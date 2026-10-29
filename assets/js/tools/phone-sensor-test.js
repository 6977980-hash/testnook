/* Phone sensor test: one tap checks every sensor the browser can see (accelerometer, gyroscope, orientation, compass,
   location, light, magnetometer, proximity, vibration, battery, touch, screen rotation), with a live value per row
   and a link to the full test for each. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="phone-sensor-test"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#ss-start'), gpsBtn = $('#ss-gps'), statusEl = $('#ss-status'), summary = $('#ss-summary');
	var rows = {}, offs = [], running = false, seen = {}, paintT = 0;
	Array.prototype.forEach.call(root.querySelectorAll('[data-ss]'), function (li) {
		rows[li.getAttribute('data-ss')] = { state: li.querySelector('.ss-state'), val: li.querySelector('.ss-val') };
	});

	function set(id, state, cls, val) {
		var r = rows[id];
		if (!r) { return; }
		r.state.textContent = state;
		r.state.className = 'ss-state ' + (cls || '');
		if (val !== undefined) { r.val.textContent = val; }
	}

	function count() {
		var yes = 0, total = 0;
		Object.keys(rows).forEach(function (k) { total++; if (rows[k].state.classList.contains('is-ok')) { yes++; } });
		summary.textContent = yes + ' of ' + total + ' checks found on this device';
		summary.hidden = false;
	}

	// Checks that need no permission.
	function staticChecks() {
		set('vibrate', 'vibrate' in navigator ? 'Supported' : 'Not in this browser', 'vibrate' in navigator ? 'is-ok' : 'is-warn');
		var tp = navigator.maxTouchPoints || 0;
		set('touch', tp ? 'Yes' : 'No', tp ? 'is-ok' : 'is-bad', tp ? 'Up to ' + tp + ' touch points' : 'No touch screen reported');
		var so = screen.orientation;
		set('rotate', so ? 'Supported' : 'Basic', so ? 'is-ok' : 'is-warn', so ? so.type + ', ' + so.angle + '°' : (window.innerWidth > window.innerHeight ? 'Landscape' : 'Portrait'));
		if (so && so.addEventListener) { so.addEventListener('change', function () { set('rotate', 'Supported', 'is-ok', so.type + ', ' + so.angle + '°'); }); }
		set('light', 'AmbientLightSensor' in window ? 'API available' : 'Not exposed', 'AmbientLightSensor' in window ? 'is-ok' : 'is-warn');
		set('mag', 'Magnetometer' in window ? 'API available' : 'Not exposed', 'Magnetometer' in window ? 'is-ok' : 'is-warn');
		set('prox', 'ProximitySensor' in window || 'ondeviceproximity' in window ? 'API available' : 'Not exposed', 'ProximitySensor' in window || 'ondeviceproximity' in window ? 'is-ok' : 'is-warn');
		set('gps', 'geolocation' in navigator ? 'Tap to check' : 'Not supported', 'geolocation' in navigator ? '' : 'is-bad');
		if (navigator.getBattery) {
			navigator.getBattery().then(function (b) { set('battery', 'Yes', 'is-ok', Math.round(b.level * 100) + '%, ' + (b.charging ? 'charging' : 'on battery')); count(); }, function () { set('battery', 'Blocked', 'is-warn'); });
		} else { set('battery', 'Not in this browser', 'is-warn', 'Chrome and Edge on Android and computers only'); }
	}

	function onMotion(e) {
		var g = e.accelerationIncludingGravity, r = e.rotationRate, now = performance.now();
		if (g && g.x !== null && g.x !== undefined) {
			if (!seen.acc) { seen.acc = true; set('acc', 'Yes', 'is-ok'); count(); }
			if (now - paintT > 150) { rows.acc.val.textContent = 'X ' + g.x.toFixed(1) + '  Y ' + g.y.toFixed(1) + '  Z ' + g.z.toFixed(1) + ' m/s²'; }
		}
		if (r && r.alpha !== null && r.alpha !== undefined) {
			if (!seen.gyro) { seen.gyro = true; set('gyro', 'Yes', 'is-ok'); count(); }
			if (now - paintT > 150) { rows.gyro.val.textContent = 'X ' + (r.beta || 0).toFixed(1) + '  Y ' + (r.gamma || 0).toFixed(1) + '  Z ' + (r.alpha || 0).toFixed(1) + ' °/s'; }
		}
		if (now - paintT > 150) { paintT = now; }
	}

	function onOrient(e) {
		if (e.beta !== null && e.beta !== undefined) {
			if (!seen.orient) { seen.orient = true; set('orient', 'Yes', 'is-ok'); count(); }
			rows.orient.val.textContent = 'Tilt ' + e.beta.toFixed(0) + '° front/back, ' + (e.gamma || 0).toFixed(0) + '° left/right';
		}
		if (typeof e.webkitCompassHeading === 'number' && e.webkitCompassHeading >= 0) { compass(e.webkitCompassHeading); }
		else if (e.absolute === true && e.alpha !== null) { compass(360 - e.alpha); }
	}

	function compass(h) {
		h = ((h + S.screenAngle()) % 360 + 360) % 360;
		if (!seen.compass) { seen.compass = true; set('compass', 'Yes', 'is-ok'); count(); }
		rows.compass.val.textContent = 'Heading ' + Math.round(h) + '° ' + S.cardinal(h);
	}

	function start() {
		S.request().then(function (state) {
			if (state !== 'granted') { U.status(statusEl, S.message(state, 'motion sensors'), 'bad'); ['acc', 'gyro', 'orient', 'compass'].forEach(function (k) { set(k, state === 'denied' ? 'Blocked' : 'No', 'is-bad'); }); count(); return; }
			running = true;
			offs.push(S.on('devicemotion', onMotion), S.on('deviceorientation', onOrient));
			if ('ondeviceorientationabsolute' in window) { offs.push(S.on('deviceorientationabsolute', function (e) { if (e.alpha !== null) { compass(360 - e.alpha); } })); }
			['acc', 'gyro', 'orient', 'compass'].forEach(function (k) { set(k, 'Waiting...', ''); });
			startBtn.textContent = 'Stop';
			U.status(statusEl, 'Checking... move the phone a little.', '');
			setTimeout(function () {
				if (!running) { return; }
				['acc', 'gyro', 'orient', 'compass'].forEach(function (k) { if (!seen[k]) { set(k, 'Not found', 'is-bad'); } });
				count();
				U.status(statusEl, seen.acc ? 'Done. Tap a test name for the full test of that sensor.' : S.message('nodata', 'motion sensor'), seen.acc ? 'ok' : 'bad');
			}, 2500);
		});
	}

	function stop() {
		running = false;
		offs.forEach(function (f) { f(); });
		offs = [];
		startBtn.textContent = 'Check all sensors';
		U.status(statusEl, 'Stopped. The results above stay until you reload.', '');
	}

	startBtn.addEventListener('click', function () { if (running) { stop(); } else { start(); } });
	gpsBtn.addEventListener('click', function () {
		if (!('geolocation' in navigator)) { return; }
		set('gps', 'Waiting...', '');
		navigator.geolocation.getCurrentPosition(function (p) {
			var a = p.coords.accuracy, sat = a <= 30 && typeof p.coords.altitude === 'number';
			set('gps', sat ? 'Yes (satellites)' : 'Yes (approximate)', sat ? 'is-ok' : 'is-warn', 'Accuracy ±' + Math.round(a) + ' m' + (sat ? '' : ', likely Wi-Fi or network; try outdoors'));
			count();
		}, function (err) {
			set('gps', err.code === 1 ? 'Blocked' : 'No fix', 'is-bad', err.code === 1 ? 'Location permission refused' : 'Turn on Location and try outdoors');
			count();
		}, { enableHighAccuracy: true, timeout: 30000, maximumAge: 0 });
	});
	staticChecks();
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { stop(); } });
})();
