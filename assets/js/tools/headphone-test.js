/* Headphone test: hard left / centre / right routing via a channel merger, L->R pan, bass tones and sweep, polarity (phase) check, full sweep. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="headphone-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#hp-status'), stopBtn = $('#hp-stop'), vol = $('#hp-volume'), volOut = $('#hp-volout');
	var vuL = $('#hp-vu-l'), vuR = $('#hp-vu-r');
	var ctx = null, master = null, merger = null, anL = null, anR = null, nodes = [], timer = 0, vuRaf = 0, current = null;

	var LABELS = {
		left: 'Playing in the LEFT ear only.', centre: 'Playing in BOTH ears: it should sound centred, inside your head.', right: 'Playing in the RIGHT ear only.',
		pan: 'Moving from left to right and back.', b30: 'Bass tone, 30 Hz.', b50: 'Bass tone, 50 Hz.', b80: 'Bass tone, 80 Hz.', b120: 'Bass tone, 120 Hz.',
		bsweep: 'Bass sweep from 20 Hz up to 200 Hz.', inphase: 'In phase: the sound should be focused in the centre.', outphase: 'Out of phase: the sound should feel wide and hard to place.',
		sweep: 'Full sweep from 20 Hz to 20 kHz over 12 seconds.'
	};

	function level() { return Math.pow(vol.value / 100, 2) * 0.8; }

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			merger = ctx.createChannelMerger(2);
			master = ctx.createGain();
			master.gain.value = level();
			merger.connect(master);
			master.connect(ctx.destination);
			var split = ctx.createChannelSplitter(2);
			anL = ctx.createAnalyser(); anR = ctx.createAnalyser();
			anL.fftSize = anR.fftSize = 256;
			master.connect(split);
			split.connect(anL, 0);
			split.connect(anR, 1);
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	// Send a mono node to the left and right channels with separate gains (negative = inverted polarity).
	function route(src, l, r) {
		var gl = ctx.createGain(), gr = ctx.createGain();
		gl.gain.value = l;
		gr.gain.value = r;
		src.connect(gl).connect(merger, 0, 0);
		src.connect(gr).connect(merger, 0, 1);
		nodes.push(gl, gr);
		return { l: gl, r: gr };
	}

	function env(dur, peak) {
		var g = ctx.createGain(), t = ctx.currentTime;
		g.gain.setValueAtTime(0.0001, t);
		g.gain.exponentialRampToValueAtTime(peak, t + 0.05);
		g.gain.setValueAtTime(peak, t + dur - 0.08);
		g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
		nodes.push(g);
		return g;
	}

	function osc(freq, type, dur, dest) {
		var o = ctx.createOscillator();
		o.type = type;
		o.frequency.value = freq;
		o.connect(dest);
		o.start();
		o.stop(ctx.currentTime + dur);
		nodes.push(o);
		return o;
	}

	// Voice-like tone with vibrato, easy to place in space.
	function voice(dur, dest) {
		var o = osc(330, 'triangle', dur, dest);
		var vib = ctx.createOscillator(), vg = ctx.createGain();
		vib.frequency.value = 5;
		vg.gain.value = 6;
		vib.connect(vg).connect(o.frequency);
		vib.start();
		vib.stop(ctx.currentTime + dur);
		nodes.push(vib, vg);
		var e2 = ctx.createGain();
		e2.gain.value = 0.25;
		e2.connect(dest);
		nodes.push(e2);
		osc(660, 'sine', dur, e2);
	}

	function noise(dur) {
		var len = ctx.sampleRate * 2, buf = ctx.createBuffer(1, len, ctx.sampleRate), d = buf.getChannelData(0), b = 0;
		// Brown-ish noise: easier on the ears than white noise and rich in the frequencies where polarity is audible.
		for (var i = 0; i < len; i++) { b = (b + 0.02 * (Math.random() * 2 - 1)) / 1.02; d[i] = b * 3.5; }
		var src = ctx.createBufferSource();
		src.buffer = buf;
		src.loop = true;
		src.start();
		src.stop(ctx.currentTime + dur);
		nodes.push(src);
		return src;
	}

	function stop(silent) {
		clearTimeout(timer);
		cancelAnimationFrame(vuRaf);
		var t = ctx ? ctx.currentTime : 0;
		nodes.forEach(function (n) { try { if (n.stop) { n.stop(t + 0.05); } else { n.disconnect(); } } catch (e) { /* already stopped */ } });
		nodes = [];
		U.$$('[data-hp]', root).forEach(function (b) { b.classList.remove('is-active'); });
		stopBtn.disabled = true;
		current = null;
		vuL.style.width = vuR.style.width = '0%';
		if (!silent) { U.status(statusEl, 'Stopped.', ''); }
	}

	function vu() {
		vuRaf = requestAnimationFrame(vu);
		var a = new Uint8Array(anL.fftSize), b = new Uint8Array(anR.fftSize), pl = 0, pr = 0;
		anL.getByteTimeDomainData(a);
		anR.getByteTimeDomainData(b);
		for (var i = 0; i < a.length; i++) { pl = Math.max(pl, Math.abs(a[i] - 128)); pr = Math.max(pr, Math.abs(b[i] - 128)); }
		vuL.style.width = Math.min(100, pl / 1.28) + '%';
		vuR.style.width = Math.min(100, pr / 1.28) + '%';
	}

	function bass(freq) { var d = 4; route(osc(freq, 'sine', d, env(d, 0.9)), 1, 1); return d; }

	function play(kind, btn) {
		if (!ensure()) { return; }
		if (current === kind) { stop(); return; }
		stop(true);
		master.gain.value = level();
		var dur = 4, g, r, o, t = ctx.currentTime;
		switch (kind) {
			case 'left': g = env(dur, 0.9); voice(dur, g); route(g, 1, 0); break;
			case 'right': g = env(dur, 0.9); voice(dur, g); route(g, 0, 1); break;
			case 'centre': g = env(dur, 0.9); voice(dur, g); route(g, 0.7, 0.7); break;
			case 'pan':
				dur = 8; g = env(dur, 0.9); voice(dur, g); r = route(g, 1, 0);
				// Equal-power-ish pan: left fades out while right fades in, then back.
				r.l.gain.setValueAtTime(1, t); r.l.gain.linearRampToValueAtTime(0, t + dur / 2); r.l.gain.linearRampToValueAtTime(1, t + dur);
				r.r.gain.setValueAtTime(0, t); r.r.gain.linearRampToValueAtTime(1, t + dur / 2); r.r.gain.linearRampToValueAtTime(0, t + dur);
				break;
			case 'b30': dur = bass(30); break;
			case 'b50': dur = bass(50); break;
			case 'b80': dur = bass(80); break;
			case 'b120': dur = bass(120); break;
			case 'bsweep':
				dur = 10; o = osc(20, 'sine', dur, env(dur, 0.9));
				o.frequency.exponentialRampToValueAtTime(200, t + dur);
				route(o, 1, 1);
				break;
			case 'inphase': dur = 6; g = env(dur, 0.7); noise(dur).connect(g); route(g, 0.8, 0.8); break;
			case 'outphase': dur = 6; g = env(dur, 0.7); noise(dur).connect(g); route(g, 0.8, -0.8); break;
			case 'sweep':
				dur = 12; o = osc(20, 'sine', dur, env(dur, 0.6));
				o.frequency.exponentialRampToValueAtTime(20000, t + dur);
				route(o, 0.8, 0.8);
				break;
			default: return;
		}
		current = kind;
		btn.classList.add('is-active');
		stopBtn.disabled = false;
		U.status(statusEl, LABELS[kind], '');
		timer = setTimeout(function () { stop(true); U.status(statusEl, 'Done. Did it sound the way the label says?', 'ok'); }, dur * 1000 + 100);
		vu();
	}

	U.$$('[data-hp]', root).forEach(function (btn) {
		btn.addEventListener('click', function () { play(btn.getAttribute('data-hp'), btn); });
	});
	stopBtn.addEventListener('click', function () { stop(); });
	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (master) { master.gain.setTargetAtTime(level(), ctx.currentTime, 0.03); }
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && current) { stop(true); } });
}());
