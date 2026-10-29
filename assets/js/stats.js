/*
 * Anonymous result sharing (Phase 13a). Loaded only on tool pages with a
 * 'stats' list. A tool script calls TNStats.begin(board) when a test starts
 * (fetches a signed ticket) and TNStats.submit(board, value, extra, cv) when
 * it ends; the server answers with the percentile, shown under the tool as
 * "Faster than 64% of 18,240 tests this month". Nothing is sent in embed mode,
 * or after the visitor turns sharing off (localStorage 'tn-share-off').
 * Fires 'tn:begin' and 'tn:result' events on document for leaderboard.js.
 */
(function () {
	'use strict';
	var cfg = window.TN || {};
	var line = document.querySelector('[data-tn-share-line]');
	var note = document.querySelector('[data-tn-share-note]');
	var tickets = {};

	function off() {
		try { return localStorage.getItem('tn-share-off') === '1'; } catch (e) { return false; }
	}
	function enabled() { return !!cfg.rest && !cfg.embed && !off(); }

	function post(path, body) {
		return fetch(cfg.rest + path, {
			method: 'POST',
			credentials: 'omit',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(body)
		}).then(function (r) { return r.json().then(function (j) { return r.ok ? j : Promise.reject(j); }); });
	}

	function show(msg, type) {
		if (!line) { return; }
		line.textContent = msg;
		line.hidden = !msg;
		line.classList.toggle('is-ok', type === 'ok');
	}

	function paintNote() {
		if (!note) { return; }
		var isOff = off();
		note.querySelector('[data-tn-share-on]').hidden = isOff;
		note.querySelector('[data-tn-share-off]').hidden = !isOff;
	}
	if (note) {
		note.addEventListener('click', function (e) {
			var b = e.target.closest('[data-tn-share-set]');
			if (!b) { return; }
			try { localStorage.setItem('tn-share-off', b.getAttribute('data-tn-share-set') === 'off' ? '1' : '0'); } catch (err) { /* private mode */ }
			paintNote();
			show('');
		});
		paintNote();
	}

	/* "Copy result" line for CPS, reaction and typing results (shown even when sharing is off). */
	var copyBox = document.querySelector('[data-tn-copy-result]');
	function resultText(board, value, extra) {
		var where = location.host + location.pathname;
		var m = /^cps-(\d+)$/.exec(board);
		if (m) { return 'I got ' + Number(value).toFixed(1) + ' CPS on the ' + m[1] + ' second click test at ' + where; }
		if (board === 'reaction') { return 'My average reaction time is ' + Math.round(value) + ' ms over 5 tries at ' + where; }
		if (/^typing-/.test(board)) { return 'I type ' + Math.round(value) + ' WPM at ' + Math.round(extra) + '% accuracy, tested at ' + where; }
		return '';
	}
	function showCopy(board, value, extra) {
		if (!copyBox || cfg.embed) { return; }
		var text = resultText(board, value, extra);
		copyBox.querySelector('[data-tn-copy-text]').textContent = text;
		copyBox.hidden = !text;
	}
	if (copyBox) {
		copyBox.querySelector('button').addEventListener('click', function (e) {
			window.TNUtil.copyText(copyBox.querySelector('[data-tn-copy-text]').textContent, e.currentTarget);
		});
	}

	window.TNStats = {
		enabled: enabled,
		/** Fetch a ticket for a board when a test starts. Safe to call again: the newest ticket wins. */
		begin: function (board) {
			if (copyBox) { copyBox.hidden = true; }
			if (!enabled()) { tickets[board] = null; return; }
			show('');
			document.dispatchEvent(new CustomEvent('tn:begin', { detail: { board: board } }));
			tickets[board] = post('start', { board: board }).then(function (j) { return j.ticket; }).catch(function () { return null; });
		},
		/** Send the final score. Resolves with the server answer or null when nothing was sent. */
		submit: function (board, value, extra, cv) {
			var t = tickets[board];
			tickets[board] = null;
			showCopy(board, value, extra);
			if (!enabled() || !t) { return Promise.resolve(null); }
			return t.then(function (ticket) {
				if (!ticket) { return null; }
				return post('result', { board: board, ticket: ticket, value: value, extra: extra || 0, cv: typeof cv === 'number' ? cv : -1 });
			}).then(function (j) {
				if (!j) { return null; }
				if (!j.ok) { show(j.code === 'implausible' ? 'That score is outside the range we count for site stats.' : '', ''); return null; }
				var n = Number(j.count || 0).toLocaleString();
				if (j.status === 'suspect') {
					show('Your clicks were too evenly spaced to count as a hand, so this run was not added to the site stats.', '');
				} else if (j.percentile) {
					var better = board === 'reaction' ? 'Faster' : 'Better';
					show(better + ' than ' + j.percentile + '% of ' + n + ' tests on Testnook in the last 30 days.', 'ok');
				} else {
					show('Shared anonymously. Site averages appear once enough people have taken this test.', '');
				}
				j.board = board;
				j.value = value;
				j.extra = extra || 0;
				// leaderboard.js listens: a result with an id and claim can get a nickname.
				document.dispatchEvent(new CustomEvent('tn:result', { detail: j }));
				return j;
			}).catch(function () { return null; });
		}
	};
}());
