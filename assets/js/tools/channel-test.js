/* Channel test: left / right / centre routing, panning, ping-pong notes, a balance control and in-phase vs out-of-phase noise.
   Shared by stereo-test and mono-test. After each sound the page asks where it was heard and explains the answer:
   left-only sound in both ears means the output is mono, and out-of-phase noise that nearly vanishes means the channels are summed. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="stereo-test"], [data-tool="mono-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#ch-status'), vol = $('#ch-volume'), volOut = $('#ch-volout'), bal = $('#ch-balance'), balOut = $('#ch-balout');
	var spkL = $('#ch-l'), spkR = $('#ch-r'), askSide = $('#ch-ask-side'), askPhase = $('#ch-ask-phase');
	var ctx = null, master = null, merger = null, anL = null, anR = null, nodes = [], timer = 0, raf = 0, last = '', noiseBuf = null;

	var LABELS = {
		left: 'Playing in the LEFT channel only.', right: 'Playing in the RIGHT channel only.', centre: 'Playing in both channels equally: it should come from the middle.',
		pan: 'Moving from left to right and back.', pingpong: 'Notes bouncing left, right, left, right.', balance: 'Centre tone: move the balance slider until it sounds exactly in the middle.',
		inphase: 'In phase: the noise should sound focused in the centre.', outphase: 'Out of phase: the noise should sound wide and hard to place. In mono it nearly disappears.'
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
			anL = ctx.createAnalyser();
			anR = ctx.createAnalyser();
			anL.fftSize = anR.fftSize = 256;
			master.connect(split);
			split.connect(anL, 0);
			split.connect(anR, 1);
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function route(srcNode, l, r) {
		var gl = ctx.createGain(), gr = ctx.createGain();
		gl.gain.value = l;
		gr.gain.value = r;
		srcNode.connect(gl).connect(merger, 0, 0);
		srcNode.connect(gr).connect(merger, 0, 1);
		nodes.push(gl, gr);
		return { l: gl, r: gr };
	}

	function env(t0, dur, peak) {
		var g = ctx.createGain();
		g.gain.setValueAtTime(0.0001, t0);
		g.gain.exponentialRampToValueAtTime(peak, t0 + 0.03);
		g.gain.setValueAtTime(peak, t0 + Math.max(0.04, dur - 0.08));
		g.gain.exponentialRampToValueAtTime(0.0001, t0 + dur);
		nodes.push(g);
		return g;
	}

	// A bright two-note chime repeated, easy to place in space on speakers.
	function chime(dur, dest) {
		var t = ctx.currentTime;
		for (var s = 0; s < dur - 0.2; s += 0.5) {
			[523.25, 783.99].forEach(function (f, i) {
				var o = ctx.createOscillator(), g = env(t + s + i * 0.12, 0.36, 0.5);
				o.type = 'triangle';
				o.frequency.value = f;
				o.connect(g).connect(dest);
				o.start(t + s + i * 0.12);
				o.stop(t + s + i * 0.12 + 0.4);
				nodes.push(o);
			});
		}
	}

	function noise() {
		if (!noiseBuf) {
			var n = ctx.sampleRate * 2, d, last0 = 0;
			noiseBuf = ctx.createBuffer(1, n, ctx.sampleRate);
			d = noiseBuf.getChannelData(0);
			for (var i = 0; i < n; i++) { last0 = (last0 + 0.04 * (Math.random() * 2 - 1)) / 1.04; d[i] = last0 * 3.2; } // soft brown-ish noise
		}
		var src = ctx.createBufferSource();
		src.buffer = noiseBuf;
		src.loop = true;
		nodes.push(src);
		return src;
	}

	function stopAll() {
		clearTimeout(timer);
		nodes.forEach(function (n) { try { if (n.stop) { n.stop(); } n.disconnect(); } catch (e) { /* already stopped */ } });
		nodes = [];
		U.$$('[data-ch]', root).forEach(function (b) { b.setAttribute('aria-pressed', 'false'); });
	}

	function play(kind, btn) {
		if (!ensure()) { return; }
		stopAll();
		last = kind;
		btn.setAttribute('aria-pressed', 'true');
		var dur = 3, bus = ctx.createGain();
		nodes.push(bus);
		if (kind === 'left') { route(bus, 1, 0); chime(dur, bus); }
		else if (kind === 'right') { route(bus, 0, 1); chime(dur, bus); }
		else if (kind === 'centre') { route(bus, 0.75, 0.75); chime(dur, bus); }
		else if (kind === 'balance') {
			dur = 8;
			var b = Number(bal.value) / 100, gains = route(bus, Math.min(1, 1 - b) * 0.75, Math.min(1, 1 + b) * 0.75);
			bal.oninput = function () { var v = Number(bal.value) / 100; gains.l.gain.value = Math.min(1, 1 - v) * 0.75; gains.r.gain.value = Math.min(1, 1 + v) * 0.75; showBal(); };
			chime(dur, bus);
		} else if (kind === 'pan') {
			dur = 6;
			var gp = route(bus, 1, 0), t = ctx.currentTime, steps = 60;
			for (var i = 0; i <= steps; i++) {
				var x = i / steps, p = x < 0.5 ? x * 2 : 2 - x * 2; // 0 -> 1 -> 0
				gp.l.gain.setValueAtTime(Math.cos(p * Math.PI / 2), t + x * dur);
				gp.r.gain.setValueAtTime(Math.sin(p * Math.PI / 2), t + x * dur);
			}
			chime(dur, bus);
		} else if (kind === 'pingpong') {
			dur = 4;
			var t2 = ctx.currentTime, notes = [523.25, 659.25, 783.99, 1046.5];
			for (var k = 0; k < 8; k++) {
				var side = ctx.createGain(), o = ctx.createOscillator(), g = env(t2 + k * 0.45, 0.4, 0.55);
				route(side, k % 2 ? 0 : 1, k % 2 ? 1 : 0);
				o.type = 'triangle';
				o.frequency.value = notes[k % 4];
				o.connect(g).connect(side);
				o.start(t2 + k * 0.45);
				o.stop(t2 + k * 0.45 + 0.45);
				nodes.push(side, o);
			}
		} else if (kind === 'inphase' || kind === 'outphase') {
			dur = 4;
			var src = noise(), ge = env(ctx.currentTime, dur, 0.6);
			src.connect(ge);
			route(ge, 0.8, kind === 'outphase' ? -0.8 : 0.8);
			src.start();
		}
		U.status(statusEl, LABELS[kind], '');
		askSide.hidden = !(kind === 'left' || kind === 'right');
		askPhase.hidden = kind !== 'outphase';
		timer = setTimeout(function () { stopAll(); if (askSide.hidden && askPhase.hidden) { U.status(statusEl, 'Done. Pick another sound.', ''); } else { U.status(statusEl, 'Where did you hear it? Pick an answer below.', ''); } }, dur * 1000 + 100);
		meters();
	}

	function meters() {
		cancelAnimationFrame(raf);
		var buf = new Uint8Array(anL.fftSize);
		function rms(an) {
			an.getByteTimeDomainData(buf);
			var s = 0;
			for (var i = 0; i < buf.length; i++) { var v = (buf[i] - 128) / 128; s += v * v; }
			return Math.sqrt(s / buf.length);
		}
		function f() {
			var l = rms(anL), r = rms(anR);
			spkL.style.setProperty('--lv', Math.min(1, l * 6));
			spkR.style.setProperty('--lv', Math.min(1, r * 6));
			spkL.classList.toggle('is-on', l > 0.005);
			spkR.classList.toggle('is-on', r > 0.005);
			if (nodes.length) { raf = requestAnimationFrame(f); } else { spkL.classList.remove('is-on'); spkR.classList.remove('is-on'); }
		}
		f();
	}

	var ANSWERS = {
		one: ['ok', 'Stereo is working: that sound came from one side only, so your left and right channels are separate. Test the other side too.'],
		both: ['bad', 'You heard a one-sided sound on both sides, so your audio is mono. Either Mono Audio is turned on in the accessibility settings, or the device has a single speaker (most phones in portrait, many Bluetooth speakers and some laptops). See how to switch it below.'],
		wrong: ['bad', 'The channels are swapped: left plays on the right. Check that headphones are the right way round (L and R markings), and look for a "swap left and right" setting in your sound driver.'],
		none: ['bad', 'That side is silent. Check the balance slider in your system sound settings, plug the cable in fully, and try another pair of headphones or speakers to see whether the fault follows the device.'],
		loud: ['ok', 'The out-of-phase noise was clearly audible, so your output keeps the two channels separate: stereo. On speakers it can sound thin or "inside out", which is normal.'],
		quiet: ['bad', 'The noise almost vanished, which happens when the two channels are added together: your output is mono. The two halves of the signal are opposite and cancel. Turn Mono Audio off if you want stereo.']
	};
	U.$$('[data-ans]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			var a = ANSWERS[b.getAttribute('data-ans')];
			askSide.hidden = askPhase.hidden = true;
			U.status(statusEl, a[1], a[0]);
		});
	});

	function showBal() {
		var v = Number(bal.value);
		balOut.textContent = v === 0 ? 'Centre' : (v < 0 ? 'L ' + -v : 'R ' + v);
	}
	if (bal) { showBal(); bal.addEventListener('input', showBal); }

	U.$$('[data-ch]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			if (b.getAttribute('aria-pressed') === 'true') { stopAll(); U.status(statusEl, 'Stopped.', ''); return; }
			play(b.getAttribute('data-ch'), b);
		});
	});
	$('#ch-stop').addEventListener('click', function () { stopAll(); U.status(statusEl, 'Stopped.', ''); });
	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (master) { master.gain.setTargetAtTime(level(), ctx.currentTime, 0.02); }
	});
	window.addEventListener('pagehide', stopAll);
}());
