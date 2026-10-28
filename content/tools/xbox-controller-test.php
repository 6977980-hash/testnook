<?php
defined( 'ABSPATH' ) || exit;

$diagram = require __DIR__ . '/_gamepad-diagram.php';

return array(
	'title'          => 'Xbox Controller Test',
	'seo_title'      => 'Xbox Controller Test: Check Buttons, Triggers and Drift',
	'description'    => 'Free Xbox controller test for Xbox One, Series X|S and Elite pads. Check every button, LT/RT trigger travel, both sticks for drift and the rumble motors online.',
	'intro'          => 'Connect your Xbox controller by USB, Bluetooth or the Xbox Wireless Adapter and press any button. Each button, trigger and stick lights up live, so a dead bumper, a short trigger or a drifting stick is easy to spot.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome, Edge, Firefox or Safari on a computer, or a phone with the Xbox controller paired by Bluetooth.',
	'ads'            => 'standard',
	'styles'         => array( 'gamepad-tester' ),
	'scripts'        => array( 'gamepad-tester' ),
	'embed_height'   => 820,
	'tool'           => $diagram(
		'xbox',
		array( 'A', 'B', 'X', 'Y', 'LB', 'RB', 'LT', 'RT', 'View', 'Menu', 'LS', 'RS', 'Up', 'Down', 'Left', 'Right', 'Xbox', 'Share' )
	),
	'howto'          => array(
		'Connect the controller with a USB cable, the Xbox Wireless Adapter, or Bluetooth: press the Xbox button to turn it on, then hold the small <strong>pair</strong> button on top until the Xbox logo flashes fast and pick "Xbox Wireless Controller" on your device.',
		'Press any button so the browser can see the controller. Its name and the "Standard" mapping appear under the diagram.',
		'Press A, B, X and Y, the D-pad, LB, RB, View, Menu, the Xbox button and the Share button (Series X|S pads). Each one turns green once it registers.',
		'Pull LT and RT slowly. The bar should fill evenly to 100%. Move both sticks in full circles and click them in for LS and RS.',
		'Let go of the sticks and check the resting numbers, then press <strong>Test vibration</strong> to check the rumble motors.',
	),
	'howto_title'    => 'How to test an Xbox controller',
	'results'        => '<ul>
<li><strong>Every button turns green:</strong> the controller works. Xbox One pads have no Share button, so 17 of 18 is a full pass for them.</li>
<li><strong>A bumper only works when pressed at one end:</strong> LB and RB click on a hinge and the switch underneath wears out. It is a common Xbox One fault and usually needs a new tactile switch.</li>
<li><strong>LT or RT stops below 100%:</strong> 95% and up is normal. A trigger that stops at half or flickers has a worn trigger sensor or a loose spring.</li>
<li><strong>Stick reads more than 0.10 at rest:</strong> that is stick drift. The <a href="/stick-drift-test/">stick drift test</a> measures it and suggests a dead zone.</li>
<li><strong>The Xbox button does nothing:</strong> on Windows the Game Bar often captures it before the browser does. Turn off "Open Xbox Game Bar using this button" in the Game Bar settings to test it.</li>
</ul>',
	'extra'          => array(
		array(
			'Xbox One, Series X|S and Elite controllers',
			'<p>All current Xbox controllers use the same layout, so this test works the same for the Xbox One controller, the Series X|S controller with its Share button, and the Elite Series 2. The Elite\'s back paddles map to other buttons by default, so pressing a paddle lights up the button it copies; change the mapping in the Xbox Accessories app if you want to test the paddles on their own. Third-party pads that copy the Xbox layout (PowerA, 8BitDo, GameSir) work here too.</p>
<p>Chrome and Edge on Windows read Xbox controllers best, including rumble. Firefox and Safari show buttons and sticks but may not send vibration. For PlayStation pads, use the <a href="/ps5-controller-test/">PS5 controller test</a> or <a href="/ps4-controller-test/">PS4 controller test</a>; for anything else, the <a href="/gamepad-tester/">gamepad tester</a>.</p>',
			'models',
		),
		array(
			'Fixing Xbox controller drift and dead buttons',
			'<p>Drift on Xbox controllers comes from the potentiometers inside each stick wearing over time, the same as on PlayStation pads. Before replacing anything, update the controller firmware in the Xbox Accessories app (on Windows or the console), blow compressed air around the stick base while moving it in circles, and recalibrate by turning the controller off and on without touching the sticks. If drift stays above 0.10, the stick module needs replacing.</p>
<p>Bumpers and the D-pad are the parts that fail most on older Xbox One pads. A bumper that only clicks at one end, or a D-pad that registers diagonals when you press straight, is a worn switch or a stretched rubber membrane rather than a software problem.</p>',
			'repair',
		),
	),
	'fixes'          => array(
		array( 'Xbox controller not detected on PC', 'Press a button after connecting. Try a different USB cable or port, since some cables only charge. If Steam is open, its Xbox configuration support can hide the controller from other apps; close Steam and reload this page.' ),
		array( 'Bluetooth keeps disconnecting', 'Only Xbox One S and newer controllers have Bluetooth; the original Xbox One pad needs a cable or the Wireless Adapter. Update the controller firmware in the Xbox Accessories app, keep it within a few metres of the computer, and remove other Bluetooth devices that crowd the signal.' ),
		array( 'Vibration does not work', 'Rumble from web pages works in Chrome and Edge. Check the batteries: an Xbox controller turns rumble off when the batteries are low. In the Xbox Accessories app, make sure vibration is not set to zero.' ),
		array( 'Buttons are mixed up', 'The browser reports "Non-standard" mapping. This happens with some third-party pads in their "D-input" mode; switch them to "X-input" (often a switch on the back) and reload the page.' ),
	),
	'faq'            => array(
		array( 'How do I test my Xbox controller on PC?', 'Connect it by USB, Bluetooth or the Wireless Adapter, open this page and press any button. Then press every button and move both sticks; each input lights up when it works.' ),
		array( 'How can I tell if my Xbox controller has stick drift?', 'Let go of both sticks and read the numbers under them. Above 0.10 at rest means drift. The stick drift test gives an exact percentage.' ),
		array( 'Does this work with the Xbox Elite Series 2?', 'Yes. All standard buttons, triggers and sticks show up. The back paddles copy other buttons by default, so they light up those buttons.' ),
		array( 'Can I test an Xbox controller on my phone?', 'Yes. Pair it with your phone by Bluetooth, then open this page in Chrome on Android or Safari on iPhone and press a button.' ),
		array( 'Why does the Xbox button open the Game Bar?', 'Windows uses the Xbox button for the Game Bar. Turn that option off in the Game Bar settings to test the button here.' ),
		array( 'Can I test the trigger rumble motors?', 'Browsers can only drive the two main rumble motors. The small impulse trigger motors in LT and RT are not reachable from a web page.' ),
	),
	'related'        => array( 'stick-drift-test', 'ps5-controller-test', 'ps4-controller-test', 'gamepad-tester', 'reaction-time-test', 'keyboard-tester' ),
	'updated'        => '2026-10-28',
);
