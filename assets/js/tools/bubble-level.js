/* Bubble level: a round level when the phone lies flat (beta and gamma from DeviceOrientation) and a bar level when
   it stands on an edge (angle of the gravity vector from DeviceMotion). Smoothed readings, a "set zero" calibration
   kept in localStorage, a hold button, and a short buzz when the reading becomes level. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="bubble-level"]');
	if (!root || !window.TNSensor) { return; }
	var U = window.TNUtil, S = window.TNSensor;
	var $ = function (s) { return root.querySelector(s); };
	var KEY = 'tn-level-cal', FULL = 10, LEVEL = 0.3;

	var startBtn = $('#lv-start'), zeroBtn = $('#lv-zero'), clearBtn = $('#lv-clear'), holdBtn = $('#lv-hold'), statusEl = $('#lv-status');
	var wrap = $('#lv-wrap'), disc = $('#lv-disc'), bar = $('#lv-bar'), bubble = $('#lv-bubble'), bubble2 = $('#lv-bubble2');
	var out = { a: $('#lv-a'), b: $('#lv-b'), al: $('#lv-al'), bl: $('#lv-bl'), mode: $('#lv-mode') };
	var offs = [], running = false, got = false, held = false, wasLevel = false;
	var sm = { b: null, g: null, e: null }, raw = { b: 0, g: 0 }, mode = 'flat';
	var cal = { b: 0, g: 0, e: 0 };
	try { var saved = JSON.parse(localStorage.getItem(KEY) || 'null'); if (saved && typeof saved.b === 'number') { cal = saved; } } catch (err) { /* private mode */ }

	function ease(prev, v, k) { return prev === null ? v : prev + (v - prev) * k; }
	function clamp(v, m) { return Math.max(-m, Math.min(m, v)); }

	function render() {
		if (held || !got) { return; }
		var level;
		if (mode === 'flat') {
			// Bubble offset in device axes (x right, y up), turned into screen axes when the page is rotated.
			var dx = -(sm.g - cal.g), dy = sm.b - cal.b, th = S.screenAngle() * Math.PI / 180;
			var x = dx * Math.cos(th) - dy * Math.sin(th), y = dx * Math.sin(th) + dy * Math.cos(th), r = Math.sqrt(x * x + y * y);
			var k = Math.min(1, FULL / Math.max(r, 0.0001));
			// px, py are percent of the disc (max 40); the bubble is 20% of the disc, so its own translate is 5 times that.
			var px = clamp(x * k / FULL * 40, 40), py = clamp(-y * k / FULL * 40, 40);
			bubble.style.transform = 'translate(' + (px * 5).toFixed(1) + '%, ' + (py * 5).toFixed(1) + '%)';
			out.a.textContent = Math.abs(x).toFixed(1) + '°';
			out.b.textContent = Math.abs(y).toFixed(1) + '°';
			out.al.textContent = 'Left / right';
			out.bl.textContent = 'Front / back';
			level = r < LEVEL;
		} else {
			var e = S.angleDiff(sm.e, cal.e);
			var bw = bar.clientWidth, bx = clamp(e / FULL, 1) * (bw / 2 - 26);
			bubble2.style.transform = 'translateX(' + bx.toFixed(1) + 'px)';
			out.a.textContent = Math.abs(e).toFixed(1) + '°';
			out.al.textContent = 'Tilt';
			out.b.textContent = (Math.abs(e) < 45 ? (e < 0 ? 'Right side low' : e > 0 ? 'Left side low' : 'Level') : '-');
			out.bl.textContent = 'Which side';
			level = Math.abs(e) < LEVEL;
		}
		wrap.classList.toggle('is-level', level);
		if (level && !wasLevel && navigator.vibrate) { try { navigator.vibrate(25); } catch (err) { /* blocked */ } }
		wasLevel = level;
	}

	function onOrient(e) {
		if (e.beta === null || e.beta === undefined) { return; }
		if (!got) { got = true; U.status(statusEl, 'Level is live. Put the phone on the surface to check.', 'ok'); }
		raw.b = e.beta; raw.g = e.gamma || 0;
		sm.b = ease(sm.b, e.beta, 0.25);
		sm.g = ease(sm.g, e.gamma || 0, 0.25);
		var edge = Math.abs(e.beta) > 55 || Math.abs(e.gamma || 0) > 55;
		if (edge !== (mode === 'edge')) {
			mode = edge ? 'edge' : 'flat';
			disc.hidden = edge;
			bar.hidden = !edge;
			out.mode.textContent = edge ? 'Edge (stand the phone on its side)' : 'Flat (lay the phone down)';
		}
		render();
	}

	function onMotion(e) {
		var raw0 = e.accelerationIncludingGravity;
		if (!raw0 || raw0.x === null || raw0.x === undefined) { return; }
		S.learnFlip(raw0, raw.b, raw.g);
		var g = S.gravity(e);
		// Angle of gravity in the screen plane, rounded to the nearest edge (0, 90, 180 or 270 degrees).
		var th = S.screenAngle() * Math.PI / 180, sx = g.x * Math.cos(th) - g.y * Math.sin(th), sy = g.x * Math.sin(th) + g.y * Math.cos(th);
		var ang = Math.atan2(sx, sy) * 180 / Math.PI, near = Math.round(ang / 90) * 90;
		var dev = ang - near;
		sm.e = sm.e === null ? dev : ease(sm.e, dev, 0.25);
		if (mode === 'edge') { render(); }
	}

	function start() {
		S.request().then(function (state) {
			if (state !== 'granted') { U.status(statusEl, S.message(state, 'motion sensors'), 'bad'); return; }
			running = true;
			offs.push(S.on('deviceorientation', onOrient), S.on('devicemotion', onMotion));
			startBtn.textContent = 'Stop';
			zeroBtn.disabled = holdBtn.disabled = false;
			U.status(statusEl, 'Reading the tilt sensor...', '');
			setTimeout(function () { if (running && !got) { U.status(statusEl, S.message('nodata', 'tilt sensor'), 'bad'); } }, 2000);
		});
	}

	function stop() {
		running = false;
		offs.forEach(function (f) { f(); });
		offs = [];
		startBtn.textContent = 'Start level';
		zeroBtn.disabled = holdBtn.disabled = true;
		U.status(statusEl, 'Stopped.', '');
	}

	startBtn.addEventListener('click', function () { if (running) { stop(); } else { start(); } });
	zeroBtn.addEventListener('click', function () {
		if (!got) { return; }
		if (mode === 'flat') { cal.b = sm.b; cal.g = sm.g; } else { cal.e = sm.e || 0; }
		try { localStorage.setItem(KEY, JSON.stringify(cal)); } catch (err) { /* private mode */ }
		clearBtn.hidden = false;
		U.status(statusEl, 'Zero set on this surface. Readings are now relative to it (saved on this device).', 'ok');
		render();
	});
	clearBtn.addEventListener('click', function () {
		cal = { b: 0, g: 0, e: 0 };
		try { localStorage.removeItem(KEY); } catch (err) { /* private mode */ }
		clearBtn.hidden = true;
		U.status(statusEl, 'Calibration cleared.', '');
		render();
	});
	holdBtn.addEventListener('click', function () {
		held = !held;
		holdBtn.setAttribute('aria-pressed', held ? 'true' : 'false');
		holdBtn.textContent = held ? 'Release' : 'Hold reading';
		if (!held) { render(); }
	});
	clearBtn.hidden = !(cal.b || cal.g || cal.e);
	document.addEventListener('visibilitychange', function () { if (document.hidden && running) { stop(); } });
})();
