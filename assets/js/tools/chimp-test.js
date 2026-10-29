/* Chimp test: numbers 1..n appear on an 8x5 grid; after the first click they hide and you tap them in order. One more number each level, three strikes. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="chimp-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var board = $('#cm-board'), intro = $('#cm-intro'), levelEl = $('#cm-level'), livesEl = $('#cm-lives');
	var bestEl = $('#cm-best'), statusEl = $('#cm-status'), pbEl = $('#cm-pb'), startBtn = $('#cm-start');
	var KEY = 'tn-chimp-best', COLS = 8, ROWS = 5;
	var n = 4, lives = 3, next = 1, cells = [], state = 'idle';

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best in this browser: ' + v + ' numbers' : '';
		return v;
	}
	function hearts() {
		livesEl.innerHTML = '';
		for (var i = 0; i < 3; i++) { livesEl.innerHTML += '<span' + (i < lives ? '' : ' class="is-lost"') + '>&#9679;</span>'; }
	}

	function layout() {
		board.innerHTML = '';
		board.classList.remove('is-hidden');
		cells = [];
		var spots = [];
		for (var i = 0; i < COLS * ROWS; i++) { spots.push(i); }
		for (i = spots.length - 1; i > 0; i--) { var j = Math.floor(Math.random() * (i + 1)); var t = spots[i]; spots[i] = spots[j]; spots[j] = t; }
		var used = {};
		for (i = 0; i < n; i++) { used[spots[i]] = i + 1; }
		for (i = 0; i < COLS * ROWS; i++) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'mm-cell' + (used[i] ? ' has-n' : '');
			if (used[i]) {
				b.textContent = String(used[i]);
				b.setAttribute('data-n', String(used[i]));
				b.setAttribute('aria-label', 'Number ' + used[i]);
				b.addEventListener('pointerdown', onPress);
			} else {
				b.tabIndex = -1;
				b.setAttribute('aria-hidden', 'true');
			}
			board.appendChild(b);
			cells.push(b);
		}
		next = 1;
		state = 'show';
		levelEl.textContent = String(n);
		U.status(statusEl, 'Click 1, then the rest in order from memory.', '');
	}

	function onPress(e) {
		if (state !== 'show' && state !== 'run') { return; }
		if (e.pointerType === 'mouse' && e.button !== 0) { return; }
		e.preventDefault();
		var b = e.currentTarget, v = Number(b.getAttribute('data-n'));
		if (v !== next) {
			b.classList.add('is-bad');
			board.classList.remove('is-hidden');
			state = 'wait';
			lives--;
			hearts();
			if (lives <= 0) { return gameOver(); }
			U.status(statusEl, 'Wrong: that was ' + v + ', not ' + next + '. ' + lives + (lives === 1 ? ' strike' : ' strikes') + ' left. Next round in a moment.', 'bad');
			setTimeout(layout, 1300);
			return;
		}
		b.classList.add('is-ok');
		if (v === 1 && n > 1) { board.classList.add('is-hidden'); state = 'run'; }
		next++;
		if (next > n) {
			state = 'wait';
			n++;
			U.status(statusEl, 'Correct. Next round: ' + n + ' numbers.', 'ok');
			setTimeout(layout, 700);
		}
	}

	function gameOver() {
		state = 'idle';
		var score = n, best = pb();
		bestEl.textContent = String(score);
		if (score > best) { try { localStorage.setItem(KEY, String(score)); } catch (err) { /* ignore */ } pb(); }
		var msg = 'Game over at ' + score + ' numbers. ';
		if (score < 7) { msg += 'Below the usual range; most people reach 8 or 9.'; }
		else if (score < 10) { msg += 'Average working memory span.'; }
		else if (score < 14) { msg += 'Above average.'; }
		else { msg += 'Chimp level. Ayumu the chimpanzee manages 9 digits in under a second, so you are in good company.'; }
		U.status(statusEl, msg + ' Press Start to play again.', '');
		startBtn.textContent = 'Start again';
		board.hidden = true;
		intro.hidden = false;
		intro.querySelector('h2').textContent = 'Score: ' + score;
		intro.querySelector('p').textContent = msg;
	}

	function start() {
		n = 4; lives = 3;
		hearts();
		bestEl.textContent = '-';
		intro.hidden = true;
		board.hidden = false;
		layout();
	}

	startBtn.addEventListener('click', start);
	board.hidden = true;
	hearts();
	pb();
}());
