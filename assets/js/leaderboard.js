/*
 * Leaderboards (Phase 13b). Two jobs:
 * 1. Each [data-tn-lb] widget: board select + Today / This week / All time
 *    tabs. The all-time table is printed by PHP; other views are fetched
 *    from GET /board and cached per page load.
 * 2. On tool pages, the "Add my score to the leaderboard" form: stats.js
 *    fires 'tn:result' with the row id and claim after a score is stored;
 *    the nickname goes to POST /claim and the table is refreshed.
 */
(function () {
	'use strict';
	var cfg = window.TN || {};
	var cache = {};

	function fmt(v, meta) {
		return Number(v).toLocaleString(undefined, { minimumFractionDigits: meta.dp, maximumFractionDigits: meta.dp }) + (meta.unit ? ' ' + meta.unit : '');
	}
	function fmtDate(d) {
		var p = d.split('-');
		return new Date(Date.UTC(+p[0], +p[1] - 1, +p[2])).toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric', timeZone: 'UTC' });
	}
	function esc(s) {
		return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; });
	}

	function load(board, period, fresh) {
		var key = board + '|' + period;
		if (!fresh && cache[key]) { return cache[key]; }
		cache[key] = fetch(cfg.rest + 'board?board=' + encodeURIComponent(board) + '&period=' + period + (fresh ? '&_=' + Date.now() : ''), { credentials: 'omit', cache: fresh ? 'no-store' : 'default' })
			.then(function (r) { return r.ok ? r.json() : { rows: [] }; })
			.then(function (j) { return j.rows || []; })
			.catch(function () { return []; });
		return cache[key];
	}

	function Widget(el) {
		this.el = el;
		this.meta = JSON.parse(el.getAttribute('data-meta') || '{}');
		this.board = el.getAttribute('data-board');
		this.period = el.getAttribute('data-period') || 'all';
		this.rows = el.querySelector('[data-tn-lb-rows]');
		this.empty = el.querySelector('[data-tn-lb-empty]');
		this.extraTh = el.querySelector('[data-tn-lb-extra]');
		this.highlight = '';
		var self = this;
		var select = el.querySelector('[data-tn-lb-board]');
		if (select) {
			select.addEventListener('change', function () { self.board = select.value; self.refresh(); });
		}
		el.querySelectorAll('[data-tn-lb-period]').forEach(function (tab) {
			tab.addEventListener('click', function () {
				self.period = tab.getAttribute('data-tn-lb-period');
				el.querySelectorAll('[data-tn-lb-period]').forEach(function (t) { t.setAttribute('aria-selected', t === tab ? 'true' : 'false'); });
				self.refresh();
			});
		});
	}
	Widget.prototype.refresh = function (fresh) {
		var self = this, board = this.board, period = this.period;
		this.el.classList.add('is-loading');
		load(board, period, fresh).then(function (rows) {
			if (board !== self.board || period !== self.period) { return; }
			self.paint(rows);
		});
	};
	Widget.prototype.paint = function (rows) {
		var meta = this.meta[this.board] || { dp: 0, unit: '', extra: '' }, html = '', self = this;
		if (this.extraTh) { this.extraTh.hidden = !meta.extra; this.extraTh.textContent = meta.extra || 'Accuracy'; }
		rows.forEach(function (r) {
			var me = self.highlight && r.nick.toLowerCase() === self.highlight;
			html += '<tr' + (me ? ' class="is-me"' : '') + '><td class="lb__rank">' + r.rank + '</td><td class="lb__name">' + esc(r.nick) + '</td><td class="lb__score">' + esc(fmt(r.value, meta)) + '</td>'
				+ (meta.extra ? '<td class="lb__extra">' + r.extra + '%</td>' : '') + '<td class="lb__date">' + esc(fmtDate(r.date)) + '</td></tr>';
		});
		this.rows.innerHTML = html;
		if (this.empty) { this.empty.hidden = rows.length > 0; }
		this.el.classList.remove('is-loading');
	};
	Widget.prototype.show = function (board, period, nick) {
		var select = this.el.querySelector('[data-tn-lb-board]');
		if (select && this.meta[board]) { select.value = board; }
		if (this.meta[board]) { this.board = board; }
		this.period = period;
		this.highlight = (nick || '').toLowerCase();
		this.el.querySelectorAll('[data-tn-lb-period]').forEach(function (t) { t.setAttribute('aria-selected', t.getAttribute('data-tn-lb-period') === period ? 'true' : 'false'); });
		this.refresh(true);
	};

	var widgets = [];
	document.querySelectorAll('[data-tn-lb]').forEach(function (el) { widgets.push(new Widget(el)); });

	/* ---------- Claim form (tool pages) ---------- */
	var box = document.querySelector('[data-tn-lb-claim]');
	if (!box || !cfg.rest) { return; }
	var open = box.querySelector('[data-tn-lb-open]');
	var form = box.querySelector('[data-tn-lb-form]');
	var input = form.querySelector('input[name="nick"]');
	var msg = box.querySelector('[data-tn-lb-msg]');
	var pending = null;
	var MESSAGES = {
		nick_length: 'Nicknames are 3 to 16 characters long.',
		nick_chars: 'Use letters, digits, spaces, dashes or underscores only.',
		nick_link: 'Nicknames cannot contain links or domain names.',
		nick_blocked: 'That nickname is not allowed. Please pick another.',
		daily_limit: 'You have added 10 scores today. Come back tomorrow.',
		already_claimed: 'This score is already on the leaderboard.',
		expired: 'This score is too old to add. Run the test again.',
		bad_claim: 'This score cannot be added. Run the test again.'
	};

	function say(text, type) {
		msg.textContent = text;
		msg.hidden = !text;
		msg.classList.toggle('is-ok', type === 'ok');
		msg.classList.toggle('is-err', type === 'err');
	}
	function reset() {
		pending = null;
		box.hidden = true;
		form.hidden = true;
		open.hidden = false;
		say('');
	}
	function ordinal(n) {
		var s = ['th', 'st', 'nd', 'rd'], v = n % 100;
		return n + (s[(v - 20) % 10] || s[v] || s[0]);
	}

	document.addEventListener('tn:begin', reset);
	document.addEventListener('tn:result', function (e) {
		var j = e.detail;
		if (!j || !j.ok || !j.id || !j.claim) { return; }
		pending = j;
		box.hidden = false;
		open.hidden = false;
		form.hidden = true;
		say('');
	});
	open.addEventListener('click', function () {
		open.hidden = true;
		form.hidden = false;
		try { input.value = input.value || localStorage.getItem('tn-nick') || ''; } catch (err) { /* private mode */ }
		input.focus();
	});
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		if (!pending) { return; }
		var nick = input.value.replace(/\s+/g, ' ').trim();
		if (nick.length < 3 || nick.length > 16 || !/^[A-Za-z0-9 _-]+$/.test(nick)) {
			say(nick.length < 3 || nick.length > 16 ? MESSAGES.nick_length : MESSAGES.nick_chars, 'err');
			return;
		}
		var btn = form.querySelector('button[type="submit"]');
		btn.disabled = true;
		var claim = pending;
		fetch(cfg.rest + 'claim', {
			method: 'POST',
			credentials: 'omit',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ id: claim.id, claim: claim.claim, nick: nick })
		}).then(function (r) { return r.json().then(function (j) { return r.ok ? j : { ok: false, code: j.code || 'bad_claim' }; }); })
			.then(function (j) {
				btn.disabled = false;
				if (!j.ok) {
					say(MESSAGES[j.code] || 'Something went wrong. Please try again.', 'err');
					if (j.code === 'already_claimed' || j.code === 'expired' || j.code === 'bad_claim' || j.code === 'daily_limit') { pending = null; form.hidden = true; open.hidden = true; }
					return;
				}
				try { localStorage.setItem('tn-nick', nick); } catch (err) { /* private mode */ }
				pending = null;
				form.hidden = true;
				open.hidden = true;
				if (j.held) {
					say('Great score! It is held for a quick check and will appear on the leaderboard once approved.', 'ok');
					return;
				}
				var r = j.ranks || {}, parts = [];
				if (r.day) { parts.push(ordinal(r.day) + ' today'); }
				if (r.week) { parts.push(ordinal(r.week) + ' this week'); }
				if (r.all) { parts.push(ordinal(r.all) + ' of all time'); }
				say('Added as ' + nick + ': ' + parts.join(', ') + '.', 'ok');
				var period = r.day && r.day <= 10 ? 'day' : (r.week && r.week <= 10 ? 'week' : 'all');
				widgets.forEach(function (w) { if (w.meta[j.board]) { w.show(j.board, period, nick); } });
				var first = document.querySelector('[data-tn-lb]');
				if (first && r[period] <= 10) { first.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }
			})
			.catch(function () { btn.disabled = false; say('Could not reach the server. Please try again.', 'err'); });
	});
}());
