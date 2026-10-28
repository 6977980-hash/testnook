/* Shared by the white screen and black screen pages: full-screen solid colour with brightness steps, extra colours, a timer and cursor hiding. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="white-screen"], [data-tool="black-screen"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var screen = $('#cs-screen'), hint = $('#cs-hint'), statusEl = $('#cs-status'), timerSel = $('#cs-timer');
	var swatches = U.$$('[data-cs-color]', root);
	var current = root.getAttribute('data-tool') === 'black-screen' ? '#000000' : '#ffffff';
	var active = false, hintTimer = 0, cursorTimer = 0, endTimer = 0;

	function dark(hex) {
		var n = parseInt(hex.slice(1), 16);
		var r = n >> 16, g = (n >> 8) & 255, b = n & 255;
		return (r * 299 + g * 587 + b * 114) / 1000 < 128;
	}

	function paint(hex) {
		current = hex;
		screen.style.background = hex;
		hint.style.color = dark(hex) ? '#fff' : '#000';
		hint.textContent = hex.toUpperCase() + '  -  Esc or tap to exit';
		hint.classList.add('is-on');
		clearTimeout(hintTimer);
		hintTimer = setTimeout(function () { hint.classList.remove('is-on'); }, 2000);
		swatches.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-cs-color') === hex ? 'true' : 'false'); });
	}

	function open(hex) {
		if (hex) { current = hex; }
		active = true;
		screen.hidden = false;
		paint(current);
		U.enterFullscreen(screen);
		screen.focus();
		clearTimeout(endTimer);
		var mins = timerSel ? Number(timerSel.value) : 0;
		if (mins) { endTimer = setTimeout(close, mins * 60000); }
		U.status(statusEl, 'Full screen on. Press Esc, or tap the screen, to come back.', '');
	}

	function close() {
		if (!active) { return; }
		active = false;
		clearTimeout(endTimer);
		screen.hidden = true;
		screen.classList.remove('hide-cursor');
		U.exitFullscreen();
		U.status(statusEl, 'Back to the page. Choose a colour or press the button to go full screen again.', '');
	}

	$('#cs-start').addEventListener('click', function () { open(); });
	swatches.forEach(function (b) {
		b.addEventListener('click', function () {
			var hex = b.getAttribute('data-cs-color');
			if (active) { paint(hex); } else { open(hex); }
		});
	});
	// Preview the chosen colour in the stage before going full screen.
	var preview = $('#cs-preview');
	if (preview) {
		swatches.forEach(function (b) {
			b.addEventListener('mouseenter', function () { preview.style.background = b.getAttribute('data-cs-color'); });
			b.addEventListener('mouseleave', function () { preview.style.background = current; });
		});
		preview.style.background = current;
		preview.addEventListener('click', function () { open(); });
	}

	screen.addEventListener('click', function () { close(); });
	screen.addEventListener('mousemove', function () {
		screen.classList.remove('hide-cursor');
		clearTimeout(cursorTimer);
		cursorTimer = setTimeout(function () { screen.classList.add('hide-cursor'); }, 1500);
	});
	document.addEventListener('keydown', function (e) {
		if (!active) { return; }
		if (e.key === 'Escape') { close(); }
	});
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		document.addEventListener(ev, function () {
			if (active && !(document.fullscreenElement || document.webkitFullscreenElement) && !screen.classList.contains('is-pseudo-fs')) { close(); }
		});
	});
	screen.addEventListener('tn:fullscreen', function (e) { if (!e.detail.on && active) { close(); } });
}());
