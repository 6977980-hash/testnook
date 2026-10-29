<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Reduce Ping and Fix Lag Spikes',
	'seo_title'   => 'How to Reduce Ping and Fix Lag Spikes in Online Games',
	'description' => 'Ten fixes for high ping and lag spikes, from a network cable and router QoS to closer game servers, in order of impact, plus how to check what each one changed.',
	'blurb'       => 'The fixes that lower ping and stop lag spikes, in the order that usually helps most.',
	'hub'         => 'system',
	'tool'        => 'ping-test',
	'tools'       => array( 'internet-speed-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'High ping and sudden lag spikes almost always come from a handful of causes: Wi-Fi, other traffic on the line, the router\'s queue, or a far-away server. The fixes below are ordered by how much they usually help. Measure before and after each one with the ping test, so you know which change actually worked.',
	'summary'     => array(
		'<strong>Use a network cable.</strong> Moving from Wi-Fi to Ethernet removes most spikes and often 5 to 20 ms of ping.',
		'<strong>Stop the line filling up.</strong> Pause downloads, cloud backups and streams on other devices, or turn on <strong>SQM or QoS</strong> in the router to fix bufferbloat.',
		'<strong>Pick the closest game server</strong> and close background apps. Distance to the server is often the biggest part of in-game ping.',
		'Check each change with the <a href="/ping-test/">ping test</a>: median ping, jitter and lost requests should all fall.',
	),
	'sections'    => array(
		array(
			'First, find out where the lag comes from',
			'<p>Run the <a href="/ping-test/">ping test</a> for 30 seconds three times: on your usual Wi-Fi, over a cable (or right next to the router), and on Wi-Fi while another device streams a video. Then run the <a href="/internet-speed-test/">internet speed test</a> and look at its bufferbloat grade.</p>
<ul>
<li><strong>Bad on Wi-Fi, fine on a cable:</strong> the problem is wireless. Start with fixes 1 and 2.</li>
<li><strong>Fine when quiet, bad while others use the internet</strong> (or a bufferbloat grade of C or worse): the router lets a queue build up. Fixes 3 and 4.</li>
<li><strong>Fine in the test, high only in one game:</strong> the server is far or busy. Fix 5.</li>
<li><strong>Bad everywhere, even on a quiet cable:</strong> the connection or provider. Fixes 8 to 10.</li>
</ul>',
			'diagnose',
		),
		array(
			'1 and 2: Fix the Wi-Fi or skip it',
			'<p><strong>1. Use an Ethernet cable.</strong> It is the most reliable fix for gaming. Wi-Fi shares the air with every other device and neighbor, has to retry lost frames, and briefly pauses to scan for networks, which shows up as spikes. A cable avoids all of that. If the router is in another room, a long flat cable or a pair of <strong>powerline adapters</strong> (network over the mains wiring) is still usually steadier than Wi-Fi; mesh systems with a wired backhaul are the next best thing.</p>
<p><strong>2. If you must use Wi-Fi, make it as clean as possible.</strong> Connect to the 5 GHz or 6 GHz band rather than 2.4 GHz, keep the router high and in the open, and avoid playing through several walls. Turn off other devices you are not using. Some laptops pause Wi-Fi now and then to scan for other networks, which shows up as regular spikes; updating the Wi-Fi driver often helps. Test again after each change.</p>',
			'wifi',
		),
		array(
			'3 and 4: Stop other traffic from causing lag',
			'<p><strong>3. Pause the heavy users.</strong> A game update on a console, a phone backing up photos, a 4K stream or a large upload can all fill the line. Game consoles and PC launchers also download updates in the background; schedule them for the night. Cloud backup apps (OneDrive, Google Drive, iCloud) usually have a setting to limit upload speed.</p>
<p><strong>4. Turn on SQM or QoS in the router.</strong> Bufferbloat happens when the router holds large queues of packets while the line is busy, so your small game packets wait behind them. Smart Queue Management (SQM, often using the fq_codel or CAKE algorithms) keeps those queues short. Many routers call it QoS, Adaptive QoS, Smart Queue or Gaming mode. Set the limits to about 85 to 95% of the speeds you measured; you give up a little bandwidth and gain steady ping. After turning it on, the bufferbloat grade in the speed test should improve to A or B.</p>
<p>Device prioritization ("put my console first") helps a bit on some routers but does not fix bufferbloat on its own; SQM is the setting that does.</p>',
			'traffic',
		),
		array(
			'5 to 7: Game and computer settings',
			'<p><strong>5. Choose the closest server.</strong> Every 1,000 km of distance adds roughly 10 ms of round-trip time. Most games let you pick a region or show the ping to each one; choose the lowest, not the one with the most players. In matchmaking games, a strict ping limit (if offered) keeps you on nearby servers.</p>
<p><strong>6. Close background apps.</strong> Browsers with many tabs, streaming apps, voice chat with video, torrent clients and cloud sync all send traffic. On a PC, check Task Manager > Performance > Ethernet or Wi-Fi to see whether something is using the network.</p>
<p><strong>7. Do not confuse ping with frame rate.</strong> Low FPS or a slow display also feels like lag but has nothing to do with the internet. If the game shows low ping but feels delayed, check your frames with the <a href="/fps-test/">FPS test</a> and the input delay of your mouse with the <a href="/mouse-latency-test/">mouse latency test</a>.</p>',
			'settings',
		),
		array(
			'8 to 10: The connection itself',
			'<p><strong>8. Restart the modem and router.</strong> Unplug both for 30 seconds. It clears overheating, memory leaks and stuck connections, which can cause random spikes. Update the router firmware while you are at it.</p>
<p><strong>9. Check cables and the line.</strong> A damaged Ethernet cable, a loose coax connector or a noisy phone line causes packet loss. If the ping test shows lost requests on a cable with nothing else running, swap the cable first, then contact your provider with screenshots taken at different times. They can test the line from their side.</p>
<p><strong>10. Consider the connection type.</strong> If you are on DSL, mobile or older satellite, the technology itself sets a floor for ping. Fiber gives the lowest and steadiest latency, followed by cable. A 5G home connection can be fine but varies with signal and tower load.</p>',
			'connection',
		),
		array(
			'Things that rarely help',
			'<ul>
<li><strong>Paying for a faster plan</strong> lowers ping only if your line was full. If the speed test shows plenty of headroom, extra Mbps change nothing in a game.</li>
<li><strong>Changing DNS</strong> speeds up how quickly websites and matchmaking start, but does not change the ping during a match. (It is still worth trying for slow page loads; see <a href="/how-to-change-dns-server/">how to change your DNS server</a>.)</li>
<li><strong>"Ping booster" apps and gaming VPNs</strong> help only when your provider routes traffic to a particular game server badly. Usually a VPN adds a stop and raises ping. If you try one, measure in-game ping with and without it.</li>
<li><strong>Registry tweaks</strong> such as Nagle\'s algorithm changes made sense for some old games but do nothing for most modern ones.</li>
</ul>',
			'myths',
		),
	),
	'faq'         => array(
		array( 'Why does my ping spike every few seconds?', 'Regular spikes usually come from Wi-Fi (background network scans, interference) or another device uploading. Test on a cable; if the spikes stop, it is the Wi-Fi.' ),
		array( 'Does a better router lower ping?', 'A router with good SQM or QoS can greatly reduce lag spikes when the line is busy, and a newer Wi-Fi standard can steady wireless ping. It cannot shorten the distance to the server.' ),
		array( 'Can a VPN lower my ping?', 'Rarely. It helps only if your provider routes traffic to a game server the long way. In most cases it adds a stop and raises ping by 5 to 50 ms.' ),
		array( 'Why is my ping high only at night?', 'Evening is peak time: more people at home share the provider\'s network, and your own household uses more. SQM helps with your own household; provider congestion needs a complaint or a different provider.' ),
		array( 'Do powerline adapters have good ping?', 'Usually better and steadier than Wi-Fi through several walls, but slightly worse than a direct cable. Results depend on the wiring; test with the ping test.' ),
		array( 'What ping should I aim for?', 'Under 50 ms with jitter under 10 ms and no packet loss is a good target for any game. See <a href="/what-is-a-good-ping/">what is a good ping</a> for the full ranges.' ),
	),
	'sources'     => array(
		array( 'Bufferbloat.net: Introduction to bufferbloat', 'https://www.bufferbloat.net/projects/bloat/wiki/Introduction/' ),
	),
	'ads'         => 'standard',
);
