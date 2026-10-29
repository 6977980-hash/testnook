/* Stick drift test: live stick positions with trails, adjustable dead zone ring, a timed resting drift check with tiers and a suggested dead zone, and an outer range trace with a circularity error. */
(function () {
	'use strict';
	// Serves the stick drift and Joy-Con drift pages: any page with the #sd-c0 canvas.
	var first = document.getElementById('sd-c0');
	var root = first && first.closest('[data-tool]');
	if (!root) { return; }
	var joycon = root.hasAttribute('data-sd-joycon') || !!root.querySelector('[data-sd-joycon]');
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#sd-status'), padSel = $('#sd-pad'), dzIn = $('#sd-dz'), dzOut = $('#sd-dzout'), checkBtn = $('#sd-check'), resetBtn = $('#sd-reset');
	var dpr = Math.min(2, window.devicePixelRatio || 1);
	var BINS = 72;
	var sticks = [0, 1].map(function (i) {
		var c = $('#sd-c' + i);
		return {
			canvas: c, g: c.getContext('2d'), x: 0, y: 0, trail: [], edge: new Float32Array(BINS),
			out: { x: $('#sd-x' + i), y: $('#sd-y' + i), d: $('#sd-d' + i), rest: $('#sd-rest' + i), range: $('#sd-range' + i), circ: $('#sd-circ' + i), dz: $('#sd-dzs' + i) }
		};
	});
	var padIndex = -1, check = null, deadzone = 0.1, tiers = $('#sd-tiers');
	// Upper bound of each drift tier (share of full tilt): excellent, normal, noticeable, needs attention.
	var TIERS = [0.01, 0.05, 0.10, Infinity], TIER_NAMES = ['Excellent', 'Normal', 'Noticeable', 'Needs attention'];
	function tierOf(m) { for (var i = 0; i < TIERS.length; i++) { if (m <= TIERS[i]) { return i; } } return 3; }
	var css = getComputedStyle(root);
	function colour(n) { return css.getPropertyValue(n).trim(); }

	function pads() {
		var list = navigator.getGamepads ? navigator.getGamepads() : [];
		return Array.prototype.filter.call(list || [], function (p) { return p && p.connected !== false; });
	}

	function refreshList() {
		var list = pads();
		padSel.innerHTML = '';
		list.forEach(function (p) {
			var o = document.createElement('option');
			o.value = p.index;
			o.textContent = shortName(p.id);
			padSel.appendChild(o);
		});
		padSel.hidden = list.length < 2;
		if (!list.some(function (p) { return p.index === padIndex; })) { padIndex = list.length ? list[0].index : -1; }
		padSel.value = String(padIndex);
		checkBtn.disabled = padIndex < 0;
		if (padIndex < 0) {
			U.status(statusEl, 'No controller found yet. Connect it by USB or Bluetooth, then press any button on it.', '');
		} else if (!check) {
			var cur = list.filter(function (p) { return p.index === padIndex; })[0];
			U.status(statusEl, 'Connected: ' + shortName(cur.id) + '. Leave the sticks alone and press Check drift.', 'ok');
			if (joycon) { joyconNote(cur); }
		}
	}

	// Joy-Con page: name the circles after the connected Joy-Con and warn when the browser reads it without analogue sticks.
	function joyconNote(p) {
		var id = String(p.id), h0 = $('#sd-h0'), h1 = $('#sd-h1'), isJc = /joy-?con|057e/i.test(id);
		if (!h0 || !h1) { return; }
		if (/\(L\)/.test(id) && !/L\+R/.test(id)) { h0.textContent = 'Joy-Con (L) stick'; h1.textContent = 'Not used'; }
		else if (/\(R\)/.test(id) && !/L\+R/.test(id)) { h0.textContent = 'Joy-Con (R) stick'; h1.textContent = 'Not used'; }
		else { h0.textContent = 'Left stick'; h1.textContent = 'Right stick'; }
		if (isJc && p.mapping !== 'standard') {
			U.status(statusEl, 'This browser reads the Joy-Con as a basic device, so its stick may only report 8 directions and drift cannot be measured. Open the page in Chrome or Edge.', 'bad');
		}
	}

	function shortName(id) { return String(id || 'Controller').replace(/\s*\((STANDARD GAMEPAD\s*)?Vendor:.*$/i, '').slice(0, 60); }

	function size(s) {
		var w = Math.round(s.canvas.clientWidth * dpr);
		if (s.canvas.width !== w) { s.canvas.width = s.canvas.height = w; }
	}

	function draw(s) {
		size(s);
		var g = s.g, w = s.canvas.width, c = w / 2, r = w / 2 - 8 * dpr;
		g.clearRect(0, 0, w, w);
		g.fillStyle = colour('--surface');
		g.beginPath(); g.arc(c, c, r, 0, Math.PI * 2); g.fill();
		g.strokeStyle = colour('--border');
		g.lineWidth = 1 * dpr;
		g.beginPath(); g.arc(c, c, r, 0, Math.PI * 2); g.moveTo(c - r, c); g.lineTo(c + r, c); g.moveTo(c, c - r); g.lineTo(c, c + r); g.stroke();
		// Dead zone ring.
		g.fillStyle = 'rgba(180, 83, 9, .12)';
		g.strokeStyle = colour('--warn');
		g.setLineDash([4 * dpr, 4 * dpr]);
		g.beginPath(); g.arc(c, c, r * deadzone, 0, Math.PI * 2); g.fill(); g.stroke();
		g.setLineDash([]);
		// Outer range trace.
		var any = false;
		g.strokeStyle = colour('--ok');
		g.lineWidth = 2 * dpr;
		g.beginPath();
		for (var b = 0; b <= BINS; b++) {
			var e = s.edge[b % BINS];
			if (!e) { any = false; continue; }
			var a = (b % BINS) / BINS * Math.PI * 2, px = c + Math.cos(a) * e * r, py = c + Math.sin(a) * e * r;
			if (any) { g.lineTo(px, py); } else { g.moveTo(px, py); }
			any = true;
		}
		g.stroke();
		// Trail.
		g.strokeStyle = colour('--brand');
		g.globalAlpha = 0.35;
		g.beginPath();
		s.trail.forEach(function (p, i) { var px = c + p[0] * r, py = c + p[1] * r; if (i) { g.lineTo(px, py); } else { g.moveTo(px, py); } });
		g.stroke();
		g.globalAlpha = 1;
		// Current position.
		g.fillStyle = Math.hypot(s.x, s.y) > deadzone ? colour('--brand') : colour('--muted');
		g.beginPath(); g.arc(c + s.x * r, c + s.y * r, 8 * dpr, 0, Math.PI * 2); g.fill();
	}

	function update(s, x, y) {
		s.x = x; s.y = y;
		var d = Math.min(1.5, Math.hypot(x, y));
		s.out.x.textContent = U.fmt(x, 3);
		s.out.y.textContent = U.fmt(y, 3);
		s.out.d.textContent = Math.round(d * 100) + '%';
		s.trail.push([x, y]);
		if (s.trail.length > 60) { s.trail.shift(); }
		if (d > 0.5) {
			var bin = Math.floor(((Math.atan2(y, x) + Math.PI * 2) % (Math.PI * 2)) / (Math.PI * 2) * BINS) % BINS;
			if (d > s.edge[bin]) { s.edge[bin] = Math.min(d, 1.3); }
			var filled = 0, sum = 0;
			for (var i = 0; i < BINS; i++) { if (s.edge[i]) { filled++; sum += s.edge[i]; } }
			if (filled > BINS * 0.6) { s.out.range.textContent = Math.round(sum / filled * 100) + '%'; }
			if (s.out.circ) {
				if (filled >= BINS * 0.9) {
					// Circularity error: average gap between the traced edge and the ideal circle at full tilt.
					var err = 0;
					for (var j = 0; j < BINS; j++) { if (s.edge[j]) { err += Math.abs(s.edge[j] - 1); } }
					s.out.circ.textContent = U.fmt(err / filled * 100, 1) + '%';
				} else {
					s.out.circ.textContent = 'Rotate ' + Math.round(filled / BINS * 100) + '%';
				}
			}
		}
	}

	function runCheck(now) {
		if (!check) { return; }
		var t = now - check.start;
		if (t < 3000) {
			U.status(statusEl, 'Let go of both sticks... measuring starts in ' + Math.ceil((3000 - t) / 1000) + ' s.', '');
			return;
		}
		if (t < 6000) {
			sticks.forEach(function (s, i) { var d = Math.hypot(s.x, s.y); check.max[i] = Math.max(check.max[i], d); check.sum[i] += d; });
			check.n++;
			U.status(statusEl, 'Measuring resting position... ' + Math.ceil((6000 - t) / 1000) + ' s. Do not touch the sticks.', '');
			return;
		}
		var worst = 0;
		sticks.forEach(function (s, i) {
			var m = check.max[i];
			worst = Math.max(worst, m);
			s.out.rest.textContent = U.fmt(m * 100, 1) + '%';
			s.out.rest.className = 'stat-value ' + ['sd-good', 'sd-good', 'sd-warn', 'sd-bad'][tierOf(m)];
			if (s.out.dz) { s.out.dz.textContent = suggestDz(m) + '%'; }
		});
		var tier = tierOf(worst), pct = U.fmt(worst * 100, 1), dz = suggestDz(worst);
		var msg = tier === 0 ? 'Excellent: both sticks rest within ' + pct + '% of center. No drift at all.' :
			tier === 1 ? 'Normal: the worst stick rests ' + pct + '% off center, ordinary sensor noise. Default dead zones hide it.' :
			tier === 2 ? 'Noticeable drift (' + pct + '% off center at rest). A dead zone of about ' + dz + '% in your game settings hides it.' :
			'Drift needs attention (' + pct + '% off center at rest). Try the fixes below; a dead zone of ' + dz + '% would be needed to hide it.';
		U.status(statusEl, msg, tier < 2 ? 'ok' : 'bad');
		markTier(tier);
		deadzone = dz / 100; dzIn.value = dz; dzOut.textContent = dz + '%';
		checkBtn.disabled = false;
		check = null;
	}

	// Smallest whole-percent dead zone that hides the resting offset, with a 2% margin.
	function suggestDz(m) { return Math.min(30, Math.ceil(m * 100) + 2); }

	function markTier(t) {
		if (!tiers) { return; }
		U.$$('[data-sd-tier]', tiers).forEach(function (row) {
			var on = Number(row.getAttribute('data-sd-tier')) === t;
			row.classList.toggle('is-hit', on);
			if (on) { row.setAttribute('aria-current', 'true'); } else { row.removeAttribute('aria-current'); }
		});
		tiers.setAttribute('data-sd-verdict', t < 0 ? '' : TIER_NAMES[t]);
	}

	function loop(now) {
		requestAnimationFrame(loop);
		var p = padIndex >= 0 ? (navigator.getGamepads() || [])[padIndex] : null;
		if (p && p.axes.length >= 2) {
			update(sticks[0], p.axes[0] || 0, p.axes[1] || 0);
			if (p.axes.length >= 4) { update(sticks[1], p.axes[2] || 0, p.axes[3] || 0); }
		}
		runCheck(now);
		sticks.forEach(draw);
	}

	function reset() {
		sticks.forEach(function (s) {
			s.trail = []; s.edge = new Float32Array(BINS);
			s.out.rest.textContent = s.out.range.textContent = '-';
			if (s.out.circ) { s.out.circ.textContent = '-'; }
			if (s.out.dz) { s.out.dz.textContent = '-'; }
			s.out.rest.className = 'stat-value';
		});
		check = null;
		markTier(-1);
		refreshList();
	}

	if (!('getGamepads' in navigator)) {
		U.status(statusEl, 'This browser does not support controllers. Use an up-to-date Chrome, Edge, Firefox or Safari.', 'bad');
		checkBtn.disabled = true;
		return;
	}

	window.addEventListener('gamepadconnected', refreshList);
	window.addEventListener('gamepaddisconnected', refreshList);
	padSel.addEventListener('change', function () { padIndex = Number(padSel.value); reset(); });
	dzIn.addEventListener('input', function () { deadzone = dzIn.value / 100; dzOut.textContent = dzIn.value + '%'; });
	checkBtn.addEventListener('click', function () {
		check = { start: performance.now(), max: [0, 0], sum: [0, 0], n: 0 };
		checkBtn.disabled = true;
	});
	resetBtn.addEventListener('click', reset);
	refreshList();
	requestAnimationFrame(loop);
}());
