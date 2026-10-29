/* Screen info: resolution, size, aspect ratio, and the aspect ratio and PPI calculators.
   Shared by screen-resolution, screen-size, screen-ratio, aspect-ratio-calculator and ppi-calculator; it fills whatever
   elements the page has ([data-si] values, #si-res-table rows, #sz-*, #ar-*, #pp-*). Nothing is sent anywhere. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="screen-resolution"], [data-tool="screen-size"], [data-tool="screen-ratio"], [data-tool="aspect-ratio-calculator"], [data-tool="ppi-calculator"]');
	if (!root) { return; }
	var U = window.TNUtil, CAL = window.TNScreenCal;
	var $ = function (s) { return root.querySelector(s); };

	var NAMES = {
		'1024x768': 'XGA', '1280x720': 'HD (720p)', '1280x800': 'WXGA', '1280x1024': 'SXGA', '1366x768': 'HD (WXGA)', '1440x900': 'WXGA+',
		'1536x864': 'HD+ (scaled)', '1600x900': 'HD+', '1680x1050': 'WSXGA+', '1920x1080': 'Full HD (1080p)', '1920x1200': 'WUXGA',
		'2048x1080': 'DCI 2K', '2560x1080': 'UW-FHD (ultrawide)', '2560x1440': 'QHD (1440p)', '2560x1600': 'WQXGA', '2560x1664': 'Liquid Retina (MacBook Air 13.6")', '2880x1800': 'Retina WQXGA+',
		'3024x1964': 'Liquid Retina XDR (14")', '3456x2234': 'Liquid Retina XDR (16")', '3200x1800': 'QHD+', '3440x1440': 'UWQHD (ultrawide)',
		'3840x1600': 'UW4K (ultrawide)', '3840x2160': '4K UHD', '4096x2160': 'DCI 4K', '5120x1440': 'DQHD (super ultrawide)',
		'5120x2880': '5K', '6016x3384': '6K', '7680x4320': '8K UHD'
	};
	var RATIOS = [[1, 1], [5, 4], [4, 3], [3, 2], [16, 10], [5, 3], [16, 9], [18, 9], [19, 9], [19.5, 9], [20, 9], [21, 9], [32, 9]];

	function gcd(a, b) { a = Math.abs(a); b = Math.abs(b); while (b) { var t = b; b = a % b; a = t; } return a || 1; }
	function fmt(n, d) { return Number(n.toFixed(d === undefined ? 2 : d)).toLocaleString('en-US', { maximumFractionDigits: d === undefined ? 2 : d }); }
	function nearestRatio(w, h) {
		var r = Math.max(w, h) / Math.min(w, h), best = null, err = Infinity;
		RATIOS.forEach(function (q) { var e = Math.abs(q[0] / q[1] - r) / r; if (e < err) { err = e; best = q; } });
		var name = best[0] === 21 ? '21:9 (ultrawide, really 64:27 or 43:18)' : best[0] + ':' + best[1];
		return { name: name, exact: err < 0.012, ratio: r };
	}
	function reduced(w, h) { var g = gcd(Math.round(w), Math.round(h)); return Math.round(w) / g + ':' + Math.round(h) / g; }

	function read() {
		var dpr = window.devicePixelRatio || 1, sw = screen.width, sh = screen.height;
		return {
			dpr: dpr, sw: sw, sh: sh,
			pw: Math.round(sw * dpr), ph: Math.round(sh * dpr),
			vw: window.innerWidth, vh: window.innerHeight,
			aw: screen.availWidth, ah: screen.availHeight,
			depth: screen.colorDepth
		};
	}

	function set(key, val) { U.$$('[data-si="' + key + '"]', root).forEach(function (el) { el.textContent = val; }); }

	/* ---------- Live screen values ---------- */
	function fill() {
		var s = read();
		var longP = Math.max(s.pw, s.ph), shortP = Math.min(s.pw, s.ph), key = longP + 'x' + shortP;
		set('physical', s.pw + ' x ' + s.ph);
		set('css', s.sw + ' x ' + s.sh);
		set('viewport', s.vw + ' x ' + s.vh);
		set('avail', s.aw + ' x ' + s.ah);
		set('dpr', fmt(s.dpr, 3));
		set('scaling', Math.round(s.dpr * 100) + '%');
		set('depth', s.depth + '-bit');
		set('orientation', s.pw >= s.ph ? 'Landscape' : 'Portrait');
		set('name', NAMES[key] || (s.dpr > 1.4 && shortP < 1400 ? 'High density phone or tablet screen' : 'Not a standard name'));
		set('megapixels', fmt(s.pw * s.ph / 1e6, 2) + ' MP');
		var nr = nearestRatio(s.pw, s.ph), vr = nearestRatio(s.vw, s.vh);
		set('ratio', (nr.exact ? nr.name : reduced(Math.max(s.pw, s.ph), Math.min(s.pw, s.ph))));
		set('ratio-near', nr.exact ? 'exactly ' + nr.name.split(' ')[0] : 'close to ' + nr.name);
		set('ratio-dec', fmt(nr.ratio, 3) + ':1');
		set('ratio-reduced', reduced(longP, shortP));
		set('vp-ratio', fmt(vr.ratio, 2) + ':1 (' + (vr.exact ? '' : 'about ') + vr.name.split(' ')[0] + ')');
		U.$$('#si-res-table tr[data-res]', root).forEach(function (tr) { tr.classList.toggle('is-you', tr.getAttribute('data-res') === key); });
		U.$$('.si-box[data-ratio]', root).forEach(function (b) {
			var q = b.getAttribute('data-ratio').split(':');
			b.classList.toggle('is-you', Math.abs(q[0] / q[1] - nr.ratio) / nr.ratio < 0.012);
		});
		var you = $('#si-you-box');
		if (you) {
			// Fit the outline of this screen in a 320 x 180 box.
			var k = Math.min(Math.min(320, root.clientWidth - 40) / s.pw, 180 / s.ph);
			you.style.width = Math.round(s.pw * k) + 'px';
			you.style.height = Math.round(s.ph * k) + 'px';
		}
		sizeFill();
	}

	/* ---------- Screen size from the calibration ---------- */
	function sizeFill() {
		if (!$('#sz-diag-out') || !CAL) { return; }
		var s = read(), ppi = CAL.ppi(), wIn = s.sw / ppi, hIn = s.sh / ppi, dIn = Math.hypot(wIn, hIn);
		$('#sz-diag-out').textContent = fmt(dIn, 1) + '"';
		set('size-cm', fmt(dIn * 2.54, 1) + ' cm');
		set('size-w', fmt(wIn, 1) + '" (' + fmt(wIn * 2.54, 1) + ' cm)');
		set('size-h', fmt(hIn, 1) + '" (' + fmt(hIn * 2.54, 1) + ' cm)');
		set('size-ppi', fmt(ppi * s.dpr, 0) + ' px per inch');
		$('#sz-note').textContent = CAL.calibrated() ? 'Measured from your calibration. Accurate to about 2-3% if the card matched closely.' : 'Rough guess: the screen is not calibrated, so this assumes 96 CSS px per inch. Calibrate below for a real measurement.';
		$('#sz-note').classList.toggle('is-bad', !CAL.calibrated());
	}

	/* ---------- Diagonal + ratio calculator (screen size page) ---------- */
	var szD = $('#sz-d');
	if (szD) {
		var szCalc = function () {
			var d = parseFloat(szD.value), rw = parseFloat($('#sz-rw').value), rh = parseFloat($('#sz-rh').value);
			var out = $('#sz-out');
			if (!(d > 0 && rw > 0 && rh > 0)) { out.textContent = 'Enter a diagonal and a ratio.'; return; }
			var k = d / Math.hypot(rw, rh), w = rw * k, h = rh * k;
			out.innerHTML = '';
			[['Width', fmt(w, 2) + ' in = ' + fmt(w * 2.54, 1) + ' cm'], ['Height', fmt(h, 2) + ' in = ' + fmt(h * 2.54, 1) + ' cm'], ['Area', fmt(w * h, 1) + ' sq in = ' + fmt(w * h * 6.4516, 0) + ' sq cm']].forEach(function (r) {
				var dt = document.createElement('dt'), dd = document.createElement('dd');
				dt.textContent = r[0];
				dd.textContent = r[1];
				out.appendChild(dt);
				out.appendChild(dd);
			});
		};
		['#sz-d', '#sz-rw', '#sz-rh'].forEach(function (id) { $(id).addEventListener('input', szCalc); });
		U.$$('[data-sz-ratio]', root).forEach(function (b) {
			b.addEventListener('click', function () {
				var q = b.getAttribute('data-sz-ratio').split(':');
				$('#sz-rw').value = q[0];
				$('#sz-rh').value = q[1];
				szCalc();
			});
		});
		szCalc();
	}

	/* ---------- Aspect ratio calculator ---------- */
	var w1 = $('#ar-w1');
	if (w1) {
		var h1 = $('#ar-h1'), w2 = $('#ar-w2'), h2 = $('#ar-h2'), last = 'w2';
		var arCalc = function () {
			var a = parseFloat(w1.value), b = parseFloat(h1.value), round = $('#ar-round').checked;
			if (!(a > 0 && b > 0)) { $('#ar-ratio').textContent = '-'; return; }
			var r = a / b, nr = nearestRatio(a, b);
			if (last === 'w2' && parseFloat(w2.value) > 0) { var hv = parseFloat(w2.value) / r; h2.value = round ? Math.round(hv) : fmt(hv, 2).replace(/,/g, ''); }
			if (last === 'h2' && parseFloat(h2.value) > 0) { var wv = parseFloat(h2.value) * r; w2.value = round ? Math.round(wv) : fmt(wv, 2).replace(/,/g, ''); }
			var isInt = a === Math.round(a) && b === Math.round(b);
			$('#ar-ratio').textContent = isInt ? reduced(a, b) : fmt(r, 4) + ':1';
			$('#ar-dec').textContent = fmt(r, 4) + ':1';
			var nn = nr.name.split(' ')[0];
			if (a < b) { nn = nn.split(':').reverse().join(':') + ' (portrait)'; }
			$('#ar-near').textContent = (nr.exact ? 'Standard ratio: ' : 'Closest standard ratio: ') + nn;
			var pv = $('#ar-preview');
			pv.style.aspectRatio = a + ' / ' + b;
			pv.style.width = a >= b ? '100%' : (a / b * 100) + '%';
			$('#ar-preview-label').textContent = (isInt ? reduced(a, b) : fmt(r, 3) + ':1');
			var list = $('#ar-sizes');
			list.innerHTML = '';
			[480, 720, 1080, 1440, 2160].forEach(function (hh) {
				var ww = hh * r, li = document.createElement('li');
				if (a < b) { li.textContent = hh + ' x ' + Math.round(hh / r); } else { li.textContent = Math.round(ww) + ' x ' + hh + (Math.abs(ww - Math.round(ww)) > 0.01 ? ' (' + fmt(ww, 2) + ' exact)' : ''); }
				list.appendChild(li);
			});
		};
		w1.addEventListener('input', arCalc);
		h1.addEventListener('input', arCalc);
		w2.addEventListener('input', function () { last = 'w2'; arCalc(); });
		h2.addEventListener('input', function () { last = 'h2'; arCalc(); });
		$('#ar-round').addEventListener('change', arCalc);
		U.$$('[data-ar]', root).forEach(function (b) {
			b.addEventListener('click', function () {
				var q = b.getAttribute('data-ar').split(':');
				w1.value = q[0];
				h1.value = q[1];
				arCalc();
			});
		});
		$('#ar-mine').addEventListener('click', function () { var s = read(); w1.value = s.pw; h1.value = s.ph; arCalc(); });
		$('#ar-swap').addEventListener('click', function () { var t = w1.value; w1.value = h1.value; h1.value = t; t = w2.value; w2.value = h2.value; h2.value = t; arCalc(); });
		arCalc();
	}

	/* ---------- PPI calculator ---------- */
	var ppW = $('#pp-w');
	if (ppW) {
		var ppH = $('#pp-h'), ppD = $('#pp-d'), ppUnit = $('#pp-unit');
		var ppCalc = function () {
			var w = parseFloat(ppW.value), h = parseFloat(ppH.value), d = parseFloat(ppD.value);
			if (!(w > 0 && h > 0 && d > 0)) { set('pp-ppi', '-'); return; }
			if (ppUnit.value === 'cm') { d /= 2.54; }
			var diagPx = Math.hypot(w, h), ppi = diagPx / d, wIn = w / ppi, hIn = h / ppi;
			var retina = 1 / (ppi * Math.tan(Math.PI / 180 / 60)); // inches at which one pixel spans 1 arcminute
			set('pp-ppi', fmt(ppi, 1));
			set('pp-ppcm', fmt(ppi / 2.54, 1));
			set('pp-pitch', fmt(25.4 / ppi, 3) + ' mm');
			set('pp-mp', fmt(w * h / 1e6, 2) + ' MP (' + Math.round(w * h).toLocaleString('en-US') + ' px)');
			set('pp-size', fmt(wIn * 2.54, 1) + ' x ' + fmt(hIn * 2.54, 1) + ' cm (' + fmt(wIn, 2) + ' x ' + fmt(hIn, 2) + ' in)');
			set('pp-ratio', nearestRatio(w, h).name.split(' ')[0] + ' (' + reduced(w, h) + ')');
			set('pp-retina', fmt(retina * 2.54, 0) + ' cm (' + fmt(retina, 1) + ' in)');
			var verdict = ppi >= 400 ? 'Phone-class density: pixels are invisible at any normal distance.' : ppi >= 200 ? 'High density (Retina class) for a laptop or tablet.' : ppi >= 140 ? 'Very sharp for a desktop monitor at arm\'s length.' : ppi >= 100 ? 'Sharp for a desktop monitor at arm\'s length.' : ppi >= 80 ? 'Standard desktop density: pixels can be seen up close.' : 'Low density: fine for a TV seen from the sofa, coarse up close.';
			set('pp-verdict', verdict);
		};
		[ppW, ppH, ppD].forEach(function (el) { el.addEventListener('input', ppCalc); });
		ppUnit.addEventListener('change', ppCalc);
		$('#pp-preset').addEventListener('change', function () {
			var v = this.value.split(',');
			if (v.length === 3) { ppW.value = v[0]; ppH.value = v[1]; ppD.value = v[2]; ppUnit.value = 'in'; ppCalc(); }
		});
		$('#pp-mine').addEventListener('click', function () {
			var s = read();
			ppW.value = Math.max(s.pw, s.ph);
			ppH.value = Math.min(s.pw, s.ph);
			if (CAL && CAL.calibrated() && !ppD.value) { ppD.value = fmt(Math.hypot(s.sw, s.sh) / CAL.ppi(), 1); ppUnit.value = 'in'; }
			ppCalc();
			ppD.focus();
		});
		ppCalc();
	}

	/* ---------- Copy ---------- */
	var copyBtn = $('#si-copy');
	if (copyBtn) {
		copyBtn.addEventListener('click', function () {
			var s = read();
			var txt = 'Screen resolution: ' + s.pw + ' x ' + s.ph + ' physical pixels\nCSS (scaled) size: ' + s.sw + ' x ' + s.sh + '\nDevice pixel ratio: ' + s.dpr + '\nBrowser viewport: ' + s.vw + ' x ' + s.vh + '\nColour depth: ' + s.depth + '-bit';
			var done = function () { U.status($('#si-status'), 'Copied to the clipboard.', 'ok'); };
			var fail = function () { U.status($('#si-status'), 'Your browser blocked the clipboard. Select the values above and copy them by hand.', 'bad'); };
			if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(txt).then(done, fail); } else { fail(); }
		});
	}

	if (CAL) { CAL.onChange(fill); }
	window.addEventListener('resize', fill);
	if (screen.orientation && screen.orientation.addEventListener) { screen.orientation.addEventListener('change', function () { setTimeout(fill, 150); }); }
	fill();
}());
