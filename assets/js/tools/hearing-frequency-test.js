/* Hearing frequency test: stepped sweep from 8 kHz up in 1 kHz steps (optionally 500 Hz), the user presses "I can hear it" while the tone plays; the result is the highest audible frequency, compared with typical ranges by age. Also a free-play mode for any frequency. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="hearing-frequency-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#hf-start'), hearBtn = $('#hf-hear'), noBtn = $('#hf-no'), stopBtn = $('#hf-stop'), againBtn = $('#hf-again');
	var vol = $('#hf-volume'), volOut = $('#hf-volout'), stepSel = $('#hf-step'), statusEl = $('#hf-status');
	var freqEl = $('#hf-freq'), meter = $('#hf-meter'), meterLabel = $('#hf-meterlabel'), result = $('#hf-result'), resHz = $('#hf-reshz'), resAge = $('#hf-resage'), resNote = $('#hf-resnote');
	var tickBtns = U.$$('[data-hf-hz]', root), chBtns = U.$$('[data-hf-ch]', root);
	var AGES = [[20000, 'under 20'], [17000, '20s'], [15000, '30s'], [12000, '40s'], [10000, '50s'], [8000, '60s or over']];
	var START = 8000, END = 20000, TONE_MS = 2500, GAP_MS = 600;

	var ctx = null, osc = null, gain = null, gl = null, gr = null, merger = null;
	var running = false, freq = START, step = 1000, highest = 0, timer = 0, ch = 0, playing = false, raf = 0, toneStart = 0;

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

	function fmtHz(f) { return f >= 1000 ? (f / 1000).toFixed(f % 1000 ? 1 : 0) + ' kHz' : f + ' Hz'; }

	function play(f, ms) {
		if (!ensure()) { return; }
		silence();
		osc = ctx.createOscillator();
		osc.type = 'sine';
		osc.frequency.value = f;
		osc.connect(gain);
		var t = ctx.currentTime;
		osc.start(t);
		gain.gain.cancelScheduledValues(t);
		gain.gain.setValueAtTime(0.0001, t);
		gain.gain.exponentialRampToValueAtTime(Math.max(level(), 0.0001), t + 0.05);
		if (ms) {
			gain.gain.setValueAtTime(Math.max(level(), 0.0001), t + ms / 1000 - 0.05);
			gain.gain.exponentialRampToValueAtTime(0.0001, t + ms / 1000);
			osc.stop(t + ms / 1000 + 0.02);
		}
		playing = true;
		toneStart = performance.now();
		freqEl.textContent = fmtHz(f);
		cancelAnimationFrame(raf);
		(function tick() {
			if (!playing) { return; }
			var p = ms ? Math.min(1, (performance.now() - toneStart) / ms) : 1;
			meter.style.width = Math.round(p * 100) + '%';
			raf = requestAnimationFrame(tick);
		}());
	}

	function silence() {
		if (!osc) { return; }
		var o = osc, t = ctx.currentTime;
		gain.gain.cancelScheduledValues(t);
		gain.gain.setValueAtTime(Math.max(gain.gain.value, 0.0001), t);
		gain.gain.exponentialRampToValueAtTime(0.0001, t + 0.05);
		try { o.stop(t + 0.08); } catch (e) { /* already stopped */ }
		osc = null;
		playing = false;
		meter.style.width = '0%';
	}

	function ageText(f) {
		for (var i = 0; i < AGES.length; i++) { if (f >= AGES[i][0]) { return AGES[i][1]; } }
		return 'over 60';
	}

	function finish(reason) {
		running = false;
		clearTimeout(timer);
		silence();
		hearBtn.disabled = noBtn.disabled = stopBtn.disabled = true;
		startBtn.disabled = false;
		againBtn.hidden = false;
		tickBtns.forEach(function (b) { b.disabled = false; });
		freqEl.textContent = '-';
		meterLabel.textContent = 'Test finished';
		if (!highest) {
			resHz.textContent = 'below ' + fmtHz(START);
			resAge.textContent = '-';
			resNote.textContent = 'You did not hear the first tone. Check the volume and that your headphones play high tones (try the 8 kHz button on the tone generator), then try again.';
			result.hidden = false;
			U.status(statusEl, 'No tone was heard. Check your headphones and volume, then try again.', 'bad');
			return;
		}
		resHz.textContent = fmtHz(highest) + (highest >= END ? ' or higher' : '');
		resAge.textContent = 'typical for people ' + ageText(highest);
		resNote.textContent = reason === 'stopped' ? 'The test was stopped early, so the real limit may be higher.' : highest >= END ? 'That is the top of the test range and of human hearing.' : 'The next tone, ' + fmtHz(Math.min(END, highest + step)) + ', was not heard. Headphones, volume and background noise all affect this number.';
		result.hidden = false;
		tickBtns.forEach(function (b) { b.classList.toggle('is-heard', Number(b.getAttribute('data-hf-hz')) <= highest); });
		U.status(statusEl, 'Result: highest tone heard ' + fmtHz(highest) + '.', 'ok');
	}

	function next() {
		if (!running) { return; }
		if (freq > END) { finish('end'); return; }
		meterLabel.textContent = 'Playing ' + fmtHz(freq) + '. Press "I can hear it" if you hear a tone.';
		play(freq, TONE_MS);
		hearBtn.disabled = noBtn.disabled = false;
		tickBtns.forEach(function (b) { b.classList.toggle('is-now', Number(b.getAttribute('data-hf-hz')) === freq); });
		clearTimeout(timer);
		timer = setTimeout(function () {
			// Not heard within the tone: play it once more, then give up on this frequency.
			meterLabel.textContent = 'Silence. Not heard? Press "I can\'t hear it", or wait for a repeat.';
			timer = setTimeout(function () { play(freq, TONE_MS); timer = setTimeout(function () { notHeard(); }, TONE_MS + GAP_MS); }, GAP_MS);
		}, TONE_MS + GAP_MS);
	}

	function heard() {
		if (!running || !playing) { return; }
		highest = freq;
		clearTimeout(timer);
		silence();
		tickBtns.forEach(function (b) { if (Number(b.getAttribute('data-hf-hz')) === freq) { b.classList.add('is-heard'); b.classList.remove('is-now'); } });
		U.status(statusEl, 'Heard ' + fmtHz(freq) + '. Next tone coming up.', 'ok');
		freq += step;
		timer = setTimeout(next, GAP_MS);
	}

	function notHeard() {
		if (!running) { return; }
		clearTimeout(timer);
		finish('not-heard');
	}

	function start() {
		if (!ensure()) { return; }
		running = true;
		highest = 0;
		step = Number(stepSel.value);
		freq = START;
		result.hidden = true;
		againBtn.hidden = true;
		startBtn.disabled = true;
		stopBtn.disabled = false;
		tickBtns.forEach(function (b) { b.classList.remove('is-heard', 'is-now'); b.disabled = true; });
		U.status(statusEl, 'Test running. Each tone plays for 2.5 seconds; press "I can hear it" as soon as you hear it.', '');
		next();
	}

	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (gain && playing) { gain.gain.setTargetAtTime(Math.max(level(), 0.0001), ctx.currentTime, 0.02); }
	});
	startBtn.addEventListener('click', start);
	againBtn.addEventListener('click', start);
	hearBtn.addEventListener('click', heard);
	noBtn.addEventListener('click', notHeard);
	stopBtn.addEventListener('click', function () { finish('stopped'); });
	// Free play: tap any frequency to hear it for two seconds outside the test.
	tickBtns.forEach(function (b) {
		b.addEventListener('click', function () {
			if (running) { return; }
			var f = Number(b.getAttribute('data-hf-hz'));
			play(f, 2000);
			U.status(statusEl, 'Playing ' + fmtHz(f) + ' for two seconds.', '');
		});
	});
	chBtns.forEach(function (b) {
		b.addEventListener('click', function () {
			ch = Number(b.getAttribute('data-hf-ch'));
			chBtns.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			route();
		});
	});
	document.addEventListener('keydown', function (e) {
		if (!running || e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') { return; }
		if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); heard(); }
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { finish('stopped'); } });
}());
