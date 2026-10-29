<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'What Is a Good Ping? Latency for Gaming and Calls',
	'seo_title'   => 'What Is a Good Ping for Gaming? Latency & Jitter Explained',
	'description' => 'What ping is, what counts as good for gaming, video calls and streaming, why jitter and packet loss matter just as much, and what makes your ping high.',
	'blurb'       => 'Ping ranges for gaming and calls, why jitter matters as much, and where high latency really comes from.',
	'hub'         => 'system',
	'tool'        => 'ping-test',
	'tools'       => array( 'internet-speed-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Ping is the number that decides whether a shot lands when you click or a moment later, and whether people in a call talk over each other. It is measured in milliseconds, and lower is better. Here is what counts as good for each use, what the other two numbers next to it mean, and why your ping in a game is often higher than on a speed test.',
	'summary'     => array(
		'<strong>Under 20 ms</strong> is excellent, <strong>20 to 50 ms</strong> is good for any game, <strong>50 to 100 ms</strong> is fine for most uses, and <strong>over 100 ms</strong> is noticeable in fast games.',
		'<strong>Jitter</strong> (how much ping changes) should stay under about 10 ms, and <strong>packet loss</strong> should be 0%. A steady 60 ms plays better than a jumpy 25 ms.',
		'Video calls tolerate more: the ITU recommends keeping one-way delay under 150 ms, which means a round-trip ping under about 300 ms, but lower feels more natural.',
		'Your ping in a game also includes the distance to the game server. Check your connection itself with the <a href="/ping-test/">ping test</a>.',
	),
	'sections'    => array(
		array(
			'What ping actually measures',
			'<p>Ping is the <strong>round-trip time</strong>: how long a small message takes to travel from your device to a server and back, in milliseconds (ms). The name comes from the command-line tool that sends these test messages, which was named after the sound of sonar. "Latency" means the same delay; "lag" is what you feel when it is high or uneven.</p>
<p>Ping has almost nothing to do with download speed. Speed is how much data fits through the pipe each second; ping is how long each piece takes to get through. A 1,000 Mbps fiber line can have 5 ms ping and a 1,000 Mbps satellite line can have 600 ms. That is why games, which send small updates many times a second, care about ping and hardly about Mbps.</p>',
			'what',
		),
		array(
			'Good ping ranges for each use',
			'<table><thead><tr><th>Ping</th><th>Competitive games (shooters, fighting, MOBA)</th><th>Casual and turn-based games</th><th>Video calls</th></tr></thead><tbody>
<tr><td>Under 20 ms</td><td>Excellent</td><td>Excellent</td><td>Excellent</td></tr>
<tr><td>20 to 50 ms</td><td>Good, no real disadvantage</td><td>Excellent</td><td>Excellent</td></tr>
<tr><td>50 to 100 ms</td><td>Playable, slight delay</td><td>Good</td><td>Good</td></tr>
<tr><td>100 to 150 ms</td><td>Noticeable, shots land late</td><td>Fine</td><td>Good</td></tr>
<tr><td>150 to 300 ms</td><td>Frustrating</td><td>Playable</td><td>Some talking over each other</td></tr>
<tr><td>Over 300 ms</td><td>Unplayable</td><td>Slow</td><td>Hard to hold a conversation</td></tr>
</tbody></table>
<p>For calls, the ITU-T recommendation G.114 says that for most applications the one-way delay should stay under 150 ms; a round-trip ping is two one-way trips, so under about 300 ms is acceptable, and conversation feels most natural well below that. Streaming video and downloads hardly care about ping at all, because they buffer ahead.</p>',
			'ranges',
		),
		array(
			'Jitter and packet loss matter as much as ping',
			'<p>The average ping hides the problem most people actually feel. <strong>Jitter</strong> is the variation from one message to the next. If your ping swings between 15 and 120 ms, characters warp and voices break up even though the average looks like a healthy 40 ms. Aim for jitter under 10 ms; over 30 ms is a real problem for calls and games.</p>
<p><strong>Packet loss</strong> is data that never arrives. Games and calls cannot wait for a resend, so a lost packet means a missed update: stutter, rubber-banding, a robotic voice. Anything above 0% on a cable is worth investigating, and over 1 to 2% is clearly noticeable.</p>
<p>That is why the Testnook <a href="/ping-test/">ping test</a> runs for 10 to 60 seconds and draws every reading instead of showing one number. Amber bars are spikes (more than double the typical ping) and red bars are lost requests. A flat, low line is what you want.</p>',
			'jitter-loss',
		),
		array(
			'Why your ping in a game is higher than on a test',
			'<p>A browser ping test talks to the nearest data center, often in your own city. A game server may be in another country. Light in fiber covers about 200 km per millisecond, so every 1,000 km of cable adds roughly 10 ms of round trip, and real routes are rarely straight. As a rough guide from Western Europe, a server in the same country gives 10 to 30 ms, one on the US East Coast 80 to 100 ms, and one in Asia 200 ms or more.</p>
<p>So if the ping test shows 15 ms and the game shows 90 ms, your connection is fine and the server is far away: pick a closer region in the game settings. If both show high ping, or the test shows big spikes, the problem is on your side: Wi-Fi, a busy line or the provider.</p>',
			'game-vs-test',
		),
		array(
			'What makes ping high',
			'<ul>
<li><strong>Wi-Fi.</strong> Wireless adds a few milliseconds at best and large spikes at worst, especially through walls or on the crowded 2.4 GHz band. A cable is the single biggest improvement for gaming.</li>
<li><strong>A busy line (bufferbloat).</strong> When someone streams or uploads, a poorly managed router queues data and your game packets wait behind it. Ping can jump from 20 to 300 ms. The <a href="/internet-speed-test/">internet speed test</a> grades this.</li>
<li><strong>The type of connection.</strong> Fiber is lowest (often 5 to 15 ms to nearby servers), then cable and DSL (10 to 40 ms), then 4G and 5G mobile (20 to 60 ms, more variable), then satellite. Low-orbit satellite such as Starlink is typically 25 to 60 ms; older geostationary satellite is 600 ms or more.</li>
<li><strong>Distance and routing.</strong> The physical path to the server, and sometimes a provider that routes traffic the long way round.</li>
<li><strong>VPNs and proxies.</strong> An extra stop usually adds latency, unless the VPN happens to have a better route.</li>
</ul>
<p>Our guide on <a href="/how-to-reduce-ping/">how to reduce ping</a> goes through the fixes in order of how much they help.</p>',
			'causes',
		),
		array(
			'How to measure your ping properly',
			'<p>Close other apps that use the internet, then run the <a href="/ping-test/">ping test</a> for 30 seconds over Wi-Fi, and again over a cable if you can. Then run it once more while someone else streams a video or a download is running. Comparing the three tells you whether your problem is the Wi-Fi, the busy line, or the connection itself. Note the median, the jitter and the number of lost requests. If loss appears even on a cable with nothing else running, restart the modem and router; if it stays, contact your provider with screenshots.</p>',
			'measure',
		),
	),
	'faq'         => array(
		array( 'Is 50 ms ping good?', 'Yes. 50 ms is good for nearly every online game and excellent for calls and streaming. Competitive players notice a small difference compared with 20 ms, but most people do not.' ),
		array( 'Is 100 ms ping bad?', 'For fast shooters and fighting games it is noticeable: your actions arrive about a tenth of a second late. For casual games, calls and browsing it is fine.' ),
		array( 'What is a good ping for Fortnite, Valorant or Call of Duty?', 'Under 50 ms is good and under 20 ms is ideal. Above 80 to 100 ms you will lose some close fights. Choose the closest server region and play on a cable.' ),
		array( 'Does faster internet lower ping?', 'Not directly. A faster plan helps only if your line is full while you play. Distance, Wi-Fi and router queues matter far more.' ),
		array( 'Is 0 ms ping possible?', 'No. Even a server in the same building takes a fraction of a millisecond, and anything over the internet takes at least a few. Under 10 ms is already about as good as it gets.' ),
		array( 'What is the difference between ping and latency?', 'They are used for the same thing. Latency is the delay; ping is the usual way of measuring it as a round trip in milliseconds.' ),
	),
	'sources'     => array(
		array( 'ITU-T Recommendation G.114: One-way transmission time', 'https://www.itu.int/rec/T-REC-G.114' ),
		array( 'Bufferbloat.net: Introduction to bufferbloat', 'https://www.bufferbloat.net/projects/bloat/wiki/Introduction/' ),
	),
	'ads'         => 'standard',
);
