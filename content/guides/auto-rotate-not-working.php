<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Auto-Rotate Not Working? How to Fix Screen Rotation',
	'seo_title'   => 'Auto-Rotate Not Working? Screen Rotation Fixes for Phones',
	'description' => 'Screen will not rotate? Check the rotation lock, the app, the accelerometer and the settings that block it, with fixes for Android and iPhone in order.',
	'blurb'       => 'Why the screen stops rotating and the fixes to try in order, from the rotation lock to a sensor test.',
	'hub'         => 'phone',
	'tool'        => 'accelerometer-test',
	'tools'       => array( 'phone-sensor-test', 'bubble-level' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'You turn the phone sideways to watch a video and the picture stays stubbornly upright. Most of the time the cause is a setting, not a broken part. Work through these checks in order; the sensor test near the end tells you in a few seconds whether the hardware is to blame.',
	'summary'     => array(
		'Most rotation problems are the <strong>rotation lock</strong>: Auto-rotate off on Android, Portrait Orientation Lock on in iPhone Control Centre.',
		'Some screens and apps <strong>never rotate</strong>: the iPhone home screen on most models, many Android launchers, and apps that are built portrait-only.',
		'If rotation works in some apps but not others, it is the app. If it works nowhere, run the <a href="/accelerometer-test/">accelerometer test</a>: if "Sensor says" changes when you turn the phone, the sensor is fine.',
		'A sensor that reads nothing after a restart and a safe mode check usually needs a repair, often after a drop or water damage.',
	),
	'sections'    => array(
		array(
			'1. Check the rotation lock',
			'<p><strong>Android:</strong> swipe down twice from the top to open quick settings and look for <strong>Auto-rotate</strong> (on some phones it shows as Portrait or Landscape when locked). Tap it so it reads Auto-rotate. On Samsung phones it is in the same panel; when locked, a small rotate icon appears in the navigation bar when you turn the phone, and tapping it rotates once.</p>
<p><strong>iPhone:</strong> swipe down from the top-right corner (or up from the bottom on iPhones with a Home button) to open Control Centre. If the padlock with a circular arrow is red or white, Portrait Orientation Lock is on. Tap it to turn it off.</p>
<p><strong>iPad and tablets:</strong> the same lock exists, and on some iPads the side switch can be set to lock rotation instead of mute.</p>',
			'lock',
		),
		array(
			'2. Make sure the app can rotate',
			'<p>Plenty of screens are designed for one orientation only. The iPhone home screen only rotates on Plus and Max models, many Android launchers stay in portrait unless you turn on "Rotate to landscape" in their settings, and lots of apps (some banking apps, Instagram, many games) lock themselves to portrait or landscape. Test with an app that always rotates: the browser, the calculator or YouTube in full screen.</p>
<p>If rotation works there, your phone is fine and the app you were using simply does not rotate. Some Android phones also have a per-app setting under Display, or in developer options a "Force activities to be resizable" switch that can affect it; leave developer options alone unless you know what they do.</p>',
			'app',
		),
		array(
			'3. Restart, then rule out an app',
			'<p>A restart fixes a surprising number of stuck sensors, because the service that reads the accelerometer starts fresh. If rotation still fails everywhere, an app may be holding the orientation: screen recorders, rotation control apps, launchers and some driving or kids modes do this.</p>
<p>On Android, boot into <strong>safe mode</strong> (hold the power-off option on the power menu, then confirm). Safe mode starts the phone with downloaded apps disabled. If rotation works in safe mode, uninstall recently added apps one by one. Restart normally to leave safe mode.</p>',
			'restart',
		),
		array(
			'4. Test the accelerometer',
			'<p>Auto-rotate uses the accelerometer to see which way gravity pulls. Open the <a href="/accelerometer-test/">accelerometer test</a>, tap Start and turn the phone sideways.</p>
<ul>
<li><strong>"Sensor says" changes to Landscape</strong> but "Screen is" stays Portrait: the sensor works. The block is a setting or the app, so go back to steps 1 to 3.</li>
<li><strong>Numbers change but the gravity check is far from 9.81:</strong> the sensor is miscalibrated. Restart, then calibrate if your phone offers it.</li>
<li><strong>No data at all on a phone:</strong> check motion access for the browser first (on iPhone, tap Allow; on Android, allow Motion sensors in the site settings). If it is allowed and still nothing arrives, the sensor or its driver has failed.</li>
</ul>
<p>The <a href="/phone-sensor-test/">phone sensor test</a> shows every sensor at once if you also want to check the gyroscope and compass.</p>',
			'test',
		),
		array(
			'5. Calibrate and update',
			'<p>Some Android phones offer sensor calibration in Settings (search for "calibrat") or in a hardware test menu; Samsung phones show the sensors after dialling <code>*#0*#</code> and tapping Sensor. Lay the phone on a flat table for calibration. iPhones calibrate at the factory and have no option; a restart is the reset.</p>
<p>Install pending system updates too. Rotation bugs after an update are not rare, and they are usually fixed in the next one. If rotation broke right after an update and the sensor test passes, an update or a reset of settings (Android: Reset settings or Reset app preferences; iPhone: Settings &gt; General &gt; Transfer or Reset &gt; Reset &gt; Reset All Settings) clears it without deleting data.</p>',
			'calibrate',
		),
		array(
			'6. When it is the hardware',
			'<p>If the accelerometer test shows no data in a browser that has motion access, or values that never change, after a restart and safe mode, the sensor itself has likely failed. It sits on the main board, so a hard drop or water damage is the usual cause. A repair shop can confirm it with a diagnostic; on most phones the fix is a board repair rather than a cheap part swap, so get a quote first. Until then, you can still rotate manually: Android shows a rotate button when Auto-rotate is off, and many video apps have their own full-screen rotate button.</p>',
			'hardware',
		),
	),
	'faq'         => array(
		array( 'Why does my phone not rotate when I turn it?', 'Usually the rotation lock is on, or the app does not support rotation. Turn off Portrait Orientation Lock (iPhone) or turn on Auto-rotate (Android), then test in the browser.' ),
		array( 'Which sensor controls auto-rotate?', 'The accelerometer. It senses gravity, so it knows which way up the phone is. The gyroscope helps with smooth motion but auto-rotate works without it.' ),
		array( 'Why does my iPhone home screen not rotate?', 'Only Plus and Max sized iPhones rotate the home screen, and only with Display Zoom set to Standard. Other iPhones keep the home screen in portrait by design.' ),
		array( 'How do I know if my accelerometer is broken?', 'Open the accelerometer test, tap Start and tilt the phone. If nothing changes after a restart, with motion access allowed, the sensor is probably faulty.' ),
		array( 'Can a case or magnet stop auto-rotate?', 'A case cannot. A strong magnet affects the compass, not the accelerometer, so it does not stop rotation.' ),
		array( 'Does auto-rotate drain the battery?', 'Hardly at all. The accelerometer uses very little power and runs anyway for step counting and other features.' ),
	),
	'ads'         => 'standard',
);
