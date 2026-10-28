<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mouse Tester',
	'seo_title'      => 'Mouse Tester: Test Every Mouse Button and Wheel Online',
	'description'    => 'Free online mouse tester. Check left, right and middle clicks, side buttons and scroll wheel up and down. See each button light up and count every click.',
	'intro'          => 'Click, scroll and press the side buttons over the mouse below. Every button lights up when it works and keeps a count, so a faulty switch or wheel shows up straight away.',
	'device'         => 'desktop',
	'device_message' => 'This mouse test needs a mouse. Connect one to your computer, or use a laptop with a mouse attached. On a phone or tablet, taps count as left clicks only; use the <a href="/touch-screen-test/">touch screen test</a> to check the screen instead.',
	'ads'            => 'standard',
	'styles'         => array( 'mouse-tester' ),
	'scripts'        => array( 'mouse-tester' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-bar">
	<span class="mt-hint">Keep the pointer inside the grey area while you test.</span>
	<button type="button" class="btn btn-sm" id="mt-reset">Reset</button>
</div>
<div class="tool-stage mt-stage" id="mt-stage" tabindex="0" aria-describedby="mt-status">
	<div class="mt-mouse" aria-hidden="true">
		<div class="mt-part mt-left" data-mt="0"><span>L</span></div>
		<div class="mt-part mt-right" data-mt="2"><span>R</span></div>
		<div class="mt-wheel">
			<div class="mt-part mt-up" data-mt="up">&#9650;</div>
			<div class="mt-part mt-mid" data-mt="1">M</div>
			<div class="mt-part mt-down" data-mt="down">&#9660;</div>
		</div>
		<div class="mt-part mt-side mt-fwd" data-mt="4">5</div>
		<div class="mt-part mt-side mt-back" data-mt="3">4</div>
		<div class="mt-body"></div>
	</div>
</div>
<div class="stats mt-stats">
	<div class="stat"><span class="stat-label">Left</span><span class="stat-value" data-mt-count="0">0</span></div>
	<div class="stat"><span class="stat-label">Right</span><span class="stat-value" data-mt-count="2">0</span></div>
	<div class="stat"><span class="stat-label">Middle</span><span class="stat-value" data-mt-count="1">0</span></div>
	<div class="stat"><span class="stat-label">Back (4)</span><span class="stat-value" data-mt-count="3">0</span></div>
	<div class="stat"><span class="stat-label">Forward (5)</span><span class="stat-value" data-mt-count="4">0</span></div>
	<div class="stat"><span class="stat-label">Scroll up</span><span class="stat-value" data-mt-count="up">0</span></div>
	<div class="stat"><span class="stat-label">Scroll down</span><span class="stat-value" data-mt-count="down">0</span></div>
</div>
<p class="tool-status" id="mt-status" aria-live="polite">Waiting for your first click.</p>',
	'howto'          => array(
		'Move the pointer over the grey test area.',
		'Click the <strong>left</strong>, <strong>right</strong> and <strong>middle</strong> (wheel) buttons one at a time. Each part of the picture turns blue while held and green once it has worked.',
		'Roll the scroll wheel <strong>up</strong> and <strong>down</strong> a few notches each way. The page will not scroll while the pointer is over the test area.',
		'Press the <strong>side buttons</strong> (back and forward, also called buttons 4 and 5) if your mouse has them. The tester blocks them from leaving the page.',
		'Compare the counters with the number of times you pressed. Press <strong>Reset</strong> to start over.',
	),
	'howto_title'    => 'How to use the mouse tester',
	'results'        => '<p>Every button that turns green is detected by your computer and works. The counters tell you more:</p>
<ul>
<li><strong>Count matches your presses:</strong> the switch is healthy.</li>
<li><strong>Count is higher than your presses</strong> (for example 2 after one click): the switch is bouncing and your mouse may be double clicking. Confirm with the <a href="/double-click-test/">double click test</a>, which measures the gap between clicks.</li>
<li><strong>Count is lower, or a button never turns green:</strong> the switch is failing, the button is remapped in your mouse software, or the browser does not receive it.</li>
<li><strong>Scroll goes the wrong way</strong> (an up roll adds to "Scroll down"): the wheel encoder is dirty or worn. A few wrong-way counts while rolling fast is a classic sign.</li>
</ul>',
	'extra'          => array(
		array(
			'What this mouse test checks',
			'<p>The mouse tester listens to the same events every website and game receives: button presses (left, right, middle, back and forward) and wheel movement. That makes it a quick, honest mouse button test for new mice, second-hand mice and gaming mice before the warranty runs out. It works with wired, wireless and Bluetooth mice and with laptop touchpads (a two-finger tap counts as a right click).</p>
<p>Extra buttons beyond the five standard ones (DPI switches, sniper buttons, profile buttons) are usually handled by the mouse driver and never reach the browser, so they will not light up here. That is normal.</p>',
			'what-it-checks',
		),
	),
	'fixes'          => array(
		array( 'Left click sometimes double clicks or drops a drag', 'This is switch bounce, usually from a worn or dirty micro switch. Blow compressed air around the button edge, update the mouse firmware, and if your mouse software has a "debounce time" setting, raise it a little. If it keeps happening, the switch needs replacing or the mouse should go back under warranty.' ),
		array( 'Right click or a side button does nothing', 'Open your mouse software (Logitech G Hub, Razer Synapse, SteelSeries GG and so on) and check the button is not remapped or disabled. On Windows, also check Settings > Bluetooth & devices > Mouse > "Primary mouse button" is set as you expect.' ),
		array( 'Scroll wheel jumps or scrolls the wrong way', 'Dust in the wheel encoder causes skipped or reversed steps. Spin the wheel hard in both directions while blowing compressed air into the gap. For wireless mice, also replace the battery, because low power can make the wheel erratic.' ),
		array( 'Side buttons go back a page', 'Back and forward are blocked while the pointer is inside the test area. If your browser still navigates, keep the pointer inside the grey box, or test in Chrome or Edge, which honour the block reliably.' ),
	),
	'faq'            => array(
		array( 'How do I test my mouse buttons?', 'Hover over the test area and press each button once. Each one that turns green works. Check that the counters match the number of presses.' ),
		array( 'How do I know if my mouse is broken?', 'A button that never lights up, counts two clicks for one press, or a wheel that counts the wrong direction points to a hardware fault. Try the fixes above, then test the mouse on another computer to rule out software.' ),
		array( 'Can I test the side buttons on my mouse?', 'Yes. Buttons 4 and 5 (back and forward) are detected and counted, and the tester stops them from leaving the page while the pointer is inside the test area.' ),
		array( 'Does this mouse test work with wireless mice?', 'Yes. Wired, wireless and Bluetooth mice all send the same events. If clicks are missed only on wireless, check the battery and move the receiver closer.' ),
		array( 'Why does my mouse double click when I click once?', 'The switch is bouncing, sending two signals for one press. It usually gets worse over time. Our double click test measures how often it happens.' ),
		array( 'Can I check my mouse DPI or polling rate here?', 'Not on this page. Use the <a href="/dpi-analyzer/">DPI analyzer</a> to measure your real DPI and the <a href="/mouse-polling-rate-test/">polling rate test</a> to measure how often it reports.' ),
	),
	'related'        => array( 'double-click-test', 'cps-test', 'scroll-test', 'dpi-analyzer', 'mouse-polling-rate-test', 'keyboard-tester', 'reaction-time-test' ),
	'updated'        => '2026-10-28',
);
