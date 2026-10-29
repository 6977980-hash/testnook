/* Zoom test: camera preview with lighting check, mic level with a record-and-play-back sample, speaker chime with output picker, and a ready checklist. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="zoom-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var video = $('#zt-video'), empty = $('#zt-empty'), startBtn = $('#zt-start'), statusEl = $('#zt-status');
	var camSel = $('#zt-cam'), micSel = $('#zt-mic'), spkSel = $('#zt-spk');
	var meter = $('#zt-meter'), recBtn = $('#zt-rec'), playback = $('#zt-playback'), chimeBtn = $('#zt-chime');
	var out = { res: $('#zt-res'), fps: $('#zt-fps'), light: $('#zt-light'), level: $('#zt-level') };
	var checks = { cam: $('#zt-ck-cam'), mic: $('#zt-ck-mic'), spk: $('#zt-ck-spk'), light: $('#zt-ck-light') };

	var stream = null, actx = null, analyser = null, buf = null, raf = 0, peakSince = 0, lastLoop = 0, heard = false;
	var probe = document.createElement('canvas'), pg = probe.getContext('2d', { willReadFrequently: true });
	probe.width = 64; probe.height = 36;
	var frames = 0, lastFps = performance.now(), lightAt = 0, chimeUrl = '', recUrl = '';
	var hasRVFC = 'requestVideoFrameCallback' in HTMLVideoElement.prototype;
	// Count real camera frames where the browser can; otherwise fall back to screen frames.
	function onFrame() { frames++; if (stream) { video.requestVideoFrameCallback(onFrame); } }

	function mark(el, state, text) {
		el.className = 'zt-check ' + (state === true ? 'is-ok' : state === false ? 'is-bad' : '');
		el.querySelector('span').textContent = text;
	}

	function fillDevices() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) { return; }
		navigator.mediaDevices.enumerateDevices().then(function (list) {
			[[camSel, 'videoinput', 'Camera'], [micSel, 'audioinput', 'Microphone'], [spkSel, 'audiooutput', 'Speaker']].forEach(function (d) {
				var keep = d[0].value;
				var items = list.filter(function (x) { return x.kind === d[1]; });
				d[0].innerHTML = '';
				items.forEach(function (x, i) {
					var o = document.createElement('option');
					o.value = x.deviceId;
					o.textContent = x.label || d[2] + ' ' + (i + 1);
					d[0].appendChild(o);
				});
				if (keep && items.some(function (x) { return x.deviceId === keep; })) { d[0].value = keep; }
				d[0].hidden = items.length < 2;
			});
			if (!('setSinkId' in HTMLMediaElement.prototype)) { spkSel.hidden = true; }
		});
	}

	function stop() {
		if (stream) { stream.getTracks().forEach(function (t) { t.stop(); }); }
		stream = null;
		cancelAnimationFrame(raf);
	}

	function start() {
		if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) { U.status(statusEl, U.mediaError({ name: '' }, 'camera and microphone'), 'bad'); return; }
		stop();
		var c = {
			video: camSel.value ? { deviceId: { exact: camSel.value }, width: { ideal: 1280 }, height: { ideal: 720 } } : { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } },
			audio: micSel.value ? { deviceId: { exact: micSel.value } } : true
		};
		U.status(statusEl, 'Allow the camera and microphone when the browser asks...', '');
		navigator.mediaDevices.getUserMedia(c).catch(function (err) {
			// No camera (or it is busy): carry on with the microphone only.
			if (err && (err.name === 'NotFoundError' || err.name === 'NotReadableError' || err.name === 'OverconstrainedError')) {
				mark(checks.cam, false, U.mediaError(err, 'camera'));
				return navigator.mediaDevices.getUserMedia({ audio: c.audio });
			}
			throw err;
		}).then(function (s) {
			stream = s;
			var vt = s.getVideoTracks()[0], at = s.getAudioTracks()[0];
			if (vt) {
				video.srcObject = s;
				video.hidden = false;
				empty.hidden = true;
				var p = video.play();
				if (p && p.catch) { p.catch(function () {}); }
				mark(checks.cam, true, 'Camera works: ' + (vt.label || 'camera'));
				if (hasRVFC) { video.requestVideoFrameCallback(onFrame); }
			} else {
				video.hidden = true;
				empty.hidden = false;
			}
			if (at) {
				var AC = window.AudioContext || window.webkitAudioContext;
				if (!actx) { actx = new AC(); }
				if (actx.state === 'suspended') { actx.resume(); }
				analyser = actx.createAnalyser();
				analyser.fftSize = 1024;
				buf = new Float32Array(analyser.fftSize);
				actx.createMediaStreamSource(new MediaStream([at])).connect(analyser);
				recBtn.disabled = false;
				mark(checks.mic, null, 'Say something: waiting for sound from ' + (at.label || 'the microphone') + '...');
			}
			startBtn.textContent = 'Restart camera and mic';
			U.status(statusEl, vt ? 'Camera and microphone are on. Speak to check the level, then test your speakers.' : 'Microphone is on, but no camera was found.', 'ok');
			fillDevices();
			raf = requestAnimationFrame(loop);
		}).catch(function (err) {
			U.status(statusEl, U.mediaError(err, 'camera and microphone'), 'bad');
		});
	}

	function loop(now) {
		raf = requestAnimationFrame(loop);
		if (analyser) {
			analyser.getFloatTimeDomainData(buf);
			var sum = 0;
			for (var i = 0; i < buf.length; i++) { sum += buf[i] * buf[i]; }
			var db = 20 * Math.log10(Math.sqrt(sum / buf.length) + 1e-9);
			var pct = Math.max(0, Math.min(100, (db + 60) / 60 * 100));
			meter.style.width = pct + '%';
			out.level.textContent = db < -90 ? '-' : Math.round(db) + ' dB';
			// Count total time above the speech threshold, so short words add up.
			if (db > -45) {
				peakSince += Math.min(50, now - (lastLoop || now));
				if (!heard && peakSince > 250) {
					heard = true;
					mark(checks.mic, true, 'Microphone picks up your voice' + (db > -3 ? ', but it is clipping: lower the input volume.' : '.'));
				}
			}
			lastLoop = now;
		}
		if (!video.hidden && video.videoWidth) {
			if (!hasRVFC) { frames++; }
			if (now - lastFps > 1000) {
				out.fps.textContent = Math.round(frames * 1000 / (now - lastFps));
				out.res.textContent = video.videoWidth + ' x ' + video.videoHeight;
				frames = 0; lastFps = now;
			}
			if (now - lightAt > 700) { lightAt = now; checkLight(); }
		}
	}

	// Average brightness of the picture, and of its centre (where a face usually is).
	function checkLight() {
		pg.drawImage(video, 0, 0, 64, 36);
		var d = pg.getImageData(0, 0, 64, 36).data, all = 0, mid = 0, nm = 0;
		for (var y = 0; y < 36; y++) {
			for (var x = 0; x < 64; x++) {
				var o = (y * 64 + x) * 4, l = 0.2126 * d[o] + 0.7152 * d[o + 1] + 0.0722 * d[o + 2];
				all += l;
				if (x > 20 && x < 44 && y > 6 && y < 30) { mid += l; nm++; }
			}
		}
		all /= 64 * 36; mid /= nm;
		var pct = Math.round(mid / 255 * 100);
		out.light.textContent = pct + '%';
		if (mid < 60) { mark(checks.light, false, 'Too dark: add a lamp or face a window. Light from behind you makes your face a silhouette.'); }
		else if (mid > 215) { mark(checks.light, false, 'Too bright: move the light further away or lower the camera exposure.'); }
		else if (all - mid > 45) { mark(checks.light, false, 'The background is much brighter than you: there is probably a window behind you.'); }
		else { mark(checks.light, true, 'Lighting looks good.'); }
	}

	// A two-note chime as a WAV file, so it can be sent to a chosen speaker with setSinkId.
	function chime() {
		if (chimeUrl) { return chimeUrl; }
		var rate = 44100, n = Math.round(rate * 1.2), data = new DataView(new ArrayBuffer(44 + n * 2));
		function str(o, s) { for (var i = 0; i < s.length; i++) { data.setUint8(o + i, s.charCodeAt(i)); } }
		str(0, 'RIFF'); data.setUint32(4, 36 + n * 2, true); str(8, 'WAVEfmt '); data.setUint32(16, 16, true);
		data.setUint16(20, 1, true); data.setUint16(22, 1, true); data.setUint32(24, rate, true); data.setUint32(28, rate * 2, true);
		data.setUint16(32, 2, true); data.setUint16(34, 16, true); str(36, 'data'); data.setUint32(40, n * 2, true);
		for (var i = 0; i < n; i++) {
			var t = i / rate, v = 0;
			if (t < 0.6) { v = Math.sin(2 * Math.PI * 784 * t) * Math.exp(-t * 5); }
			else { var u = t - 0.6; v = Math.sin(2 * Math.PI * 1047 * u) * Math.exp(-u * 4); }
			data.setInt16(44 + i * 2, Math.max(-1, Math.min(1, v * 0.5)) * 32767, true);
		}
		chimeUrl = URL.createObjectURL(new Blob([data], { type: 'audio/wav' }));
		return chimeUrl;
	}

	function sink(el) {
		if (spkSel.value && el.setSinkId) { return el.setSinkId(spkSel.value).catch(function () {}); }
		return Promise.resolve();
	}

	chimeBtn.addEventListener('click', function () {
		var a = new Audio(chime());
		sink(a).then(function () { return a.play(); }).then(function () {
			$('#zt-heard').hidden = false;
		}).catch(function () { U.status(statusEl, 'The browser blocked the sound. Click the button again.', 'bad'); });
	});
	U.$$('[data-zt-heard]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			var yes = b.getAttribute('data-zt-heard') === '1';
			mark(checks.spk, yes, yes ? 'Speakers or headphones work.' : 'No sound: check the volume, mute key and the output device (see the fixes below).');
			$('#zt-heard').hidden = true;
		});
	});

	recBtn.addEventListener('click', function () {
		if (!stream || !window.MediaRecorder) { U.status(statusEl, 'Recording is not supported in this browser.', 'bad'); return; }
		var at = stream.getAudioTracks()[0];
		if (!at) { return; }
		var rec = new MediaRecorder(new MediaStream([at])), parts = [], left = 5;
		rec.ondataavailable = function (e) { if (e.data.size) { parts.push(e.data); } };
		rec.onstop = function () {
			if (recUrl) { URL.revokeObjectURL(recUrl); }
			recUrl = URL.createObjectURL(new Blob(parts, { type: rec.mimeType || 'audio/webm' }));
			playback.src = recUrl;
			playback.hidden = false;
			sink(playback).then(function () { return playback.play(); }).catch(function () {});
			recBtn.disabled = false;
			recBtn.textContent = 'Record 5 s and play back';
			U.status(statusEl, 'Playing your recording. This is roughly how others will hear you (Zoom adds its own noise suppression).', 'ok');
		};
		rec.start();
		recBtn.disabled = true;
		recBtn.textContent = 'Recording... 5';
		var t = setInterval(function () {
			left--;
			if (left > 0) { recBtn.textContent = 'Recording... ' + left; return; }
			clearInterval(t);
			rec.stop();
		}, 1000);
	});

	startBtn.addEventListener('click', start);
	[camSel, micSel].forEach(function (s) { s.addEventListener('change', function () { if (stream) { heard = false; peakSince = 0; start(); } }); });
	window.addEventListener('pagehide', stop);
	fillDevices();
}());
