<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'What Is My IP Address?',
	'seo_title'      => 'What Is My IP Address? See Your IPv4, IPv6 & Network',
	'description'    => 'See your public IP address instantly: IPv4 and IPv6, the network that owns it, its rough location and a check for a VPN or proxy. Copy or hide it in one tap.',
	'intro'          => 'This is the address every website sees when you visit it. The page shows your public IPv4 and IPv6 addresses, the internet provider or company that owns the address block, its rough location, and whether it looks like a VPN or proxy. You can also look up any other IP address.',
	'trust'          => 'Nothing is sent to Testnook',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'system' ),
	'scripts'        => array( 'net', 'what-is-my-ip' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-stage sy-stage">
	<div class="sy-hero"><small id="ip-kind">Your public IP address</small><strong id="ip-main" data-ip-blur>Looking up...</strong></div>
	<div class="btn-row"><button type="button" class="btn btn-primary" id="ip-copy">Copy IP address</button><button type="button" class="btn" id="ip-refresh">Check again</button><label class="btn btn-sm"><input type="checkbox" id="ip-hide"> Hide (for screenshots)</label></div>
	<dl class="sy-meta">
		<dt>IPv4 address</dt><dd><span id="ip-v4" data-ip-blur>-</span><small id="ip-multi" class="sy-note" hidden> Your network uses more than one exit address.</small></dd>
		<dt>IPv6 address</dt><dd id="ip-v6" data-ip-blur>-</dd>
		<dt>Location (from IP)</dt><dd id="ip-loc">-</dd>
		<dt>Network owner</dt><dd id="ip-net">-</dd>
		<dt>Address block</dt><dd id="ip-block" data-ip-blur>-</dd>
		<dt>Time zone</dt><dd id="ip-tz">-</dd>
		<dt>Nearest data centre</dt><dd id="ip-colo">-</dd>
	</dl>
	<div class="sy-verdict" id="ip-vpn"><strong>Checking for a VPN or proxy...</strong><p>This takes a second.</p></div>
	<p class="sy-label">Look up another IP address</p>
	<div class="dn-form"><input type="text" id="ip-look-in" placeholder="e.g. 8.8.8.8" inputmode="text" autocomplete="off" spellcheck="false" aria-label="IP address to look up"><button type="button" class="btn" id="ip-look-btn">Look up</button></div>
	<dl class="sy-meta" id="ip-look-out" hidden></dl>
</div>
<p class="tool-status" id="ip-status" aria-live="polite">Looking up your IP address...</p>',
	'howto'          => array(
		'Open the page. Your public IP address appears at the top within a second or two.',
		'Press <strong>Copy IP address</strong> to paste it into a support chat, a game server whitelist or a router setting.',
		'Check the <strong>IPv4</strong> and <strong>IPv6</strong> lines. Many connections have both; "No IPv6 connection" means your provider or router only uses IPv4.',
		'Read the <strong>VPN or proxy</strong> box. If you turned a VPN on, the network owner should be the VPN company and the location should be the VPN server\'s.',
		'Tick <strong>Hide</strong> before taking a screenshot to blur the addresses.',
	),
	'howto_title'    => 'How to find your IP address',
	'results'        => '<ul>
<li><strong>Public IP address</strong> is the one the internet sees. At home it belongs to your router, so every phone and laptop on the same Wi-Fi shares it. On mobile data it often changes when you reconnect.</li>
<li><strong>IPv4</strong> addresses look like <code>203.0.113.45</code>. <strong>IPv6</strong> addresses look like <code>2001:db8:85a3::8a2e:370:7334</code>. When both work, browsers usually prefer IPv6, so the address at the top can be either.</li>
<li><strong>Network owner</strong> comes from the regional internet registry (ARIN, RIPE, APNIC, LACNIC or AFRINIC) that hands out address blocks. For a home line it names your provider or its parent company; the AS number identifies the network on the internet.</li>
<li><strong>Location</strong> is where the IP is registered or routed, often the nearest big city of your provider, not your street. It can be hundreds of kilometres off, and is wrong on purpose with a VPN.</li>
<li><strong>Time zone</strong> compares the zone of the IP (when available) with the clock on this device. A mismatch is a common sign of a VPN.</li>
</ul>',
	'extra'          => array(
		array(
			'Public IP vs private (local) IP',
			'<p>Your device has two kinds of address. The <strong>public IP</strong> shown here is given by your internet provider to your router. Inside your home, the router hands each device a <strong>private IP</strong>, usually starting with <code>192.168.</code>, <code>10.</code> or <code>172.16-31.</code>. Private addresses are reused in millions of homes and never appear on the internet, so websites cannot see them.</p>
<p>To find your private IP: on Windows, open Settings > Network & internet > Wi-Fi > your network > Properties; on a Mac, System Settings > Wi-Fi > Details; on Android, Settings > About phone > Status (or the Wi-Fi network details); on iPhone, Settings > Wi-Fi > tap the (i) next to the network. The <a href="/webrtc-leak-test/">WebRTC leak test</a> also shows whether your browser exposes it.</p>',
			'public-vs-private',
		),
		array(
			'What someone can do with your IP address',
			'<p>An IP address reveals your provider and a rough area, usually the city or region, not your home address. Only your provider can link it to your account, and it shares that only with police and courts under a legal order. Websites use it to block spam, choose a language and show local content. Someone who knows it could try to flood your connection in an online game (a DDoS), which is why some gamers use a VPN. If you share it in a screenshot, nothing serious usually happens, but there is no reason to: use the Hide option.</p>
<p>To change your public IP, restart your router (many providers give a new address after a while), switch between Wi-Fi and mobile data, or use a VPN. Check this page again afterwards to confirm.</p>',
			'privacy',
		),
	),
	'fixes'          => array(
		array( 'My VPN is on but my real IP shows', 'The VPN is not routing browser traffic. Reconnect it, check that it is not in "split tunnelling" mode for your browser, and turn on its kill switch. Then run the <a href="/webrtc-leak-test/">WebRTC leak test</a> as well.' ),
		array( 'The location is in the wrong city', 'IP locations come from databases that map address blocks to places, and providers often route a whole region through one city. It does not affect your internet. If a website shows the wrong country, contact your provider or the website.' ),
		array( 'No IPv6 connection', 'Your provider or router does not give out IPv6 addresses, or it is turned off in the router. IPv4 alone works fine for almost everything today. Look for an IPv6 setting in the router\'s WAN or internet settings if you need it.' ),
		array( 'The page says it cannot reach the lookup servers', 'A strict ad blocker, a firewall or a work or school network may block them. Allow speed.cloudflare.com and api.ipify.org, or try another network.' ),
	),
	'faq'            => array(
		array( 'What is my IP address?', 'It is shown at the top of this page: the public address your connection uses on the internet right now. Every website you visit sees it.' ),
		array( 'Is my IP address the same on every device at home?', 'Yes, for the public IP. Your phone, laptop and TV share the router\'s public address on the same Wi-Fi. Each has its own private IP inside the network. On mobile data your phone gets a different public IP.' ),
		array( 'Does my IP address show my exact location?', 'No. It shows the area your provider routes the address through, usually a city or region, sometimes far from you. Your street address is known only to your provider.' ),
		array( 'What is the difference between IPv4 and IPv6?', 'IPv4 is the older format with about 4.3 billion addresses, written as four numbers like 203.0.113.45. IPv6 has vastly more addresses and is written in hexadecimal with colons. Most connections now use both.' ),
		array( 'Why does my IP address change?', 'Most home and mobile plans use dynamic addresses that the provider can change when the router or phone reconnects. A fixed (static) IP is usually an extra on business plans.' ),
		array( 'Does Testnook store my IP address?', 'No. The lookups go from your browser to Cloudflare, ipify and the internet registries, the same way any website sees your IP. This page does not save or log the result.' ),
	),
	'related'        => array( 'webrtc-leak-test', 'internet-speed-test', 'ping-test', 'dns-lookup', 'what-is-my-browser', 'device-info', 'what-is-my-user-agent', 'gps-test' ),
	'updated'        => '2026-10-29',
);
