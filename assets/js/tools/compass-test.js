/* Compass test: heading from webkitCompassHeading (iPhone) or deviceorientationabsolute (Android), corrected for the
   screen rotation. Shows a compass rose, the heading accuracy iPhones report, a 3 second steadiness check, a tilt
   warning, an optional target bearing and, where the browser has it, the raw Magnetometer field strength. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="compass-test"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#cp-start'), statusEl = $('#cp-status'), rose = $('#cp-rose'), readEl = $('#cp-deg'), dirEl = $('#cp-dir'), result = $('#cp-result'), target = $('#cp-target'), arrow = $('#cp-arrow');
	var out = { src: $('#cp-src'), acc: $('#cp-acc'), steady: $('#cp-steady'), tilt: $('#cp-tilt'), field: $('#cp-field') };
	var offs = [], running = false, got = false, recent = [], heading = null, shown = null, mag = null, absSeen = false, lastPaint = 0;

	// Compass rose: ticks every 5 degrees, labels every 30, N in red.
	(function build() {
		var s = '<svg viewBox="0 0 300 300" aria-hidden="true"><circle cx="150" cy="150" r="146" fill="none" stroke="currentColor" stroke-opacity=".25" stroke-width="2"/>';
		for (var d = 0; d < 360; d += 5) {
			var long = d % 30 === 0, r1 = 146, r2 = long ? 128 : 137, a = (d - 90) * Math.PI / 180;
			s += '<line x1="' + (150 + r1 * Math.cos(a)).toFixed(1) + '" y1="' + (150 + r1 * Math.sin(a)).toFixed(1) + '" x2="' + (150 + r2 * Math.cos(a)).toFixed(1) + '" y2="' + (150 + r2 * Math.sin(a)).toFixed(1) + '" stroke="currentColor" stroke-width="' + (long ? 2 : 1) + '"/>';
		}
		var labels = { 0: 'N', 90: 'E', 180: 'S', 270: 'W' };
		for (d = 0; d < 360; d += 30) {
			var t = labels[d] || String(d), rr = labels[d] !== undefined ? 108 : 112, b = (d - 90) * Math.PI / 180;
			s += '<text x="' + (150 + rr * Math.cos(b)).toFixed(1) + '" y="' + (150 + rr * Math.sin(b) + 5).toFixed(1) + '" text-anchor="middle"' + (d === 0 ? ' class="cp-n"' : '') + (labels[d] === undefined ? ' style="font-size:11px;font-weight:600"' : '') + ' transform="rotate(' + d + ' ' + (150 + rr * Math.cos(b)).toFixed(1) + ' ' + (150 + rr * Math.sin(b)).toFixed(1) + ')">' + t + '</text>';
		}
		s += '<path d="M150 62 L160 150 L150 142 L140 150 Z" fill="#e5484d"/><path d="M150 238 L160 150 L150 158 L140 150 Z" fill="currentColor" fill-opacity=".35"/><circle cx="150" cy="150" r="6" fill="currentColor"/></svg>';
		rose.innerHTML = s;
	})();

	function paint(now) {
		if (heading === null) { return; }
		// Rotate the rose the short way round so it never spins a full turn when crossing north.
		shown = shown === null ? heading : shown + S.angleDiff(heading, ((shown % 360) + 360) % 360);
		rose.style.transform = 'rotate(' + (-shown).toFixed(1) + 'deg)';
		if (now - lastPaint < 120) { return; }
		lastPaint = now;
		readEl.textContent = Math.round(heading) % 360 + '°';
		dirEl.textContent = S.cardinal(heading);
		while (recent.length && now - recent[0].t > 3000) { recent.shift(); }
		if (recent.length > 10) {
			var cs = S.circStats(recent.map(function (r) { return r.h; }));
			out.steady.textContent = '±' + cs.sd.toFixed(1) + '°';
			out.steady.className = 'stat-value ' + (cs.sd < 2 ? 'is-ok' : cs.sd < 6 ? 'is-warn' : 'is-bad');
		}
		var tv = parseFloat(target.value);
		if (!isNaN(tv)) {
			var diff = S.angleDiff(tv, heading);
			arrow.hidden = false;
			arrow.style.transform = 'rotate(' + diff.toFixed(1) + 'deg)';
			$('#cp-turn').textContent = Math.abs(diff) < 3 ? 'On target' : 'Turn ' + (diff > 0 ? 'right ' : 'left ') + Math.abs(diff).toFixed(0) + '°';
		} else { arrow.hidden = true; $('#cp-turn').textContent = ''; }
	}

	function setHeading(h, src, acc, tilt) {
		if (typeof h !== 'number' || !isFinite(h)) { return; }
		heading = ((h + S.screenAngle()) % 360 + 360) % 360;
		var now = performance.now();
		recent.push({ t: now, h: heading });
		if (!got) {
			got = true;
			out.src.textContent = src;
			out.src.className = 'stat-value is-ok';
			U.status(statusEl, 'Compass is working. Hold the phone flat and turn around slowly: N on the dial should point north.', 'ok');
		}
		if (acc !== undefined) {
			out.acc.textContent = acc < 0 ? 'Not calibrated' : '±' + Math.round(acc) + '°';
			out.acc.className = 'stat-value ' + (acc < 0 || acc > 30 ? 'is-bad' : acc > 15 ? 'is-warn' : 'is-ok');
			result.hidden = !(acc < 0 || acc > 25);
		}
		out.tilt.textContent = tilt > 25 ? 'Hold flatter' : 'OK';
		out.tilt.className = 'stat-value ' + (tilt > 25 ? 'is-warn' : 'is-ok');
		paint(now);
	}

	function tiltOf(e) { return Math.max(Math.abs(e.beta || 0), Math.abs(e.gamma || 0)); }

	function onAbs(e) {
		if (e.alpha === null || e.alpha === undefined) { return; }
		absSeen = true;
		setHeading(360 - e.alpha, 'Yes (absolute orientation)', undefined, tiltOf(e));
	}

	function onOrient(e) {
		if (typeof e.webkitCompassHeading === 'number' && e.webkitCompassHeading >= 0) {
			setHeading(e.webkitCompassHeading, 'Yes (iPhone compass)', e.webkitCompassAccuracy, tiltOf(e));
		} else if (e.absolute === true && !absSeen && e.alpha !== null && e.alpha !== undefined) {
			setHeading(360 - e.alpha, 'Yes (absolute orientation)', undefined, tiltOf(e));
		}
	}

	function startMagnetometer() {
		if (!('Magnetometer' in window)) { out.field.textContent = 'Not exposed'; return; }
		try {
			mag = new window.Magnetometer({ frequency: 10 });
			mag.addEventListener('reading', function () {
				var f = Math.sqrt(mag.x * mag.x + mag.y * mag.y + mag.z * mag.z);
				out.field.textContent = f.toFixed(0) + ' µT';
				out.field.className = 'stat-value ' + (f > 25 && f < 70 ? 'is-ok' : 'is-warn');
			});
			mag.addEventListener('error', function () { out.field.textContent = 'Blocked'; });
			mag.start();
		} catch (err) { out.field.textContent = 'Blocked'; }
	}

	function start() {
		S.request().then(function (state) {
			if (state !== 'granted') { U.status(statusEl, S.message(state, 'compass'), 'bad'); return; }
			running = true;
			if ('ondeviceorientationabsolute' in window) { offs.push(S.on('deviceorientationabsolute', onAbs)); }
			offs.push(S.on('deviceorientation', onOrient));
			startMagnetometer();
			startBtn.textContent = 'Stop';
			U.status(statusEl, 'Reading the compass...', '');
			setTimeout(function () {
				if (!running || got) { return; }
				out.src.textContent = 'No';
				out.src.className = 'stat-value is-bad';
				U.status(statusEl, 'No compass heading arrived. This device may have no magnetometer (most laptops do not), or the browser only gives relative orientation. Try Chrome on Android or Safari on iPhone.', 'bad');
			}, 2500);
		});
	}

	function stop() {
		running = false;
		offs.forEach(function (f) { f(); });
		offs = [];
		if (mag) { try { mag.stop(); } catch (e) { /* already stopped */ } mag = null; }
		startBtn.textContent = 'Start compass';
		U.status(statusEl, 'Stopped.', '');
	}

	startBtn.addEventListener('click', function () { if (running) { stop(); } else { start(); } });
	target.addEventListener('input', function () { lastPaint = 0; paint(performance.now()); });
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { stop(); } });
})();
