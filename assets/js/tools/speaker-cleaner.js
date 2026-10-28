/* Speaker cleaner: low tone (165 Hz), pulse or sweep through Web Audio, with a soft start. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="speaker-cleaner"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var goBtn = $('#sc-go'), label = $('#sc-label'), timeEl = $('#sc-time'), bar = $('#sc-progress');
	var durSel = $('#sc-duration'), vol = $('#sc-volume'), volOut = $('#sc-volout'), statusEl = $('#sc-status');
	var modeBtns = U.$$('[data-sc-mode]', root);

	var FREQ = 165;
	var mode = 'tone';
	var ctx = null, osc = null, gain = null, lfo = null, lfoGain = null;
	var running = false, startedAt = 0, total = 60, raf = 0;

	function fmtTime(s) {
		s = Math.max(0, Math.ceil(s));
		return Math.floor(s / 60) + ':' + ('0' + (s % 60)).slice(-2);
	}

	function level() { return Math.pow(vol.value / 100, 1.6); }

	function showIdle() {
		total = Number(durSel.value);
		timeEl.textContent = fmtTime(total);
		bar.style.width = '0%';
	}

	function start() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio. Try Chrome, Safari, Edge or Firefox.', 'bad'); return; }
		if (!ctx) { ctx = new AC(); }
		if (ctx.state === 'suspended') { ctx.resume(); }

		var t = ctx.currentTime;
		gain = ctx.createGain();
		gain.gain.setValueAtTime(0.0001, t);
		gain.gain.exponentialRampToValueAtTime(Math.max(0.0001, level()), t + 2);
		gain.connect(ctx.destination);

		osc = ctx.createOscillator();
		osc.type = 'sine';
		osc.frequency.setValueAtTime(FREQ, t);

		if (mode === 'pulse') {
			// Square LFO on a gain node: the tone switches on and off twice a second.
			var gate = ctx.createGain();
			gate.gain.value = 0.5;
			lfo = ctx.createOscillator();
			lfo.type = 'square';
			lfo.frequency.value = 2;
			lfoGain = ctx.createGain();
			lfoGain.gain.value = 0.5;
			lfo.connect(lfoGain).connect(gate.gain);
			osc.connect(gate).connect(gain);
			lfo.start(t);
		} else if (mode === 'sweep') {
			// Glide 120 -> 300 Hz and back every 6 s.
			osc.frequency.setValueAtTime(210, t);
			lfo = ctx.createOscillator();
			lfo.type = 'triangle';
			lfo.frequency.value = 1 / 6;
			lfoGain = ctx.createGain();
			lfoGain.gain.value = 90;
			lfo.connect(lfoGain).connect(osc.frequency);
			osc.connect(gain);
			lfo.start(t);
		} else {
			osc.connect(gain);
		}
		osc.start(t);

		running = true;
		total = Number(durSel.value);
		startedAt = performance.now();
		root.classList.add('is-playing');
		label.textContent = 'Stop';
		U.status(statusEl, 'Playing ' + (mode === 'sweep' ? 'a 120-300 Hz sweep' : FREQ + ' Hz' + (mode === 'pulse' ? ' pulses' : '')) + '. Keep the speaker facing down.', '');
		tick();
	}

	function stop(done) {
		if (!running) { return; }
		running = false;
		cancelAnimationFrame(raf);
		var t = ctx.currentTime;
		try {
			gain.gain.cancelScheduledValues(t);
			gain.gain.setValueAtTime(Math.max(0.0001, gain.gain.value), t);
			gain.gain.exponentialRampToValueAtTime(0.0001, t + 0.15);
			osc.stop(t + 0.2);
			if (lfo) { lfo.stop(t + 0.2); }
		} catch (e) { /* already stopped */ }
		osc = lfo = lfoGain = null;
		root.classList.remove('is-playing');
		label.textContent = done ? 'Run again' : 'Start cleaning';
		if (done) {
			bar.style.width = '100%';
			timeEl.textContent = fmtTime(0);
			U.status(statusEl, 'Done. If the sound is still muffled, run it again or try Pulse mode.', 'ok');
		} else {
			showIdle();
			U.status(statusEl, 'Stopped.', '');
		}
	}

	function tick() {
		var elapsed = (performance.now() - startedAt) / 1000;
		var left = total - elapsed;
		timeEl.textContent = fmtTime(left);
		bar.style.width = Math.min(100, (elapsed / total) * 100) + '%';
		if (left <= 0) { stop(true); return; }
		raf = requestAnimationFrame(tick);
	}

	goBtn.addEventListener('click', function () { if (running) { stop(false); } else { start(); } });

	modeBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			mode = btn.getAttribute('data-sc-mode');
			modeBtns.forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
			if (running) { stop(false); start(); }
		});
	});

	durSel.addEventListener('change', function () { if (!running) { showIdle(); } else { total = Number(durSel.value); } });

	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (running && gain) { gain.gain.setTargetAtTime(Math.max(0.0001, level()), ctx.currentTime, 0.05); }
	});

	document.addEventListener('visibilitychange', function () {
		if (document.hidden && running) { stop(false); U.status(statusEl, 'Paused because the page was hidden. Press Start to continue.', ''); }
	});

	showIdle();
}());
