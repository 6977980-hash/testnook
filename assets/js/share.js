/*
 * Share your score (Phase 24). Loaded on tool pages with a 'stats' list or
 * 'share' => true, never in embeds. A tool script calls
 *   TNShare.show('I scored 9.2 CPS on the Testnook 5 second click test', board)
 * when a run ends and TNShare.hide() when a new run starts. stats.js calls
 * TNShare.percentile(board, 78, 'better') once the server answers, which adds
 * ", better than 78% of players" to the line.
 * Plain share links only (WhatsApp, X, Facebook, Reddit), the phone's own share
 * sheet where navigator.share exists, and Copy. No third-party scripts.
 */
(function () {
	'use strict';
	var box = document.querySelector('[data-tn-share]');
	if (!box || (window.TN || {}).embed) { return; }
	var textEl = box.querySelector('[data-tn-share-text]');
	var nativeBtn = box.querySelector('[data-tn-share-native]');
	var state = { claim: '', board: '', pct: 0, word: 'better' };
	var page = location.origin + location.pathname;

	function link(source) {
		return source ? page + '?utm_source=' + source + '&utm_medium=social&utm_campaign=score_share' : page;
	}
	function sentence() {
		return state.claim + (state.pct ? ', ' + state.word + ' than ' + state.pct + '% of recent scores' : '') + '. Can you beat me?';
	}
	function intent(net) {
		var s = sentence(), u;
		if (net === 'whatsapp') { return 'https://wa.me/?text=' + encodeURIComponent(s + ' ' + link('whatsapp')); }
		u = encodeURIComponent(link(net));
		if (net === 'x') { return 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(s) + '&url=' + u; }
		if (net === 'facebook') { return 'https://www.facebook.com/sharer/sharer.php?u=' + u; }
		return 'https://www.reddit.com/submit?url=' + u + '&title=' + encodeURIComponent(s);
	}
	function paint() {
		textEl.textContent = sentence() + ' ' + link('');
		box.querySelectorAll('[data-tn-share-to]').forEach(function (a) { a.href = intent(a.getAttribute('data-tn-share-to')); });
	}
	function track(method) {
		if (window.gtag) { window.gtag('event', 'share', { method: method, content_type: 'score', item_id: state.board || (window.TN || {}).slug || '' }); }
	}

	if (nativeBtn && navigator.share) {
		nativeBtn.hidden = false;
		nativeBtn.addEventListener('click', function () {
			navigator.share({ title: document.title, text: sentence(), url: link('share_sheet') }).then(function () { track('share_sheet'); }, function () { /* closed */ });
		});
	}
	box.querySelector('[data-tn-share-copy]').addEventListener('click', function (e) {
		window.TNUtil.copyText(textEl.textContent, e.currentTarget);
		track('copy');
	});
	box.addEventListener('click', function (e) {
		var a = e.target.closest('[data-tn-share-to]');
		if (a) { track(a.getAttribute('data-tn-share-to')); }
	});

	window.TNShare = {
		show: function (claim, board) {
			if (!claim) { return; }
			state = { claim: claim, board: board || '', pct: 0, word: 'better' };
			paint();
			box.hidden = false;
		},
		percentile: function (board, pct, word) {
			if (box.hidden || board !== state.board || !(pct > 0)) { return; }
			state.pct = Math.round(pct);
			state.word = word || 'better';
			paint();
		},
		hide: function () { box.hidden = true; }
	};
}());
