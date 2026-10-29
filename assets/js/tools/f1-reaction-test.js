/* F1 reaction test: five pairs of red lights come on one per second, go out after a random hold, earliest input event timed with performance.now(). */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="f1-reaction-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#f1-stage'), big = $('#f1-big'), small = $('#f1-small'), lights = U.$$('.f1-col', root);
	var lastEl = $('#f1-last'), avgEl = $('#f1-avg'), bestEl = $('#f1-best'), countEl = $('#f1-count');
	var log = $('#f1-log'), statusEl = $('#f1-status'), pbEl = $('#f1-pb');
	var nSel = U.$$('[data-f1-n]', root);

	var KEY = 'tn-f1-best';
	var limit = 5, times = [], state = 'idle', timers = [], goAt = 0, lastInput = 0, lit = 0;

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best average in this browser: ' + (v / 1000).toFixed(3) + ' s' : '';
		return v;
	}
	pb();

	function fmt(ms) { return (ms / 1000).toFixed(3) + ' s'; }
	function clearTimers() { timers.forEach(clearTimeout); timers = []; }
	function setLights(n) {
		lit = n;
		lights.forEach(function (col, i) { col.classList.toggle('is-on', i < n); });
	}

	function setState(s, title, text) {
		state = s;
		stage.className = 'tool-stage f1-stage is-' + s;
		big.textContent = title;
		small.textContent = text;
	}

	function countText() { return times.length + (limit ? ' / ' + limit : ''); }

	function sequence() {
		setLights(0);
		setState('wait', '', 'Wait for all five lights to go out.');
		clearTimers();
		for (var i = 1; i <= 5; i++) {
			(function (n) { timers.push(setTimeout(function () { setLights(n); }, n * 1000)); }(i));
		}
		// Real F1 starts hold the lights between 0.2 and 3 seconds after the fifth pair.
		timers.push(setTimeout(go, 5000 + 200 + Math.random() * 2800));
	}

	function go() {
		setLights(0);
		setState('go', 'Go!', '');
		requestAnimationFrame(function () { goAt = performance.now(); });
	}

	function rating(ms) {
		if (ms < 150) { return 'Superhuman (or a lucky guess)'; }
		if (ms < 200) { return 'F1 driver pace'; }
		if (ms < 250) { return 'Fast'; }
		if (ms < 300) { return 'Average'; }
		if (ms < 400) { return 'A bit slow'; }
		return 'Slow';
	}

	function finish() {
		var avg = times.reduce(function (a, b) { return a + b; }, 0) / times.length;
		var best = pb();
		var msg = 'Round done: average ' + fmt(avg) + ' (' + rating(avg).toLowerCase() + ').';
		if (!best || avg < best) {
			try { localStorage.setItem(KEY, String(Math.round(avg))); } catch (e) { /* ignore */ }
			pb();
			msg += best ? ' New best average!' : '';
		}
		setState('done', fmt(avg) + ' average', rating(avg) + '. Click to race again.');
		U.status(statusEl, msg, avg < 300 ? 'ok' : '');
		if (window.TNShare) { TNShare.show('My F1 reaction time is ' + Math.round(avg) + ' ms (average of ' + times.length + ' starts) on Testnook'); }
	}

	function record(t) {
		var ms = t - goAt;
		times.push(ms);
		lastEl.textContent = fmt(ms);
		var avg = times.reduce(function (a, b) { return a + b; }, 0) / times.length;
		avgEl.textContent = fmt(avg);
		bestEl.textContent = fmt(Math.min.apply(null, times));
		countEl.textContent = countText();
		var li = document.createElement('li');
		li.textContent = fmt(ms);
		li.className = ms < 250 ? 'is-fast' : (ms > 400 ? 'is-slow' : '');
		log.appendChild(li);
		if (log.children.length > 20) { log.removeChild(log.firstChild); }

		if (limit && times.length >= limit) { finish(); return; }
		setState('result', fmt(ms), rating(ms) + '. Click for the next start.');
		U.status(statusEl, 'Start ' + times.length + ': ' + fmt(ms) + '. Average so far ' + fmt(avg) + '.', '');
	}

	function press(t) {
		if (t - lastInput < 60) { return; }
		lastInput = t;
		if (state === 'idle' || state === 'result' || state === 'jump') { sequence(); return; }
		if (state === 'done') { if (window.TNShare) { TNShare.hide(); } times = []; log.innerHTML = ''; countEl.textContent = countText(); sequence(); return; }
		if (state === 'wait') {
			clearTimers();
			setState('jump', 'Jump start!', 'You went before the lights went out. Click to line up again.');
			U.status(statusEl, 'Jump start: you reacted with ' + lit + ' of 5 lights on. That start does not count.', 'bad');
			return;
		}
		if (state === 'go') { record(t); }
	}

	stage.addEventListener('pointerdown', function (e) { if (e.button === 0 || e.pointerType !== 'mouse') { e.preventDefault(); stage.focus({ preventScroll: true }); press(e.timeStamp || performance.now()); } });
	stage.addEventListener('touchstart', function (e) { e.preventDefault(); press(e.timeStamp || performance.now()); }, { passive: false });
	stage.addEventListener('keydown', function (e) {
		if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); if (!e.repeat) { press(e.timeStamp || performance.now()); } }
	});
	stage.addEventListener('contextmenu', function (e) { e.preventDefault(); });

	function reset() {
		clearTimers();
		if (window.TNShare) { TNShare.hide(); }
		times = [];
		log.innerHTML = '';
		setLights(0);
		lastEl.textContent = avgEl.textContent = bestEl.textContent = '-';
		countEl.textContent = countText();
		setState('idle', 'Click to start', 'Five red lights come on one by one. React the instant they all go out.');
		U.status(statusEl, 'Click, tap or press Space to line up on the grid.', '');
	}
	$('#f1-reset').addEventListener('click', reset);

	nSel.forEach(function (b) {
		b.addEventListener('click', function () {
			limit = Number(b.getAttribute('data-f1-n'));
			nSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
		});
	});

	document.addEventListener('visibilitychange', function () { if (document.hidden && state === 'wait') { clearTimers(); setLights(0); setState('idle', 'Click to start', 'The start was aborted. Click to line up again.'); } });
}());
