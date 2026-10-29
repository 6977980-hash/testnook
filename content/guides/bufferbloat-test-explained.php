<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Bufferbloat Test Explained: What Your Grade Means',
	'seo_title'   => 'Bufferbloat Test Explained: Grades, Causes and the Fix',
	'description' => 'What a bufferbloat test measures, what the A+ to F grades mean, why ping jumps when someone else downloads, and how SQM or QoS on your router fixes it.',
	'blurb'       => 'Why ping jumps when the line is busy, what the bufferbloat grade means and how to fix it.',
	'hub'         => 'system',
	'tool'        => 'internet-speed-test',
	'tools'       => array( 'ping-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Your internet can be fast and still lag. If video calls freeze and games spike whenever someone else in the house downloads, uploads or streams, the problem is usually bufferbloat: a queue in the router that fills up while the line is busy. Here is how a bufferbloat test measures it, what the grade means and how to fix it in a few minutes.',
	'summary'     => array(
		'<strong>Bufferbloat</strong> is the extra delay your ping picks up while the connection is busy, caused by oversized queues in the router or modem.',
		'A test measures ping on an idle line, then again while it downloads and uploads at full speed. The difference is the bufferbloat: under 5 ms extra is <strong>A+</strong>, under 30 ms <strong>A</strong>, under 60 ms <strong>B</strong>, and over 200 ms is <strong>D</strong> or <strong>F</strong>.',
		'The fix is <strong>Smart Queue Management (SQM)</strong>, often called QoS, Adaptive QoS or Smart Queue in router settings, set to about 85 to 95% of your measured speeds.',
		'Run the <a href="/internet-speed-test/">internet speed test</a> before and after: the grade should rise to A or B.',
	),
	'sections'    => array(
		array(
			'What bufferbloat is',
			'<p>Every router and modem keeps a buffer, a queue of data waiting to go out, so that short bursts of traffic are not dropped. The trouble starts when that queue is large and the line is full. A big download or a photo backup keeps the queue packed, and every small packet from your game or video call has to wait behind it. The data still arrives, but late: a ping of 15 ms on a quiet line can become 300 ms or more while the queue is full.</p>
<p>The name comes from the engineers who documented the problem around 2010 and built the fix that most routers now ship. The important point for you is that bufferbloat has nothing to do with how fast your plan is. A gigabit fiber line and a 20 Mbps DSL line can both suffer from it, and both can be fixed by the same setting.</p>',
			'what-it-is',
		),
		array(
			'How a bufferbloat test works',
			'<p>A bufferbloat test has three steps. First it measures ping on an idle connection, which is your baseline. Then it fills the download direction with test data while it keeps measuring ping, and does the same for upload. The bufferbloat figure is how much the ping rose under load compared with the baseline.</p>
<p>The <a href="/internet-speed-test/">speed test on this site</a> shows both numbers ("Ping while downloading" and "Ping while uploading") and grades the worse rise on the scale used by the bufferbloat community:</p>
<div class="table-scroll"><table>
<thead><tr><th>Grade</th><th>Extra ping under load</th><th>What you notice</th></tr></thead>
<tbody>
<tr><td>A+</td><td>Under 5 ms</td><td>Nothing. Calls and games are unaffected by other traffic.</td></tr>
<tr><td>A</td><td>5 to 30 ms</td><td>Nothing in practice.</td></tr>
<tr><td>B</td><td>30 to 60 ms</td><td>Fine for calls; competitive games may feel slightly heavier during big downloads.</td></tr>
<tr><td>C</td><td>60 to 200 ms</td><td>Noticeable lag in games and short freezes in calls while someone uploads or downloads.</td></tr>
<tr><td>D</td><td>200 to 400 ms</td><td>Games become unplayable and calls break up whenever the line is busy.</td></tr>
<tr><td>F</td><td>Over 400 ms</td><td>Even web pages feel slow while a backup or download runs.</td></tr>
</tbody></table></div>
<p>Upload is usually the worse direction, because upload speeds are lower and a phone backing up photos fills them quickly. If your grade is bad only for upload, that is the one to fix first.</p>',
			'how-it-works',
		),
		array(
			'How to fix bufferbloat',
			'<ol>
<li><strong>Find the setting.</strong> In your router\'s app or web page look for <strong>SQM</strong>, <strong>QoS</strong>, <strong>Adaptive QoS</strong>, <strong>Smart Queue</strong>, <strong>Bandwidth control</strong> or a <strong>Gaming</strong> mode. Routers running OpenWrt have it under Network &gt; SQM QoS; many recent mesh systems have it in their app.</li>
<li><strong>Enter your speeds.</strong> Run the speed test with nothing else running and set the SQM limits to about 85 to 95% of the download and upload you measured. The limit has to be slightly below the real line speed so that the queue forms in your router, where it is managed, and not in the modem.</li>
<li><strong>Pick the algorithm if asked.</strong> CAKE or fq_codel are the two that matter; either is fine.</li>
<li><strong>Test again.</strong> The grade should rise to A or B. If it does not, lower the limits by another 5% and repeat. You give up a little top speed and gain steady ping under any load.</li>
</ol>
<p>If your router has no such setting, the cheapest fixes are a firmware update (some vendors added it later), scheduling backups and game updates for the night, or limiting upload speed inside the backup app. A newer router with SQM is the lasting fix; the modem or fiber box from the provider can usually stay as it is.</p>',
			'fix',
		),
		array(
			'Bufferbloat or something else?',
			'<p>Not every lag spike is bufferbloat. Use the pattern to tell them apart with the <a href="/ping-test/">ping test</a>:</p>
<ul>
<li><strong>High ping only while the line is busy:</strong> bufferbloat. The fix above.</li>
<li><strong>Random spikes on a quiet line, worse on Wi-Fi:</strong> wireless interference or a laptop scanning for networks. Test over a cable.</li>
<li><strong>High ping all the time, even idle:</strong> distance to the server or the type of connection (mobile, satellite, DSL). SQM cannot lower the baseline.</li>
<li><strong>Lost requests on a cable with nothing else running:</strong> a faulty cable, modem or line. Contact the provider with screenshots.</li>
</ul>
<p>Our guide on <a href="/how-to-reduce-ping/">how to reduce ping</a> goes through the other fixes in order of impact.</p>',
			'something-else',
		),
	),
	'faq'         => array(
		array( 'What is a good bufferbloat score?', 'A or A+, meaning your ping rises by less than 30 ms when the line is full. B is acceptable for most people; C or worse is worth fixing if you game or make video calls.' ),
		array( 'Does bufferbloat affect download speed?', 'No. Downloads finish just as fast; it is the delay for everything else that suffers. That is why a speed test can look perfect while calls still freeze.' ),
		array( 'Will SQM make my internet slower?', 'Top speed drops by the 5 to 15% you leave as headroom. In return every call, game and web page stays responsive while the line is busy, which most people notice far more.' ),
		array( 'Can my internet provider fix bufferbloat?', 'Sometimes, by updating the modem or fiber box, but the easiest fix is usually in your own router. Providers rarely change queue settings on request.' ),
		array( 'Why is my upload bufferbloat worse than download?', 'Upload is usually much slower, so the same size of queue takes longer to empty, and cloud backups, video calls and game streams all push data up at once.' ),
		array( 'Does a mesh Wi-Fi system cause bufferbloat?', 'Wi-Fi itself can add queueing, but the main queue sits at the slowest link, which is usually the internet line. Turn on SQM in the main router of the mesh system.' ),
	),
	'sources'     => array(
		array( 'Bufferbloat.net: "What can I do about bufferbloat?"', 'https://www.bufferbloat.net/projects/bloat/wiki/What_can_I_do_about_Bufferbloat/' ),
		array( 'OpenWrt documentation: SQM (Smart Queue Management)', 'https://openwrt.org/docs/guide-user/network/traffic-shaping/sqm' ),
		array( 'RFC 8290: The Flow Queue CoDel Packet Scheduler and Active Queue Management Algorithm', 'https://www.rfc-editor.org/rfc/rfc8290' ),
	),
	'ads'         => 'standard',
);
