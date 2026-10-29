<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Accelerometer Test',
	'seo_title'      => 'Accelerometer Test: Check Your Phone\'s Motion Sensor Online',
	'description'    => 'Free accelerometer test. See live X, Y and Z acceleration and g-force, count shakes, check gravity reads 9.81 and find out why auto-rotate is not working.',
	'intro'          => 'Check your phone\'s accelerometer in the browser. Tap Start to see the acceleration on all three axes, the total g-force and a live graph, count shakes, and run a gravity check that shows whether the sensor reads 9.81 m/s&sup2; when the phone lies still. It also shows which way up the sensor thinks the phone is, which helps with auto-rotate problems.',
	'device'         => 'touch',
	'device_message' => 'Most laptops and desktop computers have no accelerometer that the browser can read. Open this page on your phone or tablet.',
	'ads'            => 'content',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'accelerometer-test' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage sn-stage">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="ac-start">Start accelerometer test</button>
		<button type="button" class="btn" id="ac-still" disabled>Gravity check (5 s)</button>
		<button type="button" class="btn btn-sm" id="ac-reset">Reset</button>
	</div>
	<div class="seg" role="group" aria-label="Graph mode"><button type="button" data-ac-mode="g" aria-pressed="true">With gravity</button><button type="button" data-ac-mode="lin" aria-pressed="false">Movement only</button></div>
	<p class="sn-label" id="ac-unit">Acceleration including gravity (m/s&sup2;)</p>
	<div class="sn-legend"><span class="k0">X <b id="ac-x">-</b></span><span class="k1">Y <b id="ac-y">-</b></span><span class="k2">Z <b id="ac-z">-</b></span></div>
	<canvas class="sn-graph" id="ac-graph" aria-label="Acceleration graph"></canvas>
	<div class="stats">
		<div class="stat"><span class="stat-label">Total</span><span class="stat-value" id="ac-total">-</span></div>
		<div class="stat"><span class="stat-label">Peak</span><span class="stat-value" id="ac-peak">-</span></div>
		<div class="stat"><span class="stat-label">Movement</span><span class="stat-value" id="ac-lin">-</span></div>
		<div class="stat"><span class="stat-label">Shakes</span><span class="stat-value" id="ac-shakes">0</span></div>
		<div class="stat"><span class="stat-label">Sensor says</span><span class="stat-value" id="ac-pose">-</span></div>
		<div class="stat"><span class="stat-label">Screen is</span><span class="stat-value" id="ac-screen">-</span></div>
		<div class="stat"><span class="stat-label">Sample rate</span><span class="stat-value" id="ac-hz">-</span></div>
	</div>
	<div class="sn-result is-bad" id="ac-rotate" hidden>The sensor says landscape but the screen stayed in portrait (or the other way round). The accelerometer is fine: auto-rotate is off, locked, or the app does not rotate. See <a href="/auto-rotate-not-working/">auto-rotate not working</a>.</div>
	<div class="sn-result" id="ac-result" hidden></div>
</div>
<p class="tool-status" id="ac-status" aria-live="polite">Open this page on your phone and tap Start. On iPhone, tap Allow when Safari asks for motion access.</p>',
	'howto'          => array(
		'Open this page on the phone and tap <strong>Start accelerometer test</strong>. On iPhone, tap <strong>Allow</strong> in the motion access prompt.',
		'Tilt the phone slowly. With gravity on, the line for the axis pointing up rises towards 9.8 and the others fall towards 0.',
		'Switch to <strong>Movement only</strong> and shake the phone. The graph should spike and the shake counter should count each shake.',
		'Lay the phone flat on a table and tap <strong>Gravity check</strong>. Keep still for 5 seconds and read the result.',
		'Turn the phone sideways and compare <strong>Sensor says</strong> with <strong>Screen is</strong> to see whether an auto-rotate problem is the sensor or a setting.',
	),
	'howto_title'    => 'How to test your phone\'s accelerometer',
	'results'        => '<p>An accelerometer measures acceleration in meters per second squared (m/s&sup2;) along three axes. Even lying still it feels gravity, so a phone flat on a table should read about <strong>X 0, Y 0, Z 9.81</strong>, which is 1 g in total.</p>
<ul>
<li><strong>Gravity check within 0.35 of 9.81:</strong> accurate. Phone sensors are often a few percent off, and up to 0.7 is still normal.</li>
<li><strong>X or Y above 0.5 while flat:</strong> the surface is not level, or the sensor has an offset. A level table and a second run tell the two apart.</li>
<li><strong>Total far from 1 g while still, or values frozen:</strong> a faulty sensor or a browser that blocks it.</li>
<li><strong>Peak:</strong> the highest total seen. A firm shake gives 2 to 3 g; most phone sensors cap at 8 or 16 g.</li>
<li><strong>Sensor says landscape, screen stays portrait:</strong> the sensor works and the problem is the rotation setting or the app.</li>
</ul>
<p>Movement only removes gravity, so it reads about zero when the phone is still and shows just the shaking or the motion of a car or a lift.</p>',
	'extra'          => array(
		array(
			'The three axes',
			'<p>Hold the phone upright in portrait, screen facing you. <strong>X</strong> runs left to right across the screen, <strong>Y</strong> runs from the bottom to the top, and <strong>Z</strong> comes out of the screen towards you. The browser uses the same directions on every phone. Safari on iPhone has long reported these readings with the opposite sign, so this page checks the sign against the tilt angles and corrects it, keeping the numbers the same on iPhone and Android.</p>
<p>The accelerometer cannot tell how fast the phone is turning, only which way gravity pulls and how hard the phone is pushed. Turning is the job of the gyroscope; see <a href="/gyroscope-vs-accelerometer/">gyroscope vs accelerometer</a> and the <a href="/gyroscope-test/">gyroscope test</a>.</p>',
			'axes',
		),
		array(
			'What the accelerometer is used for',
			'<p>Auto-rotate, the step counter, shake gestures, lift to wake, fall and crash detection, tilt games and the spirit level all start from the accelerometer. If several of these stop working at the same time, test the sensor here first. The <a href="/bubble-level/">bubble level</a> uses the same sensor to show whether a surface is flat.</p>',
			'uses',
		),
	),
	'fixes'          => array(
		array( 'No data on the phone', 'In Chrome on Android, tap the lock icon by the address, open Permissions and allow Motion sensors. On iPhone, close Safari fully and reopen the page so the Allow prompt appears again. Battery saver modes on some Android phones also pause sensors in the browser.' ),
		array( 'Auto-rotate does not work but the sensor does', 'If "Sensor says" changes when you turn the phone, the accelerometer is fine. Turn on Auto-rotate (Android quick settings) or turn off Portrait Orientation Lock (iPhone Control Center). Some apps and home screens never rotate.' ),
		array( 'The values are frozen or jump wildly', 'Restart the phone. If the gravity check still fails flat on a table, try the sensor test menu: Samsung phones open it by dialing *#0*# and tapping Sensor. A sensor that fails there too needs a repair.' ),
		array( 'Steps or shake gestures are not counted', 'Check the app has the physical activity permission (Android) or Motion & Fitness access (iPhone Settings > Privacy & Security). If the shake counter here works, the sensor is fine.' ),
	),
	'faq'            => array(
		array( 'How do I check if my accelerometer is working?', 'Open this page on the phone, tap Start and tilt the phone. If the numbers change and a flat phone reads about 9.81 on Z, the accelerometer works. Use the gravity check for a precise reading.' ),
		array( 'Why does the accelerometer show 9.8 when the phone is still?', 'An accelerometer feels gravity as an acceleration of 9.81 m/s&sup2; upwards. That is why it knows which way is down, and why the total reads 1 g at rest.' ),
		array( 'What is a g-force reading?', 'Total acceleration divided by 9.81. At rest it is 1 g; a quick shake can reach 2 to 3 g. The peak box keeps the highest value since you tapped Start.' ),
		array( 'Does the accelerometer test work on iPhone?', 'Yes, in Safari and every other iPhone browser. Tap Start and allow motion access. The page detects and corrects the reversed signs Safari can report, so the numbers match Android.' ),
		array( 'Can I calibrate the accelerometer?', 'iPhones calibrate it at the factory and have no user option. Some Android phones have a calibration option in Settings or in a hidden test menu. A gravity check here shows whether it is needed at all.' ),
		array( 'Is my motion data stored?', 'No. Everything is processed in your browser and nothing is uploaded.' ),
	),
	'related'        => array( 'gyroscope-test', 'bubble-level', 'compass-test', 'phone-sensor-test', 'vibration-test', 'touch-screen-test' ),
	'updated'        => '2026-10-29',
);
