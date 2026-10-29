<?php
defined( 'ABSPATH' ) || exit;

$diagram = require __DIR__ . '/_gamepad-diagram.php';

return array(
	'title'          => 'PS5 Controller Test',
	'seo_title'      => 'PS5 Controller Test: Check DualSense Buttons and Drift',
	'description'    => 'Free PS5 controller test for PC, Mac and phone. Check every DualSense button, L2/R2 trigger travel, both sticks for drift, the touchpad click and rumble.',
	'intro'          => 'Plug in your DualSense with a USB-C cable or pair it by Bluetooth, then press any button. Every button, trigger and stick lights up as you use it, so a dead Cross button, a weak R2 or a drifting stick shows up in seconds.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome, Edge, Firefox or Safari on a computer, or a phone with the DualSense paired by Bluetooth.',
	'ads'            => 'standard',
	'styles'         => array( 'gamepad-tester' ),
	'scripts'        => array( 'gamepad-tester' ),
	'embed_height'   => 820,
	'tool'           => $diagram(
		'ps5',
		array( '✕', '○', '□', '△', 'L1', 'R1', 'L2', 'R2', 'Create', 'Options', 'L3', 'R3', 'Up', 'Down', 'Left', 'Right', 'PS', 'Touchpad' )
	),
	'howto'          => array(
		'Connect the DualSense to your computer or phone with a USB-C data cable, or pair it: hold <strong>Create</strong> and the <strong>PS</strong> button until the light bar flashes, then pick "DualSense Wireless Controller" in Bluetooth settings.',
		'Press any button so the browser reveals the controller. The name and "Standard" mapping appear in the boxes under the diagram.',
		'Press Cross, Circle, Square and Triangle, the D-pad, L1, R1, Create, Options, the PS button and the touchpad click. Each one turns green once it has registered.',
		'Squeeze L2 and R2 slowly. The bar should rise smoothly from 0 to 100%. Then move both sticks in full circles and press them in for L3 and R3.',
		'Let go of both sticks and watch the numbers under them. Press <strong>Test vibration</strong> to check the rumble motors.',
	),
	'howto_title'    => 'How to test a PS5 controller',
	'results'        => '<ul>
<li><strong>All 18 buttons turn green:</strong> every input on the DualSense works. The mute button is not visible to browsers, so it does not appear.</li>
<li><strong>A button never lights up:</strong> it is not registering. Press it hard a few times. Cross and Circle wear first on heavily used pads.</li>
<li><strong>L2 or R2 stops short of 100%:</strong> anything from 95% up is normal. A trigger that stops at 60-80% or jumps in steps has a worn sensor, or the adaptive trigger is stuck in a game\'s resistance mode; turn the controller off and on to reset it.</li>
<li><strong>Stick numbers are not 0.00 at rest:</strong> values up to about 0.05 are normal and games hide them with a dead zone. Above 0.10 is stick drift, which DualSense controllers are known for. Measure it exactly with the <a href="/stick-drift-test/">stick drift test</a>.</li>
<li><strong>Touchpad shows as "Touchpad":</strong> that is the touchpad click. Browsers do not report the touch surface itself or the motion sensors.</li>
</ul>',
	'extra'          => array(
		array(
			'DualSense stick drift: what it is and what to do',
			'<p>Stick drift means a stick reports movement when nobody touches it, so your character walks or the camera turns on its own. On the DualSense it is caused by wear inside the analog stick module: the carbon tracks of its potentiometers wear down and dust gets in, so the resting position no longer reads as the center. It usually starts small, a reading of 0.06 to 0.15 at rest, and grows over months.</p>
<p>Before you open the controller, try the easy steps: update the controller in the PS5 settings (Accessories, Controllers, Wireless Controller Device Software), blow compressed air around the base of the stick while rotating it, and reset the controller with a pin in the small hole on the back for five seconds. If drift stays above 0.10, the stick module needs replacing. Sony repairs it under warranty in the first year, and the DualSense Edge has swappable stick modules for exactly this reason.</p>',
			'drift',
		),
		array(
			'What this PS5 controller tester can and cannot check',
			'<p>Browsers read the DualSense through the standard gamepad layout: 18 buttons, two analog triggers and four stick axes. That covers every button you press in a game, the trigger travel, both sticks and the basic rumble motors. The adaptive trigger resistance, the haptic patterns, the motion sensors, the touch surface, the light bar and the built-in microphone are not available to web pages, so test those on the console itself or with the <a href="/mic-test/">mic test</a> for the microphone.</p>
<p>A DualSense Edge works here too: the back paddles show up in the raw list as extra buttons when the browser reports them. For an Xbox or PS4 pad, use the <a href="/xbox-controller-test/">Xbox controller test</a> or the <a href="/ps4-controller-test/">PS4 controller test</a>, or the general <a href="/gamepad-tester/">gamepad tester</a> for any other controller.</p>',
			'limits',
		),
	),
	'fixes'          => array(
		array( 'The DualSense is not detected on PC', 'Press a button after connecting: browsers only reveal a controller after an input. Use a USB-C cable that carries data, since many phone charging cables do not. Close Steam or DS4Windows if they are running, because they can take exclusive control.' ),
		array( 'Bluetooth pairing fails', 'Remove "DualSense Wireless Controller" from the Bluetooth list, then hold Create and PS until the light bar flashes quickly and pair again. If it still fails, reset the controller with a pin in the small hole on the back, next to the Sony logo.' ),
		array( 'A face button or the D-pad is sticky', 'Turn the controller off. Work a cotton swab with a little isopropyl alcohol around the edge of the button while pressing it repeatedly, then let it dry for ten minutes. If the button is still dead, the contact under it is worn.' ),
		array( 'Vibration does not work in the test', 'Rumble from a web page works best in Chrome and Edge over USB. Over Bluetooth on Windows, browsers often cannot send rumble to a DualSense even though the motors are fine, so try a cable before assuming a fault.' ),
	),
	'faq'            => array(
		array( 'How do I test my PS5 controller on PC?', 'Connect it with a USB-C cable or Bluetooth, open this page and press any button. Then press every button, squeeze both triggers and move both sticks; each input lights up when it works.' ),
		array( 'How do I check my PS5 controller for stick drift?', 'Let go of both sticks and read the numbers under them. Values above 0.10 at rest mean drift. The stick drift test measures it over three seconds and suggests a dead zone.' ),
		array( 'Can I test a PS5 controller on my phone?', 'Yes. Pair the DualSense with your Android phone or iPhone by Bluetooth, then open this page in Chrome or Safari and press a button.' ),
		array( 'Does this test the adaptive triggers?', 'It tests how far L2 and R2 travel, from 0 to 100%. The adaptive resistance and haptic feedback are not available to web pages.' ),
		array( 'Does it work with the DualSense Edge?', 'Yes. All standard buttons, triggers and sticks show on the diagram, and the back buttons appear in the raw list if your browser reports them.' ),
		array( 'Why does the touchpad only show as a button?', 'Browsers report the touchpad click as button 17 but not the touch position. Click the pad to test it.' ),
	),
	'related'        => array( 'stick-drift-test', 'ps4-controller-test', 'xbox-controller-test', 'gamepad-tester', 'mic-test', 'reaction-time-test' ),
	'updated'        => '2026-10-28',
);
