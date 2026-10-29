<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Internet, Browser & System Tests',
	'seo_title'   => 'Internet & System Tests: Speed, Ping, IP, DNS & Browser',
	'description' => 'Free internet and system tests: check your internet speed and ping, find your IP address, look up DNS, test for VPN leaks and see your browser and GPU details.',
	'intro'       => 'Everything about your connection and the device you are on, tested in the browser: internet speed, ping and jitter, your public IP address, DNS records and the fastest DNS server, VPN leaks, your browser version and features, graphics card and WebGL, and the full device details support teams ask for.',
	'body'        => '<h2>Test your internet connection</h2>
<p>Start with the <a href="/internet-speed-test/">internet speed test</a>. In about 25 seconds it measures download and upload speed in Mbps, ping and jitter, and how much your ping rises when the line is full (the bufferbloat grade), then says what the connection is good for. If games or calls lag but the speed looks fine, run the <a href="/ping-test/">ping test</a> for 30 or 60 seconds: it draws every reading so you can see spikes and lost requests, and gives a verdict for gaming and video calls.</p>
<p>For a fair result, test once over a network cable or next to the router. If the cable result is close to your plan and Wi-Fi is much slower, the problem is the Wi-Fi, not the line.</p>

<h2>IP address, DNS and VPN checks</h2>
<p><a href="/what-is-my-ip/">What is my IP</a> shows your public IPv4 and IPv6 addresses, the provider that owns them, the rough location websites see and a hint when it looks like a VPN or proxy. The <a href="/webrtc-leak-test/">WebRTC leak test</a> checks whether your browser reveals your real IP through WebRTC while a VPN is on. The <a href="/dns-lookup/">DNS lookup</a> reads A, AAAA, MX, TXT, NS and other records for any domain, compares Cloudflare and Google to see whether a change has spread, and times eight public DNS servers to find the fastest one for you.</p>

<h2>Browser, graphics and device details</h2>
<p><a href="/what-is-my-browser/">What is my browser</a> names your browser and version, checks whether it is up to date and lists 47 web features it does or does not support. The <a href="/what-is-my-user-agent/">user agent</a> page shows the exact string your browser sends, with a parser for any other one. The <a href="/webgl-test/">WebGL test</a> checks WebGL and WebGPU, names your graphics card, warns when hardware acceleration is off and runs a short GPU benchmark. <a href="/device-info/">Device info</a> puts the operating system, screen, CPU threads, memory, GPU, network and battery on one page with a copy button, and <a href="/screen-resolution/">screen resolution</a> shows the real pixel count and scaling. On a phone, <a href="/what-phone-do-i-have/">what phone do I have</a> finds the model.</p>

<h2>Fixing a slow or laggy connection</h2>
<ul>
<li><strong>Slow everywhere:</strong> restart the modem and router, then test over a cable. If the cable result is far below your plan at several times of day, contact your provider with the results.</li>
<li><strong>Slow only on Wi-Fi:</strong> move closer to the router, use the 5 GHz or 6 GHz band, or add a mesh point. Walls and distance are the usual cause.</li>
<li><strong>Lag when others use the internet:</strong> a poor bufferbloat grade. Turn on SQM or QoS in the router.</li>
<li><strong>Sites slow to start loading:</strong> try a faster DNS server from the DNS speed test.</li>
<li><strong>3D sites and browser games stutter:</strong> check the WebGL test says hardware acceleration is on.</li>
</ul>

<h2>Privacy</h2>
<p>The tests run in your browser. The speed and ping tests exchange random data with Cloudflare\'s nearest data center, the IP tools ask Cloudflare, ipify and the internet registries what address your connection uses, and DNS lookups go to Cloudflare or Google over HTTPS. These services see your IP address, as every website you visit does. Testnook does not receive or store any of the results; your speed test history stays in your own browser.</p>',
	'faq'         => array(
		array( 'What is a good internet speed?', 'About 25 Mbps download is enough for one person to stream in 4K and make video calls. A busy household is comfortable from about 100 Mbps with 10 to 20 Mbps upload. Measure yours with the <a href="/internet-speed-test/">internet speed test</a>.' ),
		array( 'What is a good ping?', 'Under 20 ms is excellent, 20 to 50 ms is good for any game, 50 to 100 ms is fine for most uses, and over 100 ms starts to feel slow. The <a href="/ping-test/">ping test</a> also shows jitter and spikes.' ),
		array( 'How do I find my IP address?', 'Open <a href="/what-is-my-ip/">what is my IP</a>. It shows your public address at the top, with IPv4 and IPv6 separately and the provider that owns it.' ),
		array( 'How can I check if my VPN is working?', 'With the VPN on, open what is my IP: the address and location should be the VPN server\'s. Then run the WebRTC leak test to make sure the browser does not reveal your real IP another way.' ),
		array( 'Which browser am I using?', 'Open <a href="/what-is-my-browser/">what is my browser</a>. It shows the name and version, the engine, your operating system and whether an update is due.' ),
		array( 'Do these tests store my data?', 'No. Nothing is sent to Testnook. The third-party services the tests talk to see your IP address while the test runs, as any website does.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
