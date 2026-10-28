/* Visual memory test: a pattern of tiles lights up, then you click the tiles that were lit; the grid grows every level, three strikes in a level cost a life. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="visual-memory-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var board = $('#vm-board'), intro = $('#vm-intro'), levelEl = $('#vm-level'), livesEl = $('#vm-lives');
	var statusEl = $('#vm-status'), pbEl = $('#vm-pb'), startBtn = $('#vm-start');
	var KEY = 'tn-visual-memory-best';
	var level = 1, lives = 3, size = 3, lit = {}, found = 0, misses = 0, state = 'idle', timer = 0;

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best in this browser: level ' + v : '';
		return v;
	}
	function hearts() {
		livesEl.innerHTML = '';
		for (var i = 0; i < 3; i++) { livesEl.innerHTML += '<span' + (i < lives ? '' : ' class="is-lost"') + '>&#9679;</span>'; }
	}
	function gridFor(l) { return Math.min(10, 3 + Math.floor((l - 1) / 2)); }

	function round() {
		size = gridFor(level);
		var count = level + 2;
		board.innerHTML = '';
		board.style.gridTemplateColumns = 'repeat(' + size + ', 1fr)';
		board.classList.add('is-locked');
		lit = {}; found = 0; misses = 0;
		var spots = [];
		for (var i = 0; i < size * size; i++) { spots.push(i); }
		for (i = spots.length - 1; i > 0; i--) { var j = Math.floor(Math.random() * (i + 1)); var t = spots[i]; spots[i] = spots[j]; spots[j] = t; }
		for (i = 0; i < count; i++) { lit[spots[i]] = true; }
		for (i = 0; i < size * size; i++) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'mm-cell' + (lit[i] ? ' is-on' : '');
			b.setAttribute('data-i', String(i));
			b.setAttribute('aria-label', 'Tile ' + (i + 1));
			b.addEventListener('pointerdown', onPress);
			board.appendChild(b);
		}
		levelEl.textContent = String(level);
		state = 'show';
		U.status(statusEl, 'Level ' + level + ': remember the ' + count + ' highlighted tiles.', '');
		clearTimeout(timer);
		timer = setTimeout(function () {
			U.$$('.mm-cell', board).forEach(function (c) { c.classList.remove('is-on'); });
			board.classList.remove('is-locked');
			state = 'run';
			U.status(statusEl, 'Now click the tiles that were highlighted.', '');
		}, 1000 + count * 120);
	}

	function onPress(e) {
		if (state !== 'run') { return; }
		if (e.pointerType === 'mouse' && e.button !== 0) { return; }
		e.preventDefault();
		var b = e.currentTarget, i = b.getAttribute('data-i');
		if (b.classList.contains('is-ok') || b.classList.contains('is-bad')) { return; }
		if (lit[i]) {
			b.classList.add('is-ok');
			found++;
			if (found === level + 2) {
				state = 'wait';
				level++;
				U.status(statusEl, 'Level complete.', 'ok');
				timer = setTimeout(round, 600);
			}
		} else {
			b.classList.add('is-bad');
			misses++;
			if (misses >= 3) {
				state = 'wait';
				lives--;
				hearts();
				U.$$('.mm-cell', board).forEach(function (c) { if (lit[c.getAttribute('data-i')]) { c.classList.add('is-on'); } });
				if (lives <= 0) { return setTimeout(gameOver, 900); }
				U.status(statusEl, 'Three misses: you lose a life. ' + lives + ' left. Same level again.', 'bad');
				timer = setTimeout(round, 1300);
			}
		}
	}

	function gameOver() {
		state = 'idle';
		var score = level, msg, best = pb();
		if (score > best) { try { localStorage.setItem(KEY, String(score)); } catch (err) { /* ignore */ } pb(); }
		if (score < 6) { msg = 'Below the typical range. Try grouping the tiles into shapes.'; }
		else if (score < 10) { msg = 'Average. Most people end between level 6 and 9.'; }
		else if (score < 14) { msg = 'Above average visual memory.'; }
		else { msg = 'Excellent. Very few people get this far.'; }
		board.hidden = true;
		intro.hidden = false;
		intro.querySelector('h3').textContent = 'Level ' + score;
		intro.querySelector('p').textContent = msg;
		startBtn.textContent = 'Start again';
		U.status(statusEl, 'Game over at level ' + score + '. ' + msg, '');
	}

	startBtn.addEventListener('click', function () {
		level = 1; lives = 3;
		hearts();
		intro.hidden = true;
		board.hidden = false;
		round();
	});
	board.hidden = true;
	hearts();
	pb();
}());
