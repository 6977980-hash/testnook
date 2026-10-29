/* Eye test: a tumbling E visual acuity test and a letter chart, sized for the chosen viewing distance with the shared
   screen calibration (TNScreenCal). A 20/20 letter is 5 arcminutes tall at the viewing distance. Each line shows
   five Es; three right passes the line, three wrong ends the eye. Lines too small for the screen's pixels are skipped. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="eye-test"]');
	if (!root) { return; }
	var U = window.TNUtil, CAL = window.TNScreenCal;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#et-stage'), canvas = $('#et-canvas'), ctx = canvas.getContext('2d'), statusEl = $('#et-status');
	var distSel = $('#et-dist'), answers = $('#et-answers'), lineEl = $('#et-line'), resR = $('#et-res-right'), resL = $('#et-res-left');
	var startBtn = $('#et-start');

	var LINES = [200, 100, 70, 50, 40, 30, 25, 20, 15, 10];
	var DIRS = ['right', 'down', 'left', 'up'];
	var SLOAN = 'CDHKNORSVZ';
	var mode = 'e', eye = 'right', run = null, results = {};

	function distMm() { return Number(distSel.value); }
	// Letter height in CSS px for Snellen denominator x (20/x).
	function letterPx(x) { return distMm() * Math.tan((5 * x / 20) / 60 * Math.PI / 180) * CAL.pxPerMm(); }
	function dpr() { return window.devicePixelRatio || 1; }
	function fits(x, maxCss) {
		var h = letterPx(x);
		return h * dpr() >= 5 && h <= maxCss;
	}
	function label(x) {
		var metric = Math.round(x * 0.3 * 10) / 10;
		return '20/' + x + ' (6/' + metric + ')';
	}

	function size() {
		var w = stage.clientWidth, h = Math.max(260, stage.clientHeight - 4), r = dpr();
		canvas.style.width = w + 'px';
		canvas.style.height = h + 'px';
		canvas.width = Math.round(w * r);
		canvas.height = Math.round(h * r);
		return { w: w, h: h, r: r };
	}

	function clear(s) {
		ctx.setTransform(1, 0, 0, 1, 0, 0);
		ctx.fillStyle = '#fff';
		ctx.fillRect(0, 0, canvas.width, canvas.height);
		ctx.fillStyle = '#000';
		return s;
	}

	// Tumbling E on a 5 x 5 grid, opening facing dir.
	function drawE(cx, cy, hCss, dir, r) {
		var u = hCss * r / 5, x0 = cx * r - 2.5 * u, y0 = cy * r - 2.5 * u;
		ctx.save();
		ctx.translate(cx * r, cy * r);
		ctx.rotate(DIRS.indexOf(dir) * Math.PI / 2);
		ctx.translate(-cx * r, -cy * r);
		ctx.fillRect(x0, y0, u, 5 * u);
		[0, 2, 4].forEach(function (row) { ctx.fillRect(x0, y0 + row * u, 5 * u, u); });
		ctx.restore();
	}

	/* ---------- Tumbling E test ---------- */
	function nextE() {
		var s = clear(size());
		var x = run.lines[run.li];
		run.dir = DIRS[Math.floor(Math.random() * 4)];
		if (run.dir === run.prev) { run.dir = DIRS[(DIRS.indexOf(run.dir) + 1 + Math.floor(Math.random() * 3)) % 4]; }
		run.prev = run.dir;
		drawE(s.w / 2, s.h / 2, letterPx(x), run.dir, s.r);
		lineEl.textContent = 'Line ' + label(x) + ' - letter ' + (run.shown + 1) + ' of 5';
	}

	function start() {
		var s = size(), maxCss = s.h * 0.85;
		var lines = LINES.filter(function (x) { return fits(x, maxCss); });
		if (!lines.length) { U.status(statusEl, 'No line fits this screen at this distance. Choose a shorter distance or use full screen.', 'bad'); return; }
		run = { lines: lines, li: 0, shown: 0, right: 0, wrong: 0, passed: null, prev: '' };
		root.classList.add('is-running');
		answers.hidden = false;
		startBtn.textContent = 'Restart';
		var skipped = LINES.length - LINES.indexOf(lines[lines.length - 1]) - 1;
		U.status(statusEl, 'Cover your ' + (eye === 'right' ? 'left' : 'right') + ' eye. Which way do the arms of the E point? Use the arrow keys or the buttons.' + (skipped ? ' The smallest ' + skipped + ' line' + (skipped > 1 ? 's are' : ' is') + ' too small for this screen at this distance.' : ''), '');
		nextE();
	}

	function answer(dir) {
		if (!run) { return; }
		if (dir === run.dir) { run.right++; } else { run.wrong++; }
		run.shown++;
		if (run.right >= 3) {
			run.passed = run.lines[run.li];
			run.li++;
			run.shown = run.right = run.wrong = 0;
			if (run.li >= run.lines.length) { finish(); return; }
		} else if (run.wrong >= 3) {
			finish();
			return;
		}
		nextE();
	}

	function finish() {
		var x = run.passed, smallest = run.lines[run.lines.length - 1], first = run.lines[0];
		var text;
		if (x === null) {
			text = 'worse than ' + label(first);
		} else {
			text = label(x) + (x === smallest && smallest !== 10 ? ' or better (screen limit)' : '');
		}
		results[eye] = { x: x, text: text };
		(eye === 'right' ? resR : resL).textContent = text;
		run = null;
		root.classList.remove('is-running');
		answers.hidden = true;
		var s = clear(size());
		ctx.font = '600 ' + Math.round(18 * s.r) + 'px system-ui, sans-serif';
		ctx.textAlign = 'center';
		ctx.fillText((eye === 'right' ? 'Right' : 'Left') + ' eye: ' + text, s.w * s.r / 2, s.h * s.r / 2);
		lineEl.textContent = 'Finished';
		var other = eye === 'right' ? 'left' : 'right';
		var msg = (eye === 'right' ? 'Right' : 'Left') + ' eye: ' + text + '.';
		if (!results[other]) {
			msg += ' Now choose ' + (other === 'left' ? 'Left eye' : 'Right eye') + ' and press Start to test the other eye.';
		} else if ([x, results[other].x].some(function (v) { return v === null || v > 40; })) {
			msg += ' One eye read no better than 20/40. That is worth an eye examination.';
		}
		U.status(statusEl, msg, x !== null && x <= 20 ? 'ok' : '');
	}

	answers.addEventListener('click', function (e) {
		var b = e.target.closest('[data-et]');
		if (b) { answer(b.getAttribute('data-et')); }
	});
	document.addEventListener('keydown', function (e) {
		if (!run || mode !== 'e') { return; }
		var map = { ArrowUp: 'up', ArrowDown: 'down', ArrowLeft: 'left', ArrowRight: 'right' };
		if (map[e.key]) { e.preventDefault(); answer(map[e.key]); }
		else if (e.key === ' ' || e.key === '?') { e.preventDefault(); answer('none'); }
	});

	/* ---------- Letter chart ---------- */
	function chart() {
		var s = size(), r = s.r;
		clear(s);
		ctx.textAlign = 'center';
		ctx.textBaseline = 'alphabetic';
		var y = 16, shown = 0;
		LINES.forEach(function (x, i) {
			var h = letterPx(x);
			if (h * r < 5 || h > s.h * 0.6) { return; }
			var n = Math.min(i + 1, 8), gap = h, w = n * h + (n - 1) * gap;
			while (n > 1 && w > s.w - 140) { n--; w = n * h + (n - 1) * gap; }
			if (w > s.w - 20 || y + h + 18 > s.h) { return; }
			ctx.font = '700 ' + (h / 0.716 * r) + 'px Arial, Helvetica, sans-serif';
			var letters = '';
			for (var k = 0; k < n; k++) { letters += SLOAN[(i * 3 + k * 7) % SLOAN.length]; }
			for (var j = 0; j < n; j++) { ctx.fillText(letters[j], (s.w / 2 - w / 2 + h / 2 + j * (h + gap)) * r, (y + h) * r); }
			ctx.font = '600 ' + (11 * r) + 'px system-ui, sans-serif';
			ctx.textAlign = 'right';
			ctx.fillStyle = '#666';
			ctx.fillText('20/' + x, (s.w - 8) * r, (y + h) * r);
			ctx.fillStyle = '#000';
			ctx.textAlign = 'center';
			y += h + Math.max(12, h * 0.6);
			shown++;
		});
		lineEl.textContent = shown ? 'Letter chart for ' + distSel.options[distSel.selectedIndex].text : 'No line fits: change the distance';
		U.status(statusEl, 'Stand at the chosen distance, cover one eye and read each line aloud to a helper. Your acuity is the smallest line you read with no more than two mistakes.', '');
	}

	function redraw() {
		if (mode === 'chart') { chart(); return; }
		if (run) { nextE(); return; }
		var s = clear(size());
		var x = 20, h = letterPx(x);
		drawE(s.w / 2, s.h / 2, Math.max(h, 5 / s.r), 'right', s.r);
		lineEl.textContent = 'A 20/20 E at ' + distSel.options[distSel.selectedIndex].text + ' is ' + (h / CAL.pxPerMm()).toFixed(1) + ' mm tall';
	}

	U.$$('[data-et-mode]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			mode = b.getAttribute('data-et-mode');
			U.$$('[data-et-mode]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
			run = null;
			answers.hidden = true;
			root.classList.remove('is-running');
			root.classList.toggle('is-chart', mode === 'chart');
			startBtn.style.display = mode === 'chart' ? 'none' : '';
			redraw();
		});
	});
	U.$$('[data-et-eye]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			eye = b.getAttribute('data-et-eye');
			U.$$('[data-et-eye]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
			run = null;
			answers.hidden = true;
			redraw();
		});
	});
	startBtn.addEventListener('click', start);
	distSel.addEventListener('change', function () { run = null; answers.hidden = true; redraw(); });
	CAL.onChange(redraw);
	stage.addEventListener('tn:fullscreen', function () { setTimeout(redraw, 60); });
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) { document.addEventListener(ev, function () { setTimeout(redraw, 60); }); });
	var lastW = 0;
	window.addEventListener('resize', function () { if (Math.abs(stage.clientWidth - lastW) > 10) { lastW = stage.clientWidth; redraw(); } });

	if (window.innerWidth < 700) { distSel.value = '400'; }
	if (!CAL.calibrated()) { U.status(statusEl, 'Calibrate first (below the chart) so the letters are the right size, then choose your distance and press Start.', 'bad'); }
	redraw();
}());
