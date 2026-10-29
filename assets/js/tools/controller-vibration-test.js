/* Controller vibration test: dual-rumble with separate strong (left, low frequency) and weak (right, high frequency) motor levels, duration, patterns, Xbox trigger rumble where supported, and a Firefox hapticActuators fallback. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="controller-vibration-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#cv-status'), padSel = $('#cv-pad'), nameEl = $('#cv-name'), supEl = $('#cv-support'), trigEl = $('#cv-trig');
	var strong = $('#cv-strong'), weak = $('#cv-weak'), dur = $('#cv-dur'), playBtn = $('#cv-play'), stopBtn = $('#cv-stop');
	var outs = { strong: $('#cv-strongout'), weak: $('#cv-weakout'), dur: $('#cv-durout') };
	var motorL = $('#cv-motor-l'), motorR = $('#cv-motor-r'), feel = $('#cv-feel');
	var padIndex = -1, timers = [], lastShape = '';

	function pads() {
		var list = navigator.getGamepads ? navigator.getGamepads() : [];
		return Array.prototype.filter.call(list || [], function (p) { return p && p.connected !== false; });
	}
	function pad() { return padIndex >= 0 ? (navigator.getGamepads() || [])[padIndex] : null; }
	function shortName(id) { return String(id || 'Controller').replace(/\s*\((STANDARD GAMEPAD\s*)?Vendor:.*$/i, '').slice(0, 60); }
	function hasDual(p) { return !!(p && p.vibrationActuator && p.vibrationActuator.playEffect); }
	function hasTrigger(p) {
		var a = p && p.vibrationActuator;
		return !!(a && a.effects && Array.prototype.indexOf.call(a.effects, 'trigger-rumble') !== -1);
	}
	function hasHaptic(p) { return !!(p && p.hapticActuators && p.hapticActuators.length && p.hapticActuators[0].pulse); }

	function refresh() {
		var list = pads();
		padSel.innerHTML = '';
		list.forEach(function (p) {
			var o = document.createElement('option');
			o.value = p.index;
			o.textContent = shortName(p.id);
			padSel.appendChild(o);
		});
		padSel.hidden = list.length < 2;
		if (!list.some(function (p) { return p.index === padIndex; })) { padIndex = list.length ? list[0].index : -1; }
		padSel.value = String(padIndex);
		var p = pad(), can = hasDual(p) || hasHaptic(p);
		nameEl.textContent = p ? shortName(p.id) : 'None';
		supEl.textContent = !p ? '-' : hasDual(p) ? 'Yes (dual rumble)' : hasHaptic(p) ? 'Yes (basic)' : 'Not available';
		trigEl.textContent = !p ? '-' : hasTrigger(p) ? 'Yes' : 'No';
		root.classList.toggle('has-trigger', hasTrigger(p));
		U.$$('.cv-actions button', root).forEach(function (b) { b.disabled = !can; });
		U.$$('[data-cv-trigger]', root).forEach(function (b) { b.disabled = !hasTrigger(p); });
		if (!p) {
			U.status(statusEl, 'No controller found yet. Connect it by USB or Bluetooth, then press any button on it.', '');
		} else if (!can) {
			U.status(statusEl, 'This browser cannot make ' + shortName(p.id) + ' vibrate. Try Chrome or Edge with the controller connected by USB.', 'bad');
		} else {
			U.status(statusEl, 'Connected: ' + shortName(p.id) + '. Choose a pattern or set the motors and press Vibrate.', 'ok');
		}
	}

	function show(s, w, ms) {
		motorL.style.setProperty('--cv-amp', s);
		motorR.style.setProperty('--cv-amp', w);
		root.classList.add('is-buzzing');
		timers.push(setTimeout(function () { motorL.style.setProperty('--cv-amp', 0); motorR.style.setProperty('--cv-amp', 0); root.classList.remove('is-buzzing'); }, ms));
	}

	function rumble(s, w, ms, at) {
		timers.push(setTimeout(function () {
			var p = pad();
			if (!p) { return; }
			show(s, w, ms);
			if (hasDual(p)) {
				p.vibrationActuator.playEffect('dual-rumble', { startDelay: 0, duration: ms, strongMagnitude: s, weakMagnitude: w }).catch(function () {});
			} else if (hasHaptic(p)) {
				p.hapticActuators[0].pulse(Math.max(s, w), ms);
			}
		}, at || 0));
	}

	function stop() {
		timers.forEach(clearTimeout);
		timers = [];
		var p = pad();
		if (p && p.vibrationActuator && p.vibrationActuator.reset) { p.vibrationActuator.reset().catch(function () {}); }
		motorL.style.setProperty('--cv-amp', 0);
		motorR.style.setProperty('--cv-amp', 0);
		root.classList.remove('is-buzzing');
	}

	var SHAPES = {
		left: function () { rumble(1, 0, 1000); return 'left (strong) motor only'; },
		right: function () { rumble(0, 1, 1000); return 'right (weak) motor only'; },
		both: function () { rumble(1, 1, 1000); return 'both motors at full power'; },
		gentle: function () { rumble(0.25, 0.25, 1500); return 'both motors at 25%'; },
		pulse: function () { for (var i = 0; i < 5; i++) { rumble(0.8, 0.8, 150, i * 300); } return '5 short pulses'; },
		heartbeat: function () { for (var i = 0; i < 3; i++) { rumble(0.9, 0.2, 120, i * 900); rumble(0.6, 0.1, 160, i * 900 + 220); } return 'a heartbeat'; },
		ramp: function () { for (var i = 1; i <= 10; i++) { rumble(i / 10, i / 10, 200, (i - 1) * 200); } return 'a ramp from 10% to 100%'; }
	};

	function trigger(side) {
		var p = pad();
		if (!hasTrigger(p)) { return; }
		var l = side === 'left' ? 1 : 0, r = side === 'right' ? 1 : 0;
		show(0, 0, 0);
		p.vibrationActuator.playEffect('trigger-rumble', { startDelay: 0, duration: 800, strongMagnitude: 0, weakMagnitude: 0, leftTrigger: l, rightTrigger: r }).catch(function () {});
		ask(side + ' trigger motor');
	}

	function ask(what) {
		lastShape = what;
		feel.hidden = false;
		$('#cv-feel-q').textContent = 'Did you feel the ' + what + '?';
		U.status(statusEl, 'Playing ' + what + '.', 'ok');
	}

	U.$$('[data-cv-shape]', root).forEach(function (b) {
		b.addEventListener('click', function () { stop(); ask(SHAPES[b.getAttribute('data-cv-shape')]()); });
	});
	U.$$('[data-cv-trigger]', root).forEach(function (b) {
		b.addEventListener('click', function () { stop(); trigger(b.getAttribute('data-cv-trigger')); });
	});
	playBtn.addEventListener('click', function () {
		stop();
		rumble(strong.value / 100, weak.value / 100, Number(dur.value));
		ask('vibration (strong ' + strong.value + '%, weak ' + weak.value + '%)');
	});
	stopBtn.addEventListener('click', function () { stop(); U.status(statusEl, 'Stopped.', ''); });
	[[strong, outs.strong, '%'], [weak, outs.weak, '%'], [dur, outs.dur, ' ms']].forEach(function (x) {
		x[0].addEventListener('input', function () { x[1].textContent = x[0].value + x[2]; });
	});
	U.$$('[data-cv-felt]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			var v = b.getAttribute('data-cv-felt');
			feel.hidden = true;
			if (v === 'yes') { U.status(statusEl, 'Good: the ' + lastShape + ' works.', 'ok'); }
			else if (v === 'weak') { U.status(statusEl, 'Weak or uneven rumble can mean a worn motor or loose weight. Compare the left and right motor buttons; if one side is clearly weaker, that motor needs repair. Also check that vibration is turned up in the controller or console settings.', 'bad'); }
			else { U.status(statusEl, 'No vibration: check the troubleshooting tips below. Try a USB cable, Chrome or Edge, and make sure vibration is not turned off in Steam, Windows or the controller app.', 'bad'); }
		});
	});
	padSel.addEventListener('change', function () { stop(); padIndex = Number(padSel.value); refresh(); });

	if (!('getGamepads' in navigator)) {
		U.status(statusEl, 'This browser does not support controllers. Use an up-to-date Chrome, Edge, Firefox or Safari.', 'bad');
		return;
	}
	window.addEventListener('gamepadconnected', refresh);
	window.addEventListener('gamepaddisconnected', refresh);
	document.addEventListener('visibilitychange', function () { if (document.hidden) { stop(); } });
	refresh();
}());
