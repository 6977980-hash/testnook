/* Shared helpers for the phone sensor pages (gyroscope, accelerometer, compass, bubble level, sensor test).
   Loaded before the page script. Handles the iOS motion permission prompt, a rolling line graph, an event rate
   counter, the iPhone axis inversion of accelerationIncludingGravity, and compass heading maths. */
(function () {
	'use strict';
	if (window.TNSensor) { return; }

	var DME = window.DeviceMotionEvent, DOE = window.DeviceOrientationEvent;
	var iosPerm = !!((DME && typeof DME.requestPermission === 'function') || (DOE && typeof DOE.requestPermission === 'function'));
	var granted = !iosPerm;

	/** Ask for motion + orientation access (iOS 13+ needs a tap). Resolves 'granted', 'denied', 'unsupported' or 'insecure'. */
	function request() {
		if (!window.isSecureContext) { return Promise.resolve('insecure'); }
		if (!DME && !DOE) { return Promise.resolve('unsupported'); }
		if (!iosPerm || granted) { return Promise.resolve('granted'); }
		// Both prompts are started inside the same tap; iOS shows one dialog for the pair.
		var asks = [];
		if (DME && typeof DME.requestPermission === 'function') { asks.push(DME.requestPermission()); }
		if (DOE && typeof DOE.requestPermission === 'function') { asks.push(DOE.requestPermission()); }
		return Promise.all(asks.map(function (p) { return p.catch(function () { return 'denied'; }); })).then(function (r) {
			granted = r.every(function (s) { return s === 'granted'; });
			return granted ? 'granted' : 'denied';
		});
	}

	function message(state, what) {
		what = what || 'motion sensors';
		if (state === 'insecure') { return 'This page must be opened over HTTPS to read the ' + what + '.'; }
		if (state === 'unsupported') { return 'This browser does not expose ' + what + ' to websites. Try Chrome on Android or Safari on iPhone.'; }
		if (state === 'denied') { return 'Motion access was refused. On iPhone, close Safari completely (swipe it away in the app switcher), open this page again and tap Allow. In Chrome, open the site settings (lock icon) and allow Motion sensors.'; }
		if (state === 'nodata') { return 'No ' + what + ' data arrived. This device may not have the sensor (most laptops and desktops do not), or the browser blocks it. On a phone, check that motion sensors are allowed for this site.'; }
		return '';
	}

	/** Listen to a window event; returns a function that removes the listener. */
	function on(type, fn) {
		window.addEventListener(type, fn);
		return function () { window.removeEventListener(type, fn); };
	}

	/** Counts events and reports the rate over the last second. */
	function Rate() {
		var times = [];
		return {
			tick: function () {
				var t = performance.now();
				times.push(t);
				while (times.length && t - times[0] > 1000) { times.shift(); }
			},
			hz: function () {
				var t = performance.now();
				while (times.length && t - times[0] > 1000) { times.shift(); }
				return times.length;
			},
			reset: function () { times = []; }
		};
	}

	var COLORS = ['#e5484d', '#30a46c', '#3e63dd', '#f59e0b'];

	/** Rolling line graph on a canvas: push([v1, v2, v3]) per sample; draws on the next animation frame. */
	function Graph(canvas, opts) {
		opts = opts || {};
		var n = opts.points || 240, lines = opts.lines || 3, floor = opts.range || 1;
		var data = [], raf = 0, ctx = canvas.getContext('2d');
		for (var i = 0; i < lines; i++) { data.push([]); }

		function draw() {
			raf = 0;
			var dpr = window.devicePixelRatio || 1, w = canvas.clientWidth, h = canvas.clientHeight;
			if (!w || !h) { return; }
			if (canvas.width !== Math.round(w * dpr) || canvas.height !== Math.round(h * dpr)) {
				canvas.width = Math.round(w * dpr);
				canvas.height = Math.round(h * dpr);
			}
			ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
			ctx.clearRect(0, 0, w, h);
			var cs = getComputedStyle(canvas), grid = cs.getPropertyValue('--border') || '#ccc', muted = cs.getPropertyValue('--muted') || '#777';
			var lo = Infinity, hi = -Infinity;
			data.forEach(function (d) { d.forEach(function (v) { if (v < lo) { lo = v; } if (v > hi) { hi = v; } }); });
			if (opts.min !== undefined) { lo = Math.min(lo, opts.min); }
			if (opts.max !== undefined) { hi = Math.max(hi, opts.max); }
			if (!isFinite(lo)) { lo = -floor; hi = floor; }
			if (opts.symmetric) { var m = Math.max(Math.abs(lo), Math.abs(hi), floor); lo = -m; hi = m; }
			else if (hi - lo < floor) { var c = (hi + lo) / 2; lo = c - floor / 2; hi = c + floor / 2; }
			var pad = (hi - lo) * 0.08;
			lo -= pad; hi += pad;
			var y = function (v) { return h - (v - lo) / (hi - lo) * h; };
			ctx.lineWidth = 1;
			ctx.strokeStyle = grid.trim();
			ctx.beginPath();
			[0.25, 0.5, 0.75].forEach(function (f) { ctx.moveTo(0, Math.round(h * f) + 0.5); ctx.lineTo(w, Math.round(h * f) + 0.5); });
			ctx.stroke();
			if (lo < 0 && hi > 0) {
				ctx.strokeStyle = muted.trim();
				ctx.beginPath();
				ctx.moveTo(0, Math.round(y(0)) + 0.5);
				ctx.lineTo(w, Math.round(y(0)) + 0.5);
				ctx.stroke();
			}
			ctx.lineWidth = 1.8;
			data.forEach(function (d, k) {
				if (d.length < 2) { return; }
				ctx.strokeStyle = (opts.colors || COLORS)[k];
				ctx.beginPath();
				for (var j = 0; j < d.length; j++) {
					var x = w - (d.length - 1 - j) * (w / (n - 1));
					if (j) { ctx.lineTo(x, y(d[j])); } else { ctx.moveTo(x, y(d[j])); }
				}
				ctx.stroke();
			});
			ctx.fillStyle = muted.trim();
			ctx.font = '11px ' + (cs.getPropertyValue('--mono') || 'monospace');
			ctx.fillText(fmtAxis(hi - pad), 4, 12);
			ctx.fillText(fmtAxis(lo + pad), 4, h - 4);
		}
		function fmtAxis(v) { return Math.abs(v) >= 100 ? v.toFixed(0) : v.toFixed(1); }

		return {
			push: function (vals) {
				for (var k = 0; k < lines; k++) {
					var v = vals[k];
					if (typeof v === 'number' && isFinite(v)) { data[k].push(v); if (data[k].length > n) { data[k].shift(); } }
				}
				if (!raf) { raf = requestAnimationFrame(draw); }
			},
			clear: function () { data.forEach(function (d) { d.length = 0; }); if (!raf) { raf = requestAnimationFrame(draw); } },
			draw: draw
		};
	}

	/* iPhones report accelerationIncludingGravity with every axis inverted compared with the W3C convention
	   (flat, face up: z = +9.81). The sign is learnt by comparing the reading with the gravity direction the
	   orientation angles predict, with the user agent as the starting guess. */
	var flip = /iPhone|iPad|iPod/.test(navigator.userAgent) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1) ? -1 : 1;
	var flipVotes = 0;
	function learnFlip(g, beta, gamma) {
		if (!g || beta === null || beta === undefined || gamma === null || gamma === undefined) { return flip; }
		var b = beta * Math.PI / 180, c = gamma * Math.PI / 180;
		var ex = -Math.cos(b) * Math.sin(c), ey = Math.sin(b), ez = Math.cos(b) * Math.cos(c);
		var len = Math.sqrt(g.x * g.x + g.y * g.y + g.z * g.z);
		if (len < 5) { return flip; }
		var dot = (g.x * ex + g.y * ey + g.z * ez) / len;
		if (Math.abs(dot) < 0.6) { return flip; }
		flipVotes = Math.max(-20, Math.min(20, flipVotes + (dot > 0 ? 1 : -1)));
		if (flipVotes >= 5) { flip = 1; }
		if (flipVotes <= -5) { flip = -1; }
		return flip;
	}

	/** Gravity reading in the W3C convention, or null. */
	function gravity(e) {
		var g = e && e.accelerationIncludingGravity;
		if (!g || g.x === null || g.x === undefined) { return null; }
		return { x: g.x * flip, y: g.y * flip, z: g.z * flip };
	}

	function screenAngle() {
		var o = screen.orientation;
		if (o && typeof o.angle === 'number') { return o.angle; }
		return typeof window.orientation === 'number' ? window.orientation : 0;
	}

	var POINTS = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
	var NAMES = { N: 'North', NE: 'North-east', E: 'East', SE: 'South-east', S: 'South', SW: 'South-west', W: 'West', NW: 'North-west' };
	function cardinal(deg) { return POINTS[Math.round(((deg % 360) + 360) % 360 / 22.5) % 16]; }
	function cardinalName(deg) { var p = POINTS[Math.round(((deg % 360) + 360) % 360 / 45) * 2 % 16]; return NAMES[p]; }

	/** Mean and standard deviation of a list of numbers. */
	function stats(list) {
		var n = list.length, s = 0, ss = 0;
		if (!n) { return { mean: 0, sd: 0, n: 0 }; }
		list.forEach(function (v) { s += v; });
		var mean = s / n;
		list.forEach(function (v) { ss += (v - mean) * (v - mean); });
		return { mean: mean, sd: Math.sqrt(ss / n), n: n };
	}

	/** Shortest signed difference between two angles in degrees. */
	function angleDiff(a, b) { return ((a - b + 540) % 360) - 180; }

	/** Circular mean and spread (degrees) of a list of headings. */
	function circStats(list) {
		var sx = 0, sy = 0;
		list.forEach(function (d) { sx += Math.cos(d * Math.PI / 180); sy += Math.sin(d * Math.PI / 180); });
		var mean = (Math.atan2(sy, sx) * 180 / Math.PI + 360) % 360;
		var dev = list.map(function (d) { return angleDiff(d, mean); });
		return { mean: mean, sd: stats(dev).sd, n: list.length };
	}

	/** Pass/fail checklist: each li[data-step] holds buttons [data-pass] / [data-fail]. Calls back with {id: true|false}. */
	function steps(list, cb) {
		var state = {};
		Array.prototype.forEach.call(list.querySelectorAll('[data-step]'), function (li) {
			var id = li.getAttribute('data-step');
			Array.prototype.forEach.call(li.querySelectorAll('[data-pass],[data-fail]'), function (b) {
				b.addEventListener('click', function () {
					var pass = b.hasAttribute('data-pass');
					state[id] = pass;
					li.classList.toggle('is-pass', pass);
					li.classList.toggle('is-fail', !pass);
					Array.prototype.forEach.call(li.querySelectorAll('[data-pass],[data-fail]'), function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
					cb(state);
				});
			});
		});
	}

	function num(v, d) { return typeof v === 'number' && isFinite(v) ? v.toFixed(d === undefined ? 1 : d) : '-'; }

	window.TNSensor = {
		needsTap: iosPerm,
		request: request,
		message: message,
		on: on,
		Rate: Rate,
		Graph: Graph,
		COLORS: COLORS,
		learnFlip: learnFlip,
		gravity: gravity,
		flip: function () { return flip; },
		screenAngle: screenAngle,
		cardinal: cardinal,
		cardinalName: cardinalName,
		stats: stats,
		circStats: circStats,
		angleDiff: angleDiff,
		steps: steps,
		num: num
	};
})();
