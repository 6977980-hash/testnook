/* Gyroscope test: live orientation angles and rotation rate (deg/s) from DeviceOrientation and DeviceMotion,
   a 3D phone that follows the device, a rolling graph, a 10 second drift check (bias and noise while still)
   and a full-turn check that integrates the z rotation rate to see if the gyroscope measures 360 degrees. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="gyroscope-test"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#gy-start'), stillBtn = $('#gy-still'), turnBtn = $('#gy-turn'), statusEl = $('#gy-status'), phone = $('#gy-phone'), result = $('#gy-result');
	var out = { a: $('#gy-a'), b: $('#gy-b'), g: $('#gy-g'), rx: $('#gy-rx'), ry: $('#gy-ry'), rz: $('#gy-rz'), peak: $('#gy-peak'), hz: $('#gy-hz'), has: $('#gy-has') };
	var graph = S.Graph($('#gy-graph'), { symmetric: true, range: 20 });
	var rate = S.Rate(), offs = [], running = false, peak = 0, gotRate = false, gotMotion = false, gotOrient = false, check = null, turn = null, lastT = 0, paintT = 0, hzTimer = 0;

	function setHas(text, ok) {
		out.has.textContent = text;
		out.has.className = 'stat-value ' + (ok ? 'is-ok' : 'is-bad');
	}

	function onOrient(e) {
		if (e.beta === null || e.beta === undefined) { return; }
		gotOrient = true;
		var a = e.alpha || 0, b = e.beta, g = e.gamma || 0;
		phone.style.transform = 'rotateX(' + b.toFixed(1) + 'deg) rotateY(' + (-g).toFixed(1) + 'deg) rotateZ(' + a.toFixed(1) + 'deg)';
		out.a.textContent = a.toFixed(0) + '°';
		out.b.textContent = b.toFixed(0) + '°';
		out.g.textContent = g.toFixed(0) + '°';
	}

	function onMotion(e) {
		gotMotion = true;
		var r = e.rotationRate;
		if (!r || r.alpha === null || r.alpha === undefined) { return; }
		if (!gotRate) { gotRate = true; setHas('Yes', true); U.status(statusEl, 'Gyroscope is working. Turn and tilt the phone: the graph shows how fast it rotates around each axis.', 'ok'); }
		rate.tick();
		var x = r.beta || 0, y = r.gamma || 0, z = r.alpha || 0, now = e.timeStamp || performance.now();
		var mag = Math.sqrt(x * x + y * y + z * z);
		if (mag > peak) { peak = mag; out.peak.textContent = peak.toFixed(0) + '°/s'; }
		graph.push([x, y, z]);
		if (now - paintT > 100) {
			paintT = now;
			out.rx.textContent = x.toFixed(1);
			out.ry.textContent = y.toFixed(1);
			out.rz.textContent = z.toFixed(1);
		}
		if (check) { check.x.push(x); check.y.push(y); check.z.push(z); }
		if (turn && lastT) {
			var dt = (now - lastT) / 1000;
			if (dt > 0 && dt < 0.5) { turn.deg += z * dt; turn.tilt = Math.max(turn.tilt, Math.abs(x), Math.abs(y)); }
			turnBtn.textContent = 'Stop at ' + Math.abs(turn.deg).toFixed(0) + '°';
		}
		lastT = now;
	}

	function start() {
		S.request().then(function (state) {
			if (state !== 'granted') { U.status(statusEl, S.message(state, 'gyroscope'), 'bad'); return; }
			running = true;
			offs.push(S.on('deviceorientation', onOrient), S.on('devicemotion', onMotion));
			startBtn.textContent = 'Stop';
			stillBtn.disabled = false;
			turnBtn.disabled = false;
			U.status(statusEl, 'Listening to the gyroscope... move the phone.', '');
			hzTimer = setInterval(function () { out.hz.textContent = rate.hz() + ' Hz'; }, 500);
			setTimeout(function () {
				if (!running || gotRate) { return; }
				if (gotMotion) {
					setHas('No', false);
					U.status(statusEl, 'Motion data arrives but without rotation rate: this device has an accelerometer and no gyroscope (common on budget phones and tablets). ' + (gotOrient ? 'The tilt angles above come from the accelerometer and compass instead.' : ''), 'bad');
				} else {
					setHas('No data', false);
					U.status(statusEl, S.message('nodata', 'gyroscope'), 'bad');
				}
			}, 2000);
		});
	}

	function stop() {
		running = false;
		offs.forEach(function (f) { f(); });
		offs = [];
		clearInterval(hzTimer);
		check = turn = null;
		startBtn.textContent = 'Start gyroscope test';
		stillBtn.disabled = turnBtn.disabled = true;
		stillBtn.textContent = 'Drift check (10 s)';
		turnBtn.textContent = 'Full turn check';
		U.status(statusEl, 'Stopped.', '');
	}

	function show(html, ok) {
		result.innerHTML = html;
		result.className = 'sn-result ' + (ok ? 'is-ok' : 'is-bad');
		result.hidden = false;
	}

	startBtn.addEventListener('click', function () { if (running) { stop(); } else { start(); } });

	stillBtn.addEventListener('click', function () {
		if (check || !gotRate) { if (!gotRate) { U.status(statusEl, 'Waiting for gyroscope data first.', 'bad'); } return; }
		check = { x: [], y: [], z: [] };
		var left = 10;
		stillBtn.disabled = true;
		stillBtn.textContent = 'Keep still... ' + left;
		U.status(statusEl, 'Lay the phone flat on a table and do not touch it for 10 seconds.', '');
		var t = setInterval(function () {
			left--;
			if (check && left > 0) { stillBtn.textContent = 'Keep still... ' + left; return; }
			clearInterval(t);
			stillBtn.disabled = !running;
			stillBtn.textContent = 'Drift check (10 s)';
			if (!check) { return; }
			var sx = S.stats(check.x), sy = S.stats(check.y), sz = S.stats(check.z);
			check = null;
			var bias = Math.max(Math.abs(sx.mean), Math.abs(sy.mean), Math.abs(sz.mean)), noise = Math.max(sx.sd, sy.sd, sz.sd);
			var verdict = bias < 0.5 && noise < 0.5 ? 'Steady: no drift to speak of.' : bias < 2 && noise < 2 ? 'Normal: a little drift, which the phone corrects for in games and maps.' : 'High drift or the phone moved. Run it again flat on a table; if it stays high, calibrate the gyroscope (see the fixes below).';
			show('<strong>Drift check: ' + verdict + '</strong><br>Bias (average reading while still): X ' + sx.mean.toFixed(2) + ', Y ' + sy.mean.toFixed(2) + ', Z ' + sz.mean.toFixed(2) + ' °/s. Noise: ' + noise.toFixed(2) + ' °/s over ' + sx.n + ' samples.', bias < 2 && noise < 2);
			U.status(statusEl, 'Drift check done.', 'ok');
		}, 1000);
	});

	turnBtn.addEventListener('click', function () {
		if (!gotRate) { U.status(statusEl, 'Waiting for gyroscope data first.', 'bad'); return; }
		if (!turn) {
			turn = { deg: 0, tilt: 0 };
			turnBtn.textContent = 'Stop at 0°';
			U.status(statusEl, 'Flat on a table, line the phone up with an edge, turn it one full circle back to the same spot, then tap Stop.', '');
			return;
		}
		var deg = Math.abs(turn.deg), err = deg - 360;
		turn = null;
		turnBtn.textContent = 'Full turn check';
		if (deg < 180) { show('Only ' + deg.toFixed(0) + '° was measured. Turn the phone a full circle flat on the table before tapping Stop.', false); return; }
		var good = Math.abs(err) <= 10;
		show('<strong>Full turn: ' + deg.toFixed(0) + '° measured (' + (err >= 0 ? '+' : '') + err.toFixed(0) + '° against 360°).</strong> ' + (good ? 'The gyroscope measures rotation accurately.' : Math.abs(err) <= 25 ? 'A small error; check you stopped exactly where you started.' : 'A large error: either the turn was not a full circle or the gyroscope scale is off.'), Math.abs(err) <= 25);
	});

	$('#gy-reset').addEventListener('click', function () { peak = 0; out.peak.textContent = '0°/s'; graph.clear(); result.hidden = true; });
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { stop(); } });
	setHas(S.needsTap ? 'Tap Start' : '-', true);
	out.has.className = 'stat-value';
})();
