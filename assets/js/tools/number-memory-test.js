/* Number memory test: a number is shown for a few seconds, then typed back; one more digit each level until the first mistake. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="number-memory-test"]');
	if (!root) { return; }
	var U = window.TNUtil;
	var $ = function (s) { return root.querySelector(s); };

	var intro = $('#nm-intro'), show = $('#nm-show'), numEl = $('#nm-number'), bar = $('#nm-bar'), form = $('#nm-form'), input = $('#nm-input');
	var result = $('#nm-result'), levelEl = $('#nm-level'), statusEl = $('#nm-status'), pbEl = $('#nm-pb'), startBtn = $('#nm-start');
	var KEY = 'tn-number-memory-best';
	var level = 1, number = '', timer = 0, raf = 0, state = 'idle';

	function pb() {
		var v = 0;
		try { v = Number(localStorage.getItem(KEY)) || 0; } catch (e) { /* private mode */ }
		pbEl.textContent = v ? 'Best in this browser: ' + v + ' digits' : '';
		return v;
	}
	function gen(len) {
		var s = String(1 + Math.floor(Math.random() * 9));
		while (s.length < len) { s += String(Math.floor(Math.random() * 10)); }
		return s;
	}
	function view(which) {
		intro.hidden = which !== 'intro';
		show.hidden = which !== 'show';
		form.hidden = which !== 'form';
		result.hidden = which !== 'result';
	}

	function round() {
		number = gen(level);
		numEl.textContent = number;
		levelEl.textContent = String(level);
		view('show');
		state = 'show';
		var ms = Math.max(2000, 1000 + level * 1000), t0 = performance.now();
		U.status(statusEl, 'Level ' + level + ': memorise the number. It disappears in ' + (ms / 1000) + ' s.', '');
		cancelAnimationFrame(raf);
		(function step() {
			var p = Math.max(0, 1 - (performance.now() - t0) / ms);
			bar.style.width = (p * 100) + '%';
			if (p > 0) { raf = requestAnimationFrame(step); }
		}());
		clearTimeout(timer);
		timer = setTimeout(ask, ms);
	}

	function ask() {
		state = 'ask';
		view('form');
		input.value = '';
		input.focus({ preventScroll: true });
		U.status(statusEl, 'What was the number?', '');
	}

	function diffHtml(want, got) {
		var out = '';
		for (var i = 0; i < Math.max(want.length, got.length); i++) {
			var w = want[i] || '', g = got[i] || '_';
			out += w === g ? g : '<span class="is-bad">' + g + '</span>';
		}
		return out;
	}

	function check() {
		if (state !== 'ask') { return; }
		var got = input.value.replace(/\D/g, '');
		if (!got) { return; }
		state = 'result';
		view('result');
		var ok = got === number, best = pb();
		$('#nm-want').textContent = number;
		$('#nm-got').innerHTML = diffHtml(number, got);
		if (ok) {
			$('#nm-verdict').textContent = 'Correct';
			level++;
			if (level - 1 > best) { try { localStorage.setItem(KEY, String(level - 1)); } catch (e) { /* ignore */ } pb(); }
			$('#nm-next').textContent = 'Next: ' + level + ' digits';
			U.status(statusEl, 'Correct. Next level has ' + level + ' digits.', 'ok');
		} else {
			var score = level - 1, msg;
			if (score < 6) { msg = 'Below the typical span; most adults manage 7.'; }
			else if (score < 9) { msg = 'An average span of around 7 digits, as the research says.'; }
			else if (score < 12) { msg = 'Above average. Chunking the digits is working.'; }
			else { msg = 'Exceptional. Memory athletes land here.'; }
			$('#nm-verdict').textContent = 'Wrong. Your number memory score: ' + score + ' digits';
			$('#nm-next').textContent = 'Try again';
			U.status(statusEl, 'Score: ' + score + ' digits. ' + msg, '');
			level = 1;
		}
	}

	startBtn.addEventListener('click', function () { level = 1; round(); });
	$('#nm-next').addEventListener('click', round);
	$('#nm-submit').addEventListener('click', check);
	input.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); check(); } });
	input.addEventListener('input', function () { input.value = input.value.replace(/\D/g, ''); });
	view('intro');
	pb();
}());
