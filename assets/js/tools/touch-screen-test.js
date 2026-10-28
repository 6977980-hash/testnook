/* Touch screen test: multi-touch drawing with one colour per finger, live touch markers, max simultaneous touches, and a grid mode that maps dead zones. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="touch-screen-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#ts-stage'), ink = $('#ts-ink'), live = $('#ts-live'), hint = $('#ts-hint'), statusEl = $('#ts-status');
	var ic = ink.getContext('2d'), lc = live.getContext('2d');
	var out = { now: $('#ts-now'), max: $('#ts-max'), cov: $('#ts-cov'), type: $('#ts-type') };
	var COLOURS = ['#0f9d8a', '#e2563b', '#3b6fe2', '#d39a0b', '#9b4fd1', '#1aa34a', '#d6337a', '#0b8fc4', '#7a6a12', '#555f6e'];
	var dpr = Math.min(2, window.devicePixelRatio || 1);

	var mode = 'draw', gridSize = 'fine', pointers = {}, slot = 0, maxTouches = 0, raf = 0;
	var cols = 0, rows = 0, cell = 0, filled = null, filledCount = 0, w = 0, h = 0;

	function css(name) { return getComputedStyle(root).getPropertyValue(name).trim(); }

	function setupGrid() {
		var target = gridSize === 'fine' ? 28 : 48;
		cell = target * dpr;
		cols = Math.max(4, Math.round(w / cell));
		rows = Math.max(4, Math.round(h / cell));
		filled = new Uint8Array(cols * rows);
		filledCount = 0;
		drawGrid();
		updateCoverage();
	}

	function drawGrid() {
		ic.clearRect(0, 0, w, h);
		var cw = w / cols, ch = h / rows;
		ic.fillStyle = css('--ok') || '#15803d';
		for (var i = 0; i < filled.length; i++) {
			if (filled[i]) { ic.fillRect((i % cols) * cw, Math.floor(i / cols) * ch, cw, ch); }
		}
		ic.strokeStyle = css('--border') || '#ccc';
		ic.lineWidth = 1;
		ic.beginPath();
		for (var x = 1; x < cols; x++) { ic.moveTo(Math.round(x * cw) + 0.5, 0); ic.lineTo(Math.round(x * cw) + 0.5, h); }
		for (var y = 1; y < rows; y++) { ic.moveTo(0, Math.round(y * ch) + 0.5); ic.lineTo(w, Math.round(y * ch) + 0.5); }
		ic.stroke();
	}

	function markCell(px, py) {
		var cx = Math.floor(px / (w / cols)), cy = Math.floor(py / (h / rows));
		if (cx < 0 || cy < 0 || cx >= cols || cy >= rows) { return; }
		var i = cy * cols + cx;
		if (filled[i]) { return; }
		filled[i] = 1;
		filledCount++;
		ic.fillStyle = css('--ok') || '#15803d';
		var cw = w / cols, ch = h / rows;
		ic.fillRect(cx * cw + 1, cy * ch + 1, cw - 1, ch - 1);
		updateCoverage();
	}

	// Mark every cell along a segment so fast swipes do not leave gaps.
	function markLine(x0, y0, x1, y1) {
		var steps = Math.max(1, Math.ceil(Math.hypot(x1 - x0, y1 - y0) / (Math.min(w / cols, h / rows) / 2)));
		for (var s = 0; s <= steps; s++) { markCell(x0 + (x1 - x0) * s / steps, y0 + (y1 - y0) * s / steps); }
	}

	function updateCoverage() {
		if (mode !== 'grid') { out.cov.textContent = '-'; return; }
		var pct = filledCount / filled.length * 100;
		out.cov.textContent = Math.floor(pct) + '%';
		if (filledCount === filled.length) {
			U.status(statusEl, 'Every square responded. No dead zones found on this screen.', 'ok');
		}
	}

	function resize(force) {
		var nw = Math.round(stage.clientWidth * dpr), nh = Math.round(stage.clientHeight * dpr);
		if (!force && nw === w && nh === h) { return; }
		w = ink.width = live.width = nw;
		h = ink.height = live.height = nh;
		if (mode === 'grid') { setupGrid(); } else { ic.clearRect(0, 0, w, h); }
	}

	function pos(e) {
		var r = ink.getBoundingClientRect();
		return { x: (e.clientX - r.left) * dpr, y: (e.clientY - r.top) * dpr };
	}

	function count() {
		var n = Object.keys(pointers).length;
		out.now.textContent = n;
		if (n > maxTouches) {
			maxTouches = n;
			out.max.textContent = n;
			if (n > 1) { U.status(statusEl, 'Multi-touch works: ' + n + ' touches at once.', 'ok'); }
		}
	}

	function down(e) {
		e.preventDefault();
		try { stage.setPointerCapture(e.pointerId); } catch (err) { /* synthetic events */ }
		hint.hidden = true;
		var p = pos(e);
		pointers[e.pointerId] = { x: p.x, y: p.y, c: COLOURS[slot++ % COLOURS.length], n: slot, size: Math.max(e.width || 0, e.height || 0) };
		out.type.textContent = e.pointerType === 'touch' ? 'Finger' : e.pointerType === 'pen' ? 'Stylus' : 'Mouse';
		if (mode === 'grid') { markCell(p.x, p.y); } else { dot(pointers[e.pointerId], p); }
		count();
		if (!raf) { raf = requestAnimationFrame(drawLive); }
	}

	function dot(pt, p) {
		ic.fillStyle = pt.c;
		ic.beginPath();
		ic.arc(p.x, p.y, 3 * dpr, 0, Math.PI * 2);
		ic.fill();
	}

	function move(e) {
		var pt = pointers[e.pointerId];
		if (!pt) { return; }
		e.preventDefault();
		var list = e.getCoalescedEvents ? e.getCoalescedEvents() : [];
		if (!list.length) { list = [e]; }
		list.forEach(function (ev) {
			var p = pos(ev);
			if (mode === 'grid') {
				markLine(pt.x, pt.y, p.x, p.y);
			} else {
				ic.strokeStyle = pt.c;
				ic.lineWidth = 4 * dpr;
				ic.lineCap = 'round';
				ic.beginPath();
				ic.moveTo(pt.x, pt.y);
				ic.lineTo(p.x, p.y);
				ic.stroke();
			}
			pt.x = p.x;
			pt.y = p.y;
		});
		pt.size = Math.max(e.width || 0, e.height || 0);
	}

	function up(e) {
		if (!pointers[e.pointerId]) { return; }
		delete pointers[e.pointerId];
		if (!Object.keys(pointers).length) { slot = 0; }
		count();
	}

	// Rings and numbers under each finger, redrawn every frame while touching.
	function drawLive() {
		lc.clearRect(0, 0, w, h);
		var ids = Object.keys(pointers);
		ids.forEach(function (id) {
			var pt = pointers[id], r = Math.max(22, pt.size || 0) * dpr;
			lc.strokeStyle = pt.c;
			lc.lineWidth = 3 * dpr;
			lc.beginPath();
			lc.arc(pt.x, pt.y, r, 0, Math.PI * 2);
			lc.stroke();
			lc.fillStyle = pt.c;
			lc.font = '700 ' + (13 * dpr) + 'px system-ui, sans-serif';
			lc.textAlign = 'center';
			lc.fillText(String(pt.n), pt.x, pt.y - r - 6 * dpr);
		});
		raf = ids.length ? requestAnimationFrame(drawLive) : 0;
	}

	function clear() {
		ic.clearRect(0, 0, w, h);
		lc.clearRect(0, 0, w, h);
		maxTouches = 0;
		out.max.textContent = '0';
		if (mode === 'grid') { setupGrid(); U.status(statusEl, 'Swipe over every square until the whole grid is green.', ''); } else { U.status(statusEl, 'Cleared. Draw again with one or more fingers.', ''); }
	}

	function setMode(m) {
		mode = m;
		U.$$('[data-ts-mode]', root).forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-ts-mode') === m ? 'true' : 'false'); });
		$('#ts-gridsize').hidden = m !== 'grid';
		clear();
	}

	stage.addEventListener('pointerdown', down);
	stage.addEventListener('pointermove', move);
	stage.addEventListener('pointerup', up);
	stage.addEventListener('pointercancel', up);
	stage.addEventListener('lostpointercapture', up);
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });
	$('#ts-clear').addEventListener('click', clear);
	U.$$('[data-ts-mode]', root).forEach(function (b) { b.addEventListener('click', function () { setMode(b.getAttribute('data-ts-mode')); }); });
	U.$$('[data-ts-grid]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			gridSize = b.getAttribute('data-ts-grid');
			U.$$('[data-ts-grid]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
			setupGrid();
		});
	});
	window.addEventListener('resize', function () { resize(false); });
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) { document.addEventListener(ev, function () { setTimeout(function () { resize(false); }, 80); }); });
	root.addEventListener('tn:fullscreen', function () { setTimeout(function () { resize(false); }, 80); });

	resize(true);
}());
