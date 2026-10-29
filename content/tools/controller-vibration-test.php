<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Controller Vibration Test',
	'seo_title'      => 'Controller Vibration Test: Check PS5, Xbox and PC Rumble',
	'description'    => 'Free controller vibration test for PS5, PS4, Xbox and PC gamepads. Test the left and right rumble motors at any strength, play patterns and check Xbox trigger rumble.',
	'intro'          => 'Check that your controller\'s rumble works. Test the left (strong) and right (weak) motors on their own or together, set any strength and duration, and play pulse, heartbeat and ramp patterns. On Xbox controllers in Chrome or Edge you can also test the trigger motors.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome or Edge on a computer for the best vibration support.',
	'ads'            => 'standard',
	'styles'         => array( 'controller-vibration-test' ),
	'scripts'        => array( 'controller-vibration-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<label class="visually-hidden" for="cv-pad">Controller</label>
	<select id="cv-pad" class="cv-select" hidden></select>
	<button type="button" class="btn" id="cv-stop">Stop</button>
</div>
<div class="tool-stage cv-stage" aria-hidden="true">
	<div class="cv-motor"><i id="cv-motor-l"></i><b>Left motor</b>strong, low rumble</div>
	<div class="cv-motor"><i id="cv-motor-r"></i><b>Right motor</b>weak, high buzz</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Controller</span><span class="stat-value" id="cv-name">None</span></div>
	<div class="stat"><span class="stat-label">Vibration</span><span class="stat-value" id="cv-support">-</span></div>
	<div class="stat"><span class="stat-label">Trigger rumble</span><span class="stat-value" id="cv-trig">-</span></div>
</div>
<div class="cv-actions" role="group" aria-label="Vibration patterns">
	<button type="button" class="btn btn-sm" data-cv-shape="left" disabled>Left motor</button>
	<button type="button" class="btn btn-sm" data-cv-shape="right" disabled>Right motor</button>
	<button type="button" class="btn btn-sm" data-cv-shape="both" disabled>Both, full</button>
	<button type="button" class="btn btn-sm" data-cv-shape="gentle" disabled>Gentle</button>
	<button type="button" class="btn btn-sm" data-cv-shape="pulse" disabled>Pulse</button>
	<button type="button" class="btn btn-sm" data-cv-shape="heartbeat" disabled>Heartbeat</button>
	<button type="button" class="btn btn-sm" data-cv-shape="ramp" disabled>Ramp up</button>
	<button type="button" class="btn btn-sm cv-trig" data-cv-trigger="left" disabled>Left trigger</button>
	<button type="button" class="btn btn-sm cv-trig" data-cv-trigger="right" disabled>Right trigger</button>
</div>
<div class="cv-controls">
	<div class="field"><label for="cv-strong">Strong motor <output id="cv-strongout" for="cv-strong">100%</output></label><input type="range" id="cv-strong" min="0" max="100" step="5" value="100"></div>
	<div class="field"><label for="cv-weak">Weak motor <output id="cv-weakout" for="cv-weak">100%</output></label><input type="range" id="cv-weak" min="0" max="100" step="5" value="100"></div>
	<div class="field"><label for="cv-dur">Duration <output id="cv-durout" for="cv-dur">1000 ms</output></label><input type="range" id="cv-dur" min="100" max="5000" step="100" value="1000"></div>
</div>
<div class="cv-actions"><button type="button" class="btn btn-primary" id="cv-play" disabled>Vibrate</button></div>
<div class="cv-feel" id="cv-feel" hidden><span id="cv-feel-q">Did you feel it?</span> <button type="button" class="btn btn-sm" data-cv-felt="yes">Yes</button> <button type="button" class="btn btn-sm" data-cv-felt="weak">Weak or uneven</button> <button type="button" class="btn btn-sm" data-cv-felt="no">No</button></div>
<p class="tool-status" id="cv-status" aria-live="polite">Connect a controller and press any button on it.</p>',
	'howto'          => array(
		'Connect the controller by USB cable (most reliable) or Bluetooth, open this page in Chrome or Edge and press any button on the controller so the browser can see it.',
		'Hold the controller in both hands as you would in a game.',
		'Press <strong>Left motor</strong>, then <strong>Right motor</strong>. The left motor gives a deep rumble, the right one a lighter, faster buzz. Each should be clearly felt on its own side.',
		'Try the patterns, or set the strong and weak motors and the duration yourself and press <strong>Vibrate</strong>.',
		'Answer whether you felt it. On Xbox controllers, also try <strong>Left trigger</strong> and <strong>Right trigger</strong> if they appear.',
	),
	'howto_title'    => 'How to test controller vibration',
	'results'        => '<p>Most controllers have two rumble motors with offset weights. The <strong>strong motor</strong> (left handle) spins a heavy weight for deep rumble, such as explosions. The <strong>weak motor</strong> (right handle) spins a lighter weight for fine buzzes, such as engine hum. Xbox One and Series controllers add two small <strong>impulse trigger</strong> motors behind LT and RT.</p>
<ul>
<li><strong>Both sides work and scale with the slider:</strong> the rumble is fine.</li>
<li><strong>One side is silent or much weaker:</strong> that motor is worn, loose or disconnected. Motors can be replaced on most controllers.</li>
<li><strong>Rattling or grinding:</strong> the weight may be rubbing on the shell or a broken piece is loose inside.</li>
<li><strong>Nothing at all, but buttons work in the <a href="/gamepad-tester/">gamepad tester</a>:</strong> usually the browser, connection or a vibration setting, not the controller. See the fixes below.</li>
</ul>
<p>The PS5 DualSense uses voice-coil haptics instead of spinning motors. Browsers drive them with the same commands, so you feel a rumble, but the adaptive triggers cannot be tested from a web page.</p>',
	'extra'          => array(
		array(
			'Which controllers and browsers support vibration?',
			'<p>Chrome and Edge on Windows, macOS, Linux, ChromeOS and Android support rumble on Xbox One, Xbox Series, PS4 DualShock 4, PS5 DualSense, Switch Pro and most XInput PC controllers. Trigger rumble works on Xbox controllers in Chrome and Edge on Windows. Safari supports rumble on recent macOS and iOS versions with many controllers. Firefox has limited support. A USB cable is the most reliable connection; some controllers do not accept rumble commands over Bluetooth on every system.</p>',
			'support',
		),
		array(
			'More controller tests',
			'<p>Vibration is only one part of a controller. Check every button, trigger and stick in the <a href="/gamepad-tester/">gamepad tester</a>, measure joystick drift with the <a href="/stick-drift-test/">stick drift test</a>, or use the dedicated pages for the <a href="/ps5-controller-test/">PS5 controller</a>, the <a href="/xbox-controller-test/">Xbox controller</a> and <a href="/joy-con-drift-test/">Joy-Con drift</a>. For phone vibration, use the <a href="/vibration-test/">vibration test</a>.</p>',
			'more-tests',
		),
	),
	'fixes'          => array(
		array( 'The browser sees the controller but nothing vibrates', 'Use Chrome or Edge and connect with a USB cable. Close Steam or turn off Steam Input for the browser, as it can take over the controller. In DS4Windows or similar tools, check that rumble is enabled.' ),
		array( 'Vibration is turned off in settings', 'On Xbox controllers check the Xbox Accessories app (Windows) for vibration settings. For a PS5 controller paired with a PS5, check Settings > Accessories > Controllers > Vibration Intensity; for PS4, Settings > Devices > Controllers > Enable Vibration.' ),
		array( 'Only one motor works', 'Run the left and right motor buttons a few times. If one side stays silent, the motor wire may have come loose or the motor has failed. Many controllers can be opened and the motor replaced; otherwise contact the manufacturer if it is under warranty.' ),
		array( 'The controller does not appear at all', 'Press a button on it after the page loads: browsers only show controllers once they have been used. Then check the connection with the <a href="/gamepad-tester/">gamepad tester</a>.' ),
	),
	'faq'            => array(
		array( 'How do I test my controller vibration?', 'Connect the controller, open this page in Chrome or Edge and press any button. Then press Left motor and Right motor to feel each one, or set a strength and press Vibrate.' ),
		array( 'Does this work with a PS5 controller?', 'Yes. Chrome and Edge make the DualSense rumble through its haptic motors. The adaptive trigger resistance cannot be tested in a browser.' ),
		array( 'Can I test Xbox impulse triggers?', 'Yes, in Chrome or Edge with an Xbox One or Series controller. The Left trigger and Right trigger buttons appear when the browser supports trigger rumble.' ),
		array( 'Why does my controller not vibrate on my phone?', 'Many mobile browsers ignore rumble commands over Bluetooth. Try Chrome on Android with the latest system update, or test on a computer with a USB cable.' ),
		array( 'What is the difference between the strong and weak motor?', 'The strong motor has a heavy weight for deep, powerful rumble; the weak motor has a light weight for faster, finer vibration. Games mix the two for different effects.' ),
		array( 'Is it bad to run vibration at full power?', 'No, short tests at full power are what the motors are made for. Long continuous rumble drains a wireless controller\'s battery quickly, so do not leave it running.' ),
	),
	'related'        => array( 'gamepad-tester', 'stick-drift-test', 'ps5-controller-test', 'xbox-controller-test', 'joy-con-drift-test', 'ps4-controller-test', 'vibration-test', 'keyboard-ghosting-test' ),
	'updated'        => '2026-10-29',
);
