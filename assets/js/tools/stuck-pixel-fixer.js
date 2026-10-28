/* Stuck pixel fixer: a draggable flashing box (or the whole screen) cycling random R/G/B/black/white. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="stuck-pixel-fixer"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var COLORS = ['#ff0000', '#00ff00', '#0000ff', '#000000', '#ffffff'];
	var agree = $('#spf-agree'), startBtn = $('#spf-start'), fullBtn = $('#spf-full'), stopBtn = $('#spf-stop');
	var size = $('#spf-size'), sizeOut = $('#spf-sizeout'), mins = $('#spf-mins'), statusEl = $('#spf-status');
	var box = $('#spf-box'), screen = $('#spf-screen'), preview = $('#spf-preview');
	var speedBtns = U.$$('[data-spf-speed]', root);

	var speed = 'fast', target = null, raf = 0, last = 0, startedAt = 0, statusAt = 0;
	var pos = null;

	function sizeBox() {
		var s = Number(size.value);
		sizeOut.textContent = s + ' px';
		box.style.width = box.style.height = s + 'px';
		var p = Math.min(s, 160);
		preview.style.width = preview.style.height = p + 'px';
		if (pos) { place(pos.x, pos.y); }
	}

	function place(x, y) {
		var s = Number(size.value);
		x = Math.max(0, Math.min(window.innerWidth - s, x));
		y = Math.max(0, Math.min(window.innerHeight - s, y));
		pos = { x: x, y: y };
		box.style.left = x + 'px';
		box.style.top = y + 'px';
	}

	function fmt(sec) { sec = Math.floor(sec); return Math.floor(sec / 60) + ':' + ('0' + (sec % 60)).slice(-2); }

	function loop(now) {
		raf = requestAnimationFrame(loop);
		if (speed === 'gentle' && now - last < 100) { return; }
		last = now;
		target.style.background = COLORS[(Math.random() * COLORS.length) | 0];
		var elapsed = (now - startedAt) / 1000, limit = Number(mins.value) * 60;
		if (now - statusAt > 1000) {
			statusAt = now;
			U.status(statusEl, 'Running ' + fmt(elapsed) + ' of ' + fmt(limit) + '. Press Esc or Stop to end.', '');
		}
		if (elapsed >= limit) { stop(true); }
	}

	function run(el) {
		stop();
		target = el;
		el.hidden = false;
		startedAt = performance.now();
		statusAt = 0;
		stopBtn.disabled = false;
		raf = requestAnimationFrame(loop);
	}

	function stop(done) {
		if (!target) { return; }
		cancelAnimationFrame(raf);
		var was = target;
		target = null;
		was.hidden = true;
		if (was === screen) { U.exitFullscreen(); }
		stopBtn.disabled = true;
		U.status(statusEl, done ? 'Finished. Check the pixel again with the dead pixel test.' : 'Stopped. Check the pixel with the dead pixel test, or run the fixer again.', done ? 'ok' : '');
	}

	agree.addEventListener('change', function () {
		startBtn.disabled = fullBtn.disabled = !agree.checked;
		if (!agree.checked) { stop(); }
		U.status(statusEl, agree.checked ? 'Ready. Start the fixer box, then drag it over the stuck pixel.' : 'Tick the box above to unlock the fixer.', '');
	});

	startBtn.addEventListener('click', function () {
		var s = Number(size.value);
		if (!pos) { place((window.innerWidth - s) / 2, (window.innerHeight - s) / 2); }
		run(box);
	});
	fullBtn.addEventListener('click', function () {
		run(screen);
		U.enterFullscreen(screen);
	});
	stopBtn.addEventListener('click', function () { stop(); });
	$('#spf-close').addEventListener('click', function (e) { e.stopPropagation(); stop(); });
	screen.addEventListener('click', function () { stop(); });
	document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && target) { stop(); } });
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		document.addEventListener(ev, function () {
			if (target === screen && !(document.fullscreenElement || document.webkitFullscreenElement) && !screen.classList.contains('is-pseudo-fs')) { stop(); }
		});
	});
	screen.addEventListener('tn:fullscreen', function (e) { if (!e.detail.on && target === screen) { stop(); } });

	// Drag the box with mouse, pen or finger.
	var drag = null;
	box.addEventListener('pointerdown', function (e) {
		if (e.target !== box) { return; }
		drag = { dx: e.clientX - pos.x, dy: e.clientY - pos.y };
		box.setPointerCapture(e.pointerId);
		e.preventDefault();
	});
	box.addEventListener('pointermove', function (e) { if (drag) { place(e.clientX - drag.dx, e.clientY - drag.dy); } });
	box.addEventListener('pointerup', function () { drag = null; });
	box.addEventListener('pointercancel', function () { drag = null; });

	speedBtns.forEach(function (btn) {
		btn.addEventListener('click', function () {
			speed = btn.getAttribute('data-spf-speed');
			speedBtns.forEach(function (b) { b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
		});
	});
	size.addEventListener('input', sizeBox);
	window.addEventListener('resize', function () { if (pos) { place(pos.x, pos.y); } });
	sizeBox();
}());
