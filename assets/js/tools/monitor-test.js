/* Monitor test patterns: a full-screen canvas viewer shared by the monitor, LCD, OLED, display, colour and calibration pages.
   Each page lists its patterns as .mt-pat buttons (data-mt = pattern id, data-tip = what to look for); this file draws them by id. */
(function () {
	'use strict';
	var grid = document.getElementById('mt-grid');
	var root = grid && grid.closest('[data-tool]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var screenEl = $('#mt-screen'), canvas = $('#mt-canvas'), g = canvas.getContext('2d');
	var tip = $('#mt-tip'), tipName = $('#mt-tip-name'), tipText = $('#mt-tip-text'), nav = $('#mt-nav'), tipsBox = $('#mt-tips'), statusEl = $('#mt-status');
	var items = U.$$('.mt-pat', root);
	var idx = 0, active = false, raf = 0, hideTimer = 0, seen = {};

	function rgb(r, gg, b) { return 'rgb(' + r + ',' + gg + ',' + b + ')'; }
	function grey(v) { return rgb(v, v, v); }
	function fill(c, W, H) { g.fillStyle = c; g.fillRect(0, 0, W, H); }
	function text(t, x, y, size, colour, align) {
		g.font = '600 ' + Math.round(size) + 'px system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif';
		g.fillStyle = colour;
		g.textAlign = align || 'center';
		g.textBaseline = 'middle';
		g.fillText(t, x, y);
	}
	// Columns of exact levels (no browser gradient dithering): fn(i) -> colour for i in 0..n-1.
	function ramp(x, y, w, h, n, fn) {
		for (var i = 0; i < n; i++) {
			var x0 = Math.round(x + i * w / n), x1 = Math.round(x + (i + 1) * w / n);
			g.fillStyle = fn(i);
			g.fillRect(x0, y, x1 - x0, h);
		}
	}
	// A pattern made of single device pixels: cell(x, y) -> [r, g, b], repeated as a tile.
	function pixelPattern(size, cell) {
		var c = document.createElement('canvas');
		c.width = c.height = size;
		var cg = c.getContext('2d'), img = cg.createImageData(size, size);
		for (var y = 0; y < size; y++) {
			for (var x = 0; x < size; x++) {
				var p = cell(x, y), o = (y * size + x) * 4;
				img.data[o] = p[0]; img.data[o + 1] = p[1]; img.data[o + 2] = p[2]; img.data[o + 3] = 255;
			}
		}
		cg.putImageData(img, 0, 0);
		return g.createPattern(c, 'repeat');
	}
	function patches(values, bg, W, H, s, labelColour) {
		fill(grey(bg), W, H);
		var cols = 8, rows = Math.ceil(values.length / cols);
		var size = Math.min(W * 0.9 / (cols + (cols - 1) * 0.18), H * 0.8 / (rows * 1.6));
		var gap = size * 0.18, total = cols * size + (cols - 1) * gap, x0 = (W - total) / 2, y0 = (H - rows * size * 1.6) / 2;
		values.forEach(function (v, i) {
			var c = i % cols, r = Math.floor(i / cols), x = x0 + c * (size + gap), y = y0 + r * size * 1.6;
			g.fillStyle = grey(v);
			g.fillRect(Math.round(x), Math.round(y), Math.round(size), Math.round(size));
			text(String(v), x + size / 2, y + size * 1.22, Math.max(9, size * 0.2), labelColour);
		});
	}

	var CHECKER = [
		[115, 82, 68], [194, 150, 130], [98, 122, 157], [87, 108, 67], [133, 128, 177], [103, 189, 170],
		[214, 126, 44], [80, 91, 166], [193, 90, 99], [94, 60, 108], [157, 188, 64], [224, 163, 46],
		[56, 61, 150], [70, 148, 73], [175, 54, 60], [231, 199, 31], [187, 86, 149], [8, 133, 161],
		[243, 243, 242], [200, 200, 200], [160, 160, 160], [122, 122, 121], [85, 85, 85], [52, 52, 52]
	];

	// Each pattern: function (W, H, s, t) where s = device pixels per CSS pixel and t = time in ms (animated ones only).
	var P = {
		black: function (W, H) { fill('#000', W, H); },
		white: function (W, H) { fill('#fff', W, H); },
		red: function (W, H) { fill('#f00', W, H); },
		green: function (W, H) { fill('#0f0', W, H); },
		blue: function (W, H) { fill('#00f', W, H); },
		cyan: function (W, H) { fill('#0ff', W, H); },
		magenta: function (W, H) { fill('#f0f', W, H); },
		yellow: function (W, H) { fill('#ff0', W, H); },
		grey50: function (W, H) { fill(grey(128), W, H); },
		grey20: function (W, H) { fill(grey(51), W, H); },
		grey5: function (W, H) { fill(grey(13), W, H); },
		gradient: function (W, H, s) {
			ramp(0, 0, W, Math.round(H / 2), 256, grey);
			ramp(0, Math.round(H / 2), W, H - Math.round(H / 2), 32, function (i) { return grey(Math.round(i * 255 / 31)); });
			text('256 levels', 12 * s, H / 2 - 14 * s, 12 * s, '#fff', 'left');
			text('32 steps', 12 * s, H / 2 + 14 * s, 12 * s, '#fff', 'left');
		},
		'rgb-gradients': function (W, H) {
			var h = H / 4;
			[[1, 1, 1], [1, 0, 0], [0, 1, 0], [0, 0, 1]].forEach(function (m, r) {
				ramp(0, Math.round(r * h), W, Math.round((r + 1) * h) - Math.round(r * h), 256, function (i) { return rgb(i * m[0], i * m[1], i * m[2]); });
			});
		},
		'near-black': function (W, H, s) {
			fill('#000', W, H);
			var n = 41, top = H * 0.2, h = H * 0.6;
			ramp(0, Math.round(top), W, Math.round(h), n, grey);
			for (var i = 0; i < n; i += 5) { text(String(i), (i + 0.5) * W / n, top + h + 16 * s, 11 * s, grey(110)); }
		},
		'black-level': function (W, H, s) { patches([1, 2, 3, 4, 5, 6, 7, 8, 10, 12, 14, 16, 20, 24, 28, 32], 0, W, H, s, grey(90)); },
		'white-level': function (W, H, s) { patches([254, 253, 252, 251, 250, 248, 246, 244, 242, 240, 236, 232, 228, 224, 220, 216], 255, W, H, s, grey(150)); },
		gamma: function (W, H, s) {
			fill(grey(128), W, H);
			var gammas = [1.8, 2.0, 2.2, 2.4, 2.6], cw = W / gammas.length;
			var stripes = pixelPattern(2, function (x, y) { return y % 2 ? [0, 0, 0] : [255, 255, 255]; });
			gammas.forEach(function (gm, i) {
				var x = Math.round(i * cw), w = Math.round((i + 1) * cw) - x, y = Math.round(H * 0.15), h = Math.round(H * 0.6);
				g.fillStyle = stripes;
				g.fillRect(x, y, w, h);
				var v = Math.round(255 * Math.pow(0.5, 1 / gm)), sq = Math.round(Math.min(w * 0.5, h * 0.5));
				g.fillStyle = grey(v);
				g.fillRect(Math.round(x + (w - sq) / 2), Math.round(y + (h - sq) / 2), sq, sq);
				text(gm.toFixed(1), x + w / 2, y + h + 26 * s, 18 * s, '#fff');
			});
			text('Gamma', W / 2, H * 0.07, 16 * s, '#fff');
		},
		sharpness: function (W, H, s) {
			fill('#fff', W, H);
			var bw = Math.round(Math.min(W / 5, 240 * s)), bh = Math.round(Math.min(H / 4, 140 * s)), y = Math.round(H * 0.08), x0 = Math.round((W - bw * 4 - 30 * s * 3) / 2);
			var pats = [
				pixelPattern(2, function (x) { return x % 2 ? [255, 255, 255] : [0, 0, 0]; }),
				pixelPattern(2, function (x, yy) { return yy % 2 ? [255, 255, 255] : [0, 0, 0]; }),
				pixelPattern(2, function (x, yy) { return (x + yy) % 2 ? [255, 255, 255] : [0, 0, 0]; }),
				pixelPattern(4, function (x, yy) { return ((x >> 1) + (yy >> 1)) % 2 ? [255, 255, 255] : [0, 0, 0]; })
			];
			var names = ['1 px vertical', '1 px horizontal', '1 px checker', '2 px checker'];
			pats.forEach(function (p, i) {
				var x = x0 + i * (bw + Math.round(30 * s));
				g.fillStyle = p;
				g.fillRect(x, y, bw, bh);
				text(names[i], x + bw / 2, y + bh + 14 * s, 11 * s, '#333');
			});
			var ty = y + bh + 50 * s, half = W / 2;
			g.fillStyle = '#000';
			g.fillRect(Math.round(half), Math.round(ty - 20 * s), Math.round(half), H);
			[9, 11, 13, 16, 20].forEach(function (px, i) {
				var line = 'The quick brown fox jumps over the lazy dog 0123456789';
				var yy = ty + i * 34 * s;
				g.font = Math.round(px * s) + 'px system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif';
				g.textAlign = 'left';
				g.textBaseline = 'middle';
				g.fillStyle = '#000';
				g.fillText(px + 'px  ' + line, 20 * s, yy, half - 40 * s);
				g.fillStyle = '#fff';
				g.fillText(px + 'px  ' + line, half + 20 * s, yy, half - 40 * s);
			});
		},
		grid: function (W, H, s) {
			fill('#000', W, H);
			var step = Math.round(50 * s), x, y;
			g.fillStyle = grey(200);
			for (x = Math.round(W / 2) % step; x < W; x += step) { g.fillRect(x, 0, 1, H); }
			for (y = Math.round(H / 2) % step; y < H; y += step) { g.fillRect(0, y, W, 1); }
			g.fillStyle = '#0f0';
			g.fillRect(0, 0, W, 1); g.fillRect(0, H - 1, W, 1); g.fillRect(0, 0, 1, H); g.fillRect(W - 1, 0, 1, H);
			g.fillStyle = '#fff';
			g.fillRect(Math.round(W / 2) - 1, 0, 2, H); g.fillRect(0, Math.round(H / 2) - 1, W, 2);
			g.strokeStyle = '#fff';
			g.lineWidth = Math.max(1, s);
			var r = Math.min(W, H) * 0.45, cr = Math.min(W, H) * 0.12;
			g.beginPath(); g.arc(W / 2, H / 2, r, 0, Math.PI * 2); g.stroke();
			[[cr, cr], [W - cr, cr], [cr, H - cr], [W - cr, H - cr]].forEach(function (c) { g.beginPath(); g.arc(c[0], c[1], cr * 0.9, 0, Math.PI * 2); g.stroke(); });
			text(Math.round(W) + ' x ' + Math.round(H) + ' px', W / 2, H / 2 + 24 * s, 14 * s, '#fff');
		},
		'color-bars': function (W, H, s) {
			var bars = [[1, 1, 1], [1, 1, 0], [0, 1, 1], [0, 1, 0], [1, 0, 1], [1, 0, 0], [0, 0, 1]];
			var n = bars.length, split = Math.round(H * 0.62);
			bars.forEach(function (m, i) {
				var x = Math.round(i * W / n), w = Math.round((i + 1) * W / n) - x;
				g.fillStyle = rgb(191 * m[0], 191 * m[1], 191 * m[2]);
				g.fillRect(x, 0, w, split);
				g.fillStyle = rgb(255 * m[0], 255 * m[1], 255 * m[2]);
				g.fillRect(x, split, w, H - split);
			});
			text('75%', 12 * s, split - 14 * s, 12 * s, '#000', 'left');
			text('100%', 12 * s, split + 14 * s, 12 * s, '#000', 'left');
		},
		hue: function (W, H) {
			for (var x = 0; x < W; x++) { g.fillStyle = 'hsl(' + (x / W * 360) + ',100%,50%)'; g.fillRect(x, 0, 1, H); }
			var gr = g.createLinearGradient(0, 0, 0, H);
			gr.addColorStop(0, 'rgba(255,255,255,1)'); gr.addColorStop(0.5, 'rgba(255,255,255,0)');
			gr.addColorStop(0.5, 'rgba(0,0,0,0)'); gr.addColorStop(1, 'rgba(0,0,0,1)');
			g.fillStyle = gr;
			g.fillRect(0, 0, W, H);
		},
		saturation: function (W, H, s) {
			fill(grey(128), W, H);
			var hues = [0, 60, 120, 180, 240, 300], steps = 10, pad = 20 * s, cw = (W - pad * 2) / steps, rh = (H - pad * 2) / hues.length;
			hues.forEach(function (h, r) {
				for (var i = 0; i < steps; i++) {
					g.fillStyle = 'hsl(' + h + ',' + ((i + 1) * 10) + '%,50%)';
					g.fillRect(Math.round(pad + i * cw), Math.round(pad + r * rh), Math.ceil(cw - 2 * s), Math.ceil(rh - 4 * s));
				}
			});
		},
		checker: function (W, H, s) {
			fill(grey(128), W, H);
			var cols = 6, rows = 4, size = Math.min((W * 0.9) / cols, (H * 0.85) / rows), gap = size * 0.1;
			var x0 = (W - cols * size) / 2, y0 = (H - rows * size) / 2;
			CHECKER.forEach(function (c, i) {
				g.fillStyle = rgb(c[0], c[1], c[2]);
				g.fillRect(Math.round(x0 + (i % cols) * size + gap / 2), Math.round(y0 + Math.floor(i / cols) * size + gap / 2), Math.round(size - gap), Math.round(size - gap));
			});
		},
		inversion: function (W, H, s) {
			fill(grey(64), W, H);
			var bands = [
				['Pixel checker', function (x, y) { return (x + y) % 2 ? [0, 0, 0] : [170, 170, 170]; }],
				['Column pairs', function (x, y) { return ((x >> 1) + y) % 2 ? [0, 0, 0] : [170, 170, 170]; }],
				['Green / magenta', function (x, y) { return (x + y) % 2 ? [170, 0, 170] : [0, 170, 0]; }],
				['Line pairs', function (x, y) { return (x + (y >> 1)) % 2 ? [0, 0, 0] : [170, 170, 170]; }],
				['Red / cyan', function (x, y) { return (x + y) % 2 ? [0, 150, 150] : [150, 0, 0]; }]
			];
			var bh = H / bands.length;
			bands.forEach(function (b, i) {
				g.fillStyle = pixelPattern(4, b[1]);
				g.fillRect(0, Math.round(i * bh), W, Math.round((i + 1) * bh) - Math.round(i * bh) - Math.round(4 * s));
				text(b[0], 14 * s, i * bh + 16 * s, 12 * s, '#fff', 'left');
			});
		},
		'viewing-angle': function (W, H, s) {
			fill(grey(128), W, H);
			var cells = [grey(64), grey(192), rgb(226, 182, 155), rgb(120, 150, 210), rgb(90, 160, 90), rgb(200, 90, 100)];
			var cols = 3, cw = W / cols, ch = H * 0.42;
			cells.forEach(function (c, i) {
				g.fillStyle = c;
				g.fillRect(Math.round((i % cols) * cw + cw * 0.08), Math.round(H * 0.06 + Math.floor(i / cols) * (ch + H * 0.04)), Math.round(cw * 0.84), Math.round(ch));
			});
		},
		smear: function (W, H, s, t) {
			fill('#000', W, H);
			var speed = 480 * s, bw = 160 * s, levels = [20, 40, 80, 128];
			var rh = H / levels.length;
			levels.forEach(function (v, i) {
				var x = ((t / 1000) * speed * (i % 2 ? -1 : 1)) % (W + bw);
				if (x < 0) { x += W + bw; }
				g.fillStyle = grey(v);
				g.fillRect(Math.round(x - bw), Math.round(i * rh + rh * 0.2), Math.round(bw), Math.round(rh * 0.6));
				text('Level ' + v, 14 * s, i * rh + rh * 0.12, 11 * s, grey(140), 'left');
			});
		}
	};
	var ANIMATED = { smear: 1 };

	function scale() { return window.devicePixelRatio || 1; }

	function render(t) {
		var id = items[idx].getAttribute('data-mt'), s = scale();
		var W = Math.round(window.innerWidth * s), H = Math.round(window.innerHeight * s);
		if (canvas.width !== W || canvas.height !== H) { canvas.width = W; canvas.height = H; }
		g.imageSmoothingEnabled = false;
		(P[id] || P.black)(W, H, s, t || 0);
	}

	function loop(t) {
		if (!active) { return; }
		render(t);
		raf = ANIMATED[items[idx].getAttribute('data-mt')] ? requestAnimationFrame(loop) : 0;
	}

	function showTip() {
		var b = items[idx];
		tipName.textContent = (idx + 1) + '/' + items.length + ' ' + b.querySelector('span').textContent.replace(/^\d+\.\s*/, '') + ':';
		tipText.textContent = b.getAttribute('data-tip');
		tip.hidden = !tipsBox.checked;
	}

	function go(i) {
		idx = i;
		seen[idx] = 1;
		cancelAnimationFrame(raf);
		raf = requestAnimationFrame(loop);
		showTip();
		wake();
	}

	function wake() {
		screenEl.classList.remove('is-idle');
		clearTimeout(hideTimer);
		hideTimer = setTimeout(function () { screenEl.classList.add('is-idle'); }, 2500);
	}

	function open(i) {
		active = true;
		screenEl.hidden = false;
		U.enterFullscreen(screenEl);
		screenEl.focus();
		go(i || 0);
	}

	function close() {
		if (!active) { return; }
		active = false;
		cancelAnimationFrame(raf);
		screenEl.hidden = true;
		U.exitFullscreen();
		var n = Object.keys(seen).length;
		U.status(statusEl, 'You viewed ' + n + ' of ' + items.length + ' patterns. Click any pattern to look at it again.', 'ok');
	}

	function step(d) {
		var next = idx + d;
		if (next >= items.length) { close(); return; }
		go(Math.max(0, next));
	}

	// Thumbnails: draw each pattern small, once.
	items.forEach(function (b, i) {
		var c = b.querySelector('canvas'), tg = c.getContext('2d'), keep = g;
		g = tg;
		try { (P[b.getAttribute('data-mt')] || P.black)(c.width, c.height, 0.35, 900); } catch (e) { /* thumbnail only */ }
		g = keep;
		b.addEventListener('click', function () { open(i); });
	});

	$('#mt-start').addEventListener('click', function () { open(0); });
	screenEl.addEventListener('click', function (e) {
		var btn = e.target.closest('[data-mt-go]');
		if (btn) {
			var d = Number(btn.getAttribute('data-mt-go'));
			if (d) { step(d); } else { close(); }
			return;
		}
		step(1);
	});
	screenEl.addEventListener('mousemove', wake);
	screenEl.addEventListener('touchstart', wake, { passive: true });
	tipsBox.addEventListener('change', function () { if (active) { showTip(); } });
	document.addEventListener('keydown', function (e) {
		if (!active) { return; }
		if (e.key === 'ArrowRight' || e.key === ' ' || e.key === 'Enter' || e.key === 'ArrowDown' || e.key === 'PageDown') { e.preventDefault(); step(1); }
		else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp' || e.key === 'PageUp') { e.preventDefault(); step(-1); }
		else if (e.key === 'h' || e.key === 'H') { tipsBox.checked = !tipsBox.checked; showTip(); }
		else if (e.key === 'Escape') { close(); }
	});
	window.addEventListener('resize', function () { if (active && !raf) { render(0); } });
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		document.addEventListener(ev, function () {
			if (active && !(document.fullscreenElement || document.webkitFullscreenElement) && !screenEl.classList.contains('is-pseudo-fs')) { close(); }
			else if (active) { render(0); }
		});
	});
	screenEl.addEventListener('tn:fullscreen', function (e) { if (!e.detail.on && active) { close(); } });

	// For automated checks: draw a pattern by index.
	root.mtOpen = open;
}());
