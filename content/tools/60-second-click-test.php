<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '60 Second Click Test',
	'seo_title'      => '60 Second Click Test: How Many Clicks in One Minute?',
	'description'    => 'Free 60 second click test. Click for a full minute and get your total clicks, clicks per second, peak and consistency, with a graph of every second of the run.',
	'intro'          => 'How many times can you click in one minute? The 60 second click test is a stamina run: your total clicks, your clicks per second, the fastest second and a sixty-bar graph that shows exactly how your speed held up.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( 60 ),
	'howto'          => array(
		'Support your forearm on the desk and hold the mouse loosely.',
		'Click the box to start the one minute timer.',
		'Click at a pace you can hold for the whole minute. Swap between two fingers if you need to.',
		'When the timer ends, read your <strong>total clicks</strong> and <strong>CPS</strong>. Hover the graph bars for the clicks in each second.',
	),
	'howto_title'    => 'How to take the 60 second click test',
	'results'        => '<p>A one minute test gives a score that is easy to compare: your total clicks. Divide by sixty for the CPS; 300 clicks is 5 CPS, a strong minute of normal clicking.</p>
<div class="table-scroll"><table>
<thead><tr><th>Clicks in 60 s</th><th>CPS</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 220</td><td>Under 3.7</td><td>Relaxed clicking or a strong fade.</td></tr>
<tr><td>220-300</td><td>3.7-5</td><td>Normal clicking, well paced.</td></tr>
<tr><td>300-380</td><td>5-6.3</td><td>Excellent stamina.</td></tr>
<tr><td>380-500</td><td>6.3-8.3</td><td>Two-finger alternating or held jitter.</td></tr>
<tr><td>Over 500</td><td>Over 8.3</td><td>Butterfly or drag clicking, or a faulty switch.</td></tr>
</tbody></table></div>
<p>Over a minute, a consistency score above 75% is good. The graph usually shows a fast first ten seconds, a long middle plateau and sometimes a final push. A long plateau is what to aim for.</p>',
	'extra'          => array(
		array(
			'Clicks per minute and what it is used for',
			'<p>Some idle and clicker games measure progress in clicks per minute, and a few game anti-cheat systems look at sustained rates rather than bursts. A one minute run also reveals mouse faults that short tests miss: a switch that starts to chatter when warm, or a button that sticks after a few hundred presses. If your graph has a spike of impossible seconds late in the run, check the mouse with the <a href="/double-click-test/">double click test</a>.</p>',
			'cpm',
		),
		array(
			'Look after your hand',
			'<p>Sixty seconds of hard clicking is a real workout for the small muscles of the hand. Normal clicking is safe, but do not jitter click for a full minute, and stop if you feel pain, tingling or numbness. Take breaks between runs and stretch the wrist and fingers.</p>',
			'hand',
		),
	),
	'fixes'          => array(
		array( 'The test ended early', 'Switching tabs or minimising the window can pause the browser. Keep the page in front for the whole minute.' ),
		array( 'My CPS keeps dropping', 'That is fatigue. Start slower, keep the wrist supported, and alternate two fingers on the button.' ),
		array( 'The pointer leaves the box', 'Hold the mouse with the thumb and ring finger so the clicking finger does not push it. Clicks outside the box are not counted.' ),
	),
	'faq'            => array(
		array( 'How many clicks in 60 seconds is good?', 'Around 300 clicks (5 CPS) is a strong minute for normal clicking. Above 400 needs two-finger or jitter clicking.' ),
		array( 'What is the average clicks in one minute?', 'Most people make 220 to 300 clicks in a minute, about 4 to 5 clicks per second.' ),
		array( 'What is a good CPM?', 'CPM is clicks per minute, the same as your total here. 300 CPM is good, 360 or more is very good.' ),
		array( 'Can I take the 60 second test on a phone?', 'Yes, taps are counted. Rest the phone on a table and tap with two fingers in turn for the best score.' ),
		array( 'Why does the graph show tall bars at the start?', 'Everyone starts faster than they can hold. The bars settle after about ten seconds.' ),
		array( 'Is my best score saved?', 'Yes, your best 60 second CPS is stored in this browser and shared with the main CPS test.' ),
	),
	'related'        => array( '30-second-click-test', '100-second-click-test', 'cps-test', 'auto-clicker-test', 'double-click-test', 'spacebar-clicker' ),
	'updated'        => '2026-10-29',
);
