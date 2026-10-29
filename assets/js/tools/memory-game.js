/* Memory game: a grid of face-down cards in pairs; flip two, keep the matches; moves, time and best per size. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="memory-game"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var stage = $('#mg-stage'), board = $('#mg-board'), intro = $('#mg-intro');
	var movesEl = $('#mg-moves'), timeEl = $('#mg-time'), pairsEl = $('#mg-pairs'), accEl = $('#mg-acc');
	var statusEl = $('#mg-status'), pbEl = $('#mg-pb'), startBtn = $('#mg-start'), sizeSel = U.$$('[data-mg-size]', root), setSel = U.$$('[data-mg-set]', root);

	var SETS = {
		emoji: ['🍎', '🍌', '🍇', '🍓', '🍒', '🍋', '🥝', '🍉', '🥑', '🥕', '🌽', '🍄', '🐶', '🐱', '🐭', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐵', '🐔', '🐧', '🐦', '🦄', '🐝', '🦋', '⚽', '🏀', '🎸', '🚗'],
		numbers: null,
		letters: null
	};
	var cols = 4, rows = 4, set = 'emoji';
	var first = null, lock = false, moves = 0, matched = 0, hits = 0, total = 0, t0 = 0, timer = 0, running = false;

	function key() { return 'tn-memory-game-' + cols + 'x' + rows; }
	function pb() {
		var v = null;
		try { v = JSON.parse(localStorage.getItem(key()) || 'null'); } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best for ' + cols + 'x' + rows + ' in this browser: ' + v.moves + ' moves in ' + fmtTime(v.ms) : '';
		return v;
	}
	function fmtTime(ms) {
		var s = Math.round(ms / 1000);
		return s >= 60 ? Math.floor(s / 60) + ':' + ('0' + (s % 60)).slice(-2) : s + ' s';
	}
	function shuffle(a) {
		for (var i = a.length - 1; i > 0; i--) { var j = Math.floor(Math.random() * (i + 1)); var t = a[i]; a[i] = a[j]; a[j] = t; }
		return a;
	}
	function faces(n) {
		if (set === 'numbers') { return Array.apply(null, Array(n)).map(function (x, i) { return String(i + 1); }); }
		if (set === 'letters') { return 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('').slice(0, n); }
		return shuffle(SETS.emoji.slice()).slice(0, n);
	}

	function tick() {
		timeEl.textContent = fmtTime(performance.now() - t0);
		timer = setTimeout(tick, 500);
	}

	function build() {
		clearTimeout(timer);
		if (window.TNShare) { TNShare.hide(); }
		board.innerHTML = '';
		board.style.gridTemplateColumns = 'repeat(' + cols + ', 1fr)';
		board.style.maxWidth = (cols * 90) + 'px';
		var pairs = cols * rows / 2, f = faces(pairs), deck = shuffle(f.concat(f));
		deck.forEach(function (face, i) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'mg-card';
			b.setAttribute('data-face', face);
			b.setAttribute('aria-label', 'Card ' + (i + 1));
			b.innerHTML = '<span class="mg-inner"><span class="mg-back"></span><span class="mg-front">' + face + '</span></span>';
			b.addEventListener('click', function () { flip(b); });
			board.appendChild(b);
		});
		first = null; lock = false; moves = 0; matched = 0; hits = 0; total = 0; running = false;
		movesEl.textContent = '0'; timeEl.textContent = '0 s'; accEl.textContent = '-';
		pairsEl.textContent = '0 / ' + pairs;
		intro.hidden = true;
		board.hidden = false;
		stage.classList.add('is-run');
		startBtn.textContent = 'New game';
		U.status(statusEl, 'Flip two cards at a time and find all ' + pairs + ' pairs. The timer starts on your first flip.', '');
		pb();
	}

	function flip(card) {
		if (lock || card.classList.contains('is-up') || card.classList.contains('is-done')) { return; }
		if (!running) { running = true; t0 = performance.now(); tick(); }
		card.classList.add('is-up');
		card.setAttribute('aria-label', card.getAttribute('data-face'));
		if (!first) { first = card; return; }
		moves++;
		movesEl.textContent = String(moves);
		var a = first, b = card;
		first = null;
		if (a.getAttribute('data-face') === b.getAttribute('data-face')) {
			matched++; hits++;
			a.classList.add('is-done'); b.classList.add('is-done');
			pairsEl.textContent = matched + ' / ' + (cols * rows / 2);
			if (matched === cols * rows / 2) { finish(); }
		} else {
			lock = true;
			setTimeout(function () {
				a.classList.remove('is-up'); b.classList.remove('is-up');
				a.setAttribute('aria-label', 'Card'); b.setAttribute('aria-label', 'Card');
				lock = false;
			}, 750);
		}
		accEl.textContent = Math.round(hits / moves * 100) + '%';
	}

	function finish() {
		clearTimeout(timer);
		running = false;
		var ms = performance.now() - t0, pairs = cols * rows / 2, best = pb();
		timeEl.textContent = fmtTime(ms);
		var msg = 'Done: ' + pairs + ' pairs in ' + moves + ' moves and ' + fmtTime(ms) + '. ';
		var perfect = pairs; // minimum possible moves
		if (moves <= perfect + 2) { msg += 'Nearly perfect recall.'; }
		else if (moves <= perfect * 1.6) { msg += 'Good memory: few repeated flips.'; }
		else if (moves <= perfect * 2.4) { msg += 'Average. You forgot a few positions along the way.'; }
		else { msg += 'Lots of re-flips. Try naming each card\'s position in your head as you reveal it.'; }
		if (!best || moves < best.moves || (moves === best.moves && ms < best.ms)) {
			try { localStorage.setItem(key(), JSON.stringify({ moves: moves, ms: Math.round(ms) })); } catch (e) { /* ignore */ }
			if (best) { msg += ' New best!'; }
			pb();
		}
		U.status(statusEl, msg, 'ok');
		stage.classList.remove('is-run');
		if (window.TNShare) { TNShare.show('I found all ' + pairs + ' pairs in ' + moves + ' moves and ' + fmtTime(ms) + ' on the Testnook memory game'); }
	}

	startBtn.addEventListener('click', build);
	sizeSel.forEach(function (b) {
		b.addEventListener('click', function () {
			var p = b.getAttribute('data-mg-size').split('x');
			cols = Number(p[0]); rows = Number(p[1]);
			sizeSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			pb();
			if (!board.hidden) { build(); }
		});
	});
	setSel.forEach(function (b) {
		b.addEventListener('click', function () {
			set = b.getAttribute('data-mg-set');
			setSel.forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
			if (!board.hidden) { build(); }
		});
	});
	board.hidden = true;
	pb();
}());
