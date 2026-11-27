/* Frame skipping test: 12 cells, one lit per refresh via requestAnimationFrame. The cell index follows elapsed frames, so a frame the browser misses also shows as a gap in a photo. Measures the refresh rate (median rAF interval) and counts browser-missed frames. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="frame-skipping-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var box = $('#fs-cells'), hzEl = $('#fs-hz'), msEl = $('#fs-ms'), framesEl = $('#fs-frames'), missedEl = $('#fs-missed');
	var statusEl = $('#fs-status'), pauseBtn = $('#fs-pause');
	var N = 12, cells = [], i;
	for (i = 0; i < N; i++) { cells.push(box.appendChild(document.createElement('span'))); }

	var deltas = [], lastT = 0, interval = 0, frames = 0, missed = 0, cell = 0, lastReport = 0, paused = false, told = false;

	function median(a) {
		var s = a.slice().sort(function (p, q) { return p - q; });
		var m = s.length >> 1;
		return s.length % 2 ? s[m] : (s[m - 1] + s[m]) / 2;
	}

	function report(now) {
		lastReport = now;
		if (deltas.length < 30) { return; }
		var med = median(deltas);
		var good = deltas.filter(function (d) { return d > med * 0.5 && d < med * 1.5; });
		interval = good.reduce(function (a, b) { return a + b; }, 0) / good.length;
		var hz = 1000 / interval;
		hzEl.textContent = Math.round(hz) + ' Hz';
		msEl.textContent = U.fmt(interval, 2) + ' ms';
		root.setAttribute('data-fs-hz', U.fmt(hz, 1));
		if (!told && deltas.length >= 90) {
			told = true;
			var shutter = Math.max(4, Math.round(hz / 10));
			U.status(statusEl, 'Your screen is drawing at ' + Math.round(hz) + ' Hz. Photograph the box with a shutter of about 1/10 s (covers ' + shutter + ' cells) and check that the lit cells have no dark gap.', 'ok');
		}
	}

	function light(idx) {
		cells[cell].classList.remove('is-on');
		cell = idx;
		cells[cell].classList.add('is-on');
		root.setAttribute('data-fs-cell', String(cell));
		root.setAttribute('data-fs-frame', String(frames));
	}

	function frame(t) {
		requestAnimationFrame(frame);
		if (paused) { lastT = 0; return; }
		var step = 1;
		if (lastT) {
			var dt = t - lastT;
			if (dt > 250) {
				lastT = t; // tab hidden or window dragged: restart timing, do not count
			} else {
				deltas.push(dt);
				if (deltas.length > 240) { deltas.shift(); }
				if (interval && deltas.length > 60 && dt > interval * 1.5) {
					step = Math.min(N - 1, Math.round(dt / interval));
					missed += step - 1;
					missedEl.textContent = missed;
				}
			}
		}
		lastT = t;
		frames++;
		light((cell + step) % N);
		if (frames % 10 === 0) { framesEl.textContent = frames; }
		if (t - lastReport > 500) { report(t); }
	}

	function reset() {
		deltas = []; lastT = 0; interval = 0; missed = 0; frames = 0; lastReport = 0; told = false;
		hzEl.textContent = '--'; msEl.textContent = '-'; missedEl.textContent = '0'; framesEl.textContent = '0';
		U.status(statusEl, 'Measuring your display. Keep this tab in front for a few seconds.', '');
	}

	pauseBtn.addEventListener('click', function () {
		paused = !paused;
		pauseBtn.setAttribute('aria-pressed', paused ? 'true' : 'false');
		pauseBtn.textContent = paused ? 'Resume' : 'Pause';
	});
	$('#fs-again').addEventListener('click', reset);
	document.addEventListener('visibilitychange', function () { if (!document.hidden) { lastT = 0; } });
	light(0);
	requestAnimationFrame(frame);
}());
