<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Controller & Gamepad Tests',
	'seo_title'   => 'Controller Tests: Gamepad Tester, Stick Drift, PS5 & Xbox',
	'description' => 'Free online controller tests. Check every button, trigger and stick on PS5, PS4, Xbox and PC gamepads, measure stick drift and find the right dead zone.',
	'intro'       => 'Plug in or pair your controller and test it in the browser: a gamepad tester that lights up every button and trigger, a stick drift test that measures how far a resting stick wanders, a rumble motor test, a Joy-Con drift test, and dedicated pages for DualSense, DualShock 4 and Xbox pads.',
	'body'        => '<h2>Which controller test do you need?</h2>
<p>The <a href="/gamepad-tester/">gamepad tester</a> works with almost any controller your computer recognizes: it draws the pad, lights up buttons as you press them, shows trigger pressure and stick position, and lists the raw button and axis values for anything not on the diagram. It also runs a rumble test on controllers that support it.</p>
<p>If a character creeps or the camera spins on its own, the <a href="/stick-drift-test/">stick drift test</a> is the page you want. It measures how far each stick sits from center while you are not touching it, grades the result and suggests a dead zone you can set in games or controller software.</p>
<p>The <a href="/ps5-controller-test/">PS5 controller test</a>, <a href="/xbox-controller-test/">Xbox controller test</a> and <a href="/ps4-controller-test/">PS4 controller test</a> use the same tester with the right button names for each pad, plus pairing steps and the faults common to that model, such as DualSense drift, Xbox bumper wear or the DualShock 4 micro-USB port.</p>
<p>The <a href="/controller-vibration-test/">controller vibration test</a> checks the rumble motors one at a time at any strength, with patterns and Xbox trigger rumble, and the <a href="/joy-con-drift-test/">Joy-Con drift test</a> measures Nintendo Switch Joy-Con drift on a PC or phone, with the fixes and Nintendo\'s repair options.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>Dead or late buttons:</strong> a button that never lights or needs a hard press. Worn membranes under the face buttons and bumpers are the usual cause.</li>
<li><strong>Stick drift:</strong> a stick that reports movement at rest. Starts as a small wobble and grows over time.</li>
<li><strong>Trigger faults:</strong> a trigger that reads partly pressed when released, or never reaches 100%.</li>
<li><strong>Stick range problems:</strong> a stick that cannot reach the edge of its circle in one direction.</li>
<li><strong>Connection drops:</strong> the controller disconnecting and reconnecting, often a cable or a low battery.</li>
</ul>

<h2>Before you blame the controller</h2>
<p>Use a USB cable the first time so pairing is not the problem. Close games, Steam Big Picture and any remapping software, because they can take over the controller and hide it from the browser. On Windows, the Xbox button may open Game Bar; turn that shortcut off. Chrome and Edge give the most complete results; Safari and Firefox support fewer controllers and features.</p>

<h2>What a browser cannot test</h2>
<p>Adaptive triggers, haptic feedback detail, the built-in speaker and microphone, the headphone jack and the light bar are controlled by the console and are not exposed to web pages. For those, test on the console itself.</p>',
	'faq'         => array(
		array( 'My controller is connected but nothing happens on the page. Why?', 'Browsers only start reading a controller after you press a button on it. Press any button, and if it still does not appear, check that no game or launcher is holding it, try a cable instead of Bluetooth, or use Chrome or Edge.' ),
		array( 'How much stick drift is normal?', 'A brand-new stick should sit within 1 to 3% of center. Up to about 5% is usually hidden by game dead zones. Above 10% you will see it in games. The stick drift test grades the number and suggests a dead zone.' ),
		array( 'Can I test a Nintendo Switch Pro Controller or Joy-Con?', 'Often, yes. The Pro Controller pairs over Bluetooth with most computers and works in Chrome. Joy-Cons appear as two separate pads. Button names may differ from the diagram, but the raw list always shows what is pressed.' ),
		array( 'Does the test work on a phone?', 'Yes, if the phone supports the controller. Android phones pair with Xbox, PS4 and PS5 controllers over Bluetooth and Chrome reads them. On iPhone and iPad, Safari supports many controllers from iOS 14 onward.' ),
		array( 'Can the test fix stick drift?', 'No test can fix the hardware. For mild drift, set a larger dead zone in the game or controller app and clean around the stick base with compressed air. Severe drift needs a stick module or a repair under warranty.' ),
		array( 'Does the rumble test work on every controller?', 'Chrome and Edge support rumble on Xbox, PS4, PS5 and many third-party pads. Firefox and Safari do not expose it yet, so the button does nothing there even if the motors work.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
