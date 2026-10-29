<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Right Click CPS Test',
	'seo_title'      => 'Right Click CPS Test: Right Mouse Button Speed Test (Free)',
	'description'    => 'Free right click CPS test. Right click as fast as you can for 1 to 100 seconds, see your right clicks per second and peak CPS, and spot a button that misses.',
	'intro'          => 'The same CPS test, for the other button. Pick a time, right click inside the box as fast as you can and the timer starts on your first right click. Left clicks are ignored, the context menu is blocked, and you get right clicks per second, peak CPS and a rank.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a mouse or a touchpad with a right button. On a touch screen a tap counts as a click, so the result is a tap test rather than a right click test. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'share'          => true,
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="seg cps-seg" role="group" aria-label="Test length">
		<button type="button" data-cps-t="1" aria-pressed="false">1 s</button>
		<button type="button" data-cps-t="5" aria-pressed="true">5 s</button>
		<button type="button" data-cps-t="10" aria-pressed="false">10 s</button>
		<button type="button" data-cps-t="30" aria-pressed="false">30 s</button>
		<button type="button" data-cps-t="60" aria-pressed="false">60 s</button>
		<button type="button" data-cps-t="100" aria-pressed="false">100 s</button>
	</div>
	<span class="cps-opt">Right button only</span>
</div>
<div class="tool-stage cps-stage" id="cps-stage" data-cps-mode="right" tabindex="0" role="button">
	<div class="cps-ring" id="cps-ring"><span id="cps-timer">5.0</span><small>seconds</small></div>
	<div class="cps-msg"><strong id="cps-big">Right click here to start</strong><span id="cps-small">The timer starts on your first right click.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Right clicks / second</span><span class="stat-value" id="cps-cps">0.0</span></div>
	<div class="stat"><span class="stat-label">Right clicks</span><span class="stat-value" id="cps-count">0</span></div>
	<div class="stat"><span class="stat-label">Peak CPS</span><span class="stat-value" id="cps-peak">0.0</span></div>
	<div class="stat"><span class="stat-label">Rank</span><span class="stat-value" id="cps-rank">-</span></div>
</div>
<div class="cps-graph" id="cps-graph" aria-hidden="true"></div>
<div class="btn-row cps-foot"><button type="button" class="btn btn-sm" id="cps-reset">Reset</button><span class="cps-pb" id="cps-pb"></span></div>
<p class="tool-status" id="cps-status" aria-live="polite">Pick a time, then right click in the box as fast as you can.</p>',
	'howto'          => array(
		'Pick a test length. <strong>5 seconds</strong> is the standard; 1 second is a burst test and 100 seconds shows how quickly your finger tires.',
		'Right click inside the box. The countdown starts on your first right click, so there is no ready-steady-go delay.',
		'Keep right clicking until the timer reaches zero. The live counter shows your right clicks per second as you go.',
		'Read your <strong>CPS</strong> (right clicks divided by the seconds), your peak second and your rank. Press <strong>Reset</strong> or right click again for another round.',
		'Left clicks and middle clicks are ignored inside the box, so you cannot pad the score by accident.',
	),
	'howto_title'    => 'How to take the right click CPS test',
	'results'        => '<p>Right click CPS is the number of right mouse button presses per second, averaged over the test. Most people are slower with the right button than the left: the middle finger is weaker than the index finger, and the right switch on many mice is stiffer because it is used less.</p>
<div class="table-scroll"><table>
<thead><tr><th>Right click CPS (5 s)</th><th>Rank</th><th>Typical of</th></tr></thead>
<tbody>
<tr><td>Under 4</td><td>Turtle</td><td>Careful single right clicks.</td></tr>
<tr><td>4-6</td><td>Rabbit</td><td>Normal fast clicking with the middle finger.</td></tr>
<tr><td>6-8</td><td>Fox</td><td>Practiced players who block and place with the right button.</td></tr>
<tr><td>8-10</td><td>Cheetah</td><td>Jitter clicking on the right button.</td></tr>
<tr><td>Over 10</td><td>Lightning</td><td>Butterfly or drag clicking on the right button.</td></tr>
</tbody></table></div>
<p><strong>Peak CPS</strong> is your fastest single second, and the graph shows each second of the test. A right click score that is far below your <a href="/cps-test/">left click CPS</a> is normal; a score of almost zero while you are clearly clicking means the button is not registering, so read the fixes below.</p>',
	'extra'          => array(
		array(
			'Why test the right mouse button?',
			'<p>In Minecraft, right click places blocks, eats, uses bows and blocks with a shield, so bridging and "god bridging" speed depend on right click CPS as much as the left button matters for PvP. In shooters the right button aims down sights, in strategy games it moves units, and in everyday use it opens menus. A right button that misses one press in twenty is annoying in a menu and costly in a game.</p>
<p>The test counts the raw <code>pointerdown</code> event for button 2, so every press the browser receives is counted, including presses so fast that the operating system would merge them into a double click. The context menu is blocked inside the box only; it works everywhere else on the page.</p>',
			'why-right-click',
		),
		array(
			'How to right click faster',
			'<p>Rest the heel of your hand on the desk and the pad of your middle finger on the button; a hovering finger is slower because it has to travel. Press from the finger joint, not the wrist. Jitter clicking works on the right button too: tense the forearm so the hand vibrates, but keep the sessions short. Butterfly clicking (index and middle finger alternating on the right button) needs a mouse where the left and right buttons sit close together. A mouse with a light optical switch and a short pre-travel helps more than any technique.</p>',
			'faster',
		),
	),
	'fixes'          => array(
		array( 'Right clicks are not counted', 'Keep the pointer inside the box; clicks elsewhere do not count and open the normal context menu. If the counter stays at zero while you right click in the box, the browser is not receiving button 2. Try another browser, check that no mouse software has remapped the right button, and test with the <a href="/mouse-tester/">mouse tester</a>.' ),
		array( 'The context menu keeps opening', 'The menu is blocked inside the box. If it still appears, left click once inside the box so the page has focus and try again. On a Mac, Control + click is sent as a right click and is counted.' ),
		array( 'My right click score is much lower than my left', 'That is normal. The middle finger is slower and the right switch is often stiffer. Compare right click scores with other right click scores, not with left click leaderboards.' ),
		array( 'Some clicks are missing or doubled', 'A worn switch can bounce and register two presses, or miss a press entirely. Run the <a href="/double-click-test/">double click test</a>: it checks the left button by default, and ticking the right button option checks this one.' ),
	),
	'faq'            => array(
		array( 'What is a good right click CPS?', 'Around 5 right clicks per second is good for normal clicking, 7-8 is fast, and 10 or more means jitter or butterfly clicking. Most people score about one CPS lower than with the left button.' ),
		array( 'Why is right clicking slower than left clicking?', 'The index finger is stronger and more practiced than the middle finger, and on many mice the right switch has a slightly heavier feel. The difference shrinks with a few rounds of practice.' ),
		array( 'Does the right click CPS test count left clicks?', 'No. Inside the box only button 2, the right button, is counted. Left and middle clicks are ignored so the score reflects the right button only.' ),
		array( 'Does right click CPS matter in Minecraft?', 'Yes. Placing blocks, bridging, eating and shield blocking all use right click, so a faster right button means faster bridging and quicker reactions in PvP.' ),
		array( 'Can I take this test on a touchpad?', 'Yes, if the touchpad has a right click zone or two-finger tap enabled. Two-finger taps are slower than a mouse button, so expect a lower score.' ),
		array( 'Is my best score saved?', 'Your best right click CPS for each test length is stored in this browser only. Nothing is sent anywhere.' ),
	),
	'related'        => array( 'cps-test', 'jitter-click-test', 'auto-clicker-test', 'double-click-test', 'mouse-tester', 'reaction-time-test' ),
	'updated'        => '2026-10-28',
);
