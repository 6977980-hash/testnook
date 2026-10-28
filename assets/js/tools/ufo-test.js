/* UFO test: rows of UFOs moving at different pixel speeds on a light or dark background, with a frame-skip check, measured refresh rate and a pursuit-tracking hint. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="ufo-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#ufo-stage'), canvas = $('#ufo-canvas'), cx = canvas.getContext('2d');
	var hzEl = $('#ufo-hz'), msEl = $('#ufo-ms'), skipEl = $('#ufo-skipped'), pxEl = $('#ufo-px'), statusEl = $('#ufo-status');
	var speedSel = U.$$('[data-ufo-speed]', root), bgSel = U.$$('[data-ufo-bg]', root), rowsSel = U.$$('[data-ufo-rows]', root);
	var dpr = Math.min(2, window.devicePixelRatio || 1);

	var speed = 960, rows = 3, bg = 'light', sizeMul = 1;
	var deltas = [], lastT = 0, skipped = 0, interval = 0, lastReport = 0, frameNo = 0;
	var xs = [0, 0, 0, 0];
	var SPEEDS = { 1: [960], 3: [480, 960, 1920], 4: [240, 480, 960, 1920] };

	function median(a) {
		var s = a.slice().sort(function (p, q) { return p - q; });
		var m = s.length >> 1;
		return s.length % 2 ? s[m] : (s[m - 1] + s[m]) / 2;
	}

	function report(now) {
		if (deltas.length < 30) { return; }
		var med = median(deltas);
		var good = deltas.filter(function (d) { return d > med * 0.5 && d < med * 1.5; });
		var mean = good.reduce(function (a, b) { return a + b; }, 0) / good.length;
		interval = mean;
		var hz = Math.round(1000 / mean);
		hzEl.textContent = hz + ' Hz';
		msEl.textContent = U.fmt(mean, 2) + ' ms';
		pxEl.textContent = U.fmt(speed / (1000 / mean), 1) + ' px';
		if (deltas.length >= 90 && now - lastReport > 2000) {
			U.status(statusEl, 'Running at ' + hz + ' Hz: the UFOs move ' + U.fmt(speed / hz, 1) + ' pixels per frame at the selected speed. Follow one with your eyes and look at the trail behind it.', 'ok');
		}
		lastReport = now;
	}

	function ufo(px, cy, size, col, dark) {
		// Saucer: body ellipse, dome, three lights under the body.
		cx.fillStyle = col;
		cx.beginPath();
		cx.ellipse(px, cy, size * 0.62, size * 0.22, 0, 0, Math.PI * 2);
		cx.fill();
		cx.fillStyle = dark ? '#9ae6ff' : '#2563eb';
		cx.beginPath();
		cx.ellipse(px, cy - size * 0.14, size * 0.28, size * 0.26, 0, Math.PI, 0);
		cx.fill();
		cx.fillStyle = dark ? '#ffd166' : '#111';
		for (var k = -1; k <= 1; k++) {
			cx.beginPath();
			cx.arc(px + k * size * 0.3, cy + size * 0.1, size * 0.05, 0, Math.PI * 2);
			cx.fill();
		}
	}

	function draw(dt) {
		var w = canvas.width, h = canvas.height, dark = bg === 'dark';
		var list = SPEEDS[rows] || SPEEDS[3];
		var laneH = h / list.length, size = Math.round(Math.min(laneH * 0.5 * sizeMul, 54 * dpr * sizeMul));
		cx.fillStyle = dark ? '#000' : '#fff';
		cx.fillRect(0, 0, w, h);
		if (bg === 'stripes') {
			// Vertical reference stripes make skipped frames and blur easier to judge.
			cx.fillStyle = '#d9dde3';
			for (var sx = 0; sx < w; sx += 40 * dpr) { cx.fillRect(sx, 0, 20 * dpr, h); }
		}
		cx.font = (12 * dpr) + 'px system-ui, sans-serif';
		for (var i = 0; i < list.length; i++) {
			var v = list[i] * speed / 960, span = w + size * 2;
			xs[i] = (xs[i] + v * dpr * dt / 1000) % span;
			var top = laneH * i, cy = top + laneH / 2 + 4 * dpr;
			cx.fillStyle = dark ? '#9aa3ad' : '#6b7280';
			cx.fillText(Math.round(v) + ' px/s' + (interval ? ' (' + U.fmt(v / (1000 / interval), 1) + ' px per frame)' : ''), 10 * dpr, top + 16 * dpr);
			if (i) {
				cx.fillStyle = dark ? '#1f2937' : '#e5e7eb';
				cx.fillRect(0, top, w, dpr);
			}
			ufo(xs[i] - size, cy, size, dark ? '#e5e7eb' : '#4b5563', dark);
		}
	}

	function frame(t) {
		requestAnimationFrame(frame);
		frameNo++;
		if (!lastT) { lastT = t; return; }
		var dt = t - lastT;
		lastT = t;
		if (dt > 250) { return; }
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
		msEl.textContent = pxEl.textContent = '-';
		skipEl.textContent = '0';
		U.status(statusEl, 'Measuring your display. Keep this tab in front for a few seconds.', '');
	}

	function sel(list, attr, fn) {
		list.forEach(function (btn) {
			btn.addEventListener('click', function () {
				fn(btn.getAttribute(attr));
				list.forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
			});
		});
	}
	sel(speedSel, 'data-ufo-speed', function (v) { speed = Number(v); });
	sel(bgSel, 'data-ufo-bg', function (v) { bg = v; stage.setAttribute('data-bg', v); });
	sel(rowsSel, 'data-ufo-rows', function (v) { rows = Number(v); });
	$('#ufo-again').addEventListener('click', reset);

	window.addEventListener('resize', resize);
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) { document.addEventListener(ev, function () { setTimeout(resize, 50); }); });
	root.addEventListener('tn:fullscreen', function () { setTimeout(resize, 50); });
	document.addEventListener('visibilitychange', function () { if (!document.hidden) { lastT = 0; } });

	resize();
	reset();
	requestAnimationFrame(frame);
}());
