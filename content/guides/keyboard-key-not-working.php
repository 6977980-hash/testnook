<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Keyboard Key Not Working? How to Find and Fix It',
	'seo_title'   => 'Keyboard Key Not Working: Causes and Fixes That Work',
	'description' => 'One key or a group of keys not working? Test which keys register, then fix software locks, dirt under the keycap, a worn switch, drivers and laptop keyboards.',
	'blurb'       => 'Test which keys register, then fix locks, dirt, a dead switch or a driver problem.',
	'hub'         => 'keyboard',
	'tool'        => 'keyboard-tester',
	'tools'       => array( 'keyboard-ghosting-test', 'spacebar-clicker', 'typing-test-english' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A key that does nothing, types twice, or only works when you press hard has one of a handful of causes. Work through them in order: most are fixed in five minutes without tools.',
	'summary'     => array(
		'<strong>Test first.</strong> Press the key in our keyboard tester: if the browser sees it, the keyboard is fine and the problem is software (a lock, a layout, an app).',
		'A <strong>group of keys</strong> dead at once usually means a software lock (Fn lock, Num Lock, filter keys), a wrong layout, or a damaged trace on a laptop keyboard.',
		'<strong>One dead or double-typing key</strong> is almost always dirt or a worn switch. Pop the keycap, clean it, and on a mechanical board swap the switch.',
		'If keys work in the BIOS but not in the OS, reinstall the keyboard driver. If they fail everywhere, it is hardware.',
	),
	'sections'    => array(
		array(
			'Step 1: find out which keys the computer actually sees',
			'<p>Open the <a href="/keyboard-tester/">keyboard tester</a> and press the problem key a few times. The page lights up every key the browser receives, and shows the key code.</p>
<ul>
<li><strong>The key lights up</strong> but does nothing in your app: the hardware is fine. Skip to the software causes below.</li>
<li><strong>Nothing lights up</strong> for that key, but others work: the key or its switch is faulty, or a lock is blocking a group of keys.</li>
<li><strong>It lights up twice per press</strong> (or types double letters): switch bounce or dirt. See the chatter section.</li>
<li><strong>It lights only when pressed hard</strong> or from one side: dirt under the keycap or a worn dome or switch.</li>
</ul>
<p>Also press several keys together on the <a href="/keyboard-ghosting-test/">ghosting test</a>. If a key only fails while other keys are held, that is ghosting (a limit of cheap keyboard matrices), not a fault.</p>',
			'test-first',
		),
		array(
			'Step 2: rule out the software locks',
			'<p>When a whole group of keys stops at once, suspect a toggle before you suspect the hardware:</p>
<ul>
<li><strong>Fn lock:</strong> on laptops and compact keyboards, F1 to F12 and sometimes the arrow or number keys change meaning when Fn lock is on. Press Fn + Esc, Fn + Caps Lock or Fn + the key with a padlock icon.</li>
<li><strong>Num Lock:</strong> on a compact laptop, Num Lock turns the U-I-O / J-K-L / M block into a number pad. Keys typing numbers instead of letters is this.</li>
<li><strong>Filter Keys and Sticky Keys (Windows):</strong> Filter Keys ignores short or repeated presses, so fast typing drops letters. Settings &gt; Accessibility &gt; Keyboard, turn both off. Holding Shift for 8 seconds can turn Filter Keys on by accident.</li>
<li><strong>Slow Keys (Mac):</strong> System Settings &gt; Accessibility &gt; Keyboard &gt; Slow Keys.</li>
<li><strong>Wrong layout:</strong> if @ and " are swapped or Y and Z are swapped, the input language changed (Windows: Win + Space cycles layouts). Remove layouts you do not use.</li>
<li><strong>Gaming mode:</strong> many gaming keyboards have a mode that disables the Windows key and sometimes Alt+Tab. It is usually Fn + Win or Fn + F10/F12.</li>
<li><strong>App shortcuts:</strong> if a key fails in one program only, that program (or a background tool such as AutoHotkey, a macro app or a screen recorder) has captured it.</li>
</ul>',
			'software-locks',
		),
		array(
			'Step 3: clean under the key',
			'<p>Crumbs, hair and dried spills are the number one cause of a single dead or stiff key.</p>
<ol>
<li>Unplug the keyboard (or shut the laptop down).</li>
<li><strong>Mechanical and most desktop keyboards:</strong> pull the keycap straight up with a keycap puller or two fingernails. Wide keys (space, Shift, Enter) have a wire stabilizer; lift one side gently first.</li>
<li><strong>Laptop and low-profile scissor keys:</strong> slide a thin plastic card under one edge and lift carefully until the scissor clips release. These break easily; if the key is stiff rather than dead, try compressed air first and skip removal.</li>
<li>Blow out debris with compressed air, then wipe the switch top and the keycap stem with a cotton swab and a little isopropyl alcohol. For a sticky key after a sugary spill, the switch itself may need alcohol worked into it and a minute of pressing.</li>
<li>Press the cap back on straight until it clicks, and test again.</li>
</ol>
<p>A keyboard that had a full spill (coffee, juice) often fails days later as the residue corrodes contacts. Unplug it immediately, turn it upside down, leave it to dry for 48 hours and clean every affected switch; even then it may not come back fully.</p>',
			'clean-key',
		),
		array(
			'Step 4: double typing (chatter) and stiff keys',
			'<p>A key that types two letters for one press is "chattering": the switch contacts bounce and the controller reads two presses. On a mechanical keyboard this is a worn or dirty switch. Fixes in order:</p>
<ol>
<li>Clean the switch with contact cleaner or isopropyl alcohol and press it 50 times.</li>
<li>Update the keyboard firmware; some manufacturers (Razer, Corsair, Keychron and others) ship debounce fixes.</li>
<li>Raise the debounce time in the keyboard software, or in VIA/QMK for custom boards.</li>
<li>Swap the switch. On hot-swap boards it pulls out with the included tool; on soldered boards it needs desoldering, or a shop.</li>
</ol>
<p>A stiff or mushy key on a membrane keyboard is usually a tired rubber dome. Domes are not sold individually, so if cleaning does not help, the keyboard is at the end of its life (they are cheap to replace).</p>',
			'chatter',
		),
		array(
			'Step 5: drivers, USB and Bluetooth',
			'<ul>
<li><strong>Try another port and skip the hub.</strong> Some hubs and front-panel ports underpower keyboards, which shows up as dropped keys or the whole keyboard pausing.</li>
<li><strong>Restart the computer</strong> before anything else; a hung input driver is common after sleep.</li>
<li><strong>Reinstall the driver (Windows):</strong> Device Manager &gt; Keyboards &gt; right-click &gt; Uninstall device, then restart. Windows reinstalls the standard driver. Also remove the manufacturer\'s software (Synapse, iCUE, G Hub) temporarily to see if it is remapping keys.</li>
<li><strong>Check in the BIOS or at the login screen.</strong> If the key works there but not after login, the problem is software in your user session.</li>
<li><strong>Wireless:</strong> replace or charge the batteries, move the receiver to a front USB port or an extension cable away from USB 3 devices and Wi-Fi routers (2.4 GHz interference), and re-pair Bluetooth keyboards by removing and adding them.</li>
</ul>',
			'drivers-usb',
		),
		array(
			'Laptop keyboards: when a row or column dies',
			'<p>A laptop keyboard is a thin membrane with printed traces. When a whole row, column or a scattered pattern of keys stops at once and no lock is on, a trace is damaged or the ribbon cable has loosened. Options:</p>
<ul>
<li><strong>Reseat the ribbon cable.</strong> On many laptops the keyboard connector is reachable after removing the bottom cover; lift the small latch, push the ribbon in, close the latch. Look up a teardown for your model first.</li>
<li><strong>Replace the keyboard.</strong> Replacement keyboards for most laptops cost 15 to 50 dollars. On some models it is a ten-minute job; on others (especially thin Dell, HP and Apple designs) the keyboard is riveted to the top case and the whole palm rest is replaced.</li>
<li><strong>Work around it.</strong> An external USB keyboard works immediately, and the on-screen keyboard or a remap tool (PowerToys Keyboard Manager on Windows, Karabiner-Elements on a Mac) can move a dead key\'s function to a key you rarely use.</li>
</ul>',
			'laptop-keyboards',
		),
	),
	'faq'         => array(
		array( 'Why does one key on my keyboard not work?', 'Most often dirt under the keycap or a worn switch. Test it in the keyboard tester first; if the browser sees the key, the problem is software (a shortcut, a lock or an app capturing it), not the key.' ),
		array( 'Why are some keys typing the wrong characters?', 'The input language or layout has changed. On Windows press Win + Space to cycle layouts, and remove extra layouts in Settings > Time & language > Language & region. Num Lock on a laptop can also turn letters into numbers.' ),
		array( 'Why does my keyboard type letters twice?', 'The switch is chattering: its contacts bounce and register two presses. Clean the switch, update the firmware, raise the debounce time if the software allows it, or replace the switch.' ),
		array( 'How do I fix a laptop key that fell off?', 'Check whether the scissor mechanism (two thin plastic frames) is still attached to the keyboard. If it is, line the keycap up and press down until it clicks. If the mechanism came off too, clip it to the base first, then the cap. Replacement caps and clips for most models are sold cheaply online.' ),
		array( 'Can a spilled drink be fixed?', 'Sometimes. Unplug or power off at once, turn the keyboard upside down, let it dry for at least 48 hours, then clean the affected switches with isopropyl alcohol. Sugary drinks leave a sticky film and often cause failures weeks later; water usually dries without harm.' ),
		array( 'Is it ghosting or a broken key?', 'If the key works alone but not while other keys are held, it is ghosting: cheap keyboards cannot read some combinations. The ghosting test shows how many keys yours can read at once. A broken key fails on its own too.' ),
	),
);
