<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Proximity Sensor Not Working? Fixes for Calls and Black Screens',
	'seo_title'   => 'Proximity Sensor Not Working? Fixes for Android and iPhone',
	'description' => 'Screen stays on during calls, or goes black and will not wake? Find and fix a proximity sensor problem: protectors, dirt, settings, calibration, repairs.',
	'blurb'       => 'Why the screen stays on at your ear or stays black, and the fixes to try before a repair.',
	'hub'         => 'phone',
	'tool'        => 'proximity-sensor-test',
	'tools'       => array( 'light-sensor-test', 'phone-sensor-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'The proximity sensor has one job: turn the screen off when the phone is against your ear, so your cheek does not mute or hang up the call. When it fails you either press buttons with your face, or the screen goes black during a call and will not come back. Both are usually fixable at home. Start with the two minute <a href="/proximity-sensor-test/">proximity sensor test</a>, then work through the fixes below.',
	'summary'     => array(
		'The most common cause is a <strong>screen protector or case</strong> covering the sensor near the earpiece. Peel the top back and test again.',
		'<strong>Dirt, make-up and cracks</strong> over the sensor window come next. Clean the top of the screen with a dry microfibre cloth.',
		'A <strong>restart</strong>, a check of call settings (pocket mode, accidental touch protection) and a system update fix most software causes.',
		'If the call test fails with a clean, bare screen, the sensor needs <strong>recalibration or repair</strong>, which is common after a screen replacement.',
	),
	'sections'    => array(
		array(
			'How to tell it is the proximity sensor',
			'<p>Two symptoms point to it. In the first, the screen stays lit at your ear and your cheek taps the keypad, mutes the call or ends it. In the second, the screen turns black as soon as a call starts and stays black even when you take the phone away, so you cannot hang up or use the keypad. Both happen only during calls (and in pocket mode on some Android phones), because that is when the phone uses the sensor.</p>
<p>The <a href="/proximity-sensor-test/">proximity sensor test</a> walks you through a call test and gives a verdict. Browsers do not let websites read the sensor directly, so the call is the reliable check on any phone.</p>',
			'symptoms',
		),
		array(
			'1. Remove the screen protector or case',
			'<p>Most proximity sensors are an infrared LED and detector behind the glass near the earpiece. Tempered glass protectors, especially thick, dark, privacy or poorly cut ones, scatter or absorb that light. Some reflect it straight back, so the sensor always thinks something is close and the screen stays black. Peel the protector back from the top edge (or take it off) and repeat the call test. If the problem disappears, buy a protector with a cut-out or one made for your exact model.</p>
<p>A case with a raised lip at the top can also sit in the sensor\'s view. Take the case off for one test call.</p>',
			'protector',
		),
		array(
			'2. Clean the sensor area',
			'<p>Skin oil, make-up, sweat and dust build up in exactly the spot that touches your ear. Wipe the top of the screen with a dry microfibre cloth, or one very lightly dampened with water. Do not spray liquid at the phone or push anything into the earpiece grille. A crack across the top of the screen also scatters the infrared light; if the glass is cracked there, a new screen (or at least a new top protector) is the fix.</p>',
			'clean',
		),
		array(
			'3. Restart and check the settings',
			'<p>Restart the phone; the sensor service starts fresh. Then look at the settings that change how the sensor is used:</p>
<ul>
<li><strong>Samsung:</strong> Settings &gt; Display &gt; Accidental touch protection, and in the Phone app &gt; Settings, check any option to turn the screen off during calls.</li>
<li><strong>Xiaomi, Redmi, POCO:</strong> Phone app settings &gt; Incoming call settings &gt; Proximity sensor, and Pocket mode in the lock screen settings.</li>
<li><strong>Other Android phones:</strong> search Settings for "proximity" or "pocket".</li>
<li><strong>iPhone:</strong> there is no switch; restart and update iOS.</li>
</ul>
<p>Install any waiting system update too. Proximity bugs after updates are well known and usually fixed in the next release.</p>',
			'settings',
		),
		array(
			'4. Use the hidden test menu',
			'<p>Many Android phones have a hardware test menu that shows the sensor directly. On Samsung, open the Phone app and dial <code>*#0*#</code>, then tap <strong>Sensor</strong>: covering the sensor turns the screen green and the phone vibrates. On Xiaomi, Redmi and POCO, <code>*#*#6484#*#*</code> opens the CIT test menu with a proximity sensor test, and on some models a calibration option. If the test menu shows no change when you cover the top of the phone with a bare, clean screen, the sensor or its calibration has failed.</p>',
			'menu',
		),
		array(
			'5. After a screen repair',
			'<p>A replacement screen is the single most common cause of a dead proximity sensor. The sensor is often moved from the old screen frame to the new one, and the small rubber gasket around it, or the clear window above it, can be left out. Cheap replacement screens may also have no proper infrared window, and some phones need the sensor recalibrated with the maker\'s tools after a new screen. If the problem started after a repair, take the phone back and ask the shop to check the proximity sensor and gasket. Good shops test it as standard.</p>',
			'repair',
		),
		array(
			'Getting through a call until it is fixed',
			'<p>If the screen stays black, press the power button twice, or once and then swipe, to wake it; on many phones the side button ends the call when you enable "Press side button to end calls" (Samsung) or a similar accessibility option. Speakerphone, wired earphones or Bluetooth avoid the problem entirely, because the phone does not need to turn the screen off when it is not at your ear. If the screen stays on, a quick fix is to turn off the setting that lets the screen respond to touches during calls, where your phone offers it.</p>',
			'workaround',
		),
	),
	'faq'         => array(
		array( 'How do I know if my proximity sensor is broken?', 'Make a call, cover the top of the phone near the earpiece and see if the screen turns off, then uncover it. If nothing happens with a clean screen and no protector, after a restart, the sensor is faulty or needs calibrating.' ),
		array( 'Can a screen protector block the proximity sensor?', 'Yes. It is the most common cause, especially with thick, dark or privacy protectors. Peel back the top edge and test again.' ),
		array( 'Why does my screen go black during calls and not come back?', 'The sensor thinks something is always close: dirt, a protector or a crack over it. Clean it and remove the protector. Pressing the power button wakes the screen meanwhile.' ),
		array( 'Can I calibrate the proximity sensor?', 'Some phones can in their hidden test menu (for example the CIT menu on Xiaomi phones). Others need the maker\'s service tools. A restart resets the software side on every phone.' ),
		array( 'Can I turn off the proximity sensor?', 'Usually not entirely, because it protects calls. Some Android phones let you switch it off in the Phone app settings. Using speaker or earphones avoids it.' ),
		array( 'How much does a proximity sensor repair cost?', 'If it is only a missing gasket or a badly fitted sensor after a screen repair, often little or nothing at the shop that did the work. A failed sensor flex is a small part; board-level faults cost more.' ),
	),
	'ads'         => 'standard',
);
