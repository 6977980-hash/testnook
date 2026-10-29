<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Mouse Double Clicking on Its Own? Causes and Fixes',
	'seo_title'   => 'Mouse Double Clicking by Itself? How to Fix the Switch',
	'description' => 'A mouse that double clicks when you click once has a worn switch. Confirm it with a test, then fix it with the debounce setting, cleaning, or a new switch.',
	'blurb'       => 'Confirm the switch is bouncing, then fix it with settings, cleaning or a new switch.',
	'hub'         => 'mouse',
	'tool'        => 'double-click-test',
	'tools'       => array( 'mouse-tester', 'cps-test', 'scroll-test', 'mouse-polling-rate-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Files open when you only meant to select them, drags drop halfway, and in games one shot fires twice. That is a mouse switch registering two clicks for one press, and it is one of the most common hardware faults there is.',
	'summary'     => array(
		'<strong>Confirm it:</strong> the double click test counts two clicks within a few milliseconds as a double. A healthy switch never does it; a worn one does it every few clicks.',
		'Software can mask it: on Windows, set the <strong>double-click speed</strong> to fast, and if the mouse software has a <strong>debounce</strong> setting, raise it.',
		'The cause is a <strong>worn or dirty microswitch</strong>. Compressed air and a few drops of contact cleaner sometimes buy months.',
		'The lasting fix is a new switch (a 2 dollar part and some soldering), a warranty claim, or a mouse with optical switches, which cannot bounce.',
	),
	'sections'    => array(
		array(
			'Step 1: confirm the switch is bouncing',
			'<p>Open the <a href="/double-click-test/">double click test</a> and click the left button slowly, once per second, 30 times. The test times the gap between clicks: two clicks within about 80 ms cannot come from a finger, so it counts them as a false double. Then do the same with the right button and the wheel click.</p>
<ul>
<li><strong>Zero false doubles in 30 clicks:</strong> the switch is fine. If files still open on one click, it is a setting (see the next section) or a software issue.</li>
<li><strong>One or more:</strong> the switch is bouncing. A switch that does it once in 30 clicks is early; one that does it every few clicks is well worn.</li>
<li><strong>Clicks go missing</strong> (you click, the counter does not move): the same wear in a different stage, where the contacts no longer close reliably.</li>
</ul>
<p>Also try the <a href="/mouse-tester/">mouse tester</a>, which shows whether a button sticks (stays pressed) after release, a sign of a worn plunger rather than the contacts.</p>',
			'confirm',
		),
		array(
			'Why a mouse starts double clicking',
			'<p>Under each mouse button is a microswitch: a small plastic box with a metal leaf spring that snaps between two contacts. Over millions of clicks the spring loses tension and the contact surfaces oxidise and pit. Instead of a clean snap, the contact chatters for a moment on landing. The mouse controller is supposed to ignore this (debouncing), but it only waits a few milliseconds, so a worn switch that chatters longer gets read as two clicks.</p>
<p>Switches are rated for 10 to 80 million clicks, but the rating assumes a clean environment and a certain contact current. Many gaming mice run their switches at a lower voltage than the rating, which speeds oxidation; it is why some well-known mice develop the fault within a year. Humidity and dust make it worse.</p>',
			'why',
		),
		array(
			'Step 2: settings that hide the problem',
			'<ul>
<li><strong>Windows double-click speed.</strong> Settings &gt; Bluetooth &amp; devices &gt; Mouse &gt; Additional mouse settings &gt; Buttons, move the double-click speed slider toward Fast. Windows then needs the two clicks closer together to count a double, but a bouncing switch\'s clicks arrive within a few milliseconds, so this helps only a little. It does fix the opposite problem, where you are accidentally double clicking yourself.</li>
<li><strong>Mouse software debounce.</strong> Razer Synapse, Logitech G Hub (on some mice), Glorious Core, Zowie and most mice with configurable firmware let you raise the debounce time from the default (often 2 to 4 ms) to 8 to 16 ms. This is the most effective software fix and costs a few milliseconds of click latency.</li>
<li><strong>Firmware update.</strong> Several makers have shipped updates that lengthen the debounce window after complaints; check the support page for your model.</li>
<li><strong>Third-party fixes.</strong> On Windows, small utilities (such as the free "MouseFix" style tools) filter out clicks that arrive within a set window. They work for any mouse and are a reasonable bridge until a repair.</li>
<li><strong>Single-click to open.</strong> If Explorer opens items on one click, it is a setting: File Explorer &gt; Options &gt; General &gt; Click items as follows &gt; Double-click to open.</li>
</ul>',
			'settings',
		),
		array(
			'Step 3: clean the switch',
			'<p>Oxidation and dust can be disturbed enough to buy weeks or months. With the mouse unplugged (or off, battery removed if possible):</p>
<ol>
<li>Blow compressed air into the gap around the button, pressing the button repeatedly while you do.</li>
<li>Open the mouse if you are comfortable: screws are usually under the glide pads or a label. Locate the switch under the faulty button, a small rectangular box with a button on top.</li>
<li>Put a tiny amount of <strong>electrical contact cleaner</strong> (not WD-40, not alcohol alone) into the switch through the gap around its plunger, and click it 50 to 100 times. Let it dry for ten minutes.</li>
<li>Advanced: pry the switch\'s top cover off with a fingernail, lift out the copper leaf spring, gently bend the curved part to restore tension, clean the contact points with a strip of paper dipped in alcohol, and reassemble. This is fiddly and the spring is easy to lose, but it often restores the switch fully.</li>
</ol>
<p>Rerun the double click test. If the false doubles are gone, note the date; when they return, it is time for a new switch.</p>',
			'clean',
		),
		array(
			'Step 4: replace the switch or the mouse',
			'<ul>
<li><strong>Warranty.</strong> Double clicking is a known fault and makers replace mice for it within the warranty period (usually two years in the EU and UK, one to two years elsewhere). Logitech and Razer have replaced out-of-warranty mice in some cases when asked.</li>
<li><strong>Replace the switch.</strong> Omron D2FC and D2F series switches and their equivalents cost 1 to 3 dollars each. Replacement means desoldering three pins and soldering in the new switch; a repair shop charges 15 to 30 dollars. A few mice (some from Glorious, Lamzu, Endgame Gear and others) have hot-swap switch sockets, where it takes a minute and no tools beyond a puller.</li>
<li><strong>Choose a mouse that cannot bounce.</strong> Optical switches (Razer\'s optical switches, Logitech Lightforce, Corsair Quickstrike, Roccat Titan Optical) use a light beam instead of metal contacts, so there is nothing to oxidise or chatter. If you have had two mice fail the same way, this is the long-term answer.</li>
</ul>
<p>For a cheap office mouse, replacement is the practical choice. For a 100 dollar gaming mouse, a switch swap is well worth it.</p>',
			'replace',
		),
	),
	'faq'         => array(
		array( 'Why does my mouse double click when I click once?', 'The microswitch under the button has worn: its metal spring contact bounces on landing and the mouse reads two clicks. Dirt and oxidation on the contacts cause the same thing. It is a hardware fault, and a double click test will show it.' ),
		array( 'Can a double clicking mouse be fixed?', 'Yes. Short term: raise the debounce time in the mouse software or clean the switch with contact cleaner. Long term: replace the switch (a cheap part, needs soldering) or the mouse. Mice with optical switches cannot develop the fault.' ),
		array( 'Does changing the Windows double-click speed fix it?', 'Rarely. A bouncing switch produces two clicks a few milliseconds apart, faster than any setting on the slider. The setting does help if the problem is that you are double clicking yourself by accident.' ),
		array( 'How long should mouse switches last?', 'Rated life is 10 to 80 million clicks, which is many years of office use. Heavy gaming and a mouse that under-powers its switches can wear them out in one to two years.' ),
		array( 'Is it the mouse or the computer?', 'Try the mouse on another computer, or another mouse on yours. A mouse that fails the double click test on two computers is faulty; if two mice both misbehave on one computer, look at the mouse driver, the USB port and the Explorer single-click setting.' ),
		array( 'Why do my drags drop halfway?', 'The same bounce: during a drag the worn switch briefly opens, which the computer reads as releasing the button. It is a stronger sign of wear than an occasional false double, and usually means the switch needs replacing soon.' ),
	),
);
