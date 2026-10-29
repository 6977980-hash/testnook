/* Reaction time test: random red wait, green go, earliest input event timed with performance.now(). */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="reaction-time-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#rt-stage'), big = $('#rt-big'), small = $('#rt-small');
	var lastEl = $('#rt-last'), avgEl = $('#rt-avg'), bestEl = $('#rt-best'), countEl = $('#rt-count');
	var log = $('#rt-log'), statusEl = $('#rt-status'), pbEl = $('#rt-pb');
	var nSel = U.$$('[data-rt-n]', root);

	var KEY = 'tn-rt-best';
	var limit = 5, times = [], state = 'idle', timer = 0, goAt = 0, lastInput = 0;

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best average in this browser: ' + U.fmt(v, 0) + ' ms' : '';
		return v;
	}
	pb();

	function setState(s, title, text) {
		state = s;
		stage.className = 'tool-stage rt-stage is-' + s;
		big.textContent = title;
		small.textContent = text;
	}

	function countText() { return times.length + (limit ? ' / ' + limit : ''); }

	function wait() {
		if (!times.length && limit === 5 && window.TNStats) { TNStats.begin('reaction'); }
		setState('wait', 'Wait for green...', 'Do not click yet.');
		clearTimeout(timer);
		timer = setTimeout(go, 1500 + Math.random() * 3500);
	}

	function go() {
		goAt = 0;
		setState('go', 'Click!', '');
		// Time from the frame the colour is actually painted, not from the timeout.
		requestAnimationFrame(function () { goAt = performance.now(); });
	}

	function rating(ms) {
		if (ms < 200) { return 'Excellent'; }
		if (ms < 250) { return 'Fast'; }
		if (ms < 300) { return 'Average'; }
		if (ms < 400) { return 'A bit slow'; }
		return 'Slow';
	}

	function finish() {
		var avg = times.reduce(function (a, b) { return a + b; }, 0) / times.length;
		var best = pb();
		var msg = 'Round done: average ' + U.fmt(avg, 0) + ' ms (' + rating(avg).toLowerCase() + ').';
		if (!best || avg < best) {
			try { localStorage.setItem(KEY, String(Math.round(avg))); } catch (e) { /* ignore */ }
			pb();
			msg += best ? ' New best average!' : '';
		}
		setState('done', U.fmt(avg, 0) + ' ms average', rating(avg) + '. Click to play again.');
		U.status(statusEl, msg, avg < 300 ? 'ok' : '');
		if (limit === 5 && window.TNStats) { TNStats.submit('reaction', Math.round(avg)); }
	}

	// Under 100 ms is faster than a human can see and respond: the click was a guess.
	var MIN_HUMAN = 100;

	function anticipated() {
		setState('soon', 'Too early (anticipated)', 'Under ' + MIN_HUMAN + ' ms is a guess, not a reaction. Click to try again.');
		U.status(statusEl, 'Clicks under ' + MIN_HUMAN + ' ms after green count as anticipated and are not recorded.', 'bad');
	}

	function record(t) {
		var ms = goAt ? t - goAt : 0;
		if (ms < MIN_HUMAN) { anticipated(); return; }
		times.push(ms);
		lastEl.textContent = U.fmt(ms, 0) + ' ms';
		var avg = times.reduce(function (a, b) { return a + b; }, 0) / times.length;
		avgEl.textContent = U.fmt(avg, 0) + ' ms';
		bestEl.textContent = U.fmt(Math.min.apply(null, times), 0) + ' ms';
		countEl.textContent = countText();
		var li = document.createElement('li');
		li.textContent = U.fmt(ms, 0) + ' ms';
		li.className = ms < 250 ? 'is-fast' : (ms > 400 ? 'is-slow' : '');
		log.appendChild(li);
		if (log.children.length > 20) { log.removeChild(log.firstChild); }

		if (limit && times.length >= limit) { finish(); return; }
		setState('result', U.fmt(ms, 0) + ' ms', rating(ms) + '. Click to try again.');
		U.status(statusEl, 'Try ' + times.length + ': ' + U.fmt(ms, 0) + ' ms. Average so far ' + U.fmt(avg, 0) + ' ms.', '');
	}

	function press(t) {
		if (t - lastInput < 60) { return; } // one event per press (touch + mouse)
		lastInput = t;
		if (state === 'idle' || state === 'result' || state === 'soon') { wait(); return; }
		if (state === 'done') { times = []; log.innerHTML = ''; countEl.textContent = countText(); wait(); return; }
		if (state === 'wait') {
			clearTimeout(timer);
			setState('soon', 'Too soon!', 'The box was not green yet. Click to try again.');
			U.status(statusEl, 'You clicked before the green. That try does not count.', 'bad');
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
		clearTimeout(timer);
		times = [];
		log.innerHTML = '';
		lastEl.textContent = avgEl.textContent = bestEl.textContent = '-';
		countEl.textContent = countText();
		setState('idle', 'Click to start', 'When the box turns red, wait. Click the moment it turns green.');
		U.status(statusEl, 'Click, tap or press Space in the box to begin. Clicks under ' + MIN_HUMAN + ' ms after green do not count.', '');
	}
	$('#rt-reset').addEventListener('click', reset);

	nSel.forEach(function (b) {
		b.addEventListener('click', function () {
			limit = Number(b.getAttribute('data-rt-n'));
			nSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
		});
	});

	document.addEventListener('visibilitychange', function () { if (document.hidden && state === 'wait') { clearTimeout(timer); setState('idle', 'Click to start', 'The round was paused. Click to continue.'); } });
}());
