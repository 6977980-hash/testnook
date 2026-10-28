/* CPS test: counts raw pointer presses in the stage for a chosen number of seconds; timer starts on the first click. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="cps-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#cps-stage'), ring = $('#cps-ring'), timerEl = $('#cps-timer'), big = $('#cps-big'), small = $('#cps-small');
	var cpsEl = $('#cps-cps'), countEl = $('#cps-count'), peakEl = $('#cps-peak'), rankEl = $('#cps-rank');
	var graph = $('#cps-graph'), statusEl = $('#cps-status'), pbEl = $('#cps-pb'), rightOk = $('#cps-right');
	var tSel = U.$$('[data-cps-t]', root);

	var dur = 5, count = 0, running = false, start = 0, raf = 0, perSec = [], lastInput = 0;

	function key() { return 'tn-cps-best-' + dur; }
	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(key())) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best for ' + dur + ' s in this browser: ' + U.fmt(v, 1) + ' CPS' : '';
		return v;
	}

	function rank(cps) {
		if (cps < 4) { return 'Turtle'; }
		if (cps < 6) { return 'Rabbit'; }
		if (cps < 8) { return 'Fox'; }
		if (cps < 10) { return 'Cheetah'; }
		return 'Lightning';
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
		drawGraph();
		stage.classList.remove('is-running');
		stage.classList.add('is-done');
		big.textContent = U.fmt(cps, 1) + ' CPS';
		small.textContent = count + ' clicks in ' + dur + ' s. ' + rank(cps) + '! Click to go again.';
		var best = pb(), msg = 'Done: ' + count + ' clicks in ' + dur + ' seconds = ' + U.fmt(cps, 1) + ' clicks per second (' + rank(cps) + ').';
		if (cps > best) {
			try { localStorage.setItem(key(), cps.toFixed(2)); } catch (e) { /* ignore */ }
			pb();
			if (best) { msg += ' New personal best!'; }
		}
		U.status(statusEl, msg, cps >= 6 ? 'ok' : '');
	}

	function begin(t) {
		running = true;
		start = t;
		count = 0;
		perSec = [];
		for (var i = 0; i < dur; i++) { perSec.push(0); }
		stage.classList.remove('is-done');
		stage.classList.add('is-running');
		big.textContent = '0';
		small.textContent = 'Keep clicking!';
		rankEl.textContent = '-';
		peakEl.textContent = '0.0';
		graph.innerHTML = '';
		U.status(statusEl, 'Go! Click as fast as you can.', '');
		raf = requestAnimationFrame(tick);
	}

	function press(t) {
		if (t - lastInput < 8) { return; } // ignore duplicate events for one press
		lastInput = t;
		if (!running) { begin(t); }
		count++;
		var sec = Math.min(dur - 1, Math.floor((t - start) / 1000));
		if (sec >= 0) { perSec[sec]++; }
		countEl.textContent = count;
		big.textContent = count;
		stage.classList.remove('is-hit');
		void stage.offsetWidth;
		stage.classList.add('is-hit');
	}

	stage.addEventListener('pointerdown', function (e) {
		if (e.pointerType === 'mouse' && e.button !== 0 && !(e.button === 2 && rightOk.checked)) { return; }
		e.preventDefault();
		press(e.timeStamp || performance.now());
	});
	stage.addEventListener('touchstart', function (e) { e.preventDefault(); press(e.timeStamp || performance.now()); }, { passive: false });
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
		graph.innerHTML = '';
		big.textContent = 'Click here to start';
		small.textContent = 'The timer starts on your first click.';
		U.status(statusEl, 'Pick a time, then click in the box as fast as you can.', '');
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
