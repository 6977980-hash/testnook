/* White noise generator: white, pink, brown, blue, violet and grey noise from looped stereo buffers, a warmth (low-pass) control, sleep timer with fade out and a live spectrum. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="white-noise-generator"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var playBtn = $('#wn-play'), vol = $('#wn-vol'), volOut = $('#wn-volout'), warm = $('#wn-warm'), warmOut = $('#wn-warmout');
	var timerSel = $('#wn-timer'), left = $('#wn-left'), statusEl = $('#wn-status'), canvas = $('#wn-canvas'), cg = canvas.getContext('2d');
	var colours = U.$$('[data-wn-colour]', root);
	var NAMES = { white: 'White', pink: 'Pink', brown: 'Brown', blue: 'Blue', violet: 'Violet', grey: 'Grey' };

	var ctx = null, master = null, lp = null, shelf = null, peak = null, analyser = null, src = null, buffers = {};
	var colour = 'white', playing = false, endAt = 0, tick = 0, raf = 0, bins = null;
	var SECONDS = 12, FADE = 0.5;

	// One channel of noise of the given colour, normalised to the same loudness (RMS).
	function channel(kind, n) {
		var out = new Float32Array(n), i, w;
		var b0 = 0, b1 = 0, b2 = 0, b3 = 0, b4 = 0, b5 = 0, b6 = 0, last = 0, prev = 0;
		for (i = 0; i < n; i++) {
			w = Math.random() * 2 - 1;
			if (kind === 'brown') {
				last = (last + 0.02 * w) / 1.02;
				out[i] = last;
			} else if (kind === 'pink' || kind === 'blue') {
				// Paul Kellet's pink filter; blue is the first difference of pink.
				b0 = 0.99886 * b0 + w * 0.0555179; b1 = 0.99332 * b1 + w * 0.0750759; b2 = 0.96900 * b2 + w * 0.1538520;
				b3 = 0.86650 * b3 + w * 0.3104856; b4 = 0.55000 * b4 + w * 0.5329522; b5 = -0.7616 * b5 - w * 0.0168980;
				var pk = b0 + b1 + b2 + b3 + b4 + b5 + b6 + w * 0.5362;
				b6 = w * 0.115926;
				out[i] = kind === 'pink' ? pk : pk - prev;
				prev = pk;
			} else if (kind === 'violet') {
				out[i] = w - prev;
				prev = w;
			} else {
				out[i] = w; // white, and grey (shaped by live filters)
			}
		}
		var sum = 0;
		for (i = 0; i < n; i++) { sum += out[i] * out[i]; }
		var k = 0.18 / Math.sqrt(sum / n);
		for (i = 0; i < n; i++) { out[i] = Math.max(-1, Math.min(1, out[i] * k)); }
		return out;
	}

	// Loop seamlessly: render a little extra and cross-fade it into the start.
	function buffer(kind) {
		if (buffers[kind]) { return buffers[kind]; }
		var rate = ctx.sampleRate, n = Math.round(rate * SECONDS), f = Math.round(rate * FADE);
		var b = ctx.createBuffer(2, n, rate);
		for (var c = 0; c < 2; c++) {
			var raw = channel(kind, n + f), data = b.getChannelData(c);
			for (var i = 0; i < n; i++) {
				if (i < f) { var t = i / f; data[i] = raw[i] * Math.sqrt(t) + raw[n + i] * Math.sqrt(1 - t); }
				else { data[i] = raw[i]; }
			}
		}
		buffers[kind] = b;
		return b;
	}

	function ensure() {
		var AC = window.AudioContext || window.webkitAudioContext;
		if (!AC) { U.status(statusEl, 'Your browser does not support Web Audio.', 'bad'); return false; }
		if (!ctx) {
			ctx = new AC();
			shelf = ctx.createBiquadFilter(); shelf.type = 'lowshelf'; shelf.frequency.value = 160;
			peak = ctx.createBiquadFilter(); peak.type = 'peaking'; peak.frequency.value = 3500; peak.Q.value = 0.8;
			lp = ctx.createBiquadFilter(); lp.type = 'lowpass'; lp.Q.value = 0.5;
			master = ctx.createGain(); master.gain.value = 0;
			analyser = ctx.createAnalyser(); analyser.fftSize = 2048; analyser.smoothingTimeConstant = 0.85;
			bins = new Uint8Array(analyser.frequencyBinCount);
			shelf.connect(peak); peak.connect(lp); lp.connect(master); master.connect(analyser); analyser.connect(ctx.destination);
			setWarmth();
		}
		if (ctx.state === 'suspended') { ctx.resume(); }
		return true;
	}

	function level() { return Math.pow(vol.value / 100, 2) * 0.9; }

	function setWarmth() {
		var v = Number(warm.value); // 0 = bright (20 kHz), 100 = very warm (400 Hz)
		var hz = Math.round(20000 * Math.pow(400 / 20000, v / 100));
		warmOut.textContent = v === 0 ? 'Off' : (hz >= 1000 ? (hz / 1000).toFixed(1) + ' kHz' : hz + ' Hz');
		if (lp) { lp.frequency.setTargetAtTime(hz, ctx.currentTime, 0.05); }
	}

	function startSource() {
		var s = ctx.createBufferSource();
		s.buffer = buffer(colour);
		s.loop = true;
		s.connect(shelf);
		var grey = colour === 'grey';
		shelf.gain.value = grey ? 10 : 0;
		peak.gain.value = grey ? -9 : 0;
		s.start();
		return s;
	}

	function play() {
		if (!ensure()) { return; }
		U.status(statusEl, 'Generating ' + NAMES[colour].toLowerCase() + ' noise...', '');
		if (src) { try { src.stop(); } catch (e) { /* already stopped */ } }
		src = startSource();
		master.gain.cancelScheduledValues(ctx.currentTime);
		master.gain.setValueAtTime(master.gain.value, ctx.currentTime);
		master.gain.linearRampToValueAtTime(level(), ctx.currentTime + 2);
		playing = true;
		playBtn.textContent = 'Stop';
		playBtn.setAttribute('aria-pressed', 'true');
		armTimer();
		U.status(statusEl, NAMES[colour] + ' noise playing. It loops seamlessly until you stop it.', 'ok');
		if (!raf) { raf = requestAnimationFrame(draw); }
	}

	function stop(fadeSec) {
		if (!playing) { return; }
		playing = false;
		var t = ctx.currentTime, f = fadeSec || 0.3, old = src;
		master.gain.cancelScheduledValues(t);
		master.gain.setValueAtTime(master.gain.value, t);
		master.gain.linearRampToValueAtTime(0, t + f);
		setTimeout(function () { if (old && !playing) { try { old.stop(); } catch (e) { /* done */ } } }, f * 1000 + 50);
		playBtn.textContent = 'Play';
		playBtn.setAttribute('aria-pressed', 'false');
		clearInterval(tick);
		endAt = 0;
		left.textContent = '';
		U.status(statusEl, 'Stopped.', '');
	}

	function armTimer() {
		clearInterval(tick);
		var mins = Number(timerSel.value);
		endAt = mins ? performance.now() + mins * 60000 : 0;
		left.textContent = '';
		if (!endAt) { return; }
		tick = setInterval(function () {
			var ms = endAt - performance.now();
			if (ms <= 30000 && playing && !root.classList.contains('is-fading')) {
				root.classList.add('is-fading');
				master.gain.cancelScheduledValues(ctx.currentTime);
				master.gain.setValueAtTime(master.gain.value, ctx.currentTime);
				master.gain.linearRampToValueAtTime(0, ctx.currentTime + Math.max(1, ms / 1000));
			}
			if (ms <= 0) { root.classList.remove('is-fading'); stop(0.1); U.status(statusEl, 'Sleep timer finished.', 'ok'); return; }
			var m = Math.floor(ms / 60000), s = Math.floor(ms / 1000) % 60;
			left.textContent = m + ':' + (s < 10 ? '0' : '') + s + ' left';
		}, 1000);
	}

	function draw() {
		raf = requestAnimationFrame(draw);
		var w = canvas.clientWidth, h = canvas.clientHeight, dpr = Math.min(2, window.devicePixelRatio || 1);
		if (canvas.width !== Math.round(w * dpr)) { canvas.width = Math.round(w * dpr); canvas.height = Math.round(h * dpr); }
		var W = canvas.width, H = canvas.height;
		cg.clearRect(0, 0, W, H);
		if (!analyser) { return; }
		analyser.getByteFrequencyData(bins);
		var bars = 48, nyq = ctx.sampleRate / 2, css = getComputedStyle(root).getPropertyValue('--brand').trim() || '#0f766e';
		cg.fillStyle = css;
		for (var i = 0; i < bars; i++) {
			// Log-spaced bands from 30 Hz to 20 kHz.
			var f0 = 30 * Math.pow(20000 / 30, i / bars), f1 = 30 * Math.pow(20000 / 30, (i + 1) / bars);
			var a = Math.floor(f0 / nyq * bins.length), z = Math.max(a + 1, Math.floor(f1 / nyq * bins.length)), m = 0;
			for (var k = a; k < z; k++) { m = Math.max(m, bins[k]); }
			var bh = m / 255 * H;
			cg.fillRect(Math.round(i * W / bars) + 1, H - bh, Math.round(W / bars) - 2, bh);
		}
		if (!playing && master && master.gain.value < 0.001) { cancelAnimationFrame(raf); raf = 0; }
	}

	colours.forEach(function (b) {
		b.addEventListener('click', function () {
			colour = b.getAttribute('data-wn-colour');
			colours.forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
			if (playing) {
				var old = src;
				src = startSource();
				setTimeout(function () { try { old.stop(); } catch (e) { /* done */ } }, 30);
				U.status(statusEl, NAMES[colour] + ' noise playing.', 'ok');
			}
		});
	});
	playBtn.addEventListener('click', function () { if (playing) { stop(); } else { play(); } });
	vol.addEventListener('input', function () {
		volOut.textContent = vol.value + '%';
		if (playing && !root.classList.contains('is-fading')) { master.gain.setTargetAtTime(level(), ctx.currentTime, 0.05); }
	});
	warm.addEventListener('input', setWarmth);
	timerSel.addEventListener('change', function () { root.classList.remove('is-fading'); if (playing) { master.gain.setTargetAtTime(level(), ctx.currentTime, 0.1); armTimer(); } });

	// For automated checks.
	root.wnState = function () { return { playing: playing, colour: colour, gain: master ? master.gain.value : 0, lp: lp ? lp.frequency.value : 0, buffers: Object.keys(buffers) }; };
}());
