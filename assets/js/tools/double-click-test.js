/* Double click test: times the gap between mousedown events and flags any gap under the threshold. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="double-click-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#dc-stage'), area = $('#dc-area'), big = $('#dc-big'), lastEl = $('#dc-last');
	var countEl = $('#dc-count'), badEl = $('#dc-bad'), gapEl = $('#dc-gap'), minEl = $('#dc-min');
	var log = $('#dc-log'), statusEl = $('#dc-status'), ms = $('#dc-ms'), msOut = $('#dc-msout');
	var btnSel = U.$$('[data-dc-btn]', root);

	var button = 0, count = 0, bad = 0, minGap = Infinity, lastT = 0;

	function threshold() { return Number(ms.value); }

	function record(t) {
		count++;
		var gap = lastT ? t - lastT : 0;
		lastT = t;
		var faulty = count > 1 && gap < threshold();
		if (faulty) { bad++; }
		if (gap > 0) { minGap = Math.min(minGap, gap); }

		countEl.textContent = count;
		badEl.textContent = bad;
		gapEl.textContent = gap ? U.fmt(gap, 0) + ' ms' : '-';
		minEl.textContent = isFinite(minGap) ? U.fmt(minGap, 0) + ' ms' : '-';

		var bar = document.createElement('span');
		bar.className = 'dc-bar' + (faulty ? ' is-bad' : '');
		bar.style.height = Math.max(8, Math.min(100, gap ? (gap / 600) * 100 : 100)) + '%';
		bar.title = gap ? U.fmt(gap, 0) + ' ms' : 'first click';
		log.appendChild(bar);
		if (log.children.length > 60) { log.removeChild(log.firstChild); }

		area.classList.remove('is-ok', 'is-bad');
		void area.offsetWidth;
		area.classList.add(faulty ? 'is-bad' : 'is-ok');
		big.textContent = faulty ? 'Double click detected!' : 'Click ' + count;
		lastEl.textContent = faulty ? 'A second click arrived ' + U.fmt(gap, 0) + ' ms after the last one. That is faster than a person can click.' : (gap ? 'Gap since last click: ' + U.fmt(gap, 0) + ' ms.' : 'First click registered.');

		if (bad) {
			U.status(statusEl, bad + ' faulty double click' + (bad > 1 ? 's' : '') + ' in ' + count + ' clicks. Your mouse switch is bouncing. See the fixes below.', 'bad');
		} else if (count >= 20) {
			U.status(statusEl, count + ' clicks, no faulty doubles. This button looks healthy.', 'ok');
		} else {
			U.status(statusEl, count + ' click' + (count > 1 ? 's' : '') + ' so far, no faults. Keep going to about 20.', '');
		}
	}

	stage.addEventListener('mousedown', function (e) {
		if (e.button !== button) { return; }
		if (e.button !== 0) { e.preventDefault(); }
		record(e.timeStamp || performance.now());
	});
	stage.addEventListener('mouseup', function (e) { if (e.button === 3 || e.button === 4) { e.preventDefault(); } });
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });
	stage.addEventListener('auxclick', function (e) { e.preventDefault(); });
	stage.addEventListener('dblclick', function (e) { e.preventDefault(); });
	stage.addEventListener('touchstart', function (e) {
		e.preventDefault();
		if (button === 0) { record(e.timeStamp || performance.now()); }
	}, { passive: false });

	btnSel.forEach(function (b) {
		b.addEventListener('click', function () {
			button = Number(b.getAttribute('data-dc-btn'));
			btnSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
			var name = { 0: 'left', 1: 'middle', 2: 'right' }[button];
			big.textContent = 'Click here with the ' + name + ' button';
		});
	});

	ms.addEventListener('input', function () {
		msOut.textContent = ms.value + ' ms';
		lastEl.textContent = 'A second click arriving within ' + ms.value + ' ms now counts as a fault.';
	});

	function reset() {
		count = bad = 0; minGap = Infinity; lastT = 0;
		countEl.textContent = badEl.textContent = '0';
		gapEl.textContent = minEl.textContent = '-';
		log.innerHTML = '';
		area.classList.remove('is-ok', 'is-bad');
		big.textContent = 'Click here once at a time';
		lastEl.textContent = 'Single clicks are normal. A second click arriving within ' + ms.value + ' ms is a fault.';
		U.status(statusEl, 'Click in the box about 20 times, one clear click at a time.', '');
	}
	$('#dc-reset').addEventListener('click', reset);
}());
