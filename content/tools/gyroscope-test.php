<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Gyroscope Test',
	'seo_title'      => 'Gyroscope Test: Check Your Phone Gyroscope Sensor Online',
	'description'    => 'Free online gyroscope test for Android and iPhone. See live rotation rate and tilt angles, run a drift check and a full-turn check to find a faulty gyro sensor.',
	'intro'          => 'Find out if your phone has a working gyroscope, straight from the browser. Tap Start, turn the phone and watch the 3D model follow it while the graph shows the rotation rate around each axis. Then run the drift check and the full-turn check to see how accurate the sensor is.',
	'device'         => 'touch',
	'device_message' => 'Laptops and desktop computers almost never have a gyroscope. Open this page on your phone or tablet to test it.',
	'ads'            => 'content',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'gyroscope-test' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage sn-stage">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="gy-start">Start gyroscope test</button>
		<button type="button" class="btn" id="gy-still" disabled>Drift check (10 s)</button>
		<button type="button" class="btn" id="gy-turn" disabled>Full turn check</button>
		<button type="button" class="btn btn-sm" id="gy-reset">Reset</button>
	</div>
	<div class="sn-scene" aria-hidden="true"><div class="sn-phone" id="gy-phone"></div></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Gyroscope</span><span class="stat-value" id="gy-has">-</span></div>
		<div class="stat"><span class="stat-label">Alpha (turn)</span><span class="stat-value" id="gy-a">-</span></div>
		<div class="stat"><span class="stat-label">Beta (tilt front/back)</span><span class="stat-value" id="gy-b">-</span></div>
		<div class="stat"><span class="stat-label">Gamma (tilt left/right)</span><span class="stat-value" id="gy-g">-</span></div>
	</div>
	<p class="sn-label">Rotation rate (degrees per second)</p>
	<div class="sn-legend"><span class="k0">X <b id="gy-rx">-</b></span><span class="k1">Y <b id="gy-ry">-</b></span><span class="k2">Z <b id="gy-rz">-</b></span></div>
	<canvas class="sn-graph" id="gy-graph" aria-label="Rotation rate graph"></canvas>
	<div class="stats">
		<div class="stat"><span class="stat-label">Peak rotation</span><span class="stat-value" id="gy-peak">0&deg;/s</span></div>
		<div class="stat"><span class="stat-label">Sample rate</span><span class="stat-value" id="gy-hz">-</span></div>
	</div>
	<div class="sn-result" id="gy-result" hidden></div>
</div>
<p class="tool-status" id="gy-status" aria-live="polite">Open this page on your phone and tap Start. On iPhone, tap Allow when Safari asks for motion access.</p>',
	'howto'          => array(
		'Open this page on your phone in Chrome, Samsung Internet or Safari and tap <strong>Start gyroscope test</strong>. On iPhone, tap <strong>Allow</strong> when Safari asks for access to motion and orientation.',
		'Turn and tilt the phone. The 3D phone should follow every movement smoothly and the three lines on the graph should jump when you rotate around each axis.',
		'Lay the phone flat on a table and tap <strong>Drift check</strong>. Do not touch it for 10 seconds; the result shows the bias and noise of the sensor.',
		'For the <strong>Full turn check</strong>, line the phone up with the edge of the table, tap the button, turn the phone one full circle flat on the table and tap Stop where you started.',
	),
	'howto_title'    => 'How to test your phone\'s gyroscope',
	'results'        => '<p>The page reads the gyroscope through the browser\'s motion events. Here is what each result tells you:</p>
<ul>
<li><strong>Gyroscope: Yes</strong> means the phone reports a rotation rate, so it has a working gyroscope chip.</li>
<li><strong>Gyroscope: No</strong> with tilt angles still moving means the phone has an accelerometer but no gyroscope. Many budget phones are built this way; tilt works, but fast turns, 360 degree photos and AR apps do not.</li>
<li><strong>No data</strong> means the browser sent nothing: a laptop, a blocked permission or a browser without motion support.</li>
<li><strong>Drift check:</strong> a healthy gyroscope reads within about 0.5 degrees per second of zero while it lies still. Readings of 2 degrees per second or more mean drift, which shows up as a view that slowly turns on its own in games and VR.</li>
<li><strong>Full turn check:</strong> within 10 degrees of 360 is accurate. Larger errors usually mean the turn was not exactly one circle, so repeat it before blaming the sensor.</li>
</ul>
<p>The sample rate is how often the browser delivers readings, usually 60 Hz. Browsers cap it, so it is lower than what the chip can do inside native apps.</p>',
	'extra'          => array(
		array(
			'What the gyroscope measures',
			'<p>A gyroscope measures how fast the phone rotates, in degrees per second, around three axes. <strong>X</strong> runs across the screen from left to right (tilting the top towards or away from you), <strong>Y</strong> runs from the bottom to the top of the screen (tilting the sides), and <strong>Z</strong> points out of the screen (turning the phone like a steering wheel or spinning it flat on a table). When the phone is still, all three read about zero.</p>
<p>The alpha, beta and gamma angles above are the phone\'s orientation, which the browser works out by combining the gyroscope with the accelerometer and, on some phones, the compass. The rotation rate graph is the raw gyroscope signal. To see how the gyroscope differs from the accelerometer, read <a href="/gyroscope-vs-accelerometer/">gyroscope vs accelerometer</a>, and try the <a href="/accelerometer-test/">accelerometer test</a> next.</p>',
			'axes',
		),
		array(
			'iPhone and Android notes',
			'<p>Every iPhone since the iPhone 4 has a gyroscope. Safari asks for permission before a website may read motion, and the prompt only appears after a tap, which is why the test needs the Start button. If you tapped Don\'t Allow, close Safari completely in the app switcher and open the page again to get the prompt back.</p>
<p>On Android, Chrome, Edge and Samsung Internet read the sensors without a prompt, unless motion sensors were turned off in the site settings. Some cheaper Android phones have no gyroscope at all; the page tells you so when the motion events arrive without a rotation rate. Firefox on Android also supports the test.</p>',
			'platforms',
		),
	),
	'fixes'          => array(
		array( 'The page says "No data"', 'Check that you opened the page on a phone, not a computer. In Chrome on Android, tap the lock icon next to the address, open Permissions and allow Motion sensors. On iPhone, close Safari fully and reopen the page so the permission prompt appears again.' ),
		array( 'The 3D phone drifts or turns on its own', 'That is gyroscope drift. Restart the phone first. Then lay it flat and still for a minute; most phones recalibrate the gyroscope automatically when they rest. Some Android phones have a manual sensor calibration under Settings, or a test menu (Samsung: dial *#0*# and open Sensor).' ),
		array( 'Games and AR apps say the phone has no gyroscope', 'If this test shows "Gyroscope: No", the phone does not have one and no setting can add it. A software "virtual gyroscope" built from the accelerometer and compass works for slow tilt but lags in fast games.' ),
		array( 'The gyroscope stopped after a drop', 'The sensor is part of a small chip on the main board and can be damaged by a hard knock. If the drift check shows large values on every run after a restart, a repair shop can confirm it; on most phones the fix is a board-level repair.' ),
	),
	'faq'            => array(
		array( 'How do I check if my phone has a gyroscope?', 'Open this page on the phone and tap Start. If the Gyroscope box says Yes and the graph moves when you turn the phone, it has one. "No" while the angles still move means it has only an accelerometer.' ),
		array( 'Does the gyroscope test work on iPhone?', 'Yes. Tap Start and then Allow in the Safari prompt. Every iPhone since the iPhone 4 has a gyroscope, so a "No data" result on iPhone almost always means the permission was refused.' ),
		array( 'What is a normal gyroscope drift?', 'Lying still, a good gyroscope reads within about 0.5 degrees per second of zero on each axis, and phones correct small offsets automatically. Several degrees per second while still points to a problem or a phone that moved.' ),
		array( 'Can I calibrate the gyroscope?', 'Usually it calibrates itself while the phone lies still. Some Android phones offer a calibration option in Settings or in a hidden test menu. iPhone has no manual option; a restart and a minute on a flat surface is the fix.' ),
		array( 'Why does the sample rate show 60 Hz when my phone does more?', 'Browsers deliver motion readings at a limited rate, usually tied to the screen refresh, to save battery and for privacy. Native apps can read the chip faster.' ),
		array( 'Is my motion data sent anywhere?', 'No. The readings are processed in your browser to draw the graph and are never uploaded.' ),
	),
	'related'        => array( 'accelerometer-test', 'compass-test', 'bubble-level', 'phone-sensor-test', 'touch-screen-test', 'vibration-test' ),
	'updated'        => '2026-10-29',
);
