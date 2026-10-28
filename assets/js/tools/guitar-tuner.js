/* Guitar tuner: getUserMedia -> AnalyserNode time-domain buffer -> normalised autocorrelation pitch -> nearest note, cents, needle; instrument presets, A4 reference, reference tones. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="guitar-tuner"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#gt-start'), statusEl = $('#gt-status'), noteEl = $('#gt-note'), octEl = $('#gt-oct'), centsEl = $('#gt-cents'), hzEl = $('#gt-hz');
	var needle = $('#gt-needle'), dial = $('#gt-dial'), strings = $('#gt-strings'), devSel = $('#gt-device'), a4In = $('#gt-a4'), targetEl = $('#gt-target'), levelEl = $('#gt-level');
	var instSel = U.$$('[data-gt-inst]', root);
	var NAMES = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
	var INST = {
		chromatic: [],
		guitar: [['E', 2], ['A', 2], ['D', 3], ['G', 3], ['B', 3], ['E', 4]],
		bass: [['E', 1], ['A', 1], ['D', 2], ['G', 2]],
		ukulele: [['G', 4], ['C', 4], ['E', 4], ['A', 4]],
		dropd: [['D', 2], ['A', 2], ['D', 3], ['G', 3], ['B', 3], ['E', 4]]
	};
	var inst = 'guitar', a4 = 440, ctx = null, stream = null, src = null, an = null, buf = null, raf = 0, osc = null, oscGain = null, oscTimer = 0;
	var hist = [], inTuneSince = 0;

	function midiToHz(m) { return a4 * Math.pow(2, (m - 69) / 12); }
	function nameToMidi(n, o) { return NAMES.indexOf(n) + (o + 1) * 12; }

	function buildStrings() {
		strings.innerHTML = '';
		var list = INST[inst];
		strings.hidden = !list.length;
		list.forEach(function (s) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'gt-string';
			b.setAttribute('data-midi', nameToMidi(s[0], s[1]));
			b.innerHTML = '<strong>' + s[0] + '</strong><small>' + s[1] + '</small>';
			b.title = 'Play reference ' + s[0] + s[1];
			b.addEventListener('click', function () { playRef(Number(b.getAttribute('data-midi')), b); });
			strings.appendChild(b);
		});
	}

	function playRef(midi, btn) {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { return; }
		if (!ctx) { ctx = new AC(); }
		if (ctx.state === 'suspended') { ctx.resume(); }
		stopRef();
		osc = ctx.createOscillator();
		oscGain = ctx.createGain();
		osc.type = 'triangle';
		osc.frequency.value = midiToHz(midi);
		oscGain.gain.setValueAtTime(0.0001, ctx.currentTime);
		oscGain.gain.exponentialRampToValueAtTime(0.25, ctx.currentTime + 0.02);
		oscGain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 2.2);
		osc.connect(oscGain).connect(ctx.destination);
		osc.start();
		osc.stop(ctx.currentTime + 2.3);
		U.$$('.gt-string', root).forEach(function (x) { x.classList.toggle('is-playing', x === btn); });
		oscTimer = setTimeout(function () { U.$$('.gt-string', root).forEach(function (x) { x.classList.remove('is-playing'); }); }, 2300);
	}
	function stopRef() {
		clearTimeout(oscTimer);
		if (osc) { try { osc.stop(); } catch (e) { /* already stopped */ } osc.disconnect(); osc = null; }
	}

	/* Normalised autocorrelation (NSDF-style): returns Hz or -1. */
	function detect(b, rate) {
		var n = b.length, rms = 0, i;
		for (i = 0; i < n; i++) { rms += b[i] * b[i]; }
		rms = Math.sqrt(rms / n);
		levelEl.style.width = Math.min(100, rms * 400) + '%';
		if (rms < 0.01) { return -1; }
		// Correlate from lag 2 so the first negative dip is always seen (otherwise notes near the top of the range read an octave low); report only 27-1200 Hz.
		var minLag = 2, maxLag = Math.floor(rate / 27), minReport = Math.floor(rate / 1200);
		var best = -1, bestVal = 0, nsdf = new Float32Array(maxLag + 1);
		for (var lag = minLag; lag <= maxLag; lag++) {
			var ac = 0, m = 0;
			for (i = 0; i < n - lag; i++) { ac += b[i] * b[i + lag]; m += b[i] * b[i] + b[i + lag] * b[i + lag]; }
			nsdf[lag] = m ? 2 * ac / m : 0;
		}
		// First clear peak above the threshold, which avoids octave errors from later, higher peaks.
		var thr = 0.9, started = false, maxPeak = 0;
		for (lag = minLag + 1; lag < maxLag; lag++) {
			if (nsdf[lag] < 0) { started = true; continue; }
			if (!started) { continue; }
			if (nsdf[lag] > nsdf[lag - 1] && nsdf[lag] >= nsdf[lag + 1] && nsdf[lag] > maxPeak) { maxPeak = nsdf[lag]; }
		}
		if (maxPeak < 0.5) { return -1; }
		thr = maxPeak * thr;
		started = false;
		for (lag = minLag + 1; lag < maxLag; lag++) {
			if (nsdf[lag] < 0) { started = true; continue; }
			if (!started) { continue; }
			if (nsdf[lag] > nsdf[lag - 1] && nsdf[lag] >= nsdf[lag + 1] && nsdf[lag] >= thr) { best = lag; bestVal = nsdf[lag]; break; }
		}
		if (best < minReport || bestVal < 0.5) { return -1; }
		// Parabolic interpolation around the peak.
		var y0 = nsdf[best - 1], y1 = nsdf[best], y2 = nsdf[best + 1], d = (y0 - y2) / (2 * (y0 - 2 * y1 + y2) || 1);
		return rate / (best + (isFinite(d) ? d : 0));
	}

	function show(hz) {
		if (hz < 0) {
			hist = [];
			noteEl.textContent = '--';
			octEl.textContent = '';
			centsEl.textContent = '';
			hzEl.textContent = '-';
			needle.style.transform = 'rotate(0deg)';
			dial.classList.remove('is-flat', 'is-sharp', 'is-ok');
			targetEl.textContent = INST[inst].length ? 'Play one string at a time.' : 'Play or sing a note.';
			return;
		}
		hist.push(hz);
		if (hist.length > 5) { hist.shift(); }
		var s = hist.slice().sort(function (a, b) { return a - b; }), med = s[s.length >> 1];
		var midi = Math.round(69 + 12 * Math.log2(med / a4)), list = INST[inst], target = midi;
		if (list.length) {
			// Snap to the nearest string so the needle tells you which way to turn the peg.
			var bestD = 1e9;
			list.forEach(function (st) { var m = nameToMidi(st[0], st[1]), dd = Math.abs(12 * Math.log2(med / midiToHz(m))); if (dd < bestD) { bestD = dd; target = m; } });
			if (bestD > 6) { target = midi; }
		}
		var cents = 1200 * Math.log2(med / midiToHz(target));
		cents = Math.max(-50, Math.min(50, cents));
		noteEl.textContent = NAMES[target % 12];
		octEl.textContent = Math.floor(target / 12) - 1;
		centsEl.textContent = (cents > 0 ? '+' : '') + Math.round(cents) + ' cents';
		hzEl.textContent = U.fmt(med, 1) + ' Hz';
		needle.style.transform = 'rotate(' + (cents * 1.6) + 'deg)';
		var ok = Math.abs(cents) <= 5;
		dial.classList.toggle('is-ok', ok);
		dial.classList.toggle('is-flat', !ok && cents < 0);
		dial.classList.toggle('is-sharp', !ok && cents > 0);
		U.$$('.gt-string', root).forEach(function (b) { b.classList.toggle('is-active', Number(b.getAttribute('data-midi')) === target); });
		var tgtHz = midiToHz(target);
		if (ok) {
			if (!inTuneSince) { inTuneSince = performance.now(); }
			targetEl.textContent = 'In tune (' + U.fmt(tgtHz, 1) + ' Hz).';
		} else {
			inTuneSince = 0;
			targetEl.textContent = (cents < 0 ? 'Flat: tighten the string' : 'Sharp: loosen the string') + ' to reach ' + NAMES[target % 12] + (Math.floor(target / 12) - 1) + ' (' + U.fmt(tgtHz, 1) + ' Hz).';
		}
	}

	function loop() {
		raf = requestAnimationFrame(loop);
		an.getFloatTimeDomainData(buf);
		show(detect(buf, ctx.sampleRate));
	}

	function release() {
		cancelAnimationFrame(raf);
		if (src) { src.disconnect(); }
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = src = null;
		levelEl.style.width = '0%';
	}

	function listDevices() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) { return; }
		navigator.mediaDevices.enumerateDevices().then(function (list) {
			var cur = devSel.value;
			devSel.innerHTML = '<option value="">Default microphone</option>';
			list.filter(function (d) { return d.kind === 'audioinput' && d.deviceId; }).forEach(function (d, i) {
				var o = document.createElement('option');
				o.value = d.deviceId;
				o.textContent = d.label || 'Microphone ' + (i + 1);
				devSel.appendChild(o);
			});
			devSel.value = cur;
		});
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) { U.status(statusEl, U.mediaError({ name: '' }, 'microphone'), 'bad'); return; }
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return; }
		release();
		startBtn.disabled = true;
		U.status(statusEl, 'Waiting for microphone permission...', '');
		if (!ctx) { ctx = new AC(); }
		if (ctx.state === 'suspended') { ctx.resume(); }
		var a = { echoCancellation: false, noiseSuppression: false, autoGainControl: false };
		if (devSel.value) { a.deviceId = { exact: devSel.value }; }
		navigator.mediaDevices.getUserMedia({ audio: a, video: false }).then(function (s) {
			stream = s;
			src = ctx.createMediaStreamSource(s);
			an = ctx.createAnalyser();
			an.fftSize = 4096;
			an.smoothingTimeConstant = 0;
			buf = new Float32Array(an.fftSize);
			src.connect(an);
			startBtn.disabled = false;
			startBtn.textContent = 'Stop tuner';
			startBtn.classList.remove('btn-primary');
			root.classList.add('is-listening');
			U.status(statusEl, 'Listening. Play one string and watch the needle.', 'ok');
			listDevices();
			loop();
		}).catch(function (err) {
			startBtn.disabled = false;
			U.status(statusEl, U.mediaError(err, 'microphone'), 'bad');
		});
	}

	function stop() {
		release();
		root.classList.remove('is-listening');
		startBtn.textContent = 'Start tuner';
		startBtn.classList.add('btn-primary');
		show(-1);
		U.status(statusEl, 'Tuner stopped.', '');
	}

	startBtn.addEventListener('click', function () { if (stream) { stop(); } else { start(); } });
	devSel.addEventListener('change', function () { if (stream) { start(); } });
	a4In.addEventListener('change', function () { var v = Number(a4In.value); a4 = v >= 400 && v <= 480 ? v : 440; a4In.value = a4; });
	instSel.forEach(function (b) {
		b.addEventListener('click', function () {
			inst = b.getAttribute('data-gt-inst');
			instSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			buildStrings();
			show(-1);
		});
	});
	window.addEventListener('pagehide', release);
	document.addEventListener('visibilitychange', function () { if (document.hidden && stream) { stop(); } });
	buildStrings();
	show(-1);
}());
