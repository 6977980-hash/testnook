/* Red-green colour blind test: dot plates drawn on a canvas, in the style of Ishihara plates but generated here.
   Figure and background differ only along a red-green direction picked from the Machado (2009) dichromat models,
   so the number is clear to normal colour vision and close to invisible for protans and deutans, while random
   dot lightness hides any brightness cue. Two classification plates use a protan-only and a deutan-only colour
   change, one per digit, which tells the two types apart. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="red-green-color-blind-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var canvas = $('#cb-plate'), ctx = canvas.getContext('2d'), answers = $('#cb-answers'), statusEl = $('#cb-status');
	var stepEl = $('#cb-step'), barEl = $('#cb-bar'), startBtn = $('#cb-start'), resultEl = $('#cb-result'), plateWrap = $('#cb-wrap');

	// Directions in linear RGB. vP is invisible to a protanope, vD to a deuteranope, vM sits between them.
	var vP = [0.98961, -0.14374, -0.00292], vD = [0.92205, -0.38602, 0.02836], vM = [0.96360, -0.26703, 0.01282];
	var C = [0.305, 0.305, 0.1144]; // sRGB 150,150,95: a neutral olive centre with room on both sides

	// kind: control (luminance, everyone sees it), screen (red-green), class (left digit protan-blind, right deutan-blind)
	var PLATES = [
		{ kind: 'control', n: '12' },
		{ kind: 'screen', n: '74', t: 0.15 },
		{ kind: 'screen', n: '6', t: 0.14 },
		{ kind: 'screen', n: '45', t: 0.13 },
		{ kind: 'screen', n: '29', t: 0.12 },
		{ kind: 'screen', n: '8', t: 0.11 },
		{ kind: 'screen', n: '57', t: 0.10 },
		{ kind: 'screen', n: '3', t: 0.09 },
		{ kind: 'screen', n: '15', t: 0.08 },
		{ kind: 'screen', n: '97', t: 0.07 },
		{ kind: 'class', n: '26', t: 0.45 },
		{ kind: 'class', n: '42', t: 0.45 }
	];
	var DISTRACT = ['1', '2', '3', '5', '6', '7', '8', '9', '16', '21', '35', '47', '70', '71', '13', '18', '61', '24'];

	var idx = -1, given = [], seed = 1;

	function rnd() { seed = (seed * 16807) % 2147483647; return (seed - 1) / 2147483646; }

	function toSrgb(l) {
		return Math.round(255 * (l <= 0.0031308 ? 12.92 * l : 1.055 * Math.pow(l, 1 / 2.4) - 0.055));
	}
	function colour(base, dir, t, k) {
		var out = [];
		for (var i = 0; i < 3; i++) { out.push(toSrgb(Math.min(1, Math.max(0, (base[i] + (dir ? dir[i] * t : 0)) * k)))); }
		return 'rgb(' + out.join(',') + ')';
	}

	// Digit masks: 0 = background, 1 = first digit (or whole number), 2 = second digit.
	function mask(n, size, split) {
		var m = document.createElement('canvas');
		m.width = m.height = size;
		var c = m.getContext('2d', { willReadFrequently: true });
		c.textAlign = 'center';
		c.textBaseline = 'middle';
		var fs = Math.round(size * (n.length > 1 ? 0.56 : 0.66));
		c.font = '900 ' + fs + 'px Arial, Helvetica, sans-serif';
		var w = c.measureText(n).width, x0 = size / 2 - w / 2;
		var data = [];
		for (var d = 0; d < n.length; d++) {
			c.clearRect(0, 0, size, size);
			c.fillStyle = '#000';
			var wPrev = c.measureText(n.slice(0, d)).width, wd = c.measureText(n[d]).width;
			c.fillText(n[d], x0 + wPrev + wd / 2, size / 2 + size * 0.03);
			data.push(c.getImageData(0, 0, size, size).data);
		}
		return function (x, y) {
			x = Math.round(x); y = Math.round(y);
			if (x < 0 || y < 0 || x >= size || y >= size) { return 0; }
			var o = (y * size + x) * 4 + 3;
			for (var i = 0; i < data.length; i++) { if (data[i][o] > 128) { return split ? i + 1 : 1; } }
			return 0;
		};
	}

	function draw(p) {
		var css = Math.min(plateWrap.clientWidth, 420), dpr = Math.min(window.devicePixelRatio || 1, 3);
		canvas.style.width = canvas.style.height = css + 'px';
		canvas.width = canvas.height = Math.round(css * dpr);
		var S = canvas.width, R = S / 2 - 2;
		ctx.clearRect(0, 0, S, S);
		var M = 400, scale = M / S, inside = mask(p.n, M, p.kind === 'class');
		seed = 7919 * (idx + 3);

		// Random dot packing with a coarse grid for overlap checks.
		var dots = [], cell = S / 20, grid = {};
		function key(gx, gy) { return gx + ',' + gy; }
		function free(x, y, r) {
			var gx = Math.floor(x / cell), gy = Math.floor(y / cell);
			for (var i = gx - 2; i <= gx + 2; i++) {
				for (var j = gy - 2; j <= gy + 2; j++) {
					var list = grid[key(i, j)];
					if (!list) { continue; }
					for (var k = 0; k < list.length; k++) {
						var d = list[k];
						if (Math.hypot(d.x - x, d.y - y) < d.r + r + S * 0.003) { return false; }
					}
				}
			}
			return true;
		}
		[0.026, 0.02, 0.015, 0.011, 0.0085, 0.0065].forEach(function (rf, pass) {
			var tries = [900, 1800, 3200, 5200, 7000, 8000][pass];
			for (var t = 0; t < tries; t++) {
				var r = S * rf * (0.85 + rnd() * 0.3);
				var a = rnd() * Math.PI * 2, dist = Math.sqrt(rnd()) * (R - r);
				var x = S / 2 + Math.cos(a) * dist, y = S / 2 + Math.sin(a) * dist;
				if (!free(x, y, r)) { continue; }
				var d = { x: x, y: y, r: r };
				dots.push(d);
				var gk = key(Math.floor(x / cell), Math.floor(y / cell));
				(grid[gk] = grid[gk] || []).push(d);
			}
		});

		dots.forEach(function (d) {
			var m = inside(d.x * scale, d.y * scale);
			var k = 0.72 + rnd() * 0.5, tj = p.t * (0.85 + rnd() * 0.3), fill;
			if (p.kind === 'control') {
				fill = m ? colour([0.42, 0.16, 0.08], null, 0, k * 0.8) : colour(C, null, 0, k * 1.15);
			} else if (p.kind === 'screen') {
				fill = colour(C, vM, m ? tj : -tj, k);
			} else {
				fill = m === 1 ? colour(C, vP, tj, k) : m === 2 ? colour(C, vD, tj, k) : colour(C, null, 0, k);
			}
			ctx.beginPath();
			ctx.arc(d.x, d.y, d.r, 0, Math.PI * 2);
			ctx.fillStyle = fill;
			ctx.fill();
		});
	}

	function options(p) {
		var set = [p.n];
		if (p.kind === 'class') { set.push(p.n[1], p.n[0]); }
		while (set.length < 4) {
			var c = DISTRACT[Math.floor(rnd() * DISTRACT.length)];
			if (set.indexOf(c) < 0 && c.length === p.n.length) { set.push(c); }
		}
		for (var i = set.length - 1; i > 0; i--) { var j = Math.floor(rnd() * (i + 1)), tmp = set[i]; set[i] = set[j]; set[j] = tmp; }
		set.push('nothing');
		return set;
	}

	function show() {
		var p = PLATES[idx];
		draw(p);
		answers.innerHTML = '';
		options(p).forEach(function (o) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'btn' + (o === 'nothing' ? ' cb-none' : '');
			b.textContent = o === 'nothing' ? 'I see no number' : o;
			b.setAttribute('data-cb', o);
			answers.appendChild(b);
		});
		stepEl.textContent = 'Plate ' + (idx + 1) + ' of ' + PLATES.length;
		barEl.style.width = (idx / PLATES.length * 100) + '%';
		U.status(statusEl, 'What number do you see? If you are not sure, choose "I see no number" rather than guess.', '');
	}

	function start() {
		idx = 0;
		given = [];
		resultEl.hidden = true;
		root.classList.add('is-running');
		startBtn.textContent = 'Restart';
		show();
	}

	answers.addEventListener('click', function (e) {
		var b = e.target.closest('[data-cb]');
		if (!b || idx < 0) { return; }
		given.push(b.getAttribute('data-cb'));
		idx++;
		if (idx < PLATES.length) { show(); } else { finish(); }
	});

	function finish() {
		root.classList.remove('is-running');
		barEl.style.width = '100%';
		stepEl.textContent = 'Done';
		answers.innerHTML = '';
		var miss = 0, prot = 0, deut = 0, both = 0;
		PLATES.forEach(function (p, i) {
			var a = given[i];
			if (p.kind === 'screen' && a !== p.n) { miss++; }
			if (p.kind === 'class') {
				if (a === p.n) { both++; } else if (a === p.n[1]) { prot++; } else if (a === p.n[0]) { deut++; }
			}
		});
		var control = given[0] === PLATES[0].n;
		var screens = PLATES.filter(function (p) { return p.kind === 'screen'; }).length;
		var head, body, cls = '';
		if (!control) {
			head = 'Result unclear';
			body = 'The first plate is one everybody should read. Check that screen brightness is up, Night Light, True Tone and blue light filters are off, and try again.';
		} else if (miss <= 1 && both === 2) {
			head = 'No sign of red-green colour blindness';
			body = 'You read ' + (screens - miss) + ' of ' + screens + ' red-green plates and both two-digit plates. This is the pattern of normal red-green colour vision.';
			cls = 'is-ok';
		} else if (miss <= 3 && prot + deut <= 1) {
			head = 'Possible mild red-green weakness';
			body = 'You missed ' + miss + ' of ' + screens + ' red-green plates, mostly the faint ones. That can be a mild colour weakness, or just your screen. Repeat on another screen and see an optometrist if it shows again.';
			cls = 'is-warn';
		} else {
			var type = prot > deut ? 'protan (red-weak) type' : deut > prot ? 'deutan (green-weak) type' : 'red-green type, protan or deutan unclear';
			head = 'Signs of red-green colour blindness';
			body = 'You missed ' + miss + ' of ' + screens + ' red-green plates. The two-digit plates point to a ' + type + '. Only an optometrist\'s test can confirm it.';
			cls = 'is-bad';
		}
		resultEl.className = 'cb-result ' + cls;
		resultEl.innerHTML = '<strong></strong><p></p><p class="cb-detail"></p>';
		resultEl.querySelector('strong').textContent = head;
		resultEl.querySelector('p').textContent = body;
		resultEl.querySelector('.cb-detail').textContent = 'Your answers: ' + PLATES.map(function (p, i) { return p.n + ' -> ' + (given[i] === 'nothing' ? 'none' : given[i]); }).join(', ');
		resultEl.hidden = false;
		U.status(statusEl, head + '. This is a screening only, not a diagnosis.', cls === 'is-ok' ? 'ok' : '');
	}

	startBtn.addEventListener('click', start);
	var lastW = 0;
	window.addEventListener('resize', function () {
		if (idx >= 0 && idx < PLATES.length && Math.abs(plateWrap.clientWidth - lastW) > 20) { lastW = plateWrap.clientWidth; draw(PLATES[idx]); }
	});

	// Draw a sample plate (not scored) so the stage is not empty before the test.
	idx = 0;
	draw(PLATES[0]);
	idx = -1;
}());
