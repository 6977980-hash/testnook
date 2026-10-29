<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Why Is My Upload Speed So Slow? Causes and Fixes',
	'seo_title'   => 'Why Is My Upload Speed So Slow? 8 Causes and How to Fix Them',
	'description' => 'Why upload is much slower than download, how much upload you need for calls, streaming and backups, and eight fixes for an upload speed that is lower than it should be.',
	'blurb'       => 'Why upload is slower than download, how much you need, and what to fix when it is too low.',
	'hub'         => 'system',
	'tool'        => 'internet-speed-test',
	'tools'       => array( 'ping-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Most people notice upload speed only when something goes wrong: a video call that freezes on their side, a stream that buffers for viewers, or a backup that takes all night. Often the upload is exactly what the plan sells, just much lower than the download. Sometimes it really is too slow. Here is how to tell which, and what to do about it.',
	'summary'     => array(
		'Most cable, DSL and mobile plans are <strong>asymmetric</strong>: upload is often a tenth or less of download. Fiber plans are usually symmetric.',
		'Measure over a <strong>cable</strong> with nothing else running and compare the result with the upload in your plan, not with the download.',
		'The usual causes of an upload below the plan: <strong>Wi-Fi</strong>, a <strong>backup or sync</strong> running in the background, a <strong>VPN</strong>, an old router or a router speed limit.',
		'For one HD video call you need about 3 Mbps up; for streaming at 1080p, about 6 to 10 Mbps.',
	),
	'sections'    => array(
		array(
			'Why upload is slower than download',
			'<p>Home internet was designed for people who download much more than they send, so most technologies split the line unevenly. Cable internet gives the upload a small slice of the channel: a "1 Gbps" cable plan often comes with 20 to 50 Mbps up. DSL is similar on a smaller scale, and mobile and fixed wireless also favor download. Fiber is the exception; many fiber plans offer the same speed both ways.</p>
<p>So the first question is not "why is upload slower than download" but "is upload slower than my plan". Check the contract or the provider\'s website for the upload figure, then test.</p>',
			'why-slower',
		),
		array(
			'How to measure it properly',
			'<ol>
<li>Connect the computer to the router with an <strong>Ethernet cable</strong>. Wi-Fi often halves the upload or worse, especially on phones, whose radios transmit at low power.</li>
<li>Pause anything that sends data: cloud backups (OneDrive, Google Drive, iCloud, Dropbox), photo sync on phones, game streams and video calls on other devices.</li>
<li>Run the <a href="/internet-speed-test/">internet speed test</a> two or three times. Look at the upload figure and at <strong>Ping while uploading</strong>.</li>
<li>Repeat at a different time of day. Cable upload in particular slows in the evening when the neighborhood is busy.</li>
</ol>
<p>If the test shows "Upload not measured", an ad blocker, a firewall or a privacy extension is blocking the test upload; allow it for the page or try a guest window.</p>',
			'measure',
		),
		array(
			'Eight causes of slow upload, and the fixes',
			'<ol>
<li><strong>Wi-Fi.</strong> Move closer to the router, use the 5 GHz or 6 GHz band, or use a cable. If a cable is fast and Wi-Fi is slow, the problem is wireless, not the line.</li>
<li><strong>Something else is uploading.</strong> A phone backing up photos or a computer syncing a folder can take the whole upload. Check the router\'s device list or app, and limit upload speed in the backup app\'s settings.</li>
<li><strong>Bufferbloat.</strong> If the speed is fine but calls freeze while anything uploads, the router lets a queue build up. Turn on SQM or QoS; our <a href="/bufferbloat-test-explained/">bufferbloat guide</a> shows how.</li>
<li><strong>A router speed limit.</strong> QoS or bandwidth limits set too low cap the upload. Check that any limit is close to your real line speed.</li>
<li><strong>A VPN.</strong> A VPN adds encryption and a detour through its server, which can cut the upload sharply, especially on far-away servers. Test with the VPN off to compare.</li>
<li><strong>An old router or cable modem.</strong> Older cable modems and routers cannot reach the upload speeds of newer plans. Ask the provider whether your modem supports your plan.</li>
<li><strong>Cables and ports.</strong> A damaged Ethernet cable can drop a gigabit port to 100 Mbps. Look at the link speed in the network settings and swap the cable if it says 100 Mbps.</li>
<li><strong>The line itself.</strong> If a clean test over a cable is far below the plan at several times of day, contact the provider with screenshots. Cable and DSL faults often show up first as low upload.</li>
</ol>',
			'causes',
		),
		array(
			'How much upload speed do you need?',
			'<div class="table-scroll"><table>
<thead><tr><th>Use</th><th>Upload needed</th></tr></thead>
<tbody>
<tr><td>Web, email, messaging</td><td>1 Mbps</td></tr>
<tr><td>HD video call (one person)</td><td>about 3 Mbps</td></tr>
<tr><td>Streaming on Twitch or YouTube at 720p</td><td>about 4 to 6 Mbps</td></tr>
<tr><td>Streaming at 1080p 60 fps</td><td>about 6 to 10 Mbps</td></tr>
<tr><td>Working from home with calls and cloud files</td><td>10 Mbps or more</td></tr>
<tr><td>Backing up large photo or video libraries</td><td>as much as you can get; 100 GB takes about 9 hours at 25 Mbps</td></tr>
</tbody></table></div>
<p>These are for one use at a time; add them up for a household. Keep 20 to 30% spare, because a line that runs at its limit is the one that lags. Our guide to <a href="/what-is-a-good-internet-speed/">what is a good internet speed</a> covers download as well.</p>',
			'how-much',
		),
	),
	'faq'         => array(
		array( 'Is 10 Mbps upload good?', 'It is enough for video calls, working from home and streaming at 1080p for one person. A household with several people on calls at once, or someone streaming, benefits from 20 Mbps or more.' ),
		array( 'Why is my upload fast on a cable but slow on Wi-Fi?', 'Wi-Fi uplink is weaker than the downlink, especially from phones and laptops far from the router. Move closer, use 5 GHz or 6 GHz, or add a mesh point near where you work.' ),
		array( 'Can I increase my upload speed without changing plans?', 'Only up to what the plan provides: use a cable, stop background uploads, update the router and fix bufferbloat. To go beyond the plan you need a plan with more upload, often a fiber plan.' ),
		array( 'Why does my upload drop in the evening?', 'Cable and some wireless networks share capacity between neighbors, and evenings are the busiest time. If the drop is large and happens every day, report it to the provider.' ),
		array( 'Does a VPN slow down upload?', 'Usually a little, sometimes a lot. The VPN encrypts the data and sends it through its server first. Choose a server close to you or test without the VPN to see the difference.' ),
		array( 'Why does the speed test say upload not measured?', 'Something blocked the test upload to Cloudflare, usually an ad blocker, a privacy extension or a company firewall. Allow the page or try a private window without extensions.' ),
	),
	'sources'     => array(
		array( 'FCC: Broadband speed guide', 'https://www.fcc.gov/consumers/guides/broadband-speed-guide' ),
		array( 'YouTube Help: Live encoder settings, bitrates and resolutions', 'https://support.google.com/youtube/answer/2853702' ),
	),
	'ads'         => 'standard',
);
