/* Gamepad tester: standard-mapping controller diagram (buttons, analog triggers, sticks), raw button/axis list, tested-count, vibration and multi-controller picker. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="gamepad-tester"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var statusEl = $('#gp-status'), padSel = $('#gp-pad'), rumbleBtn = $('#gp-rumble'), resetBtn = $('#gp-reset'), raw = $('#gp-raw');
	var info = { name: $('#gp-name'), map: $('#gp-map'), counts: $('#gp-counts'), tested: $('#gp-tested') };
	var LABELS = {
		xbox: ['A', 'B', 'X', 'Y', 'LB', 'RB', 'LT', 'RT', 'View', 'Menu', 'LS', 'RS', 'Up', 'Down', 'Left', 'Right', 'Xbox', 'Share'],
		ps: ['✕', '○', '□', '△', 'L1', 'R1', 'L2', 'R2', 'Create', 'Options', 'L3', 'R3', 'Up', 'Down', 'Left', 'Right', 'PS', 'Touchpad'],
		nintendo: ['B', 'A', 'Y', 'X', 'L', 'R', 'ZL', 'ZR', '−', '+', 'LS', 'RS', 'Up', 'Down', 'Left', 'Right', 'Home', 'Capture']
	};
	var padIndex = -1, tested = {}, rawBuilt = '', style = 'xbox';
	var btnEls = U.$$('[data-gp-btn]', root);
	var trig = { 6: $('#gp-lt'), 7: $('#gp-rt') };
	var sticks = [$('#gp-ls'), $('#gp-rs')];

	function pads() {
		return Array.prototype.filter.call(navigator.getGamepads() || [], function (p) { return p && p.connected !== false; });
	}

	function vendor(id) {
		id = String(id).toLowerCase();
		if (/054c|dualsense|dualshock|playstation|wireless controller/.test(id)) { return 'ps'; }
		if (/057e|nintendo|pro controller|joy-con/.test(id)) { return 'nintendo'; }
		return 'xbox';
	}

	function shortName(id) { return String(id || 'Controller').replace(/\s*\((STANDARD GAMEPAD\s*)?Vendor:.*$/i, '').slice(0, 70); }

	function labelButtons() {
		btnEls.forEach(function (el) {
			var i = Number(el.getAttribute('data-gp-btn')), t = el.querySelector('.gp-t');
			if (t && LABELS[style][i]) { t.textContent = LABELS[style][i]; }
		});
	}

	function refresh() {
		var list = pads();
		padSel.innerHTML = '';
		list.forEach(function (p) {
			var o = document.createElement('option');
			o.value = p.index;
			o.textContent = (p.index + 1) + ': ' + shortName(p.id);
			padSel.appendChild(o);
		});
		padSel.hidden = list.length < 2;
		if (!list.some(function (p) { return p.index === padIndex; })) { padIndex = list.length ? list[0].index : -1; reset(); }
		padSel.value = String(padIndex);
		var p = list.filter(function (q) { return q.index === padIndex; })[0];
		root.classList.toggle('gp-on', !!p);
		if (!p) {
			info.name.textContent = 'None';
			info.map.textContent = info.counts.textContent = '-';
			rumbleBtn.disabled = true;
			U.status(statusEl, 'No controller found yet. Connect it by USB or Bluetooth, then press any button on it.', '');
			return;
		}
		style = vendor(p.id);
		labelButtons();
		info.name.textContent = shortName(p.id);
		info.map.textContent = p.mapping === 'standard' ? 'Standard' : 'Non-standard';
		info.counts.textContent = p.buttons.length + ' / ' + p.axes.length;
		rumbleBtn.disabled = !(p.vibrationActuator || (p.hapticActuators && p.hapticActuators.length));
		U.status(statusEl, 'Connected: ' + shortName(p.id) + '. Press every button and move both sticks.', 'ok');
	}

	function buildRaw(p) {
		var key = p.index + ':' + p.buttons.length + ':' + p.axes.length;
		if (rawBuilt === key) { return; }
		rawBuilt = key;
		var html = '<div class="gp-raw-group"><h3>Buttons</h3><div class="gp-raw-list">';
		p.buttons.forEach(function (b, i) { html += '<div class="gp-raw-item" data-raw-b="' + i + '"><span>B' + i + '</span><b>0.00</b></div>'; });
		html += '</div></div><div class="gp-raw-group"><h3>Axes</h3><div class="gp-raw-list">';
		p.axes.forEach(function (a, i) { html += '<div class="gp-raw-item gp-raw-axis" data-raw-a="' + i + '"><span>Axis ' + i + '</span><b>0.00</b><i><em></em></i></div>'; });
		raw.innerHTML = html + '</div></div>';
	}

	function loop() {
		requestAnimationFrame(loop);
		if (padIndex < 0) { return; }
		var p = (navigator.getGamepads() || [])[padIndex];
		if (!p) { return; }
		buildRaw(p);
		p.buttons.forEach(function (b, i) {
			var v = typeof b === 'object' ? b.value : b, on = typeof b === 'object' ? b.pressed : b > 0.5;
			if (on && !tested[i]) { tested[i] = 1; info.tested.textContent = Object.keys(tested).length + ' / ' + p.buttons.length; }
			var el = root.querySelector('[data-gp-btn="' + i + '"]');
			if (el) { el.classList.toggle('is-down', on); el.classList.toggle('is-done', !!tested[i]); }
			if (trig[i]) { trig[i].style.width = Math.round(v * 100) + '%'; trig[i].parentNode.setAttribute('data-v', Math.round(v * 100) + '%'); }
			var r = raw.querySelector('[data-raw-b="' + i + '"]');
			if (r) { r.lastChild.textContent = v.toFixed(2); r.classList.toggle('is-down', on); r.classList.toggle('is-done', !!tested[i]); }
		});
		p.axes.forEach(function (a, i) {
			var r = raw.querySelector('[data-raw-a="' + i + '"]');
			if (r) {
				r.querySelector('b').textContent = (a >= 0 ? '+' : '') + a.toFixed(2);
				var bar = r.querySelector('em');
				bar.style.left = (a < 0 ? 50 + a * 50 : 50) + '%';
				bar.style.width = Math.abs(a) * 50 + '%';
			}
		});
		[[0, 1], [2, 3]].forEach(function (ax, k) {
			if (p.axes.length > ax[1]) {
				var x = p.axes[ax[0]] || 0, y = p.axes[ax[1]] || 0;
				sticks[k].querySelector('.gp-dot').style.transform = 'translate(calc(var(--r) * ' + x.toFixed(3) + '), calc(var(--r) * ' + y.toFixed(3) + '))';
				sticks[k].querySelector('.gp-xy').textContent = x.toFixed(2) + ', ' + y.toFixed(2);
			}
		});
	}

	function rumble() {
		var p = (navigator.getGamepads() || [])[padIndex];
		if (!p) { return; }
		if (p.vibrationActuator && p.vibrationActuator.playEffect) {
			p.vibrationActuator.playEffect('dual-rumble', { startDelay: 0, duration: 1000, weakMagnitude: 0.8, strongMagnitude: 1 })
				.then(function () { U.status(statusEl, 'Vibration sent. Did the controller rumble?', 'ok'); })
				.catch(function () { U.status(statusEl, 'This controller or browser does not allow vibration from a web page.', 'bad'); });
		} else if (p.hapticActuators && p.hapticActuators[0]) {
			p.hapticActuators[0].pulse(1, 1000);
		}
	}

	function reset() {
		tested = {};
		info.tested.textContent = '0';
		btnEls.forEach(function (el) { el.classList.remove('is-done', 'is-down'); });
		U.$$('.gp-raw-item', raw).forEach(function (el) { el.classList.remove('is-done'); });
	}

	if (!('getGamepads' in navigator)) {
		U.status(statusEl, 'This browser does not support controllers. Use an up-to-date Chrome, Edge, Firefox or Safari.', 'bad');
		return;
	}
	window.addEventListener('gamepadconnected', refresh);
	window.addEventListener('gamepaddisconnected', function () { rawBuilt = ''; raw.innerHTML = ''; refresh(); });
	padSel.addEventListener('change', function () { padIndex = Number(padSel.value); rawBuilt = ''; reset(); refresh(); });
	rumbleBtn.addEventListener('click', rumble);
	resetBtn.addEventListener('click', reset);
	refresh();
	requestAnimationFrame(loop);
}());
