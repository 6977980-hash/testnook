/* Spacebar clicker: counts Space keydown (not repeats) in counter mode or for a timed test; taps on the key picture count on touch devices. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="spacebar-clicker"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#sb-stage'), countEl = $('#sb-count'), keyEl = $('#sb-key'), hint = $('#sb-hint');
	var timerBox = $('#sb-timer'), leftEl = $('#sb-left'), rateEl = $('#sb-rate'), totalEl = $('#sb-total');
	var minEl = $('#sb-min'), repEl = $('#sb-rep'), graph = $('#sb-graph'), statusEl = $('#sb-status'), pbEl = $('#sb-pb');
	var tSel = U.$$('[data-sb-t]', root);

	var dur = 0, count = 0, repeats = 0, minGap = Infinity, lastT = 0, start = 0, running = false, done = false, raf = 0, perSec = [];

	function key() { return 'tn-sb-best-' + dur; }
	function pb() {
		if (!dur) { pbEl.textContent = ''; return 0; }
		var v = 0;
		try { v = Number(localStorage.getItem(key())) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best for ' + dur + ' s in this browser: ' + U.fmt(v, 1) + ' per second' : '';
		return v;
	}

	function drawGraph() {
		graph.innerHTML = '';
		var max = Math.max.apply(null, perSec.concat([1]));
		perSec.forEach(function (n) {
			var b = document.createElement('span');
			b.style.height = Math.max(4, (n / max) * 100) + '%';
			b.title = n + ' presses';
			graph.appendChild(b);
		});
	}

	function tick() {
		var el = (performance.now() - start) / 1000;
		var left = Math.max(0, dur - el);
		leftEl.textContent = left.toFixed(1);
		rateEl.textContent = U.fmt(count / Math.max(el, 0.05), 1);
		if (left <= 0) { stop(); return; }
		raf = requestAnimationFrame(tick);
	}

	function stop() {
		running = false; done = true;
		cancelAnimationFrame(raf);
		var rate = count / dur;
		rateEl.textContent = U.fmt(rate, 1);
		leftEl.textContent = '0.0';
		hint.textContent = count + ' presses in ' + dur + ' s = ' + U.fmt(rate, 1) + ' per second. Press Reset to go again.';
		stage.classList.remove('is-running');
		stage.classList.add('is-done');
		drawGraph();
		var best = pb(), msg = 'Done: ' + count + ' presses in ' + dur + ' seconds, ' + U.fmt(rate, 1) + ' per second.';
		if (rate > best) {
			try { localStorage.setItem(key(), rate.toFixed(2)); } catch (e) { /* ignore */ }
			pb();
			if (best) { msg += ' New personal best!'; }
		}
		U.status(statusEl, msg, rate >= 8 ? 'ok' : '');
		if (window.TNShare && count) { TNShare.show('I pressed Space ' + U.fmt(rate, 1) + ' times a second on the Testnook ' + dur + ' second spacebar test'); }
	}

	function press(t) {
		if (done) { return; }
		if (dur && !running) {
			running = true; start = t; perSec = [];
			for (var i = 0; i < dur; i++) { perSec.push(0); }
			timerBox.hidden = false;
			stage.classList.add('is-running');
			hint.textContent = 'Keep going!';
			raf = requestAnimationFrame(tick);
		}
		count++;
		if (lastT) { minGap = Math.min(minGap, t - lastT); }
		lastT = t;
		if (dur) { var sec = Math.min(dur - 1, Math.floor((t - start) / 1000)); if (sec >= 0) { perSec[sec]++; } }
		else if (count === 1) { start = t; }
		countEl.textContent = count;
		totalEl.textContent = count;
		minEl.textContent = isFinite(minGap) ? U.fmt(minGap, 0) + ' ms' : '-';
		if (!dur) {
			var el = (t - start) / 1000;
			rateEl.textContent = el > 0.5 ? U.fmt((count - 1) / el, 1) : '0.0';
			if (count === 1) { hint.textContent = 'Counting every press. Press Reset to clear.'; }
			if (isFinite(minGap) && minGap < 25) { U.status(statusEl, 'A gap of ' + U.fmt(minGap, 0) + ' ms between two presses is faster than a thumb: the switch may be chattering.', 'bad'); }
			else { U.status(statusEl, count + ' press' + (count > 1 ? 'es' : '') + ' counted.', ''); }
		}
		keyEl.classList.add('is-down');
	}

	stage.addEventListener('keydown', function (e) {
		if (e.code !== 'Space' && e.key !== ' ') { return; }
		e.preventDefault();
		if (e.repeat) { repeats++; repEl.textContent = repeats; return; }
		press(e.timeStamp || performance.now());
	});
	stage.addEventListener('keyup', function (e) { if (e.code === 'Space' || e.key === ' ') { e.preventDefault(); keyEl.classList.remove('is-down'); } });
	stage.addEventListener('focus', function () { if (!count && !done) { hint.textContent = 'Ready. Press the spacebar.'; } });
	stage.addEventListener('blur', function () { if (!count && !done) { hint.textContent = 'Click here, then press the spacebar.'; } });

	// Touch devices: the key picture is a button.
	keyEl.addEventListener('pointerdown', function (e) {
		if (e.pointerType === 'mouse') { return; }
		e.preventDefault();
		press(e.timeStamp || performance.now());
	});
	keyEl.addEventListener('pointerup', function () { keyEl.classList.remove('is-down'); });
	keyEl.addEventListener('pointercancel', function () { keyEl.classList.remove('is-down'); });
	keyEl.addEventListener('touchstart', function (e) { e.preventDefault(); }, { passive: false });
	stage.addEventListener('mousedown', function () { stage.focus(); });

	function reset() {
		if (window.TNShare) { TNShare.hide(); }
		running = done = false;
		cancelAnimationFrame(raf);
		count = repeats = 0; minGap = Infinity; lastT = 0; perSec = [];
		countEl.textContent = totalEl.textContent = repEl.textContent = '0';
		rateEl.textContent = '0.0';
		minEl.textContent = '-';
		leftEl.textContent = dur.toFixed(1);
		timerBox.hidden = true;
		graph.innerHTML = '';
		stage.classList.remove('is-running', 'is-done');
		keyEl.classList.remove('is-down');
		hint.textContent = dur ? 'Click here, then press Space to start the ' + dur + ' second test.' : 'Click here, then press the spacebar.';
		U.status(statusEl, 'Click the box so it has focus, then press Space.', '');
		pb();
		stage.focus({ preventScroll: true });
	}
	$('#sb-reset').addEventListener('click', reset);
	tSel.forEach(function (b) {
		b.addEventListener('click', function () {
			dur = Number(b.getAttribute('data-sb-t'));
			tSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
		});
	});
	pb();
}());
