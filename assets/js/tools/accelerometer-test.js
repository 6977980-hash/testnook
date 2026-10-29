/* Accelerometer test: live X/Y/Z acceleration (with and without gravity), total g-force and peak, a shake counter,
   the orientation the gravity vector implies next to the one the screen reports (for auto-rotate problems), and a
   5 second still check that compares the measured gravity with 9.81 m/s2. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="accelerometer-test"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };
	var G = 9.80665;

	var startBtn = $('#ac-start'), stillBtn = $('#ac-still'), statusEl = $('#ac-status'), result = $('#ac-result');
	var out = { x: $('#ac-x'), y: $('#ac-y'), z: $('#ac-z'), total: $('#ac-total'), peak: $('#ac-peak'), shakes: $('#ac-shakes'), lin: $('#ac-lin'), hz: $('#ac-hz'), pose: $('#ac-pose'), screen: $('#ac-screen'), rotate: $('#ac-rotate') };
	var graph = S.Graph($('#ac-graph'), { symmetric: true, range: 12 });
	var rate = S.Rate(), offs = [], running = false, got = false, mode = 'g', peak = 0, shakes = 0, lastShake = 0, lp = null, beta = null, gamma = null, check = null, paintT = 0, hzTimer = 0;

	function pose(g) {
		var x = g.x / G, y = g.y / G, z = g.z / G;
		if (Math.abs(z) > 0.8) { return z > 0 ? 'Flat, screen up' : 'Flat, screen down'; }
		if (Math.abs(y) >= Math.abs(x)) { return y > 0 ? 'Portrait' : 'Portrait, upside down'; }
		return x > 0 ? 'Landscape, top to the left' : 'Landscape, top to the right';
	}

	function screenPose() {
		var t = screen.orientation && screen.orientation.type;
		if (t) { return t.indexOf('landscape') === 0 ? 'Landscape' : 'Portrait'; }
		return window.innerWidth > window.innerHeight ? 'Landscape' : 'Portrait';
	}

	function onOrient(e) { beta = e.beta; gamma = e.gamma; }

	function onMotion(e) {
		var raw = e.accelerationIncludingGravity;
		if (!raw || raw.x === null || raw.x === undefined) { return; }
		S.learnFlip(raw, beta, gamma);
		var g = S.gravity(e);
		if (!got) { got = true; U.status(statusEl, 'Accelerometer is working. Tilt and shake the phone.', 'ok'); }
		rate.tick();
		var lin = e.acceleration && e.acceleration.x !== null && e.acceleration.x !== undefined ? { x: e.acceleration.x * S.flip(), y: e.acceleration.y * S.flip(), z: e.acceleration.z * S.flip() } : null;
		// Without a linear acceleration reading, estimate it by removing a low-passed gravity vector.
		lp = lp ? { x: lp.x * 0.9 + g.x * 0.1, y: lp.y * 0.9 + g.y * 0.1, z: lp.z * 0.9 + g.z * 0.1 } : { x: g.x, y: g.y, z: g.z };
		if (!lin) { lin = { x: g.x - lp.x, y: g.y - lp.y, z: g.z - lp.z }; }
		var total = Math.sqrt(g.x * g.x + g.y * g.y + g.z * g.z), linMag = Math.sqrt(lin.x * lin.x + lin.y * lin.y + lin.z * lin.z);
		if (total / G > peak) { peak = total / G; out.peak.textContent = peak.toFixed(2) + ' g'; }
		var now = performance.now();
		if (linMag > 14 && now - lastShake > 350) { lastShake = now; shakes++; out.shakes.textContent = shakes; }
		graph.push(mode === 'g' ? [g.x, g.y, g.z] : [lin.x, lin.y, lin.z]);
		if (check) { check.push(g); }
		if (now - paintT > 100) {
			paintT = now;
			var v = mode === 'g' ? g : lin;
			out.x.textContent = v.x.toFixed(2);
			out.y.textContent = v.y.toFixed(2);
			out.z.textContent = v.z.toFixed(2);
			out.total.textContent = (total / G).toFixed(2) + ' g';
			out.lin.textContent = linMag.toFixed(1) + ' m/s²';
			var p = pose(lp), sp = screenPose();
			out.pose.textContent = p;
			out.screen.textContent = sp;
			var mismatch = (p.indexOf('Landscape') === 0 && sp === 'Portrait') || (p === 'Portrait' && sp === 'Landscape');
			out.rotate.hidden = !mismatch;
		}
	}

	function start() {
		S.request().then(function (state) {
			if (state !== 'granted') { U.status(statusEl, S.message(state, 'accelerometer'), 'bad'); return; }
			running = true;
			offs.push(S.on('deviceorientation', onOrient), S.on('devicemotion', onMotion));
			startBtn.textContent = 'Stop';
			stillBtn.disabled = false;
			U.status(statusEl, 'Listening to the accelerometer...', '');
			hzTimer = setInterval(function () { out.hz.textContent = rate.hz() + ' Hz'; }, 500);
			setTimeout(function () { if (running && !got) { U.status(statusEl, S.message('nodata', 'accelerometer'), 'bad'); } }, 2000);
		});
	}

	function stop() {
		running = false;
		offs.forEach(function (f) { f(); });
		offs = [];
		check = null;
		clearInterval(hzTimer);
		startBtn.textContent = 'Start accelerometer test';
		stillBtn.disabled = true;
		stillBtn.textContent = 'Gravity check (5 s)';
		U.status(statusEl, 'Stopped.', '');
	}

	startBtn.addEventListener('click', function () { if (running) { stop(); } else { start(); } });

	$$('[data-ac-mode]').forEach(function (b) {
		b.addEventListener('click', function () {
			mode = b.getAttribute('data-ac-mode');
			$$('[data-ac-mode]').forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			$('#ac-unit').textContent = mode === 'g' ? 'Acceleration including gravity (m/s²)' : 'Acceleration without gravity: movement only (m/s²)';
			graph.clear();
		});
	});
	function $$(s) { return Array.prototype.slice.call(root.querySelectorAll(s)); }

	stillBtn.addEventListener('click', function () {
		if (!got) { U.status(statusEl, 'Waiting for accelerometer data first.', 'bad'); return; }
		if (check) { return; }
		check = [];
		var left = 5;
		stillBtn.disabled = true;
		stillBtn.textContent = 'Keep still... ' + left;
		U.status(statusEl, 'Lay the phone flat on a table, screen up, and do not touch it.', '');
		var t = setInterval(function () {
			left--;
			if (check && left > 0) { stillBtn.textContent = 'Keep still... ' + left; return; }
			clearInterval(t);
			stillBtn.disabled = !running;
			stillBtn.textContent = 'Gravity check (5 s)';
			if (!check || !check.length) { check = null; return; }
			var mags = check.map(function (g) { return Math.sqrt(g.x * g.x + g.y * g.y + g.z * g.z); });
			var sx = S.stats(check.map(function (g) { return g.x; })), sy = S.stats(check.map(function (g) { return g.y; })), sz = S.stats(check.map(function (g) { return g.z; })), sm = S.stats(mags);
			check = null;
			var err = sm.mean - G, flat = Math.abs(sz.mean) > 9;
			var good = Math.abs(err) < 0.35 && sm.sd < 0.15;
			var ok = Math.abs(err) < 0.7 && sm.sd < 0.4;
			result.innerHTML = '<strong>Gravity check: ' + sm.mean.toFixed(2) + ' m/s² measured, ' + (err >= 0 ? '+' : '') + err.toFixed(2) + ' against 9.81.</strong> ' +
				(good ? 'Accurate and steady.' : ok ? 'Within the normal range for phone sensors.' : 'Off by more than usual, or the phone moved. Repeat it on a flat, still surface.') +
				'<br>Average: X ' + sx.mean.toFixed(2) + ', Y ' + sy.mean.toFixed(2) + ', Z ' + sz.mean.toFixed(2) + ' m/s². Noise: ' + sm.sd.toFixed(3) + ' m/s².' +
				(flat ? (Math.abs(sx.mean) > 0.5 || Math.abs(sy.mean) > 0.5 ? ' X or Y is above 0.5 while flat: the table may not be level, or the sensor has an offset (try the <a href="/bubble-level/">bubble level</a> to compare).' : '') : ' The phone was not flat, so only the total is compared.');
			result.className = 'sn-result ' + (ok ? 'is-ok' : 'is-bad');
			result.hidden = false;
			U.status(statusEl, 'Gravity check done.', 'ok');
		}, 1000);
	});

	$('#ac-reset').addEventListener('click', function () { peak = 0; shakes = 0; out.peak.textContent = '-'; out.shakes.textContent = '0'; graph.clear(); result.hidden = true; });
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { stop(); } });
})();
