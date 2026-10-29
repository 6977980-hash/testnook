/* Color vision test: a 15-cap hue arrangement test in the style of the Farnsworth D-15 (and the paler Lanthony D-15d).
   Caps are evenly spaced hues in CIELAB. The user places them in order after the fixed reference cap. Scoring counts
   major crossings (jumps of more than two caps), a colour difference confusion index, and picks the confusion type
   (protan, deutan, tritan) whose simulated view (Machado 2009) makes the user's order look the most natural. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="color-vision-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var row = $('#cv-row'), tray = $('#cv-tray'), statusEl = $('#cv-status'), scoreBtn = $('#cv-score'), result = $('#cv-result');
	var N = 15, mode = 'standard', caps = [], placed = [], trayOrder = [];

	var SIM = {
		protan: [[0.152286, 1.052583, -0.204868], [0.114503, 0.786281, 0.099216], [-0.003882, -0.048116, 1.051998]],
		deutan: [[0.367322, 0.860646, -0.227968], [0.280085, 0.672501, 0.047413], [-0.011820, 0.042940, 0.968881]],
		tritan: [[1.255528, -0.076749, -0.178779], [-0.078411, 0.930809, 0.147602], [0.004733, 0.691367, 0.303900]]
	};
	var NAMES = { protan: 'protan (red)', deutan: 'deutan (green)', tritan: 'tritan (blue-yellow)' };

	/* ---------- Colour maths ---------- */
	function labToLin(L, a, b) {
		var fy = (L + 16) / 116, fx = fy + a / 500, fz = fy - b / 200;
		function inv(f) { return f > 0.206893 ? f * f * f : (f - 16 / 116) / 7.787; }
		var X = 0.95047 * inv(fx), Y = inv(fy), Z = 1.08883 * inv(fz);
		return [
			Math.min(1, Math.max(0, 3.2406 * X - 1.5372 * Y - 0.4986 * Z)),
			Math.min(1, Math.max(0, -0.9689 * X + 1.8758 * Y + 0.0415 * Z)),
			Math.min(1, Math.max(0, 0.0557 * X - 0.2040 * Y + 1.0570 * Z))
		];
	}
	function linToLab(c) {
		var X = (0.4124 * c[0] + 0.3576 * c[1] + 0.1805 * c[2]) / 0.95047, Y = 0.2126 * c[0] + 0.7152 * c[1] + 0.0722 * c[2], Z = (0.0193 * c[0] + 0.1192 * c[1] + 0.9505 * c[2]) / 1.08883;
		function f(t) { return t > 0.008856 ? Math.cbrt(t) : 7.787 * t + 16 / 116; }
		return [116 * f(Y) - 16, 500 * (f(X) - f(Y)), 200 * (f(Y) - f(Z))];
	}
	function hex(c) {
		return '#' + c.map(function (v) {
			var s = Math.round(255 * (v <= 0.0031308 ? 12.92 * v : 1.055 * Math.pow(v, 1 / 2.4) - 0.055));
			return (s < 16 ? '0' : '') + s.toString(16);
		}).join('');
	}
	function mul(m, c) { return m.map(function (r) { return Math.min(1, Math.max(0, r[0] * c[0] + r[1] * c[1] + r[2] * c[2])); }); }
	function dE(a, b) { return Math.hypot(a[0] - b[0], a[1] - b[1], a[2] - b[2]); }

	function build() {
		var L = mode === 'standard' ? 60 : 72, C = mode === 'standard' ? 34 : 16;
		caps = [];
		for (var i = 0; i <= N; i++) {
			var h = (250 - i * 20) * Math.PI / 180;
			var lin = labToLin(L, C * Math.cos(h), C * Math.sin(h));
			var cap = { id: i, lin: lin, hex: hex(lin), lab: linToLab(lin), sim: {} };
			Object.keys(SIM).forEach(function (k) { cap.sim[k] = linToLab(mul(SIM[k], lin)); });
			caps.push(cap);
		}
	}

	/* ---------- UI ---------- */
	function capEl(cap, where) {
		var b = document.createElement('button');
		b.type = 'button';
		b.className = 'cv-cap';
		b.style.background = cap.hex;
		b.setAttribute('data-cap', cap.id);
		b.setAttribute('aria-label', where === 'row' ? 'Placed cap ' + (placed.indexOf(cap.id) + 1) + ', press to take it back' : 'Colour cap');
		return b;
	}

	function render() {
		row.innerHTML = '';
		var ref = capEl(caps[0], 'ref');
		ref.disabled = true;
		ref.classList.add('cv-ref');
		ref.setAttribute('aria-label', 'Reference cap');
		row.appendChild(ref);
		placed.forEach(function (id) { row.appendChild(capEl(caps[id], 'row')); });
		for (var i = placed.length; i < N; i++) {
			var slot = document.createElement('span');
			slot.className = 'cv-slot';
			row.appendChild(slot);
		}
		tray.innerHTML = '';
		trayOrder.forEach(function (id) {
			if (placed.indexOf(id) < 0) { tray.appendChild(capEl(caps[id], 'tray')); }
		});
		scoreBtn.disabled = placed.length < N;
		if (placed.length === 0) {
			U.status(statusEl, 'Pick the cap closest in colour to the reference cap on the left, then the one closest to that, and so on.', '');
		} else if (placed.length < N) {
			U.status(statusEl, placed.length + ' of ' + N + ' placed. Tap a placed cap to take it back.', '');
		} else {
			U.status(statusEl, 'All caps placed. Check the row from left to right, then press Score.', 'ok');
		}
	}

	function shuffle() {
		trayOrder = [];
		for (var i = 1; i <= N; i++) { trayOrder.push(i); }
		for (var j = trayOrder.length - 1; j > 0; j--) { var k = Math.floor(Math.random() * (j + 1)), t = trayOrder[j]; trayOrder[j] = trayOrder[k]; trayOrder[k] = t; }
	}

	function reset() {
		build();
		shuffle();
		placed = [];
		result.hidden = true;
		render();
	}

	tray.addEventListener('click', function (e) {
		var b = e.target.closest('[data-cap]');
		if (!b) { return; }
		placed.push(Number(b.getAttribute('data-cap')));
		result.hidden = true;
		render();
	});
	row.addEventListener('click', function (e) {
		var b = e.target.closest('[data-cap]');
		if (!b || b.disabled) { return; }
		placed.splice(placed.indexOf(Number(b.getAttribute('data-cap'))), 1);
		result.hidden = true;
		render();
	});
	$('#cv-undo').addEventListener('click', function () { placed.pop(); result.hidden = true; render(); });
	$('#cv-reset').addEventListener('click', reset);
	U.$$('[data-cv-mode]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			mode = b.getAttribute('data-cv-mode');
			U.$$('[data-cv-mode]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
			reset();
		});
	});

	/* ---------- Scoring ---------- */
	function path(order, key) {
		var seq = [0].concat(order), sum = 0;
		for (var i = 1; i < seq.length; i++) {
			var a = caps[seq[i - 1]], b = caps[seq[i]];
			sum += key ? dE(a.sim[key], b.sim[key]) : dE(a.lab, b.lab);
		}
		return sum;
	}

	function score(order) {
		var perfect = [];
		for (var i = 1; i <= N; i++) { perfect.push(i); }
		var seq = [0].concat(order), major = 0, minor = 0;
		for (var j = 1; j < seq.length; j++) {
			var gap = Math.abs(seq[j] - seq[j - 1]);
			if (gap > 2) { major++; } else if (gap === 2) { minor++; }
		}
		var ci = path(order) / path(perfect);
		var best = null, bestRatio = Infinity;
		Object.keys(SIM).forEach(function (k) {
			var r = path(order, k) / path(perfect, k);
			if (r < bestRatio) { bestRatio = r; best = k; }
		});
		return { major: major, minor: minor, ci: ci, type: best };
	}

	function diagram(order) {
		var size = 260, c = size / 2, R = 100, pts = caps.map(function (cap) {
			var a = Math.atan2(cap.lab[2], cap.lab[1]);
			return [c + R * Math.cos(a), c - R * Math.sin(a)];
		});
		var seq = [0].concat(order), lines = '', dots = '';
		for (var i = 1; i < seq.length; i++) {
			var p = pts[seq[i - 1]], q = pts[seq[i]], big = Math.abs(seq[i] - seq[i - 1]) > 2;
			lines += '<line x1="' + p[0].toFixed(1) + '" y1="' + p[1].toFixed(1) + '" x2="' + q[0].toFixed(1) + '" y2="' + q[1].toFixed(1) + '" class="' + (big ? 'cv-major' : 'cv-line') + '"/>';
		}
		caps.forEach(function (cap, i) {
			dots += '<circle cx="' + pts[i][0].toFixed(1) + '" cy="' + pts[i][1].toFixed(1) + '" r="9" fill="' + cap.hex + '"/><text x="' + pts[i][0].toFixed(1) + '" y="' + (pts[i][1] + 3.5).toFixed(1) + '">' + (i === 0 ? 'P' : i) + '</text>';
		});
		return '<svg class="cv-diagram" viewBox="0 0 ' + size + ' ' + size + '" role="img" aria-label="Your order drawn around the colour circle">' + lines + dots + '</svg>';
	}

	scoreBtn.addEventListener('click', function () {
		if (placed.length < N) { return; }
		var s = score(placed), head, body, cls;
		if (s.major === 0) {
			head = 'Normal colour arrangement';
			body = 'Your caps follow the colour circle with no major crossings' + (s.minor ? ' and ' + s.minor + ' small slip' + (s.minor > 1 ? 's' : '') + ', which is normal' : '') + '.';
			cls = 'is-ok';
		} else if (s.major === 1) {
			head = 'One major crossing';
			body = 'One jump across the circle is often a slip of attention. Press Reset and do it again slowly; if it repeats, mention it at your next eye test.';
			cls = 'is-warn';
		} else {
			head = 'Pattern of a ' + NAMES[s.type] + ' colour deficiency';
			body = s.major + ' major crossings, which is the pattern of a colour vision deficiency. Your order best matches the ' + NAMES[s.type] + ' confusion axis. An optometrist can confirm it.';
			cls = 'is-bad';
		}
		result.className = 'cv-result ' + cls;
		result.innerHTML = diagram(placed) + '<div><strong></strong><p></p><p class="cv-detail"></p></div>';
		result.querySelector('strong').textContent = head;
		result.querySelector('p').textContent = body;
		result.querySelector('.cv-detail').textContent = 'Your order: P, ' + placed.join(', ') + '. Major crossings: ' + s.major + '. Confusion index: ' + s.ci.toFixed(2) + ' (1.00 is a perfect order).';
		result.hidden = false;
		U.status(statusEl, head + '. Screening only, not a diagnosis.', cls === 'is-ok' ? 'ok' : '');
		root.setAttribute('data-cv-type', s.major >= 2 ? s.type : 'normal');
	});

	// Exposed for automated checks: the order a dichromat of the given type would make (nearest colour in their simulated view).
	root.cvSimulate = function (type) {
		var left = trayOrder.slice(), cur = 0, out = [];
		while (left.length) {
			var bi = 0, bd = Infinity;
			left.forEach(function (id, i) { var d = dE(caps[cur].sim[type], caps[id].sim[type]); if (d < bd) { bd = d; bi = i; } });
			cur = left.splice(bi, 1)[0];
			out.push(cur);
		}
		return out;
	};
	root.cvPlace = function (order) { placed = order.slice(); render(); };

	reset();
}());
