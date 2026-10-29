<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '10 Second CPS Test',
	'seo_title'      => '10 Second CPS Test: Clicks Per Second Over 10 Seconds',
	'description'    => 'Free 10 second CPS test. Click for ten seconds and get your clicks per second, peak second and a consistency score that shows how well you hold your pace.',
	'intro'          => 'Ten seconds is long enough to show whether you can hold a fast rate, which is what matters in a real fight. You get your average clicks per second, your fastest second, a consistency score and a graph of every second.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( 10 ),
	'howto'          => array(
		'Point at the box with a relaxed grip and the heel of your hand resting.',
		'Click to start the ten second timer. The first click counts.',
		'Hold a rhythm you can keep. Going flat out in the first two seconds usually costs more than it gains.',
		'Read your average <strong>CPS</strong>, the <strong>peak</strong> second and the <strong>consistency</strong> score, then check the graph for the second where you slowed.',
	),
	'howto_title'    => 'How to take the 10 second CPS test',
	'results'        => '<p>Your CPS is total clicks divided by ten, so 65 clicks is 6.5 CPS. Over ten seconds most people drop about half a click per second compared with their <a href="/5-second-cps-test/">5 second score</a>.</p>
<div class="table-scroll"><table>
<thead><tr><th>CPS (10 s)</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 4</td><td>Relaxed clicking.</td></tr>
<tr><td>4-6</td><td>Normal fast clicking.</td></tr>
<tr><td>6-8</td><td>Fast and well paced.</td></tr>
<tr><td>8-11</td><td>Jitter clicking held for the whole test.</td></tr>
<tr><td>Over 11</td><td>Butterfly or drag clicking, or an exceptional jitter.</td></tr>
</tbody></table></div>
<p><strong>Consistency</strong> is 100% when every second had the same number of clicks. Above 85% is steady; below 70% means you came in bursts or faded badly. Your peak second minus your average shows how much speed you lose to fatigue.</p>',
	'extra'          => array(
		array(
			'Pacing a 10 second test',
			'<p>The common mistake is a sprint start. The arm tightens after three or four seconds and the last seconds collapse, which shows in the graph as a falling staircase. Start at about 90% of your top speed and keep it. You will usually finish with more clicks and a higher consistency score. If you are learning <a href="/jitter-click-test/">jitter clicking</a>, ten seconds is the length to practise, because it shows whether the vibration lasts.</p>',
			'pacing',
		),
		array(
			'10 seconds vs other lengths',
			'<p>A <a href="/1-second-cps-test/">1 second test</a> measures pure finger speed, five seconds is the shared benchmark, and ten seconds adds endurance. For stamina go to the <a href="/30-second-click-test/">30 second</a> or <a href="/60-second-click-test/">60 second click test</a>. Comparing your scores across lengths tells you whether to train speed or endurance.</p>',
			'lengths',
		),
	),
	'fixes'          => array(
		array( 'My arm hurts during the test', 'Stop and rest. Fast clicking for ten seconds strains the forearm, especially jitter clicking. Loosen your grip, keep sessions short and stretch the wrist between tries.' ),
		array( 'The consistency score is low', 'You started too fast or slowed in the middle. Look at the graph, then try a slightly slower start and hold it.' ),
		array( 'The count jumps by two', 'The switch may be double registering. Check with the <a href="/double-click-test/">double click test</a>.' ),
	),
	'faq'            => array(
		array( 'What is a good 10 second CPS?', 'Six to seven CPS is good for normal clicking over ten seconds. Nine or more means jitter or butterfly clicking.' ),
		array( 'How many clicks is a good score in 10 seconds?', 'Sixty to seventy clicks is a good score with one finger. Above 90 needs a technique such as jitter clicking.' ),
		array( 'What does consistency mean?', 'It compares the click count of each second with the others. 100% is a perfectly even rate; the lower it is, the more your pace changed.' ),
		array( 'Why is my 10 second CPS lower than 5 seconds?', 'Fatigue. The finger and forearm tire after a few seconds of maximum effort, so the second half of the test is slower.' ),
		array( 'Is this good practice for Minecraft PvP?', 'Yes. Fights last several seconds, so holding a rate for ten seconds is closer to real play than a one second burst.' ),
		array( 'Is my best score saved?', 'Yes, in this browser only, and it is shared with the 10 second option of the main CPS test.' ),
	),
	'related'        => array( '5-second-cps-test', '15-second-click-test', 'jitter-click-test', 'cps-test', '30-second-click-test', 'double-click-test' ),
	'updated'        => '2026-10-29',
);
