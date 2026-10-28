/* Sound test: left/right/stereo checks, tones, sweep, noise, pan and a short synthesised music clip via Web Audio. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="sound-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#st-status'), stopBtn = $('#st-stop'), vol = $('#st-volume'), volOut = $('#st-volout');
	var vuL = $('#st-vu-l'), vuR = $('#st-vu-r');
	var ctx = null, master = null, panner = null, anL = null, anR = null, nodes = [], timer = 0, vuRaf = 0, current = null;

	var LABELS = {
		left: 'Playing on the LEFT only.', right: 'Playing on the RIGHT only.', stereo: 'Playing on BOTH channels.',
		bass: 'Bass tone, 60 Hz.', mid: 'Mid tone, 1 kHz.', treble: 'Treble tone, 8 kHz.', sweep: 'Sweeping 20 Hz to 20 kHz over 10 seconds.',
		music: 'Playing a short music clip.', noise: 'Playing white noise.', pan: 'Panning from left to right.'
	};

	function level() { return Math.pow(vol.value / 100, 2) * 0.8; }

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			master = ctx.createGain();
			master.gain.value = level();
			panner = ctx.createStereoPanner ? ctx.createStereoPanner() : null;
			var split = ctx.createChannelSplitter(2);
			anL = ctx.createAnalyser(); anR = ctx.createAnalyser();
			anL.fftSize = anR.fftSize = 256;
			var tail = panner ? master.connect(panner) : master;
			tail.connect(ctx.destination);
			tail.connect(split);
			split.connect(anL, 0);
			split.connect(anR, 1);
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function stop(silent) {
		clearTimeout(timer);
		cancelAnimationFrame(vuRaf);
		var t = ctx ? ctx.currentTime : 0;
		nodes.forEach(function (n) { try { if (n.stop) { n.stop(t + 0.05); } else { n.disconnect(); } } catch (e) { /* done */ } });
		nodes = [];
		if (panner) { panner.pan.cancelScheduledValues(t); panner.pan.setValueAtTime(0, t); }
		U.$$('[data-st]', root).forEach(function (b) { b.classList.remove('is-active'); });
		stopBtn.disabled = true;
		current = null;
		vuL.style.width = vuR.style.width = '0%';
		if (!silent) { U.status(statusEl, 'Stopped.', ''); }
	}

	function env(dur, peak) {
		var g = ctx.createGain(), t = ctx.currentTime;
		g.gain.setValueAtTime(0.0001, t);
		g.gain.exponentialRampToValueAtTime(peak || 1, t + 0.03);
		if (dur) {
			g.gain.setValueAtTime(peak || 1, t + dur - 0.05);
			g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
		}
		g.connect(master);
		nodes.push(g);
		return g;
	}

	function tone(freq, type, dur, dest) {
		var o = ctx.createOscillator();
		o.type = type || 'sine';
		o.frequency.value = freq;
		o.connect(dest);
		o.start();
		if (dur) { o.stop(ctx.currentTime + dur); }
		nodes.push(o);
		return o;
	}

	// A friendly two-tone "voice" for channel checks: a low tone with a vibrato, panned hard.
	function channel(pan, dur) {
		if (panner) { panner.pan.setValueAtTime(pan, ctx.currentTime); }
		var g = env(dur, 0.9);
		var o = tone(330, 'triangle', dur, g);
		var vib = ctx.createOscillator(); vib.frequency.value = 5;
		var vg = ctx.createGain(); vg.gain.value = 6;
		vib.connect(vg).connect(o.frequency); vib.start(); vib.stop(ctx.currentTime + dur);
		nodes.push(vib, vg);
		tone(660, 'sine', dur, env(dur, 0.25));
	}

	function sweep() {
		var dur = 10, g = env(dur, 0.7);
		var o = tone(20, 'sine', dur, g);
		o.frequency.exponentialRampToValueAtTime(20000, ctx.currentTime + dur);
		return dur;
	}

	function noise() {
		var len = ctx.sampleRate * 2, buf = ctx.createBuffer(2, len, ctx.sampleRate);
		for (var c = 0; c < 2; c++) { var d = buf.getChannelData(c); for (var i = 0; i < len; i++) { d[i] = Math.random() * 2 - 1; } }
		var src = ctx.createBufferSource(); src.buffer = buf; src.loop = true;
		src.connect(env(0, 0.35)); src.start(); nodes.push(src);
		return 8;
	}

	function pan() {
		var dur = 6;
		if (panner) {
			panner.pan.setValueAtTime(-1, ctx.currentTime);
			panner.pan.linearRampToValueAtTime(1, ctx.currentTime + dur);
		}
		tone(440, 'triangle', dur, env(dur, 0.8));
		return dur;
	}

	// 12 seconds of a simple melody + bass + hi-hat, so there is a "real" sound without an audio file.
	function music() {
		var bpm = 112, beat = 60 / bpm, t0 = ctx.currentTime + 0.05;
		var melody = [0, 4, 7, 12, 7, 4, 0, -5, 0, 4, 7, 11, 12, 7, 4, 0]; // semitones from C5
		var bass = [-24, -24, -17, -17, -19, -19, -24, -24];
		var base = 523.25;
		var g = env(0, 0.9);
		melody.forEach(function (n, i) {
			var t = t0 + i * beat * 0.5;
			var o = ctx.createOscillator(); o.type = 'triangle'; o.frequency.value = base * Math.pow(2, n / 12);
			var e = ctx.createGain(); e.gain.setValueAtTime(0.0001, t); e.gain.exponentialRampToValueAtTime(0.5, t + 0.02); e.gain.exponentialRampToValueAtTime(0.0001, t + beat * 0.45);
			o.connect(e).connect(g); o.start(t); o.stop(t + beat * 0.5); nodes.push(o, e);
		});
		bass.forEach(function (n, i) {
			var t = t0 + i * beat;
			var o = ctx.createOscillator(); o.type = 'sawtooth'; o.frequency.value = base * Math.pow(2, n / 12);
			var f = ctx.createBiquadFilter(); f.type = 'lowpass'; f.frequency.value = 400;
			var e = ctx.createGain(); e.gain.setValueAtTime(0.0001, t); e.gain.exponentialRampToValueAtTime(0.6, t + 0.02); e.gain.exponentialRampToValueAtTime(0.0001, t + beat * 0.9);
			o.connect(f).connect(e).connect(g); o.start(t); o.stop(t + beat); nodes.push(o, f, e);
		});
		var len = Math.floor(ctx.sampleRate * 0.05), hb = ctx.createBuffer(1, len, ctx.sampleRate), hd = hb.getChannelData(0);
		for (var i = 0; i < len; i++) { hd[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / len, 3); }
		for (var k = 0; k < 16; k++) {
			var s = ctx.createBufferSource(); s.buffer = hb;
			var hp = ctx.createBiquadFilter(); hp.type = 'highpass'; hp.frequency.value = 6000;
			var hg = ctx.createGain(); hg.gain.value = k % 2 ? 0.12 : 0.2;
			s.connect(hp).connect(hg).connect(g); s.start(t0 + k * beat * 0.5); nodes.push(s, hp, hg);
		}
		return 8 * beat + 0.5;
	}

	function vu() {
		vuRaf = requestAnimationFrame(vu);
		var a = new Uint8Array(anL.fftSize), b = new Uint8Array(anR.fftSize);
		anL.getByteTimeDomainData(a); anR.getByteTimeDomainData(b);
		var pl = 0, pr = 0;
		for (var i = 0; i < a.length; i++) { pl = Math.max(pl, Math.abs(a[i] - 128)); pr = Math.max(pr, Math.abs(b[i] - 128)); }
		vuL.style.width = Math.min(100, pl / 1.28) + '%';
		vuR.style.width = Math.min(100, pr / 1.28) + '%';
	}

	function play(kind, btn) {
		if (!ensure()) { return; }
		if (current === kind) { stop(); return; }
		stop(true);
		master.gain.value = level();
		var dur;
		switch (kind) {
			case 'left': channel(-1, 4); dur = 4; break;
			case 'right': channel(1, 4); dur = 4; break;
			case 'stereo': channel(0, 4); dur = 4; break;
			case 'bass': tone(60, 'sine', 4, env(4, 0.9)); dur = 4; break;
			case 'mid': tone(1000, 'sine', 3, env(3, 0.5)); dur = 3; break;
			case 'treble': tone(8000, 'sine', 3, env(3, 0.3)); dur = 3; break;
			case 'sweep': dur = sweep(); break;
			case 'noise': dur = noise(); break;
			case 'pan': dur = pan(); break;
			case 'music': dur = music(); break;
			default: return;
		}
		current = kind;
		btn.classList.add('is-active');
		stopBtn.disabled = false;
		U.status(statusEl, LABELS[kind] + ' Meters show the signal sent to each channel.', '');
		timer = setTimeout(function () { stop(true); U.status(statusEl, 'Done. Did you hear it where you expected?', 'ok'); }, dur * 1000);
		vu();
	}

	U.$$('[data-st]', root).forEach(function (btn) {
		btn.addEventListener('click', function () { play(btn.getAttribute('data-st'), btn); });
	});
	stopBtn.addEventListener('click', function () { stop(); });
	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (master) { master.gain.setTargetAtTime(level(), ctx.currentTime, 0.03); }
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && current) { stop(true); } });
}());
