<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Ping Test',
	'seo_title'      => 'Ping Test: Check Your Ping, Jitter & Packet Loss Online',
	'description'    => 'Free online ping test. Watch your ping live for up to 60 seconds and see jitter, lag spikes and lost requests, with a clear verdict for gaming and video calls.',
	'intro'          => 'Measure your ping the way games feel it: a reading every quarter of a second for 10, 30 or 60 seconds, drawn live so you can see lag spikes. You get the lowest, average and highest ping, jitter, lost requests and a plain verdict for gaming, video calls and streaming.',
	'trust'          => 'Nothing is sent to Testnook',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'system' ),
	'scripts'        => array( 'net', 'ping-test' ),
	'embed_height'   => 860,
	'tool'           => '<div class="tool-stage sy-stage">
	<div class="btn-row">
		<div class="seg" role="group" aria-label="Test length"><button type="button" data-pg-secs="10" aria-pressed="false">10 s</button><button type="button" data-pg-secs="30" aria-pressed="true">30 s</button><button type="button" data-pg-secs="60" aria-pressed="false">60 s</button></div>
		<div class="seg" role="group" aria-label="Server"><button type="button" data-pg-target="cloudflare" aria-pressed="true">Nearest server</button><button type="button" data-pg-target="google" aria-pressed="false">Google</button></div>
	</div>
	<div class="pg-now"><strong id="pg-now">-</strong><span>ping now (ms)</span></div>
	<canvas class="pg-chart" id="pg-chart" aria-label="Chart of every ping sample; red bars are lost requests, amber bars are spikes"></canvas>
	<div class="btn-row sy-center"><button type="button" class="btn btn-primary" id="pg-start">Start ping test</button></div>
	<div class="stats sy-stats4">
		<div class="stat"><span class="stat-label">Lowest</span><span class="stat-value" id="pg-min">-</span></div>
		<div class="stat"><span class="stat-label">Average</span><span class="stat-value" id="pg-avg">-</span></div>
		<div class="stat"><span class="stat-label">Median</span><span class="stat-value" id="pg-med">-</span></div>
		<div class="stat"><span class="stat-label">Highest</span><span class="stat-value" id="pg-max">-</span></div>
		<div class="stat"><span class="stat-label">Jitter</span><span class="stat-value" id="pg-jit">-</span></div>
		<div class="stat"><span class="stat-label">95% under</span><span class="stat-value" id="pg-p95">-</span></div>
		<div class="stat"><span class="stat-label">Spikes</span><span class="stat-value" id="pg-spikes">-</span></div>
		<div class="stat"><span class="stat-label">Lost</span><span class="stat-value" id="pg-lost">-</span></div>
	</div>
	<dl class="sy-meta"><dt>Server</dt><dd id="pg-server">-</dd></dl>
	<div class="pg-verdicts" id="pg-verdicts" hidden>
		<div class="sy-verdict" id="pg-v-game"><strong>-</strong><p></p></div>
		<div class="sy-verdict" id="pg-v-call"><strong>-</strong><p></p></div>
		<div class="sy-verdict" id="pg-v-stream"><strong>-</strong><p></p></div>
	</div>
</div>
<p class="tool-status" id="pg-status" aria-live="polite">Pick a length and press Start. Run it while you game or call to catch the moments that lag.</p>',
	'howto'          => array(
		'Choose how long to test: 10 seconds for a quick check, 30 or 60 seconds to catch occasional lag spikes.',
		'Keep <strong>Nearest server</strong> to test your own connection, or pick <strong>Google</strong> to compare with a second network.',
		'Press <strong>Start ping test</strong> and leave the page open. Each bar on the chart is one reading; amber bars are spikes and red bars are requests that never came back.',
		'Read the median ping, jitter and lost count, then the verdicts for gaming, calls and streaming.',
		'To find the cause of lag, run it again on a cable instead of Wi-Fi, and once while someone else streams or downloads.',
	),
	'howto_title'    => 'How to check your ping',
	'results'        => '<ul>
<li><strong>Ping</strong> is the round trip time in milliseconds for a small request to reach the server and come back. The <strong>median</strong> is the typical value; the <strong>lowest</strong> shows what the line can do when nothing else is happening.</li>
<li><strong>Jitter</strong> is the average change between one reading and the next. Under 5 ms is very steady, under 15 ms is good, and over 30 ms causes choppy calls and rubber-banding in games, even when the average ping looks fine.</li>
<li><strong>95% under</strong> is the value 95 out of 100 readings stayed below. A big gap between this and the median means regular lag spikes.</li>
<li><strong>Spikes</strong> counts readings more than double the median (plus 20 ms). A few in a minute is normal on Wi-Fi; dozens point to interference, a busy network or a weak signal.</li>
<li><strong>Lost</strong> counts requests with no answer within 1.5 seconds. Any loss on a cable is a fault worth reporting; on Wi-Fi it usually means a weak signal.</li>
</ul>
<table><thead><tr><th>Median ping</th><th>Rating</th><th>Feels like</th></tr></thead><tbody>
<tr><td>Under 20 ms</td><td>Excellent</td><td>Instant, ideal for competitive games</td></tr>
<tr><td>20 to 50 ms</td><td>Good</td><td>No noticeable delay in any game</td></tr>
<tr><td>50 to 100 ms</td><td>Fair</td><td>Fine for most games and calls, slight delay in shooters</td></tr>
<tr><td>100 to 150 ms</td><td>Poor for games</td><td>Shots and moves land late; calls still work</td></tr>
<tr><td>Over 150 ms</td><td>Bad</td><td>Clear lag; people talk over each other in calls</td></tr>
</tbody></table>',
	'extra'          => array(
		array(
			'How this browser ping test works',
			'<p>Browsers are not allowed to send the "ping" (ICMP) packets that the command line tool uses, so the page sends a tiny web request over an open connection and times the reply. With <strong>Nearest server</strong> it talks to the closest Cloudflare data center and uses the browser\'s own precise timing, minus the server\'s processing time, so the result is very close to a real ping. The <strong>Google</strong> option times a tiny request to Google\'s servers from start to finish, which adds a millisecond or two of browser overhead.</p>
<p>Your ping in a game also depends on where the game server is. A server in another country adds the distance: roughly 1 ms for every 100 km of cable each way, plus the routing in between. That is why a game can show 120 ms when this test shows 15 ms. To check your connection, use this test; to choose a region, use the ping shown in the game.</p>',
			'how-it-works',
		),
		array(
			'Ping, latency and lag: the difference',
			'<p><strong>Latency</strong> is the delay itself; <strong>ping</strong> is the usual way to measure it, as a round trip. <strong>Lag</strong> is what you feel when latency is high or jumps around. Two connections with the same 30 ms average can feel very different: one steady at 30 ms, the other swinging between 10 and 150 ms. The swing is jitter, and it is why this test draws every reading instead of showing one number. Download speed is a different thing again: a 1,000 Mbps line can still have bad ping, and a 20 Mbps line can have excellent ping.</p>',
			'ping-vs-lag',
		),
	),
	'fixes'          => array(
		array( 'High ping or spikes only on Wi-Fi', 'Use a network cable for gaming if you can. If not, move closer to the router, use the 5 GHz band, and keep the router in the open, away from microwaves, cordless phones and thick walls.' ),
		array( 'Ping jumps when someone streams or downloads', 'This is bufferbloat: the router lets a queue build up. Turn on SQM, QoS or "gaming mode" in the router settings. The <a href="/internet-speed-test/">internet speed test</a> grades it by measuring ping while the line is full.' ),
		array( 'Lost requests on a cable', 'Restart the modem and router, check the cable and its plug, and test again. If loss stays above 1% on a cable, contact your provider with a screenshot of the chart.' ),
		array( 'Ping is fine here but high in one game', 'The game server is far away or busy. Choose a closer region in the game settings. A VPN can sometimes give a shorter route, but usually adds ping.' ),
	),
	'faq'            => array(
		array( 'What is a good ping?', 'Under 20 ms is excellent, 20 to 50 ms is good, 50 to 100 ms is fine for most uses, and over 100 ms starts to feel slow in fast games. Read more in our guide <a href="/what-is-a-good-ping/">what is a good ping</a>.' ),
		array( 'What is jitter?', 'Jitter is how much the ping changes from one reading to the next. Steady ping with low jitter feels smooth; jitter over 30 ms makes calls choppy and characters jump in games, even when the average ping is low.' ),
		array( 'What is packet loss and how much is too much?', 'Packet loss is data that never arrives. Games and calls need almost none: 0% is normal, 1% is noticeable and over 2% causes stutter and dropouts. This test counts requests that got no reply within 1.5 seconds.' ),
		array( 'Why is my ping higher in games than here?', 'This test talks to the nearest data center, usually in your own city or country. A game server further away adds travel time, about 1 ms per 100 km each way, plus the routing in between.' ),
		array( 'Does download speed affect ping?', 'Not directly. Ping depends on distance, routing and how busy the line is. But a full line can raise ping a lot if the router queues data badly (bufferbloat), so a download on another device can make your game lag.' ),
		array( 'How do I lower my ping?', 'Use a cable instead of Wi-Fi, stop downloads and streams on other devices while you play, turn on QoS or SQM in the router, and choose the closest game server. Our guide on <a href="/how-to-reduce-ping/">how to reduce ping</a> covers each step.' ),
	),
	'related'        => array( 'internet-speed-test', 'what-is-my-ip', 'dns-lookup', 'reaction-time-test', 'mouse-latency-test', 'webrtc-leak-test', 'device-info', 'fps-test' ),
	'updated'        => '2026-10-29',
);
