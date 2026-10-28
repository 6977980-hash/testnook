/* Burn-in test: full-screen check patterns (solid colours, grey gradient, checkerboard) stepped by hand, and a consent-gated auto cycle that runs the patterns for a set time to relieve image retention. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="burn-in-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var PATTERNS = [
		{ id: 'grey', name: '50% grey', css: '#808080' },
		{ id: 'white', name: 'White', css: '#ffffff' },
		{ id: 'red', name: 'Red', css: '#ff0000' },
		{ id: 'green', name: 'Green', css: '#00ff00' },
		{ id: 'blue', name: 'Blue', css: '#0000ff' },
		{ id: 'black', name: 'Black', css: '#000000' },
		{ id: 'gradient', name: 'Grey gradient', css: 'linear-gradient(to right, #000 0%, #fff 100%)' },
		{ id: 'checker', name: 'Checkerboard', css: 'repeating-conic-gradient(#000 0% 25%, #fff 0% 50%) 0 0 / 80px 80px' },
		{ id: 'bars', name: 'Colour bars', css: 'linear-gradient(to right, #fff 0 12.5%, #ff0 0 25%, #0ff 0 37.5%, #0f0 0 50%, #f0f 0 62.5%, #f00 0 75%, #00f 0 87.5%, #000 0)' }
	];
	var screen = $('#bi-screen'), hint = $('#bi-hint'), statusEl = $('#bi-status'), preview = $('#bi-preview');
	var startBtn = $('#bi-start'), cycleBtn = $('#bi-cycle'), agree = $('#bi-agree'), mins = $('#bi-mins'), speed = $('#bi-speed');
	var swatches = U.$$('[data-bi-pattern]', root);
	var index = 0, active = false, cycling = false, cycleTimer = 0, endTimer = 0, hintTimer = 0, cursorTimer = 0, startedAt = 0, tickTimer = 0;

	function pattern() { return PATTERNS[index]; }

	function paint(i) {
		index = (i + PATTERNS.length) % PATTERNS.length;
		var p = pattern();
		screen.style.background = p.css;
		preview.style.background = p.css;
		hint.textContent = p.name + (cycling ? '  -  auto cycle, Esc to stop' : '  -  click or arrow keys for the next pattern, Esc to exit');
		hint.classList.add('is-on');
		clearTimeout(hintTimer);
		hintTimer = setTimeout(function () { hint.classList.remove('is-on'); }, 2000);
		swatches.forEach(function (b) { b.setAttribute('aria-pressed', b.getAttribute('data-bi-pattern') === p.id ? 'true' : 'false'); });
	}

	function open(i) {
		active = true;
		screen.hidden = false;
		paint(typeof i === 'number' ? i : index);
		U.enterFullscreen(screen);
		screen.focus();
		U.status(statusEl, cycling ? 'Auto cycle running. Press Esc to stop.' : 'Full screen on. Click or use the arrow keys to step through the patterns; Esc exits.', '');
	}

	function close() {
		if (!active) { return; }
		active = false;
		stopCycle(true);
		screen.hidden = true;
		screen.classList.remove('hide-cursor');
		U.exitFullscreen();
		U.status(statusEl, 'Back to the page. Look at the next pattern or run the auto cycle.', '');
	}

	function fmt(sec) { sec = Math.max(0, Math.floor(sec)); return Math.floor(sec / 60) + ':' + ('0' + (sec % 60)).slice(-2); }

	function startCycle() {
		if (!agree.checked) { return; }
		cycling = true;
		cycleBtn.textContent = 'Stop cycle';
		var every = Number(speed.value) * 1000, limit = Number(mins.value) * 60;
		startedAt = performance.now();
		open(0);
		clearInterval(cycleTimer);
		cycleTimer = setInterval(function () { paint(index + 1); }, every);
		clearInterval(tickTimer);
		tickTimer = setInterval(function () {
			var elapsed = (performance.now() - startedAt) / 1000;
			U.status(statusEl, 'Auto cycle running: ' + fmt(elapsed) + ' of ' + fmt(limit) + '. Press Esc to stop.', '');
			if (elapsed >= limit) { close(); U.status(statusEl, 'Cycle finished after ' + mins.value + ' minutes. Open the 50% grey pattern to see if the ghost image has faded.', 'ok'); }
		}, 1000);
	}

	function stopCycle(quiet) {
		if (!cycling) { return; }
		cycling = false;
		clearInterval(cycleTimer);
		clearInterval(tickTimer);
		cycleBtn.textContent = 'Run auto cycle';
		if (!quiet) { U.status(statusEl, 'Cycle stopped.', ''); }
	}

	startBtn.addEventListener('click', function () { open(); });
	cycleBtn.addEventListener('click', function () { if (cycling) { close(); } else { startCycle(); } });
	agree.addEventListener('change', function () {
		cycleBtn.disabled = !agree.checked;
		U.status(statusEl, agree.checked ? 'Auto cycle unlocked. Choose a length and press Run auto cycle.' : 'Tick the box to unlock the auto cycle.', '');
	});
	swatches.forEach(function (b, i) {
		b.addEventListener('click', function () {
			var id = b.getAttribute('data-bi-pattern'), k = 0;
			PATTERNS.forEach(function (p, j) { if (p.id === id) { k = j; } });
			if (active) { paint(k); } else { open(k); }
		});
	});
	preview.addEventListener('click', function () { open(); });
	screen.addEventListener('click', function () { if (cycling) { close(); } else { paint(index + 1); } });
	screen.addEventListener('mousemove', function () {
		screen.classList.remove('hide-cursor');
		clearTimeout(cursorTimer);
		cursorTimer = setTimeout(function () { screen.classList.add('hide-cursor'); }, 1500);
	});
	document.addEventListener('keydown', function (e) {
		if (!active) { return; }
		if (e.key === 'Escape') { close(); return; }
		if (cycling) { return; }
		if (e.key === 'ArrowRight' || e.key === 'ArrowDown' || e.key === ' ') { e.preventDefault(); paint(index + 1); }
		if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') { e.preventDefault(); paint(index - 1); }
	});
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		document.addEventListener(ev, function () {
			if (active && !(document.fullscreenElement || document.webkitFullscreenElement) && !screen.classList.contains('is-pseudo-fs')) { close(); }
		});
	});
	screen.addEventListener('tn:fullscreen', function (e) { if (!e.detail.on && active) { close(); } });
	document.addEventListener('visibilitychange', function () { if (document.hidden && cycling) { close(); } });
	cycleBtn.disabled = !agree.checked;
	paint(0);
}());
