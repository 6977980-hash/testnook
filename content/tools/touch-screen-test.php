<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Touch Screen Test',
	'seo_title'      => 'Touch Screen Test: Find Dead Zones and Test Multi-Touch',
	'description'    => 'Free touch screen test for phones, tablets and touch laptops. Draw to find dead zones, fill a grid to map unresponsive areas and count multi-touch points.',
	'intro'          => 'Draw on the box below with one or more fingers to see exactly where your touch screen responds. Switch to the grid to map dead zones, and use all your fingers to check multi-touch.',
	'device'         => 'touch',
	'device_message' => 'No touch screen was detected, so you can only draw with the mouse. Open this page on your phone, tablet or touch-screen laptop to test the touch screen itself.',
	'ads'            => 'content',
	'styles'         => array( 'touch-screen-test' ),
	'scripts'        => array( 'touch-screen-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Test mode">
		<button type="button" data-ts-mode="draw" aria-pressed="true">Draw</button>
		<button type="button" data-ts-mode="grid" aria-pressed="false">Grid</button>
	</div>
	<div class="seg" role="group" aria-label="Grid size" id="ts-gridsize" hidden>
		<button type="button" data-ts-grid="fine" aria-pressed="true">Fine</button>
		<button type="button" data-ts-grid="coarse" aria-pressed="false">Coarse</button>
	</div>
	<div class="btn-row">
		<button type="button" class="btn" id="ts-clear">Clear</button>
		<button type="button" class="btn" data-tn-fullscreen="#tool">Full screen</button>
	</div>
</div>
<div class="tool-stage ts-stage" id="ts-stage" aria-label="Touch area: draw here with one or more fingers">
	<canvas id="ts-ink"></canvas>
	<canvas id="ts-live"></canvas>
	<div class="ts-hint" id="ts-hint"><p><strong>Draw here with your finger.</strong><br>Try two, three or more fingers at once. Use full screen to test the edges.</p></div>
</div>
<div class="stats ts-stats">
	<div class="stat"><span class="stat-label">Touches now</span><span class="stat-value" id="ts-now">0</span></div>
	<div class="stat"><span class="stat-label">Max at once</span><span class="stat-value" id="ts-max">0</span></div>
	<div class="stat"><span class="stat-label">Grid covered</span><span class="stat-value" id="ts-cov">-</span></div>
	<div class="stat"><span class="stat-label">Input</span><span class="stat-value" id="ts-type">-</span></div>
</div>
<p class="tool-status" id="ts-status" aria-live="polite">Draw slow lines across the whole area. A line that breaks in the same spot each time marks a dead zone.</p>',
	'howto'          => array(
		'Remove any case edge that covers the screen and wipe the screen clean. Press <strong>Full screen</strong> so the test reaches the edges and corners.',
		'In <strong>Draw</strong> mode, drag one finger slowly across the screen in straight lines, top to bottom and left to right. Every line should be smooth and unbroken.',
		'Put two, three, four and then all five fingers down at once. Each finger gets its own colour and number, and <strong>Max at once</strong> shows how many touches your screen tracks.',
		'Switch to <strong>Grid</strong> and swipe over every square. Squares turn green when they respond; any square that stays grey after several tries is a dead zone.',
		'Press <strong>Clear</strong> to start over, and repeat with a stylus if you use one.',
	),
	'howto_title'    => 'How to test your touch screen',
	'results'        => '<ul>
<li><strong>Smooth, unbroken lines everywhere:</strong> the digitiser (the touch layer) is working normally.</li>
<li><strong>Lines break or jump in the same place every time:</strong> that area is a dead zone. It is usually hardware damage to the digitiser or its cable, often after a drop or a screen repair.</li>
<li><strong>Lines appear where you did not touch</strong> (ghost touches): the screen registers phantom input. Moisture, a charger with poor grounding, a cracked or badly fitted screen protector, or a failing digitiser are the usual causes.</li>
<li><strong>Grid squares near the edges stay grey:</strong> check that a case or protector is not covering them before blaming the screen.</li>
<li><strong>Max at once is 1:</strong> on a phone this points to a fault or an accessibility setting. Most phones and tablets track 5 or 10 touches; touch laptops usually 10.</li>
</ul>',
	'extra'          => array(
		array(
			'Dead zones, ghost touches and touch delay',
			'<p>A <strong>dead zone</strong> is a part of the screen that does not respond to touch. It shows up here as a gap in your lines or a grid square that will not turn green. A <strong>ghost touch</strong> is the opposite: the screen reacts on its own. Both are faults of the digitiser, the thin sensor layer above the display, and not of the picture itself. If the image also has dots or lines, run the <a href="/dead-pixel-test/">dead pixel test</a> to check the display panel separately.</p>
<p>Lag and missed taps can also come from software. If lines lag behind your finger, close other apps, restart the phone and try again. If the delay goes away, the touch screen is fine.</p>',
			'dead-zones',
		),
		array(
			'Testing a new or repaired phone',
			'<p>Run this screen touch test when you buy a used phone or collect a phone after a screen replacement. Cheap replacement screens often have weaker touch response at the edges or support fewer simultaneous touches. Test the corners in full screen, check at least five-finger multi-touch, and fill the whole grid. While you are at it, check the speakers with the <a href="/sound-test/">sound test</a> and the cameras with the <a href="/webcam-test/">webcam test</a>.</p>',
			'repaired-phones',
		),
	),
	'fixes'          => array(
		array( 'Touch screen not responding in some areas', 'Remove the case and screen protector, clean the screen, and restart the device. If the dead zone stays in exactly the same place, the digitiser is damaged and the screen assembly needs to be replaced.' ),
		array( 'Ghost touches or random taps', 'Unplug the charger (cheap chargers cause noise), dry your hands and the screen, and remove a cracked or bubbled screen protector. On Android, check for a "touch sensitivity" or "glove mode" setting and turn it off. Update the system software.' ),
		array( 'Touch is slow or inaccurate', 'Turn off battery saver, close background apps and restart. Android has no manual touch calibration, but a system update or a safe-mode boot shows whether an app is the cause. On Windows touch laptops, open Control Panel > Tablet PC Settings > Calibrate.' ),
		array( 'Multi-touch only shows one finger', 'Some accessibility features (Windows Touch feedback modes, Android "Ignore repeated touches", iPhone AssistiveTouch or Touch Accommodations) change how touches are handled. Turn them off and test again.' ),
	),
	'faq'            => array(
		array( 'How do I check my touch screen for dead spots?', 'Switch to Grid, press Full screen and swipe over every square. Any square that stays grey after several swipes is a dead spot.' ),
		array( 'How many touches should my phone support?', 'Most phones and tablets support 5 or 10 simultaneous touches. Put all fingers down and read Max at once.' ),
		array( 'Can this test a touch screen laptop or monitor?', 'Yes. It works on Windows touch laptops, Chromebooks, 2-in-1s and touch monitors in any modern browser.' ),
		array( 'Does a screen protector affect touch?', 'A thin, well-fitted protector does not. A thick, cracked or bubbled one can cause dead zones or ghost touches, especially near the edges.' ),
		array( 'Can a dead zone be fixed?', 'If cleaning, removing the protector and a restart do not help, it is hardware damage and the screen or digitiser must be replaced.' ),
		array( 'Does this touch screen test work with a stylus?', 'Yes. Pens and styluses are detected and shown as Stylus, so you can check their accuracy the same way.' ),
	),
	'related'        => array( 'dead-pixel-test', 'speaker-cleaner', 'online-mirror', 'camera-test', 'sound-test', 'burn-in-test' ),
	'updated'        => '2026-10-28',
);
