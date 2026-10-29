/* Ping test: a latency sample every 250 ms for 10, 30 or 60 seconds to the nearest Cloudflare edge or to Google,
   live chart, min/avg/median/max, jitter, 95th percentile, spikes, lost requests, and verdicts for gaming and calls. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="ping-test"]');
	if (!root || !window.TNNet) { return; }
	var U = window.TNUtil, N = window.TNNet;
	var $ = function (s) { return root.querySelector(s); };
	var startBtn = $('#pg-start'), statusEl = $('#pg-status'), canvas = $('#pg-chart'), nowEl = $('#pg-now');
	var secs = 30, target = 'cloudflare', running = false, token = 0, samples = [];
	var TIMEOUT = 1500, EVERY = 250, SKIP = 2;

	function set(id, v) { var el = $('#' + id); if (el) { el.textContent = v; } }

	U.$$('[data-pg-secs]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			if (running) { return; }
			secs = +b.getAttribute('data-pg-secs');
			U.$$('[data-pg-secs]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
		});
	});
	U.$$('[data-pg-target]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			if (running) { return; }
			target = b.getAttribute('data-pg-target');
			U.$$('[data-pg-target]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
		});
	});

	function one() {
		return target === 'google' ? N.pingOpaque('https://www.gstatic.com/generate_204', TIMEOUT) : N.ping(TIMEOUT);
	}

	/* ---------- Chart ---------- */
	function css(name) { return getComputedStyle(root).getPropertyValue(name).trim() || '#888'; }
	function draw() {
		var dpr = window.devicePixelRatio || 1, w = canvas.clientWidth, h = canvas.clientHeight;
		if (canvas.width !== Math.round(w * dpr)) { canvas.width = Math.round(w * dpr); canvas.height = Math.round(h * dpr); }
		var ctx = canvas.getContext('2d');
		ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
		ctx.clearRect(0, 0, w, h);
		var total = Math.max(1, Math.round(secs * 1000 / EVERY)), vals = samples.filter(function (v) { return v !== null; });
		var s = N.stats(samples.slice(SKIP)), top = Math.max(50, s ? Math.min(s.max, s.p95 * 2) * 1.15 : 50);
		top = Math.ceil(top / 20) * 20;
		var pad = 34, gw = w - pad - 6, gh = h - 22, bw = gw / total;
		ctx.font = '11px ' + css('--font');
		ctx.fillStyle = css('--muted');
		ctx.strokeStyle = css('--border');
		ctx.lineWidth = 1;
		[0, 0.5, 1].forEach(function (f) {
			var y = 8 + gh * (1 - f);
			ctx.beginPath(); ctx.moveTo(pad, y + 0.5); ctx.lineTo(w - 6, y + 0.5); ctx.stroke();
			ctx.fillText(Math.round(top * f) + '', 4, y + 4);
		});
		var brand = css('--brand'), bad = css('--bad'), warn = css('--warn');
		var med = s ? s.median : 0;
		samples.forEach(function (v, i) {
			var x = pad + i * bw;
			if (v === null) { ctx.fillStyle = bad; ctx.fillRect(x, 8, Math.max(1, bw - 1), gh); return; }
			var bh = Math.max(1, Math.min(1, v / top) * gh);
			ctx.fillStyle = s && i >= SKIP && v > med * 2 + 20 ? warn : brand;
			ctx.fillRect(x, 8 + gh - bh, Math.max(1, bw - 1), bh);
		});
		ctx.fillStyle = css('--muted');
		ctx.fillText(vals.length ? samples.length + ' of ' + total + ' samples (ms)' : 'ms', pad, h - 4);
	}

	function update(final) {
		var s = N.stats(samples.slice(SKIP)), last = samples[samples.length - 1];
		nowEl.textContent = last === undefined ? '-' : last === null ? 'lost' : Math.round(last);
		if (s) {
			set('pg-min', N.fmtMs(s.min)); set('pg-avg', N.fmtMs(s.mean)); set('pg-med', N.fmtMs(s.median)); set('pg-max', N.fmtMs(s.max));
			set('pg-jit', N.fmtMs(s.jitter)); set('pg-p95', N.fmtMs(s.p95));
			var spikes = samples.slice(SKIP).filter(function (v) { return v !== null && v > s.median * 2 + 20; }).length;
			set('pg-spikes', String(spikes));
		}
		var lost = samples.slice(SKIP).filter(function (v) { return v === null; }).length, n = Math.max(1, samples.length - SKIP);
		set('pg-lost', lost + ' (' + (lost / n * 100).toFixed(1) + '%)');
		draw();
		if (final && s) { verdicts(s, lost / n * 100); }
	}

	function verdict(id, cls, title, text) {
		var el = $('#' + id);
		el.className = 'sy-verdict ' + cls;
		el.querySelector('strong').textContent = title;
		el.querySelector('p').textContent = text;
	}
	function verdicts(s, loss) {
		var m = s.median, j = s.jitter;
		$('#pg-verdicts').hidden = false;
		if (m < 30 && j < 5 && loss === 0) { verdict('pg-v-game', 'is-ok', 'Gaming: excellent', 'Low, steady ping. Fine for competitive shooters and fighting games.'); }
		else if (m < 60 && j < 15 && loss < 1) { verdict('pg-v-game', 'is-ok', 'Gaming: good', 'Fine for almost every online game.'); }
		else if (m < 100 && j < 30 && loss < 2) { verdict('pg-v-game', 'is-warn', 'Gaming: playable', 'You may notice delay in fast games. ' + (j >= 15 ? 'Jitter is the bigger problem: try a cable.' : 'A closer game server helps.')); }
		else { verdict('pg-v-game', 'is-bad', 'Gaming: laggy', loss >= 2 ? 'Requests are getting lost. Check Wi-Fi signal and cables.' : 'Ping or jitter is high. Expect rubber-banding.'); }
		if (m < 150 && j < 30 && loss < 1) { verdict('pg-v-call', 'is-ok', 'Video calls: good', 'Calls should be smooth with no talking over each other.'); }
		else if (m < 300 && loss < 3) { verdict('pg-v-call', 'is-warn', 'Video calls: okay', 'Usable, with some delay or choppy moments.'); }
		else { verdict('pg-v-call', 'is-bad', 'Video calls: poor', 'Expect frozen video and dropped words.'); }
		if (loss < 5) { verdict('pg-v-stream', 'is-ok', 'Streaming and browsing: fine', 'Ping matters little here; download speed matters more.'); }
		else { verdict('pg-v-stream', 'is-warn', 'Streaming and browsing: unsteady', 'Many lost requests: pages may stall now and then.'); }
	}

	function stop(msg, cls) {
		running = false;
		token++;
		startBtn.textContent = 'Start ping test';
		U.status(statusEl, msg, cls || '');
	}

	function run() {
		var my = ++token, t0 = performance.now(), end = secs * 1000, n = 0;
		running = true;
		samples = [];
		$('#pg-verdicts').hidden = true;
		['pg-min', 'pg-avg', 'pg-med', 'pg-max', 'pg-jit', 'pg-p95', 'pg-spikes', 'pg-lost'].forEach(function (id) { set(id, '-'); });
		startBtn.textContent = 'Stop';
		U.status(statusEl, 'Pinging ' + (target === 'google' ? 'Google' : 'the nearest Cloudflare data centre') + '...', '');
		if (target === 'cloudflare') {
			N.meta().then(function (m) { if (my === token) { set('pg-server', 'Cloudflare ' + (m.colo || '') + (m.country ? ' (you: ' + N.country(m.country) + ')' : '')); } }).catch(function () {});
		} else { set('pg-server', 'Google (www.gstatic.com)'); }
		(function loop() {
			if (my !== token) { return; }
			var s0 = performance.now();
			one().then(function (v) {
				if (my !== token) { return; }
				samples.push(v);
				n++;
				update(false);
				if (n === 4 && samples.every(function (x) { return x === null; })) {
					stop('Could not reach the test server. An ad blocker, a firewall, or a school or office network may block it, or you are offline.', 'bad');
					return;
				}
				if (performance.now() - t0 >= end) {
					update(true);
					var s = N.stats(samples.slice(SKIP));
					stop(s ? 'Done: median ping ' + N.fmtMs(s.median) + ', jitter ' + N.fmtMs(s.jitter) + '.' : 'Done.', 'ok');
					return;
				}
				setTimeout(loop, Math.max(0, EVERY - (performance.now() - s0)));
			});
		}());
	}

	startBtn.addEventListener('click', function () {
		if (running) { update(true); stop('Stopped. The results cover the samples so far.'); return; }
		run();
	});
	window.addEventListener('resize', draw);
	draw();
}());
