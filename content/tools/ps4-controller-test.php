<?php
defined( 'ABSPATH' ) || exit;

$diagram = require __DIR__ . '/_gamepad-diagram.php';

return array(
	'title'          => 'PS4 Controller Test',
	'seo_title'      => 'PS4 Controller Test: Check DualShock 4 Buttons Online',
	'description'    => 'Free PS4 controller test for PC, Mac and phone. Check every DualShock 4 button, L2/R2 trigger travel, both sticks for drift, the touchpad click and rumble.',
	'intro'          => 'Connect your DualShock 4 with a micro-USB cable or Bluetooth and press any button. Every button, trigger and stick lights up live, so you can check a used PS4 controller or find the button that stopped working.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome, Edge, Firefox or Safari on a computer, or a phone with the DualShock 4 paired by Bluetooth.',
	'ads'            => 'standard',
	'styles'         => array( 'gamepad-tester' ),
	'scripts'        => array( 'gamepad-tester' ),
	'embed_height'   => 820,
	'tool'           => $diagram(
		'ps4',
		array( '✕', '○', '□', '△', 'L1', 'R1', 'L2', 'R2', 'Share', 'Options', 'L3', 'R3', 'Up', 'Down', 'Left', 'Right', 'PS', 'Touchpad' )
	),
	'howto'          => array(
		'Connect the DualShock 4 with a micro-USB data cable, or pair it: hold <strong>Share</strong> and the <strong>PS</strong> button until the light bar double-flashes, then pick "Wireless Controller" in Bluetooth settings.',
		'Press any button so the browser can see the controller. Its name and mapping appear under the diagram.',
		'Press Cross, Circle, Square, Triangle, the D-pad, L1, R1, Share, Options, PS and the touchpad click. Each one turns green when it registers.',
		'Squeeze L2 and R2 slowly to check they reach 100%. Move both sticks in full circles and press them in for L3 and R3.',
		'Let go of the sticks and read the resting values, then press <strong>Test vibration</strong>.',
	),
	'howto_title'    => 'How to test a PS4 controller',
	'results'        => '<ul>
<li><strong>All 18 buttons turn green:</strong> every input works.</li>
<li><strong>L2 or R2 jumps or stops short:</strong> anything above 95% is fine. The DualShock 4 triggers have springs that crack with age, which makes the trigger feel loose and stop early.</li>
<li><strong>Stick reads over 0.10 at rest:</strong> stick drift. Older DS4 pads drift often; the <a href="/stick-drift-test/">stick drift test</a> measures how much.</li>
<li><strong>Buttons light up on their own or the controller disconnects when you move it:</strong> a loose battery connector or a cracked micro-USB port, both common on older DualShock 4s.</li>
<li><strong>The diagram shows the wrong buttons:</strong> the mapping says "Non-standard", usually in older browsers. The raw list under the diagram is always accurate.</li>
</ul>',
	'extra'          => array(
		array(
			'Using a DualShock 4 on PC',
			'<p>Windows, macOS, Android and iOS all support the DualShock 4 without extra software, and Chrome, Edge, Firefox and Safari read it with the standard layout. That is all this test needs. Tools like DS4Windows make the controller look like an Xbox pad to games, which is handy for older PC games, but while they run they can hide the real controller or show it twice. If you see two controllers in the list, pick the one called "Wireless Controller" or close DS4Windows.</p>
<p>The DualShock 4 comes in two versions: the original (CUH-ZCT1) and the newer one with a light strip in the touchpad (CUH-ZCT2), which also works over USB as a wired controller. Both test the same here. For the newer PlayStation pad, use the <a href="/ps5-controller-test/">PS5 controller test</a>; for Xbox pads, the <a href="/xbox-controller-test/">Xbox controller test</a>.</p>',
			'pc',
		),
		array(
			'Common DualShock 4 problems',
			'<p>The DualShock 4 is old enough that most second-hand pads have some wear. The usual faults, in order: stick drift, a weak or loose R2 trigger, a battery that lasts under two hours, a micro-USB port that only charges at an angle, and sticky face buttons. This test catches all the input faults in a minute. Battery life you can only judge by playing, and a port that charges only at an angle should be repaired before it fails completely.</p>',
			'faults',
		),
	),
	'fixes'          => array(
		array( 'PS4 controller not detected on PC', 'Press a button after connecting. Use a micro-USB cable that carries data, since many only charge. Close DS4Windows and Steam if they are open and reload the page.' ),
		array( 'Bluetooth pairing fails', 'Remove "Wireless Controller" from the Bluetooth list, then reset the controller with a pin in the small hole on the back near the L2 button for five seconds. Hold Share and PS until the light bar double-flashes and pair again.' ),
		array( 'Controller disconnects or the light bar flickers', 'Usually a loose battery plug inside, or a worn micro-USB port. Try it on a cable: if it stays connected on USB but drops on Bluetooth, the battery or its connector is the problem.' ),
		array( 'Vibration does not work', 'Use Chrome or Edge over a USB cable; rumble over Bluetooth is not always supported by browsers. Check that vibration is enabled in your system or game settings.' ),
	),
	'faq'            => array(
		array( 'How do I test my PS4 controller on PC?', 'Connect it with a micro-USB cable or Bluetooth, open this page and press any button. Then press every button, squeeze both triggers and move both sticks.' ),
		array( 'How do I check a PS4 controller for drift?', 'Let go of both sticks and read the numbers. Values above 0.10 mean drift. The stick drift test measures it exactly.' ),
		array( 'Do I need DS4Windows to test it?', 'No. Browsers read the DualShock 4 directly. DS4Windows can even get in the way, so close it if the controller does not show up.' ),
		array( 'Can I test a PS4 controller on my phone?', 'Yes. Pair it by Bluetooth with your Android phone or iPhone, then open this page and press a button.' ),
		array( 'Does this test the touchpad and light bar?', 'It tests the touchpad click. The touch surface, light bar, speaker and motion sensors are not available to web pages.' ),
		array( 'Is a used PS4 controller worth buying?', 'If every button turns green, both triggers reach 100% and both sticks rest under 0.10, it is in good working order.' ),
	),
	'related'        => array( 'stick-drift-test', 'ps5-controller-test', 'xbox-controller-test', 'gamepad-tester', 'reaction-time-test', 'mouse-tester' ),
	'updated'        => '2026-10-28',
);
