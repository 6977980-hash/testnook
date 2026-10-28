/* Keyboard tester: full-size / TKL / 60% layouts, keys light up on keydown and stay green once tested, held-key count (rollover), last key details and a typing area. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="keyboard-tester"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var board = $('#kb-board'), statusEl = $('#kb-status'), typing = $('#kb-typing');
	var out = { key: $('#kb-key'), code: $('#kb-code'), which: $('#kb-which'), held: $('#kb-held'), max: $('#kb-max'), tested: $('#kb-tested'), total: $('#kb-total') };
	var layout = 'full', tested = {}, down = {}, maxHeld = 0, keyCount = 0;

	// [code, label, width in units]; a row is an array of keys; null = gap of 0.5u.
	var MAIN = [
		[['Escape', 'Esc', 1], null, ['F1', 'F1'], ['F2', 'F2'], ['F3', 'F3'], ['F4', 'F4'], null, ['F5', 'F5'], ['F6', 'F6'], ['F7', 'F7'], ['F8', 'F8'], null, ['F9', 'F9'], ['F10', 'F10'], ['F11', 'F11'], ['F12', 'F12']],
		[['Backquote', '`'], ['Digit1', '1'], ['Digit2', '2'], ['Digit3', '3'], ['Digit4', '4'], ['Digit5', '5'], ['Digit6', '6'], ['Digit7', '7'], ['Digit8', '8'], ['Digit9', '9'], ['Digit0', '0'], ['Minus', '-'], ['Equal', '='], ['Backspace', 'Backspace', 2]],
		[['Tab', 'Tab', 1.5], ['KeyQ', 'Q'], ['KeyW', 'W'], ['KeyE', 'E'], ['KeyR', 'R'], ['KeyT', 'T'], ['KeyY', 'Y'], ['KeyU', 'U'], ['KeyI', 'I'], ['KeyO', 'O'], ['KeyP', 'P'], ['BracketLeft', '['], ['BracketRight', ']'], ['Backslash', '\\', 1.5]],
		[['CapsLock', 'Caps', 1.75], ['KeyA', 'A'], ['KeyS', 'S'], ['KeyD', 'D'], ['KeyF', 'F'], ['KeyG', 'G'], ['KeyH', 'H'], ['KeyJ', 'J'], ['KeyK', 'K'], ['KeyL', 'L'], ['Semicolon', ';'], ['Quote', '\''], ['Enter', 'Enter', 2.25]],
		[['ShiftLeft', 'Shift', 2.25], ['KeyZ', 'Z'], ['KeyX', 'X'], ['KeyC', 'C'], ['KeyV', 'V'], ['KeyB', 'B'], ['KeyN', 'N'], ['KeyM', 'M'], ['Comma', ','], ['Period', '.'], ['Slash', '/'], ['ShiftRight', 'Shift', 2.75]],
		[['ControlLeft', 'Ctrl', 1.25], ['MetaLeft', 'Win', 1.25], ['AltLeft', 'Alt', 1.25], ['Space', '', 6.25], ['AltRight', 'Alt', 1.25], ['MetaRight', 'Win', 1.25], ['ContextMenu', 'Menu', 1.25], ['ControlRight', 'Ctrl', 1.25]]
	];
	var NAV = [
		[['PrintScreen', 'PrtSc'], ['ScrollLock', 'ScrLk'], ['Pause', 'Pause']],
		[['Insert', 'Ins'], ['Home', 'Home'], ['PageUp', 'PgUp']],
		[['Delete', 'Del'], ['End', 'End'], ['PageDown', 'PgDn']],
		[],
		[null, ['ArrowUp', '↑'], null],
		[['ArrowLeft', '←'], ['ArrowDown', '↓'], ['ArrowRight', '→']]
	];
	var NUM = [
		[],
		[['NumLock', 'Num'], ['NumpadDivide', '/'], ['NumpadMultiply', '*'], ['NumpadSubtract', '-']],
		[['Numpad7', '7'], ['Numpad8', '8'], ['Numpad9', '9'], ['NumpadAdd', '+', 1, 2]],
		[['Numpad4', '4'], ['Numpad5', '5'], ['Numpad6', '6']],
		[['Numpad1', '1'], ['Numpad2', '2'], ['Numpad3', '3'], ['NumpadEnter', 'Enter', 1, 2]],
		[['Numpad0', '0', 2], ['NumpadDecimal', '.']]
	];

	function build() {
		board.innerHTML = '';
		board.className = 'kb-board kb-' + layout;
		var rows = MAIN;
		if (layout === 'sixty') { rows = MAIN.slice(1); }
		var blocks = [rows];
		if (layout !== 'sixty') { blocks.push(NAV); }
		if (layout === 'full') { blocks.push(NUM); }
		keyCount = 0;
		blocks.forEach(function (block, bi) {
			var sec = document.createElement('div');
			sec.className = 'kb-block kb-block-' + bi;
			block.forEach(function (row) {
				var r = document.createElement('div');
				r.className = 'kb-row';
				row.forEach(function (k) {
					if (!k) { var gap = document.createElement('span'); gap.className = 'kb-gap'; r.appendChild(gap); return; }
					var el = document.createElement('span');
					el.className = 'kb-key' + (tested[k[0]] ? ' is-done' : '');
					el.setAttribute('data-code', k[0]);
					el.textContent = k[1];
					if (k[2] && k[2] !== 1) { el.style.setProperty('--w', k[2]); }
					if (k[3]) { el.style.setProperty('--h', k[3]); }
					r.appendChild(el);
					keyCount++;
				});
				sec.appendChild(r);
			});
			board.appendChild(sec);
		});
		out.total.textContent = keyCount;
		out.tested.textContent = Object.keys(tested).filter(function (c) { return board.querySelector('[data-code="' + c + '"]'); }).length;
	}

	function keyEl(e) {
		var code = e.code;
		if (!code && e.keyCode) { code = 'keyCode-' + e.keyCode; }
		return board.querySelector('[data-code="' + code + '"]');
	}

	function show(e) {
		out.key.textContent = e.key === ' ' ? 'Space' : (e.key || '-');
		out.code.textContent = e.code || '-';
		out.which.textContent = e.keyCode || e.which || '-';
	}

	function onDown(e) {
		if (e.target === typing && !e.ctrlKey && !e.metaKey && !e.altKey) {
			// Let the typing area take the character, but still light up the key.
		} else if (e.code !== 'F5' && e.code !== 'F11' && e.code !== 'F12' && !(e.ctrlKey && /Key[CVAXZ]/.test(e.code)) && !e.metaKey) {
			e.preventDefault(); // stops Tab focus moves, Space scroll, Backspace navigation, Alt menus
		}
		show(e);
		down[e.code || e.keyCode] = 1;
		var held = Object.keys(down).length;
		out.held.textContent = held;
		if (held > maxHeld) { maxHeld = held; out.max.textContent = held; }
		var el = keyEl(e);
		if (el) {
			el.classList.add('is-down');
			if (!tested[e.code]) {
				tested[e.code] = 1;
				el.classList.add('is-done');
				var n = board.querySelectorAll('.is-done').length;
				out.tested.textContent = n;
				U.status(statusEl, (e.key === ' ' ? 'Space' : e.key) + ' works. ' + n + ' of ' + keyCount + ' keys tested.' + (n === keyCount ? ' Every key on this layout works.' : ''), 'ok');
			}
		} else {
			U.status(statusEl, 'Key "' + (e.key || e.code) + '" (' + (e.code || 'no code') + ') pressed. It is not on this layout, but it works.', 'ok');
		}
	}

	function onUp(e) {
		delete down[e.code || e.keyCode];
		out.held.textContent = Object.keys(down).length;
		var el = keyEl(e);
		if (el) { el.classList.remove('is-down'); }
	}

	function reset() {
		tested = {}; down = {}; maxHeld = 0;
		out.max.textContent = '0'; out.held.textContent = '0';
		out.key.textContent = out.code.textContent = out.which.textContent = '-';
		typing.value = '';
		build();
		U.status(statusEl, 'Click here and press every key. Each one turns green when it works.', '');
	}

	root.addEventListener('keydown', onDown);
	root.addEventListener('keyup', onUp);
	window.addEventListener('blur', function () { down = {}; out.held.textContent = '0'; U.$$('.is-down', board).forEach(function (k) { k.classList.remove('is-down'); }); });
	U.$$('[data-kb-layout]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			layout = b.getAttribute('data-kb-layout');
			U.$$('[data-kb-layout]', root).forEach(function (o) { o.setAttribute('aria-pressed', o === b ? 'true' : 'false'); });
			build();
			board.focus();
		});
	});
	$('#kb-reset').addEventListener('click', function () { reset(); board.focus(); });
	board.addEventListener('mousedown', function () { setTimeout(function () { board.focus(); }, 0); });
	if (U.isTouch() && !U.hasFinePointer()) { layout = 'sixty'; U.$$('[data-kb-layout]', root).forEach(function (o) { o.setAttribute('aria-pressed', o.getAttribute('data-kb-layout') === 'sixty' ? 'true' : 'false'); }); }
	build();
}());
