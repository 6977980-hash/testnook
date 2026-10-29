/* Keyboard tester: full-size / TKL / 75% / 60% layouts, ANSI or ISO (UK/EU) shape, Windows or Mac labels, keys light up on keydown and stay green once tested, held-key count (rollover), last key details, a key log and a typing area. The board scales to fit its box. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="keyboard-tester"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var board = $('#kb-board'), stage = $('#kb-stage'), hint = $('#kb-hint'), statusEl = $('#kb-status'), typing = $('#kb-typing');
	var logBody = $('#kb-log-body'), logCopy = $('#kb-log-copy');
	var out = { key: $('#kb-key'), code: $('#kb-code'), which: $('#kb-which'), held: $('#kb-held'), max: $('#kb-max'), tested: $('#kb-tested'), total: $('#kb-total') };
	var opt = { size: 'full', shape: 'ansi', os: /Mac|iPhone|iPad/.test(navigator.platform || '') ? 'mac' : 'win' };
	var tested = {}, down = {}, maxHeld = 0, keyCount = 0, log = [];
	var LOG_MAX = 10, U_MIN = 22, U_MAX = 46;

	// Keys are [code, label, width in units, height in units]; a row is an array of keys.
	// null = a 1u gap, a number = a gap of that many units.
	var FN = [['Escape', 'Esc'], null, ['F1', 'F1'], ['F2', 'F2'], ['F3', 'F3'], ['F4', 'F4'], 0.5, ['F5', 'F5'], ['F6', 'F6'], ['F7', 'F7'], ['F8', 'F8'], 0.5, ['F9', 'F9'], ['F10', 'F10'], ['F11', 'F11'], ['F12', 'F12']];
	var FN75 = [['Escape', 'Esc'], ['F1', 'F1'], ['F2', 'F2'], ['F3', 'F3'], ['F4', 'F4'], ['F5', 'F5'], ['F6', 'F6'], ['F7', 'F7'], ['F8', 'F8'], ['F9', 'F9'], ['F10', 'F10'], ['F11', 'F11'], ['F12', 'F12'], ['PrintScreen', 'PrtSc'], ['Insert', 'Ins'], ['Delete', 'Del']];
	var NUMROW = [['Backquote', '`'], ['Digit1', '1'], ['Digit2', '2'], ['Digit3', '3'], ['Digit4', '4'], ['Digit5', '5'], ['Digit6', '6'], ['Digit7', '7'], ['Digit8', '8'], ['Digit9', '9'], ['Digit0', '0'], ['Minus', '-'], ['Equal', '='], ['Backspace', 'Backspace', 2]];
	var QROW = [['KeyQ', 'Q'], ['KeyW', 'W'], ['KeyE', 'E'], ['KeyR', 'R'], ['KeyT', 'T'], ['KeyY', 'Y'], ['KeyU', 'U'], ['KeyI', 'I'], ['KeyO', 'O'], ['KeyP', 'P'], ['BracketLeft', '['], ['BracketRight', ']']];
	var AROW = [['KeyA', 'A'], ['KeyS', 'S'], ['KeyD', 'D'], ['KeyF', 'F'], ['KeyG', 'G'], ['KeyH', 'H'], ['KeyJ', 'J'], ['KeyK', 'K'], ['KeyL', 'L'], ['Semicolon', ';'], ['Quote', '\'']];
	var ZROW = [['KeyZ', 'Z'], ['KeyX', 'X'], ['KeyC', 'C'], ['KeyV', 'V'], ['KeyB', 'B'], ['KeyN', 'N'], ['KeyM', 'M'], ['Comma', ','], ['Period', '.'], ['Slash', '/']];
	var BOTTOM = {
		win: [['ControlLeft', 'Ctrl', 1.25], ['MetaLeft', 'Win', 1.25], ['AltLeft', 'Alt', 1.25], ['Space', '', 6.25], ['AltRight', 'Alt', 1.25], ['MetaRight', 'Win', 1.25], ['ContextMenu', 'Menu', 1.25], ['ControlRight', 'Ctrl', 1.25]],
		mac: [['ControlLeft', 'Control', 1.25], ['AltLeft', 'Option', 1.25], ['MetaLeft', 'Cmd', 1.5], ['Space', '', 7], ['MetaRight', 'Cmd', 1.5], ['AltRight', 'Option', 1.25], ['ControlRight', 'Control', 1.25]],
		win75: [['ControlLeft', 'Ctrl', 1.25], ['MetaLeft', 'Win', 1.25], ['AltLeft', 'Alt', 1.25], ['Space', '', 6.25], ['AltRight', 'Alt'], ['ContextMenu', 'Menu'], ['ControlRight', 'Ctrl']],
		mac75: [['ControlLeft', 'Control', 1.25], ['AltLeft', 'Option', 1.25], ['MetaLeft', 'Cmd', 1.25], ['Space', '', 6.25], ['MetaRight', 'Cmd'], ['AltRight', 'Option'], ['ControlRight', 'Control']]
	};
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
	// Mac keyboards print other names on the same physical keys.
	var MAC_LABELS = { Backspace: 'Delete', Enter: 'Return', NumLock: 'Clear', PrintScreen: 'F13', ScrollLock: 'F14', Pause: 'F15', Insert: 'Help', Delete: 'Del' };
	// Shorter names when the keys get small.
	var SHORT = { Control: 'Ctrl', Option: 'Opt', Backspace: 'Bksp', Delete: 'Del', Return: 'Ret', Clear: 'Clr', Pause: 'Pse', PrtSc: 'Prt', ScrLk: 'Scr' };

	/* The three alpha rows (Tab, Caps, Shift) for ANSI or ISO. ISO: tall Enter, '#' key beside it, an extra key beside left Shift. */
	function alphaRows(shiftRight) {
		var right = shiftRight || 2.75;
		if (opt.shape === 'iso') {
			return [
				[['Tab', 'Tab', 1.5]].concat(QROW, [['Enter', 'Enter', 1.5, 2]]),
				[['CapsLock', 'Caps', 1.5]].concat(AROW, [['Backslash', '#'], 1.5]),
				[['ShiftLeft', 'Shift', 1.25], ['IntlBackslash', '\\']].concat(ZROW, [['ShiftRight', 'Shift', right]])
			];
		}
		return [
			[['Tab', 'Tab', 1.5]].concat(QROW, [['Backslash', '\\', 1.5]]),
			[['CapsLock', 'Caps', 1.75]].concat(AROW, [['Enter', 'Enter', 2.25]]),
			[['ShiftLeft', 'Shift', 2.25]].concat(ZROW, [['ShiftRight', 'Shift', right]])
		];
	}

	function blocks() {
		var a;
		if (opt.size === 'seventyfive') {
			a = alphaRows(1.75);
			return [[
				FN75,
				NUMROW.concat([['Home', 'Home']]),
				a[0].concat([['PageUp', 'PgUp']]),
				a[1].concat([['PageDown', 'PgDn']]),
				a[2].concat([['ArrowUp', '↑'], ['End', 'End']]),
				BOTTOM[opt.os + '75'].concat([['ArrowLeft', '←'], ['ArrowDown', '↓'], ['ArrowRight', '→']])
			]];
		}
		a = alphaRows();
		var main = [NUMROW].concat(a, [BOTTOM[opt.os]]);
		if (opt.size === 'sixty') { return [main]; }
		var out = [[FN].concat(main), NAV];
		if (opt.size === 'full') { out.push(NUM); }
		return out;
	}

	function label(k) {
		return opt.os === 'mac' && MAC_LABELS[k[0]] ? MAC_LABELS[k[0]] : k[1];
	}

	function build() {
		board.innerHTML = '';
		board.className = 'kb-board kb-' + opt.size;
		keyCount = 0;
		blocks().forEach(function (block, bi) {
			var sec = document.createElement('div');
			sec.className = 'kb-block kb-block-' + bi;
			block.forEach(function (row) {
				var r = document.createElement('div');
				r.className = 'kb-row';
				row.forEach(function (k) {
					if (!k || typeof k === 'number') {
						var gap = document.createElement('span');
						gap.className = 'kb-gap';
						if (k) { gap.style.setProperty('--w', k); }
						r.appendChild(gap);
						return;
					}
					var el = document.createElement('span');
					el.className = 'kb-key' + (tested[k[0]] ? ' is-done' : '');
					el.setAttribute('data-code', k[0]);
					el.setAttribute('data-label', label(k));
					el.textContent = label(k);
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
		out.tested.textContent = board.querySelectorAll('.is-done').length;
		fit();
	}

	/* Scale the key unit so the board fits the stage; below U_MIN the stage scrolls sideways and shows a hint. */
	function fit() {
		var avail = stage.clientWidth - parseFloat(getComputedStyle(stage).paddingLeft) * 2;
		board.style.setProperty('--u', '40px');
		var w40 = board.offsetWidth;
		board.style.setProperty('--u', '20px');
		var w20 = board.offsetWidth;
		var perU = (w40 - w20) / 20, fixed = w20 - perU * 20;
		var u = perU > 0 ? Math.floor((avail - fixed) / perU) : U_MAX;
		u = Math.max(U_MIN, Math.min(U_MAX, u));
		board.style.setProperty('--u', u + 'px');
		U.$$('.kb-key', board).forEach(function (el) {
			var l = el.getAttribute('data-label');
			el.textContent = u < 32 && SHORT[l] ? SHORT[l] : l;
		});
		var over = board.offsetWidth > avail + 1;
		stage.classList.toggle('is-scroll', over);
		hint.hidden = !over;
	}

	function keyEl(e) {
		var code = e.code;
		if (!code && e.keyCode) { code = 'keyCode-' + e.keyCode; }
		return board.querySelector('[data-code="' + code + '"]');
	}

	function keyName(e) { return e.key === ' ' ? 'Space' : (e.key || '-'); }

	function show(e) {
		out.key.textContent = keyName(e);
		out.code.textContent = e.code || '-';
		out.which.textContent = e.keyCode || e.which || '-';
	}

	function addLog(e) {
		log.unshift({ key: keyName(e), code: e.code || '-', keyCode: e.keyCode || e.which || 0, repeat: !!e.repeat });
		if (log.length > LOG_MAX) { log.length = LOG_MAX; }
		logBody.innerHTML = '';
		log.forEach(function (row) {
			var tr = document.createElement('tr');
			[row.key + (row.repeat ? ' (held)' : ''), row.code, String(row.keyCode)].forEach(function (v) {
				var td = document.createElement('td');
				td.textContent = v;
				tr.appendChild(td);
			});
			logBody.appendChild(tr);
		});
		logCopy.disabled = false;
	}

	function onDown(e) {
		if (e.target === typing && !e.ctrlKey && !e.metaKey && !e.altKey) {
			// Let the typing area take the character, but still light up the key.
		} else if (e.target.closest && e.target.closest('button, select')) {
			return; // leave the option buttons and the copy button their normal keys
		} else if (e.code !== 'F5' && e.code !== 'F11' && e.code !== 'F12' && !(e.ctrlKey && /Key[CVAXZ]/.test(e.code)) && !e.metaKey) {
			e.preventDefault(); // stops Tab focus moves, Space scroll, Backspace navigation, Alt menus
		}
		show(e);
		addLog(e);
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
				U.status(statusEl, keyName(e) + ' works. ' + n + ' of ' + keyCount + ' keys tested.' + (n === keyCount ? ' Every key on this layout works.' : ''), 'ok');
			}
		} else {
			if (e.code) { tested[e.code] = 1; }
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
		tested = {}; down = {}; maxHeld = 0; log = [];
		out.max.textContent = '0'; out.held.textContent = '0';
		out.key.textContent = out.code.textContent = out.which.textContent = '-';
		typing.value = '';
		logBody.innerHTML = '';
		logCopy.disabled = true;
		build();
		U.status(statusEl, 'Click here and press every key. Each one turns green when it works.', '');
	}

	function press(name, value) {
		U.$$('[data-kb-' + name + ']', root).forEach(function (o) { o.setAttribute('aria-pressed', o.getAttribute('data-kb-' + name) === value ? 'true' : 'false'); });
	}

	root.addEventListener('keydown', onDown);
	root.addEventListener('keyup', onUp);
	window.addEventListener('blur', function () { down = {}; out.held.textContent = '0'; U.$$('.is-down', board).forEach(function (k) { k.classList.remove('is-down'); }); });
	['size', 'shape', 'os'].forEach(function (name) {
		U.$$('[data-kb-' + name + ']', root).forEach(function (b) {
			b.addEventListener('click', function () {
				opt[name] = b.getAttribute('data-kb-' + name);
				press(name, opt[name]);
				build();
				board.focus();
			});
		});
	});
	$('#kb-reset').addEventListener('click', function () { reset(); board.focus(); });
	logCopy.addEventListener('click', function () {
		var text = 'key\tcode\tkeyCode\n' + log.slice().reverse().map(function (r) { return r.key + '\t' + r.code + '\t' + r.keyCode; }).join('\n');
		U.copyText(text, logCopy);
	});
	board.addEventListener('mousedown', function () { setTimeout(function () { board.focus(); }, 0); });
	var resizeTimer;
	window.addEventListener('resize', function () { clearTimeout(resizeTimer); resizeTimer = setTimeout(fit, 100); });
	if (U.isTouch() && !U.hasFinePointer()) { opt.size = 'sixty'; }
	press('size', opt.size);
	press('shape', opt.shape);
	press('os', opt.os);
	build();
}());
