/* Voice recorder: MediaRecorder with pause / resume, a live level meter and scrolling waveform, and a list of takes kept in memory.
   Each take plays in an <audio> element and downloads as the browser's own format (WebM / MP4) or as 16-bit WAV, decoded with Web Audio. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="voice-recorder"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var recBtn = $('#vr-rec'), pauseBtn = $('#vr-pause'), stopBtn = $('#vr-stop'), timeEl = $('#vr-time'), devSel = $('#vr-device');
	var canvas = $('#vr-wave'), g = canvas.getContext('2d'), meter = $('#vr-meter'), list = $('#vr-list'), statusEl = $('#vr-status'), empty = $('#vr-empty');
	var ns = $('#vr-ns'), ec = $('#vr-ec');
	var dpr = Math.min(2, window.devicePixelRatio || 1);
	var ctx = null, stream = null, an = null, src = null, rec = null, chunks = [], raf = 0, takes = 0;
	var elapsed = 0, segStart = 0, history = [];
	var css = getComputedStyle(root);

	function fmtTime(ms) {
		var s = Math.floor(ms / 1000), m = Math.floor(s / 60);
		return m + ':' + ('0' + (s % 60)).slice(-2) + '.' + Math.floor((ms % 1000) / 100);
	}
	function now() { return elapsed + (rec && rec.state === 'recording' ? performance.now() - segStart : 0); }

	function fit() {
		var w = canvas.clientWidth || 600, h = canvas.clientHeight || 120;
		canvas.width = Math.round(w * dpr);
		canvas.height = Math.round(h * dpr);
	}

	function draw() {
		var w = canvas.width, h = canvas.height, buf = new Float32Array(an.fftSize);
		an.getFloatTimeDomainData(buf);
		var peak = 0, sum = 0;
		for (var i = 0; i < buf.length; i++) { var v = Math.abs(buf[i]); sum += buf[i] * buf[i]; if (v > peak) { peak = v; } }
		var rms = Math.sqrt(sum / buf.length), db = rms > 0 ? 20 * Math.log10(rms) : -100;
		meter.style.width = Math.max(0, Math.min(100, (db + 60) / 60 * 100)) + '%';
		if (rec && rec.state === 'recording') {
			history.push(peak);
			var cols = Math.floor(w / (3 * dpr));
			if (history.length > cols) { history.splice(0, history.length - cols); }
			timeEl.textContent = fmtTime(now());
		}
		g.clearRect(0, 0, w, h);
		g.fillStyle = css.getPropertyValue('--brand').trim() || '#0f766e';
		var mid = h / 2;
		history.forEach(function (p, i) {
			var bh = Math.max(1 * dpr, Math.min(1, p * 1.4) * (h - 4));
			g.fillRect(i * 3 * dpr, mid - bh / 2, 2 * dpr, bh);
		});
		raf = requestAnimationFrame(draw);
	}

	function listDevices() {
		if (!navigator.mediaDevices.enumerateDevices) { return; }
		navigator.mediaDevices.enumerateDevices().then(function (devs) {
			var mics = devs.filter(function (d) { return d.kind === 'audioinput'; }), cur = devSel.value;
			devSel.innerHTML = '';
			var def = document.createElement('option');
			def.value = '';
			def.textContent = 'Default microphone';
			devSel.appendChild(def);
			mics.forEach(function (d, i) {
				if (!d.deviceId || d.deviceId === 'default') { return; }
				var o = document.createElement('option');
				o.value = d.deviceId;
				o.textContent = d.label || 'Microphone ' + (i + 1);
				devSel.appendChild(o);
			});
			devSel.value = cur;
			devSel.hidden = devSel.options.length < 2;
		});
	}

	function openMic() {
		var a = { echoCancellation: ec.checked, noiseSuppression: ns.checked, autoGainControl: ns.checked };
		if (devSel.value) { a.deviceId = { exact: devSel.value }; }
		return navigator.mediaDevices.getUserMedia({ audio: a, video: false }).then(function (s) {
			if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
			stream = s;
			if (src) { src.disconnect(); }
			src = ctx.createMediaStreamSource(s);
			an = ctx.createAnalyser();
			an.fftSize = 1024;
			src.connect(an);
			cancelAnimationFrame(raf);
			fit();
			draw();
			listDevices();
		});
	}

	function pickType() {
		var types = ['audio/webm;codecs=opus', 'audio/mp4', 'audio/webm', 'audio/ogg;codecs=opus'];
		return types.filter(function (t) { return MediaRecorder.isTypeSupported && MediaRecorder.isTypeSupported(t); })[0];
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) { U.status(statusEl, U.mediaError({ name: '' }, 'microphone'), 'bad'); return; }
		if (typeof MediaRecorder === 'undefined') { U.status(statusEl, 'This browser cannot record audio. Update it, or try Chrome, Edge, Firefox or Safari 14.1+.', 'bad'); return; }
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!ctx) { ctx = new AC(); }
		if (ctx.state === 'suspended') { ctx.resume(); }
		recBtn.disabled = true;
		U.status(statusEl, 'Waiting for microphone permission...', '');
		openMic().then(function () {
			var type = pickType();
			chunks = [];
			try { rec = new MediaRecorder(stream, type ? { mimeType: type } : undefined); } catch (e) { rec = new MediaRecorder(stream); }
			rec.ondataavailable = function (e) { if (e.data && e.data.size) { chunks.push(e.data); } };
			rec.onstop = function () { save(new Blob(chunks, { type: rec.mimeType || type || 'audio/webm' }), elapsed); };
			elapsed = 0;
			history = [];
			segStart = performance.now();
			rec.start(1000);
			recBtn.disabled = false;
			setUi('recording');
			U.status(statusEl, 'Recording. Speak normally, about a hand\'s width from the microphone.', '');
		}).catch(function (err) {
			recBtn.disabled = false;
			U.status(statusEl, U.mediaError(err, 'microphone'), 'bad');
		});
	}

	function setUi(state) {
		root.classList.toggle('is-recording', state === 'recording');
		root.classList.toggle('is-paused', state === 'paused');
		recBtn.hidden = state !== 'idle';
		pauseBtn.hidden = stopBtn.hidden = state === 'idle';
		pauseBtn.textContent = state === 'paused' ? 'Resume' : 'Pause';
		devSel.disabled = ns.disabled = ec.disabled = state !== 'idle';
	}

	function pause() {
		if (!rec) { return; }
		if (rec.state === 'recording') {
			if (!rec.pause) { return; }
			rec.pause();
			elapsed += performance.now() - segStart;
			setUi('paused');
			U.status(statusEl, 'Paused. Press Resume to carry on in the same recording.', '');
		} else if (rec.state === 'paused') {
			rec.resume();
			segStart = performance.now();
			setUi('recording');
			U.status(statusEl, 'Recording again.', '');
		}
	}

	function stop() {
		if (!rec || rec.state === 'inactive') { return; }
		if (rec.state === 'recording') { elapsed += performance.now() - segStart; }
		rec.stop();
		setUi('idle');
	}

	function ext(type) { return /mp4/.test(type) ? 'm4a' : /ogg/.test(type) ? 'ogg' : 'webm'; }

	function save(blob, ms) {
		if (!blob.size) { U.status(statusEl, 'Nothing was recorded. Check the microphone and try again.', 'bad'); return; }
		takes++;
		var url = URL.createObjectURL(blob), name = 'Recording ' + takes, file = 'voice-recording-' + takes;
		var li = document.createElement('li'), head = document.createElement('div'), title = document.createElement('strong'), meta = document.createElement('span');
		var audio = document.createElement('audio'), row = document.createElement('div');
		var dl = document.createElement('a'), wav = document.createElement('button'), del = document.createElement('button');
		li.className = 'vr-take';
		head.className = 'vr-take-head';
		title.textContent = name;
		meta.textContent = fmtTime(ms).replace(/\.\d$/, '') + ' · ' + (blob.size / 1024 < 1024 ? Math.round(blob.size / 1024) + ' KB' : U.fmt(blob.size / 1048576, 1) + ' MB') + ' · ' + ext(blob.type).toUpperCase();
		head.appendChild(title);
		head.appendChild(meta);
		audio.controls = true;
		audio.preload = 'metadata';
		audio.src = url;
		row.className = 'btn-row';
		dl.className = 'btn btn-sm';
		dl.href = url;
		dl.download = file + '.' + ext(blob.type);
		dl.textContent = 'Download ' + ext(blob.type).toUpperCase();
		wav.type = 'button';
		wav.className = 'btn btn-sm';
		wav.textContent = 'Download WAV';
		wav.addEventListener('click', function () { toWav(blob, file, wav); });
		del.type = 'button';
		del.className = 'btn btn-sm vr-del';
		del.textContent = 'Delete';
		del.addEventListener('click', function () {
			URL.revokeObjectURL(url);
			li.remove();
			empty.hidden = !!list.children.length;
			U.status(statusEl, name + ' deleted.', '');
		});
		row.appendChild(dl);
		row.appendChild(wav);
		row.appendChild(del);
		li.appendChild(head);
		li.appendChild(audio);
		li.appendChild(row);
		list.insertBefore(li, list.firstChild);
		empty.hidden = true;
		timeEl.textContent = fmtTime(0);
		U.status(statusEl, name + ' saved below. It stays in this tab until you close it, so download anything you want to keep.', 'ok');
	}

	// Decode the recording and write a 16-bit PCM WAV file.
	function toWav(blob, file, btn) {
		btn.disabled = true;
		btn.textContent = 'Converting...';
		var fr = new FileReader();
		fr.onload = function () {
			ctx.decodeAudioData(fr.result.slice(0), function (buf) {
				var ch = Math.min(2, buf.numberOfChannels), n = buf.length, rate = buf.sampleRate;
				var out = new DataView(new ArrayBuffer(44 + n * ch * 2)), p = 0;
				function str(s) { for (var i = 0; i < s.length; i++) { out.setUint8(p++, s.charCodeAt(i)); } }
				function u32(v) { out.setUint32(p, v, true); p += 4; }
				function u16(v) { out.setUint16(p, v, true); p += 2; }
				str('RIFF'); u32(36 + n * ch * 2); str('WAVE'); str('fmt '); u32(16); u16(1); u16(ch); u32(rate); u32(rate * ch * 2); u16(ch * 2); u16(16); str('data'); u32(n * ch * 2);
				var data = [];
				for (var c = 0; c < ch; c++) { data.push(buf.getChannelData(c)); }
				for (var i = 0; i < n; i++) {
					for (c = 0; c < ch; c++) {
						var s = Math.max(-1, Math.min(1, data[c][i]));
						out.setInt16(p, s < 0 ? s * 0x8000 : s * 0x7fff, true);
						p += 2;
					}
				}
				var url = URL.createObjectURL(new Blob([out], { type: 'audio/wav' })), a = document.createElement('a');
				a.href = url;
				a.download = file + '.wav';
				document.body.appendChild(a);
				a.click();
				a.remove();
				setTimeout(function () { URL.revokeObjectURL(url); }, 4000);
				btn.disabled = false;
				btn.textContent = 'Download WAV';
			}, function () {
				btn.disabled = false;
				btn.textContent = 'Download WAV';
				U.status(statusEl, 'This browser could not convert the recording to WAV. Use the other download button.', 'bad');
			});
		};
		fr.readAsArrayBuffer(blob);
	}

	recBtn.addEventListener('click', start);
	pauseBtn.addEventListener('click', pause);
	stopBtn.addEventListener('click', stop);
	document.addEventListener('keydown', function (e) {
		if (e.code !== 'Space' || /INPUT|SELECT|TEXTAREA|BUTTON|AUDIO/.test(document.activeElement.tagName)) { return; }
		if (!root.contains(document.activeElement) && document.activeElement !== document.body) { return; }
		e.preventDefault();
		if (rec && rec.state !== 'inactive') { pause(); } else { start(); }
	});
	window.addEventListener('resize', function () { if (an) { fit(); } });
	window.addEventListener('pagehide', function () {
		if (rec && rec.state !== 'inactive') { rec.stop(); }
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
	});
	if (typeof MediaRecorder !== 'undefined' && MediaRecorder.prototype && !MediaRecorder.prototype.pause) { pauseBtn.remove(); }
	setUi('idle');
	timeEl.textContent = fmtTime(0);
	fit();
}());
