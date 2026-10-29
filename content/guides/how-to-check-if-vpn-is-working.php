<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Check If Your VPN Is Working (IP, DNS and WebRTC Leaks)',
	'seo_title'   => 'How to Check If Your VPN Is Working: IP, DNS & WebRTC Leaks',
	'description' => 'A five-minute check that your VPN really hides you: compare your IP address, test for WebRTC and DNS leaks, check IPv6 and fix each leak with the right setting.',
	'blurb'       => 'A five-minute check of your IP, WebRTC, DNS and IPv6, and the fix for each kind of VPN leak.',
	'hub'         => 'system',
	'tool'        => 'what-is-my-ip',
	'tools'       => array( 'webrtc-leak-test', 'dns-lookup' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A VPN icon in the corner does not prove that your traffic is protected. Leaks through WebRTC, DNS or IPv6 can reveal your real address while the VPN says "connected". The check below takes about five minutes, needs nothing but a browser, and tells you exactly which part leaks and how to fix it.',
	'summary'     => array(
		'<strong>Compare your IP</strong> with the VPN off and on using <a href="/what-is-my-ip/">what is my IP</a>. With it on, the address, network owner and location should all be the VPN\'s.',
		'Run the <a href="/webrtc-leak-test/">WebRTC leak test</a> with the VPN on. A different public IP through WebRTC is a leak, usually your real one.',
		'Check <strong>IPv6</strong>: if the page shows your provider\'s IPv6 address with the VPN on, IPv6 bypasses the tunnel.',
		'Fix leaks with the VPN\'s <strong>kill switch and leak protection</strong>, no split tunneling for the browser, and IPv6 blocked or tunneled. Test again after each change.',
	),
	'sections'    => array(
		array(
			'What a VPN should hide, and how it leaks',
			'<p>A VPN sends your traffic through an encrypted tunnel to the VPN company\'s server, so websites see that server\'s IP address instead of yours, and your internet provider sees only encrypted data going to the VPN. Three things commonly slip past the tunnel:</p>
<ul>
<li><strong>WebRTC leaks:</strong> the browser\'s video-call technology asks a STUN server which address it sees, sometimes outside the tunnel, and any web page can read the answer.</li>
<li><strong>DNS leaks:</strong> your device keeps asking your provider\'s DNS server for website addresses, so the provider still sees every site name you visit.</li>
<li><strong>IPv6 leaks:</strong> the VPN tunnels only IPv4, while your connection also has IPv6, so IPv6 traffic goes out directly with your real address.</li>
</ul>
<p>There is also the simplest failure: the VPN is connected but the browser is excluded by <strong>split tunneling</strong>, or the tunnel dropped and there is no kill switch to stop traffic.</p>',
			'how-leaks',
		),
		array(
			'Step 1: Note your real IP with the VPN off',
			'<p>Turn the VPN off and open <a href="/what-is-my-ip/">what is my IP</a>. Write down (or screenshot with Hide off, for yourself only) four things: the <strong>IPv4 address</strong>, the <strong>IPv6 address</strong> if there is one, the <strong>network owner</strong> (your provider), and the <strong>location</strong>. This is your baseline: none of it should appear once the VPN is on.</p>',
			'baseline',
		),
		array(
			'Step 2: Turn the VPN on and compare',
			'<p>Connect the VPN, preferably to a server in another country so the difference is obvious, and reload the page. What you should see:</p>
<ul>
<li>A <strong>different IPv4 address</strong>.</li>
<li>A <strong>network owner</strong> that is the VPN company or a hosting provider it rents servers from (names such as M247, Datacamp, Leaseweb or the VPN brand itself). The page\'s VPN check box will usually say "Looks like a VPN, proxy or data center".</li>
<li>A <strong>location</strong> matching the VPN server.</li>
<li>Either <strong>no IPv6</strong>, or an IPv6 address that also belongs to the VPN.</li>
</ul>
<p>If your provider\'s name or your real IPv4 still shows, the browser is not going through the VPN at all. Reconnect, try another server, and check split tunneling (step 5). If only the <strong>IPv6</strong> line still shows your provider\'s address, you have an IPv6 leak.</p>',
			'compare',
		),
		array(
			'Step 3: Test for a WebRTC leak',
			'<p>With the VPN still on, open the <a href="/webrtc-leak-test/">WebRTC leak test</a>. It compares the public IP that STUN servers see through WebRTC with the IP your normal browsing uses.</p>
<ul>
<li><strong>No leak:</strong> WebRTC shows only the VPN\'s address, or none.</li>
<li><strong>Leak found:</strong> WebRTC shows a different public IP. Compare it with your baseline: if it is your real IP, any website can read it without asking.</li>
<li>A local address such as 192.168.1.23, or a random name ending in .local, is not a leak of your public IP. Current browsers hide local IPs by default.</li>
</ul>
<p>WebRTC leaks are most common with browser-only VPN extensions, which proxy web pages but not the UDP traffic WebRTC uses. The standard for how browsers should handle this is RFC 8828; Chrome, Edge, Firefox and Safari now follow its safer modes by default, but a VPN setup can still bypass them.</p>',
			'webrtc',
		),
		array(
			'Step 4: Check for a DNS leak',
			'<p>A DNS leak means that the VPN hides your traffic, but the questions "where is example.com?" still go to your internet provider. The surest check is in the VPN app itself: most have a "DNS leak protection" switch and show which DNS server they use. You can also check from the browser:</p>
<ul>
<li>Open <code>1.1.1.1/help</code> (Cloudflare\'s diagnostic page). It shows whether you are using Cloudflare\'s DNS and which data center answers. If you set Cloudflare DNS but the VPN is supposed to use its own, it should say No.</li>
<li>On a Windows PC, run <code>nslookup example.com</code> in Command Prompt. The "Server" line shows the resolver your system is using. With the VPN on, it should be the VPN\'s address, not your router (192.168.x.x) or your provider.</li>
</ul>
<p>The <a href="/dns-lookup/">DNS lookup</a> tool itself talks to Cloudflare or Google over HTTPS and does not use your system\'s DNS, so it is the right tool for checking records but not for spotting a DNS leak.</p>',
			'dns',
		),
		array(
			'Step 5: Fix what leaks',
			'<ul>
<li><strong>Turn on the kill switch</strong> (sometimes called Network Lock). It blocks all internet traffic if the tunnel drops, so nothing goes out unprotected.</li>
<li><strong>Turn on DNS leak protection</strong> and, if offered, the VPN\'s own DNS servers. On Android, set Private DNS to Automatic or Off while using a VPN that provides its own DNS.</li>
<li><strong>Check split tunneling.</strong> Make sure your browser is not on the list of apps that bypass the VPN.</li>
<li><strong>Handle IPv6.</strong> Turn on the VPN\'s IPv6 leak protection, or choose a VPN that tunnels IPv6. As a last resort, turn off IPv6 in the network adapter settings.</li>
<li><strong>Block WebRTC leaks.</strong> Use the desktop app rather than only a browser extension, turn on the extension\'s WebRTC protection, or in Firefox set <code>media.peerconnection.enabled</code> to false in <code>about:config</code> (this turns off browser video calls). The WebRTC leak test page lists the setting for each browser.</li>
<li><strong>Update the VPN app and switch protocol</strong> (WireGuard or OpenVPN) if a leak keeps returning.</li>
</ul>
<p>After every change, repeat steps 2 to 4. A VPN that still leaks with all protections on is not doing its job.</p>',
			'fix',
		),
		array(
			'What a VPN does not hide',
			'<p>Even a leak-free VPN hides only your IP address and your traffic from the local network and provider. Websites still recognize you when you log in, cookies and browser fingerprints still work, and your <a href="/what-is-my-browser/">browser</a> and <a href="/device-info/">device details</a> are visible to every site. A VPN also slows your connection a little: run the <a href="/internet-speed-test/">internet speed test</a> with it on and off to see the cost.</p>',
			'limits',
		),
	),
	'faq'         => array(
		array( 'How do I know if my VPN is on?', 'Open what is my IP with the VPN connected. If the address and location are the VPN server\'s and the network owner is not your provider, it is working for your browser.' ),
		array( 'What is a VPN leak?', 'Any traffic that reveals your real IP address or the sites you visit despite the VPN: most often through WebRTC, DNS requests or IPv6.' ),
		array( 'Can websites see my real IP with a VPN?', 'Not if the VPN works and nothing leaks. With a WebRTC or IPv6 leak, a website can read your real address without asking.' ),
		array( 'Do free VPNs leak more?', 'Leak tests often find more problems with free VPNs and browser extensions, which may skip WebRTC, DNS or IPv6 protection. Test any VPN yourself rather than relying on claims.' ),
		array( 'Is a WebRTC leak dangerous?', 'It reveals your real IP to any site that checks, which defeats the purpose of the VPN for privacy. It does not give access to your device.' ),
		array( 'Should I check every time I connect?', 'Check after installing a VPN, after updates, and when you change networks or settings. A quick look at what is my IP each time you connect takes seconds.' ),
	),
	'sources'     => array(
		array( 'RFC 8828: WebRTC IP Address Handling Requirements', 'https://www.rfc-editor.org/rfc/rfc8828' ),
	),
	'ads'         => 'standard',
);
