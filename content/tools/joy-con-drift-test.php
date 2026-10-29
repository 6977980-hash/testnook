<?php
defined( 'ABSPATH' ) || exit;

$stick = function ( $i, $label ) {
	return '<div class="sd-stick">
		<h3 id="sd-h' . $i . '">' . $label . '</h3>
		<canvas id="sd-c' . $i . '" aria-label="' . $label . ' position"></canvas>
		<div class="stats">
			<div class="stat"><span class="stat-label">X</span><span class="stat-value" id="sd-x' . $i . '">0.000</span></div>
			<div class="stat"><span class="stat-label">Y</span><span class="stat-value" id="sd-y' . $i . '">0.000</span></div>
			<div class="stat"><span class="stat-label">Distance</span><span class="stat-value" id="sd-d' . $i . '">0%</span></div>
			<div class="stat"><span class="stat-label">At rest</span><span class="stat-value" id="sd-rest' . $i . '">-</span></div>
			<div class="stat"><span class="stat-label">Outer range</span><span class="stat-value" id="sd-range' . $i . '">-</span></div>
		</div>
	</div>';
};

return array(
	'title'          => 'Joy-Con Drift Test',
	'seo_title'      => 'Joy-Con Drift Test: Check Switch Joy-Con Stick Drift Online',
	'description'    => 'Free Joy-Con drift test. Connect a Nintendo Switch Joy-Con to your PC or phone by Bluetooth, see the stick live and measure drift at rest with a suggested dead zone.',
	'intro'          => 'Find out if your Nintendo Switch Joy-Con has stick drift. Pair the Joy-Con with your computer or phone by Bluetooth, open this page in Chrome or Edge and press a button: the stick appears live, and a 3-second check measures how far it sits off centre when nobody touches it.',
	'device'         => 'gamepad',
	'device_message' => 'This browser cannot read game controllers. Use an up-to-date Chrome or Edge on a computer or Android phone.',
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
<div class="tool-stage sd-stage" data-sd-joycon>
	' . $stick( 0, 'Left stick' ) . '
	' . $stick( 1, 'Right stick' ) . '
</div>
<p class="tool-status" id="sd-status" aria-live="polite">No Joy-Con found yet. Pair it by Bluetooth, then press any button on it.</p>',
	'howto'          => array(
		'Pair the Joy-Con with your computer or Android phone: hold the small round sync button on the rail of the Joy-Con until the lights run, then choose "Joy-Con (L)" or "Joy-Con (R)" in the Bluetooth settings.',
		'Open this page in Chrome or Edge and press any button on the Joy-Con. If both Joy-Cons are connected, pick one in the menu that appears.',
		'Move the stick around. A single Joy-Con shows in the first circle, turned sideways as if you held it horizontally. Let go and watch whether the dot returns to the centre.',
		'Put the Joy-Con down on a table and press <strong>Check drift</strong>. Do not touch it during the 3-second countdown and the 3-second measurement.',
		'Rotate the stick slowly around its edge a few times to draw the outer range, then repeat the test for the other Joy-Con.',
	),
	'howto_title'    => 'How to test a Joy-Con for drift',
	'results'        => '<p><strong>At rest</strong> is how far the stick reports itself from the centre when untouched, as a percentage of full tilt:</p>
<ul>
<li><strong>Under 5%:</strong> no drift. The Switch\'s own dead zone hides this.</li>
<li><strong>5-12%:</strong> early drift. You may see slow movement in menus or the camera creeping in some games.</li>
<li><strong>Over 12%:</strong> clear Joy-Con drift. Characters walk or menus scroll on their own.</li>
</ul>
<p><strong>Outer range</strong> shows whether the stick reaches full tilt all the way round. Around 100% is ideal; a lower value in one direction means worn or dirty contacts. Drift often comes and goes, so test again after a few minutes of play if the first result is clean but you still see problems in games.</p>',
	'extra'          => array(
		array(
			'Why Joy-Cons drift',
			'<p>The original Joy-Con sticks use a small potentiometer: a contact slides over a carbon track to read the stick position. Over time the track wears and dust gets in, so the reading at rest moves away from the centre. That is why drift appears after months of use and why cleaning sometimes helps for a while. Nintendo offers free Joy-Con drift repairs in many regions, including the US, the UK and the EU, regardless of warranty; check Nintendo Support for your country. The Switch 2 Joy-Con use new sticks, and many third-party replacement sticks now use Hall effect sensors, which do not wear in the same way.</p>',
			'why-drift',
		),
		array(
			'Testing on the Switch itself',
			'<p>On the console, open System Settings > Controllers and Sensors > Calibrate Control Sticks, press the stick you want to test and watch the cross: if it moves away from the centre without you touching it, the stick drifts, and you can recalibrate it there. This page gives you a number to compare and works when the Switch is not to hand. For Pro Controllers and other gamepads, use the <a href="/stick-drift-test/">stick drift test</a> and the <a href="/gamepad-tester/">gamepad tester</a>; to check rumble, try the <a href="/controller-vibration-test/">controller vibration test</a>.</p>',
			'on-switch',
		),
	),
	'fixes'          => array(
		array( 'Recalibrate the stick on the Switch', 'Go to System Settings > Controllers and Sensors > Calibrate Control Sticks, press the stick and follow the steps. Update the controller firmware under Controllers and Sensors > Update Controllers first.' ),
		array( 'Clean the stick', 'Turn the Switch off, lift the rubber skirt around the stick base slightly and blow compressed air underneath in short bursts while rotating the stick. Some people add a drop of isopropyl alcohol (90% or more) and rotate the stick, then let it dry fully. It often helps for a while but does not repair a worn track.' ),
		array( 'Get it repaired', 'Nintendo repairs drifting Joy-Con for free in many countries; request a repair on the Nintendo Support website. Out of warranty, a replacement stick module is cheap, but opening the Joy-Con needs a tri-wing screwdriver and care with the ribbon cables.' ),
		array( 'The Joy-Con does not show up', 'Make sure it is paired in the Bluetooth settings and not still connected to the Switch (turn the Switch off or put it in airplane mode). Press a button after the page loads, and use Chrome or Edge.' ),
	),
	'faq'            => array(
		array( 'How do I test my Joy-Con for drift online?', 'Pair the Joy-Con with your PC or Android phone by Bluetooth, open this page in Chrome or Edge, press a button, then press Check drift with the stick untouched. Over 12% at rest means clear drift.' ),
		array( 'Can I test Joy-Cons on a PC?', 'Yes. Windows, macOS and Linux can pair Joy-Cons by Bluetooth. Chrome and Edge read their sticks as analogue controllers, which this test needs.' ),
		array( 'Why does my Joy-Con show in the left circle?', 'A single Joy-Con counts as a small sideways controller, so its one stick is reported as the left stick. Both circles are used when the browser combines a pair into one controller.' ),
		array( 'Does Nintendo fix Joy-Con drift for free?', 'In many regions, yes, including the US, UK and EU, even out of warranty. Check the Nintendo Support site for your country.' ),
		array( 'Can Joy-Con drift fix itself?', 'Sometimes it fades for a while after cleaning or as dust moves, but worn sticks usually get worse. Recalibrating hides mild drift.' ),
		array( 'Does this work with the Switch Pro Controller?', 'Yes. Pair the Pro Controller the same way; both of its sticks appear. The <a href="/stick-drift-test/">stick drift test</a> works for it too.' ),
	),
	'related'        => array( 'stick-drift-test', 'gamepad-tester', 'controller-vibration-test', 'ps5-controller-test', 'xbox-controller-test', 'ps4-controller-test', 'keyboard-tester', 'touch-screen-test' ),
	'updated'        => '2026-10-29',
);
