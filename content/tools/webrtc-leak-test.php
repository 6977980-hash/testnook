<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'WebRTC Leak Test',
	'seo_title'      => 'WebRTC Leak Test: Is Your VPN Leaking Your Real IP?',
	'description'    => 'Free WebRTC leak test. See whether your browser reveals your real or local IP address through WebRTC while a VPN is on, and how to stop it in each browser.',
	'intro'          => 'A VPN hides your IP address from websites, but a browser feature called WebRTC can still reveal it. This test asks public STUN servers which address they see from your browser and compares it with the address your normal browsing uses. If they differ while your VPN is on, your real IP is leaking.',
	'trust'          => 'Nothing is sent to Testnook',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'system' ),
	'scripts'        => array( 'net', 'webrtc-leak-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-stage sy-stage">
	<div class="sy-verdict" id="wr-verdict"><strong>Starting the test...</strong><p>It takes a few seconds.</p></div>
	<dl class="sy-meta"><dt>Your IP for normal browsing</dt><dd id="wr-http">-</dd><dt>Public IP seen through WebRTC</dt><dd id="wr-rtc">-</dd></dl>
	<div id="wr-table" hidden>
		<p class="sy-label">Every address WebRTC found</p>
		<div class="sy-scroll"><table class="sy-table"><thead><tr><th>Address</th><th>Type</th><th>Meaning</th><th>Why</th></tr></thead><tbody id="wr-body"></tbody></table></div>
	</div>
	<div class="btn-row"><button type="button" class="btn btn-primary" id="wr-start">Test again</button><a class="btn" href="/what-is-my-ip/">What is my IP</a></div>
</div>
<p class="tool-status" id="wr-status" aria-live="polite">Running the WebRTC leak test...</p>',
	'howto'          => array(
		'Turn your VPN on and connect to a server, then open or reload this page. The test runs by itself.',
		'Check <strong>Your IP for normal browsing</strong>. With a VPN on, this should be the VPN server\'s address, not your home one.',
		'Read the verdict. <strong>Leak found</strong> means WebRTC shows a public IP that is not your browsing IP, which is usually your real address.',
		'For a baseline, run it once with the VPN off: both lines should then show your home IP, and the verdict says "No leak".',
		'If there is a leak, follow the fixes below and press <strong>Test again</strong>.',
	),
	'howto_title'    => 'How to test for a WebRTC leak',
	'results'        => '<ul>
<li><strong>No leak</strong>: WebRTC only shows the same public IP websites already see. If that is the VPN\'s address, the VPN covers WebRTC too.</li>
<li><strong>Leak found</strong>: WebRTC shows a public IP that normal requests do not use. With a VPN on, that is almost always your real IP, which any website could read with a few lines of code.</li>
<li><strong>Local address (hidden)</strong>: a random name ending in <code>.local</code>. Modern Chrome, Edge, Firefox and Safari hide your local IP this way unless a site has camera or microphone permission. This is safe.</li>
<li><strong>Local network IP</strong>: an address like <code>192.168.1.23</code>. It is not your public IP and cannot be used to reach you, but it adds detail to a browser fingerprint.</li>
<li><strong>WebRTC is turned off</strong>: no addresses can leak, but video calls that run in the browser (Google Meet, Teams on the web, Discord in a browser) will not work.</li>
</ul>',
	'extra'          => array(
		array(
			'What WebRTC is and why it can leak',
			'<p>WebRTC is the browser technology behind video calls, screen sharing and file transfer in the browser. To connect two people directly, the browser asks a <strong>STUN server</strong>: "what address do you see me coming from?". That question goes out over UDP, which some VPN apps do not route through the tunnel, or which the operating system sends out of the normal network card. The STUN server then sees your real public IP, and the web page can read the answer. No permission prompt is shown, which is why this leak surprised so many VPN users when it was found in 2015.</p>
<p>Most good VPN apps now block it, and browsers have reduced it, but it still happens with browser VPN extensions that only proxy web traffic, with split tunnelling, and with some free VPNs.</p>',
			'what-is-webrtc',
		),
		array(
			'How to stop a WebRTC leak',
			'<ul>
<li><strong>VPN app:</strong> turn on its leak protection or kill switch, turn off split tunnelling for the browser, and use the desktop app rather than only a browser extension.</li>
<li><strong>Chrome and Edge:</strong> there is no built-in switch. Install the official <strong>WebRTC Network Limiter</strong> extension from Google, or your VPN\'s extension with "WebRTC leak protection" turned on.</li>
<li><strong>Firefox:</strong> type <code>about:config</code> in the address bar, accept the warning, search <code>media.peerconnection.enabled</code> and set it to <strong>false</strong>. This turns WebRTC off completely.</li>
<li><strong>Brave:</strong> Settings > Privacy and security > WebRTC IP handling policy > "Disable non-proxied UDP".</li>
<li><strong>Safari:</strong> Safari already hides local IPs and does not leak through STUN in normal use; keep macOS or iOS up to date.</li>
</ul>
<p>Run the test again after each change. Then check your <a href="/what-is-my-ip/">IP address</a> and use the <a href="/dns-lookup/">DNS tools</a> if you also want to confirm your DNS goes through the VPN.</p>',
			'fix',
		),
	),
	'fixes'          => array(
		array( 'Leak found with the VPN on', 'Turn on the VPN\'s leak protection or kill switch, make sure the browser is not excluded by split tunnelling, and add WebRTC protection in the browser as described above. Test again.' ),
		array( 'Both lines show my home IP even with the VPN on', 'The VPN is not routing the browser at all, which is a bigger problem than WebRTC. Reconnect the VPN, try another server, and check <a href="/what-is-my-ip/">what is my IP</a>.' ),
		array( 'Video calls stopped working after the fix', 'Turning WebRTC off in Firefox or with an extension also blocks browser calls. Use the call app instead, or allow WebRTC only for the call site in the extension settings.' ),
		array( 'The test shows no public IP at all', 'Your network or firewall blocks STUN (common on work and school networks), or the browser limits WebRTC. Nothing can leak in that case.' ),
	),
	'faq'            => array(
		array( 'What is a WebRTC leak?', 'It happens when WebRTC, the browser\'s video call technology, reveals your real IP address to a website while a VPN is supposed to hide it.' ),
		array( 'Does my VPN protect against WebRTC leaks?', 'Most paid VPN apps do when their leak protection is on. Browser-only VPN or proxy extensions often do not. This test shows the answer for your setup.' ),
		array( 'Is showing my local IP a problem?', 'Only a small one. Local IPs like 192.168.x.x are shared by millions of home networks and cannot be used to reach you, but they add a detail that helps track a browser. Current browsers hide them by default.' ),
		array( 'Should I turn off WebRTC?', 'Only if a leak remains after fixing the VPN and you do not use video calls in the browser. Turning it off breaks browser-based calls and screen sharing.' ),
		array( 'Can websites really read my IP through WebRTC?', 'Yes. Any page can run a few lines of JavaScript to gather WebRTC addresses without asking you, which is exactly what this test does.' ),
		array( 'Does this test store my IP address?', 'No. The STUN servers (Google and Cloudflare) and the IP lookup services see your address, as any website does, but this page does not save or send the results anywhere.' ),
	),
	'related'        => array( 'what-is-my-ip', 'dns-lookup', 'internet-speed-test', 'ping-test', 'what-is-my-browser', 'device-info', 'what-is-my-user-agent', 'webgl-test' ),
	'updated'        => '2026-10-29',
);
