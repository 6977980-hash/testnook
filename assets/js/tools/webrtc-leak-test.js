/* WebRTC leak test: gathers ICE candidates through public STUN servers (Google, Cloudflare), lists host
   (local / mDNS), srflx (public, as STUN sees it) and relay addresses, and compares the public ones with the
   IPs that normal web requests come from (TNNet). An IP that only WebRTC reveals is a leak. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="webrtc-leak-test"]');
	if (!root || !window.TNNet) { return; }
	var U = window.TNUtil, N = window.TNNet;
	var $ = function (s) { return root.querySelector(s); };
	var statusEl = $('#wr-status'), body = $('#wr-body'), startBtn = $('#wr-start');

	function isPrivate(ip) {
		return /^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[01])\.|169\.254\.|127\.|100\.(6[4-9]|[7-9]\d|1[01]\d|12[0-7])\.)/.test(ip) || /^(fc|fd|fe80)/i.test(ip) || ip === '::1';
	}
	// IPv6 devices use several addresses in the same /64 (privacy addresses), so compare the prefix for IPv6.
	function prefix64(ip) {
		var parts = ip.split('::'), head = parts[0] ? parts[0].split(':') : [], tail = parts[1] ? parts[1].split(':') : [];
		var g = head.slice();
		for (var i = head.length + tail.length; i < 8; i++) { g.push('0'); }
		return g.concat(tail).slice(0, 4).map(function (x) { return parseInt(x, 16); }).join(':');
	}
	function seen(addr, http) {
		return http.some(function (h) { return h === addr || (h.indexOf(':') >= 0 && addr.indexOf(':') >= 0 && prefix64(h) === prefix64(addr)); });
	}
	function verdict(cls, title, text) {
		var el = $('#wr-verdict');
		el.className = 'sy-verdict ' + cls;
		el.querySelector('strong').textContent = title;
		el.querySelector('p').textContent = text;
	}

	function gather() {
		return new Promise(function (resolve) {
			var found = [], pc;
			try {
				pc = new RTCPeerConnection({ iceServers: [{ urls: 'stun:stun.l.google.com:19302' }, { urls: 'stun:stun.cloudflare.com:3478' }] });
			} catch (e) { resolve(null); return; }
			var done = false;
			function finish() {
				if (done) { return; }
				done = true;
				try { pc.close(); } catch (e) {}
				resolve(found);
			}
			pc.onicecandidate = function (e) {
				if (!e.candidate) { finish(); return; }
				var c = e.candidate.candidate || '', parts = c.split(' ');
				// candidate:<foundation> <component> <protocol> <priority> <address> <port> typ <type> ...
				if (parts.length < 8) { return; }
				var addr = parts[4], type = parts[7], proto = parts[2].toLowerCase();
				if (!found.some(function (x) { return x.addr === addr && x.type === type; })) { found.push({ addr: addr, type: type, proto: proto }); }
			};
			pc.onicegatheringstatechange = function () { if (pc.iceGatheringState === 'complete') { finish(); } };
			pc.createDataChannel('tn');
			pc.createOffer().then(function (o) { return pc.setLocalDescription(o); }).catch(finish);
			setTimeout(finish, 6000);
		});
	}

	function label(c, http) {
		if (/\.local$/i.test(c.addr)) { return ['Local address (hidden)', 'The browser hides your local IP behind a random .local name. This is safe.', 'sy-ok']; }
		if (c.type === 'host') {
			return isPrivate(c.addr) ? ['Local network IP', 'Your device\'s address inside your home or office network. Sites cannot reach it, but it can help fingerprint you.', ''] : ['Public IP on this device', 'This device has a public address directly.', seen(c.addr, http) ? '' : 'sy-bad'];
		}
		if (c.type === 'srflx' || c.type === 'prflx') {
			return seen(c.addr, http) ? ['Public IP (matches)', 'The same address websites already see. No leak.', 'sy-ok'] : ['Public IP (different)', 'WebRTC reveals an address that normal web requests do not use. This is a leak if a VPN is on.', 'sy-bad'];
		}
		return ['Relay', 'A relay server address.', ''];
	}

	function render(cands, http) {
		body.innerHTML = '';
		cands.forEach(function (c) {
			var l = label(c, http), tr = document.createElement('tr');
			[c.addr, c.type + ' / ' + c.proto, l[0], l[1]].forEach(function (v, i) {
				var td = document.createElement('td');
				if (i === 0) { var code = document.createElement('code'); code.textContent = v; td.appendChild(code); } else { td.textContent = v; }
				if (i === 2 && l[2]) { td.className = l[2]; }
				tr.appendChild(td);
			});
			body.appendChild(tr);
		});
		$('#wr-table').hidden = !cands.length;
	}

	function run() {
		startBtn.disabled = true;
		body.innerHTML = '';
		verdict('', 'Testing...', 'Asking STUN servers which address they see, and comparing it with your normal IP.');
		U.status(statusEl, 'Running the WebRTC leak test...', '');
		var httpP = Promise.all([N.meta().then(function (m) { return m.ip; }, function () { return null; }), N.ipv4(), N.ipv6()]);
		Promise.all([gather(), httpP]).then(function (r) {
			var cands = r[0], http = r[1].filter(Boolean).filter(function (v, i, a) { return a.indexOf(v) === i; });
			startBtn.disabled = false;
			startBtn.textContent = 'Test again';
			$('#wr-http').textContent = http.length ? http.join(', ') : 'Could not be checked';
			if (cands === null) {
				verdict('is-ok', 'No leak: WebRTC is turned off', 'This browser has WebRTC disabled (by a setting or an extension), so it cannot reveal any address. Video calls in the browser will not work while it is off.');
				U.status(statusEl, 'WebRTC is not available in this browser.', 'ok');
				return;
			}
			render(cands, http);
			var pub = cands.filter(function (c) { return (c.type === 'srflx' || c.type === 'prflx' || (c.type === 'host' && !isPrivate(c.addr))) && !/\.local$/i.test(c.addr); });
			var leaks = http.length ? pub.filter(function (c) { return !seen(c.addr, http); }) : [];
			var localIps = cands.filter(function (c) { return c.type === 'host' && !/\.local$/i.test(c.addr) && isPrivate(c.addr); });
			$('#wr-rtc').textContent = pub.length ? pub.map(function (c) { return c.addr; }).filter(function (v, i, a) { return a.indexOf(v) === i; }).join(', ') : 'None found';
			if (leaks.length) {
				verdict('is-bad', 'Leak found: WebRTC shows a different IP', 'WebRTC reveals ' + leaks.map(function (c) { return c.addr; }).join(', ') + ', which is not the address your browsing uses. If a VPN is on, this is probably your real IP. See the fixes below.');
			} else if (!http.length) {
				verdict('is-warn', 'Could not compare', 'Your normal IP could not be looked up (the lookup servers may be blocked), so the WebRTC addresses below cannot be compared.');
			} else if (!pub.length) {
				verdict('is-ok', 'No leak: no public IP through WebRTC', 'WebRTC did not reveal any public address. Either STUN is blocked on this network or the browser limits WebRTC. ' + (localIps.length ? 'It does show your local network IP, which is a small privacy risk.' : ''));
			} else {
				verdict('is-ok', 'No leak', 'WebRTC shows the same public IP that websites already see' + (localIps.length ? '. Your local network IP is visible, which is a small fingerprinting risk.' : ', and your local IP is hidden.') + ' If a VPN is on and this is the VPN\'s address, it is protecting you.');
			}
			U.status(statusEl, 'Done. ' + cands.length + ' WebRTC address' + (cands.length === 1 ? '' : 'es') + ' found.', 'ok');
		});
	}
	startBtn.addEventListener('click', run);
	run();
}());
