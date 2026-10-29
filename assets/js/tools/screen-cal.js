/* Shared screen calibration: CSS pixels per inch from a bank card or the screen diagonal.
   Stored under the online ruler's key, so calibrating once serves the ruler, eye tests and screen size page.
   Tool scripts read window.TNScreenCal.ppi() and listen with TNScreenCal.onChange(fn). */
(function () {
	'use strict';
	var KEY = 'tn-ruler-ppi', CARD_MM = 85.6;
	var ppi = 96, calibrated = false, listeners = [];
	try { var saved = parseFloat(localStorage.getItem(KEY)); if (saved > 20 && saved < 1000) { ppi = saved; calibrated = true; } } catch (e) { /* private mode */ }

	function set(v, isCal) {
		ppi = v;
		calibrated = isCal;
		try { if (isCal) { localStorage.setItem(KEY, v.toFixed(2)); } else { localStorage.removeItem(KEY); } } catch (e) { /* ignore */ }
		paint();
		listeners.forEach(function (fn) { fn(ppi, calibrated); });
	}

	window.TNScreenCal = {
		ppi: function () { return ppi; },
		calibrated: function () { return calibrated; },
		pxPerMm: function () { return ppi / 25.4; },
		onChange: function (fn) { listeners.push(fn); }
	};

	var box = document.getElementById('sc-cal');
	if (!box) { return; }
	var $ = function (s) { return box.querySelector(s); };
	var card = $('#sc-card'), slider = $('#sc-slider'), state = $('#sc-state'), diag = $('#sc-diag'), hint = $('#sc-hint');
	// On a narrow phone screen the card's long side (85.60 mm) does not fit, so match its short side (53.98 mm) instead.
	var SHORT_MM = 53.98, edge = CARD_MM, other = SHORT_MM;

	function size(w) {
		card.style.width = w + 'px';
		card.style.height = (w * other / edge) + 'px';
	}

	function paint() {
		var narrow = window.innerWidth < 560;
		edge = narrow ? SHORT_MM : CARD_MM;
		other = narrow ? CARD_MM : SHORT_MM;
		hint.textContent = narrow ? 'Hold a bank or ID card upright against the screen and drag the slider until the box is exactly as wide as the card\'s short side.' : 'Hold any bank or ID card flat against the screen and drag the slider until the box is exactly as wide as the card.';
		var w = edge / 25.4 * ppi;
		size(w);
		slider.value = Math.round(w);
		state.textContent = calibrated ? '(calibrated: ' + Math.round(ppi) + ' px per inch)' : '(not calibrated: sizes assume 96 px per inch)';
		box.classList.toggle('is-cal', calibrated);
	}

	slider.addEventListener('input', function () { size(Number(slider.value)); });
	$('#sc-card-apply').addEventListener('click', function () { set(Number(slider.value) / (edge / 25.4), true); });
	$('#sc-diag-apply').addEventListener('click', function () {
		var d = parseFloat(diag.value);
		if (!(d >= 3 && d <= 100)) { diag.focus(); return; }
		set(Math.hypot(screen.width, screen.height) / d, true);
	});
	$('#sc-reset').addEventListener('click', function () { set(96, false); });
	paint();
}());
