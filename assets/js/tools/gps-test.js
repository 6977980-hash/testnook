/* GPS test: watchPosition with high accuracy. Shows time to first fix, coordinates (can be blurred), accuracy with a
   rating, altitude, speed and heading, update rate, and a scatter plot of the fixes around their average in metres
   with the radius that holds half and 95% of them. Nothing leaves the browser. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="gps-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#gp-start'), statusEl = $('#gp-status'), coords = $('#gp-coords'), hide = $('#gp-hide'), map = $('#gp-map'), copy = $('#gp-copy'), plot = $('#gp-plot');
	var out = { ttff: $('#gp-ttff'), acc: $('#gp-acc'), rating: $('#gp-rating'), best: $('#gp-best'), alt: $('#gp-alt'), speed: $('#gp-speed'), head: $('#gp-head'), n: $('#gp-n'), every: $('#gp-every'), src: $('#gp-src'), r50: $('#gp-r50'), r95: $('#gp-r95') };
	var watch = null, t0 = 0, fixes = [], last = null, best = Infinity, timeout = 0;

	function rating(m) {
		if (m <= 5) { return ['Excellent', 'is-ok']; }
		if (m <= 15) { return ['Good', 'is-ok']; }
		if (m <= 50) { return ['Fair', 'is-warn']; }
		return ['Poor', 'is-bad'];
	}

	function fmtCoord(v, pos, neg) { return Math.abs(v).toFixed(6) + '° ' + (v >= 0 ? pos : neg); }

	// Fixes relative to their mean, in metres (equirectangular is fine over a few hundred metres).
	function spread() {
		var n = fixes.length, la = 0, lo = 0;
		fixes.forEach(function (f) { la += f.lat; lo += f.lon; });
		la /= n; lo /= n;
		var k = Math.cos(la * Math.PI / 180) * 111320;
		var pts = fixes.map(function (f) { return { x: (f.lon - lo) * k, y: (f.lat - la) * 110540, acc: f.acc }; });
		var d = pts.map(function (p) { return Math.sqrt(p.x * p.x + p.y * p.y); }).sort(function (a, b) { return a - b; });
		return { pts: pts, r50: d[Math.floor((n - 1) * 0.5)], r95: d[Math.floor((n - 1) * 0.95)] };
	}

	function draw(sp) {
		var dpr = window.devicePixelRatio || 1, w = plot.clientWidth, h = plot.clientHeight;
		if (!w) { return; }
		plot.width = Math.round(w * dpr);
		plot.height = Math.round(h * dpr);
		var ctx = plot.getContext('2d'), cs = getComputedStyle(plot);
		ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
		ctx.clearRect(0, 0, w, h);
		var maxR = 5;
		sp.pts.forEach(function (p) { maxR = Math.max(maxR, Math.abs(p.x), Math.abs(p.y)); });
		maxR = Math.max(maxR, last ? last.acc : 0) * 1.15;
		var nice = [5, 10, 20, 50, 100, 200, 500, 1000, 2000, 5000];
		var ring = nice.filter(function (v) { return v <= maxR; }).pop() || 5;
		var sc = (Math.min(w, h) / 2 - 10) / maxR, cx = w / 2, cy = h / 2;
		ctx.strokeStyle = cs.getPropertyValue('--border').trim();
		ctx.fillStyle = cs.getPropertyValue('--muted').trim();
		ctx.font = '11px ' + cs.getPropertyValue('--font');
		ctx.lineWidth = 1;
		[ring / 2, ring].forEach(function (r) { ctx.beginPath(); ctx.arc(cx, cy, r * sc, 0, Math.PI * 2); ctx.stroke(); ctx.fillText(r + ' m', cx + r * sc * 0.72 + 4, cy - r * sc * 0.72); });
		ctx.beginPath(); ctx.moveTo(cx, 6); ctx.lineTo(cx, h - 6); ctx.moveTo(6, cy); ctx.lineTo(w - 6, cy); ctx.stroke();
		ctx.fillText('N', cx + 4, 14);
		if (last) {
			var lp = sp.pts[sp.pts.length - 1];
			ctx.fillStyle = 'rgba(62, 99, 221, .12)';
			ctx.beginPath(); ctx.arc(cx + lp.x * sc, cy - lp.y * sc, last.acc * sc, 0, Math.PI * 2); ctx.fill();
		}
		sp.pts.forEach(function (p, i) {
			var isLast = i === sp.pts.length - 1;
			ctx.fillStyle = isLast ? '#3e63dd' : 'rgba(229, 72, 77, .7)';
			ctx.beginPath(); ctx.arc(cx + p.x * sc, cy - p.y * sc, isLast ? 5 : 3, 0, Math.PI * 2); ctx.fill();
		});
	}

	function onFix(p) {
		var c = p.coords, now = performance.now();
		clearTimeout(timeout);
		if (!fixes.length) { out.ttff.textContent = ((now - t0) / 1000).toFixed(1) + ' s'; }
		var f = { lat: c.latitude, lon: c.longitude, acc: c.accuracy, t: now };
		if (last) { out.every.textContent = ((now - last.t) / 1000).toFixed(1) + ' s'; }
		fixes.push(f);
		if (fixes.length > 300) { fixes.shift(); }
		last = f;
		best = Math.min(best, c.accuracy);
		coords.textContent = fmtCoord(c.latitude, 'N', 'S') + ', ' + fmtCoord(c.longitude, 'E', 'W');
		map.href = 'https://www.google.com/maps?q=' + c.latitude.toFixed(6) + ',' + c.longitude.toFixed(6);
		map.hidden = copy.hidden = false;
		var r = rating(c.accuracy);
		out.acc.textContent = '±' + (c.accuracy < 100 ? c.accuracy.toFixed(1) : Math.round(c.accuracy)) + ' m';
		out.rating.textContent = r[0];
		out.rating.className = 'stat-value ' + r[1];
		out.best.textContent = '±' + (best < 100 ? best.toFixed(1) : Math.round(best)) + ' m';
		out.alt.textContent = typeof c.altitude === 'number' ? Math.round(c.altitude) + ' m' + (typeof c.altitudeAccuracy === 'number' ? ' (±' + Math.round(c.altitudeAccuracy) + ')' : '') : 'Not reported';
		out.speed.textContent = typeof c.speed === 'number' && !isNaN(c.speed) ? (c.speed * 3.6).toFixed(1) + ' km/h (' + (c.speed * 2.23694).toFixed(1) + ' mph)' : '-';
		out.head.textContent = typeof c.heading === 'number' && !isNaN(c.heading) && c.speed > 0.5 ? Math.round(c.heading) + '°' : '-';
		out.n.textContent = fixes.length;
		// Satellite fixes nearly always come with an altitude and a tight radius; Wi-Fi and cell fixes do not.
		var gnss = c.accuracy <= 30 && typeof c.altitude === 'number';
		out.src.textContent = gnss ? 'Satellites (GPS)' : c.accuracy > 100 ? 'Wi-Fi or mobile network' : 'Mixed / Wi-Fi';
		out.src.className = 'stat-value ' + (gnss ? 'is-ok' : 'is-warn');
		if (fixes.length >= 3) {
			var sp = spread();
			out.r50.textContent = sp.r50.toFixed(1) + ' m';
			out.r95.textContent = sp.r95.toFixed(1) + ' m';
			draw(sp);
		} else { draw(spread()); }
		U.status(statusEl, gnss ? 'Location fix from satellites. Stay put for a minute to see how much the position wanders.' : c.accuracy > 100 ? 'This fix is approximate (Wi-Fi or mobile network). Go outside with a clear view of the sky and wait for the accuracy to improve.' : 'Getting closer. Satellite fixes usually reach under 15 m outdoors.', gnss ? 'ok' : '');
	}

	function onErr(err) {
		var msg = err.code === 1 ? 'Location permission was refused. Tap the lock icon by the address and allow Location, then try again. On iPhone, also check Settings > Privacy & Security > Location Services > Safari Websites.'
			: err.code === 2 ? 'The device could not work out a position. Turn on Location (GPS) in the phone settings and go outside, away from tall buildings.'
			: 'Still waiting for a fix. Satellite GPS can take up to a minute the first time, longer indoors.';
		U.status(statusEl, msg, 'bad');
		if (err.code === 1) { stop(true); }
	}

	function start() {
		if (!('geolocation' in navigator)) { U.status(statusEl, 'This browser has no location support.', 'bad'); return; }
		if (!window.isSecureContext) { U.status(statusEl, 'This page must be opened over HTTPS to use location.', 'bad'); return; }
		fixes = []; last = null; best = Infinity; t0 = performance.now();
		Object.keys(out).forEach(function (k) { out[k].textContent = '-'; out[k].className = 'stat-value'; });
		watch = navigator.geolocation.watchPosition(onFix, onErr, { enableHighAccuracy: true, maximumAge: 0, timeout: 60000 });
		startBtn.textContent = 'Stop';
		U.status(statusEl, 'Waiting for a location fix... allow location access if the browser asks.', '');
		timeout = setTimeout(function () { if (watch !== null && !fixes.length) { U.status(statusEl, 'No fix after 30 seconds. Make sure Location is on, then go outside or near a window.', 'bad'); } }, 30000);
	}

	function stop(quiet) {
		if (watch !== null) { navigator.geolocation.clearWatch(watch); }
		watch = null;
		clearTimeout(timeout);
		startBtn.textContent = 'Start GPS test';
		if (!quiet) { U.status(statusEl, fixes.length ? 'Stopped after ' + fixes.length + ' fixes.' : 'Stopped.', ''); }
	}

	startBtn.addEventListener('click', function () { if (watch !== null) { stop(); } else { start(); } });
	hide.addEventListener('change', function () { coords.classList.toggle('is-hidden', hide.checked); });
	copy.addEventListener('click', function () {
		if (!last || !navigator.clipboard) { return; }
		navigator.clipboard.writeText(last.lat.toFixed(6) + ', ' + last.lon.toFixed(6)).then(function () { copy.textContent = 'Copied'; setTimeout(function () { copy.textContent = 'Copy'; }, 1500); });
	});
	draw({ pts: [] });
})();
