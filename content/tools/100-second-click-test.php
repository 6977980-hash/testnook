<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '100 Second Click Test',
	'seo_title'      => '100 Second Click Test: The Long CPS Stamina Challenge',
	'description'    => 'Free 100 second click test. Click for one hundred seconds and see your total clicks, average CPS, peak second and consistency. The long stamina challenge.',
	'intro'          => 'The longest click test there is: one hundred seconds of clicking. It is as much about patience and a relaxed hand as about speed. Click the box to start, keep going until the ring empties, and see your total, your average clicks per second and a graph of all hundred seconds.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'stats'          => array( 'cps-100' ),
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( 100 ),
	'howto'          => array(
		'Get comfortable: forearm supported, mouse in a loose grip, page in front of every other window.',
		'Click the box to start the 100 second timer.',
		'Settle into a steady rhythm. Swap fingers whenever one tires; every press inside the box counts.',
		'At zero, read your <strong>total clicks</strong>, average <strong>CPS</strong> and <strong>consistency</strong>. The graph has one bar for each of the hundred seconds.',
	),
	'howto_title'    => 'How to take the 100 second click test',
	'results'        => '<p>Because the test is exactly 100 seconds, your clicks divided by 100 is your CPS: 450 clicks is 4.5 CPS. Very few people hold their 5 second speed for this long.</p>
<div class="table-scroll"><table>
<thead><tr><th>Clicks in 100 s</th><th>CPS</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 350</td><td>Under 3.5</td><td>Relaxed pace, or you stopped to rest.</td></tr>
<tr><td>350-450</td><td>3.5-4.5</td><td>A solid long run.</td></tr>
<tr><td>450-550</td><td>4.5-5.5</td><td>Excellent stamina.</td></tr>
<tr><td>550-750</td><td>5.5-7.5</td><td>Two-finger alternating held throughout.</td></tr>
<tr><td>Over 750</td><td>Over 7.5</td><td>Butterfly or drag clicking, an auto clicker, or a faulty switch.</td></tr>
</tbody></table></div>
<p>Over 100 seconds a consistency score above 70% is very steady. Dips in the graph are the moments you rested or changed fingers.</p>',
	'extra'          => array(
		array(
			'Strategy for 100 seconds',
			'<p>Treat it like a long run, not a sprint. Start at about three quarters of your 5 second speed and keep it there. Alternate the index and middle finger every ten or fifteen seconds to share the load. Keep breathing and keep the shoulder down. People who sprint the first ten seconds usually finish with fewer clicks than people who start slower.</p>
<p>A 100 second run is also a good stress test for a mouse. Hundreds of presses in a row can expose a switch that starts to double click when warm; if late seconds in the graph are much taller than the rest, run the <a href="/double-click-test/">double click test</a>. To test an auto clicker instead of your hand, use the <a href="/auto-clicker-test/">auto clicker test</a>, which also measures the gap between clicks.</p>',
			'strategy',
		),
	),
	'fixes'          => array(
		array( 'The timer stopped or skipped', 'Browsers slow down pages in background tabs. Keep this tab in front and do not switch apps until the test ends.' ),
		array( 'My hand hurts', 'Stop. One hundred seconds of fast clicking is long. Rest, stretch and use two fingers in turn next time. Do not jitter click for this length.' ),
		array( 'The count seems too high', 'A switch that double registers can add hundreds of clicks over a long run. Check the mouse with the <a href="/double-click-test/">double click test</a>.' ),
	),
	'faq'            => array(
		array( 'How many clicks in 100 seconds is good?', 'Around 450 to 550 clicks (4.5 to 5.5 CPS) is excellent for normal clicking. Most people land between 350 and 450.' ),
		array( 'How long is the 100 second click test?', 'Exactly 100 seconds, one minute and forty seconds, timed from your first click.' ),
		array( 'Why is my CPS so much lower than in 5 seconds?', 'Nobody holds sprint speed for 100 seconds. A drop of one to two clicks per second is normal.' ),
		array( 'Can I rest during the test?', 'Yes, the timer keeps running, so a rest lowers your total. The graph shows where you paused.' ),
		array( 'Is it safe to click for 100 seconds?', 'Normal clicking is fine for most people. Stop if you feel pain or tingling, and avoid jitter clicking for this length.' ),
		array( 'Is my best saved?', 'Your best 100 second CPS is stored in this browser only and shared with the main CPS test.' ),
	),
	'related'        => array( '60-second-click-test', '30-second-click-test', 'cps-test', 'auto-clicker-test', 'double-click-test', 'mouse-tester' ),
	'updated'        => '2026-10-29',
);
