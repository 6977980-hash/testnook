/* Shared network helpers for the system hub (window.TNNet): latency, download and upload against Cloudflare's speed test
   edge (speed.cloudflare.com, CORS open, nearest data centre), IP details from its response headers, IPv4/IPv6 via ipify,
   network owner via RDAP, DNS over HTTPS. Loaded before internet-speed-test, ping-test, what-is-my-ip, dns-lookup and
   webrtc-leak-test. Nothing is sent to testnook.com. */
(function () {
	'use strict';
	if (window.TNNet) { return; }
	var CF = 'https://speed.cloudflare.com';
	var now = function () { return performance.now(); };
	var rnd = function () { return Math.random().toString(36).slice(2); };

	function timeout(ms, ctrl) {
		return setTimeout(function () { try { ctrl.abort(); } catch (e) {} }, ms);
	}

	// Server processing time from Server-Timing, so it can be taken off the round trip.
	function serverTime(entry) {
		var t = 0;
		(entry && entry.serverTiming || []).forEach(function (s) { if (/^cfSpeed/.test(s.name) && s.duration > t) { t = s.duration; } });
		return t;
	}

	function entryFor(url) {
		var list = performance.getEntriesByName(url);
		return list.length ? list[list.length - 1] : null;
	}

	/* One latency sample to the nearest Cloudflare edge, in ms (null when lost). The browser's resource timing
	   gives request-to-first-byte; the server's own processing time is taken off. */
	function ping(ms) {
		var url = CF + '/__down?bytes=0&r=' + rnd(), ctrl = new AbortController(), t0 = now(), tid = timeout(ms || 2000, ctrl);
		return fetch(url, { cache: 'no-store', signal: ctrl.signal }).then(function (r) {
			return r.arrayBuffer().then(function () {
				clearTimeout(tid);
				var wall = now() - t0, e = entryFor(url), v = wall;
				if (e && e.responseStart > 0 && e.requestStart > 0) { v = e.responseStart - e.requestStart; }
				v -= serverTime(e);
				if (v < 0.5) { v = Math.max(0.5, Math.min(wall, 1)); }
				try { performance.clearResourceTimings(); } catch (err) {}
				return v;
			});
		}).catch(function () { clearTimeout(tid); return null; });
	}

	/* Latency to another host where only an opaque response is possible: wall time of a tiny request. */
	function pingOpaque(base, ms) {
		var ctrl = new AbortController(), t0 = now(), tid = timeout(ms || 2000, ctrl);
		return fetch(base + (base.indexOf('?') < 0 ? '?' : '&') + 'r=' + rnd(), { mode: 'no-cors', cache: 'no-store', signal: ctrl.signal }).then(function () {
			clearTimeout(tid);
			return now() - t0;
		}).catch(function () { clearTimeout(tid); return null; });
	}

	/* What Cloudflare sees for this connection: /cdn-cgi/trace gives the IP, data centre (colo) and country;
	   the speed endpoint's cf-meta-* headers add city, network (ASN) and time zone when Cloudflare includes them. */
	function meta() {
		var ctrl = new AbortController(), tid = timeout(6000, ctrl), out = { ip: '', colo: '', country: '', asn: '', city: '', timezone: '' };
		var trace = fetch(CF + '/cdn-cgi/trace?r=' + rnd(), { cache: 'no-store', signal: ctrl.signal }).then(function (r) { return r.text(); }).then(function (t) {
			t.split('\n').forEach(function (line) {
				var i = line.indexOf('='), k = line.slice(0, i), v = line.slice(i + 1).trim();
				if (k === 'ip') { out.ip = v; } else if (k === 'colo') { out.colo = v; } else if (k === 'loc') { out.country = v; }
			});
		});
		var head = fetch(CF + '/__down?bytes=0&r=' + rnd(), { cache: 'no-store', signal: ctrl.signal }).then(function (r) {
			var h = function (k) { return r.headers.get('cf-meta-' + k) || ''; };
			out.asn = h('asn');
			out.city = h('city');
			out.timezone = h('timezone');
			out.ip = out.ip || h('ip');
			out.colo = out.colo || h('colo');
			out.country = out.country || h('country');
		}).catch(function () {});
		return Promise.all([trace.catch(function () {}), head]).then(function () {
			clearTimeout(tid);
			if (!out.ip) { throw new Error('blocked'); }
			return out;
		});
	}

	function jsonIp(url, ms) {
		var ctrl = new AbortController(), tid = timeout(ms || 5000, ctrl);
		return fetch(url, { cache: 'no-store', signal: ctrl.signal }).then(function (r) { return r.json(); }).then(function (d) {
			clearTimeout(tid);
			return d && d.ip ? d.ip : null;
		}).catch(function () { clearTimeout(tid); return null; });
	}
	function ipv4() { return jsonIp('https://api.ipify.org?format=json', 5000); }
	function ipv6() { return jsonIp('https://api6.ipify.org?format=json', 5000); }

	/* Who holds an IP block, from the regional internet registry (RDAP is open to browsers). */
	function owner(ip) {
		var ctrl = new AbortController(), tid = timeout(8000, ctrl);
		return fetch('https://rdap.org/ip/' + encodeURIComponent(ip), { signal: ctrl.signal }).then(function (r) { return r.json(); }).then(function (d) {
			clearTimeout(tid);
			var name = '';
			(d.entities || []).some(function (e) {
				if ((e.roles || []).indexOf('registrant') < 0 && (e.roles || []).indexOf('administrative') < 0) { return false; }
				var v = e.vcardArray && e.vcardArray[1];
				(v || []).some(function (x) { if (x[0] === 'fn' && x[3]) { name = String(x[3]); return true; } return false; });
				return !!name;
			});
			return { name: name, net: d.name || '', handle: d.handle || '', country: d.country || '', start: d.startAddress || '', end: d.endAddress || '' };
		}).catch(function () { clearTimeout(tid); return null; });
	}

	/* ---------- Bandwidth ---------- */
	/* Downloads in parallel streams for `ms` (or until `maxBytes`) and reports progress.
	   Speed = bytes after the warm-up / time after it. */
	function download(o) {
		o = o || {};
		var ms = o.ms || 10000, warm = o.warm || 2000, streams = o.streams || 4, chunk = o.chunk || 25000000;
		var ctrls = [], total = 0, t0 = now(), done = false, warmBytes = null, samples = [];
		return new Promise(function (resolve, reject) {
			var anyBytes = false, failures = 0;
			function one() {
				if (done) { return; }
				var c = new AbortController();
				ctrls.push(c);
				fetch(CF + '/__down?bytes=' + chunk + '&r=' + rnd(), { cache: 'no-store', signal: c.signal }).then(function (r) {
					if (!r.ok || !r.body) { throw new Error('http'); }
					var reader = r.body.getReader();
					function pump() {
						return reader.read().then(function (x) {
							if (x.done) { return; }
							total += x.value.byteLength;
							anyBytes = true;
							if (!done) { return pump(); }
							try { reader.cancel(); } catch (e) {}
						});
					}
					return pump();
				}).then(one, function () {
					if (done) { return; }
					failures++;
					if (failures > streams * 2 && !anyBytes) { finish(new Error('blocked')); return; }
					setTimeout(one, 200);
				});
			}
			var tick = setInterval(function () {
				var t = now() - t0;
				samples.push([t, total]);
				if (warmBytes === null && t >= warm) { warmBytes = [t, total]; }
				if (o.onProgress) { o.onProgress(rate(samples, 1000), total, Math.max(t / ms, o.maxBytes ? total / o.maxBytes : 0)); }
				if (t >= ms || (o.maxBytes && total >= o.maxBytes)) { finish(); }
			}, 100);
			function finish(err) {
				if (done) { return; }
				done = true;
				clearInterval(tick);
				ctrls.forEach(function (c) { try { c.abort(); } catch (e) {} });
				if (err) { reject(err); return; }
				if (!anyBytes) { reject(new Error('blocked')); return; }
				var t = now() - t0, w = warmBytes || [0, 0];
				resolve({ mbps: (total - w[1]) * 8 / ((t - w[0]) / 1000) / 1e6, bytes: total, seconds: t / 1000 });
			}
			if (o.signal) { o.signal.addEventListener('abort', function () { finish(new Error('stopped')); }); }
			for (var i = 0; i < streams; i++) { one(); }
		});
	}

	/* Uploads blobs in parallel with XHR (fetch has no upload progress) and grows the blob while each one is fast. */
	function upload(o) {
		o = o || {};
		var ms = o.ms || 8000, warm = o.warm || 1500, streams = o.streams || 3;
		var max = 32 * 1048576, size = 1048576, buf = new Uint8Array(max);
		for (var i = 0; i < max; i += 4096) { buf[i] = (i * 2654435761) & 255; }
		var blob = new Blob([buf]), xhrs = [], done = false, finished = 0, live = {}, t0 = now(), samples = [], warmBytes = null, id = 0, anyOk = false, failures = 0;
		function total() { var s = finished; Object.keys(live).forEach(function (k) { s += live[k]; }); return s; }
		return new Promise(function (resolve, reject) {
			function one() {
				if (done) { return; }
				var x = new XMLHttpRequest(), k = ++id, start = now(), sz = size;
				xhrs.push(x);
				live[k] = 0;
				x.upload.onprogress = function (e) { live[k] = e.loaded; };
				x.onload = function () {
					delete live[k];
					if (x.status >= 200 && x.status < 300) {
						finished += sz;
						anyOk = true;
						if (now() - start < 1500 && size < max) { size = Math.min(max, size * 2); }
					} else { failures++; }
					if (failures > streams * 2 && !anyOk) { finish(new Error('blocked')); return; }
					one();
				};
				x.onerror = function () {
					delete live[k];
					failures++;
					if (failures > streams * 2 && !anyOk) { finish(new Error('blocked')); return; }
					setTimeout(one, 200);
				};
				x.open('POST', CF + '/__up?r=' + rnd());
				x.setRequestHeader('Content-Type', 'text/plain');
				x.send(blob.slice(0, sz));
			}
			var tick = setInterval(function () {
				var t = now() - t0, b = total();
				samples.push([t, b]);
				if (warmBytes === null && t >= warm) { warmBytes = [t, b]; }
				if (o.onProgress) { o.onProgress(rate(samples, 1000), b, Math.max(t / ms, o.maxBytes ? b / o.maxBytes : 0)); }
				if (t >= ms || (o.maxBytes && b >= o.maxBytes)) { finish(); }
			}, 100);
			function finish(err) {
				if (done) { return; }
				done = true;
				clearInterval(tick);
				var b = total(), t = now() - t0;
				xhrs.forEach(function (x) { try { x.abort(); } catch (e) {} });
				if (err) { reject(err); return; }
				if (!b) { reject(new Error('blocked')); return; }
				var w = warmBytes || [0, 0];
				resolve({ mbps: (b - w[1]) * 8 / ((t - w[0]) / 1000) / 1e6, bytes: b, seconds: t / 1000 });
			}
			if (o.signal) { o.signal.addEventListener('abort', function () { finish(new Error('stopped')); }); }
			for (var j = 0; j < streams; j++) { one(); }
		});
	}

	// Mbps over the last `win` ms of [time, bytes] samples.
	function rate(samples, win) {
		if (samples.length < 2) { return 0; }
		var last = samples[samples.length - 1], first = samples[0];
		for (var i = samples.length - 1; i >= 0; i--) { if (last[0] - samples[i][0] >= win) { first = samples[i]; break; } }
		var dt = (last[0] - first[0]) / 1000;
		return dt > 0 ? (last[1] - first[1]) * 8 / dt / 1e6 : 0;
	}

	/* ---------- Stats and formatting ---------- */
	function stats(list) {
		var v = list.filter(function (x) { return x !== null; }), n = v.length;
		if (!n) { return null; }
		var s = v.slice().sort(function (a, b) { return a - b; }), sum = 0, jit = 0, jn = 0;
		v.forEach(function (x) { sum += x; });
		for (var i = 1; i < list.length; i++) { if (list[i] !== null && list[i - 1] !== null) { jit += Math.abs(list[i] - list[i - 1]); jn++; } }
		var q = function (p) { var k = (n - 1) * p, lo = Math.floor(k), hi = Math.ceil(k); return s[lo] + (s[hi] - s[lo]) * (k - lo); };
		return { n: n, lost: list.length - n, min: s[0], max: s[n - 1], mean: sum / n, median: q(0.5), p95: q(0.95), jitter: jn ? jit / jn : 0 };
	}

	function mbps(v) {
		if (v === null || v === undefined || isNaN(v)) { return '-'; }
		return v >= 100 ? Math.round(v).toString() : v >= 10 ? v.toFixed(1) : v.toFixed(2);
	}
	function ms(v) { return v === null || v === undefined || isNaN(v) ? '-' : (v < 10 ? v.toFixed(1) : Math.round(v)) + ' ms'; }
	function bytes(b) { return b >= 1e9 ? (b / 1e9).toFixed(2) + ' GB' : b >= 1e6 ? Math.round(b / 1e6) + ' MB' : Math.round(b / 1e3) + ' kB'; }

	var regionNames = null;
	function country(code) {
		if (!code) { return ''; }
		try {
			regionNames = regionNames || new Intl.DisplayNames(['en'], { type: 'region' });
			return regionNames.of(code.toUpperCase()) || code;
		} catch (e) { return code; }
	}

	/* DNS over HTTPS, JSON API (Cloudflare and Google both allow browsers). */
	var RESOLVERS = {
		cloudflare: { name: 'Cloudflare (1.1.1.1)', url: 'https://cloudflare-dns.com/dns-query' },
		google: { name: 'Google (8.8.8.8)', url: 'https://dns.google/resolve' }
	};
	function dns(name, type, resolver, extraParams) {
		var r = RESOLVERS[resolver] || RESOLVERS.cloudflare, ctrl = new AbortController(), tid = timeout(8000, ctrl), t0 = now();
		var url = r.url + '?name=' + encodeURIComponent(name) + '&type=' + encodeURIComponent(type) + (extraParams || '');
		return fetch(url, { headers: { accept: 'application/dns-json' }, cache: 'no-store', signal: ctrl.signal }).then(function (res) {
			if (!res.ok) { throw new Error('http ' + res.status); }
			return res.json();
		}).then(function (d) {
			clearTimeout(tid);
			d.ms = now() - t0;
			return d;
		});
	}

	window.TNNet = {
		CF: CF, ping: ping, pingOpaque: pingOpaque, meta: meta, ipv4: ipv4, ipv6: ipv6, owner: owner,
		download: download, upload: upload, stats: stats, fmtMbps: mbps, fmtMs: ms, fmtBytes: bytes, country: country,
		dns: dns, RESOLVERS: RESOLVERS, sleep: function (t) { return new Promise(function (r) { setTimeout(r, t); }); }
	};
}());
