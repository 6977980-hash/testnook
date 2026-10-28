/* Scroll test: counts wheel notches up and down, flags wrong-way scrolls (a notch that reverses direction mid-scroll) and double steps, shows deltaY per notch and a moving strip. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="scroll-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#sc-stage'), strip = $('#sc-strip'), log = $('#sc-log'), resetBtn = $('#sc-reset'), statusEl = $('#sc-status');
	var arrows = { up: $('#sc-up'), down: $('#sc-down') };
	var out = { up: $('#sc-upc'), down: $('#sc-downc'), flips: $('#sc-flips'), skips: $('#sc-skips'), delta: $('#sc-delta'), rate: $('#sc-rate'), mode: $('#sc-mode') };
	var FLIP_MS = 150;   // a lone opposite notch within this gap, between two same-direction notches, is a wrong-way scroll
	var counts = { up: 0, down: 0 }, flips = 0, skips = 0, offset = 0, step = 0, deltas = [], recent = [], stamps = [], flashT = { up: 0, down: 0 };

	function flash(dir) {
		arrows[dir].classList.add('is-down');
		clearTimeout(flashT[dir]);
		flashT[dir] = setTimeout(function () { arrows[dir].classList.remove('is-down'); }, 120);
	}

	function modeName(m) { return m === 1 ? 'lines' : m === 2 ? 'pages' : 'pixels'; }

	function onWheel(e) {
		e.preventDefault();
		if (!e.deltaY) { return; }
		var dir = e.deltaY < 0 ? 'up' : 'down', mag = Math.abs(e.deltaY), now = performance.now();
		counts[dir]++;
		flash(dir);
		out[dir].textContent = counts[dir];
		out.mode.textContent = modeName(e.deltaMode);

		// Notch size: the most common magnitude so far (smooth-scrolling mice send many small deltas, which the median absorbs).
		deltas.push(mag);
		if (deltas.length > 200) { deltas.shift(); }
		var sorted = deltas.slice().sort(function (a, b) { return a - b; });
		step = sorted[sorted.length >> 1];
		out.delta.textContent = (dir === 'up' ? '-' : '+') + Math.round(mag) + (step ? ' (notch ≈ ' + Math.round(step) + ')' : '');

		// A single notch that is 2x or more the usual size is a skipped step on a stepped wheel.
		var skipped = step && deltas.length > 5 && mag >= step * 1.9 && e.deltaMode === 0 && step >= 20;
		if (skipped) { skips++; out.skips.textContent = skips; }

		// Wrong-way detection: direction A, then B within FLIP_MS, then A again within FLIP_MS.
		recent.push({ d: dir, t: now });
		if (recent.length > 3) { recent.shift(); }
		var flipped = false;
		if (recent.length === 3 && recent[0].d === recent[2].d && recent[1].d !== recent[0].d && recent[2].t - recent[0].t < FLIP_MS * 2) {
			flips++;
			out.flips.textContent = flips;
			flipped = true;
			recent = [recent[2]];
		}

		stamps.push(now);
		while (stamps.length && now - stamps[0] > 1000) { stamps.shift(); }
		out.rate.textContent = stamps.length + '/s';

		offset += e.deltaMode === 0 ? e.deltaY : e.deltaY * (e.deltaMode === 1 ? 20 : 300);
		strip.style.backgroundPositionY = (-offset) + 'px';

		var row = document.createElement('span');
		row.className = 'sc-row ' + (flipped ? 'is-flip' : skipped ? 'is-skip' : dir === 'up' ? 'is-up' : 'is-down');
		row.textContent = (dir === 'up' ? '▲' : '▼') + Math.round(mag) + (flipped ? ' wrong way' : skipped ? ' double' : '');
		log.insertBefore(row, log.firstChild);
		while (log.children.length > 40) { log.removeChild(log.lastChild); }

		var total = counts.up + counts.down;
		if (flips) {
			U.status(statusEl, total + ' notches, ' + flips + ' wrong-way scroll' + (flips > 1 ? 's' : '') + ' found. Keep scrolling slowly in one direction to confirm the fault.', 'bad');
		} else if (skips) {
			U.status(statusEl, total + ' notches, ' + skips + ' double step' + (skips > 1 ? 's' : '') + '. Scroll one click at a time to check if the wheel skips.', '');
		} else {
			U.status(statusEl, total + ' notches, no wrong-way scrolls or skipped steps so far.', 'ok');
		}
	}

	function reset() {
		counts = { up: 0, down: 0 }; flips = 0; skips = 0; offset = 0; deltas = []; recent = []; stamps = [];
		Object.keys(out).forEach(function (k) { out[k].textContent = k === 'mode' ? '-' : '0'; });
		out.delta.textContent = '-'; out.rate.textContent = '0/s';
		log.innerHTML = '';
		strip.style.backgroundPositionY = '0px';
		U.status(statusEl, 'Reset. Scroll the wheel inside the box.', '');
	}

	stage.addEventListener('wheel', onWheel, { passive: false });
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });
	stage.addEventListener('auxclick', function (e) { e.preventDefault(); });
	stage.addEventListener('mousedown', function (e) { if (e.button === 1) { e.preventDefault(); } }); // no autoscroll
	resetBtn.addEventListener('click', reset);
	if (U.isTouch() && !U.hasFinePointer()) {
		U.status(statusEl, 'This test needs a mouse wheel. Finger scrolling on a touch screen is not sent as wheel events.', 'bad');
	}
}());
