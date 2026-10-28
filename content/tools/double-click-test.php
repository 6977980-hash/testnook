<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Double Click Test',
	'seo_title'      => 'Double Click Test: Is Your Mouse Double Clicking? (Free)',
	'description'    => 'Free double click test. Click once in the box: if your mouse sends two clicks within 80 ms, the switch is faulty. See the gap between clicks and how to fix it.',
	'intro'          => 'Does your mouse open two windows or drop files when you click once? Click in the box below a few times. The test times every click and catches any extra click that happens too fast to be yours.',
	'device'         => 'desktop',
	'device_message' => 'This test is for a mouse. On a touch screen, taps are counted but a double-tap fault cannot be told apart from two taps. Check a touch screen with the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'double-click-test' ),
	'scripts'        => array( 'double-click-test' ),
	'embed_height'   => 600,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Button to test">
		<button type="button" data-dc-btn="0" aria-pressed="true">Left button</button>
		<button type="button" data-dc-btn="2" aria-pressed="false">Right button</button>
		<button type="button" data-dc-btn="1" aria-pressed="false">Middle</button>
	</div>
	<div class="dc-thresh field"><label for="dc-ms">Fault threshold <output id="dc-msout" for="dc-ms">80 ms</output></label><input type="range" id="dc-ms" min="30" max="150" step="10" value="80"></div>
</div>
<div class="tool-stage dc-stage" id="dc-stage" tabindex="0">
	<div class="dc-area" id="dc-area"><strong id="dc-big">Click here once at a time</strong><span id="dc-last">Single clicks are normal. A second click arriving within 80 ms is a fault.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Clicks</span><span class="stat-value" id="dc-count">0</span></div>
	<div class="stat"><span class="stat-label">Faulty doubles</span><span class="stat-value" id="dc-bad">0</span></div>
	<div class="stat"><span class="stat-label">Last gap</span><span class="stat-value" id="dc-gap">-</span></div>
	<div class="stat"><span class="stat-label">Fastest gap</span><span class="stat-value" id="dc-min">-</span></div>
</div>
<div class="dc-log" id="dc-log" aria-live="off"></div>
<div class="btn-row dc-foot"><button type="button" class="btn btn-sm" id="dc-reset">Reset</button></div>
<p class="tool-status" id="dc-status" aria-live="polite">Click in the box about 20 times, one clear click at a time.</p>',
	'howto'          => array(
		'Choose the button you want to test (left is the usual culprit).',
		'Click inside the box <strong>once at a time</strong>, with a short pause between clicks. Do 20-30 clicks.',
		'Each click adds a bar to the timeline. A green bar is a normal click. A <strong>red</strong> bar is a second click that arrived within 80 ms of the previous one, which is faster than a human can click on purpose.',
		'Try clicking at different speeds and pressures, and hold the button for a moment before releasing, because a worn switch often fails on release.',
		'Read the <strong>Faulty doubles</strong> counter. Press <strong>Reset</strong> to start again.',
	),
	'howto_title'    => 'How to test for double clicking',
	'results'        => '<p><strong>Faulty doubles = 0</strong> after 20-30 clicks: your mouse switch is working. If you still get double clicks in Windows, the problem is a setting (see the fixes).</p>
<p><strong>One or more red bars:</strong> the switch is bouncing. Each red bar is a click your mouse sent on its own. Even one or two in thirty clicks is enough to drop files, open two windows and mis-fire in games, and it usually gets worse over weeks.</p>
<p>The <strong>gap</strong> values show the time between consecutive clicks. Intentional double clicks by a person are normally 120 ms or more apart, so anything under 80 ms is treated as a fault. Lower the threshold slider if you are a very fast clicker and want to be strict; raise it if you suspect the switch but see no red bars.</p>',
	'extra'          => array(
		array(
			'Why does a mouse double click on its own?',
			'<p>Each mouse button has a tiny metal micro switch. Over hundreds of thousands of presses the spring contact wears and oxidises, and instead of one clean "on" it bounces: on, off, on in a few milliseconds. The mouse firmware normally filters bounce for a short window (debounce), but a worn switch bounces for longer than that window and the computer sees two clicks. Dust and static can cause the same thing on a nearly new mouse, which is why cleaning sometimes helps.</p>
<p>This double click test uses the browser\'s high resolution timer to measure the gap between every <em>mousedown</em> event, so it sees exactly what your games and apps see.</p>',
			'why',
		),
	),
	'fixes'          => array(
		array( 'Raise the debounce time in the mouse software', 'Razer Synapse, Logitech G Hub and many other apps have a "debounce" or "click delay" setting. Raising it a few milliseconds hides light bounce. It is a workaround, not a repair, but it can buy months.' ),
		array( 'Clean the switch', 'Unplug the mouse, hold the button half-pressed and blow compressed air into the gap at the front edge. A drop of contact cleaner on a cotton bud near the switch helps with oxidised contacts. Let it dry fully before plugging in.' ),
		array( 'Check Windows settings if the test shows no fault', 'If this test is clean but Windows still double clicks, open Settings > Bluetooth & devices > Mouse > Additional mouse settings and lower the "Double-click speed" slider. Also check File Explorer is not set to "Single-click to open an item".' ),
		array( 'Replace the switch or the mouse', 'Micro switches cost very little and can be soldered in by a repair shop, or at home if you are handy. If the mouse is under warranty, claim it: double clicking is a well-known fault and most brands replace the mouse.' ),
	),
	'faq'            => array(
		array( 'How do I know if my mouse is double clicking?', 'Click in the test box one click at a time. If the test shows a red bar or the "Faulty doubles" counter goes up, your mouse sent an extra click you did not make.' ),
		array( 'Why does my mouse double click when I click once?', 'The micro switch under the button is worn or dirty and "bounces", sending two signals for one press. It is the most common mouse fault, especially on gaming mice after a year or two.' ),
		array( 'Can I fix a double clicking mouse?', 'Often. Raise the debounce setting in the mouse software, clean the switch with compressed air or contact cleaner, or have the switch replaced. If it is under warranty, ask for a replacement.' ),
		array( 'What is the fault threshold?', 'The shortest gap between two clicks that a person could make on purpose. We use 80 ms by default. Clicks closer together than that are counted as a fault.' ),
		array( 'Does the test work for the right button?', 'Yes. Select Right button or Middle in the toolbar. The context menu is blocked inside the test box so right clicks register cleanly.' ),
		array( 'Does this double click test work on a laptop touchpad?', 'Yes. Taps and physical touchpad clicks are counted the same way. Touchpad faults are rarer, but the test will show them.' ),
	),
	'related'        => array( 'mouse-tester', 'cps-test', 'scroll-test', 'mouse-polling-rate-test', 'reaction-time-test', 'keyboard-tester' ),
	'updated'        => '2026-10-28',
);
