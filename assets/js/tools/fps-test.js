/* FPS test: rAF frame counter with average, min/max, frame-time graph, dropped frames and a 30/15 fps comparison lane. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="fps-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var nowEl = $('#fps-now'), avgEl = $('#fps-avg'), mmEl = $('#fps-minmax'), msEl = $('#fps-ms'), dropEl = $('#fps-drop'), hzEl = $('#fps-hz'), statusEl = $('#fps-status');
	var lanes = $('#fps-lanes'), graph = $('#fps-graph');
	var lc = lanes.getContext('2d'), gc = graph.getContext('2d');
	var dpr = Math.min(2, window.devicePixelRatio || 1);

	var speed = 960; // px per second
	var paused = false, raf = 0;
	var times = [];      // last ~120 frame times (ms)
	var secFrames = 0, secStart = 0, fps = 0, samples = [], dropped = 0, lastT = 0;
	var x = 0, last30 = 0, last15 = 0, x30 = 0, x15 = 0;
	var css = getComputedStyle(root);

	function resize() {
		var w = lanes.clientWidth, h = lanes.clientHeight;
		lanes.width = w * dpr; lanes.height = h * dpr;
		graph.width = graph.clientWidth * dpr; graph.height = graph.clientHeight * dpr;
	}

	function colour(name) { return css.getPropertyValue(name).trim() || '#0f766e'; }

	function drawLanes(dt) {
		var w = lanes.width, h = lanes.height, box = Math.round(h / 4.5), laneH = h / 3;
		x = (x + speed * dpr * dt / 1000) % (w + box);
		if (performance.now() - last30 >= 1000 / 30) { x30 = x; last30 = performance.now(); }
		if (performance.now() - last15 >= 1000 / 15) { x15 = x; last15 = performance.now(); }
		lc.clearRect(0, 0, w, h);
		lc.font = (12 * dpr) + 'px system-ui, sans-serif';
		lc.fillStyle = colour('--muted');
		var labels = [(fps ? fps + ' fps' : 'your fps') + ' (every frame)', '30 fps', '15 fps'];
		var xs = [x, x30, x15], cols = [colour('--brand'), colour('--warn'), colour('--bad')];
		for (var i = 0; i < 3; i++) {
			lc.fillStyle = colour('--muted');
			lc.fillText(labels[i], 10 * dpr, laneH * i + 16 * dpr);
			lc.fillStyle = cols[i];
			lc.fillRect(xs[i] - box, laneH * i + (laneH - box) / 2 + 6 * dpr, box, box);
		}
	}

	function drawGraph() {
		var w = graph.width, h = graph.height, n = times.length;
		gc.clearRect(0, 0, w, h);
		if (!n) { return; }
		var target = fps ? 1000 / fps : 16.7, max = Math.max(target * 3, 50);
		gc.fillStyle = colour('--surface-2');
		gc.fillRect(0, 0, w, h);
		gc.strokeStyle = colour('--border');
		gc.beginPath();
		gc.moveTo(0, h - (target / max) * h);
		gc.lineTo(w, h - (target / max) * h);
		gc.stroke();
		gc.strokeStyle = colour('--brand');
		gc.lineWidth = 2 * dpr;
		gc.beginPath();
		for (var i = 0; i < n; i++) {
			var px = (i / (120 - 1)) * w, py = h - Math.min(1, times[i] / max) * h;
			if (i === 0) { gc.moveTo(px, py); } else { gc.lineTo(px, py); }
		}
		gc.stroke();
		gc.lineWidth = 1;
	}

	function frame(t) {
		raf = requestAnimationFrame(frame);
		if (paused) { return; }
		if (!lastT) { lastT = t; secStart = t; return; }
		var dt = t - lastT;
		lastT = t;
		if (dt > 1000) { dt = 0; secStart = t; secFrames = 0; return; } // tab was hidden
		times.push(dt);
		if (times.length > 120) { times.shift(); }
		secFrames++;
		if (fps && dt > (1000 / fps) * 1.5 && samples.length > 1) { dropped++; dropEl.textContent = dropped; }

		if (t - secStart >= 1000) {
			fps = Math.round(secFrames * 1000 / (t - secStart));
			secFrames = 0;
			secStart = t;
			samples.push(fps);
			if (samples.length > 60) { samples.shift(); }
			var sum = samples.reduce(function (a, b) { return a + b; }, 0);
			var avg = sum / samples.length;
			nowEl.textContent = fps;
			avgEl.textContent = U.fmt(avg, 1);
			mmEl.textContent = Math.min.apply(null, samples) + ' / ' + Math.max.apply(null, samples);
			msEl.textContent = U.fmt(1000 / fps, 1) + ' ms';
			if (samples.length >= 3) {
				var peak = Math.max.apply(null, samples);
				var hz = [30, 60, 75, 90, 120, 144, 165, 240, 360].reduce(function (best, r) { return Math.abs(r - peak) < Math.abs(best - peak) ? r : best; }, 60);
				hzEl.textContent = hz + ' Hz';
				var msg = avg >= hz - 3 ? 'Smooth: your browser is drawing at about ' + hz + ' FPS, which matches your screen.' : 'Your screen can show about ' + hz + ' FPS but the browser averages ' + U.fmt(avg, 0) + '. Close other apps or check power saving.';
				U.status(statusEl, msg, avg >= hz - 3 ? 'ok' : 'bad');
			}
		}
		drawLanes(dt);
		drawGraph();
	}

	function reset() {
		times = []; samples = []; secFrames = 0; dropped = 0; lastT = 0; fps = 0;
		nowEl.textContent = '--'; avgEl.textContent = mmEl.textContent = msEl.textContent = hzEl.textContent = '-'; dropEl.textContent = '0';
		U.status(statusEl, 'Measuring... keep this tab in front for a few seconds.', '');
	}

	$('#fps-pause').addEventListener('click', function () {
		paused = !paused;
		this.textContent = paused ? 'Resume' : 'Pause';
		if (!paused) { lastT = 0; }
	});
	$('#fps-reset').addEventListener('click', reset);
	U.$$('[data-fps-speed]', root).forEach(function (btn) {
		btn.addEventListener('click', function () {
			speed = Number(btn.getAttribute('data-fps-speed'));
			U.$$('[data-fps-speed]', root).forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
		});
	});
	window.addEventListener('resize', resize);
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) { document.addEventListener(ev, function () { setTimeout(resize, 50); }); });
	root.addEventListener('tn:fullscreen', function () { setTimeout(resize, 50); });
	document.addEventListener('visibilitychange', function () { if (!document.hidden) { lastT = 0; } });

	resize();
	raf = requestAnimationFrame(frame);
}());
