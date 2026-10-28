/* Tone generator: one oscillator (sine/square/triangle/sawtooth) at an exact frequency, log slider, L/R/both routing, sweep, waveform drawing. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="tone-generator"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var hzIn = $('#tg-hz'), slider = $('#tg-slider'), noteEl = $('#tg-note'), vol = $('#tg-volume'), volOut = $('#tg-volout');
	var playBtn = $('#tg-play'), sweepBtn = $('#tg-sweep'), sweepTime = $('#tg-sweeptime'), statusEl = $('#tg-status');
	var canvas = $('#tg-canvas'), cx = canvas.getContext('2d');
	var waveSel = U.$$('[data-tg-wave]', root), chSel = U.$$('[data-tg-ch]', root);

	var MIN = 1, MAX = 22000;
	var ctx = null, osc = null, gain = null, gl = null, gr = null, merger = null;
	var wave = 'sine', ch = 0, playing = false, sweeping = false, sweepRaf = 0, sweepEnd = 0, sweepStart = 0, sweepDur = 0;
	var NOTES = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];

	// Log slider: 0..1000 -> MIN..MAX
	function sliderToHz(v) { return Math.round(MIN * Math.pow(MAX / MIN, v / 1000) * 100) / 100; }
	function hzToSlider(hz) { return Math.round(Math.log(hz / MIN) / Math.log(MAX / MIN) * 1000); }

	function hz() { var v = parseFloat(hzIn.value); return isFinite(v) ? Math.min(MAX, Math.max(MIN, v)) : 440; }

	function noteName(f) {
		if (f < 16) { return 'below musical range'; }
		var n = Math.round(12 * Math.log2(f / 440)) + 57; // C0 = 0
		var cents = Math.round(1200 * Math.log2(f / (440 * Math.pow(2, (n - 57) / 12))));
		var name = NOTES[((n % 12) + 12) % 12] + Math.floor(n / 12);
		return name + (cents ? (cents > 0 ? ' +' : ' ') + cents + ' cents' : '') + ' (' + (f >= 1000 ? (f / 1000).toFixed(f % 1000 ? 2 : 0) + ' kHz' : f + ' Hz') + ')';
	}

	function level() { return Math.pow(vol.value / 100, 2) * 0.5; }

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			merger = ctx.createChannelMerger(2);
			gain = ctx.createGain();
			gl = ctx.createGain(); gr = ctx.createGain();
			gain.gain.value = 0;
			gain.connect(gl).connect(merger, 0, 0);
			gain.connect(gr).connect(merger, 0, 1);
			merger.connect(ctx.destination);
			route();
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function route() {
		if (!gl) { return; }
		gl.gain.value = ch <= 0 ? 1 : 0;
		gr.gain.value = ch >= 0 ? 1 : 0;
	}

	function setFreq(f, fromSlider) {
		f = Math.min(MAX, Math.max(MIN, f));
		if (!fromSlider) { slider.value = hzToSlider(f); }
		hzIn.value = Number.isInteger(f) ? f : f.toFixed(2);
		noteEl.textContent = noteName(f);
		if (osc && !sweeping) { osc.frequency.setTargetAtTime(f, ctx.currentTime, 0.01); }
		draw(f);
	}

	function start() {
		if (!ensure()) { return; }
		if (osc) { return; }
		osc = ctx.createOscillator();
		osc.type = wave;
		osc.frequency.value = hz();
		osc.connect(gain);
		osc.start();
		gain.gain.cancelScheduledValues(ctx.currentTime);
		gain.gain.setValueAtTime(0.0001, ctx.currentTime);
		gain.gain.exponentialRampToValueAtTime(Math.max(level(), 0.0001), ctx.currentTime + 0.05);
		playing = true;
		playBtn.textContent = 'Stop';
		playBtn.classList.add('is-on');
		U.status(statusEl, 'Playing ' + wave + ' wave at ' + hzIn.value + ' Hz on ' + (ch < 0 ? 'the left' : ch > 0 ? 'the right' : 'both channels') + '.', 'ok');
	}

	function stop() {
		if (!osc) { return; }
		var o = osc, t = ctx.currentTime;
		gain.gain.cancelScheduledValues(t);
		gain.gain.setValueAtTime(Math.max(gain.gain.value, 0.0001), t);
		gain.gain.exponentialRampToValueAtTime(0.0001, t + 0.05);
		o.stop(t + 0.08);
		osc = null;
		playing = false;
		playBtn.textContent = 'Play';
		playBtn.classList.remove('is-on');
		if (sweeping) { endSweep(); }
		U.status(statusEl, 'Stopped.', '');
	}

	function endSweep() {
		sweeping = false;
		cancelAnimationFrame(sweepRaf);
		sweepBtn.textContent = 'Sweep 20 Hz → 20 kHz';
		sweepBtn.classList.remove('is-on');
	}

	function sweep() {
		if (sweeping) { stop(); return; }
		if (!osc) { setFreq(20); start(); if (!osc) { return; } }
		sweeping = true;
		sweepDur = Number(sweepTime.value);
		sweepStart = ctx.currentTime;
		sweepEnd = sweepStart + sweepDur;
		osc.frequency.cancelScheduledValues(sweepStart);
		osc.frequency.setValueAtTime(20, sweepStart);
		osc.frequency.exponentialRampToValueAtTime(20000, sweepEnd);
		sweepBtn.textContent = 'Stop sweep';
		sweepBtn.classList.add('is-on');
		U.status(statusEl, 'Sweeping from 20 Hz to 20 kHz over ' + sweepDur + ' seconds.', 'ok');
		(function tick() {
			var p = (ctx.currentTime - sweepStart) / sweepDur;
			if (p >= 1) { setFreq(20000); stop(); return; }
			var f = Math.round(20 * Math.pow(1000, p));
			slider.value = hzToSlider(f);
			hzIn.value = f;
			noteEl.textContent = noteName(f);
			draw(f);
			sweepRaf = requestAnimationFrame(tick);
		}());
	}

	function draw(f) {
		var w = canvas.width, h = canvas.height, mid = h / 2, amp = h * 0.38;
		var cycles = Math.min(12, Math.max(2, Math.round(Math.log10(f) * 2)));
		cx.clearRect(0, 0, w, h);
		cx.strokeStyle = getComputedStyle(root).getPropertyValue('--brand').trim() || '#0f766e';
		cx.lineWidth = 2;
		cx.beginPath();
		for (var x = 0; x <= w; x++) {
			var p = (x / w) * cycles, ph = p - Math.floor(p), y;
			if (wave === 'sine') { y = Math.sin(p * Math.PI * 2); }
			else if (wave === 'square') { y = ph < 0.5 ? 1 : -1; }
			else if (wave === 'triangle') { y = 1 - 4 * Math.abs(ph - 0.5); }
			else { y = 2 * ph - 1; }
			if (x === 0) { cx.moveTo(x, mid - y * amp); } else { cx.lineTo(x, mid - y * amp); }
		}
		cx.stroke();
	}

	hzIn.addEventListener('input', function () { var v = parseFloat(hzIn.value); if (isFinite(v) && v >= MIN && v <= MAX) { if (sweeping) { endSweep(); } setFreq(v); } });
	hzIn.addEventListener('change', function () { setFreq(hz()); });
	slider.addEventListener('input', function () { if (sweeping) { endSweep(); } setFreq(sliderToHz(Number(slider.value)), true); });
	U.$$('[data-tg-step]', root).forEach(function (b) { b.addEventListener('click', function () { if (sweeping) { endSweep(); } setFreq(Math.round(hz()) + Number(b.getAttribute('data-tg-step'))); }); });
	U.$$('[data-tg-hz]', root).forEach(function (b) { b.addEventListener('click', function () { if (sweeping) { endSweep(); } setFreq(Number(b.getAttribute('data-tg-hz'))); if (!playing) { start(); } }); });
	waveSel.forEach(function (b) {
		b.addEventListener('click', function () {
			wave = b.getAttribute('data-tg-wave');
			waveSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			if (osc) { osc.type = wave; }
			draw(hz());
		});
	});
	chSel.forEach(function (b) {
		b.addEventListener('click', function () {
			ch = Number(b.getAttribute('data-tg-ch'));
			chSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			route();
		});
	});
	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (gain && playing) { gain.gain.setTargetAtTime(Math.max(level(), 0.0001), ctx.currentTime, 0.02); }
	});
	playBtn.addEventListener('click', function () { if (playing) { stop(); } else { start(); } });
	sweepBtn.addEventListener('click', sweep);
	document.addEventListener('visibilitychange', function () { if (document.hidden && playing) { stop(); } });

	setFreq(440);
}());
