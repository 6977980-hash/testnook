/* Bass test: sine tones from 20 to 200 Hz, a free slider, up and down sweeps with an "I can't hear it" marker that reports the speaker's
   lowest audible frequency, a slow rattle sweep, and a synthesised kick drum and 808 bass. Everything fades in and out to avoid clicks. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="bass-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#bt-status'), freqEl = $('#bt-freq'), noteEl = $('#bt-note'), cone = $('#bt-cone');
	var slider = $('#bt-slider'), sliderOut = $('#bt-sliderout'), vol = $('#bt-volume'), volOut = $('#bt-volout'), markBtn = $('#bt-mark'), lowEl = $('#bt-low');
	var ctx = null, master = null, osc = null, og = null, timer = 0, raf = 0, mode = '', sweep = null, beat = 0, active = null;

	function level() { return Math.pow(vol.value / 100, 2) * 0.9; }

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			master = ctx.createGain();
			master.gain.value = level();
			master.connect(ctx.destination);
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	var NAMES = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
	function noteOf(f) {
		var n = Math.round(12 * Math.log2(f / 440)) + 57;
		return NAMES[((n % 12) + 12) % 12] + (Math.floor(n / 12));
	}
	function show(f) {
		freqEl.textContent = Math.round(f) + ' Hz';
		noteEl.textContent = f >= 16 ? 'Note ' + noteOf(f) : '';
		cone.style.animationDuration = Math.max(0.02, Math.min(0.5, 2 / f)) + 's';
	}

	function stopTone() {
		clearTimeout(timer);
		clearInterval(beat);
		cancelAnimationFrame(raf);
		if (osc) {
			var o = osc, g = og, t = ctx.currentTime;
			g.gain.cancelScheduledValues(t);
			g.gain.setValueAtTime(g.gain.value, t);
			g.gain.linearRampToValueAtTime(0, t + 0.08);
			setTimeout(function () { try { o.stop(); o.disconnect(); g.disconnect(); } catch (e) { /* stopped */ } }, 120);
		}
		osc = og = null;
		sweep = null;
		mode = '';
		markBtn.hidden = true;
		cone.classList.remove('is-on');
		if (active) { active.setAttribute('aria-pressed', 'false'); active = null; }
	}

	function tone(f) {
		osc = ctx.createOscillator();
		og = ctx.createGain();
		osc.type = 'sine';
		osc.frequency.value = f;
		og.gain.setValueAtTime(0, ctx.currentTime);
		og.gain.linearRampToValueAtTime(0.9, ctx.currentTime + 0.15);
		osc.connect(og).connect(master);
		osc.start();
		cone.classList.add('is-on');
		show(f);
	}

	function press(btn) {
		if (active) { active.setAttribute('aria-pressed', 'false'); }
		active = btn;
		if (btn) { btn.setAttribute('aria-pressed', 'true'); }
	}

	function playFixed(f, btn) {
		stopTone();
		if (!ensure()) { return; }
		mode = 'fixed';
		press(btn);
		tone(f);
		U.status(statusEl, f + ' Hz playing. ' + (f < 40 ? 'Below 40 Hz most small speakers and many headphones play almost nothing; a subwoofer should rumble.' : f < 80 ? 'Subwoofers and good headphones play this cleanly; laptop and phone speakers barely do.' : 'Most speakers can play this. Listen for buzzing or rattling.'), '');
		timer = setTimeout(stopTone, 8000);
	}

	function runSweep(from, to, secs, btn, label) {
		stopTone();
		if (!ensure()) { return; }
		mode = 'sweep';
		press(btn);
		tone(from);
		var t0 = ctx.currentTime;
		osc.frequency.setValueAtTime(from, t0);
		osc.frequency.exponentialRampToValueAtTime(to, t0 + secs);
		sweep = { from: from, to: to, secs: secs, t0: t0 };
		markBtn.hidden = false;
		markBtn.textContent = to < from ? 'I can\'t hear it any more' : 'I can hear it now';
		U.status(statusEl, label, '');
		(function f() {
			if (!sweep) { return; }
			var x = Math.min(1, (ctx.currentTime - t0) / secs);
			show(from * Math.pow(to / from, x));
			if (x >= 1) { stopTone(); U.status(statusEl, 'Sweep finished. Press it again, and use the button below the sweep to mark where the bass fades.', ''); return; }
			raf = requestAnimationFrame(f);
		}());
	}

	function current() {
		if (!sweep) { return 0; }
		var x = Math.min(1, (ctx.currentTime - sweep.t0) / sweep.secs);
		return sweep.from * Math.pow(sweep.to / sweep.from, x);
	}

	function kick(t, deep) {
		var o = ctx.createOscillator(), g = ctx.createGain(), len = deep ? 1.4 : 0.45;
		o.type = 'sine';
		o.frequency.setValueAtTime(deep ? 120 : 150, t);
		o.frequency.exponentialRampToValueAtTime(deep ? 42 : 45, t + (deep ? 0.12 : 0.1));
		g.gain.setValueAtTime(0.0001, t);
		g.gain.exponentialRampToValueAtTime(1, t + 0.005);
		g.gain.exponentialRampToValueAtTime(0.0001, t + len);
		o.connect(g).connect(master);
		o.start(t);
		o.stop(t + len + 0.05);
	}

	function drums(deep, btn) {
		stopTone();
		if (!ensure()) { return; }
		mode = 'beat';
		press(btn);
		cone.classList.add('is-on');
		show(deep ? 42 : 50);
		var step = deep ? 1.0 : 0.5, next = ctx.currentTime + 0.05, end = next + 8;
		function sched() {
			while (next < ctx.currentTime + 0.3 && next < end) { kick(next, deep); next += step; }
			if (next >= end) { clearInterval(beat); timer = setTimeout(stopTone, 1500); }
		}
		sched();
		beat = setInterval(sched, 100);
		U.status(statusEl, deep ? 'Long 808-style bass hits around 42 Hz. A good subwoofer gives a deep, clean boom that fades smoothly.' : 'Kick drum at 120 BPM. You should feel a tight punch, not a boomy rumble or a buzz.', '');
	}

	U.$$('[data-bt-f]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			if (b.getAttribute('aria-pressed') === 'true') { stopTone(); U.status(statusEl, 'Stopped.', ''); return; }
			playFixed(Number(b.getAttribute('data-bt-f')), b);
		});
	});
	U.$$('[data-bt]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			var k = b.getAttribute('data-bt');
			if (b.getAttribute('aria-pressed') === 'true') { stopTone(); U.status(statusEl, 'Stopped.', ''); return; }
			if (k === 'down') { runSweep(200, 15, 20, b, 'Sweeping down from 200 Hz to 15 Hz. Press "I can\'t hear it any more" the moment the tone fades away.'); }
			if (k === 'up') { runSweep(15, 200, 20, b, 'Sweeping up from 15 Hz. Press "I can hear it now" as soon as you hear the tone.'); }
			if (k === 'rattle') { runSweep(30, 120, 30, b, 'Slow rattle sweep from 30 to 120 Hz. Listen for buzzing from the grille, the cabinet or things around the speaker.'); }
			if (k === 'kick') { drums(false, b); }
			if (k === '808') { drums(true, b); }
			if (k === 'slider') {
				stopTone();
				if (!ensure()) { return; }
				mode = 'slider';
				press(b);
				tone(Number(slider.value));
				U.status(statusEl, 'Drag the slider to change the frequency while the tone plays.', '');
			}
		});
	});
	markBtn.addEventListener('click', function () {
		var f = Math.round(current()), m = mode;
		if (!f || m !== 'sweep') { return; }
		stopTone();
		lowEl.textContent = f + ' Hz';
		U.status(statusEl, 'Your setup plays bass down to about ' + f + ' Hz at this volume. ' + (f <= 30 ? 'That is subwoofer territory: excellent bass extension.' : f <= 50 ? 'Good: typical of bookshelf speakers, good headphones and small subwoofers.' : f <= 90 ? 'Typical of small speakers, laptops and earbuds. A subwoofer or better headphones go lower.' : 'Very limited bass, as from a phone or laptop speaker. Check the speaker is not damaged or blocked.'), 'ok');
	});
	slider.addEventListener('input', function () {
		sliderOut.textContent = slider.value + ' Hz';
		if (mode === 'slider' && osc) { osc.frequency.setTargetAtTime(Number(slider.value), ctx.currentTime, 0.03); show(Number(slider.value)); }
	});
	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (master) { master.gain.setTargetAtTime(level(), ctx.currentTime, 0.03); }
	});
	$('#bt-stop').addEventListener('click', function () { stopTone(); U.status(statusEl, 'Stopped.', ''); });
	document.addEventListener('visibilitychange', function () { if (document.hidden) { stopTone(); } });
	window.addEventListener('pagehide', stopTone);
}());
