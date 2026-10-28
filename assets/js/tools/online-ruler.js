/* Online ruler: canvas ruler in cm/mm or inches at a calibrated pixels-per-inch (bank card, screen diagonal or fine tune), stored in localStorage; drag to measure. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="online-ruler"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#rl-stage'), wrap = $('#rl-wrap'), canvas = $('#rl-canvas'), cx = canvas.getContext('2d');
	var measure = $('#rl-measure'), measureLabel = $('#rl-measure-label'), tip = $('#rl-tip');
	var ppiEl = $('#rl-ppi'), ppcmEl = $('#rl-ppcm'), lenEl = $('#rl-len'), valEl = $('#rl-val'), statusEl = $('#rl-status');
	var calState = $('#rl-cal-state'), card = $('#rl-card'), cardSlider = $('#rl-card-slider'), diagIn = $('#rl-diag'), resEl = $('#rl-res');
	var unitSel = U.$$('[data-rl-unit]', root);

	var KEY = 'tn-ruler-ppi';
	var CARD_MM = 85.6;
	var ppi = 96, unit = 'cm', vertical = false, calibrated = false, dragStart = null, dragEnd = null;

	try { var saved = parseFloat(localStorage.getItem(KEY)); if (saved > 20 && saved < 1000) { ppi = saved; calibrated = true; } } catch (e) { /* private mode */ }

	function save() {
		try { localStorage.setItem(KEY, ppi.toFixed(2)); } catch (e) { /* ignore */ }
		calibrated = true;
	}

	function pxPerUnit() { return unit === 'cm' ? ppi / 2.54 : ppi; }

	function colours() {
		var cs = getComputedStyle(root);
		return { ink: cs.getPropertyValue('--text').trim() || '#121721', muted: cs.getPropertyValue('--muted').trim() || '#5a6473', bg: cs.getPropertyValue('--surface').trim() || '#fff', brand: cs.getPropertyValue('--brand').trim() || '#0f766e' };
	}

	function draw() {
		var dpr = window.devicePixelRatio || 1;
		var W = wrap.clientWidth, H = wrap.clientHeight;
		if (!W || !H) { return; }
		canvas.width = Math.round(W * dpr);
		canvas.height = Math.round(H * dpr);
		canvas.style.width = W + 'px';
		canvas.style.height = H + 'px';
		cx.setTransform(dpr, 0, 0, dpr, 0, 0);
		var c = colours();
		cx.fillStyle = c.bg;
		cx.fillRect(0, 0, W, H);

		var length = vertical ? H : W; // px along the ruler
		var ppu = pxPerUnit();
		var pad = 12;
		var usable = length - pad * 2;
		var units = usable / ppu;
		lenEl.textContent = unit === 'cm' ? units.toFixed(1) + ' cm' : units.toFixed(1) + ' in';

		cx.save();
		if (vertical) { cx.translate(W, 0); cx.rotate(Math.PI / 2); } // ruler along the left edge, numbers readable
		var depth = vertical ? W : H; // thickness of the ruler
		cx.strokeStyle = c.ink;
		cx.fillStyle = c.ink;
		cx.lineWidth = 1;
		cx.font = '600 13px ' + (getComputedStyle(root).getPropertyValue('--font') || 'system-ui');
		cx.textAlign = 'center';
		cx.textBaseline = 'top';

		// Baseline
		cx.beginPath(); cx.moveTo(pad, 0.5); cx.lineTo(length - pad, 0.5); cx.stroke();

		var sub = unit === 'cm' ? 10 : 16; // ticks per unit
		var total = Math.floor(units * sub);
		for (var i = 0; i <= total; i++) {
			var x = Math.round(pad + (i / sub) * ppu) + 0.5;
			var h;
			if (i % sub === 0) { h = 34; }
			else if (unit === 'cm') { h = i % 5 === 0 ? 22 : 12; }
			else { h = i % 8 === 0 ? 26 : i % 4 === 0 ? 18 : i % 2 === 0 ? 12 : 8; }
			cx.lineWidth = i % sub === 0 ? 1.5 : 1;
			cx.beginPath(); cx.moveTo(x, 0); cx.lineTo(x, h); cx.stroke();
			if (i % sub === 0) {
				var n = i / sub;
				cx.fillText(String(n), x + (n === 0 ? 6 : 0), h + 6);
			}
		}
		// Unit label
		cx.textAlign = 'right';
		cx.fillStyle = c.muted;
		cx.font = '500 12px system-ui';
		cx.fillText(unit === 'cm' ? 'centimetres (1 mm marks)' : 'inches (1/16 marks)', length - pad, depth - 22);
		cx.restore();

		ppiEl.textContent = Math.round(ppi);
		ppcmEl.textContent = (ppi / 2.54).toFixed(1);
		calState.textContent = calibrated ? '(calibrated: ' + Math.round(ppi) + ' px per inch)' : '(not calibrated: using the browser\'s default 96 px per inch)';
		card.style.width = (CARD_MM / 25.4 * ppi) + 'px';
		card.style.height = (53.98 / 25.4 * ppi) + 'px';
		cardSlider.value = Math.round(CARD_MM / 25.4 * ppi);
		drawMeasure();
	}

	function pos(e) {
		var r = wrap.getBoundingClientRect();
		return vertical ? e.clientY - r.top : e.clientX - r.left;
	}

	function fmtLen(px) {
		var pad = 12;
		var u = px / pxPerUnit();
		if (unit === 'cm') { return u >= 1 ? u.toFixed(2) + ' cm' : (u * 10).toFixed(1) + ' mm'; }
		var frac = Math.round((u % 1) * 16), whole = Math.floor(u);
		if (frac === 16) { whole++; frac = 0; }
		return u.toFixed(2) + ' in' + (frac ? ' (' + (whole ? whole + ' ' : '') + frac / gcd(frac, 16) + '/' + 16 / gcd(frac, 16) + ')' : '');
	}
	function gcd(a, b) { return b ? gcd(b, a % b) : a; }

	function drawMeasure() {
		if (dragStart === null || dragEnd === null) { measure.hidden = true; return; }
		var a = Math.min(dragStart, dragEnd), b = Math.max(dragStart, dragEnd);
		measure.hidden = false;
		if (vertical) { measure.style.top = a + 'px'; measure.style.height = (b - a) + 'px'; measure.style.left = '0'; measure.style.width = '100%'; }
		else { measure.style.left = a + 'px'; measure.style.width = (b - a) + 'px'; measure.style.top = '0'; measure.style.height = '100%'; }
		var txt = fmtLen(b - a);
		measureLabel.textContent = txt;
		valEl.textContent = txt;
	}

	var dragging = false;
	wrap.addEventListener('pointerdown', function (e) {
		if (e.button !== 0 && e.pointerType === 'mouse') { return; }
		e.preventDefault();
		dragging = true;
		dragStart = pos(e); dragEnd = dragStart;
		wrap.setPointerCapture(e.pointerId);
		drawMeasure();
	});
	wrap.addEventListener('pointermove', function (e) { if (!dragging) { return; } dragEnd = pos(e); drawMeasure(); });
	function endDrag() { if (dragging) { dragging = false; if (Math.abs(dragEnd - dragStart) < 2) { dragStart = dragEnd = null; valEl.textContent = '-'; drawMeasure(); } } }
	wrap.addEventListener('pointerup', endDrag);
	wrap.addEventListener('pointercancel', endDrag);
	wrap.addEventListener('touchstart', function (e) { e.preventDefault(); }, { passive: false });

	unitSel.forEach(function (b) {
		b.addEventListener('click', function () {
			unit = b.getAttribute('data-rl-unit');
			unitSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			draw();
		});
	});
	$('#rl-flip').addEventListener('click', function () {
		vertical = !vertical;
		stage.classList.toggle('is-vertical', vertical);
		this.textContent = vertical ? 'Horizontal' : 'Vertical';
		dragStart = dragEnd = null;
		draw();
	});

	// Calibration: bank card
	cardSlider.addEventListener('input', function () {
		var w = Number(cardSlider.value);
		card.style.width = w + 'px';
		card.style.height = (w * 53.98 / CARD_MM) + 'px';
	});
	$('#rl-card-apply').addEventListener('click', function () {
		ppi = Number(cardSlider.value) / (CARD_MM / 25.4);
		save(); draw();
		U.status(statusEl, 'Calibrated from a bank card: ' + Math.round(ppi) + ' pixels per inch. Saved in this browser.', 'ok');
	});
	// Calibration: screen diagonal
	function showRes() {
		var w = screen.width, h = screen.height, dpr = window.devicePixelRatio || 1;
		resEl.textContent = 'Screen: ' + Math.round(w * dpr) + ' x ' + Math.round(h * dpr) + ' physical px (' + w + ' x ' + h + ' CSS px, scale ' + dpr + 'x).';
	}
	showRes();
	$('#rl-diag-apply').addEventListener('click', function () {
		var d = parseFloat(diagIn.value);
		if (!(d > 2 && d < 120)) { U.status(statusEl, 'Enter the screen diagonal in inches, for example 15.6 or 27.', 'bad'); return; }
		var w = screen.width, h = screen.height;
		var diagCss = Math.sqrt(w * w + h * h);
		ppi = diagCss / d; // CSS px per inch (devicePixelRatio already applied by the browser)
		save(); draw();
		U.status(statusEl, 'Calibrated from a ' + d + ' inch screen: ' + Math.round(ppi) + ' pixels per inch. Check with a card or ruler if display scaling is unusual.', 'ok');
	});
	U.$$('[data-rl-adj]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			ppi *= 1 + Number(b.getAttribute('data-rl-adj')) / 100;
			save(); draw();
			U.status(statusEl, 'Adjusted to ' + ppi.toFixed(1) + ' pixels per inch.', '');
		});
	});
	$('#rl-cal-reset').addEventListener('click', function () {
		ppi = 96; calibrated = false;
		try { localStorage.removeItem(KEY); } catch (e) { /* ignore */ }
		draw();
		U.status(statusEl, 'Calibration cleared. The ruler assumes 96 pixels per inch again.', '');
	});

	var ro = window.ResizeObserver ? new ResizeObserver(function () { draw(); }) : null;
	if (ro) { ro.observe(wrap); } else { window.addEventListener('resize', draw); }
	stage.addEventListener('tn:fullscreen', function () { setTimeout(draw, 50); });
	document.addEventListener('fullscreenchange', function () { setTimeout(draw, 50); });
	new MutationObserver(draw).observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
	draw();
	if (calibrated) { U.status(statusEl, 'Using your saved calibration: ' + Math.round(ppi) + ' pixels per inch.', 'ok'); }
}());
