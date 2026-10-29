<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Spacebar Clicker',
	'seo_title'      => 'Spacebar Clicker: Spacebar Counter and Speed Test (Free)',
	'description'    => 'Free spacebar clicker and counter. Press Space as fast as you can for 5 to 60 seconds, see presses per second, and check if your spacebar misses or repeats.',
	'intro'          => 'Press the spacebar as fast as you can and count every press. Pick a timed test for presses per second, or use the endless counter to check that your spacebar never misses or double-registers.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a physical keyboard. On a phone or tablet you can tap the big button instead, but the result is a tap test, not a spacebar test. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'spacebar-clicker' ),
	'share'          => true,
	'scripts'        => array( 'spacebar-clicker' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="seg sb-seg" role="group" aria-label="Mode">
		<button type="button" data-sb-t="0" aria-pressed="true">Counter</button>
		<button type="button" data-sb-t="5" aria-pressed="false">5 s</button>
		<button type="button" data-sb-t="10" aria-pressed="false">10 s</button>
		<button type="button" data-sb-t="30" aria-pressed="false">30 s</button>
		<button type="button" data-sb-t="60" aria-pressed="false">60 s</button>
	</div>
	<button type="button" class="btn btn-sm" id="sb-reset">Reset</button>
</div>
<div class="tool-stage sb-stage" id="sb-stage" tabindex="0" role="button">
	<div class="sb-count" id="sb-count">0</div>
	<div class="sb-key" id="sb-key"><span>Space</span></div>
	<p class="sb-hint" id="sb-hint">Click here, then press the spacebar.</p>
	<div class="sb-timer" id="sb-timer" hidden><span id="sb-left">5.0</span> s left</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Presses / second</span><span class="stat-value" id="sb-rate">0.0</span></div>
	<div class="stat"><span class="stat-label">Presses</span><span class="stat-value" id="sb-total">0</span></div>
	<div class="stat"><span class="stat-label">Fastest gap</span><span class="stat-value" id="sb-min">-</span></div>
	<div class="stat"><span class="stat-label">Held repeats</span><span class="stat-value" id="sb-rep">0</span></div>
</div>
<div class="sb-graph" id="sb-graph" aria-hidden="true"></div>
<div class="btn-row sb-foot"><span class="sb-pb" id="sb-pb"></span></div>
<p class="tool-status" id="sb-status" aria-live="polite">Click the box so it has focus, then press Space.</p>',
	'howto'          => array(
		'Click inside the box so the page can hear your keyboard. The box turns blue when it has focus.',
		'In <strong>Counter</strong> mode every press adds one, for as long as you like. Use it to check that the key registers once per press.',
		'Pick <strong>5 s</strong>, <strong>10 s</strong>, <strong>30 s</strong> or <strong>60 s</strong> for a speed test. The timer starts on your first press.',
		'Press the spacebar as fast as you can until the time runs out. The key picture lights up on each press.',
		'Read <strong>Presses per second</strong> and your total, then press <strong>Reset</strong> to go again.',
	),
	'howto_title'    => 'How to use the spacebar clicker',
	'results'        => '<p><strong>Presses per second</strong> is your total divided by the test length. Most people manage 6-8 per second with one thumb; 10-12 is fast; above 14 usually means two thumbs or a very light switch. Scores on the 5 second test are higher than on 60 seconds, because the thumb tires.</p>
<p><strong>Fastest gap</strong> is the shortest time between two presses. A gap under 25 ms that you did not make on purpose is a sign of a bouncing switch; a mechanical keyboard with dirt under the spacebar does this. <strong>Held repeats</strong> counts key-repeat events from holding the bar down; they are never added to your score.</p>
<p>If the counter does not rise for a press you clearly made, the key missed. A spacebar that misses now and then needs cleaning or, on a mechanical board, a new switch. Compare with the rest of the keyboard on the <a href="/keyboard-tester/">keyboard tester</a>.</p>',
	'extra'          => array(
		array(
			'What the spacebar counter is good for',
			'<p>The spacebar is the most pressed key on any keyboard, so it is the first to fail. Stabilizers rattle, the switch wears, crumbs collect underneath, and on laptops the membrane loses its click. A spacebar counter shows three faults quickly: presses that do not register, one press that counts as two (chatter), and a bar that only works when pressed in the middle.</p>
<p>Gamers use the spacebar speed test for bunny hopping, rhythm games and Minecraft, where fast and reliable jumps matter. Typists use it to check that the key keeps up with their pace. Try pressing at the left edge, the center and the right edge: a bar with worn stabilizers counts the center but misses the edges.</p>',
			'what-it-checks',
		),
	),
	'fixes'          => array(
		array( 'Presses are not counted', 'Click inside the test box first so it has keyboard focus. If presses still vanish, the key is missing. Pull the keycap on a mechanical keyboard and clean under it, or test with another keyboard to rule out the key.' ),
		array( 'One press counts as two', 'That is switch chatter. Blow compressed air into the switch, or on a hot-swap keyboard replace the spacebar switch. Some keyboard software has a debounce setting that hides light chatter.' ),
		array( 'The spacebar only works in the middle', 'The stabilizer wires are bent or unclipped. Remove the keycap, re-seat the stabilizer and add a little grease. On laptops, a bent keycap clip has the same effect and needs the cap replaced.' ),
		array( 'The page scrolls when I press Space', 'Space is captured inside the test box. Click the box first; if the page still scrolls, a browser extension may be intercepting keys.' ),
	),
	'faq'            => array(
		array( 'How fast can you press the spacebar?', 'Most people press 6 to 8 times per second. Fast gamers reach 10 to 14. Anything faster usually uses two thumbs or a key with a very short travel.' ),
		array( 'How do I test if my spacebar is working?', 'Use Counter mode and press the bar 50 times, slowly and in different spots. The counter should read exactly 50. A lower number means missed presses; a higher one means the switch is double registering.' ),
		array( 'Does holding the spacebar count?', 'No. Key-repeat events from holding the bar are counted separately under "Held repeats" and never add to your score.' ),
		array( 'Does the spacebar clicker work on a phone?', 'You can tap the big Space button on the screen and it counts taps, but that tests your thumb, not a physical spacebar.' ),
		array( 'What is a good spacebar CPS?', 'Around 8 presses per second on a 10 second test is good. Scores are lower than mouse CPS because the thumb moves more than a finger on a mouse button.' ),
		array( 'Is my best score saved?', 'Your best presses per second for each test length is stored in this browser only. Nothing is uploaded.' ),
	),
	'related'        => array( 'keyboard-tester', 'typing-speed-test', 'cps-test', 'reaction-time-test', 'double-click-test', 'mouse-tester' ),
	'updated'        => '2026-10-28',
);
