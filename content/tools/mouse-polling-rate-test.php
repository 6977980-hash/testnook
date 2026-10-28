<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mouse Polling Rate Test',
	'seo_title'      => 'Mouse Polling Rate Test: Check Your Mouse Hz Online',
	'description'    => 'Free mouse polling rate test. Move your mouse to measure how often it reports per second, see the nearest standard rate from 125 to 8000 Hz, and fix a low one.',
	'intro'          => 'Measure how often your mouse reports its position to the computer. Press start and move the mouse in fast circles inside the box; after a second or two you get the rate in Hz and the nearest standard setting.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a mouse. Touch screens and trackpads do not have a polling rate the browser can measure, so use a computer with a mouse. For a touch screen, try the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'standard',
	'styles'         => array( 'mouse-polling-rate-test' ),
	'scripts'        => array( 'mouse-polling-rate-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="pr-start">Start</button>
		<button type="button" class="btn" id="pr-reset">Reset</button>
		<button type="button" class="btn" data-tn-fullscreen="#tool">Full screen</button>
	</div>
</div>
<div class="tool-stage pr-stage" id="pr-stage">
	<div class="pr-hint" id="pr-hint"><p><strong>Move the mouse here in fast circles.</strong>Click or press Start, then keep it moving. Each second the box counts how many position reports arrived.</p></div>
</div>
<div class="stats pr-stats">
	<div class="stat"><span class="stat-label">Reports this second</span><span class="stat-value" id="pr-live">-</span></div>
	<div class="stat"><span class="stat-label">Measured rate</span><span class="stat-value" id="pr-avg">-</span></div>
	<div class="stat"><span class="stat-label">Nearest standard</span><span class="stat-value" id="pr-nominal">-</span></div>
	<div class="stat"><span class="stat-label">Report interval</span><span class="stat-value" id="pr-interval">-</span></div>
	<div class="stat"><span class="stat-label">Best second</span><span class="stat-value" id="pr-max">-</span></div>
	<div class="stat"><span class="stat-label">Reports total</span><span class="stat-value" id="pr-samples">-</span></div>
</div>
<canvas class="pr-graph" id="pr-graph" width="800" height="160" aria-label="Reports per second over the last ten seconds"></canvas>
<p class="pr-mode" id="pr-mode"></p>
<p class="tool-status" id="pr-status" aria-live="polite">Press Start, then move the mouse in fast circles inside the box.</p>',
	'howto'          => array(
		'Close other heavy programs and unplug any second mouse so only the one you want to test is moving.',
		'Press <strong>Start</strong> (or just click in the box) and move the mouse in fast, wide circles. Keep it moving the whole time: a mouse only reports when it moves, so pauses lower the count.',
		'After two or three seconds, read <strong>Measured rate</strong>. The <strong>Nearest standard</strong> box rounds it to the rate your mouse is most likely set to: 125, 250, 500, 1000, 2000, 4000 or 8000 Hz.',
		'For a wired mouse, try a different USB port if the rate is lower than expected. For a wireless mouse, test with the receiver close to the mouse and then with the cable, if it has one.',
		'Press <strong>Stop</strong> to keep the result on screen, or <strong>Reset</strong> to start a new run after changing a setting in your mouse software.',
	),
	'howto_title'    => 'How to test your mouse polling rate',
	'results'        => '<p><strong>Polling rate</strong> is how many times per second the mouse sends its position to the computer. 125 Hz means a report every 8 ms, 500 Hz every 2 ms, 1000 Hz every 1 ms. A higher rate makes the cursor track more smoothly and reduces the delay between a hand movement and the screen, which matters in fast games. For office work, 125 Hz is unnoticeable.</p>
<ul>
<li><strong>125 Hz:</strong> the USB default and what most office and wireless mice use to save battery. Normal unless you have a gaming mouse set higher.</li>
<li><strong>500 Hz:</strong> common on older gaming mice and on many wireless gaming mice.</li>
<li><strong>1000 Hz:</strong> the usual gaming setting. Almost every gaming mouse supports it.</li>
<li><strong>2000-8000 Hz:</strong> new high-rate mice. Only reachable on a cable or a dedicated high-rate receiver, and only measurable here in a browser that counts every report (see the note under the graph).</li>
</ul>
<p>The measured rate is normally a little under the nominal one, for example 980 Hz for a 1000 Hz mouse, because the computer drops the odd report and the mouse does not move in every slot. A reading far below the setting, or one that swings around, points to a slow USB port, a bad wireless link or a busy computer.</p>',
	'results_title'  => 'What your polling rate means',
	'extra'          => array(
		array(
			'How the polling rate test counts reports',
			'<p>Browsers normally bundle all the mouse movement that happens between two screen refreshes into one event, so a simple counter would never read more than your refresh rate, usually 60 or 144. This test uses the <em>coalesced events</em> feature of the Pointer Events API, which hands over every report the mouse made inside each bundle, each with its own timestamp. The rate is taken from the median gap between those reports, which is steadier than counting per second, and the count per second is shown too so you can see dips. Chrome, Edge and Firefox support coalesced events; Safari counts only one event per frame, so the result there caps at the refresh rate.</p>
<p>Any polling rate test, including the ones in mouse software, only measures while the mouse is moving fast enough to produce a report in every slot. Slow movement shows a lower number because the sensor has nothing to report. That is why the instructions say fast circles.</p>',
			'how-it-works',
		),
		array(
			'Does a higher polling rate help?',
			'<p>Going from 125 Hz to 1000 Hz cuts the worst-case input delay by about 7 ms and makes the cursor noticeably smoother on a high-refresh monitor, so it is worth turning on if your mouse supports it. Going from 1000 Hz to 4000 or 8000 Hz saves under a millisecond more and costs CPU time in some games, so it is mostly for competitive players with powerful computers. If a game stutters after you raise the rate, drop back to 1000 Hz. To check the other side of mouse precision, measure your sensor with the <a href="/dpi-analyzer/">DPI analyzer</a>, and check the buttons and wheel with the <a href="/mouse-tester/">mouse tester</a> and the <a href="/scroll-test/">scroll test</a>.</p>',
			'higher-rate',
		),
	),
	'fixes'          => array(
		array( 'The rate is stuck at 125 Hz on a gaming mouse', 'Open the mouse software (Logitech G Hub, Razer Synapse, SteelSeries GG, Corsair iCUE, Glorious Core) and set the polling rate to 1000 Hz. Some mice have a switch on the bottom or a button combination for it; check the manual. Then press Reset here and move again.' ),
		array( 'The reading is half of the setting', 'A mouse set to 1000 Hz that reads 500 is usually on a slow USB hub, a keyboard pass-through port or a USB 2.0 port shared with other devices. Plug it straight into the computer. On wireless mice, the lower rate can be the battery-saving mode or a weak signal: move the receiver closer.' ),
		array( 'The rate jumps around', 'The computer is busy. Close other programs, stop downloads and pause video, then test again. Wireless interference from USB 3 ports, Wi-Fi routers or other 2.4 GHz devices near the receiver also causes an unstable count.' ),
		array( 'The result never goes above my screen refresh rate', 'Your browser is not reporting coalesced events, so it caps the count at one per frame. Use Chrome, Edge or Firefox. The note under the graph says whether coalesced events are on.' ),
	),
	'faq'            => array(
		array( 'What is mouse polling rate?', 'How many times per second the mouse tells the computer where it is, measured in Hz. 1000 Hz is one report every millisecond.' ),
		array( 'What polling rate should my mouse be?', '1000 Hz for gaming if the mouse supports it. 125 or 500 Hz is fine for everyday use and saves battery on wireless mice.' ),
		array( 'Why does the test show less than 1000 Hz?', 'Small drops to 950-990 Hz are normal. Much lower means slow movement, a slow USB port, a weak wireless link or a busy computer.' ),
		array( 'Can I measure a wireless mouse here?', 'Yes. The rate over wireless depends on the receiver and battery mode, so it is often lower than on a cable.' ),
		array( 'Can this test measure 4000 or 8000 Hz?', 'Yes in Chrome, Edge and Firefox, which pass every report to the page. Safari limits the count to the screen refresh rate.' ),
		array( 'Does polling rate affect DPI?', 'No. DPI is how far the cursor moves per inch of mouse travel; polling rate is how often it updates. Measure DPI with the DPI analyzer.' ),
	),
	'related'        => array( 'mouse-tester', 'dpi-analyzer', 'scroll-test', 'double-click-test', 'cps-test', 'refresh-rate-test' ),
	'updated'        => '2026-10-28',
);
