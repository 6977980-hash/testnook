/* Stroop test: a congruent block then an incongruent block of colour words; answer the ink colour with buttons or R/G/B/Y keys; mean RT per block, accuracy and the Stroop effect. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="stroop-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#st-stage'), word = $('#st-word'), hint = $('#st-hint'), progress = $('#st-progress'), bar = $('#st-bar');
	var answers = U.$$('[data-st-c]', root), nSel = U.$$('[data-st-n]', root);
	var conEl = $('#st-con'), incEl = $('#st-inc'), effEl = $('#st-effect'), accEl = $('#st-acc'), statusEl = $('#st-status'), pbEl = $('#st-pb');
	var startBtn = $('#st-start'), resetBtn = $('#st-reset');

	var COLOURS = ['red', 'green', 'blue', 'yellow'];
	var KEYS = { r: 'red', g: 'green', b: 'blue', y: 'yellow', '1': 'red', '2': 'green', '3': 'blue', '4': 'yellow' };
	var KEY = 'tn-stroop-best';
	var perBlock = 20, block = 0, trial = 0, ink = '', shownAt = 0, state = 'idle', timer = 0;
	var res = { con: [], inc: [], wrong: 0, total: 0 };

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Smallest Stroop effect in this browser: ' + v + ' ms' : '';
		return v;
	}
	pb();

	function mean(a) { return a.length ? a.reduce(function (p, q) { return p + q; }, 0) / a.length : 0; }
	function pick(not) {
		var c = COLOURS[Math.floor(Math.random() * COLOURS.length)];
		return c === not ? pick(not) : c;
	}

	function setStage(s) { state = s; stage.className = 'tool-stage st-stage is-' + s; }
	function enable(on) { answers.forEach(function (b) { b.disabled = !on; }); }

	function label(n) { return n === 1 ? 'Block 1 of 2: the word and the colour match. Warm-up.' : 'Block 2 of 2: the word and the colour differ. Name the ink colour, not the word.'; }

	function show() {
		var incongruent = block === 2;
		ink = pick(null);
		var text = incongruent ? pick(ink) : ink;
		word.textContent = text.toUpperCase();
		word.setAttribute('data-ink', ink);
		word.setAttribute('data-trial', String((block - 1) * perBlock + trial + 1));
		word.lang = 'en';
		progress.textContent = 'Block ' + block + ' · ' + (trial + 1) + ' / ' + perBlock;
		bar.style.width = ((trial) / perBlock * 100) + '%';
		enable(true);
		requestAnimationFrame(function () { shownAt = performance.now(); });
	}

	function nextBlock(n) {
		block = n;
		trial = 0;
		setStage('ready');
		enable(false);
		word.textContent = n === 1 ? 'Ready?' : 'Block 2';
		word.removeAttribute('data-ink');
		hint.textContent = label(n);
		progress.textContent = 'Block ' + n + ' · starts in a moment';
		bar.style.width = '0%';
		U.status(statusEl, label(n), '');
		clearTimeout(timer);
		timer = setTimeout(function () { setStage('run'); hint.textContent = 'Which colour is the ink? Click a button or press R, G, B or Y.'; show(); }, 1600);
	}

	function finish() {
		setStage('done');
		enable(false);
		var con = mean(res.con), inc = mean(res.inc), eff = Math.round(inc - con);
		var acc = Math.round((res.total - res.wrong) / res.total * 100);
		conEl.textContent = Math.round(con) + ' ms';
		incEl.textContent = Math.round(inc) + ' ms';
		effEl.textContent = (eff >= 0 ? '+' : '') + eff + ' ms';
		accEl.textContent = acc + '%';
		word.textContent = (eff >= 0 ? '+' : '') + eff + ' ms';
		word.removeAttribute('data-ink');
		progress.textContent = 'Done';
		bar.style.width = '100%';
		var verdict;
		if (acc < 80) { verdict = 'Accuracy was low, so the timing means little: slow down a touch and try again.'; }
		else if (eff < 50) { verdict = 'A small Stroop effect: the words barely slowed you down.'; }
		else if (eff < 150) { verdict = 'A typical Stroop effect: the mismatched words cost you a little time, as they do for most people.'; }
		else if (eff < 300) { verdict = 'A large Stroop effect: reading the word got in the way of naming the colour.'; }
		else { verdict = 'A very large Stroop effect. Tiredness and distraction make it bigger; try again when fresh.'; }
		hint.textContent = verdict + ' Press Start for another round.';
		var best = pb(), msg = 'Stroop effect ' + eff + ' ms (congruent ' + Math.round(con) + ' ms, incongruent ' + Math.round(inc) + ' ms, accuracy ' + acc + '%).';
		if (acc >= 80 && (!best || eff < best)) {
			try { localStorage.setItem(KEY, String(eff)); } catch (e) { /* ignore */ }
			pb();
			if (best) { msg += ' New best!'; }
		}
		U.status(statusEl, msg, acc >= 80 && eff < 150 ? 'ok' : '');
		startBtn.textContent = 'Start again';
		startBtn.disabled = false;
	}

	function answer(c, t) {
		if (state !== 'run') { return; }
		var rt = t - shownAt;
		if (rt < 80) { return; } // key held from the previous trial
		enable(false);
		res.total++;
		var ok = c === ink;
		if (ok) { (block === 1 ? res.con : res.inc).push(rt); }
		else { res.wrong++; }
		stage.classList.remove('is-ok', 'is-bad');
		void stage.offsetWidth;
		stage.classList.add(ok ? 'is-ok' : 'is-bad');
		trial++;
		if (trial >= perBlock) {
			if (block === 1) { setTimeout(function () { nextBlock(2); }, 350); }
			else { setTimeout(finish, 350); }
			return;
		}
		setTimeout(show, ok ? 180 : 450);
	}

	function start() {
		res = { con: [], inc: [], wrong: 0, total: 0 };
		conEl.textContent = incEl.textContent = effEl.textContent = accEl.textContent = '-';
		startBtn.disabled = true;
		stage.focus({ preventScroll: true });
		nextBlock(1);
	}

	function reset() {
		clearTimeout(timer);
		setStage('idle');
		enable(false);
		block = 0; trial = 0;
		word.textContent = 'Stroop';
		word.removeAttribute('data-ink');
		hint.textContent = 'Press Start. First a warm-up block where the word and its colour match, then the real block where they differ.';
		progress.textContent = perBlock + ' words per block';
		bar.style.width = '0%';
		conEl.textContent = incEl.textContent = effEl.textContent = accEl.textContent = '-';
		startBtn.textContent = 'Start';
		startBtn.disabled = false;
		U.status(statusEl, 'Press Start, then answer the ink colour with the buttons or the R, G, B, Y keys.', '');
	}

	answers.forEach(function (b) {
		b.addEventListener('pointerdown', function (e) { if (e.button === 0 || e.pointerType !== 'mouse') { e.preventDefault(); answer(b.getAttribute('data-st-c'), e.timeStamp || performance.now()); } });
		b.addEventListener('click', function (e) { e.preventDefault(); });
	});
	root.addEventListener('keydown', function (e) {
		var c = KEYS[e.key.toLowerCase()];
		if (c && !e.repeat && state === 'run') { e.preventDefault(); answer(c, e.timeStamp || performance.now()); }
	});
	startBtn.addEventListener('click', start);
	resetBtn.addEventListener('click', reset);
	nSel.forEach(function (b) {
		b.addEventListener('click', function () {
			perBlock = Number(b.getAttribute('data-st-n'));
			nSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			reset();
		});
	});
	document.addEventListener('visibilitychange', function () { if (document.hidden && (state === 'run' || state === 'ready')) { reset(); U.status(statusEl, 'The round was stopped because the tab was hidden. Press Start to begin again.', ''); } });
	reset();
}());
