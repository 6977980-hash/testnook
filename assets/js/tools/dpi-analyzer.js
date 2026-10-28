/* DPI analyzer: pointer lock (raw movement where supported) counts movementX over a user-stated physical distance -> counts per inch; averages runs. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="dpi-analyzer"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#dpi-stage'), big = $('#dpi-big'), small = $('#dpi-small'), fill = $('#dpi-fill'), dot = $('#dpi-dot'), live = $('#dpi-live');
	var distIn = $('#dpi-dist'), setIn = $('#dpi-set'), resEl = $('#dpi-result'), countsEl = $('#dpi-counts'), devEl = $('#dpi-dev'), runsEl = $('#dpi-runs');
	var statusEl = $('#dpi-status'), modeEl = $('#dpi-mode');
	var unitSel = U.$$('[data-dpi-unit]', root);

	var unit = 'cm', counts = 0, locked = false, measuring = false, runs = [], raw = false, fallbackMoves = 0, lastX = 0;

	function inches() {
		var d = parseFloat(distIn.value) || 5;
		return unit === 'cm' ? d / 2.54 : d;
	}

	function expected() { return Math.round(inches() * (Number(setIn.value) || 800)); }

	function paint() {
		var exp = expected();
		var p = Math.min(1, Math.abs(counts) / Math.max(exp, 1));
		fill.style.width = (p * 100) + '%';
		dot.style.left = (p * 100) + '%';
		live.textContent = counts + ' counts';
	}

	function begin() {
		counts = 0;
		measuring = true;
		stage.classList.add('is-measuring');
		big.textContent = 'Move the mouse ' + distIn.value + ' ' + unit + ' to the right';
		small.textContent = 'Then press Space or click to finish. Esc cancels.';
		paint();
		U.status(statusEl, 'Measuring. Move slowly in a straight line, then press Space.', '');
	}

	function finish() {
		if (!measuring) { return; }
		measuring = false;
		stage.classList.remove('is-measuring');
		var dpi = Math.abs(counts) / inches();
		if (Math.abs(counts) < 20) {
			U.status(statusEl, 'Hardly any movement was counted. Click the box and move the mouse before pressing Space.', 'bad');
			release();
			return;
		}
		runs.push(dpi);
		if (runs.length > 5) { runs.shift(); }
		var avg = runs.reduce(function (a, b) { return a + b; }, 0) / runs.length;
		resEl.textContent = Math.round(avg);
		countsEl.textContent = Math.abs(counts);
		runsEl.textContent = runs.length;
		var set = Number(setIn.value);
		var msg = 'Run ' + runs.length + ': ' + Math.abs(counts) + ' counts over ' + distIn.value + ' ' + unit + ' = ' + Math.round(dpi) + ' DPI.';
		if (set) {
			var dev = (avg - set) / set * 100;
			devEl.textContent = (dev > 0 ? '+' : '') + dev.toFixed(1) + '%';
			devEl.style.color = Math.abs(dev) <= 5 ? 'var(--ok)' : (Math.abs(dev) <= 12 ? 'var(--warn)' : 'var(--bad)');
			msg += ' Average ' + Math.round(avg) + ' DPI, ' + (Math.abs(dev) <= 5 ? 'within normal tolerance' : Math.abs(dev) <= 12 ? 'a noticeable deviation' : 'far from the set value: check pointer speed and acceleration') + '.';
		} else {
			devEl.textContent = '-';
			msg += ' Average ' + Math.round(avg) + ' DPI over ' + runs.length + ' run' + (runs.length > 1 ? 's' : '') + '.';
		}
		U.status(statusEl, msg, set && Math.abs((avg - set) / set) > 0.12 ? 'bad' : 'ok');
		big.textContent = Math.round(avg) + ' DPI';
		small.textContent = 'Click to measure again (runs are averaged).';
		release();
	}

	function release() {
		if (document.pointerLockElement === stage && document.exitPointerLock) { document.exitPointerLock(); }
	}

	function lock() {
		if (!stage.requestPointerLock) { startFallback(); return; }
		var p;
		try { p = stage.requestPointerLock({ unadjustedMovement: true }); } catch (e) { p = null; }
		if (p && p.then) {
			p.then(function () { raw = true; }).catch(function () {
				raw = false;
				try { var q = stage.requestPointerLock(); if (q && q.catch) { q.catch(startFallback); } } catch (e) { startFallback(); }
			});
		} else if (p === undefined) {
			// Older API returns undefined and fires pointerlockchange / pointerlockerror.
			raw = false;
		}
	}

	function startFallback() {
		// No pointer lock: measure with plain mouse movement inside the stage.
		fallbackMoves = 0;
		modeEl.textContent = 'Mode: standard movement (set Windows pointer speed to 6/11, no acceleration).';
		begin();
	}

	document.addEventListener('pointerlockchange', function () {
		locked = document.pointerLockElement === stage;
		if (locked) {
			modeEl.textContent = raw ? 'Mode: raw input (pointer speed and acceleration ignored).' : 'Mode: pointer lock (set Windows pointer speed to 6/11, no acceleration).';
			begin();
		} else if (measuring) {
			// Esc released the lock mid-run.
			measuring = false;
			stage.classList.remove('is-measuring');
			big.textContent = 'Click here to start';
			small.textContent = 'The run was cancelled.';
			U.status(statusEl, 'Pointer released. Click the box to start a new run.', '');
		}
	});
	document.addEventListener('pointerlockerror', function () { startFallback(); });

	stage.addEventListener('mousemove', function (e) {
		if (!measuring) { return; }
		counts += e.movementX || 0;
		paint();
	});
	stage.addEventListener('mousedown', function (e) {
		if (e.button !== 0) { return; }
		if (measuring) { finish(); return; }
		lock();
	});
	stage.addEventListener('keydown', function (e) {
		if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); if (measuring) { finish(); } else { lock(); } }
	});
	document.addEventListener('keydown', function (e) {
		if (measuring && (e.key === ' ' || e.key === 'Enter') && document.activeElement !== stage) { e.preventDefault(); finish(); }
	});
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });

	unitSel.forEach(function (b) {
		b.addEventListener('click', function () {
			var next = b.getAttribute('data-dpi-unit');
			if (next !== unit) {
				var d = parseFloat(distIn.value) || 5;
				distIn.value = next === 'cm' ? Math.round(d * 2.54 * 2) / 2 : Math.round(d / 2.54 * 2) / 2;
			}
			unit = next;
			unitSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
		});
	});

	function reset() {
		measuring = false; runs = []; counts = 0;
		release();
		stage.classList.remove('is-measuring');
		resEl.textContent = devEl.textContent = '-';
		devEl.style.color = '';
		countsEl.textContent = runsEl.textContent = '0';
		big.textContent = 'Click here to start';
		small.textContent = 'Line the mouse up with a mark on a ruler or the edge of your mouse pad first.';
		paint();
		U.status(statusEl, 'Place a ruler next to your mouse, or use the edge of the mouse pad as the start line.', '');
	}
	$('#dpi-reset').addEventListener('click', reset);
	paint();
}());
