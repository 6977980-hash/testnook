/* Camera test: front / back camera switching, per-camera resolution, frame rate and aspect ratio, torch where available, snapshot. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="camera-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var video = $('#ct-video'), empty = $('#ct-empty'), startBtn = $('#ct-start'), stopBtn = $('#ct-stop'), flipBtn = $('#ct-flip');
	var snapBtn = $('#ct-snap'), torchBtn = $('#ct-torch'), devSel = $('#ct-device'), statusEl = $('#ct-status'), list = $('#ct-list');
	var out = { res: $('#ct-res'), fps: $('#ct-fps'), ar: $('#ct-ar'), facing: $('#ct-facing'), name: $('#ct-name') };

	var stream = null, facing = 'user', frames = 0, fpsTimer = 0, rvfcId = 0, shotUrl = '', torch = false, results = {};
	var hasRVFC = 'requestVideoFrameCallback' in HTMLVideoElement.prototype;

	function gcd(a, b) { return b ? gcd(b, a % b) : a; }
	function ratio(w, h) {
		var r = w / h;
		if (Math.abs(r - 16 / 9) < 0.02) { return '16:9'; }
		if (Math.abs(r - 4 / 3) < 0.02) { return '4:3'; }
		if (Math.abs(r - 3 / 2) < 0.02) { return '3:2'; }
		var g = gcd(w, h);
		return (w / g) + ':' + (h / g);
	}

	function constraints() {
		var v = { width: { ideal: 1920 }, height: { ideal: 1080 } };
		if (devSel.value) { v.deviceId = { exact: devSel.value }; } else { v.facingMode = facing; }
		return { video: v, audio: false };
	}

	function release() {
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = null;
		clearInterval(fpsTimer);
		if (hasRVFC && rvfcId) { video.cancelVideoFrameCallback(rvfcId); }
		rvfcId = 0;
		torch = false;
		torchBtn.hidden = true;
		torchBtn.setAttribute('aria-pressed', 'false');
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
			U.status(statusEl, U.mediaError({ name: '' }, 'camera'), 'bad');
			return;
		}
		release();
		startBtn.disabled = true;
		U.status(statusEl, 'Waiting for camera permission...', '');
		navigator.mediaDevices.getUserMedia(constraints()).then(function (s) {
			stream = s;
			video.srcObject = s;
			video.hidden = false;
			empty.hidden = true;
			var p = video.play();
			if (p && p.catch) { p.catch(function () {}); }
			stopBtn.disabled = flipBtn.disabled = snapBtn.disabled = false;
			startBtn.disabled = false;
			startBtn.textContent = 'Restart';
			var track = s.getVideoTracks()[0], st = track.getSettings();
			facing = st.facingMode || facing;
			root.classList.toggle('is-mirrored', facing !== 'environment');
			out.facing.textContent = facing === 'environment' ? 'Back' : facing === 'user' ? 'Front' : 'Unknown';
			out.name.textContent = track.label || 'Camera';
			var caps = track.getCapabilities ? track.getCapabilities() : {};
			torchBtn.hidden = !(caps && caps.torch);
			U.status(statusEl, 'Camera working: ' + (track.label || 'camera') + '. ' + (facing === 'environment' ? 'Showing the back camera.' : 'Showing the front camera.'), 'ok');
			track.addEventListener('ended', function () { stop('The camera was disconnected or taken by another app.'); });
			listDevices(st.deviceId);
			measure(track);
		}).catch(function (err) {
			startBtn.disabled = false;
			if (err && err.name === 'OverconstrainedError' && !devSel.value) {
				U.status(statusEl, 'No ' + (facing === 'environment' ? 'back' : 'front') + ' camera was found on this device.', 'bad');
			} else {
				U.status(statusEl, U.mediaError(err, 'camera'), 'bad');
			}
		});
	}

	function stop(msg) {
		release();
		video.srcObject = null;
		video.hidden = true;
		empty.hidden = false;
		stopBtn.disabled = flipBtn.disabled = snapBtn.disabled = true;
		startBtn.textContent = 'Start camera';
		out.fps.textContent = '-';
		U.status(statusEl, msg || 'Camera stopped.', msg ? 'bad' : '');
	}

	function listDevices(activeId) {
		navigator.mediaDevices.enumerateDevices().then(function (all) {
			var cams = all.filter(function (d) { return d.kind === 'videoinput'; });
			devSel.innerHTML = '';
			var o0 = document.createElement('option');
			o0.value = '';
			o0.textContent = 'Auto (front / back)';
			devSel.appendChild(o0);
			cams.forEach(function (d, i) {
				var o = document.createElement('option');
				o.value = d.deviceId;
				o.textContent = d.label || 'Camera ' + (i + 1);
				if (d.deviceId === activeId && devSel.value) { o.selected = true; }
				devSel.appendChild(o);
			});
			devSel.hidden = cams.length < 2;
			flipBtn.hidden = cams.length < 2;
			$('#ct-count').textContent = cams.length;
		});
	}

	function record(track) {
		var w = video.videoWidth, h = video.videoHeight;
		if (!w || !track) { return; }
		var key = track.getSettings().deviceId || facing;
		var fps = out.fps.textContent;
		results[key] = { name: track.label || (facing === 'environment' ? 'Back camera' : 'Front camera'), res: w + 'x' + h, ar: ratio(w, h), fps: fps, facing: out.facing.textContent };
		var html = '';
		Object.keys(results).forEach(function (k) {
			var r = results[k];
			html += '<li><strong>' + r.name.replace(/</g, '&lt;') + '</strong> (' + r.facing + '): ' + r.res + ', ' + r.ar + ', ' + r.fps + '</li>';
		});
		list.innerHTML = html;
		list.parentNode.hidden = false;
	}

	function showSize() {
		var w = video.videoWidth, h = video.videoHeight;
		if (!w) { return; }
		out.res.textContent = w + 'x' + h + ' (' + U.fmt(w * h / 1e6, 1) + ' MP)';
		out.ar.textContent = ratio(w, h);
	}

	function measure(track) {
		frames = 0;
		clearInterval(fpsTimer);
		var last = performance.now();
		if (hasRVFC) {
			var onFrame = function () { frames++; rvfcId = video.requestVideoFrameCallback(onFrame); };
			rvfcId = video.requestVideoFrameCallback(onFrame);
		}
		fpsTimer = setInterval(function () {
			showSize();
			var now = performance.now();
			if (hasRVFC) {
				out.fps.textContent = Math.round(frames * 1000 / (now - last)) + ' fps';
				frames = 0;
				last = now;
			} else if (stream) {
				var fr = track.getSettings().frameRate;
				out.fps.textContent = fr ? Math.round(fr) + ' fps' : 'n/a';
			}
			record(track);
		}, 1000);
	}

	function flip() {
		facing = facing === 'environment' ? 'user' : 'environment';
		devSel.value = '';
		start();
	}

	function toggleTorch() {
		if (!stream) { return; }
		var track = stream.getVideoTracks()[0];
		torch = !torch;
		track.applyConstraints({ advanced: [{ torch: torch }] }).then(function () {
			torchBtn.setAttribute('aria-pressed', torch ? 'true' : 'false');
			U.status(statusEl, torch ? 'Flash on.' : 'Flash off.', 'ok');
		}).catch(function () {
			torch = false;
			U.status(statusEl, 'This browser cannot control the flash.', 'bad');
		});
	}

	function snapshot() {
		var w = video.videoWidth, h = video.videoHeight;
		if (!w) { return; }
		var c = document.createElement('canvas');
		c.width = w;
		c.height = h;
		var g = c.getContext('2d');
		if (root.classList.contains('is-mirrored')) { g.translate(w, 0); g.scale(-1, 1); }
		g.drawImage(video, 0, 0, w, h);
		c.toBlob(function (blob) {
			if (!blob) { return; }
			if (shotUrl) { URL.revokeObjectURL(shotUrl); }
			shotUrl = URL.createObjectURL(blob);
			var a = document.createElement('a');
			a.href = shotUrl;
			a.download = 'camera-test.png';
			a.target = '_self';
			a.textContent = 'Download photo';
			a.className = 'btn btn-sm ct-download';
			var old = root.querySelector('.ct-download');
			if (old) { old.remove(); }
			snapBtn.insertAdjacentElement('afterend', a);
			U.status(statusEl, 'Photo taken (' + w + 'x' + h + '). It stays on your device unless you download it.', 'ok');
		}, 'image/png');
	}

	startBtn.addEventListener('click', start);
	stopBtn.addEventListener('click', function () { stop(); });
	flipBtn.addEventListener('click', flip);
	snapBtn.addEventListener('click', snapshot);
	torchBtn.addEventListener('click', toggleTorch);
	devSel.addEventListener('change', function () { if (stream) { start(); } });
	video.addEventListener('loadedmetadata', showSize);
	video.addEventListener('resize', showSize);
	window.addEventListener('pagehide', release);
	document.addEventListener('visibilitychange', function () { if (document.hidden && stream) { stop('Camera stopped because the page was hidden.'); } });

	if (!U.isTouch()) { flipBtn.hidden = true; }
}());
