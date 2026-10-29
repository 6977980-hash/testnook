/* Astigmatism test: a clock dial of line groups every 30 degrees and a fan of single lines every 15 degrees.
   With one eye covered, lines along the meridian the eye focuses best look darker and sharper. The user taps the
   darkest lines (or "all the same") for each eye; the darkest clock hour gives an estimated axis by the rule of 30. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="astigmatism-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#as-stage'), canvas = $('#as-canvas'), ctx = canvas.getContext('2d'), statusEl = $('#as-status');
	var resR = $('#as-res-right'), resL = $('#as-res-left');
	var chart = 'dial', eye = 'right', picked = null, results = {};

	function geom() {
		var w = stage.clientWidth, h = Math.min(Math.max(300, w * 0.9), 460), r = window.devicePixelRatio || 1;
		canvas.style.width = w + 'px';
		canvas.style.height = h + 'px';
		canvas.width = Math.round(w * r);
		canvas.height = Math.round(h * r);
		return { w: w, h: h, r: r, cx: w / 2, cy: h / 2, R: Math.min(w, h) / 2 - 26 };
	}

	// Clock hour (1-12) to the angle on screen, 12 at the top, clockwise.
	function hourAngle(hr) { return (hr % 12) * Math.PI / 6 - Math.PI / 2; }

	function draw() {
		var g = geom(), r = g.r;
		ctx.setTransform(r, 0, 0, r, 0, 0);
		ctx.fillStyle = '#fff';
		ctx.fillRect(0, 0, g.w, g.h);
		ctx.strokeStyle = '#000';
		ctx.lineCap = 'butt';
		if (chart === 'dial') {
			ctx.lineWidth = 2.2;
			for (var hr = 1; hr <= 12; hr++) {
				var a = hourAngle(hr), dx = Math.cos(a), dy = Math.sin(a), px = -dy, py = dx;
				for (var k = -1; k <= 1; k++) {
					var off = k * 6;
					ctx.beginPath();
					ctx.moveTo(g.cx + dx * g.R * 0.22 + px * off, g.cy + dy * g.R * 0.22 + py * off);
					ctx.lineTo(g.cx + dx * g.R * 0.86 + px * off, g.cy + dy * g.R * 0.86 + py * off);
					ctx.stroke();
				}
			}
		} else {
			ctx.lineWidth = 1.6;
			for (var d = 0; d < 180; d += 15) {
				var t = d * Math.PI / 180;
				ctx.beginPath();
				ctx.moveTo(g.cx - Math.cos(t) * g.R * 0.9, g.cy - Math.sin(t) * g.R * 0.9);
				ctx.lineTo(g.cx + Math.cos(t) * g.R * 0.9, g.cy + Math.sin(t) * g.R * 0.9);
				ctx.stroke();
			}
			ctx.fillStyle = '#fff';
			ctx.beginPath();
			ctx.arc(g.cx, g.cy, g.R * 0.12, 0, Math.PI * 2);
			ctx.fill();
		}
		// Hour numbers, and the picked pair in the brand colour.
		ctx.font = '600 14px system-ui, sans-serif';
		ctx.textAlign = 'center';
		ctx.textBaseline = 'middle';
		for (var n = 1; n <= 12; n++) {
			var b = hourAngle(n), on = picked && (n === picked || n === (picked + 6 - 1) % 12 + 1);
			ctx.fillStyle = on ? '#0f766e' : '#555';
			ctx.font = (on ? '800 17px' : '600 14px') + ' system-ui, sans-serif';
			ctx.fillText(String(n), g.cx + Math.cos(b) * (g.R + 14), g.cy + Math.sin(b) * (g.R + 14));
		}
		ctx.fillStyle = '#000';
		ctx.beginPath();
		ctx.arc(g.cx, g.cy, 3, 0, Math.PI * 2);
		ctx.fill();
	}

	function axisFor(hr) { var pair = hr > 6 ? hr - 6 : hr; return pair * 30; }
	function pairText(hr) { var a = hr > 6 ? hr - 6 : hr; return a + ' and ' + (a + 6) + ' o\'clock'; }

	function record(text, isAstig) {
		results[eye] = text;
		(eye === 'right' ? resR : resL).textContent = text;
		var other = eye === 'right' ? 'left' : 'right';
		U.status(statusEl, (eye === 'right' ? 'Right' : 'Left') + ' eye: ' + text + '. ' + (results[other] ? (isAstig || /darker/.test(results[other]) ? 'Lines that look darker in one direction are a sign of astigmatism; an eye examination will measure it.' : 'No sign of astigmatism in either eye on this chart.') : 'Now choose ' + (other === 'left' ? 'Left eye' : 'Right eye') + ', cover the other eye and look again.'), isAstig ? '' : 'ok');
	}

	canvas.addEventListener('click', function (e) {
		var rect = canvas.getBoundingClientRect(), x = e.clientX - rect.left - rect.width / 2, y = e.clientY - rect.top - rect.height / 2;
		if (Math.hypot(x, y) < 12) { return; }
		var ang = Math.atan2(y, x) + Math.PI / 2; // 0 at 12 o'clock, clockwise
		if (ang < 0) { ang += Math.PI * 2; }
		var hr = Math.round(ang / (Math.PI / 6)) % 12 || 12;
		picked = hr;
		draw();
		record('darker at ' + pairText(hr) + ', axis about ' + axisFor(hr) + '°', true);
	});
	$('#as-same').addEventListener('click', function () {
		picked = null;
		draw();
		record('all lines look the same', false);
	});
	U.$$('[data-as-chart]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			chart = b.getAttribute('data-as-chart');
			U.$$('[data-as-chart]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
			draw();
		});
	});
	U.$$('[data-as-eye]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			eye = b.getAttribute('data-as-eye');
			U.$$('[data-as-eye]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
			picked = null;
			draw();
			U.status(statusEl, 'Cover your ' + (eye === 'right' ? 'left' : 'right') + ' eye and look at the dot in the middle. Tap the darkest lines, or press "All look the same".', '');
		});
	});
	var lastW = 0;
	window.addEventListener('resize', function () { if (Math.abs(stage.clientWidth - lastW) > 10) { lastW = stage.clientWidth; draw(); } });
	draw();
}());
