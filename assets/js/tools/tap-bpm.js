/* Tap BPM: taps (pointer or any key) -> average BPM over the run, BPM of the last few taps, stability, halve/double, auto reset after a pause. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="tap-bpm"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#tb-stage'), big = $('#tb-big'), small = $('#tb-small'), ring = $('#tb-ring');
	var lastEl = $('#tb-last'), avgEl = $('#tb-avg'), countEl = $('#tb-count'), stabEl = $('#tb-stab'), msEl = $('#tb-ms'), statusEl = $('#tb-status');
	var resetBtn = $('#tb-reset'), halfBtn = $('#tb-half'), doubleBtn = $('#tb-double'), autoChk = $('#tb-auto');

	var taps = [], mul = 1, lastInput = 0, idleTimer = 0, bpm = 0;
	var GENRES = [[70, 'slow ballad / downtempo'], [95, 'hip hop / reggae'], [110, 'pop / funk'], [128, 'house / disco'], [140, 'techno / trance'], [160, 'drum and bass (half) / fast rock'], [180, 'drum and bass / punk'], [400, 'very fast']];

	function genre(b) {
		for (var i = 0; i < GENRES.length; i++) { if (b < GENRES[i][0]) { return GENRES[i][1]; } }
		return 'very fast';
	}

	function stats() {
		if (taps.length < 2) { return null; }
		var gaps = [];
		for (var i = 1; i < taps.length; i++) { gaps.push(taps[i] - taps[i - 1]); }
		var avg = (taps[taps.length - 1] - taps[0]) / (taps.length - 1);
		var recent = gaps.slice(-4);
		var last = recent.reduce(function (a, b) { return a + b; }, 0) / recent.length;
		var sd = Math.sqrt(gaps.reduce(function (a, g) { return a + (g - avg) * (g - avg); }, 0) / gaps.length);
		return { avg: avg, last: last, sd: sd };
	}

	function render() {
		var s = stats();
		countEl.textContent = taps.length;
		if (!s) {
			big.textContent = taps.length ? 'Keep tapping' : 'Tap here';
			small.textContent = taps.length ? 'One more tap gives the first reading.' : 'Tap in time with the music. Space or any key works too.';
			lastEl.textContent = avgEl.textContent = stabEl.textContent = msEl.textContent = '-';
			return;
		}
		bpm = 60000 / s.avg * mul;
		var lastBpm = 60000 / s.last * mul;
		var stab = Math.max(0, Math.round(100 - s.sd / s.avg * 100));
		big.textContent = U.fmt(bpm, taps.length >= 8 ? 1 : 0) + ' BPM';
		small.textContent = taps.length < 4 ? 'Keep tapping for a steadier reading.' : genre(bpm) + (mul !== 1 ? ' (' + (mul === 2 ? 'doubled' : 'halved') + ')' : '');
		avgEl.textContent = U.fmt(bpm, 1);
		lastEl.textContent = U.fmt(lastBpm, 1);
		stabEl.textContent = stab + '%';
		msEl.textContent = U.fmt(s.avg / mul, 0) + ' ms';
		if (taps.length >= 8) {
			U.status(statusEl, 'About ' + Math.round(bpm) + ' BPM over ' + taps.length + ' taps (' + genre(bpm) + ').', stab >= 85 ? 'ok' : '');
		}
	}

	function reset(keepStatus) {
		taps = [];
		mul = 1;
		bpm = 0;
		clearTimeout(idleTimer);
		stage.classList.remove('is-live');
		render();
		if (!keepStatus) { U.status(statusEl, 'Tap the big area, press Space or any key in time with the beat.', ''); }
	}

	function tap(t) {
		if (t - lastInput < 40) { return; }
		lastInput = t;
		if (taps.length && t - taps[taps.length - 1] > 3000) { reset(true); }
		taps.push(t);
		if (taps.length > 64) { taps.shift(); }
		stage.classList.add('is-live');
		ring.classList.remove('is-hit');
		void ring.offsetWidth;
		ring.classList.add('is-hit');
		render();
		clearTimeout(idleTimer);
		if (autoChk.checked) {
			idleTimer = setTimeout(function () {
				if (taps.length >= 2) { U.status(statusEl, 'Paused: final reading ' + Math.round(bpm) + ' BPM from ' + taps.length + ' taps. Tap again to start a new count.', 'ok'); }
				stage.classList.remove('is-live');
			}, 3000);
		}
	}

	stage.addEventListener('pointerdown', function (e) { if (e.button === 0 || e.pointerType !== 'mouse') { e.preventDefault(); tap(e.timeStamp || performance.now()); } });
	stage.addEventListener('touchstart', function (e) { e.preventDefault(); tap(e.timeStamp || performance.now()); }, { passive: false });
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });
	document.addEventListener('keydown', function (e) {
		if (e.repeat || e.metaKey || e.ctrlKey || e.altKey) { return; }
		var tag = (e.target.tagName || '').toLowerCase();
		if (tag === 'input' || tag === 'textarea' || tag === 'select') { return; }
		if (tag === 'button' && e.target !== stage && (e.key === 'Enter' || e.key === ' ')) { return; } // let the button click
		if (e.key === 'Tab' || e.key === 'Escape' || /^F\d+$/.test(e.key)) { return; }
		var plain = e.key === ' ' || e.key === 'Enter' || /^[a-z0-9]$/i.test(e.key);
		if (!plain && !root.contains(e.target)) { return; }
		if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); }
		tap(e.timeStamp || performance.now());
	});
	resetBtn.addEventListener('click', function () { reset(); resetBtn.blur(); });
	halfBtn.addEventListener('click', function () { mul = mul === 2 ? 1 : 0.5; render(); halfBtn.blur(); });
	doubleBtn.addEventListener('click', function () { mul = mul === 0.5 ? 1 : 2; render(); doubleBtn.blur(); });
	reset();
}());
