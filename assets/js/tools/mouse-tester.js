/* Mouse tester: buttons 0-4 and wheel up/down light up and count; context menu, autoscroll and back/forward are blocked in the stage. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="mouse-tester"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var stage = root.querySelector('#mt-stage');
	var statusEl = root.querySelector('#mt-status');
	var NAMES = { 0: 'Left click', 1: 'Middle click', 2: 'Right click', 3: 'Back button (4)', 4: 'Forward button (5)', up: 'Scroll up', down: 'Scroll down' };
	var counts = {};

	function part(key) { return root.querySelector('[data-mt="' + key + '"]'); }

	function bump(key) {
		counts[key] = (counts[key] || 0) + 1;
		var el = root.querySelector('[data-mt-count="' + key + '"]');
		if (el) { el.textContent = counts[key]; }
		var p = part(key);
		if (p) { p.classList.add('is-done'); }
		var done = Object.keys(NAMES).filter(function (k) { return counts[k]; }).length;
		U.status(statusEl, NAMES[key] + ' detected. ' + done + ' of 7 inputs tested.', 'ok');
	}

	function flash(key) {
		var p = part(key);
		if (!p) { return; }
		p.classList.add('is-down');
		clearTimeout(p._t);
		p._t = setTimeout(function () { p.classList.remove('is-down'); }, 140);
	}

	stage.addEventListener('mousedown', function (e) {
		if (e.button > 4) { return; }
		if (e.button !== 0) { e.preventDefault(); } // stops middle-click autoscroll
		var p = part(e.button);
		if (p) { p.classList.add('is-down'); }
		bump(e.button);
	});
	stage.addEventListener('mouseup', function (e) {
		if (e.button === 3 || e.button === 4) { e.preventDefault(); } // stops back/forward navigation
		var p = part(e.button);
		if (p) { p.classList.remove('is-down'); }
	});
	stage.addEventListener('mouseleave', function () {
		U.$$('.is-down', root).forEach(function (p) { p.classList.remove('is-down'); });
	});
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });
	stage.addEventListener('auxclick', function (e) { e.preventDefault(); });
	stage.addEventListener('wheel', function (e) {
		e.preventDefault();
		if (!e.deltaY) { return; }
		var key = e.deltaY < 0 ? 'up' : 'down';
		flash(key);
		bump(key);
	}, { passive: false });

	// Touch screens: count taps as left clicks so the page still does something.
	stage.addEventListener('touchstart', function (e) {
		e.preventDefault();
		flash(0);
		bump(0);
	}, { passive: false });

	root.querySelector('#mt-reset').addEventListener('click', function () {
		counts = {};
		U.$$('[data-mt-count]', root).forEach(function (el) { el.textContent = '0'; });
		U.$$('.mt-part', root).forEach(function (p) { p.classList.remove('is-done', 'is-down'); });
		U.status(statusEl, 'Reset. Waiting for your first click.', '');
	});
}());
