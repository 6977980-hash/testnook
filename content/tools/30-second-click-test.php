<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '30 Second Click Test',
	'seo_title'      => '30 Second Click Test: Clicks Per Second Endurance Test',
	'description'    => 'Free 30 second click test. Click for half a minute and see your total clicks, CPS, peak second and consistency, with a graph of how your speed held up.',
	'intro'          => 'Half a minute of clicking is an endurance test. Everyone can sprint for five seconds; holding a fast rate for thirty shows real technique and stamina. Click the box to start, then watch the graph to see exactly when you slowed down.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'stats'          => array( 'cps-30' ),
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( 30 ),
	'howto'          => array(
		'Sit comfortably with your forearm supported and the mouse in a relaxed grip.',
		'Click the box to start the thirty second timer.',
		'Pick a pace you can keep. Switch fingers if one tires: the test counts every press, whichever finger makes it.',
		'At zero, read your <strong>clicks</strong>, <strong>CPS</strong>, <strong>peak</strong> and <strong>consistency</strong>. The graph has one bar per second.',
	),
	'howto_title'    => 'How to take the 30 second click test',
	'results'        => '<p>Your CPS is your clicks divided by thirty, so 180 clicks is 6 CPS. That is an excellent 30 second result for normal clicking; most people fade to around 5.</p>
<div class="table-scroll"><table>
<thead><tr><th>Clicks in 30 s</th><th>CPS</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 120</td><td>Under 4</td><td>Relaxed clicking, or a heavy fade.</td></tr>
<tr><td>120-165</td><td>4-5.5</td><td>Normal fast clicking.</td></tr>
<tr><td>165-210</td><td>5.5-7</td><td>Strong endurance.</td></tr>
<tr><td>210-270</td><td>7-9</td><td>Jitter or two-finger clicking held for the whole test.</td></tr>
<tr><td>Over 270</td><td>Over 9</td><td>Butterfly or drag clicking, or a switch that double registers.</td></tr>
</tbody></table></div>
<p>The gap between your <strong>peak</strong> second and your average is your fade. Under 1.5 CPS is very good at this length. Consistency above 80% over thirty seconds is a steady clicker.</p>',
	'extra'          => array(
		array(
			'Building click endurance',
			'<p>Endurance comes from relaxation, not strength. Watch the graph: if the bars fall from second five onwards, your forearm is tensing. Drop the shoulder, loosen the grip and click from the fingertip. Some players alternate the index and middle finger every few seconds, which keeps the rate up without any special technique. Practise at this length a few times a week and the curve flattens.</p>
<p>Take care with jitter clicking at thirty seconds. Holding forearm tension that long is the main cause of sore wrists among clickers. If you feel pain, tingling or numbness, stop and rest for several days.</p>',
			'endurance',
		),
	),
	'fixes'          => array(
		array( 'The pointer drifts out of the box', 'Long fast clicking moves the mouse. Raise your sensitivity a little, use the middle of the box, or hold the mouse more firmly with the thumb and ring finger.' ),
		array( 'My score falls off a cliff halfway', 'You started at sprint pace. Start slower, around 80 to 90% of your 5 second speed, and keep it.' ),
		array( 'Clicks vanish during the test', 'If clicks stop counting while the pointer is in the box, the switch may be failing under load. Compare with another mouse in the <a href="/mouse-tester/">mouse tester</a>.' ),
	),
	'faq'            => array(
		array( 'How many clicks in 30 seconds is good?', 'Around 150 to 180 clicks (5 to 6 CPS) is good for normal clicking. Above 210 means jitter, butterfly or two-finger clicking.' ),
		array( 'What is the average 30 second click score?', 'Most people land between 120 and 165 clicks, which is 4 to 5.5 clicks per second.' ),
		array( 'Is a 30 second click test bad for my hand?', 'Normal clicking for thirty seconds is fine. Jitter clicking for that long strains the forearm; keep tries short and stop if it hurts.' ),
		array( 'Why does my CPS fall over 30 seconds?', 'Finger and forearm fatigue. The fade is normal; the graph shows how much and when.' ),
		array( 'Can I switch fingers during the test?', 'Yes. Every press inside the box counts, whichever finger makes it.' ),
		array( 'Is my best score saved?', 'Your best 30 second CPS is saved in this browser only, shared with the main CPS test.' ),
	),
	'related'        => array( '60-second-click-test', '15-second-click-test', '10-second-cps-test', 'cps-test', 'jitter-click-test', 'spacebar-clicker' ),
	'updated'        => '2026-10-29',
);
