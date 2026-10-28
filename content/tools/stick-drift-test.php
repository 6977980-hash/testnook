<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Stick Drift Test',
	'seo_title'      => 'Stick Drift Test: Check Controller Joystick Drift Online',
	'description'    => 'Free stick drift test for PS5, PS4, Xbox, Switch Pro and PC controllers. See both joysticks live, measure resting drift in percent and find the right dead zone.',
	'intro'          => 'Find out if your controller has joystick drift. Connect it, leave the sticks alone and press Check drift: the test measures how far each stick sits from centre and tells you the dead zone you need.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome, Edge, Firefox or Safari on a computer, or a phone with a Bluetooth controller connected.',
	'ads'            => 'standard',
	'styles'         => array( 'stick-drift-test' ),
	'scripts'        => array( 'stick-drift-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="sd-check" disabled>Check drift</button>
		<button type="button" class="btn" id="sd-reset">Reset</button>
		<label class="visually-hidden" for="sd-pad">Controller</label>
		<select id="sd-pad" class="sd-select" hidden></select>
	</div>
	<div class="field sd-dz"><label for="sd-dz">Dead zone ring <output id="sd-dzout" for="sd-dz">10%</output></label><input type="range" id="sd-dz" min="0" max="30" step="1" value="10"></div>
</div>
<div class="tool-stage sd-stage">
	<div class="sd-stick">
		<h3>Left stick</h3>
		<canvas id="sd-c0" aria-label="Left stick position"></canvas>
		<div class="stats">
			<div class="stat"><span class="stat-label">X</span><span class="stat-value" id="sd-x0">0.000</span></div>
			<div class="stat"><span class="stat-label">Y</span><span class="stat-value" id="sd-y0">0.000</span></div>
			<div class="stat"><span class="stat-label">Distance</span><span class="stat-value" id="sd-d0">0%</span></div>
			<div class="stat"><span class="stat-label">At rest</span><span class="stat-value" id="sd-rest0">-</span></div>
			<div class="stat"><span class="stat-label">Outer range</span><span class="stat-value" id="sd-range0">-</span></div>
		</div>
	</div>
	<div class="sd-stick">
		<h3>Right stick</h3>
		<canvas id="sd-c1" aria-label="Right stick position"></canvas>
		<div class="stats">
			<div class="stat"><span class="stat-label">X</span><span class="stat-value" id="sd-x1">0.000</span></div>
			<div class="stat"><span class="stat-label">Y</span><span class="stat-value" id="sd-y1">0.000</span></div>
			<div class="stat"><span class="stat-label">Distance</span><span class="stat-value" id="sd-d1">0%</span></div>
			<div class="stat"><span class="stat-label">At rest</span><span class="stat-value" id="sd-rest1">-</span></div>
			<div class="stat"><span class="stat-label">Outer range</span><span class="stat-value" id="sd-range1">-</span></div>
		</div>
	</div>
</div>
<p class="tool-status" id="sd-status" aria-live="polite">No controller found yet. Connect it by USB or Bluetooth, then press any button on it.</p>',
	'howto'          => array(
		'Connect your controller by USB cable or Bluetooth, then <strong>press any button</strong> on it. Browsers only show a controller after a button press.',
		'Move both sticks. The dots should follow smoothly and return to the centre cross when you let go.',
		'Put the controller down on a table and press <strong>Check drift</strong>. After a 3-second countdown the test measures both sticks for 3 seconds while nobody touches them.',
		'Read <strong>At rest</strong> for each stick and the result line. Then slowly rotate each stick around its outer edge a few times to draw the green <strong>outer range</strong> circle.',
		'Use the <strong>Dead zone ring</strong> slider to see how large a dead zone would hide any drift you found.',
	),
	'howto_title'    => 'How to test for stick drift',
	'results'        => '<p><strong>At rest</strong> is how far the stick reports itself from the centre while untouched, as a percentage of full tilt. Every stick has a little noise, so small numbers are normal:</p>
<ul>
<li><strong>Under 5%:</strong> no drift. Default game dead zones hide this completely.</li>
<li><strong>5-12%:</strong> minor drift. You may notice slow camera creep in some games. A slightly larger dead zone or cleaning usually solves it.</li>
<li><strong>Over 12%:</strong> clear stick drift. Characters walk or the camera turns on its own. The stick module is worn or dirty.</li>
</ul>
<p><strong>Outer range</strong> is the average distance the stick reaches at full tilt. Around 100% (often 100-115% on the diagonals) is normal. Much lower than 100% in one direction means the stick cannot reach full tilt there, which feels like a sluggish turn in games. A dot that jitters or jumps while you hold the stick still is also a sign of a worn potentiometer.</p>',
	'extra'          => array(
		array(
			'What causes stick drift?',
			'<p>Most controllers measure stick position with small potentiometers: a wiper sliding over a resistive track. Over time the track wears, and dust, skin oils and debris get inside. The reading at rest then no longer matches the true centre, so the console thinks you are pushing the stick slightly. PS5 DualSense, PS4 DualShock 4, Xbox, Switch Joy-Con and Pro controllers can all develop drift, usually after a year or more of heavy use. Newer Hall effect and TMR sticks use magnets instead and are far less prone to wear.</p>',
			'causes',
		),
		array(
			'Joystick drift test for PS5, Xbox and Switch controllers',
			'<p>This joystick tester works with any controller your browser can see: PlayStation pads by USB or Bluetooth, Xbox controllers by USB, the wireless adapter or Bluetooth, Switch Pro controllers and most PC gamepads. To check every button and trigger as well, use the full <a href="/gamepad-tester/">gamepad tester</a>. If your mouse or keyboard is the problem instead, try the <a href="/mouse-tester/">mouse tester</a>.</p>',
			'controllers',
		),
	),
	'fixes'          => array(
		array( 'Clean the stick', 'Turn the controller off. Push the stick fully to one side and spray a short burst of compressed air under the cap, then rotate the stick in circles. Repeat for each direction. A little isopropyl alcohol (90%+) on a cotton swab around the base can help; let it dry fully before use.' ),
		array( 'Recalibrate the controller', 'On Xbox and PC, Windows has a calibration tool: press Win+R, type joy.cpl, select the controller, Properties > Settings > Calibrate. On Switch go to System Settings > Controllers and Sensors > Calibrate Control Sticks. PS5 has no calibration menu, but updating the controller firmware from Settings > Accessories can help.' ),
		array( 'Increase the dead zone', 'Most games have a dead zone setting under Controls or Advanced controller settings. Set it a few points above the At rest value this test shows. On Steam you can set dead zones per controller in Controller Settings.' ),
		array( 'Repair or replace', 'If cleaning does not help, the stick module is worn. Check the warranty first. Replacing the module needs soldering on most controllers; Hall effect replacement sticks fix drift for good on many models.' ),
	),
	'faq'            => array(
		array( 'How do I know if my controller has stick drift?', 'Put the controller down, press Check drift and wait six seconds. A resting value over about 12% means drift. You may also see the dot sit away from the centre cross.' ),
		array( 'Why does my controller not show up?', 'Press a button after connecting: browsers hide controllers until then. Also check that the cable carries data, not only charge, and that no other app has taken over the controller.' ),
		array( 'Can stick drift fix itself?', 'Sometimes dust works its way out and drift fades, but worn sticks usually get worse. Cleaning helps in many cases.' ),
		array( 'What dead zone should I use?', 'A few percent above the At rest value. Most games default to 5-15%. Too large a dead zone makes small aiming movements feel unresponsive.' ),
		array( 'Does this work for PS5 DualSense drift?', 'Yes. Connect the DualSense by USB-C or Bluetooth, press a button and run the test in Chrome, Edge, Firefox or Safari.' ),
		array( 'Is a little movement at rest normal?', 'Yes. Every analog stick reports small values at rest, usually 1-4%. Games ignore it with a small dead zone.' ),
	),
	'related'        => array( 'gamepad-tester', 'ps5-controller-test', 'xbox-controller-test', 'ps4-controller-test', 'keyboard-tester', 'mouse-tester' ),
	'updated'        => '2026-10-28',
);
