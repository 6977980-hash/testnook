/* Hearing frequency test: stepped sweep from 8 kHz up in 1 kHz steps (optionally 500 Hz), the user presses "I can hear it" while the tone plays. About 1 in 5 trials is silent (catch trial): a press there is flagged and counted. The sweep ends with a confirm pass (top tone, the step below and one silent trial in random order). Ear: left, both, right, or each ear in turn. The result is the highest confirmed frequency, compared with typical ranges by age. Also a free-play mode for any frequency. */
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
	var START = 8000, END = 20000, TONE_MS = 2500, GAP_MS = 600, CATCH_P = 0.2;

	var ctx = null, osc = null, gain = null, gl = null, gr = null, merger = null;
	var running = false, freq = START, step = 1000, highest = 0, timer = 0, ch = 0, playing = false, raf = 0, toneStart = 0;
	var phase = 'sweep', trial = null, lastCatch = false, falseAlarms = 0, catches = 0, ears = [0], earIdx = 0, results = [], confirmQ = [], confirmHeard = {};

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

	// ch: -1 left, 0 both, 1 right, 2 each ear in turn (one side at a time during the test, both for free play).
	function route() {
		if (!gl) { return; }
		var c = running ? ears[earIdx] : ch === 2 ? 0 : ch;
		gl.gain.value = c <= 0 ? 1 : 0;
		gr.gain.value = c >= 0 ? 1 : 0;
		root.setAttribute('data-hf-route', c < 0 ? 'L' : c > 0 ? 'R' : 'LR');
	}

	function fmtHz(f) { return f >= 1000 ? (f / 1000).toFixed(f % 1000 ? 1 : 0) + ' kHz' : f + ' Hz'; }

	// muted = a silent catch trial: same display and timing, no sound.
	function play(f, ms, muted) {
		if (!ensure()) { return; }
		silence();
		route();
		playing = true;
		toneStart = performance.now();
		freqEl.textContent = fmtHz(f);
		meterAnim(ms);
		if (muted) { root.setAttribute('data-hf-tone', 'silent'); return; }
		root.setAttribute('data-hf-tone', String(f));
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
	}

	function meterAnim(ms) {
		cancelAnimationFrame(raf);
		(function tick() {
			if (!playing) { return; }
			var p = ms ? Math.min(1, (performance.now() - toneStart) / ms) : 1;
			meter.style.width = Math.round(p * 100) + '%';
			raf = requestAnimationFrame(tick);
		}());
	}

	function silence() {
		playing = false;
		meter.style.width = '0%';
		root.removeAttribute('data-hf-tone');
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

	function earName(c) { return c < 0 ? 'Left' : c > 0 ? 'Right' : 'Both ears'; }
	function earPrefix() { return ears.length > 1 ? earName(ears[earIdx]) + ' ear: ' : ''; }
	function markNow(f) { tickBtns.forEach(function (b) { b.classList.toggle('is-now', Number(b.getAttribute('data-hf-hz')) === f); }); }
	function shuffle(a) { for (var i = a.length - 1; i > 0; i--) { var j = Math.floor(Math.random() * (i + 1)), t = a[i]; a[i] = a[j]; a[j] = t; } return a; }

	/* One trial: a tone, or a silent catch trial that looks the same. cb(yes) gets the answer for tones. */
	function present(kind, f, cb, noRepeat) {
		trial = { kind: kind, f: f, cb: cb, done: false };
		if (kind === 'catch') { catches++; }
		lastCatch = kind === 'catch';
		meterLabel.textContent = earPrefix() + (phase === 'confirm' ? 'Check: press "I can hear it" only if you are sure a tone is playing.' : 'Playing ' + fmtHz(f) + '. Press "I can hear it" if you hear a tone.');
		play(f, TONE_MS, kind === 'catch');
		hearBtn.disabled = noBtn.disabled = false;
		markNow(f);
		clearTimeout(timer);
		timer = setTimeout(function () {
			if (kind === 'catch' || noRepeat) { answer(false); return; }
			// Not heard within the tone: play it once more, then give up on this frequency.
			meterLabel.textContent = earPrefix() + 'Silence. Not heard? Press "I can\'t hear it", or wait for a repeat.';
			timer = setTimeout(function () { play(f, TONE_MS); timer = setTimeout(function () { answer(false); }, TONE_MS + GAP_MS); }, GAP_MS);
		}, TONE_MS + GAP_MS);
	}

	function answer(yes) {
		if (!running || !trial || trial.done) { return; }
		var t = trial;
		t.done = true;
		clearTimeout(timer);
		silence();
		if (t.kind === 'catch') {
			if (yes) {
				falseAlarms++;
				U.status(statusEl, 'No tone was playing; press only when you are sure.', 'bad');
			}
			timer = setTimeout(function () { if (phase === 'sweep') { present('tone', t.f, sweepAnswer); } else { confirmNext(); } }, GAP_MS);
			return;
		}
		t.cb(yes);
	}

	function sweepAnswer(yes) {
		if (!yes) { endSweep(); return; }
		highest = freq;
		tickBtns.forEach(function (b) { if (Number(b.getAttribute('data-hf-hz')) === freq) { b.classList.add('is-heard'); b.classList.remove('is-now'); } });
		U.status(statusEl, earPrefix() + 'Heard ' + fmtHz(freq) + '. Next tone coming up.', 'ok');
		freq += step;
		timer = setTimeout(next, GAP_MS);
	}

	function next() {
		if (!running) { return; }
		if (freq > END) { endSweep(); return; }
		// About 1 in 5 trials after the first heard tone is silent, never two in a row.
		var isCatch = highest > 0 && !lastCatch && Math.random() < CATCH_P;
		present(isCatch ? 'catch' : 'tone', freq, sweepAnswer);
	}

	/* Confirm pass: replay the top tone and the next step down, plus one silent trial, in random order. */
	function endSweep() {
		clearTimeout(timer);
		silence();
		if (!highest) { earDone(); return; }
		phase = 'confirm';
		confirmHeard = {};
		var q = [{ kind: 'tone', f: highest, key: 'top' }, { kind: 'catch', f: highest, key: 'catch' }];
		if (highest - step >= START) {
			q.push({ kind: 'tone', f: highest - step, key: 'low' });
			q[1].f = Math.random() < 0.5 ? highest : highest - step;
		}
		confirmQ = shuffle(q);
		U.status(statusEl, earPrefix() + 'Confirming ' + fmtHz(highest) + ': a few more short checks, one of them may be silent. Answer each one.', '');
		meterLabel.textContent = earPrefix() + 'Confirm pass coming up...';
		timer = setTimeout(confirmNext, GAP_MS * 2);
	}

	function confirmNext() {
		if (!running) { return; }
		if (!confirmQ.length) { earDone(); return; }
		var c = confirmQ.shift();
		present(c.kind, c.f, function (yes) { confirmHeard[c.key] = yes; timer = setTimeout(confirmNext, GAP_MS); }, true);
	}

	function record(conf) {
		var hz = highest;
		if (!conf) {
			if (!highest) { conf = 'none'; }
			else if (confirmHeard.top) { conf = 'confirmed'; }
			else if (confirmHeard.low) { conf = 'lowered'; hz = highest - step; }
			else { conf = 'unconfirmed'; }
		}
		results.push({ ear: ears[earIdx], hz: hz, sweep: highest, conf: conf, fa: falseAlarms, catches: catches });
	}

	function resetEar() {
		highest = 0; freq = START; phase = 'sweep'; falseAlarms = 0; catches = 0; lastCatch = false; confirmHeard = {}; confirmQ = []; trial = null;
		tickBtns.forEach(function (b) { b.classList.remove('is-heard', 'is-now'); });
	}

	function earDone() {
		record();
		earIdx++;
		if (earIdx < ears.length) {
			resetEar();
			hearBtn.disabled = noBtn.disabled = true;
			U.status(statusEl, earName(ears[earIdx - 1]) + ' ear done. Now the ' + earName(ears[earIdx]).toLowerCase() + ' ear, from 8 kHz again.', 'ok');
			meterLabel.textContent = earPrefix() + 'Starting in a moment...';
			timer = setTimeout(next, 1500);
			return;
		}
		finish('end');
	}

	function noteFor(r) {
		var n;
		if (r.conf === 'none') { return 'You did not hear the first tone. Check the volume and that your headphones play high tones (try the 8 kHz button on the tone generator), then try again.'; }
		if (r.conf === 'stopped') { n = 'The test was stopped early, so the real limit may be higher.'; }
		else if (r.conf === 'confirmed') { n = 'Confirmed: you heard ' + fmtHz(r.hz) + ' again on the replay.' + (r.hz >= END ? ' That is the top of the test range and of human hearing.' : ' The next tone, ' + fmtHz(Math.min(END, r.hz + step)) + ', was not heard.'); }
		else if (r.conf === 'lowered') { n = 'On the replay you did not hear ' + fmtHz(r.sweep) + ' but did hear ' + fmtHz(r.hz) + ', so the result is ' + fmtHz(r.hz) + '.'; }
		else { n = 'Not confirmed: you did not hear ' + fmtHz(r.sweep) + ' or the step below it on the replay. Re-run at the same volume.'; }
		if (r.fa) { n += ' You pressed during ' + r.fa + ' of ' + r.catches + ' silent checks, so the result may be too high.'; }
		return n;
	}

	function finish(reason) {
		var wasRunning = running;
		running = false;
		clearTimeout(timer);
		silence();
		hearBtn.disabled = noBtn.disabled = stopBtn.disabled = true;
		startBtn.disabled = false;
		againBtn.hidden = false;
		tickBtns.forEach(function (b) { b.disabled = false; b.classList.remove('is-now'); });
		chBtns.forEach(function (b) { b.disabled = false; });
		freqEl.textContent = '-';
		meterLabel.textContent = 'Test finished';
		if (wasRunning && reason === 'stopped' && earIdx < ears.length && highest) { record('stopped'); }
		route();
		var heard = results.filter(function (r) { return r.hz > 0; });
		if (!heard.length) {
			resHz.textContent = 'below ' + fmtHz(START);
			resAge.textContent = '-';
			resNote.textContent = results.length ? noteFor(results[0]) : 'The test was stopped before any tone was heard.';
			result.hidden = false;
			U.status(statusEl, 'No tone was heard. Check your headphones and volume, then try again.', 'bad');
			return;
		}
		var fmtR = function (r) { return r.hz > 0 ? fmtHz(r.hz) + (r.hz >= END ? ' or higher' : '') : 'below ' + fmtHz(START); };
		var best = Math.max.apply(null, heard.map(function (r) { return r.hz; }));
		if (results.length > 1) {
			resHz.textContent = results.map(function (r) { return earName(r.ear) + ' ' + fmtR(r); }).join(' · ');
			resAge.textContent = 'better ear typical for people ' + ageText(best);
			var notes = results.map(function (r) { return earName(r.ear) + ': ' + noteFor(r); });
			var gap = Math.abs(results[0].hz - results[1].hz);
			if (results.length === 2 && gap >= 3000) { notes.push('Your ears differ by ' + fmtHz(gap) + '. Swap the earphones and repeat; if the gap stays with the same ear, mention it to a doctor or audiologist.'); }
			resNote.textContent = notes.join(' ');
		} else {
			resHz.textContent = fmtR(results[0]);
			resAge.textContent = results[0].hz > 0 ? 'typical for people ' + ageText(results[0].hz) : '-';
			resNote.textContent = noteFor(results[0]);
		}
		result.hidden = false;
		var last = results[results.length - 1];
		tickBtns.forEach(function (b) { b.classList.toggle('is-heard', Number(b.getAttribute('data-hf-hz')) <= last.hz); });
		U.status(statusEl, 'Result: highest tone heard ' + resHz.textContent + '.', 'ok');
	}

	function start() {
		if (!ensure()) { return; }
		clearTimeout(timer);
		running = true;
		results = [];
		ears = ch === 2 ? [-1, 1] : [ch];
		earIdx = 0;
		step = Number(stepSel.value);
		resetEar();
		result.hidden = true;
		againBtn.hidden = true;
		startBtn.disabled = true;
		stopBtn.disabled = false;
		tickBtns.forEach(function (b) { b.disabled = true; });
		chBtns.forEach(function (b) { b.disabled = true; });
		U.status(statusEl, earPrefix() + 'Test running. Each tone plays for 2.5 seconds; press "I can hear it" as soon as you hear it. Some checks are silent on purpose.', '');
		next();
	}

	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (gain && playing) { gain.gain.setTargetAtTime(Math.max(level(), 0.0001), ctx.currentTime, 0.02); }
	});
	startBtn.addEventListener('click', start);
	againBtn.addEventListener('click', start);
	hearBtn.addEventListener('click', function () { if (playing) { answer(true); } });
	noBtn.addEventListener('click', function () { answer(false); });
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
		if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); if (playing) { answer(true); } }
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { finish('stopped'); } });
}());
