/* eDPI calculator and sensitivity converter.
   eDPI = DPI x sensitivity. cm/360 = 360 / (yaw x sens x DPI) x 2.54.
   Converting keeps cm/360: newSens = sens x yawFrom / yawTo x dpi / newDpi.
   Yaw values come from the <option data-yaw> attributes (content/tools/edpi-calculator.php). Nothing is sent anywhere. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="edpi-calculator"]');
	if (!root) { return; }
	var $ = function (s) { return root.querySelector(s); };
	var DPI_MIN = 50, DPI_MAX = 50000, SENS_MAX = 10000, YAW_MAX = 10;

	var dpiEl = $('#ed-dpi'), sensEl = $('#ed-sens'), fromEl = $('#ed-from'), toEl = $('#ed-to'), dpi2El = $('#ed-dpi2');
	var yawFromEl = $('#ed-yaw-from'), yawToEl = $('#ed-yaw-to'), msg = $('#ed-msg');

	function num(el) { var v = String(el.value).trim(); return v === '' ? NaN : Number(v); }
	function fmt(n, d) { return Number(n.toFixed(d)).toLocaleString('en-US', { maximumFractionDigits: d }); }
	// Sensitivity: 3 decimals is what most games accept; show more only for tiny values.
	function sens(n) { return fmt(n, n < 0.1 ? 4 : 3); }
	function text(id, v) { $(id).textContent = v; }
	function label(sel) { return sel.options[sel.selectedIndex].text; }

	function yawOf(sel, customEl) {
		var opt = sel.options[sel.selectedIndex];
		var custom = sel.value === 'custom';
		customEl.closest('label').hidden = !custom;
		if (!custom) { return Number(opt.getAttribute('data-yaw')); }
		return num(customEl);
	}

	function clear(ids) { ids.forEach(function (id) { text(id, '-'); }); }

	function calc() {
		var dpi = num(dpiEl), s = num(sensEl), yawFrom = yawOf(fromEl, yawFromEl), yawTo = yawOf(toEl, yawToEl);
		var dpi2raw = num(dpi2El), dpi2 = isNaN(dpi2raw) ? dpi : dpi2raw;
		var errors = [];
		if (!(dpi >= DPI_MIN && dpi <= DPI_MAX)) { errors.push('Enter a DPI between 50 and 50,000.'); }
		if (!(s > 0 && s <= SENS_MAX)) { errors.push('Enter an in-game sensitivity above 0.'); }
		if (!(yawFrom > 0 && yawFrom <= YAW_MAX)) { errors.push('Enter the yaw of your game, for example 0.022.'); }
		var convOk = yawTo > 0 && yawTo <= YAW_MAX && dpi2 >= DPI_MIN && dpi2 <= DPI_MAX;
		if (!isNaN(dpi2raw) && !(dpi2raw >= DPI_MIN && dpi2raw <= DPI_MAX)) { errors.push('Enter a new DPI between 50 and 50,000, or leave it empty.'); }
		else if (!(yawTo > 0 && yawTo <= YAW_MAX)) { errors.push('Enter the yaw of the game you are converting to.'); }
		msg.textContent = errors.join(' ');

		var allBody = $('#ed-all');
		if (!(dpi >= DPI_MIN && dpi <= DPI_MAX && s > 0 && s <= SENS_MAX && yawFrom > 0 && yawFrom <= YAW_MAX)) {
			clear(['#ed-edpi', '#ed-cm360', '#ed-in360', '#ed-counts', '#ed-out-sens']);
			text('#ed-edpi-note', ''); text('#ed-out-note', '');
			allBody.textContent = '';
			return;
		}
		var edpi = dpi * s;
		var counts = 360 / (yawFrom * s);          // mouse counts for one full turn
		var inches = counts / dpi, cm = inches * 2.54;
		text('#ed-edpi', fmt(edpi, 2));
		text('#ed-edpi-note', fmt(dpi, 0) + ' DPI × ' + sens(s) + ' in ' + label(fromEl).replace(/ \(.*\)$/, ''));
		text('#ed-cm360', fmt(cm, 1) + ' cm');
		text('#ed-in360', fmt(inches, 2) + ' in');
		text('#ed-counts', fmt(counts, 0));

		text('#ed-to-name', 'Sensitivity in ' + (toEl.value === 'custom' ? 'the other game' : label(toEl)));
		if (convOk) {
			var out = s * (yawFrom / yawTo) * (dpi / dpi2);
			text('#ed-out-sens', sens(out));
			text('#ed-out-note', 'at ' + fmt(dpi2, 0) + ' DPI (eDPI ' + fmt(out * dpi2, 1) + '), the same ' + fmt(cm, 1) + ' cm/360');
		} else {
			text('#ed-out-sens', '-'); text('#ed-out-note', '');
		}

		allBody.textContent = '';
		Array.prototype.forEach.call(fromEl.options, function (o) {
			var y = Number(o.getAttribute('data-yaw'));
			if (!(y > 0)) { return; }
			var v = s * yawFrom / y;
			var tr = document.createElement('tr');
			[o.text, sens(v), fmt(v * dpi, 1)].forEach(function (c) { var td = document.createElement('td'); td.textContent = c; tr.appendChild(td); });
			allBody.appendChild(tr);
		});
	}

	[dpiEl, sensEl, dpi2El, yawFromEl, yawToEl].forEach(function (el) { el.addEventListener('input', calc); });
	[fromEl, toEl].forEach(function (el) { el.addEventListener('change', calc); });
	calc();
})();
