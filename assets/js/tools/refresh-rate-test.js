/* Refresh rate test: median rAF interval -> Hz, jitter, skipped frames, motion lanes (full / half / 30 Hz) and a frame-skip strip. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="refresh-rate-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var hzEl = $('#rr-hz'), exactEl = $('#rr-exact'), measEl = $('#rr-measured'), msEl = $('#rr-ms'), jitEl = $('#rr-jitter'), skipEl = $('#rr-skipped'), statusEl = $('#rr-status');
	var canvas = $('#rr-lanes'), cx = canvas.getContext('2d'), strip = $('#rr-skip');
	var dpr = Math.min(2, window.devicePixelRatio || 1);
	var RATES = [24, 30, 48, 50, 60, 72, 75, 85, 90, 100, 120, 144, 160, 165, 170, 175, 180, 200, 240, 280, 300, 360, 480, 500];
	var CELLS = 16;

	var deltas = [], lastT = 0, frameNo = 0, skipped = 0, interval = 0, lastReport = 0;
	var speed = 960, x = 0, xHalf = 0, x30 = 0, last30 = 0;
	var css = getComputedStyle(root);
	function colour(name) { return css.getPropertyValue(name).trim() || '#0f766e'; }

	for (var i = 0; i < CELLS; i++) { strip.appendChild(document.createElement('span')); }
	var cells = strip.children;

	function median(a) {
		var s = a.slice().sort(function (p, q) { return p - q; });
		var m = s.length >> 1;
		return s.length % 2 ? s[m] : (s[m - 1] + s[m]) / 2;
	}

	function nominal(hz) {
		return RATES.reduce(function (best, r) { return Math.abs(r - hz) < Math.abs(best - hz) ? r : best; }, 60);
	}

	function report(now) {
		if (deltas.length < 30) { return; }
		var med = median(deltas);
		// Average only the frames near the median so a hiccup does not skew the exact value.
		var good = deltas.filter(function (d) { return d > med * 0.5 && d < med * 1.5; });
		var mean = good.reduce(function (a, b) { return a + b; }, 0) / good.length;
		var sd = Math.sqrt(good.reduce(function (a, b) { return a + (b - mean) * (b - mean); }, 0) / good.length);
		var hz = 1000 / mean;
		interval = mean;
		var nom = Math.abs(nominal(hz) - hz) <= Math.max(1.5, hz * 0.02) ? nominal(hz) : Math.round(hz);
		hzEl.textContent = nom;
		exactEl.textContent = 'Exact: ' + U.fmt(hz, 2) + ' Hz, based on the last ' + deltas.length + ' frames.';
		measEl.textContent = U.fmt(hz, 1) + ' Hz';
		msEl.textContent = U.fmt(mean, 2) + ' ms';
		jitEl.textContent = U.fmt(sd, 2) + ' ms';
		if (deltas.length >= 90) {
			var msg = 'Your screen is running at ' + nom + ' Hz.';
			if (nom <= 60) { msg += ' If you own a 120 Hz or faster monitor, it is set to 60 Hz: see the fixes below.'; }
			U.status(statusEl, msg, 'ok');
		}
		lastReport = now;
	}

	function draw(dt) {
		var w = canvas.width, h = canvas.height, laneH = h / 3, size = Math.round(Math.min(laneH * 0.55, 46 * dpr));
		var step = speed * dpr * dt / 1000, span = w + size * 2;
		x = (x + step) % span;
		if (frameNo % 2 === 0) { xHalf = x; }
		var now = performance.now();
		if (now - last30 >= 1000 / 30 - 1) { x30 = x; last30 = now; }
		cx.clearRect(0, 0, w, h);
		var hz = interval ? Math.round(1000 / interval) : 0;
		var labels = [(hz ? hz + ' Hz' : 'Full rate') + ' (every refresh)', (hz ? Math.round(hz / 2) + ' Hz' : 'Half rate') + ' (every 2nd refresh)', '30 Hz'];
		var xs = [x, xHalf, x30], cols = [colour('--brand'), colour('--warn'), colour('--bad')];
		cx.font = (12 * dpr) + 'px system-ui, sans-serif';
		for (var k = 0; k < 3; k++) {
			var top = laneH * k, cy = top + laneH / 2 + 6 * dpr, px = xs[k] - size;
			cx.fillStyle = colour('--muted');
			cx.fillText(labels[k], 10 * dpr, top + 16 * dpr);
			cx.fillStyle = cols[k];
			// A simple saucer: body ellipse + dome.
			cx.beginPath();
			cx.ellipse(px, cy, size * 0.6, size * 0.22, 0, 0, Math.PI * 2);
			cx.fill();
			cx.beginPath();
			cx.ellipse(px, cy - size * 0.12, size * 0.28, size * 0.24, 0, Math.PI, 0);
			cx.fill();
		}
	}

	function frame(t) {
		requestAnimationFrame(frame);
		frameNo++;
		cells[(frameNo - 1 + CELLS) % CELLS].classList.remove('is-on');
		cells[frameNo % CELLS].classList.add('is-on');
		if (!lastT) { lastT = t; return; }
		var dt = t - lastT;
		lastT = t;
		if (dt > 250) { return; } // tab was hidden or the window was dragged
		deltas.push(dt);
		if (deltas.length > 240) { deltas.shift(); }
		if (interval && deltas.length > 60 && dt > interval * 1.5) {
			skipped += Math.round(dt / interval) - 1;
			skipEl.textContent = skipped;
		}
		if (t - lastReport > 500) { report(t); }
		draw(dt);
	}

	function resize() {
		canvas.width = canvas.clientWidth * dpr;
		canvas.height = canvas.clientHeight * dpr;
	}

	function reset() {
		deltas = []; lastT = 0; skipped = 0; interval = 0; lastReport = 0;
		hzEl.textContent = '--';
		exactEl.textContent = 'Measuring your display...';
		measEl.textContent = msEl.textContent = jitEl.textContent = '-';
		skipEl.textContent = '0';
		U.status(statusEl, 'Keep this tab in front and do not move the window for about three seconds.', '');
	}

	$('#rr-again').addEventListener('click', reset);
	U.$$('[data-rr-speed]', root).forEach(function (btn) {
		btn.addEventListener('click', function () {
			speed = Number(btn.getAttribute('data-rr-speed'));
			U.$$('[data-rr-speed]', root).forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
		});
	});
	window.addEventListener('resize', resize);
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) { document.addEventListener(ev, function () { setTimeout(resize, 50); }); });
	root.addEventListener('tn:fullscreen', function () { setTimeout(resize, 50); });
	document.addEventListener('visibilitychange', function () { if (!document.hidden) { lastT = 0; } });

	resize();
	requestAnimationFrame(frame);
}());
