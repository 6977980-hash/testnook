<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'What Is a Good Internet Speed? Mbps Explained',
	'seo_title'   => 'What Is a Good Internet Speed? Download & Upload Explained',
	'description' => 'How many Mbps you really need for streaming, gaming, video calls and working from home, why upload and ping matter, and how to tell if your plan is too slow.',
	'blurb'       => 'How many Mbps you need for streaming, calls, gaming and a busy home, and when upload and ping matter more.',
	'hub'         => 'system',
	'tool'        => 'internet-speed-test',
	'tools'       => array( 'ping-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Internet plans are sold by one big number, the download speed in megabits per second (Mbps), but that number alone does not tell you whether video calls will be smooth or games will lag. This guide gives practical speeds for each activity, explains how to add them up for a household, and shows which other numbers on a speed test matter.',
	'summary'     => array(
		'For <strong>one person</strong>, 25 Mbps download handles 4K streaming, video calls and browsing. Netflix recommends 15 Mbps for 4K and YouTube 20 Mbps.',
		'A <strong>household</strong> that streams, games and works from home at the same time is comfortable from about <strong>100 Mbps download and 10 to 20 Mbps upload</strong>.',
		'<strong>Upload</strong> decides how you look in video calls and how fast backups run. 3 Mbps per HD call is the minimum; many plans upload far slower than they download.',
		'Speed is not everything: <strong>ping under 50 ms and low jitter</strong> matter more for games and calls. Measure all of it with the <a href="/internet-speed-test/">internet speed test</a>.',
	),
	'sections'    => array(
		array(
			'Mbps, download and upload in plain words',
			'<p>Internet speed is the amount of data your connection moves each second. Providers measure it in <strong>megabits per second (Mbps)</strong>; a gigabit line is 1,000 Mbps. Download managers and game launchers usually show <strong>megabytes per second (MB/s)</strong> instead. One byte is eight bits, so divide by eight: 100 Mbps is about 12.5 MB/s, which downloads a 50 GB game in a little under an hour and a half.</p>
<p><strong>Download</strong> speed is data coming to you: websites, streaming, app and game downloads. <strong>Upload</strong> speed is data you send: your camera in a video call, photos backing up to the cloud, files sent to work, a live stream. Most activities download far more than they upload, which is why cable, DSL and many fiber plans give much more download than upload. A plan sold as "500 Mbps" may upload at only 20 or 50 Mbps.</p>',
			'basics',
		),
		array(
			'How much speed each activity needs',
			'<p>These are the speeds one stream or one person needs, based on what the services themselves recommend, with a little headroom:</p>
<table><thead><tr><th>Activity</th><th>Download</th><th>Upload</th></tr></thead><tbody>
<tr><td>Email, web browsing, music streaming</td><td>1 to 5 Mbps</td><td>under 1 Mbps</td></tr>
<tr><td>HD video, 1080p (Netflix, YouTube)</td><td>5 Mbps</td><td>-</td></tr>
<tr><td>4K video (Netflix 15, YouTube 20 Mbps)</td><td>15 to 25 Mbps</td><td>-</td></tr>
<tr><td>HD video call (Zoom, Teams, Meet)</td><td>3 to 4 Mbps</td><td>3 to 4 Mbps</td></tr>
<tr><td>Online gaming</td><td>3 to 10 Mbps</td><td>1 to 3 Mbps</td></tr>
<tr><td>Cloud gaming (GeForce Now, Xbox Cloud) in 1080p</td><td>20 to 25 Mbps</td><td>1 to 3 Mbps</td></tr>
<tr><td>Streaming yourself on Twitch or YouTube in 1080p</td><td>-</td><td>6 to 10 Mbps</td></tr>
</tbody></table>
<p>Two things stand out. Online gaming needs surprisingly little speed: a match sends small updates many times a second, so a 10 Mbps line plays as well as a gigabit one if the ping is low. What eats bandwidth in gaming is downloading games and updates, which are often 50 to 150 GB. Video calls, on the other hand, need real upload, and that is where many home lines fall short when two people work from home.</p>',
			'by-activity',
		),
		array(
			'How to work out what your home needs',
			'<p>Add up what happens <strong>at the same time</strong> at the busiest hour, usually the evening, and add about 25% headroom for background traffic like phone backups and updates. A few examples:</p>
<ul>
<li><strong>One person</strong> who streams, browses and makes calls: 25 to 50 Mbps download, 5 Mbps upload.</li>
<li><strong>A couple working from home</strong> with two video calls at once and a TV in the evening: about 50 to 100 Mbps download and at least 10 Mbps upload.</li>
<li><strong>A family of four</strong> with two 4K TVs, a gaming console, two phones on social video and a laptop on a call: 100 to 200 Mbps download and 20 Mbps upload or more.</li>
<li><strong>Heavy downloaders and content creators</strong> who move large files or stream: 300 Mbps to 1 Gbps, ideally on fiber with matching upload.</li>
</ul>
<p>For comparison, in 2024 the US regulator FCC raised its definition of a basic broadband connection to 100 Mbps download and 20 Mbps upload. That is a sensible target for a typical household today, and more than enough for most single-person homes.</p>',
			'household',
		),
		array(
			'Ping, jitter and bufferbloat: the numbers that cause lag',
			'<p>Download speed tells you how much data fits through the pipe. <strong>Ping</strong> (latency) tells you how long each piece takes to arrive, and that is what you feel in games and calls. Under 20 ms is excellent, 20 to 50 ms is good, 50 to 100 ms is fine for most things, and over 100 ms is noticeable in fast games. <strong>Jitter</strong>, the change in ping from moment to moment, should stay under about 10 ms for smooth calls.</p>
<p>The most common hidden problem is <strong>bufferbloat</strong>: ping is low when the line is quiet but jumps to hundreds of milliseconds as soon as someone downloads or uploads. A speed test that only reports Mbps misses it. The Testnook <a href="/internet-speed-test/">internet speed test</a> measures ping while downloading and uploading and gives a grade; if it is C or worse, turning on SQM or QoS in your router often fixes lag without paying for a faster plan. The <a href="/ping-test/">ping test</a> watches latency over a full minute to catch spikes.</p>',
			'latency',
		),
		array(
			'Why your speed test is lower than your plan',
			'<p>A plan sold as "up to 300 Mbps" rarely shows exactly 300 on every test. Results within about 10 to 20% of the plan over a cable are normal. Bigger gaps usually have one of these causes:</p>
<ul>
<li><strong>Wi-Fi.</strong> The most common bottleneck by far. Distance, walls and crowded channels can turn a fast line into 30 to 50 Mbps in a far room. Test next to the router or over an Ethernet cable to see the real line speed.</li>
<li><strong>Old hardware.</strong> Routers, network adapters and laptops with 100 Mbps ports, or old Wi-Fi 4 (802.11n) devices, cap the speed no matter what the plan is.</li>
<li><strong>Peak hours.</strong> Evening congestion on cable and shared networks. If the cable result drops only between about 7 and 11 pm, it is the provider\'s network.</li>
<li><strong>Other devices.</strong> A console updating or a computer backing up takes its share while you test.</li>
<li><strong>VPNs.</strong> They route traffic through a distant server and often cap speed.</li>
</ul>
<p>To make a fair complaint to your provider, run the test over a cable at three or four different times on two or three days and keep the results. The speed test saves your last ten results in the browser for exactly this.</p>',
			'lower-than-plan',
		),
		array(
			'Do you need gigabit internet?',
			'<p>Most homes do not. A single 4K stream uses about 15 to 25 Mbps, so even five at once fit in 150 Mbps. Gigabit makes a real difference in only a few cases: downloading very large games or files often, uploading large files for work (on a symmetric fiber plan), or a big household where many people do heavy things at the same time. It also helps only if your Wi-Fi and devices can use it; many phones and laptops top out at 300 to 600 Mbps over Wi-Fi.</p>
<p>Before upgrading, check whether the problem is speed at all. If pages and calls feel slow but your speed test shows plenty of Mbps, the cause is more likely Wi-Fi coverage, high ping or bufferbloat. Fixing those is cheaper than a faster plan and often makes a bigger difference.</p>',
			'gigabit',
		),
	),
	'faq'         => array(
		array( 'Is 100 Mbps good internet?', 'Yes. 100 Mbps download handles several 4K streams, gaming and video calls at the same time for a typical family. Check that the upload is at least 10 to 20 Mbps if people work from home.' ),
		array( 'Is 50 Mbps fast enough for gaming?', 'Yes. Online games need only a few Mbps; ping and jitter matter far more. 50 Mbps mainly affects how long game downloads and updates take.' ),
		array( 'What is a good upload speed?', 'At least 3 Mbps per person on a video call, 10 Mbps for a home with two people working remotely, and 20 Mbps or more for streaming yourself or uploading large files.' ),
		array( 'How much speed do I need for 4K streaming?', 'Netflix recommends 15 Mbps and YouTube 20 Mbps per 4K stream. Allow about 25 Mbps per stream to be safe when other devices are online.' ),
		array( 'Why is my Wi-Fi slower than my plan?', 'Wi-Fi loses speed with distance, walls and interference from neighbors. Test next to the router or with a cable. If that result matches your plan, improve the Wi-Fi rather than the plan.' ),
		array( 'How often should I test my internet speed?', 'Test whenever something feels slow, and a few times at different hours if you plan to complain to your provider or change plans, so you have a clear pattern rather than one result.' ),
	),
	'sources'     => array(
		array( 'Netflix Help Center: Netflix-recommended internet speeds', 'https://help.netflix.com/en/node/306' ),
		array( 'YouTube Help: System requirements', 'https://support.google.com/youtube/answer/78358' ),
		array( 'Zoom Support: system requirements and bandwidth', 'https://support.zoom.com/hc/en/article?id=zm_kb&sysparm_article=KB0060748' ),
	),
	'ads'         => 'standard',
);
