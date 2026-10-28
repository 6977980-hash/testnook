/* Mic test: getUserMedia audio, level meter (RMS dB + peak hold), waveform / spectrum view, processing toggles, and a short MediaRecorder sample with playback. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="mic-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#mc-start'), devSel = $('#mc-device'), statusEl = $('#mc-status'), canvas = $('#mc-scope'), g = canvas.getContext('2d');
	var meter = $('#mc-meter'), peakMark = $('#mc-peak'), recBtn = $('#mc-rec'), recLen = $('#mc-len'), player = $('#mc-player'), dl = $('#mc-dl');
	var out = { db: $('#mc-db'), peak: $('#mc-peakv'), rate: $('#mc-rate'), name: $('#mc-name') };
	var opts = { echoCancellation: $('#mc-ec'), noiseSuppression: $('#mc-ns'), autoGainControl: $('#mc-agc') };
	var dpr = Math.min(2, window.devicePixelRatio || 1);

	var ctx = null, stream = null, src = null, an = null, raf = 0, view = 'wave';
	var peakHold = 0, peakTime = 0, maxPeak = 0, heard = false, startedAt = 0;
	var rec = null, recTimer = 0, recUrl = '';
	var css = getComputedStyle(root);
	function colour(n) { return css.getPropertyValue(n).trim(); }

	function constraints() {
		var a = {};
		Object.keys(opts).forEach(function (k) { a[k] = opts[k].checked; });
		if (devSel.value) { a.deviceId = { exact: devSel.value }; }
		return { audio: a, video: false };
	}

	function release() {
		cancelAnimationFrame(raf);
		if (rec && rec.state === 'recording') { rec.stop(); }
		if (src) { src.disconnect(); }
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = src = null;
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
			U.status(statusEl, U.mediaError({ name: '' }, 'microphone'), 'bad');
			return;
		}
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return; }
		release();
		startBtn.disabled = true;
		U.status(statusEl, 'Waiting for microphone permission...', '');
		if (!ctx) { ctx = new AC(); }
		if (ctx.state === 'suspended') { ctx.resume(); }
		navigator.mediaDevices.getUserMedia(constraints()).then(function (s) {
			stream = s;
			src = ctx.createMediaStreamSource(s);
			an = ctx.createAnalyser();
			an.fftSize = 2048;
			an.smoothingTimeConstant = 0.6;
			src.connect(an);
			var track = s.getAudioTracks()[0], set = track.getSettings ? track.getSettings() : {};
			out.name.textContent = track.label || 'Microphone';
			out.rate.textContent = (set.sampleRate || ctx.sampleRate) / 1000 + ' kHz' + (set.channelCount ? ', ' + (set.channelCount > 1 ? 'stereo' : 'mono') : '');
			startBtn.disabled = false;
			startBtn.textContent = 'Stop microphone';
			startBtn.classList.remove('btn-primary');
			recBtn.disabled = typeof MediaRecorder === 'undefined';
			maxPeak = 0; heard = false; startedAt = performance.now(); out.peak.textContent = '-';
			U.status(statusEl, 'Listening. Say something or tap near the microphone.', '');
			track.addEventListener('ended', function () { stop('The microphone was disconnected.'); });
			listDevices(set.deviceId);
			draw();
		}).catch(function (err) {
			startBtn.disabled = false;
			U.status(statusEl, U.mediaError(err, 'microphone'), 'bad');
		});
	}

	function stop(msg) {
		release();
		startBtn.textContent = 'Start microphone';
		startBtn.classList.add('btn-primary');
		recBtn.disabled = true;
		meter.style.width = '0%';
		out.db.textContent = '-';
		g.clearRect(0, 0, canvas.width, canvas.height);
		U.status(statusEl, msg || 'Microphone stopped and released.', msg ? 'bad' : '');
	}

	function listDevices(activeId) {
		navigator.mediaDevices.enumerateDevices().then(function (list) {
			var mics = list.filter(function (d) { return d.kind === 'audioinput'; });
			devSel.innerHTML = '';
			mics.forEach(function (d, i) {
				var o = document.createElement('option');
				o.value = d.deviceId;
				o.textContent = d.label || 'Microphone ' + (i + 1);
				if (d.deviceId === activeId) { o.selected = true; }
				devSel.appendChild(o);
			});
			devSel.hidden = mics.length < 2;
		});
	}

	function draw() {
		raf = requestAnimationFrame(draw);
		var w = Math.round(canvas.clientWidth * dpr), h = Math.round(canvas.clientHeight * dpr);
		if (canvas.width !== w || canvas.height !== h) { canvas.width = w; canvas.height = h; }
		var buf = new Float32Array(an.fftSize);
		an.getFloatTimeDomainData(buf);
		var sum = 0, pk = 0;
		for (var i = 0; i < buf.length; i++) { sum += buf[i] * buf[i]; pk = Math.max(pk, Math.abs(buf[i])); }
		var rms = Math.sqrt(sum / buf.length), db = rms > 0 ? 20 * Math.log10(rms) : -100, pdb = pk > 0 ? 20 * Math.log10(pk) : -100;
		// Map -60..0 dBFS to 0..100%.
		var pct = Math.max(0, Math.min(100, (db + 60) / 60 * 100));
		meter.style.width = pct + '%';
		meter.classList.toggle('is-hot', pdb > -1);
		var now = performance.now();
		if (pk >= peakHold || now - peakTime > 1500) { peakHold = pk; peakTime = now; }
		var hp = peakHold > 0 ? Math.max(0, Math.min(100, (20 * Math.log10(peakHold) + 60) / 60 * 100)) : 0;
		peakMark.style.left = hp + '%';
		out.db.textContent = (db < -99 ? '-inf' : Math.round(db)) + ' dB';
		if (pk > maxPeak) { maxPeak = pk; out.peak.textContent = Math.round(pdb) + ' dB'; }
		if (!heard && pdb > -45) {
			heard = true;
			U.status(statusEl, 'Your microphone works: sound detected. Record a sample to hear how you sound.', 'ok');
		} else if (!heard && now - startedAt > 5000) {
			startedAt = now + 1e9;
			U.status(statusEl, 'Very little sound is reaching the page. Check that the microphone is not muted and the right one is selected.', 'bad');
		}

		g.clearRect(0, 0, w, h);
		g.fillStyle = colour('--surface-2');
		g.fillRect(0, 0, w, h);
		g.strokeStyle = g.fillStyle = colour('--brand');
		g.lineWidth = 2 * dpr;
		if (view === 'wave') {
			g.beginPath();
			for (var x = 0; x < w; x++) {
				var v = buf[Math.floor(x / w * buf.length)], y = h / 2 - v * h / 2 * 0.95;
				if (x) { g.lineTo(x, y); } else { g.moveTo(x, y); }
			}
			g.stroke();
		} else {
			var bins = new Uint8Array(an.frequencyBinCount);
			an.getByteFrequencyData(bins);
			// Log-spaced bars from ~40 Hz to ~16 kHz.
			var bars = Math.floor(w / (6 * dpr)), nyq = ctx.sampleRate / 2;
			for (var b = 0; b < bars; b++) {
				var f = 40 * Math.pow(16000 / 40, b / bars), idx = Math.min(bins.length - 1, Math.round(f / nyq * bins.length));
				var bh = bins[idx] / 255 * h;
				g.fillRect(b * 6 * dpr, h - bh, 4 * dpr, bh);
			}
		}
	}

	function record() {
		if (!stream || typeof MediaRecorder === 'undefined') { return; }
		if (rec && rec.state === 'recording') { rec.stop(); return; }
		var types = ['audio/webm;codecs=opus', 'audio/webm', 'audio/mp4', 'audio/ogg'];
		var type = types.filter(function (t) { return MediaRecorder.isTypeSupported && MediaRecorder.isTypeSupported(t); })[0];
		var chunks = [], secs = Number(recLen.value);
		try { rec = new MediaRecorder(stream, type ? { mimeType: type } : undefined); } catch (e) { U.status(statusEl, 'Recording is not supported in this browser.', 'bad'); return; }
		rec.ondataavailable = function (e) { if (e.data && e.data.size) { chunks.push(e.data); } };
		rec.onstop = function () {
			clearInterval(recTimer);
			recBtn.textContent = 'Record sample';
			recBtn.classList.remove('is-rec');
			if (!chunks.length) { return; }
			var blob = new Blob(chunks, { type: rec.mimeType || type || 'audio/webm' });
			if (recUrl) { URL.revokeObjectURL(recUrl); }
			recUrl = URL.createObjectURL(blob);
			player.src = recUrl;
			player.hidden = false;
			dl.href = recUrl;
			dl.download = 'mic-test.' + (/mp4/.test(blob.type) ? 'm4a' : /ogg/.test(blob.type) ? 'ogg' : 'webm');
			dl.hidden = false;
			var p = player.play();
			if (p && p.catch) { p.catch(function () {}); }
			U.status(statusEl, 'Playing back your recording. It stays on your device.', 'ok');
		};
		rec.start();
		var left = secs;
		recBtn.textContent = 'Stop (' + left + ' s)';
		recBtn.classList.add('is-rec');
		U.status(statusEl, 'Recording... speak normally.', '');
		recTimer = setInterval(function () {
			left--;
			if (left <= 0) { if (rec.state === 'recording') { rec.stop(); } return; }
			recBtn.textContent = 'Stop (' + left + ' s)';
		}, 1000);
	}

	startBtn.addEventListener('click', function () { if (stream) { stop(); } else { start(); } });
	devSel.addEventListener('change', function () { if (stream) { start(); } });
	Object.keys(opts).forEach(function (k) { opts[k].addEventListener('change', function () { if (stream) { start(); } }); });
	recBtn.addEventListener('click', record);
	U.$$('[data-mc-view]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			view = b.getAttribute('data-mc-view');
			U.$$('[data-mc-view]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
		});
	});
	window.addEventListener('pagehide', release);
}());
