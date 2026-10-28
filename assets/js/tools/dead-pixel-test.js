/* Dead pixel test: full-screen solid colours, advanced by click, tap or arrow keys. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="dead-pixel-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var COLORS = [
		['Black', '#000000'], ['White', '#ffffff'], ['Red', '#ff0000'], ['Green', '#00ff00'], ['Blue', '#0000ff'],
		['Cyan', '#00ffff'], ['Magenta', '#ff00ff'], ['Yellow', '#ffff00'], ['Grey', '#808080']
	];
	var screen = $('#dp-screen'), hint = $('#dp-hint'), statusEl = $('#dp-status'), auto = $('#dp-auto');
	var idx = 0, active = false, autoTimer = 0, hintTimer = 0, cursorTimer = 0;

	// Swatch buttons to start at any colour.
	var sw = $('#dp-swatches');
	COLORS.forEach(function (c, i) {
		var b = document.createElement('button');
		b.type = 'button';
		b.className = 'dp-swatch';
		b.style.background = c[1];
		b.title = c[0];
		b.setAttribute('aria-label', 'Start on ' + c[0]);
		b.addEventListener('click', function () { open(i); });
		sw.appendChild(b);
	});

	function paint() {
		var c = COLORS[idx];
		screen.style.background = c[1];
		hint.textContent = c[0] + ' (' + (idx + 1) + '/' + COLORS.length + ')  -  tap or → next, ← back, Esc exit';
		hint.style.color = idx === 1 || idx > 4 ? '#000' : '#fff';
		hint.classList.add('is-on');
		clearTimeout(hintTimer);
		hintTimer = setTimeout(function () { hint.classList.remove('is-on'); }, 1800);
	}

	function open(i) {
		idx = i || 0;
		active = true;
		screen.hidden = false;
		paint();
		U.enterFullscreen(screen);
		screen.focus();
		if (auto.checked) { autoTimer = setInterval(function () { step(1); }, 3000); }
	}

	function close() {
		if (!active) { return; }
		active = false;
		clearInterval(autoTimer);
		screen.hidden = true;
		screen.classList.remove('hide-cursor');
		U.exitFullscreen();
		U.status(statusEl, 'Test closed. Saw a coloured dot? Try the stuck pixel fixer. A black dot on every colour is a dead pixel.', 'ok');
	}

	function step(d) {
		var next = idx + d;
		if (next >= COLORS.length) { close(); return; }
		idx = Math.max(0, next);
		paint();
	}

	$('#dp-start').addEventListener('click', function () { open(0); });

	screen.addEventListener('click', function () { step(1); });
	screen.addEventListener('mousemove', function () {
		screen.classList.remove('hide-cursor');
		clearTimeout(cursorTimer);
		cursorTimer = setTimeout(function () { screen.classList.add('hide-cursor'); }, 1500);
	});
	document.addEventListener('keydown', function (e) {
		if (!active) { return; }
		if (e.key === 'ArrowRight' || e.key === ' ' || e.key === 'Enter' || e.key === 'ArrowDown') { e.preventDefault(); step(1); }
		else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') { e.preventDefault(); step(-1); }
		else if (e.key === 'Escape') { close(); }
	});
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		document.addEventListener(ev, function () {
			if (active && !(document.fullscreenElement || document.webkitFullscreenElement) && !screen.classList.contains('is-pseudo-fs')) { close(); }
		});
	});
	screen.addEventListener('tn:fullscreen', function (e) { if (!e.detail.on && active) { close(); } });
}());
