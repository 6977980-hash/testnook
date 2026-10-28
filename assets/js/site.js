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
		fmt: function (n, d) { return Number(n).toFixed(d || 0); }
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

	/* ---------- Homepage tool search ---------- */
	var search = $('#tool-search');
	if (search) {
		var empty = $('#search-empty');
		var filter = function () {
			var q = search.value.trim().toLowerCase();
			var any = false;
			$$('.hub-section').forEach(function (section) {
				var shown = 0;
				$$('[data-search]', section).forEach(function (card) {
					var hit = !q || card.getAttribute('data-search').indexOf(q) !== -1;
					card.parentNode.classList.toggle('is-hidden', !hit);
					if (hit) { shown++; }
				});
				section.hidden = shown === 0;
				if (shown) { any = true; }
			});
			if (empty) { empty.hidden = any; }
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
		var need = note.getAttribute('data-device');
		var show = false;
		if (need === 'desktop') { show = TNUtil.isTouch() && !TNUtil.hasFinePointer(); }
		if (need === 'touch') { show = !TNUtil.isTouch(); }
		if (need === 'gamepad') { show = !('getGamepads' in navigator); }
		if (need === 'media') { show = !(navigator.mediaDevices && navigator.mediaDevices.getUserMedia); }
		note.hidden = !show;
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

	window.addEventListener('load', function () {
		if (cfg.ga4) {
			addScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(cfg.ga4));
			window.dataLayer = window.dataLayer || [];
			window.gtag = function () { window.dataLayer.push(arguments); };
			window.gtag('js', new Date());
			window.gtag('config', cfg.ga4);
		}
		if (cfg.clarity) {
			window.clarity = window.clarity || function () { (window.clarity.q = window.clarity.q || []).push(arguments); };
			addScript('https://www.clarity.ms/tag/' + encodeURIComponent(cfg.clarity));
		}
	});
}());
