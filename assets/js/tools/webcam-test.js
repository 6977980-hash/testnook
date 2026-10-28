/* Webcam test: live preview, camera picker, measured resolution and frame rate, snapshot. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="webcam-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var video = $('#wc-video'), empty = $('#wc-empty'), shot = $('#wc-shot');
	var startBtn = $('#wc-start'), stopBtn = $('#wc-stop'), mirrorBtn = $('#wc-mirror'), snapBtn = $('#wc-snap');
	var devSel = $('#wc-device'), resSel = $('#wc-res'), statusEl = $('#wc-status');
	var out = { res: $('#wc-resv'), fps: $('#wc-fps'), mp: $('#wc-mp'), ar: $('#wc-ar') };

	var stream = null, frames = 0, fpsTimer = 0, rvfcId = 0, shotUrl = '';
	var hasRVFC = 'requestVideoFrameCallback' in HTMLVideoElement.prototype;

	function gcd(a, b) { return b ? gcd(b, a % b) : a; }
	function ratio(w, h) {
		var r = w / h;
		if (Math.abs(r - 16 / 9) < 0.02) { return '16:9'; }
		if (Math.abs(r - 4 / 3) < 0.02) { return '4:3'; }
		var g = gcd(w, h);
		return (w / g) + ':' + (h / g);
	}

	function constraints() {
		var w = Number(resSel.value);
		var v = { width: { ideal: w }, height: { ideal: Math.round(w * 9 / 16) } };
		if (devSel.value) { v.deviceId = { exact: devSel.value }; } else { v.facingMode = 'user'; }
		return { video: v, audio: false };
	}

	function release() {
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = null;
		clearInterval(fpsTimer);
		if (hasRVFC && rvfcId) { video.cancelVideoFrameCallback(rvfcId); }
		rvfcId = 0;
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
			shot.hidden = true;
			var p = video.play();
			if (p && p.catch) { p.catch(function () {}); }
			stopBtn.disabled = mirrorBtn.disabled = snapBtn.disabled = false;
			startBtn.disabled = false;
			startBtn.textContent = 'Restart camera';
			var track = s.getVideoTracks()[0];
			U.status(statusEl, 'Your webcam works: ' + (track.label || 'camera') + '.', 'ok');
			track.addEventListener('ended', function () { stop('The camera was disconnected or taken by another app.'); });
			listDevices(track.getSettings().deviceId);
			measure();
		}).catch(function (err) {
			startBtn.disabled = false;
			U.status(statusEl, U.mediaError(err, 'camera'), 'bad');
		});
	}

	function stop(msg) {
		release();
		video.srcObject = null;
		video.hidden = true;
		empty.hidden = false;
		stopBtn.disabled = mirrorBtn.disabled = snapBtn.disabled = true;
		startBtn.textContent = 'Start camera';
		out.fps.textContent = '-';
		U.status(statusEl, msg || 'Camera stopped.', msg ? 'bad' : '');
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

	function showSize() {
		var w = video.videoWidth, h = video.videoHeight;
		if (!w) { return; }
		out.res.textContent = w + 'x' + h;
		out.mp.textContent = U.fmt(w * h / 1e6, 1) + ' MP';
		out.ar.textContent = ratio(w, h);
	}

	function measure() {
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
				var fr = stream.getVideoTracks()[0].getSettings().frameRate;
				out.fps.textContent = fr ? Math.round(fr) + ' fps' : 'n/a';
			}
		}, 1000);
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
			a.download = 'webcam-snapshot.png';
			a.target = '_self';
			a.textContent = 'Download snapshot';
			a.className = 'btn btn-sm';
			var old = root.querySelector('.wc-download');
			if (old) { old.remove(); }
			a.classList.add('wc-download');
			snapBtn.insertAdjacentElement('afterend', a);
			U.status(statusEl, 'Snapshot taken (' + w + 'x' + h + '). It stays on your device unless you download it.', 'ok');
		}, 'image/png');
	}

	startBtn.addEventListener('click', start);
	stopBtn.addEventListener('click', function () { stop(); });
	snapBtn.addEventListener('click', snapshot);
	mirrorBtn.addEventListener('click', function () {
		var on = root.classList.toggle('is-mirrored');
		mirrorBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
	});
	devSel.addEventListener('change', function () { if (stream) { start(); } });
	resSel.addEventListener('change', function () { if (stream) { start(); } });
	video.addEventListener('loadedmetadata', showSize);
	video.addEventListener('resize', showSize);
	window.addEventListener('pagehide', release);

	root.classList.add('is-mirrored');
}());
