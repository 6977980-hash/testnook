/* CPS test: counts raw pointer presses in the stage for a chosen number of seconds; timer starts on the first click.
   Shared by cps-test, right-click-cps-test, jitter-click-test and auto-clicker-test; the stage's data-cps-mode (left | right | jitter | auto) picks the button and the ranks.
   Auto mode also records every press time and reports the mean interval and its spread, which tells a program apart from a finger.
   The fixed-length pages (1-second-cps-test ... 100-second-click-test) have no length buttons; the stage's data-cps-dur sets the seconds. */
(function () {
	'use strict';
	var stage0 = document.getElementById('cps-stage');
	var root = stage0 && stage0.closest('[data-tool]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#cps-stage'), ring = $('#cps-ring'), timerEl = $('#cps-timer'), big = $('#cps-big'), small = $('#cps-small');
	var cpsEl = $('#cps-cps'), countEl = $('#cps-count'), peakEl = $('#cps-peak'), rankEl = $('#cps-rank');
	var graph = $('#cps-graph'), statusEl = $('#cps-status'), pbEl = $('#cps-pb'), rightOk = $('#cps-right');
	var tSel = U.$$('[data-cps-t]', root), consistEl = $('#cps-consist'), intervalEl = $('#cps-interval'), spreadEl = $('#cps-spread');
	var mode = stage.getAttribute('data-cps-mode') || 'left';

	var pressed = root.querySelector('[data-cps-t][aria-pressed="true"]');
	var dur = pressed ? Number(pressed.getAttribute('data-cps-t')) : Number(stage.getAttribute('data-cps-dur')) || 5, count = 0, running = false, start = 0, raf = 0, perSec = [], lastInput = 0, stamps = [];

	function key() { return 'tn-cps-best-' + (mode === 'left' ? '' : mode + '-') + dur; }
	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(key())) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best for ' + dur + ' s in this browser: ' + U.fmt(v, 1) + ' CPS' : '';
		return v;
	}

	function rank(cps) {
		if (mode === 'auto') {
			if (cps < 1) { return '-'; }
			var sp = spread();
			if (count >= 20 && sp.cv < 0.08) { return 'Automated'; }
			if (count >= 20 && sp.cv < 0.2) { return 'Probably automated'; }
			return 'Looks human';
		}
		if (mode === 'jitter') {
			if (cps < 6) { return 'Not jittering yet'; }
			if (cps < 9) { return 'Warming up'; }
			if (cps < 12) { return 'Jitter'; }
			if (cps < 15) { return 'Fast jitter'; }
			return 'Pro jitter';
		}
		if (cps < 4) { return 'Turtle'; }
		if (cps < 6) { return 'Rabbit'; }
		if (cps < 8) { return 'Fox'; }
		if (cps < 10) { return 'Cheetah'; }
		return 'Lightning';
	}

	/* Mean gap between presses and its coefficient of variation (SD / mean). A human finger varies by 20-40%; a program by under 5%. */
	function spread() {
		var gaps = [];
		for (var i = 1; i < stamps.length; i++) { gaps.push(stamps[i] - stamps[i - 1]); }
		if (gaps.length < 2) { return { mean: 0, sd: 0, cv: 1 }; }
		var mean = gaps.reduce(function (a, b) { return a + b; }, 0) / gaps.length;
		var sd = Math.sqrt(gaps.reduce(function (a, g) { return a + (g - mean) * (g - mean); }, 0) / gaps.length);
		return { mean: mean, sd: sd, cv: mean ? sd / mean : 1 };
	}

	function drawGraph() {
		graph.innerHTML = '';
		var max = Math.max.apply(null, perSec.concat([1]));
		perSec.forEach(function (n) {
			var b = document.createElement('span');
			b.style.height = Math.max(4, (n / max) * 100) + '%';
			b.title = n + ' clicks';
			graph.appendChild(b);
		});
	}

	function tick() {
		var el = (performance.now() - start) / 1000;
		var left = Math.max(0, dur - el);
		timerEl.textContent = left.toFixed(1);
		ring.style.setProperty('--p', (left / dur * 100) + '%');
		cpsEl.textContent = U.fmt(count / Math.max(el, 0.05), 1);
		if (left <= 0) { stop(); return; }
		raf = requestAnimationFrame(tick);
	}

	function stop() {
		running = false;
		cancelAnimationFrame(raf);
		var cps = count / dur;
		cpsEl.textContent = U.fmt(cps, 1);
		timerEl.textContent = '0.0';
		peakEl.textContent = U.fmt(Math.max.apply(null, perSec.concat([0])), 1);
		rankEl.textContent = rank(cps);
		if (consistEl) {
			// Consistency: 100% when every second had the same count; the spread (SD) lowers it.
			var mean = count / dur, sd = Math.sqrt(perSec.reduce(function (a, n) { return a + (n - mean) * (n - mean); }, 0) / dur);
			consistEl.textContent = mean ? Math.max(0, Math.round(100 - sd / mean * 100)) + '%' : '-';
		}
		if (intervalEl) {
			var sp = spread();
			intervalEl.textContent = sp.mean ? U.fmt(sp.mean, 1) + ' ms' : '-';
			spreadEl.textContent = sp.mean ? '\u00b1' + U.fmt(sp.sd, 1) + ' ms (' + Math.round(sp.cv * 100) + '%)' : '-';
		}
		drawGraph();
		stage.classList.remove('is-running');
		stage.classList.add('is-done');
		big.textContent = U.fmt(cps, 1) + ' CPS';
		small.textContent = count + ' clicks in ' + dur + ' s. ' + rank(cps) + (mode === 'auto' ? '.' : '!') + ' Click to go again.';
		var best = pb(), msg = 'Done: ' + count + ' clicks in ' + dur + ' seconds = ' + U.fmt(cps, 1) + ' clicks per second (' + rank(cps) + ').';
		if (mode === 'auto') {
			var r = rank(cps), s2 = spread();
			if (r === 'Automated') { msg += ' The gap between clicks was ' + U.fmt(s2.mean, 1) + ' ms with only ' + Math.round(s2.cv * 100) + '% variation: that regularity is a program, so the auto clicker is working at ' + U.fmt(cps, 1) + ' CPS.'; }
			else if (r === 'Probably automated') { msg += ' The clicks are more regular than a finger manages, but with some variation; the auto clicker may have a random delay enabled, or the browser is dropping some clicks.'; }
			else if (count < 20) { msg += ' Fewer than 20 clicks is not enough to judge regularity; run a longer test.'; }
			else { msg += ' The gaps between clicks varied by ' + Math.round(s2.cv * 100) + '%, which is what a finger does. If an auto clicker was running, it is not reaching this page: check it targets the browser window and that the pointer stays over the box.'; }
		}
		if (cps > best) {
			try { localStorage.setItem(key(), cps.toFixed(2)); } catch (e) { /* ignore */ }
			pb();
			if (best) { msg += ' New personal best!'; }
		}
		U.status(statusEl, msg, mode === 'auto' ? (rank(cps) === 'Automated' ? 'ok' : '') : (cps >= (mode === 'jitter' ? 9 : 6) ? 'ok' : ''));
	}

	function begin(t) {
		running = true;
		start = t;
		count = 0;
		perSec = [];
		stamps = [];
		for (var i = 0; i < dur; i++) { perSec.push(0); }
		stage.classList.remove('is-done');
		stage.classList.add('is-running');
		big.textContent = '0';
		small.textContent = 'Keep clicking!';
		rankEl.textContent = '-';
		peakEl.textContent = '0.0';
		if (consistEl) { consistEl.textContent = '-'; }
		graph.innerHTML = '';
		U.status(statusEl, 'Go! Click as fast as you can.', '');
		raf = requestAnimationFrame(tick);
	}

	function press(t) {
		if (t - lastInput < (mode === 'auto' ? 0.5 : 8)) { return; } // ignore duplicate events for one press (auto clickers can run at 1 ms gaps)
		lastInput = t;
		if (!running) { begin(t); }
		count++;
		if (mode === 'auto') { stamps.push(t); }
		var sec = Math.min(dur - 1, Math.floor((t - start) / 1000));
		if (sec >= 0) { perSec[sec]++; }
		countEl.textContent = count;
		big.textContent = count;
		stage.classList.remove('is-hit');
		void stage.offsetWidth;
		stage.classList.add('is-hit');
	}

	function wanted(button) {
		if (mode === 'right') { return button === 2; }
		if (mode === 'auto') { return button === 0 || button === 2; }
		return button === 0 || (button === 2 && rightOk && rightOk.checked);
	}
	stage.addEventListener('pointerdown', function (e) {
		if (e.pointerType === 'mouse' && !wanted(e.button)) { return; }
		e.preventDefault();
		press(e.timeStamp || performance.now());
	});
	stage.addEventListener('touchstart', function (e) { e.preventDefault(); if (mode !== 'auto') { press(e.timeStamp || performance.now()); } }, { passive: false });
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });
	stage.addEventListener('dblclick', function (e) { e.preventDefault(); });
	stage.addEventListener('mousedown', function (e) { if (e.button !== 0) { e.preventDefault(); } });

	function reset() {
		running = false;
		cancelAnimationFrame(raf);
		count = 0; perSec = [];
		stage.classList.remove('is-running', 'is-done');
		timerEl.textContent = dur.toFixed(1);
		ring.style.setProperty('--p', '100%');
		cpsEl.textContent = peakEl.textContent = '0.0';
		countEl.textContent = '0';
		rankEl.textContent = '-';
		if (consistEl) { consistEl.textContent = '-'; }
		if (intervalEl) { intervalEl.textContent = spreadEl.textContent = '-'; }
		graph.innerHTML = '';
		big.textContent = mode === 'right' ? 'Right click here to start' : 'Click here to start';
		small.textContent = mode === 'right' ? 'The timer starts on your first right click.' : 'The timer starts on your first click.';
		U.status(statusEl, !tSel.length ? 'Click in the box as fast as you can. The ' + dur + ' second timer starts on your first click.' : mode === 'right' ? 'Pick a time, then right click in the box as fast as you can.' : mode === 'auto' ? 'Pick a time, move the pointer into the box and start your auto clicker. The timer starts on the first click.' : 'Pick a time, then click in the box as fast as you can.', '');
		pb();
	}
	$('#cps-reset').addEventListener('click', reset);
	tSel.forEach(function (b) {
		b.addEventListener('click', function () {
			dur = Number(b.getAttribute('data-cps-t'));
			tSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
		});
	});
	reset();
}());
