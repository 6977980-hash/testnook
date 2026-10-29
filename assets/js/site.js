/*
 * Testnook shared script: theme toggle, mobile nav, homepage search,
 * fullscreen helper, device notes, copy buttons, lazy ads and analytics.
 * Tool scripts can use the helpers on window.TNUtil.
 */
(function () {
	'use strict';

	var doc = document;
	var root = doc.documentElement;
	var cfg = window.TN || {};

	function $(sel, ctx) { return (ctx || doc).querySelector(sel); }
	function $$(sel, ctx) { return Array.prototype.slice.call((ctx || doc).querySelectorAll(sel)); }

	/* ---------- Fullscreen (with a CSS fallback for iPhone) ---------- */
	function fsElement() { return doc.fullscreenElement || doc.webkitFullscreenElement || $('.is-pseudo-fs'); }

	function enterFullscreen(el) {
		var req = el.requestFullscreen || el.webkitRequestFullscreen;
		if (req) {
			try {
				var p = req.call(el);
				if (p && p.catch) { p.catch(function () { pseudo(el, true); }); }
				return;
			} catch (e) { /* fall through */ }
		}
		pseudo(el, true);
	}

	function exitFullscreen() {
		var pseudoEl = $('.is-pseudo-fs');
		if (pseudoEl) { pseudo(pseudoEl, false); return; }
		var exit = doc.exitFullscreen || doc.webkitExitFullscreen;
		if (exit && (doc.fullscreenElement || doc.webkitFullscreenElement)) { exit.call(doc); }
	}

	function pseudo(el, on) {
		el.classList.toggle('is-pseudo-fs', on);
		doc.body.classList.toggle('has-pseudo-fs', on);
		el.dispatchEvent(new CustomEvent('tn:fullscreen', { detail: { on: on } }));
	}

	function toggleFullscreen(el) { if (fsElement()) { exitFullscreen(); } else { enterFullscreen(el); } }

	doc.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && $('.is-pseudo-fs')) { exitFullscreen(); }
	});
	['fullscreenchange', 'webkitfullscreenchange'].forEach(function (ev) {
		doc.addEventListener(ev, function () {
			var el = doc.fullscreenElement || doc.webkitFullscreenElement;
			doc.body.classList.toggle('is-fullscreen', !!el);
		});
	});

	/* ---------- Small helpers for tool scripts ---------- */
	window.TNUtil = {
		$: $,
		$$: $$,
		enterFullscreen: enterFullscreen,
		exitFullscreen: exitFullscreen,
		toggleFullscreen: toggleFullscreen,
		isFullscreen: function () { return !!fsElement(); },
		isTouch: function () { return navigator.maxTouchPoints > 0 || 'ontouchstart' in window; },
		hasFinePointer: function () { return matchMedia('(any-pointer: fine)').matches; },
		/** Set a status line: type is '', 'ok' or 'bad'. */
		status: function (el, msg, type) {
			if (!el) { return; }
			el.textContent = msg;
			el.classList.toggle('is-ok', type === 'ok');
			el.classList.toggle('is-bad', type === 'bad');
		},
		/** Friendly text for getUserMedia errors. */
		mediaError: function (err, what) {
			var name = err && err.name;
			if (name === 'NotAllowedError' || name === 'SecurityError') { return 'Permission was blocked. Click the camera/lock icon in the address bar, allow ' + what + ', then try again.'; }
			if (name === 'NotFoundError' || name === 'OverconstrainedError') { return 'No ' + what + ' was found. Check it is plugged in and enabled.'; }
			if (name === 'NotReadableError') { return 'Your ' + what + ' is busy. Close other apps that use it (Zoom, Teams, OBS) and try again.'; }
			if (!window.isSecureContext) { return 'This page must be opened over HTTPS to use your ' + what + '.'; }
			return 'Could not start your ' + what + (name ? ' (' + name + ')' : '') + '.';
		},
		fmt: function (n, d) { return Number(n).toFixed(d || 0); },
		/** Copy text to the clipboard; the button reads "Copied" for a moment. */
		copyText: function (text, btn) {
			var label = btn ? btn.textContent : '';
			var done = function () {
				if (!btn) { return; }
				btn.textContent = 'Copied';
				setTimeout(function () { btn.textContent = label; }, 1600);
			};
			if (navigator.clipboard && window.isSecureContext) {
				navigator.clipboard.writeText(text).then(done, function () { if (btn) { btn.textContent = 'Copy blocked'; setTimeout(function () { btn.textContent = label; }, 1600); } });
				return;
			}
			var ta = doc.createElement('textarea');
			ta.value = text;
			ta.setAttribute('readonly', '');
			ta.style.position = 'fixed';
			ta.style.opacity = '0';
			doc.body.appendChild(ta);
			ta.select();
			try { doc.execCommand('copy'); } catch (e) { /* ignore */ }
			doc.body.removeChild(ta);
			done();
		}
	};

	/* ---------- Theme toggle ---------- */
	$$('.theme-toggle').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
			root.setAttribute('data-theme', next);
			try { localStorage.setItem('tn-theme', next); } catch (e) { /* private mode */ }
		});
	});

	/* ---------- Mobile nav ---------- */
	var navBtn = $('.nav-toggle');
	var nav = $('#main-nav');
	if (navBtn && nav) {
		navBtn.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			navBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		$$('a', nav).forEach(function (a) {
			a.addEventListener('click', function () { nav.classList.remove('is-open'); navBtn.setAttribute('aria-expanded', 'false'); });
		});
	}

	/* ---------- Homepage tool search ----------
	   Every word must start a word in the card's name, blurb, hub or keywords (catalog 'keywords' holds synonyms like hz,
	   ping, wpm). Matches in the name rank first, then keywords, then the blurb; a tool listed in two hubs shows once. */
	var search = $('#tool-search');
	if (search) {
		var empty = $('#search-empty'), chips = $('.hero .chips'), sections = $$('.hub-section'), seen = {}, index = [];
		$$('.hub-section [data-search]').forEach(function (card, i) {
			var href = card.getAttribute('href') || card.getAttribute('data-name') || String(i);
			if (seen[href]) { return; }
			seen[href] = true;
			index.push({ li: card.parentNode, i: i, guide: card.classList.contains('card--guide'), name: card.getAttribute('data-name') || '', kw: card.getAttribute('data-keywords') || '', all: card.getAttribute('data-search') || '' });
		});
		var results = doc.createElement('section');
		results.className = 'hub-section search-results';
		results.hidden = true;
		results.innerHTML = '<h2>Search results</h2><ul class="cards"></ul>';
		if (sections[0]) { sections[0].parentNode.insertBefore(results, sections[0]); }
		var list = $('ul', results);
		var starts = function (text, word) { return (' ' + text.replace(/[^a-z0-9.+#]+/g, ' ')).indexOf(' ' + word) !== -1; };
		var score = function (it, words) {
			var s = 0;
			for (var w = 0; w < words.length; w++) {
				var word = words[w];
				if (it.name.indexOf(word) === 0) { s += 8; }
				else if (starts(it.name, word)) { s += 6; }
				else if (it.kw.indexOf(word) === 0) { s += 5; }
				else if (starts(it.kw, word)) { s += 4; }
				else if (starts(it.all, word)) { s += 1; }
				else { return 0; }
			}
			return it.guide ? s / 2 : s; // tools before guides
		};
		var filter = function () {
			var q = search.value.trim().toLowerCase();
			if (chips) { chips.style.display = q ? 'none' : ''; } // results sit right under the box
			if (!q) {
				results.hidden = true;
				sections.forEach(function (section) { section.hidden = false; });
				if (empty) { empty.hidden = true; }
				return;
			}
			var words = q.split(/[^a-z0-9.+#]+/).filter(Boolean);
			var hits = index.map(function (it) { return { it: it, s: score(it, words) }; }).filter(function (h) { return h.s > 0; });
			hits.sort(function (a, b) { return b.s - a.s || a.it.i - b.it.i; });
			list.innerHTML = '';
			hits.forEach(function (h) { list.appendChild(h.it.li.cloneNode(true)); });
			sections.forEach(function (section) { section.hidden = true; });
			results.hidden = !hits.length;
			if (empty) { empty.hidden = hits.length > 0; }
		};
		var params = new URLSearchParams(location.search);
		if (params.get('q')) { search.value = params.get('q'); }
		search.addEventListener('input', filter);
		filter();
	}

	/* ---------- Fullscreen buttons: data-tn-fullscreen="#selector" ---------- */
	$$('[data-tn-fullscreen]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var target = $(btn.getAttribute('data-tn-fullscreen'));
			if (target) { toggleFullscreen(target); }
		});
	});

	/* ---------- Device notes ---------- */
	var note = $('#device-note');
	if (note) {
		// 'desktop' and 'touch' notes are shown by CSS media queries (pointer type).
		var need = note.getAttribute('data-device');
		if (need === 'gamepad') { note.hidden = 'getGamepads' in navigator; }
		if (need === 'media') { note.hidden = !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia); }
	}

	/* ---------- Copy buttons: data-tn-copy="#textarea" ---------- */
	$$('[data-tn-copy]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var src = $(btn.getAttribute('data-tn-copy'));
			if (!src) { return; }
			var label = btn.textContent;
			var done = function () { btn.textContent = 'Copied'; setTimeout(function () { btn.textContent = label; }, 1600); };
			if (navigator.clipboard && window.isSecureContext) {
				navigator.clipboard.writeText(src.value).then(done);
			} else {
				src.select();
				doc.execCommand('copy');
				done();
			}
		});
	});

	/* ---------- Third-party scripts, loaded after the page is usable ---------- */
	function addScript(src, attrs) {
		var s = doc.createElement('script');
		s.async = true;
		s.src = src;
		Object.keys(attrs || {}).forEach(function (k) { s.setAttribute(k, attrs[k]); });
		doc.head.appendChild(s);
	}

	var adsLoaded = false;
	function loadAds() {
		if (adsLoaded || !cfg.ads) { return; }
		adsLoaded = true;
		addScript('https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' + encodeURIComponent(cfg.ads), { crossorigin: 'anonymous' });
		$$('ins.adsbygoogle').forEach(function () { (window.adsbygoogle = window.adsbygoogle || []).push({}); });
	}
	if (cfg.ads) {
		['scroll', 'pointerdown', 'keydown', 'touchstart'].forEach(function (ev) {
			window.addEventListener(ev, loadAds, { once: true, passive: true });
		});
		setTimeout(loadAds, 4000);
	}

	/* ---------- Embed mode: count the load per embedding site (domain only, no visitor data) ---------- */
	if (cfg.embed && cfg.rest && cfg.slug) {
		try {
			fetch(cfg.rest + 'embed', { method: 'POST', credentials: 'omit', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ slug: cfg.slug, ref: doc.referrer || '' }), keepalive: true }).catch(function () { /* ignore */ });
		} catch (e) { /* ignore */ }
	}

	/* ---------- Embed code box: width, height, theme and a preview ---------- */
	var embedBox = $('.embed-box[data-embed-src]');
	if (embedBox) {
		var code = $('#embed-code'), preview = $('#embed-preview');
		var build = function () {
			var w = $('[name="embed-w"]', embedBox).value, h = Number($('[name="embed-h"]', embedBox).value) || 620, th = $('[name="embed-theme"]', embedBox).value;
			var src = embedBox.getAttribute('data-embed-src') + (th ? '&theme=' + th : '');
			code.value = '<iframe src="' + src + '" width="' + w + '" height="' + h + '" style="border:0;max-width:100%" title="' + embedBox.getAttribute('data-embed-title') + '" allow="camera; microphone; gamepad; fullscreen; autoplay; accelerometer; gyroscope; magnetometer; geolocation" loading="lazy"></iframe>\n<p><a href="' + embedBox.getAttribute('data-embed-url') + '">' + embedBox.getAttribute('data-embed-title') + '</a> by ' + embedBox.getAttribute('data-embed-site') + '</p>';
			if (preview && embedBox.open) {
				preview.hidden = false;
				preview.style.width = w === '100%' ? '100%' : w + 'px';
				preview.height = h;
				if (preview.getAttribute('src') !== src) { preview.src = src; }
			}
		};
		$$('select, input', embedBox).forEach(function (el) { el.addEventListener('change', build); el.addEventListener('input', build); });
		embedBox.addEventListener('toggle', build);
	}

	window.addEventListener('load', function () {
		// GA4 is printed in <head> by inc/analytics.php.
		if (cfg.clarity) {
			window.clarity = window.clarity || function () { (window.clarity.q = window.clarity.q || []).push(arguments); };
			addScript('https://www.clarity.ms/tag/' + encodeURIComponent(cfg.clarity));
		}
	});
}());
