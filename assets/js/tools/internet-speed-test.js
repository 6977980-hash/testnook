/* Internet speed test: idle ping and jitter, download and upload in parallel streams against the nearest Cloudflare
   edge (TNNet), latency under load (bufferbloat grade), what the speed is good for, and the last 10 results in
   localStorage (tn-speed-history). */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="internet-speed-test"]');
	if (!root || !window.TNNet) { return; }
	var U = window.TNUtil, N = window.TNNet;
	var $ = function (s) { return root.querySelector(s); };
	var startBtn = $('#st-start'), statusEl = $('#st-status'), big = $('#st-big'), phase = $('#st-phase'), bar = $('#st-bar'), saver = $('#st-saver');
	var arc = $('#st-arc'), ARC_LEN = arc ? arc.getTotalLength() : 0;
	var running = false, ctrl = null;
	var KEY = 'tn-speed-history';

	function set(id, v) { var el = $('#' + id); if (el) { el.textContent = v; } }

	// Dial: log scale 0.5 to 1000 Mbps.
	function dial(v) {
		if (!arc) { return; }
		var f = v <= 0.5 ? 0 : Math.min(1, Math.log(v / 0.5) / Math.log(2000));
		arc.style.strokeDasharray = ARC_LEN + ' ' + ARC_LEN;
		arc.style.strokeDashoffset = String(ARC_LEN * (1 - f));
	}
	function show(v, label, progress) {
		big.textContent = N.fmtMbps(v);
		phase.textContent = label;
		dial(v);
		bar.style.width = Math.round(Math.min(1, progress) * 100) + '%';
	}

	function grade(extra) {
		if (extra === null || isNaN(extra)) { return '-'; }
		return extra < 5 ? 'A+' : extra < 30 ? 'A' : extra < 60 ? 'B' : extra < 200 ? 'C' : extra < 400 ? 'D' : 'F';
	}

	function goodFor(r) {
		var list = $('#st-good');
		if (!list) { return; }
		var ping = r.ping, jit = r.jitter;
		var items = [
			['Web browsing, email and music', r.down >= 1, r.down >= 1 ? 'Yes' : 'Slow: pages will take a while'],
			['HD video (1080p) on one screen', r.down >= 5, r.down >= 5 ? 'Yes' : 'Needs about 5 Mbps'],
			['4K streaming', r.down >= 25, r.down >= 25 ? (r.down >= 75 ? 'Yes, on several screens at once' : 'Yes, one stream') : 'Needs about 25 Mbps per stream'],
			['Video calls (Zoom, Teams, Meet)', r.down >= 3.5 && r.up >= 3 && ping < 150 && jit < 30, r.up < 3 ? 'Upload is low: your video may look blurry to others' : ping >= 150 || jit >= 30 ? 'Speed is fine, but ping or jitter may cause lag' : r.down < 3.5 ? 'Download is low for HD calls' : 'Yes, in HD'],
			['Online gaming', r.down >= 3 && r.up >= 1 && ping < 100 && jit < 30, ping < 30 && jit < 10 ? 'Yes, even competitive games' : ping < 60 && jit < 20 ? 'Yes' : ping < 100 ? 'Playable, but you may notice lag' : 'Ping is high: expect lag'],
			['Working from home with big uploads', r.up >= 10, r.up >= 10 ? 'Yes' : 'Upload under 10 Mbps makes large uploads slow']
		];
		list.innerHTML = '';
		items.forEach(function (it) {
			var li = document.createElement('li'), b = document.createElement('strong'), s = document.createElement('span');
			li.className = it[1] ? 'st-ok' : 'st-no';
			b.textContent = it[0];
			s.textContent = it[2];
			li.appendChild(b);
			li.appendChild(s);
			list.appendChild(li);
		});
		var gb = 50, secs = gb * 8000 / Math.max(0.01, r.down);
		set('st-50gb', secs < 3600 ? Math.round(secs / 60) + ' minutes' : (secs / 3600).toFixed(1) + ' hours');
		$('#st-good-wrap').hidden = false;
	}

	/* ---------- History ---------- */
	function loadHist() { try { return JSON.parse(localStorage.getItem(KEY) || '[]') || []; } catch (e) { return []; } }
	function saveHist(r) {
		var h = loadHist();
		h.unshift({ t: Date.now(), d: r.down, u: r.up, p: r.ping, j: r.jitter, s: r.colo });
		h = h.slice(0, 10);
		try { localStorage.setItem(KEY, JSON.stringify(h)); } catch (e) {}
		renderHist();
	}
	function renderHist() {
		var wrap = $('#st-hist'), body = $('#st-hist-body');
		if (!wrap) { return; }
		var h = loadHist();
		wrap.hidden = !h.length;
		body.innerHTML = '';
		h.forEach(function (x) {
			var tr = document.createElement('tr');
			[new Date(x.t).toLocaleString([], { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }), N.fmtMbps(x.d), N.fmtMbps(x.u), N.fmtMs(x.p), N.fmtMs(x.j)].forEach(function (v) {
				var td = document.createElement('td');
				td.textContent = v;
				tr.appendChild(td);
			});
			body.appendChild(tr);
		});
	}
	var clearBtn = $('#st-hist-clear');
	if (clearBtn) { clearBtn.addEventListener('click', function () { try { localStorage.removeItem(KEY); } catch (e) {} renderHist(); }); }

	/* ---------- Run ---------- */
	// Pings every 400 ms while a transfer runs, for latency under load.
	function loadedPinger() {
		var list = [], on = true;
		(function loop() {
			if (!on) { return; }
			N.ping(3000).then(function (v) { list.push(v === null ? 3000 : v); if (on) { setTimeout(loop, 400); } });
		}());
		return function () { on = false; var s = N.stats(list); return s ? s.median : null; };
	}

	function reset() {
		['st-down', 'st-up', 'st-ping', 'st-jitter', 'st-ldown', 'st-lup', 'st-grade', 'st-data', 'st-server', 'st-net'].forEach(function (id) { set(id, '-'); });
		$('#st-good-wrap').hidden = true;
		show(0, 'Ready', 0);
	}

	function fail(err, c) {
		if (c && c !== ctrl) { return; }
		running = false;
		startBtn.textContent = 'Start speed test';
		if (err && err.message === 'stopped') {
			U.status(statusEl, 'Test stopped.', '');
			show(0, 'Stopped', 0);
			return;
		}
		show(0, 'Could not connect', 0);
		U.status(statusEl, 'Could not reach the test server (speed.cloudflare.com). An ad blocker, a firewall, or a school or office network may block it. Allow it and try again.', 'bad');
	}

	function run() {
		running = true;
		var c = ctrl = new AbortController();
		startBtn.textContent = 'Stop';
		reset();
		var quick = saver && saver.checked, r = { colo: '' }, used = 0;
		var dlMs = quick ? 6000 : 10000, ulMs = quick ? 5000 : 8000;
		U.status(statusEl, 'Measuring ping...', '');
		phase.textContent = 'Ping';
		N.meta().then(function (m) {
			r.colo = m.colo;
			set('st-server', m.colo ? 'Cloudflare ' + m.colo : 'Cloudflare');
			set('st-net', [m.city, N.country(m.country)].filter(Boolean).join(', ') + (m.asn ? ' (AS' + m.asn + ')' : ''));
		}).catch(function () {});
		var pings = [], i = 0;
		function pingLoop() {
			if (c.signal.aborted) { return Promise.reject(new Error('stopped')); }
			return N.ping(2000).then(function (v) {
				pings.push(v);
				i++;
				bar.style.width = Math.round(i / 20 * 100) + '%';
				if (v !== null) { big.textContent = Math.round(v); phase.textContent = 'Ping (ms)'; }
				if (i === 2 && pings[0] === null && pings[1] === null) { throw new Error('blocked'); }
				return i < 20 ? pingLoop() : null;
			});
		}
		pingLoop().then(function () {
			var s = N.stats(pings.slice(2));
			if (!s) { throw new Error('blocked'); }
			r.ping = s.median;
			r.jitter = s.jitter;
			set('st-ping', N.fmtMs(r.ping));
			set('st-jitter', N.fmtMs(r.jitter));
			U.status(statusEl, 'Measuring download speed...', '');
			var stop = loadedPinger();
			return N.download({ ms: dlMs, warm: quick ? 1000 : 2000, maxBytes: quick ? 100e6 : 0, streams: quick ? 3 : 4, signal: c.signal, onProgress: function (v, b, p) { show(v, 'Download (Mbps)', p); } }).then(function (d) {
				r.ldown = stop();
				r.down = d.mbps;
				used += d.bytes;
				set('st-down', N.fmtMbps(d.mbps) + ' Mbps');
				set('st-ldown', N.fmtMs(r.ldown));
			}, function (e) { stop(); throw e; });
		}).then(function () {
			U.status(statusEl, 'Measuring upload speed...', '');
			var stop = loadedPinger();
			return N.upload({ ms: ulMs, warm: quick ? 1000 : 1500, maxBytes: quick ? 50e6 : 0, signal: c.signal, onProgress: function (v, b, p) { show(v, 'Upload (Mbps)', p); } }).then(function (u) {
				r.lup = stop();
				r.up = u.mbps;
				used += u.bytes;
				set('st-up', N.fmtMbps(u.mbps) + ' Mbps');
				set('st-lup', N.fmtMs(r.lup));
			}, function (e) { stop(); throw e; });
		}).then(function () {
			if (c !== ctrl) { return; }
			running = false;
			startBtn.textContent = 'Test again';
			var extra = Math.max(r.ldown || 0, r.lup || 0) - r.ping;
			set('st-grade', grade(extra));
			set('st-data', N.fmtBytes(used));
			show(r.down, 'Download (Mbps)', 1);
			goodFor(r);
			saveHist(r);
			U.status(statusEl, 'Done: ' + N.fmtMbps(r.down) + ' Mbps down, ' + N.fmtMbps(r.up) + ' Mbps up, ping ' + N.fmtMs(r.ping) + '.', 'ok');
		}).catch(function (e) { fail(e, c); });
	}

	startBtn.addEventListener('click', function () {
		if (running) { ctrl.abort(); fail(new Error('stopped')); ctrl = null; return; }
		run();
	});
	renderHist();
	reset();
}());
