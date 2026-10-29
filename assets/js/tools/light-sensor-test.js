/* Light sensor test: reads lux from the Generic Sensor AmbientLightSensor where a browser exposes it, offers a camera
   light meter (front camera average brightness, compensated for exposure time and ISO when the camera reports them),
   and a pass/fail auto-brightness check with a verdict. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="light-sensor-test"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#lt-status'), apiEl = $('#lt-api'), luxEl = $('#lt-lux'), luxBtn = $('#lt-luxstart'), camBtn = $('#lt-cam'), video = $('#lt-video'), meter = $('#lt-meter'), verdict = $('#lt-verdict');
	var out = { bright: $('#lt-bright'), index: $('#lt-index'), min: $('#lt-min'), max: $('#lt-max'), exp: $('#lt-exp') };
	var graph = S.Graph($('#lt-graph'), { lines: 1, min: 0, range: 10, colors: ['#f59e0b'] });
	var sensor = null, stream = null, track = null, timer = 0, lo = Infinity, hi = -Infinity, canvas = document.createElement('canvas');
	canvas.width = 64; canvas.height = 48;
	var ctx = canvas.getContext('2d', { willReadFrequently: true });

	function luxLabel(l) {
		if (l < 10) { return 'dark room'; }
		if (l < 100) { return 'dim room'; }
		if (l < 500) { return 'normal indoor light'; }
		if (l < 2000) { return 'bright indoor / overcast day'; }
		if (l < 20000) { return 'daylight'; }
		return 'direct sunlight';
	}

	function track2(v) {
		lo = Math.min(lo, v); hi = Math.max(hi, v);
		out.min.textContent = lo < 100 ? lo.toFixed(1) : Math.round(lo);
		out.max.textContent = hi < 100 ? hi.toFixed(1) : Math.round(hi);
		graph.push([v]);
	}

	// 1. The browser's own light sensor API (Chrome behind a flag, some Android builds).
	var hasApi = 'AmbientLightSensor' in window;
	apiEl.textContent = hasApi ? 'Available' : 'Not exposed';
	apiEl.className = 'stat-value ' + (hasApi ? 'is-ok' : 'is-warn');
	luxBtn.hidden = !hasApi;
	luxBtn.addEventListener('click', function () {
		if (sensor) { sensor.stop(); sensor = null; luxBtn.textContent = 'Read light sensor'; return; }
		try {
			sensor = new window.AmbientLightSensor({ frequency: 5 });
			sensor.addEventListener('reading', function () {
				luxEl.textContent = Math.round(sensor.illuminance) + ' lux (' + luxLabel(sensor.illuminance) + ')';
				track2(sensor.illuminance);
			});
			sensor.addEventListener('error', function (e) {
				U.status(statusEl, e.error && e.error.name === 'NotAllowedError' ? 'Access to the light sensor was refused in the site settings.' : 'The light sensor could not start: ' + (e.error ? e.error.name : 'unknown error') + '. Use the camera light meter instead.', 'bad');
				sensor = null;
				luxBtn.textContent = 'Read light sensor';
			});
			sensor.start();
			luxBtn.textContent = 'Stop light sensor';
			U.status(statusEl, 'Reading the ambient light sensor. Cover the top of the phone and the lux value should drop close to 0.', 'ok');
		} catch (err) {
			U.status(statusEl, 'The light sensor is blocked in this browser (' + err.name + '). Use the camera light meter instead.', 'bad');
			sensor = null;
		}
	});

	// 2. Camera light meter.
	function stopCam() {
		clearInterval(timer);
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = track = null;
		video.hidden = true;
		camBtn.textContent = 'Start camera light meter';
	}

	function sample() {
		if (!video.videoWidth) { return; }
		ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
		var d = ctx.getImageData(0, 0, canvas.width, canvas.height).data, sum = 0;
		for (var i = 0; i < d.length; i += 4) { sum += 0.2126 * d[i] + 0.7152 * d[i + 1] + 0.0722 * d[i + 2]; }
		var mean = sum / (d.length / 4), pct = mean / 255 * 100;
		out.bright.textContent = pct.toFixed(0) + '%';
		meter.style.width = pct.toFixed(1) + '%';
		var st = track && track.getSettings ? track.getSettings() : {};
		// Scene light is proportional to linear pixel brightness divided by exposure time x ISO.
		if (st.exposureTime && st.iso) {
			var lin = Math.pow(Math.max(mean, 1) / 255, 2.2), idx = Math.log(lin / (st.exposureTime * st.iso) * 1e6) / Math.LN2;
			out.index.textContent = idx.toFixed(1);
			out.exp.textContent = 'Compensated';
			track2(Math.max(0, idx + 10));
		} else {
			out.index.textContent = '-';
			out.exp.textContent = 'Auto (relative only)';
			track2(pct);
		}
	}

	camBtn.addEventListener('click', function () {
		if (stream) { stopCam(); U.status(statusEl, 'Camera closed.', ''); return; }
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) { U.status(statusEl, U.mediaError({ name: '' }, 'camera'), 'bad'); return; }
		U.status(statusEl, 'Waiting for camera permission...', '');
		navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 320 }, height: { ideal: 240 } }, audio: false }).then(function (s) {
			stream = s;
			track = s.getVideoTracks()[0];
			video.srcObject = s;
			video.hidden = false;
			var p = video.play();
			if (p && p.catch) { p.catch(function () {}); }
			camBtn.textContent = 'Stop camera';
			lo = Infinity; hi = -Infinity;
			graph.clear();
			timer = setInterval(sample, 200);
			U.status(statusEl, 'Camera light meter on. Cover the front camera, then point it at a lamp: the reading should follow.', 'ok');
		}).catch(function (err) { U.status(statusEl, U.mediaError(err, 'camera'), 'bad'); });
	});

	// 3. Auto-brightness check.
	S.steps($('#lt-steps'), function (st) {
		var msg = '', ok = false;
		if (st.dim === false || st.bright === false) {
			msg = st.on === false ? 'Auto-brightness was off, so the screen cannot follow the light. Turn it on and run the steps again.'
				: 'The screen did not follow the light. Clean the area beside the front camera, take off a screen protector or case that covers it, restart the phone and try again. If it still fails, see the fixes below: the sensor or its calibration may be faulty.';
		} else if (st.dim && st.bright) {
			ok = true;
			msg = 'The light sensor and auto-brightness work: the screen dimmed when covered and brightened in strong light.';
		} else { return; }
		verdict.textContent = msg;
		verdict.className = 'sn-result ' + (ok ? 'is-ok' : 'is-bad');
		verdict.hidden = false;
	});

	document.addEventListener('visibilitychange', function () { if (document.hidden) { stopCam(); if (sensor) { sensor.stop(); sensor = null; luxBtn.textContent = 'Read light sensor'; } } });
})();
