#!/usr/bin/env node
/*
 * Page gate for testnook.com (audit F-37 / S-11).
 *
 *   node bin/check-pages.js https://testnook.com [--limit=N] [--only=slug,slug] [--wide] [--a11y=warn]
 *
 * Reads every URL from <base>/wp-sitemap.xml and opens each page at 375 px
 * (iPhone 13; with --wide also 1366 px). A page fails on: status other than
 * 200, a JavaScript page error, JSON-LD that does not parse, not exactly one
 * H1, horizontal overflow, an input without a label, or a skipped heading
 * level (h2 -> h4). With --a11y=warn the last two only print.
 *
 * Score sharing is switched off (tn-share-off) and testnook/v1 writes
 * (start, result, claim, embed) are blocked, so a run never adds stats.
 * Needs Playwright: `npm i -D playwright && npx playwright install chromium`.
 */
'use strict';

const { chromium, devices } = require('playwright');

const args = process.argv.slice(2);
const base = (args.find((a) => !a.startsWith('--')) || '').replace(/\/+$/, '');
const opt = (name) => {
	const a = args.find((x) => x === '--' + name || x.startsWith('--' + name + '='));
	return a ? (a.includes('=') ? a.split('=').slice(1).join('=') : true) : null;
};
if (!/^https?:\/\//.test(base)) {
	console.error('Usage: node bin/check-pages.js <base-url> [--limit=N] [--only=slug,slug] [--wide] [--a11y=warn]');
	process.exit(2);
}
const a11yWarn = opt('a11y') === 'warn';
const limit = parseInt(opt('limit'), 10) || 0;
const only = opt('only') ? String(opt('only')).split(',').map((s) => s.trim().replace(/^\/|\/$/g, '')) : null;
const CONCURRENCY = 4;

async function sitemapUrls(request) {
	const get = async (url) => {
		const res = await request.get(url);
		if (res.status() !== 200) throw new Error(url + ' -> ' + res.status());
		return [...(await res.text()).matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => m[1].replace(/&amp;/g, '&'));
	};
	const urls = [];
	for (const sub of await get(base + '/wp-sitemap.xml')) {
		urls.push(...(/\.xml(\?|$)/.test(sub) ? await get(sub) : [sub]));
	}
	return [...new Set(urls)];
}

// Runs inside the page.
function inspect() {
	const out = { jsonld: [], h1: 0, overflow: 0, unlabeled: [], skips: [] };
	document.querySelectorAll('script[type="application/ld+json"]').forEach((s, i) => {
		try { JSON.parse(s.textContent); } catch (e) { out.jsonld.push('block ' + (i + 1) + ': ' + e.message); }
	});
	out.h1 = document.querySelectorAll('h1').length;
	out.overflow = document.documentElement.scrollWidth - window.innerWidth;
	const visible = (el) => !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
	document.querySelectorAll('input, select, textarea').forEach((el) => {
		if (/^(hidden|submit|button|reset|image)$/i.test(el.type || '')) return;
		if (!visible(el)) return;
		const named = el.getAttribute('aria-label') || el.getAttribute('aria-labelledby') || el.getAttribute('title') ||
			(el.labels && el.labels.length) || el.closest('label');
		if (!named) out.unlabeled.push(el.tagName.toLowerCase() + (el.id ? '#' + el.id : el.name ? '[name=' + el.name + ']' : ''));
	});
	let prev = 0;
	document.querySelectorAll('main h1, main h2, main h3, main h4, main h5, main h6').forEach((h) => {
		const lvl = +h.tagName[1];
		if (prev && lvl > prev + 1) out.skips.push('h' + prev + ' -> h' + lvl + ' "' + h.textContent.trim().slice(0, 40) + '"');
		prev = lvl;
	});
	return out;
}

async function checkPage(browser, url, viewport) {
	const ctx = await browser.newContext(viewport === 375 ? { ...devices['iPhone 13'] } : { viewport: { width: 1366, height: 900 } });
	await ctx.addInitScript(() => { try { localStorage.setItem('tn-share-off', '1'); } catch (e) {} });
	await ctx.route(/wp-json\/testnook\/v1\/(start|result|claim|embed)/, (r) => r.abort());
	const page = await ctx.newPage();
	const errors = [];
	const warns = [];
	page.on('pageerror', (e) => errors.push('page error: ' + e.message));
	try {
		const res = await page.goto(url, { waitUntil: 'load', timeout: 45000 });
		const status = res ? res.status() : 0;
		if (status !== 200) errors.push('status ' + status);
		await page.waitForTimeout(400);
		const r = await page.evaluate(inspect);
		r.jsonld.forEach((m) => errors.push('JSON-LD: ' + m));
		if (r.h1 !== 1) errors.push(r.h1 + ' H1 elements');
		if (r.overflow > 0) errors.push('horizontal overflow ' + r.overflow + ' px');
		const a11y = r.unlabeled.map((x) => 'unlabeled ' + x).concat(r.skips.map((x) => 'heading skip ' + x));
		(a11yWarn ? warns : errors).push(...a11y);
	} catch (e) {
		errors.push('load failed: ' + e.message.split('\n')[0]);
	}
	await ctx.close();
	return { url, viewport, errors, warns };
}

(async () => {
	const browser = await chromium.launch();
	const api = await (await browser.newContext()).request;
	let urls = await sitemapUrls(api);
	if (only) urls = urls.filter((u) => only.includes(new URL(u).pathname.replace(/^\/|\/$/g, '')));
	if (limit) urls = urls.slice(0, limit);
	const jobs = [];
	for (const u of urls) {
		jobs.push([u, 375]);
		if (opt('wide')) jobs.push([u, 1366]);
	}
	console.log('Checking ' + urls.length + ' URLs (' + jobs.length + ' page loads) from ' + base);
	let failed = 0;
	let warned = 0;
	let next = 0;
	const worker = async () => {
		while (next < jobs.length) {
			const [u, vw] = jobs[next++];
			let r = await checkPage(browser, u, vw);
			// A busy shared host can drop a request now and then: retry a load failure or 5xx once.
			if (r.errors.some((e) => /^(load failed|status (0|5\d\d))/.test(e))) r = await checkPage(browser, u, vw);
			const path = new URL(u).pathname;
			if (r.errors.length) {
				failed++;
				console.log('FAIL ' + vw + ' ' + path + '\n  - ' + r.errors.join('\n  - '));
			}
			if (r.warns.length) {
				warned++;
				console.log('warn ' + vw + ' ' + path + '\n  - ' + r.warns.join('\n  - '));
			}
		}
	};
	await Promise.all(Array.from({ length: CONCURRENCY }, worker));
	await browser.close();
	console.log((failed ? 'FAILED' : 'OK') + ': ' + (jobs.length - failed) + '/' + jobs.length + ' page loads passed' + (warned ? ', ' + warned + ' with warnings' : '') + '.');
	process.exit(failed ? 1 : 0);
})().catch((e) => {
	console.error(e);
	process.exit(2);
});
