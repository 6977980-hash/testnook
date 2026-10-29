/* Blind spot test: fixate a cross with one eye, a dot moves slowly outward, and the user marks where it vanishes and
   comes back. With the shared screen calibration (TNScreenCal) and the viewing distance, the positions become visual
   angles; the normal blind spot runs from about 12-13 to 18 degrees from fixation on the temple side. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="blind-spot-test"]');
	if (!root) { return; }
	var U = window.TNUtil, CAL = window.TNScreenCal;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#bs-stage'), canvas = $('#bs-canvas'), ctx = canvas.getContext('2d'), statusEl = $('#bs-status');
	var distSel = $('#bs-dist'), markBtn = $('#bs-mark'), startBtn = $('#bs-start');
	var outStart = $('#bs-start-deg'), outEnd = $('#bs-end-deg'), outMid = $('#bs-mid-deg'), outW = $('#bs-width-deg');
	var mode = 'measure', eye = 'right', run = null, raf = 0;
	var SPEED_DEG = 1.6; // degrees per second, slow enough to react

	function dist() { return Number(distSel.value); }
	function degToPx(deg) { return Math.tan(deg * Math.PI / 180) * dist() * CAL.pxPerMm(); }
	function pxToDeg(px) { return Math.atan(px / CAL.pxPerMm() / dist()) * 180 / Math.PI; }

	function geom() {
		var w = stage.clientWidth, h = stage.clientHeight || 260, r = window.devicePixelRatio || 1;
		if (canvas.width !== Math.round(w * r) || canvas.height !== Math.round(h * r)) {
			canvas.style.width = w + 'px';
			canvas.style.height = h + 'px';
			canvas.width = Math.round(w * r);
			canvas.height = Math.round(h * r);
		}
		// The cross sits near the nasal edge, so the dot travels towards the temple: right for the right eye.
		var crossX = eye === 'right' ? 30 : w - 30;
		return { w: w, h: h, r: r, cy: h / 2, crossX: crossX, sign: eye === 'right' ? 1 : -1 };
	}

	function frame(dotDeg, gap) {
		var g = geom();
		ctx.setTransform(g.r, 0, 0, g.r, 0, 0);
		ctx.fillStyle = '#fff';
		ctx.fillRect(0, 0, g.w, g.h);
		ctx.strokeStyle = '#000';
		ctx.lineWidth = 3;
		ctx.beginPath();
		ctx.moveTo(g.crossX - 10, g.cy); ctx.lineTo(g.crossX + 10, g.cy);
		ctx.moveTo(g.crossX, g.cy - 10); ctx.lineTo(g.crossX, g.cy + 10);
		ctx.stroke();
		if (gap) {
			// Fill-in demo: a line with a gap at the blind spot, which the brain fills.
			var a = g.crossX + g.sign * degToPx(12.5), b = g.crossX + g.sign * degToPx(18);
			ctx.lineWidth = 4;
			ctx.strokeStyle = '#0f766e';
			ctx.beginPath();
			ctx.moveTo(g.crossX + g.sign * 30, g.cy); ctx.lineTo(a, g.cy);
			ctx.moveTo(b, g.cy); ctx.lineTo(g.crossX + g.sign * (g.w - 50), g.cy);
			ctx.stroke();
		}
		if (dotDeg !== null) {
			var x = g.crossX + g.sign * degToPx(dotDeg), rad = Math.max(6, degToPx(0.8));
			ctx.fillStyle = '#c62828';
			ctx.beginPath();
			ctx.arc(x, g.cy, rad, 0, Math.PI * 2);
			ctx.fill();
			return x > 0 && x < g.w;
		}
		return true;
	}

	function maxDeg() { var g = geom(); return pxToDeg(g.w - 50); }

	function idle() {
		cancelAnimationFrame(raf);
		run = null;
		markBtn.disabled = true;
		if (mode === 'classic') { frame(15.5, false); }
		else if (mode === 'fill') { frame(null, true); }
		else { frame(5, false); }
		if (maxDeg() < 20) {
			U.status(statusEl, 'The screen is too narrow for the blind spot at ' + (dist() / 10) + ' cm. Choose a shorter distance, turn the phone sideways or use full screen.', 'bad');
		}
	}

	function start() {
		if (maxDeg() < 20) { idle(); return; }
		run = { t0: performance.now(), deg: 5, marks: [] };
		markBtn.disabled = false;
		markBtn.textContent = 'Dot gone (space)';
		markBtn.focus();
		U.status(statusEl, 'Cover your ' + (eye === 'right' ? 'left' : 'right') + ' eye, keep looking at the cross, and press when the red dot disappears.', '');
		cancelAnimationFrame(raf);
		(function tick(now) {
			if (!run) { return; }
			run.deg = 5 + (now - run.t0) / 1000 * SPEED_DEG;
			if (run.deg > Math.min(maxDeg(), 30)) { finish(); return; }
			frame(run.deg, false);
			raf = requestAnimationFrame(tick);
		}(performance.now()));
	}

	function mark() {
		if (!run) { return; }
		run.marks.push(run.deg);
		if (run.marks.length === 1) {
			markBtn.textContent = 'Dot back (space)';
			U.status(statusEl, 'Gone at ' + run.deg.toFixed(1) + '°. Keep looking at the cross and press again when the dot comes back.', '');
		} else {
			finish();
		}
	}

	function finish() {
		var m = run ? run.marks : [];
		cancelAnimationFrame(raf);
		run = null;
		markBtn.disabled = true;
		if (m.length < 2) {
			idle();
			U.status(statusEl, 'The dot reached the edge without two presses. Check that the other eye is covered, the distance is right, and you are looking at the cross, then try again.', 'bad');
			return;
		}
		var a = m[0], b = m[1];
		outStart.textContent = a.toFixed(1) + '°';
		outEnd.textContent = b.toFixed(1) + '°';
		outMid.textContent = ((a + b) / 2).toFixed(1) + '°';
		outW.textContent = (b - a).toFixed(1) + '°';
		frame(null, false);
		var mid = (a + b) / 2, ok = mid > 12 && mid < 19 && b - a > 3 && b - a < 9;
		var note = CAL.calibrated() ? '' : ' The screen is not calibrated, so the angles assume 96 px per inch and may be off.';
		U.status(statusEl, (eye === 'right' ? 'Right' : 'Left') + ' eye: blind spot from ' + a.toFixed(1) + '° to ' + b.toFixed(1) + '°. ' + (ok ? 'That is in the normal range.' : 'That is outside the usual 12-18°. Check your distance and calibration and repeat; if it stays different, mention it to an optometrist.') + note, ok ? 'ok' : '');
	}

	markBtn.addEventListener('click', mark);
	canvas.addEventListener('click', mark); // tap anywhere on the chart, useful in full screen
	startBtn.addEventListener('click', function () { if (mode !== 'measure') { setMode('measure'); } start(); });
	document.addEventListener('keydown', function (e) {
		if (e.key === ' ' && run) { e.preventDefault(); if (!e.repeat) { mark(); } }
	});

	function setMode(m) {
		mode = m;
		U.$$('[data-bs-mode]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x.getAttribute('data-bs-mode') === m)); });
		idle();
		if (m === 'classic') { U.status(statusEl, 'Cover your ' + (eye === 'right' ? 'left' : 'right') + ' eye, look at the cross from ' + (dist() / 10) + ' cm and the red dot disappears. Move your head slightly closer and further to find the exact point.', ''); }
		if (m === 'fill') { U.status(statusEl, 'Look at the cross with one eye: the gap in the green line vanishes, because your brain fills in the blind spot.', ''); }
	}
	U.$$('[data-bs-mode]', root).forEach(function (b) { b.addEventListener('click', function () { setMode(b.getAttribute('data-bs-mode')); }); });
	U.$$('[data-bs-eye]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			eye = b.getAttribute('data-bs-eye');
			U.$$('[data-bs-eye]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
			setMode(mode);
		});
	});
	distSel.addEventListener('change', idle);
	CAL.onChange(idle);
	stage.addEventListener('tn:fullscreen', function () { setTimeout(idle, 60); });
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) { document.addEventListener(ev, function () { setTimeout(idle, 60); }); });
	var lastW = 0;
	window.addEventListener('resize', function () { if (!run && Math.abs(stage.clientWidth - lastW) > 10) { lastW = stage.clientWidth; idle(); } });

	if (window.innerWidth < 700) { distSel.value = '300'; }
	idle();
}());
