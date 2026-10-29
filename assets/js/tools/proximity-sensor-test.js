/* Proximity sensor test: tries the Generic Sensor ProximitySensor and the old Firefox deviceproximity / userproximity
   events in case a browser still has them, then runs a pass/fail call test with a verdict. Browsers rarely expose
   the sensor, so the guided test is the main check. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="proximity-sensor-test"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#px-status'), apiEl = $('#px-api'), nearEl = $('#px-near'), distEl = $('#px-dist'), btn = $('#px-read'), verdict = $('#px-verdict'), face = $('#px-face');
	var sensor = null, legacy = [];

	function show(near, dist) {
		nearEl.textContent = near ? 'Near (covered)' : 'Far (clear)';
		nearEl.className = 'stat-value ' + (near ? 'is-warn' : 'is-ok');
		face.classList.toggle('is-near', !!near);
		if (typeof dist === 'number' && isFinite(dist)) { distEl.textContent = dist + ' cm'; }
	}

	var generic = 'ProximitySensor' in window, old = 'ondeviceproximity' in window || 'onuserproximity' in window;
	apiEl.textContent = generic || old ? 'Available' : 'Not exposed';
	apiEl.className = 'stat-value ' + (generic || old ? 'is-ok' : 'is-warn');
	btn.hidden = !(generic || old);

	btn.addEventListener('click', function () {
		if (sensor || legacy.length) {
			if (sensor) { sensor.stop(); sensor = null; }
			legacy.forEach(function (f) { f(); });
			legacy = [];
			btn.textContent = 'Read proximity sensor';
			return;
		}
		if (generic) {
			try {
				sensor = new window.ProximitySensor({ frequency: 5 });
				sensor.addEventListener('reading', function () { show(sensor.near, sensor.distance); });
				sensor.addEventListener('error', function (e) { U.status(statusEl, 'The proximity sensor could not start (' + (e.error ? e.error.name : 'error') + '). Use the call test below.', 'bad'); sensor = null; });
				sensor.start();
			} catch (err) { U.status(statusEl, 'The proximity sensor is blocked in this browser (' + err.name + '). Use the call test below.', 'bad'); sensor = null; }
		}
		if (old) {
			legacy.push(S.on('userproximity', function (e) { show(e.near); }));
			legacy.push(S.on('deviceproximity', function (e) { show(e.value < e.max, e.value); }));
		}
		btn.textContent = 'Stop';
		U.status(statusEl, 'Cover the top of the phone near the earpiece with your hand: the state should change to Near.', '');
	});

	S.steps($('#px-steps'), function (st) {
		var msg, ok = false;
		if (st.call === true && st.back === true) {
			ok = true;
			msg = 'The proximity sensor works: the screen turned off near your ear and came back when you moved the phone away.';
		} else if (st.call === false) {
			msg = st.clean === true
				? 'The screen stayed on after cleaning and removing the protector. Restart the phone and repeat. If it still fails, the sensor needs recalibrating (some phones have a test menu, see the codes below) or a repair, often after a screen replacement.'
				: 'The screen stayed on. Clean the top of the screen, take off any screen protector or case near the earpiece, then answer step 3 and repeat the call test.';
		} else if (st.back === false) {
			msg = 'The screen stayed black after you moved the phone away. Dirt, a protector or a crack over the sensor makes it think something is always near. Clean it, remove the protector and test again; if it persists, the sensor needs calibration or repair.';
		} else { return; }
		verdict.textContent = msg;
		verdict.className = 'sn-result ' + (ok ? 'is-ok' : 'is-bad');
		verdict.hidden = false;
	});

	document.addEventListener('visibilitychange', function () { if (document.hidden && sensor) { sensor.stop(); sensor = null; btn.textContent = 'Read proximity sensor'; } });
})();
