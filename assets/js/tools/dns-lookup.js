/* DNS lookup: DNS over HTTPS (JSON API) at Cloudflare or Google, one record type or all common ones, both resolvers
   side by side, reverse lookup for IPs, status and DNSSEC flags. Resolver speed: wire-format DoH GET requests
   (RFC 8484) timed to eight public resolvers; opaque responses are enough for timing. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="dns-lookup"]');
	if (!root || !window.TNNet) { return; }
	var U = window.TNUtil, N = window.TNNet;
	var $ = function (s) { return root.querySelector(s); };
	var statusEl = $('#dn-status'), input = $('#dn-name'), typeSel = $('#dn-type'), out = $('#dn-out');
	var resolver = 'cloudflare';
	var TYPES = { 1: 'A', 2: 'NS', 5: 'CNAME', 6: 'SOA', 12: 'PTR', 15: 'MX', 16: 'TXT', 28: 'AAAA', 33: 'SRV', 46: 'RRSIG', 48: 'DNSKEY', 257: 'CAA', 65: 'HTTPS' };
	var STATUS = { 0: 'NOERROR (found)', 1: 'FORMERR', 2: 'SERVFAIL (the domain\'s DNS is broken or DNSSEC failed)', 3: 'NXDOMAIN (no such domain)', 5: 'REFUSED' };
	var ALL = ['A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT', 'SOA', 'CAA'];

	U.$$('[data-dn-res]', root).forEach(function (b) {
		b.addEventListener('click', function () {
			resolver = b.getAttribute('data-dn-res');
			U.$$('[data-dn-res]', root).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
		});
	});

	// Accepts a domain, a URL or an IP; returns [name, forcedType].
	function normalise(v) {
		v = v.trim();
		if (!v) { return null; }
		if (/^\d{1,3}(\.\d{1,3}){3}$/.test(v)) { return [v.split('.').reverse().join('.') + '.in-addr.arpa', 'PTR']; }
		if (/^[0-9a-f:]+$/i.test(v) && v.indexOf(':') >= 0) { return [ipv6Arpa(v), 'PTR']; }
		try {
			var host = new URL(/^[a-z]+:\/\//i.test(v) ? v : 'http://' + v).hostname;
			return host && host.indexOf('.') > 0 ? [host.replace(/\.$/, ''), null] : null;
		} catch (e) { return null; }
	}
	function ipv6Arpa(v) {
		var parts = v.split('::'), head = parts[0] ? parts[0].split(':') : [], tail = parts[1] ? parts[1].split(':') : [];
		var groups = head.slice();
		for (var i = head.length + tail.length; i < 8; i++) { groups.push('0'); }
		groups = groups.concat(tail);
		var hex = groups.map(function (g) { return ('0000' + g).slice(-4); }).join('');
		return hex.split('').reverse().join('.') + '.ip6.arpa';
	}

	function table(rows) {
		var wrap = document.createElement('div'), t = document.createElement('table');
		wrap.className = 'sy-scroll';
		t.className = 'sy-table';
		t.innerHTML = '<thead><tr><th>Type</th><th>Name</th><th>TTL</th><th>Value</th></tr></thead>';
		var body = document.createElement('tbody');
		rows.forEach(function (r) {
			var tr = document.createElement('tr');
			[TYPES[r.type] || String(r.type), String(r.name).replace(/\.$/, ''), ttl(r.TTL), r.data].forEach(function (v, i) {
				var td = document.createElement('td');
				if (i === 3) { var c = document.createElement('code'); c.textContent = v; td.appendChild(c); } else { td.textContent = v; }
				tr.appendChild(td);
			});
			body.appendChild(tr);
		});
		t.appendChild(body);
		wrap.appendChild(t);
		return wrap;
	}
	function ttl(s) {
		s = +s;
		return s >= 86400 ? Math.round(s / 3600) + ' h' : s >= 3600 ? (s / 3600).toFixed(s % 3600 ? 1 : 0) + ' h' : s >= 60 ? Math.round(s / 60) + ' min' : s + ' s';
	}

	// Runs every type in `types` on one resolver; resolves to {rows, status, ad, ms, error}.
	function query(name, types, res) {
		return Promise.all(types.map(function (t) {
			return N.dns(name, t, res).then(function (d) { return d; }, function () { return null; });
		})).then(function (list) {
			var rows = [], seen = {}, status = null, ad = true, ms = 0, ok = 0;
			list.forEach(function (d) {
				if (!d) { return; }
				ok++;
				ms = Math.max(ms, d.ms);
				if (status === null || (d.Status !== 0 && d.Status !== 3)) { status = d.Status; }
				if (!d.AD) { ad = false; }
				(d.Answer || []).forEach(function (a) {
					// "All" mode: CNAME chains appear in every answer; keep one copy.
					var k = a.type + '|' + a.name + '|' + a.data;
					if (seen[k]) { return; }
					seen[k] = 1;
					rows.push(a);
				});
			});
			return { rows: rows, status: status, ad: ad && ok > 0, ms: ms, error: ok === 0 };
		});
	}

	function flags(r, label) {
		var p = document.createElement('p');
		p.className = 'dn-flags';
		[[label, ''], ['Status', STATUS[r.status] || String(r.status)], ['DNSSEC', r.ad ? 'validated' : 'not signed or not validated'], ['Time', Math.round(r.ms) + ' ms']].forEach(function (f) {
			var s = document.createElement('span');
			if (!f[1]) { var b0 = document.createElement('b'); b0.textContent = f[0]; s.appendChild(b0); } else { s.textContent = f[0] + ': '; var b = document.createElement('b'); b.textContent = f[1]; s.appendChild(b); }
			p.appendChild(s);
		});
		return p;
	}

	function sig(rows) { return rows.map(function (r) { return r.type + ' ' + String(r.data).toLowerCase(); }).sort().join('\n'); }

	function run() {
		var n = normalise(input.value);
		out.innerHTML = '';
		if (!n) { U.status(statusEl, 'Enter a domain name like example.com, a web address or an IP address.', 'bad'); return; }
		var name = n[0], t = n[1] || typeSel.value, types = t === 'ALL' ? ALL : [t];
		var list = resolver === 'both' ? ['cloudflare', 'google'] : [resolver];
		U.status(statusEl, 'Looking up ' + (t === 'ALL' ? 'all common records' : t + ' records') + ' for ' + name + '...', '');
		Promise.all(list.map(function (res) { return query(name, types, res); })).then(function (results) {
			if (results.every(function (r) { return r.error; })) {
				U.status(statusEl, 'The DNS servers could not be reached. An ad blocker or firewall may block DNS over HTTPS.', 'bad');
				return;
			}
			results.forEach(function (r, i) {
				var label = N.RESOLVERS[list[i]].name;
				out.appendChild(flags(r, label));
				if (r.rows.length) { out.appendChild(table(r.rows)); }
				else {
					var p = document.createElement('p');
					p.className = 'sy-note';
					p.textContent = r.error ? 'No answer from this resolver.' : r.status === 3 ? 'This domain does not exist in DNS.' : 'No ' + (t === 'ALL' ? '' : t + ' ') + 'records found.';
					out.appendChild(p);
				}
			});
			var msg = 'Done.';
			if (results.length === 2 && !results[0].error && !results[1].error) {
				var same = sig(results[0].rows) === sig(results[1].rows);
				msg = same ? 'Both resolvers return the same answer.' : 'The answers differ: a DNS change may still be spreading, or the domain gives different answers by location (common for big sites and CDNs).';
			}
			U.status(statusEl, msg, 'ok');
		});
	}
	$('#dn-go').addEventListener('click', run);
	input.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); run(); } });
	U.$$('[data-dn-example]', root).forEach(function (a) {
		a.addEventListener('click', function (e) {
			e.preventDefault();
			input.value = a.getAttribute('data-dn-example');
			typeSel.value = a.getAttribute('data-dn-t') || 'ALL';
			run();
		});
	});

	/* ---------- Resolver speed ---------- */
	var SPEED = [
		['Cloudflare', '1.1.1.1', 'https://cloudflare-dns.com/dns-query'],
		['Google', '8.8.8.8', 'https://dns.google/dns-query'],
		['Quad9', '9.9.9.9', 'https://dns.quad9.net/dns-query'],
		['AdGuard', '94.140.14.14', 'https://dns.adguard-dns.com/dns-query'],
		['OpenDNS', '208.67.222.222', 'https://doh.opendns.com/dns-query'],
		['NextDNS', '45.90.28.0', 'https://dns.nextdns.io/dns-query'],
		['Mullvad', '194.242.2.2', 'https://dns.mullvad.net/dns-query'],
		['Control D', '76.76.2.0', 'https://freedns.controld.com/p0']
	];
	var NAMES = ['google.com', 'youtube.com', 'wikipedia.org', 'amazon.com', 'facebook.com', 'microsoft.com'];

	function wire(name) {
		var bytes = [0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0];
		name.split('.').forEach(function (l) { bytes.push(l.length); for (var i = 0; i < l.length; i++) { bytes.push(l.charCodeAt(i)); } });
		bytes.push(0, 0, 1, 0, 1);
		var s = '';
		bytes.forEach(function (b) { s += String.fromCharCode(b); });
		return btoa(s).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
	}
	function timeOne(url, name) {
		var ctrl = new AbortController(), t0 = performance.now(), tid = setTimeout(function () { ctrl.abort(); }, 3000);
		return fetch(url + '?dns=' + wire(name), { mode: 'no-cors', cache: 'no-store', signal: ctrl.signal }).then(function () {
			clearTimeout(tid);
			return performance.now() - t0;
		}, function () { clearTimeout(tid); return null; });
	}
	var speedBtn = $('#dn-speed'), speedOut = $('#dn-speed-body');
	speedBtn.addEventListener('click', function () {
		speedBtn.disabled = true;
		speedOut.innerHTML = '';
		$('#dn-speed-wrap').hidden = false;
		U.status(statusEl, 'Timing ' + SPEED.length + ' public DNS resolvers...', '');
		var results = [];
		// One resolver at a time so they do not compete for the line.
		SPEED.reduce(function (p, r) {
			return p.then(function () {
				return timeOne(r[2], 'example.com').then(function () {
					var times = [];
					return NAMES.reduce(function (q, nm) {
						return q.then(function () { return timeOne(r[2], nm).then(function (v) { times.push(v); }); });
					}, Promise.resolve()).then(function () {
						var s = N.stats(times);
						results.push({ r: r, med: s ? s.median : null, lost: s ? s.lost : times.length });
						draw(results);
					});
				});
			});
		}, Promise.resolve()).then(function () {
			speedBtn.disabled = false;
			var ok = results.filter(function (x) { return x.med !== null; }).sort(function (a, b) { return a.med - b.med; });
			U.status(statusEl, ok.length ? 'Fastest from here: ' + ok[0].r[0] + ' (' + N.fmtMs(ok[0].med) + ').' : 'No resolver answered. DNS over HTTPS may be blocked on this network.', ok.length ? 'ok' : 'bad');
		});
	});
	function draw(results) {
		var ok = results.filter(function (x) { return x.med !== null; }), max = Math.max.apply(null, ok.map(function (x) { return x.med; }).concat([1]));
		var sorted = results.slice().sort(function (a, b) { return (a.med === null) - (b.med === null) || a.med - b.med; });
		speedOut.innerHTML = '';
		sorted.forEach(function (x) {
			var tr = document.createElement('tr'), a = document.createElement('td'), b = document.createElement('td'), c = document.createElement('td'), d = document.createElement('td'), bar = document.createElement('span');
			a.textContent = x.r[0];
			b.textContent = x.r[1];
			c.textContent = x.med === null ? 'No answer' : N.fmtMs(x.med);
			bar.className = 'dn-bar';
			bar.style.width = x.med === null ? '0' : Math.max(2, x.med / max * 100) + '%';
			d.appendChild(bar);
			[a, b, c, d].forEach(function (td) { tr.appendChild(td); });
			speedOut.appendChild(tr);
		});
	}

	U.status(statusEl, 'Enter a domain and press Look up. Lookups go straight from your browser to the DNS resolver you pick.', '');
}());
