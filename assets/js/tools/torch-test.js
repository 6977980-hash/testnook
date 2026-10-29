/* Torch test: opens the back camera, finds a track whose capabilities include torch, and switches the LED on, off, as a strobe or as SOS.
   Phones with several back cameras often expose the torch on one of them only, so every back camera is tried in turn.
   Without torch control, a full-screen white "screen light" is offered instead. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="torch-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var startBtn = $('#tt-start'), onBtn = $('#tt-on'), strobeBtn = $('#tt-strobe'), sosBtn = $('#tt-sos'), hz = $('#tt-hz'), hzOut = $('#tt-hzout');
	var video = $('#tt-video'), bulb = $('#tt-bulb'), statusEl = $('#tt-status'), light = $('#tt-light'), controls = $('#tt-controls');
	var out = { support: $('#tt-support'), cam: $('#tt-cam'), state: $('#tt-state') };
	var stream = null, track = null, on = false, timer = 0, mode = '', busy = false;

	function stopStream() {
		clearTimeout(timer);
		mode = '';
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = track = null;
		on = false;
		paint();
	}

	function paint() {
		bulb.classList.toggle('is-on', on);
		out.state.textContent = mode === 'strobe' ? 'Strobe' : mode === 'sos' ? 'SOS' : on ? 'On' : 'Off';
		onBtn.setAttribute('aria-pressed', on && !mode ? 'true' : 'false');
		onBtn.textContent = on && !mode ? 'Turn torch off' : 'Turn torch on';
		strobeBtn.setAttribute('aria-pressed', mode === 'strobe' ? 'true' : 'false');
		sosBtn.setAttribute('aria-pressed', mode === 'sos' ? 'true' : 'false');
	}

	function hasTorch(t) {
		var c = t && t.getCapabilities ? t.getCapabilities() : null;
		return !!(c && c.torch);
	}

	function open(constraints) {
		return navigator.mediaDevices.getUserMedia({ video: constraints, audio: false });
	}

	// Try the default back camera first, then every other camera whose label says back / rear / environment.
	function findTorch(s) {
		var t = s.getVideoTracks()[0];
		if (hasTorch(t)) { return Promise.resolve({ s: s, t: t }); }
		return navigator.mediaDevices.enumerateDevices().then(function (list) {
			var ids = list.filter(function (d) { return d.kind === 'videoinput' && d.deviceId && d.deviceId !== (t.getSettings().deviceId || ''); })
				.sort(function (a, b) { return (/back|rear|environment/i.test(b.label) ? 1 : 0) - (/back|rear|environment/i.test(a.label) ? 1 : 0); })
				.map(function (d) { return d.deviceId; });
			s.getTracks().forEach(function (x) { x.stop(); });
			var i = 0;
			function next() {
				if (i >= ids.length) { return Promise.resolve(null); }
				return open({ deviceId: { exact: ids[i++] } }).then(function (s2) {
					var t2 = s2.getVideoTracks()[0];
					if (hasTorch(t2)) { return { s: s2, t: t2 }; }
					s2.getTracks().forEach(function (x) { x.stop(); });
					return next();
				}, next);
			}
			return next();
		});
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
			U.status(statusEl, U.mediaError({ name: '' }, 'camera'), 'bad');
			return;
		}
		stopStream();
		startBtn.disabled = true;
		U.status(statusEl, 'Waiting for camera permission (the torch is part of the camera)...', '');
		open({ facingMode: { ideal: 'environment' } }).then(findTorch).then(function (r) {
			startBtn.disabled = false;
			if (!r) {
				out.support.textContent = 'Not available';
				out.support.className = 'stat-value is-bad';
				out.cam.textContent = '-';
				controls.hidden = true;
				U.status(statusEl, /iPhone|iPad/.test(navigator.userAgent)
					? 'Safari on this iPhone does not let websites control the torch. Use Control Centre to test it, or the screen light below.'
					: U.isTouch() ? 'This browser or phone does not let websites control the torch. Try Chrome, or use the screen light below.' : 'No camera with a flash was found. Laptop webcams have no torch; use the screen light below.', 'bad');
				return;
			}
			stream = r.s;
			track = r.t;
			video.srcObject = stream;
			video.hidden = false;
			var p = video.play();
			if (p && p.catch) { p.catch(function () {}); }
			out.support.textContent = 'Supported';
			out.support.className = 'stat-value is-ok';
			out.cam.textContent = track.label || 'Back camera';
			controls.hidden = false;
			startBtn.textContent = 'Close camera';
			U.status(statusEl, 'Torch found. Tap "Turn torch on".', 'ok');
		}).catch(function (err) {
			startBtn.disabled = false;
			U.status(statusEl, U.mediaError(err, 'camera'), 'bad');
		});
	}

	function set(v) {
		if (!track || busy) { return Promise.resolve(); }
		busy = true;
		return track.applyConstraints({ advanced: [{ torch: v }] }).then(function () {
			busy = false;
			on = v;
			paint();
		}, function () {
			busy = false;
			mode = '';
			U.status(statusEl, 'The phone refused to switch the torch. Close other camera apps and try again.', 'bad');
			paint();
		});
	}

	function strobe() {
		if (mode !== 'strobe') { return; }
		var half = 500 / Number(hz.value);
		set(!on).then(function () { if (mode === 'strobe') { timer = setTimeout(strobe, Math.max(0, half - 20)); } });
	}

	var D = 200, SOS = [D, D, D, D, D, D * 3, D * 3, D, D * 3, D, D * 3, D * 3, D, D, D, D, D, D * 7];
	function sos(i) {
		if (mode !== 'sos') { return; }
		i = i % SOS.length;
		set(i % 2 === 0).then(function () { if (mode === 'sos') { timer = setTimeout(function () { sos(i + 1); }, SOS[i]); } });
	}

	startBtn.addEventListener('click', function () {
		if (stream) { stopStream(); startBtn.textContent = 'Start torch test'; controls.hidden = true; video.hidden = true; U.status(statusEl, 'Camera closed.', ''); }
		else { start(); }
	});
	onBtn.addEventListener('click', function () {
		clearTimeout(timer);
		var was = mode;
		mode = '';
		set(was ? false : !on).then(function () { U.status(statusEl, on ? 'Torch on. If the LED is not lit, the flash or its driver is faulty.' : 'Torch off.', on ? 'ok' : ''); });
	});
	strobeBtn.addEventListener('click', function () {
		clearTimeout(timer);
		if (mode === 'strobe') { mode = ''; set(false); return; }
		mode = 'strobe';
		paint();
		U.status(statusEl, 'Strobe at ' + hz.value + ' flashes per second. The phone may not keep up with high rates.', '');
		strobe();
	});
	sosBtn.addEventListener('click', function () {
		clearTimeout(timer);
		if (mode === 'sos') { mode = ''; set(false); return; }
		mode = 'sos';
		paint();
		U.status(statusEl, 'Flashing SOS in Morse code: three short, three long, three short.', '');
		sos(0);
	});
	hz.addEventListener('input', function () { hzOut.textContent = hz.value + ' Hz'; });

	$('#tt-screen').addEventListener('click', function () {
		light.hidden = false;
		U.enterFullscreen(light);
	});
	light.addEventListener('click', function () {
		if (U.isFullscreen()) { U.exitFullscreen(); }
		light.hidden = true;
	});
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		document.addEventListener(ev, function () { if (!document.fullscreenElement && !document.webkitFullscreenElement && !light.classList.contains('is-pseudo-fs')) { light.hidden = true; } });
	});
	light.addEventListener('tn:fullscreen', function (e) { if (!e.detail.on) { light.hidden = true; } });

	document.addEventListener('visibilitychange', function () { if (document.hidden && stream) { clearTimeout(timer); mode = ''; set(false); } });
	window.addEventListener('pagehide', stopStream);
	paint();
}());
