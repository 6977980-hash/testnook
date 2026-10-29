/* Keyboard ghosting test: shows every key held at once on a 60% layout, the most keys registered together (rollover), and a checklist of gaming combos that must all register at the same time. Uses keyboard-tester.css for the keys. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="keyboard-ghosting-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var board = $('#gh-board'), statusEl = $('#gh-status'), heldList = $('#gh-held'), comboList = $('#gh-combos');
	var out = { now: $('#gh-now'), max: $('#gh-max'), best: $('#gh-best'), kro: $('#gh-kro') };
	var down = {}, maxHeld = 0, done = {};

	var ROWS = [
		[['Backquote', '`'], ['Digit1', '1'], ['Digit2', '2'], ['Digit3', '3'], ['Digit4', '4'], ['Digit5', '5'], ['Digit6', '6'], ['Digit7', '7'], ['Digit8', '8'], ['Digit9', '9'], ['Digit0', '0'], ['Minus', '-'], ['Equal', '='], ['Backspace', 'Backspace', 2]],
		[['Tab', 'Tab', 1.5], ['KeyQ', 'Q'], ['KeyW', 'W'], ['KeyE', 'E'], ['KeyR', 'R'], ['KeyT', 'T'], ['KeyY', 'Y'], ['KeyU', 'U'], ['KeyI', 'I'], ['KeyO', 'O'], ['KeyP', 'P'], ['BracketLeft', '['], ['BracketRight', ']'], ['Backslash', '\\', 1.5]],
		[['CapsLock', 'Caps', 1.75], ['KeyA', 'A'], ['KeyS', 'S'], ['KeyD', 'D'], ['KeyF', 'F'], ['KeyG', 'G'], ['KeyH', 'H'], ['KeyJ', 'J'], ['KeyK', 'K'], ['KeyL', 'L'], ['Semicolon', ';'], ['Quote', '\''], ['Enter', 'Enter', 2.25]],
		[['ShiftLeft', 'Shift', 2.25], ['KeyZ', 'Z'], ['KeyX', 'X'], ['KeyC', 'C'], ['KeyV', 'V'], ['KeyB', 'B'], ['KeyN', 'N'], ['KeyM', 'M'], ['Comma', ','], ['Period', '.'], ['Slash', '/'], ['ShiftRight', 'Shift', 2.75]],
		[['ControlLeft', 'Ctrl', 1.25], ['MetaLeft', 'Win', 1.25], ['AltLeft', 'Alt', 1.25], ['Space', 'Space', 6.25], ['AltRight', 'Alt', 1.25], ['MetaRight', 'Win', 1.25], ['ContextMenu', 'Menu', 1.25], ['ControlRight', 'Ctrl', 1.25]]
	];
	var LABEL = {};
	ROWS.forEach(function (r) { r.forEach(function (k) { LABEL[k[0]] = k[1]; }); });

	var COMBOS = [
		['WASD', ['KeyW', 'KeyA', 'KeyS', 'KeyD']],
		['Sprint jump diagonal', ['KeyW', 'KeyA', 'ShiftLeft', 'Space']],
		['Crouch jump strafe', ['KeyW', 'KeyD', 'ControlLeft', 'Space']],
		['Abilities', ['KeyQ', 'KeyW', 'KeyE', 'KeyR']],
		['Move + reload + jump', ['KeyW', 'KeyA', 'KeyR', 'Space', 'ShiftLeft']],
		['Number row', ['Digit1', 'Digit2', 'Digit3', 'Digit4', 'Digit5', 'Digit6']],
		['Home row (8 keys)', ['KeyA', 'KeyS', 'KeyD', 'KeyF', 'KeyJ', 'KeyK', 'KeyL', 'Semicolon']],
		['Ten fingers', ['KeyQ', 'KeyW', 'KeyE', 'KeyR', 'KeyT', 'KeyY', 'KeyU', 'KeyI', 'KeyO', 'KeyP']]
	];

	function build() {
		board.innerHTML = '';
		var sec = document.createElement('div');
		sec.className = 'kb-block';
		ROWS.forEach(function (row) {
			var r = document.createElement('div');
			r.className = 'kb-row';
			row.forEach(function (k) {
				var el = document.createElement('span');
				el.className = 'kb-key';
				el.setAttribute('data-code', k[0]);
				el.textContent = k[1];
				if (k[2]) { el.style.setProperty('--w', k[2]); }
				r.appendChild(el);
			});
			sec.appendChild(r);
		});
		board.appendChild(sec);
		comboList.innerHTML = '';
		COMBOS.forEach(function (c, i) {
			var li = document.createElement('li');
			li.setAttribute('data-combo', i);
			li.innerHTML = '<b></b> <span></span>';
			li.querySelector('b').textContent = c[0];
			li.querySelector('span').textContent = c[1].map(function (k) { return LABEL[k]; }).join(' + ');
			comboList.appendChild(li);
		});
	}

	function name(code) { return LABEL[code] || code.replace(/^(Key|Digit|Numpad)/, ''); }

	function paint() {
		var keys = Object.keys(down), n = keys.length;
		out.now.textContent = n;
		heldList.textContent = n ? keys.map(name).join(' + ') : 'Nothing held';
		U.$$('.kb-key', board).forEach(function (el) { el.classList.toggle('is-down', !!down[el.getAttribute('data-code')]); });
		if (n > maxHeld) {
			maxHeld = n;
			out.max.textContent = n;
			out.best.textContent = keys.map(name).join(' + ');
			out.kro.textContent = n >= 10 ? 'NKRO or 10KRO+' : n >= 6 ? n + 'KRO' : n + '-key rollover';
		}
		COMBOS.forEach(function (c, i) {
			if (!done[i] && c[1].every(function (k) { return down[k]; })) {
				done[i] = 1;
				comboList.querySelector('[data-combo="' + i + '"]').classList.add('is-ok');
				U.status(statusEl, c[0] + ' works: all ' + c[1].length + ' keys registered together.', 'ok');
			}
		});
	}

	function onDown(e) {
		if (e.code !== 'F5' && e.code !== 'F11' && e.code !== 'F12' && !e.metaKey) { e.preventDefault(); }
		if (e.repeat || !e.code) { return; }
		down[e.code] = 1;
		paint();
	}
	function onUp(e) {
		e.preventDefault();
		delete down[e.code];
		paint();
	}
	function clear() { down = {}; paint(); }

	board.addEventListener('keydown', onDown);
	board.addEventListener('keyup', onUp);
	board.addEventListener('mousedown', function () { setTimeout(function () { board.focus(); }, 0); });
	board.addEventListener('focus', function () { root.classList.add('is-focused'); });
	board.addEventListener('blur', function () { root.classList.remove('is-focused'); clear(); });
	window.addEventListener('blur', clear);
	$('#gh-reset').addEventListener('click', function () {
		maxHeld = 0; done = {};
		out.max.textContent = '0'; out.best.textContent = '-'; out.kro.textContent = '-';
		U.$$('li', comboList).forEach(function (li) { li.classList.remove('is-ok'); });
		clear();
		board.focus();
		U.status(statusEl, 'Reset. Click the keyboard and hold keys down together.', '');
	});
	build();
	paint();
	out.max.textContent = '0';
}());
