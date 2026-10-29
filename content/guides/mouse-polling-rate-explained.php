<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Mouse Polling Rate Explained: 125 vs 1000 Hz and Up',
	'seo_title'   => 'Mouse Polling Rate Explained: 125 vs 1000 vs 8000 Hz',
	'description' => 'What mouse polling rate means, how 125, 500, 1000 and 8000 Hz feel in games, why a high rate can stutter or drain a battery, and the setting most people need.',
	'blurb'       => 'What polling rate is, how 125, 1000 and 8000 Hz differ and which one to pick.',
	'hub'         => 'mouse',
	'tool'        => 'mouse-polling-rate-test',
	'tools'       => array( 'mouse-latency-test', 'mouse-tester', 'dpi-analyzer' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Polling rate is how often your mouse tells the computer where it is. Gaming mice advertise 1000, 4000 and even 8000 Hz. Here is what those numbers change, what you actually feel, and the setting that suits most setups.',
	'summary'     => array(
		'Polling rate is the number of position reports per second. <strong>1000 Hz</strong> means a report every 1 ms; <strong>125 Hz</strong>, the old default, means every 8 ms.',
		'Going from 125 to 1000 Hz is a clear, visible improvement in smoothness and delay. Going from 1000 to 4000 or 8000 Hz is a small gain that only shows on high refresh monitors.',
		'High rates cost CPU time and battery. If a game stutters at 4000 or 8000 Hz, drop back to <strong>1000 Hz</strong>.',
		'Most people should use <strong>1000 Hz</strong> and check that the mouse really reaches it with a polling rate test.',
	),
	'sections'    => array(
		array(
			'What polling rate means',
			'<p>A mouse sensor measures movement thousands of times a second, but it can only send that movement to the computer when the computer asks. USB devices are polled: the computer checks the mouse at a fixed interval and collects whatever movement has built up since the last check. The number of checks per second is the polling rate, measured in hertz (Hz).</p>
<div class="table-scroll"><table>
<thead><tr><th>Polling rate</th><th>Time between reports</th><th>Where you see it</th></tr></thead>
<tbody>
<tr><td>125 Hz</td><td>8 ms</td><td>Office mice, the USB default</td></tr>
<tr><td>250 Hz</td><td>4 ms</td><td>Some budget and Bluetooth mice</td></tr>
<tr><td>500 Hz</td><td>2 ms</td><td>Older gaming mice, power saving modes</td></tr>
<tr><td>1000 Hz</td><td>1 ms</td><td>The standard for gaming mice</td></tr>
<tr><td>2000 to 8000 Hz</td><td>0.5 to 0.125 ms</td><td>High-end wired and 2.4 GHz gaming mice</td></tr>
</tbody></table></div>
<p>Polling rate is separate from DPI. DPI is how many counts the mouse reports per inch of movement; polling rate is how often those counts are sent. A high DPI mouse at 125 Hz still updates only 125 times a second.</p>',
			'what-it-is',
		),
		array(
			'125 vs 1000 Hz: what you feel',
			'<p>At 125 Hz the cursor position is up to 8 ms old by the time it arrives, and on a 144 Hz or faster monitor some frames get no new mouse data at all. The cursor moves in small visible steps when you sweep it quickly, and flicks in shooters feel slightly loose.</p>
<p>At 1000 Hz each report is at most 1 ms old and every frame of a 240 Hz monitor gets several fresh reports. Movement looks continuous and the average delay drops by a few milliseconds. In blind tests most players can tell 125 Hz from 1000 Hz on a high refresh screen, especially in fast games.</p>
<p>A quick way to see it yourself: move the mouse in fast circles on the <a href="/mouse-polling-rate-test/">polling rate test</a> at each setting and watch the measured rate and the trail of points. At 125 Hz the points are far apart; at 1000 Hz they form a smooth curve.</p>',
			'125-vs-1000',
		),
		array(
			'Are 4000 and 8000 Hz worth it?',
			'<p>Higher rates cut the interval further, to 0.25 ms at 4000 Hz and 0.125 ms at 8000 Hz. The saving over 1000 Hz is less than one millisecond on average, which is smaller than the gap between two frames even at 360 Hz. What you can notice is smoother tracking on very high refresh monitors, where 1000 Hz leaves small timing gaps between frames.</p>
<p>The costs are real:</p>
<ul>
<li><strong>CPU load.</strong> Every report is an interrupt the computer has to handle. On older or busy processors, 8000 Hz can cause frame drops, micro stutter and jumpy cursor movement in some games.</li>
<li><strong>Battery.</strong> Wireless mice at 4000 or 8000 Hz often lose half or more of their battery life.</li>
<li><strong>Compatibility.</strong> Some older games and engines handle very fast input badly, and you may see stutter in a game that was smooth at 1000 Hz.</li>
</ul>
<p>So 4000 and 8000 Hz make sense for competitive players with a 240 Hz or faster monitor and a recent CPU. For everyone else, 1000 Hz gives almost all of the benefit with none of the side effects.</p>',
			'8000-hz',
		),
		array(
			'How to check and change your polling rate',
			'<ol>
<li><strong>Measure it.</strong> Open the <a href="/mouse-polling-rate-test/">mouse polling rate test</a> and move the mouse quickly in circles for a few seconds. The test shows the measured rate and the nearest standard value. Browsers add some timing noise, so a reading of 900 to 1000 means 1000 Hz is working.</li>
<li><strong>Change it in the mouse software.</strong> Gaming mice set the rate in the maker\'s app (Logitech G Hub, Razer Synapse, SteelSeries GG and so on). Many also have a button on the underside that cycles 125 / 500 / 1000 Hz.</li>
<li><strong>Use the right connection.</strong> Bluetooth is usually limited to about 125 to 133 Hz. For 1000 Hz or more, use the cable or the 2.4 GHz USB receiver, plugged straight into the computer rather than a hub.</li>
<li><strong>Test again.</strong> If the rate stays low, try another USB port (a rear port on a desktop), close other mouse software and check the receiver is not behind a metal case or monitor stand.</li>
</ol>',
			'check-and-change',
		),
		array(
			'Polling rate problems and fixes',
			'<p><strong>The test shows far less than the setting.</strong> You may be moving too slowly: the mouse only reports when it moves, so slow movements read lower. Move fast and steady. If it still reads low, the USB port, hub or wireless link is the limit.</p>
<p><strong>The rate jumps around.</strong> Small swings are browser timing noise. Big drops while moving fast point to wireless interference: move the receiver closer with the extension cable that came with the mouse, away from Wi-Fi routers and USB 3 devices.</p>
<p><strong>Games stutter after raising the rate.</strong> Drop back to 1000 Hz. That is the most common fix for micro stutter with 4000 and 8000 Hz mice.</p>
<p><strong>The cursor feels delayed even at 1000 Hz.</strong> Polling rate is only one part of the chain. Display refresh rate, game frame rate, V-Sync and wireless lag matter more; the <a href="/mouse-latency-test/">mouse latency test</a> helps you compare setups.</p>',
			'problems',
		),
	),
	'faq'         => array(
		array( 'What polling rate should I use?', '1000 Hz for nearly everyone. Use 4000 or 8000 Hz only if you have a 240 Hz or faster monitor, a recent CPU and no stutter at that setting.' ),
		array( 'Does polling rate affect DPI?', 'No. DPI is how far the cursor moves per inch of mouse movement; polling rate is how often the mouse reports. You set them separately.' ),
		array( 'Is 500 Hz good enough?', 'Yes for most games, with 2 ms between reports. 1000 Hz is a little smoother and is the default on most gaming mice, so there is rarely a reason to stay at 500 unless you need battery life.' ),
		array( 'Why does my mouse only show 125 Hz?', 'It is an office mouse, it is connected over Bluetooth, or it is set to 125 Hz in its software or by a button on the underside. Many USB mice without software are fixed at 125 Hz.' ),
		array( 'Does high polling rate drain the battery?', 'Yes. Wireless mice use noticeably more power at higher rates, and 4000 or 8000 Hz can cut battery life by half or more compared with 1000 Hz.' ),
		array( 'Can an online test measure polling rate accurately?', 'Closely, but not perfectly. The browser receives mouse events with some timing noise, so the test finds the nearest standard rate rather than an exact figure.' ),
	),
);
