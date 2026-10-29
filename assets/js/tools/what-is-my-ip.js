/* What is my IP: public IP as Cloudflare sees it, IPv4 and IPv6 separately (ipify), network owner and block from
   RDAP, country/city/time zone where available, a VPN/proxy hint, copy and hide, and an RDAP lookup for any IP. */
(function () {
	'use strict';
	var root = document.querySelector('[data-tool="what-is-my-ip"]');
	if (!root || !window.TNNet) { return; }
	var U = window.TNUtil, N = window.TNNet;
	var $ = function (s) { return root.querySelector(s); };
	var statusEl = $('#ip-status'), main = $('#ip-main'), hide = $('#ip-hide');
	var info = { ip: '', v4: null, v6: null, meta: null, owner: null };
	var HOSTING = /\bvpn\b|proxy|hosting|servers|cloud|data ?cent|datacamp|digitalocean|amazon|\baws\b|google cloud|azure|oracle|\bovh|hetzner|linode|akamai|vultr|choopa|leaseweb|contabo|m247|mullvad|proton ?ag|nordvpn|expressvpn|surfshark|private internet access|cyberghost|packethub|tefincom|zenlayer|cdn77|datapacket|g-core|gcore|stark industries|frantech|scaleway|psychz|quadranet|zscaler|cloudflare|fastly/i;
	// Names that mark a consumer ISP or mobile carrier. An owner that matches neither this nor HOSTING is a company, school or host.
	var ISP = /telecom|telekom|telecomunica|communications|\bcomm?\b|broadband|cable|mobile|wireless|cellular|internet|\bisp\b|fib(er|re)|dsl|telephone|\btel\b|comcast|charter|spectrum|verizon|at&t|\batt\b|t-mobile|sprint|cox|centurylink|lumen|frontier|windstream|mediacom|altice|optimum|suddenlink|rcn|wow|starlink|spacex|rogers|bell canada|telus|shaw|videotron|vodafone|orange|\bbt\b|british telecommunications|virgin|\bsky\b|talktalk|\bee\b|three|\bo2\b|telefonica|movistar|claro|vivo|\btim\b|wind|iliad|free sas|bouygues|\bsfr\b|kpn|ziggo|liberty global|swisscom|proximus|telia|tele2|telenor|elisa|\bdna\b|fastweb|turk telekom|turkcell|vodacom|mtn|safaricom|airtel|bharti|jio|reliance|bsnl|act fibernet|ptcl|nayatel|stormfiber|zong|jazz|ufone|etisalat|\bdu\b|\bstc\b|mobily|zain|ooredoo|china (telecom|unicom|mobile)|chinanet|kddi|ntt|softbank|\bkt\b|sk broadband|lg ?u\+?|chunghwa|hinet|pldt|globe|viettel|vnpt|true internet|\bais\b|maxis|celcom|unifi|tm net|singtel|starhub|\bm1\b|optus|telstra|\btpg\b|spark|\bmts\b|beeline|megafon|rostelecom|ertelecom/i;

	function set(id, v) { var el = $('#' + id); if (el) { el.textContent = v; } }
	function kind(ip) { return ip && ip.indexOf(':') >= 0 ? 'IPv6' : 'IPv4'; }

	function deviceTz() { try { return Intl.DateTimeFormat().resolvedOptions().timeZone || ''; } catch (e) { return ''; } }

	function verdict() {
		var el = $('#ip-vpn'), m = info.meta || {}, o = info.owner || {}, tz = deviceTz(), cls = 'is-ok', title, text;
		var name = (o.name || '') + ' ' + (o.net || '');
		if (m.timezone && tz && m.timezone !== tz) {
			cls = 'is-warn';
			title = 'Looks like a VPN or proxy';
			text = 'Your IP address is in the ' + m.timezone + ' time zone, but this device is set to ' + tz + '. Websites see the location of the IP, not yours.';
		} else if (HOSTING.test(name)) {
			cls = 'is-warn';
			title = 'Looks like a VPN, proxy or data centre';
			text = 'This IP belongs to ' + (o.name || o.net) + ', which runs servers rather than home internet. That usually means a VPN, proxy, iCloud Private Relay or a work network.';
		} else if (!info.owner) {
			cls = '';
			title = 'VPN check not finished';
			text = 'The network owner could not be looked up, so the VPN hint is not available.';
		} else if (!ISP.test(name)) {
			cls = '';
			title = 'Owner: ' + (o.name || o.net) + ' (business or hosting network)';
			text = 'The name does not look like a home or mobile internet provider. This is normal on a work, school or campus network; elsewhere it can mean a VPN or a proxy.';
		} else {
			title = 'Looks like a normal home or mobile connection';
			text = 'This IP belongs to ' + (o.name || o.net) + '. If you expected a VPN to be on, it is not hiding this address.';
		}
		el.className = 'sy-verdict ' + cls;
		el.querySelector('strong').textContent = title;
		el.querySelector('p').textContent = text;
	}

	function render() {
		var m = info.meta || {}, o = info.owner;
		main.textContent = info.ip || 'Not found';
		set('ip-kind', info.ip ? 'Your public ' + kind(info.ip) + ' address' : 'Could not reach the lookup servers');
		set('ip-v4', info.v4 === null ? 'Checking...' : info.v4 || 'None found');
		var note = $('#ip-multi');
		if (note) { note.hidden = !(info.ip && info.v4 && kind(info.ip) === 'IPv4' && info.ip !== info.v4); }
		set('ip-v6', info.v6 === null ? 'Checking...' : info.v6 || 'No IPv6 connection');
		set('ip-loc', [m.city, N.country(m.country)].filter(Boolean).join(', ') || '-');
		set('ip-net', o ? (o.name || o.net || '-') + (m.asn ? ' (AS' + m.asn + ')' : '') : m.asn ? 'AS' + m.asn : 'Looking up...');
		set('ip-block', o && o.start ? o.start + ' - ' + o.end + (o.net ? ' (' + o.net + ')' : '') : '-');
		set('ip-tz', (m.timezone ? m.timezone + ' (from IP), ' : '') + (deviceTz() || '-') + ' (this device)');
		set('ip-colo', m.colo ? 'Cloudflare ' + m.colo : '-');
	}

	function applyHide() {
		U.$$('[data-ip-blur]', root).forEach(function (el) { el.classList.toggle('sy-blur', hide.checked); });
	}
	hide.addEventListener('change', applyHide);

	$('#ip-copy').addEventListener('click', function () {
		if (!info.ip) { return; }
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(info.ip).then(function () { U.status(statusEl, 'IP address copied.', 'ok'); }, function () { U.status(statusEl, 'Copy was blocked. Select the address and copy it by hand.', 'bad'); });
		}
	});

	function load() {
		info = { ip: '', v4: null, v6: null, meta: null, owner: null };
		render();
		U.status(statusEl, 'Looking up your IP address...', '');
		var pm = N.meta().then(function (m) { info.meta = m; info.ip = m.ip; render(); return m.ip; }, function () { return null; });
		var p4 = N.ipv4().then(function (v) { info.v4 = v || ''; render(); return v; });
		var p6 = N.ipv6().then(function (v) { info.v6 = v || ''; render(); return v; });
		Promise.all([pm, p4]).then(function (r) {
			info.ip = info.ip || r[1] || '';
			render();
			if (!info.ip) {
				U.status(statusEl, 'Could not reach the IP lookup servers. An ad blocker or a strict firewall may block them.', 'bad');
				return null;
			}
			return N.owner(info.ip).then(function (o) { info.owner = o; render(); verdict(); });
		}).then(function () {
			return p6;
		}).then(function () {
			if (info.ip) { U.status(statusEl, 'Done. This is the address every website you visit sees right now.', 'ok'); }
		});
	}
	$('#ip-refresh').addEventListener('click', load);

	/* ---------- Look up any IP ---------- */
	var lin = $('#ip-look-in'), lout = $('#ip-look-out');
	function lookup() {
		var v = lin.value.trim();
		lout.innerHTML = '';
		if (!/^[0-9.]{7,15}$/.test(v) && !/^[0-9a-f:]{2,39}$/i.test(v)) { U.status(statusEl, 'Enter an IPv4 address like 8.8.8.8 or an IPv6 address.', 'bad'); return; }
		U.status(statusEl, 'Looking up ' + v + '...', '');
		N.owner(v).then(function (o) {
			if (!o) { U.status(statusEl, 'No registry record found for ' + v + '. Private addresses (192.168.x.x, 10.x.x.x) are not on the internet.', 'bad'); return; }
			[['Owner', o.name || '-'], ['Network name', o.net || '-'], ['Range', o.start ? o.start + ' - ' + o.end : '-'], ['Country (registry)', N.country(o.country) || '-'], ['Registry handle', o.handle || '-']].forEach(function (row) {
				var dt = document.createElement('dt'), dd = document.createElement('dd');
				dt.textContent = row[0];
				dd.textContent = row[1];
				lout.appendChild(dt);
				lout.appendChild(dd);
			});
			lout.hidden = false;
			U.status(statusEl, 'Registry record for ' + v + '.', 'ok');
		});
	}
	$('#ip-look-btn').addEventListener('click', lookup);
	lin.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); lookup(); } });

	load();
}());
