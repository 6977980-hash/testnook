/* Sequence memory test: a 3x3 grid flashes a growing sequence of tiles; repeat it in order. One mistake ends the game. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="sequence-memory-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var board = $('#sm-board'), intro = $('#sm-intro'), levelEl = $('#sm-level'), statusEl = $('#sm-status'), pbEl = $('#sm-pb'), startBtn = $('#sm-start');
	var KEY = 'tn-sequence-memory-best';
	var cells = U.$$('.mm-cell', board), seq = [], pos = 0, state = 'idle', timers = [];

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best in this browser: level ' + v : '';
		return v;
	}
	function clearTimers() { timers.forEach(clearTimeout); timers = []; }
	function flash(i, dur, cls) {
		cells[i].classList.add(cls || 'is-on');
		timers.push(setTimeout(function () { cells[i].classList.remove(cls || 'is-on'); }, dur));
	}

	function play() {
		state = 'show';
		board.classList.add('is-locked');
		levelEl.textContent = String(seq.length);
		U.status(statusEl, 'Level ' + seq.length + ': watch the sequence.', '');
		var gap = Math.max(380, 700 - seq.length * 20);
		seq.forEach(function (i, k) {
			timers.push(setTimeout(function () { flash(i, gap * 0.6); }, 500 + k * gap));
		});
		timers.push(setTimeout(function () {
			state = 'run';
			pos = 0;
			board.classList.remove('is-locked');
			U.status(statusEl, 'Now repeat it: click the tiles in the same order.', '');
		}, 500 + seq.length * gap));
	}

	function next() {
		seq.push(Math.floor(Math.random() * 9));
		play();
	}

	function onPress(e) {
		if (state !== 'run') { return; }
		if (e.pointerType === 'mouse' && e.button !== 0) { return; }
		e.preventDefault();
		var i = cells.indexOf(e.currentTarget);
		if (i === seq[pos]) {
			flash(i, 220);
			pos++;
			if (pos === seq.length) {
				state = 'wait';
				board.classList.add('is-locked');
				var best = pb();
				if (seq.length > best) { try { localStorage.setItem(KEY, String(seq.length)); } catch (err) { /* ignore */ } pb(); }
				timers.push(setTimeout(next, 700));
			}
		} else {
			flash(i, 600, 'is-bad');
			flash(seq[pos], 600);
			state = 'idle';
			board.classList.add('is-locked');
			var score = seq.length - 1, msg;
			if (score < 6) { msg = 'Below the typical range. Say the positions in your head as they flash.'; }
			else if (score < 10) { msg = 'Average. Most people end between level 6 and 9.'; }
			else if (score < 15) { msg = 'Above average sequence memory.'; }
			else { msg = 'Excellent. Very few people get this far.'; }
			timers.push(setTimeout(function () {
				board.hidden = true;
				intro.hidden = false;
				intro.querySelector('h2').textContent = 'Level ' + score;
				intro.querySelector('p').textContent = msg;
				startBtn.textContent = 'Start again';
			}, 700));
			U.status(statusEl, 'Wrong tile at step ' + (pos + 1) + '. Game over at level ' + score + '. ' + msg, '');
			if (window.TNShare && score) { TNShare.show('I reached level ' + score + ' on the Testnook sequence memory test'); }
		}
	}

	cells.forEach(function (c) { c.addEventListener('pointerdown', onPress); });
	startBtn.addEventListener('click', function () {
		if (window.TNShare) { TNShare.hide(); }
		clearTimers();
		cells.forEach(function (c) { c.className = 'mm-cell'; });
		seq = [];
		intro.hidden = true;
		board.hidden = false;
		next();
	});
	board.hidden = true;
	pb();
}());
