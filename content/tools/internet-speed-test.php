<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Internet Speed Test',
	'seo_title'      => 'Internet Speed Test: Check Download, Upload & Ping',
	'description'    => 'Free internet speed test. Measure your download and upload speed in Mbps, ping, jitter and lag under load, and see what your connection is really good for.',
	'intro'          => 'Check how fast your internet really is. One tap measures ping and jitter, then download and upload speed in Mbps, and how much your ping rises while the line is busy (bufferbloat). It takes about 25 seconds and tells you what the result means for streaming, calls and gaming.',
	'trust'          => 'Nothing is sent to Testnook',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'system' ),
	'scripts'        => array( 'net', 'internet-speed-test' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage sy-stage">
	<div class="st-dial">
		<svg viewBox="0 0 220 124" aria-hidden="true"><path class="st-track" d="M 20 112 A 90 90 0 0 1 200 112"/><path class="st-arc" id="st-arc" d="M 20 112 A 90 90 0 0 1 200 112"/></svg>
		<div class="st-read"><strong id="st-big">0</strong><span id="st-phase">Ready</span></div>
	</div>
	<div class="st-progress"><span id="st-bar"></span></div>
	<div class="btn-row sy-center"><button type="button" class="btn btn-primary" id="st-start">Start speed test</button><label class="btn btn-sm"><input type="checkbox" id="st-saver"> Data saver (shorter test)</label></div>
	<div class="stats sy-stats4">
		<div class="stat"><span class="stat-label">Download</span><span class="stat-value" id="st-down">-</span></div>
		<div class="stat"><span class="stat-label">Upload</span><span class="stat-value" id="st-up">-</span></div>
		<div class="stat"><span class="stat-label">Ping</span><span class="stat-value" id="st-ping">-</span></div>
		<div class="stat"><span class="stat-label">Jitter</span><span class="stat-value" id="st-jitter">-</span></div>
		<div class="stat"><span class="stat-label">Ping while downloading</span><span class="stat-value" id="st-ldown">-</span></div>
		<div class="stat"><span class="stat-label">Ping while uploading</span><span class="stat-value" id="st-lup">-</span></div>
		<div class="stat"><span class="stat-label">Bufferbloat grade</span><span class="stat-value" id="st-grade">-</span></div>
		<div class="stat"><span class="stat-label">Data used</span><span class="stat-value" id="st-data">-</span></div>
	</div>
	<dl class="sy-meta"><dt>Test server</dt><dd id="st-server">-</dd><dt>Your network</dt><dd id="st-net">-</dd></dl>
	<div id="st-good-wrap" hidden>
		<p class="sy-label">What this connection is good for</p>
		<ul class="st-good" id="st-good"></ul>
		<p class="sy-note">A 50 GB game download would take about <strong id="st-50gb">-</strong> at this speed.</p>
	</div>
	<div id="st-hist" hidden>
		<p class="sy-label">Your last tests (saved in this browser only)</p>
		<div class="sy-scroll"><table class="sy-table st-hist"><thead><tr><th>When</th><th>Down (Mbps)</th><th>Up (Mbps)</th><th>Ping</th><th>Jitter</th></tr></thead><tbody id="st-hist-body"></tbody></table></div>
		<button type="button" class="btn btn-sm" id="st-hist-clear">Clear history</button>
	</div>
</div>
<p class="tool-status" id="st-status" aria-live="polite">Close downloads and video on this device, then press Start. The test moves data for about 18 seconds (around 200 MB on a 100 Mbps line), so tick Data saver on mobile data.</p>',
	'howto'          => array(
		'Pause anything else using the connection: downloads, game updates, cloud backups and video on this device or others at home.',
		'Press <strong>Start speed test</strong>. The page measures ping first, then download for about 10 seconds, then upload for about 8 seconds.',
		'Read the <strong>Download</strong> and <strong>Upload</strong> results in megabits per second (Mbps), and the <strong>Ping</strong> and <strong>Jitter</strong> in milliseconds.',
		'Check <strong>Ping while downloading</strong> and the <strong>Bufferbloat grade</strong>: a big rise means calls and games lag whenever someone else uses the internet.',
		'For a fair picture, test a few times at different hours and once with a cable instead of Wi-Fi. Your last ten results are listed under the test.',
	),
	'howto_title'    => 'How to test your internet speed',
	'results'        => '<ul>
<li><strong>Download (Mbps)</strong> is how fast data reaches you: streaming, web pages, game downloads. 25 Mbps handles one 4K stream; a family that streams, games and calls at the same time is comfortable from about 100 Mbps.</li>
<li><strong>Upload (Mbps)</strong> is how fast you send data: your video in calls, cloud backups, posting videos. 3 Mbps is enough for an HD call; many home plans upload far slower than they download.</li>
<li><strong>Ping</strong> is the time for a small message to reach the test server and come back. Under 20 ms is excellent, 20 to 50 ms is good, 50 to 100 ms is fine for most things, and over 100 ms is noticeable in fast games.</li>
<li><strong>Jitter</strong> is how much the ping changes from one message to the next. Under 10 ms is smooth; over 30 ms causes choppy calls and rubber-banding in games.</li>
<li><strong>Ping while downloading and uploading</strong> shows what happens when the line is full. If ping jumps from 15 ms to 300 ms, your router lets a queue build up. That is bufferbloat, graded A+ (under 5 ms extra) to F (over 400 ms extra).</li>
</ul>
<p>The test runs against the nearest Cloudflare data center (named under the results), which is close to most people, so the numbers show what your line can do. Speeds to a far-away server, or to a busy website, can be lower.</p>',
	'extra'          => array(
		array(
			'Why your speed test result is lower than your plan',
			'<p>Internet plans are sold as "up to" a speed, and several things sit between that number and what you measure:</p>
<ul>
<li><strong>Wi-Fi.</strong> The biggest cause by far. Walls, distance and neighbors on the same channel can cut a 500 Mbps line to 50 Mbps in the next room. Test once with a network cable or next to the router; if the cable result is close to your plan, the line is fine and the Wi-Fi is the limit.</li>
<li><strong>Other devices.</strong> A console downloading an update or a phone backing up photos takes a share of the line while you test.</li>
<li><strong>The device itself.</strong> Older phones, laptops with 100 Mbps network ports and browsers busy with many tabs cannot always reach gigabit speeds.</li>
<li><strong>Busy hours.</strong> Evenings from about 7 to 11 pm are peak time on cable and shared fiber networks. A big drop only at those hours points to congestion at your provider.</li>
<li><strong>VPNs.</strong> A VPN routes traffic through its own servers, which adds distance and often caps speed. Test with it off to compare.</li>
</ul>',
			'slower-than-plan',
		),
		array(
			'Mbps, MB/s and how the test works',
			'<p>Speeds are shown in <strong>megabits per second (Mbps)</strong>, the unit providers use. Download progress in a browser or game launcher is usually in <strong>megabytes per second (MB/s)</strong>. There are 8 bits in a byte, so divide Mbps by 8: a 100 Mbps line downloads at about 12.5 MB/s.</p>
<p>The test opens several connections at once and downloads data for about 10 seconds, then uploads for about 8. The first couple of seconds are left out because connections need a moment to speed up. While data flows, a small message is timed every 0.4 seconds to measure the loaded ping. The data is random filler: nothing on your device is read or sent, and the test server only sees the requests, like any website you visit. Your last ten results stay in this browser only.</p>',
			'how-it-works',
		),
	),
	'fixes'          => array(
		array( 'Speed is much lower on Wi-Fi than on a cable', 'Move closer to the router, or lift it off the floor and out of cupboards. Use the 5 GHz or 6 GHz band for speed (2.4 GHz reaches further but is slower). In large homes a mesh system or a wired access point beats a plug-in extender.' ),
		array( 'Ping jumps when someone else uses the internet', 'That is bufferbloat. Turn on Smart Queue Management (SQM), "QoS" or "Adaptive QoS" in the router settings, and set it to about 90% of your measured speeds. Many recent routers have this; the grade usually improves to A or B.' ),
		array( 'Speed is fine on the cable but slow in the evenings', 'Test at several hours over a few days and keep the results (they are listed under the test). A consistent drop at peak time is congestion on the provider\'s side; send them the list.' ),
		array( 'The test does not start or stops with an error', 'Some ad blockers, firewalls and school or office networks block speed test servers. Allow speed.cloudflare.com, or try another network to compare.' ),
	),
	'faq'            => array(
		array( 'What is a good internet speed?', 'For one person, 25 Mbps download handles HD and 4K streaming and calls. A household that streams, games and works from home at the same time is comfortable from about 100 Mbps, with at least 10 to 20 Mbps upload. See our guide on <a href="/what-is-a-good-internet-speed/">what a good internet speed is</a>.' ),
		array( 'What is a good ping for gaming?', 'Under 20 ms is excellent, 20 to 50 ms is good for any game, 50 to 100 ms is playable for most games, and over 100 ms is noticeable in shooters and fighting games. Low jitter matters as much as low ping. The <a href="/ping-test/">ping test</a> watches it for longer.' ),
		array( 'Why is my upload speed so much lower than my download?', 'Most cable, DSL and many fiber plans are asymmetric: they give far more capacity to download than upload because most people download more. Full fiber plans often have equal speeds. Check your plan details.' ),
		array( 'How much data does a speed test use?', 'It depends on your speed, because the test runs for a fixed time. At 20 Mbps it uses about 40 MB, at 100 Mbps about 200 MB and on a gigabit line over 1 GB. Tick Data saver for a shorter test on mobile data.' ),
		array( 'Is this speed test accurate?', 'It measures the real speed between your device and the nearest Cloudflare data center, with several connections at once, like other major speed tests. Results from different tests differ a little because each uses different servers and methods. Testing over a cable gives the truest view of the line itself.' ),
		array( 'Does the speed test see my data or location?', 'No files or personal data are read or sent. The test server, like any website, sees your IP address while the test runs, and the page shows the city and network that IP belongs to. Nothing is stored by Testnook; your result history stays in your browser.' ),
	),
	'related'        => array( 'ping-test', 'what-is-my-ip', 'dns-lookup', 'webrtc-leak-test', 'device-info', 'what-is-my-browser', 'zoom-test', 'webgl-test' ),
	'updated'        => '2026-10-29',
);
