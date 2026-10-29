<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Fix Stick Drift on PS5, Xbox, Switch and PC Controllers',
	'seo_title'   => 'How to Fix Stick Drift: PS5, Xbox, Joy-Con and PC Fixes',
	'description' => 'Fix controller stick drift step by step: confirm it with a test, recalibrate, raise the dead zone, clean the stick, and know when to replace the module.',
	'blurb'       => 'Confirm it with a test, then fix it: dead zones, cleaning, resets and when to replace the stick.',
	'hub'         => 'controller',
	'tool'        => 'stick-drift-test',
	'tools'       => array( 'joy-con-drift-test', 'ps5-controller-test', 'xbox-controller-test', 'gamepad-tester' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Stick drift is when a thumbstick reports movement you are not making: the camera creeps, a character walks on its own. It is the most common controller fault and, caught early, often fixable at home.',
	'summary'     => array(
		'First <strong>measure it</strong>: a resting stick that reads more than about 5% of full travel is drifting. Our test shows the number so you are not guessing.',
		'Software fixes work for mild drift: <strong>a bigger dead zone</strong> in the game or Steam, and the console\'s <strong>recalibration</strong> (Switch and PS5 have one; Xbox does not).',
		'Physical fixes: <strong>compressed air or isopropyl alcohol</strong> around the stick base, and on older designs a few seconds of <strong>contact cleaner</strong> in the potentiometer.',
		'Drift that comes back within weeks means the sensor is worn. <strong>Replace the stick module</strong> (about 10 to 25 dollars in parts) or the controller, or use a warranty or free repair program.',
	),
	'sections'    => array(
		array(
			'Confirm it is drift, and how bad',
			'<p>Before changing anything, measure. Plug the controller in, open the <a href="/stick-drift-test/">stick drift test</a> (or the <a href="/joy-con-drift-test/">Joy-Con version</a>) and let go of both sticks. A healthy stick rests inside 1 to 3% of center. Most games ignore anything under 5 to 10%, which is why mild drift is invisible until a game with a small dead zone exposes it.</p>
<p>Three patterns tell you what you are dealing with:</p>
<ul>
<li><strong>Steady offset in one direction</strong> (say, always 8% left): the sensor is worn or dirty on one side. The classic case.</li>
<li><strong>Jittery, jumping readings</strong> while the stick is still: dirt or a damaged track inside the potentiometer, or a loose ribbon cable.</li>
<li><strong>Stick does not return to center</strong> after you move it: the spring or the plastic cap is sticking, often from grime under the rubber dust cover.</li>
</ul>
<p>Also check that the stick reaches the edge of the circle in every direction. A stick that cannot reach full travel after you have raised the dead zone will feel sluggish.</p>',
			'confirm-drift',
		),
		array(
			'Fix 1: recalibrate and raise the dead zone',
			'<p>These cost nothing and fix a surprising share of cases.</p>
<h3>Recalibrate</h3>
<ul>
<li><strong>Nintendo Switch:</strong> System Settings &gt; Controllers and Sensors &gt; Calibrate Control Sticks. Follow the prompts; it re-learns the center and edges.</li>
<li><strong>PS5 (DualSense Edge):</strong> Settings &gt; Accessories &gt; DualSense Edge &gt; Stick Calibration. A standard DualSense has no calibration menu; use the dead zone options below.</li>
<li><strong>Xbox:</strong> no built-in calibration. The Xbox Accessories app lets Elite controllers adjust stick settings; for others, use the game or Steam.</li>
<li><strong>Windows:</strong> Settings &gt; Bluetooth &amp; devices &gt; Devices &gt; More devices and printer settings, right-click the controller &gt; Game controller settings &gt; Properties &gt; Settings &gt; Calibrate. This affects older DirectInput games mostly.</li>
</ul>
<h3>Raise the dead zone</h3>
<p>Most modern games have a stick dead zone slider in the controls menu; set it just above your measured drift (drift of 8% means a dead zone of about 10%). On PC, Steam &gt; Settings &gt; Controller &gt; Calibration &amp; Advanced Settings sets a per-controller dead zone that applies to any game launched through Steam. This is a workaround, not a repair, but for a few percent of drift it is all most people need.</p>',
			'software-fixes',
		),
		array(
			'Fix 2: clean the stick',
			'<p>Dust, skin oil and drink residue work their way under the rubber boot and into the sensor. Cleaning helps most when the drift appeared suddenly or the readings jitter.</p>
<ol>
<li>Turn the controller off. Pull the stick to one side to lift the edge of the rubber dust cover.</li>
<li>Blow <strong>compressed air</strong> in short bursts around the base while rotating the stick. Keep the can upright.</li>
<li>Still drifting? Put a few drops of <strong>isopropyl alcohol</strong> (90% or higher) on a cotton swab, lift the boot and wipe around the stick base, then rotate the stick for 30 seconds and let it dry for a few minutes.</li>
<li>For older potentiometer sticks (Xbox One, PS4, standard DualSense, Switch Pro, Joy-Con), a short spray of <strong>electrical contact cleaner</strong> into the gap at the stick base, followed by a minute of rotating the stick, cleans the resistive track itself. Do not use WD-40 or anything oily, and do not do this on Hall effect sticks, which have nothing to clean.</li>
</ol>
<p>Re-run the test afterwards. If the resting value dropped into the 1 to 3% range, you are done; note the number so you can tell if it creeps back.</p>',
			'clean-stick',
		),
		array(
			'Fix 3: reset, update, and rule out the software',
			'<ul>
<li><strong>Reset the controller.</strong> DualSense and DualShock 4 have a pinhole reset button on the back (hold 5 seconds with a paper clip). On Xbox, hold the Xbox button for 10 seconds to power-cycle, or remove the batteries for a minute. Joy-Cons: hold the small sync button for a few seconds.</li>
<li><strong>Update the firmware.</strong> PS5: Settings &gt; Accessories &gt; Controllers &gt; Wireless Controller Device Software. Xbox: the Xbox Accessories app. Switch: System Settings &gt; Controllers and Sensors &gt; Update Controllers.</li>
<li><strong>Test on another device.</strong> If the controller drifts in our browser test but not in a particular game, the game\'s dead zone is just smaller than usual. If it only drifts in one game, the game\'s settings are the cause.</li>
<li><strong>Check the other stick and the triggers.</strong> On the <a href="/gamepad-tester/">gamepad tester</a>, a trigger resting above zero is the same wear problem in a different place.</li>
</ul>',
			'reset-update',
		),
		array(
			'Fix 4: replace the stick module',
			'<p>When drift returns within a few weeks of cleaning, the resistive track inside the potentiometer is worn and no amount of cleaning will last. Options, cheapest first:</p>
<ol>
<li><strong>Warranty or repair program.</strong> Nintendo repairs Joy-Con drift free in many regions, including out of warranty, after settlements and regulator pressure. Sony and Microsoft repair or replace under the standard one-year warranty.</li>
<li><strong>Replace the module yourself.</strong> Joy-Con sticks are the easiest: one ribbon cable, a tri-wing screwdriver, about 20 minutes, and the part costs a few dollars. Xbox and PlayStation sticks are soldered to the board and need a soldering iron and desoldering braid or a pump; a repair shop will do it for 20 to 40 dollars. iFixit publishes step-by-step guides for every major controller.</li>
<li><strong>Upgrade to Hall effect sticks.</strong> Hall effect modules use magnets instead of a wiping contact, so they do not wear out. Drop-in replacements exist for Joy-Cons, DualShock 4, DualSense and Xbox controllers, and many third-party controllers ship with them.</li>
<li><strong>Replacement modules on newer controllers.</strong> The DualSense Edge and some Xbox Elite revisions have swappable stick modules that click out without tools; a replacement module costs about 20 dollars.</li>
</ol>',
			'replace-module',
		),
		array(
			'Why drift happens, and how to slow it down',
			'<p>Almost every mainstream controller stick is a pair of potentiometers: a small metal wiper slides over a carbon track and the resistance tells the console where the stick is. Each movement wears a little carbon off the track. Where the wiper rests most, at center, the track thins first, and the reading starts to lie. Dust and a weakening centering spring add to it. Drift usually arrives after 300 to 500 hours of play.</p>
<p>You cannot stop wear, but you can slow it: keep food and drinks away from the controller, store it in a drawer rather than face down on a dusty desk, do not press or wiggle sticks when they are not needed, and avoid games that need constant full-throw circling for hours. Hall effect sticks sidestep the problem entirely, which is why they are becoming standard on new third-party controllers.</p>',
			'why-drift',
		),
	),
	'faq'         => array(
		array( 'Can stick drift fix itself?', 'Occasionally, if the cause was a bit of dust that moved. Drift from a worn track only gets worse. If a quick clean and recalibration do not hold for a month, the module needs replacing.' ),
		array( 'Does Nintendo fix Joy-Con drift for free?', 'In the United States, the European Union, the United Kingdom and several other regions Nintendo repairs Joy-Con drift at no charge, in or out of warranty. Start a repair request on your regional Nintendo support site.' ),
		array( 'How do I fix drift on a PS5 DualSense?', 'Reset with the pinhole button, update the firmware, clean around the stick with isopropyl alcohol, and raise the dead zone in your games. A standard DualSense cannot be recalibrated in software; persistent drift needs a module replacement or a warranty claim.' ),
		array( 'What dead zone should I set?', 'Just above your measured drift. If the stick rests at 6%, set 8 to 10%. Larger dead zones make small movements impossible, so do not go higher than you need.' ),
		array( 'Is it safe to use contact cleaner on a controller?', 'On potentiometer sticks, yes, in small amounts with the controller off and the battery disconnected where possible, letting it dry fully. Do not use it on Hall effect sticks, on triggers with rubber parts, or anywhere near the touchpad or speaker.' ),
		array( 'Do Hall effect sticks drift?', 'They can show a small constant offset if the magnet shifts, which calibration fixes, but they do not wear the way potentiometer sticks do. For heavy use they are the long-term answer.' ),
	),
	'sources'     => array(
		array( 'iFixit: Nintendo Switch Joy-Con repair guides', 'https://www.ifixit.com/Device/Nintendo_Switch_Joy-Con' ),
	),
);
