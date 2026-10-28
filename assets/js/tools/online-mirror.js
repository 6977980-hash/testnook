/* Online mirror: front camera preview, mirrored by default, with freeze, zoom, brightness, a white "ring light" frame and a photo download. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="online-mirror"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var video = $('#om-video'), still = $('#om-still'), empty = $('#om-empty'), statusEl = $('#om-status');
	var startBtn = $('#om-start'), flipBtn = $('#om-flip'), freezeBtn = $('#om-freeze'), saveBtn = $('#om-save'), lightBtn = $('#om-light');
	var zoom = $('#om-zoom'), bright = $('#om-bright'), devSel = $('#om-device');
	var stream = null, frozen = false, mirrored = true, photoUrl = '';

	function apply() {
		var z = Number(zoom.value) / 100, b = Number(bright.value) / 100;
		var t = 'scale(' + (mirrored ? -z : z) + ',' + z + ')';
		video.style.transform = still.style.transform = t;
		video.style.filter = still.style.filter = 'brightness(' + b + ')';
		$('#om-zoomout').textContent = z.toFixed(1) + 'x';
		$('#om-brightout').textContent = Math.round(b * 100) + '%';
	}

	function release() {
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = null;
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
			U.status(statusEl, U.mediaError({ name: '' }, 'camera'), 'bad');
			return;
		}
		release();
		unfreeze();
		startBtn.disabled = true;
		U.status(statusEl, 'Waiting for camera permission...', '');
		var v = { width: { ideal: 1280 }, height: { ideal: 720 } };
		if (devSel.value) { v.deviceId = { exact: devSel.value }; } else { v.facingMode = 'user'; }
		navigator.mediaDevices.getUserMedia({ video: v, audio: false }).then(function (s) {
			stream = s;
			video.srcObject = s;
			video.hidden = false;
			empty.hidden = true;
			var p = video.play();
			if (p && p.catch) { p.catch(function () {}); }
			startBtn.disabled = false;
			startBtn.textContent = 'Stop mirror';
			startBtn.classList.remove('btn-primary');
			freezeBtn.disabled = false;
			U.status(statusEl, 'Mirror on. Nothing is recorded or uploaded.', 'ok');
			s.getVideoTracks()[0].addEventListener('ended', function () { stop('The camera was disconnected or taken by another app.'); });
			listDevices(s.getVideoTracks()[0].getSettings().deviceId);
		}).catch(function (err) {
			startBtn.disabled = false;
			U.status(statusEl, U.mediaError(err, 'camera'), 'bad');
		});
	}

	function stop(msg) {
		release();
		unfreeze();
		video.srcObject = null;
		video.hidden = true;
		empty.hidden = false;
		startBtn.textContent = 'Start mirror';
		startBtn.classList.add('btn-primary');
		freezeBtn.disabled = true;
		U.status(statusEl, msg || 'Mirror off. The camera is released.', msg ? 'bad' : '');
	}

	function listDevices(activeId) {
		navigator.mediaDevices.enumerateDevices().then(function (list) {
			var cams = list.filter(function (d) { return d.kind === 'videoinput'; });
			devSel.innerHTML = '';
			cams.forEach(function (d, i) {
				var o = document.createElement('option');
				o.value = d.deviceId;
				o.textContent = d.label || 'Camera ' + (i + 1);
				if (d.deviceId === activeId) { o.selected = true; }
				devSel.appendChild(o);
			});
			devSel.hidden = cams.length < 2;
		});
	}

	function freeze() {
		var w = video.videoWidth, h = video.videoHeight;
		if (!w) { return; }
		still.width = w;
		still.height = h;
		still.getContext('2d').drawImage(video, 0, 0, w, h);
		still.hidden = false;
		video.hidden = true;
		frozen = true;
		freezeBtn.textContent = 'Unfreeze';
		freezeBtn.setAttribute('aria-pressed', 'true');
		saveBtn.hidden = false;
		U.status(statusEl, 'Frozen. Take a closer look, or save the picture to your device.', 'ok');
	}

	function unfreeze() {
		if (!frozen) { return; }
		frozen = false;
		still.hidden = true;
		video.hidden = !stream;
		freezeBtn.textContent = 'Freeze';
		freezeBtn.setAttribute('aria-pressed', 'false');
		saveBtn.hidden = true;
	}

	// Save what the user sees: mirrored, zoomed (centre crop) and with the brightness applied.
	function save() {
		var w = still.width, h = still.height, z = Number(zoom.value) / 100;
		var c = document.createElement('canvas');
		c.width = w;
		c.height = h;
		var g = c.getContext('2d');
		if ('filter' in g) { g.filter = 'brightness(' + Number(bright.value) / 100 + ')'; }
		g.translate(w / 2, h / 2);
		g.scale(mirrored ? -z : z, z);
		g.drawImage(still, -w / 2, -h / 2);
		c.toBlob(function (blob) {
			if (!blob) { return; }
			if (photoUrl) { URL.revokeObjectURL(photoUrl); }
			photoUrl = URL.createObjectURL(blob);
			var a = document.createElement('a');
			a.href = photoUrl;
			a.download = 'mirror.png';
			document.body.appendChild(a);
			a.click();
			a.remove();
		}, 'image/png');
	}

	startBtn.addEventListener('click', function () { if (stream) { stop(); } else { start(); } });
	freezeBtn.addEventListener('click', function () { if (frozen) { unfreeze(); } else { freeze(); } });
	saveBtn.addEventListener('click', save);
	flipBtn.addEventListener('click', function () {
		mirrored = !mirrored;
		flipBtn.setAttribute('aria-pressed', mirrored ? 'true' : 'false');
		apply();
	});
	lightBtn.addEventListener('click', function () {
		var on = root.classList.toggle('om-lit');
		lightBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
	});
	zoom.addEventListener('input', apply);
	bright.addEventListener('input', apply);
	devSel.addEventListener('change', function () { if (stream) { start(); } });
	window.addEventListener('pagehide', release);
	apply();
}());
