<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '1 Second CPS Test',
	'seo_title'      => '1 Second CPS Test: How Many Clicks in One Second? (Free)',
	'description'    => 'Free 1 second CPS test. Click as fast as you can for one second and see your burst click speed with typical scores. The timer starts on your first click.',
	'intro'          => 'One second, as many clicks as you can. This is a pure burst test: there is no time to get tired, so it shows the top speed of your finger and your mouse switch. The timer starts on your first click and your best one second score is saved in this browser.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 600,
	'tool'           => $tool( 1 ),
	'howto'          => array(
		'Rest your finger on the left mouse button and point at the box.',
		'Click as fast as you can. The one second countdown starts on your first click, so that click already counts.',
		'Keep clicking until the ring empties. The result is your clicks in that second, which is also your CPS.',
		'Click again to retry straight away. Burst scores vary a lot, so take your best of five rather than the first try.',
	),
	'howto_title'    => 'How to take the 1 second CPS test',
	'results'        => '<p>In a one second test your clicks per second is simply the number of clicks you landed. Because the first click starts the timer and counts, a score of 7 means seven presses inside one second.</p>
<div class="table-scroll"><table>
<thead><tr><th>Clicks in 1 s</th><th>What it usually means</th></tr></thead>
<tbody>
<tr><td>Under 5</td><td>Relaxed or careful clicking.</td></tr>
<tr><td>5-7</td><td>Normal fast clicking with one finger.</td></tr>
<tr><td>7-9</td><td>A very fast finger and a light switch.</td></tr>
<tr><td>9-13</td><td>Jitter clicking, or two fingers alternating.</td></tr>
<tr><td>Over 13</td><td>Butterfly or drag clicking, or a switch that double registers.</td></tr>
</tbody></table></div>
<p>Expect your one second score to be one or two clicks higher than your 5 second CPS: nobody slows down inside a single second. If it is much higher than that, your speed falls off quickly and a <a href="/10-second-cps-test/">10 second test</a> will show where.</p>',
	'extra'          => array(
		array(
			'Why a one second test is tricky',
			'<p>At this length one click either way changes your score by a whole CPS, so the result jumps between tries. Reaction matters too: the timer starts on your first press, so a hesitant second click wastes part of the second. Start already moving, as if you were in the middle of a run, and the score settles.</p>
<p>The mouse plays a bigger role here than in long tests. A switch with a short reset and a light press lets the finger cycle faster, while a heavy or mushy switch caps you at a lower rate however fast you are. If two mice give very different one second scores, the switch is the reason.</p>',
			'tricky',
		),
		array(
			'Burst speed in games',
			'<p>Short bursts are what most games actually need: a quick combo in Minecraft PvP, spamming an ability, or clicking through a fast quick-time event. The one second score is the speed you can reach for those moments. For longer fights the <a href="/5-second-cps-test/">5 second CPS test</a> is the better benchmark, and the <a href="/jitter-click-test/">jitter click test</a> shows whether a technique holds up.</p>',
			'games',
		),
	),
	'fixes'          => array(
		array( 'My score changes every time', 'That is normal for a one second test, where one click is one whole CPS. Do five tries and keep the best, or use the 5 second test for a steadier number.' ),
		array( 'Some clicks are not counted', 'Keep the pointer inside the box. If the count stays low while you are clicking hard, the mouse may be dropping presses; check it with the <a href="/mouse-tester/">mouse tester</a>.' ),
		array( 'The score is suspiciously high', 'A worn switch can register two clicks for one press. Run the <a href="/double-click-test/">double click test</a>; if it catches double clicks, the extra speed is the fault, not your finger.' ),
	),
	'faq'            => array(
		array( 'What is a good 1 second CPS?', 'Seven or eight clicks in one second is very good for normal clicking. Ten or more usually means jitter or butterfly clicking.' ),
		array( 'Is a 1 second CPS test accurate?', 'It is accurate for what it measures, the clicks you land in one second, but it varies a lot because each click is a whole CPS. Take the best of several tries.' ),
		array( 'Why is my 1 second score higher than my 5 second score?', 'You do not tire in one second and you can hold your breath for the whole test. Over five seconds the finger slows slightly, so the average drops.' ),
		array( 'Does the first click count?', 'Yes. The first click starts the timer and counts as click number one.' ),
		array( 'Can I use both mouse buttons?', 'Tick "Count right clicks too" and alternate left and right. That is how butterfly-style scores above 10 are reached.' ),
		array( 'Is my best score saved?', 'Yes, in this browser only. It is shared with the 1 second option of the main CPS test.' ),
	),
	'related'        => array( '5-second-cps-test', '10-second-cps-test', 'cps-test', 'jitter-click-test', 'double-click-test', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
