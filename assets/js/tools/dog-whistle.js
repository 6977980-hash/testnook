/* Dog whistle: a sine tone from 4 to 22 kHz with soft edges, hold-to-whistle, short/long/double/recall patterns and a frequency sweep. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="dog-whistle"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var hzIn = $('#dw-hz'), hzOut = $('#dw-hzout'), vol = $('#dw-vol'), volOut = $('#dw-volout'), hold = $('#dw-hold'), statusEl = $('#dw-status'), wave = $('#dw-wave');
	var ctx = null, gain = null, osc = null, busy = 0, MAXHZ = 22000;
	var PATTERNS = {
		short: [[0, 0.5]],
		long: [[0, 2]],
		double: [[0, 0.3], [0.5, 0.3]],
		recall: [[0, 0.25], [0.4, 0.25], [0.8, 0.25]],
		trill: [[0, 0.12], [0.18, 0.12], [0.36, 0.12], [0.54, 0.12], [0.72, 0.12], [0.9, 0.12]]
	};

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			MAXHZ = Math.min(22000, Math.floor(ctx.sampleRate / 2 - 500));
			hzIn.max = MAXHZ;
			gain = ctx.createGain();
			gain.gain.value = 0;
			gain.connect(ctx.destination);
			osc = ctx.createOscillator();
			osc.type = 'sine';
			osc.frequency.value = hz();
			osc.connect(gain);
			osc.start();
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function hz() { return Math.min(MAXHZ, Number(hzIn.value)); }
	function level() { return Math.pow(vol.value / 100, 2) * 0.6; }

	function label() {
		var f = Number(hzIn.value);
		hzOut.textContent = (f / 1000).toFixed(1) + ' kHz';
		wave.style.setProperty('--dw-wl', Math.max(6, 60 - (f - 4000) / 18000 * 54) + 'px');
		if (osc) { osc.frequency.setTargetAtTime(hz(), ctx.currentTime, 0.01); }
		var note = f >= 17000 ? 'Most adults cannot hear this; dogs can.' : f >= 12000 ? 'Young people hear this clearly; many adults only faintly.' : 'Audible to people and dogs: a training whistle.';
		$('#dw-note').textContent = note;
	}

	// Soft 15 ms edges so the speaker does not click.
	function blast(at, dur) {
		var g = gain.gain, t = ctx.currentTime + at, a = 0.015, peak = level();
		g.setValueAtTime(0, t);
		g.linearRampToValueAtTime(peak, t + a);
		g.setValueAtTime(peak, t + dur - a);
		g.linearRampToValueAtTime(0, t + dur);
	}

	function play(name) {
		if (!ensure()) { return; }
		var list = PATTERNS[name], end = 0;
		gain.gain.cancelScheduledValues(ctx.currentTime);
		gain.gain.setValueAtTime(0, ctx.currentTime);
		list.forEach(function (b) { blast(b[0] + 0.02, b[1]); end = Math.max(end, b[0] + b[1]); });
		root.classList.add('is-on');
		clearTimeout(busy);
		busy = setTimeout(function () { root.classList.remove('is-on'); }, (end + 0.05) * 1000);
		U.status(statusEl, 'Whistle at ' + (hz() / 1000).toFixed(1) + ' kHz.', 'ok');
	}

	function sweep() {
		if (!ensure()) { return; }
		var t = ctx.currentTime + 0.02, dur = 6, peak = level();
		gain.gain.cancelScheduledValues(ctx.currentTime);
		osc.frequency.cancelScheduledValues(ctx.currentTime);
		osc.frequency.setValueAtTime(4000, t);
		osc.frequency.exponentialRampToValueAtTime(MAXHZ, t + dur);
		gain.gain.setValueAtTime(0, t);
		gain.gain.linearRampToValueAtTime(peak, t + 0.05);
		gain.gain.setValueAtTime(peak, t + dur - 0.05);
		gain.gain.linearRampToValueAtTime(0, t + dur);
		osc.frequency.setValueAtTime(hz(), t + dur + 0.01);
		root.classList.add('is-on');
		clearTimeout(busy);
		busy = setTimeout(function () { root.classList.remove('is-on'); }, dur * 1000);
		U.status(statusEl, 'Sweeping from 4 kHz to ' + (MAXHZ / 1000).toFixed(1) + ' kHz over 6 seconds. Note when the sound disappears for you.', 'ok');
	}

	function holdOn(e) {
		if (e) { e.preventDefault(); }
		if (!ensure()) { return; }
		gain.gain.cancelScheduledValues(ctx.currentTime);
		gain.gain.setTargetAtTime(level(), ctx.currentTime, 0.005);
		root.classList.add('is-on');
	}
	function holdOff() {
		if (!ctx) { return; }
		gain.gain.cancelScheduledValues(ctx.currentTime);
		gain.gain.setTargetAtTime(0, ctx.currentTime, 0.005);
		root.classList.remove('is-on');
	}

	hold.addEventListener('pointerdown', function (e) { hold.setPointerCapture(e.pointerId); holdOn(e); });
	['pointerup', 'pointercancel', 'lostpointercapture'].forEach(function (ev) { hold.addEventListener(ev, holdOff); });
	hold.addEventListener('keydown', function (e) { if ((e.key === ' ' || e.key === 'Enter') && !e.repeat) { holdOn(e); } });
	hold.addEventListener('keyup', function (e) { if (e.key === ' ' || e.key === 'Enter') { holdOff(); } });
	U.$$('[data-dw-pattern]', root).forEach(function (b) { b.addEventListener('click', function () { play(b.getAttribute('data-dw-pattern')); }); });
	U.$$('[data-dw-hz]', root).forEach(function (b) {
		b.addEventListener('click', function () { hzIn.value = b.getAttribute('data-dw-hz'); label(); });
	});
	$('#dw-sweep').addEventListener('click', sweep);
	hzIn.addEventListener('input', label);
	vol.addEventListener('input', function () { volOut.textContent = vol.value + '%'; });
	document.addEventListener('visibilitychange', function () { if (document.hidden) { holdOff(); } });
	label();
}());
