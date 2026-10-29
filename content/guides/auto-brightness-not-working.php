<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Auto-Brightness Not Working? How to Fix Adaptive Brightness',
	'seo_title'   => 'Auto-Brightness Not Working? Fixes for Android and iPhone',
	'description' => 'Screen too dark, too bright or not changing with the light? Fix auto-brightness on Android and iPhone: settings, learned curves, covered sensors, repairs.',
	'blurb'       => 'Why adaptive brightness gets it wrong and how to reset it, from a covered sensor to a learned curve.',
	'hub'         => 'phone',
	'tool'        => 'light-sensor-test',
	'tools'       => array( 'phone-sensor-test', 'proximity-sensor-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Auto-brightness should make the screen dim in a dark room and bright in the sun without you touching the slider. When it stops working, the screen is unreadable outdoors or blinding at night. The cause is usually a setting, a covered light sensor or a brightness curve the phone has learned badly. Test the sensor in 30 seconds with the <a href="/light-sensor-test/">light sensor test</a>, then use the fixes below.',
	'summary'     => array(
		'Check auto-brightness is actually on: Android <strong>Adaptive brightness</strong> in Display settings; iPhone <strong>Auto-Brightness</strong> in Accessibility &gt; Display &amp; Text Size.',
		'The light sensor sits <strong>beside the front camera</strong>. A case lip, screen protector or dirt over it makes the phone think the room is dark.',
		'Phones <strong>learn from your slider changes</strong>. Turning auto-brightness off and on, or resetting the learned data, fixes a screen that is always too dim or too bright.',
		'Battery saver, heat protection and dark mode settings can also cap brightness. If the screen does not react to light at all after all this, the sensor may need repair.',
	),
	'sections'    => array(
		array(
			'How auto-brightness works',
			'<p>An ambient light sensor on the front of the phone measures how much light falls on it, in lux. The phone maps that number to a screen brightness using a curve: low brightness in a dark bedroom (a few lux), medium in an office (300 to 500 lux), full brightness in sunlight (tens of thousands of lux). On iPhone and most Android phones the curve adapts to you: each time you move the brightness slider, the phone shifts the curve for that light level.</p>
<p>So there are three places it can go wrong: the setting is off, the sensor cannot see the light, or the learned curve is off. Each needs a different fix.</p>',
			'how',
		),
		array(
			'1. Make sure it is turned on',
			'<p><strong>Android:</strong> Settings &gt; Display &gt; Adaptive brightness (Samsung: Settings &gt; Display &gt; Adaptive brightness, or the "Auto" toggle next to the brightness slider in quick settings).</p>
<p><strong>iPhone:</strong> Settings &gt; Accessibility &gt; Display &amp; Text Size &gt; Auto-Brightness, at the bottom of the list. Apple put it there, not in Display &amp; Brightness, which is why many people think it is missing.</p>
<p>If it was off, turn it on and give it a day of normal use before judging it.</p>',
			'on',
		),
		array(
			'2. Uncover and clean the light sensor',
			'<p>The sensor is next to the front camera or the earpiece, sometimes hidden under the display. When something covers it, the phone sees a dark room and dims the screen, even in daylight. Common culprits: a case with a raised top lip, a screen protector with a dark border or a misplaced cut-out, a sticker, dust or make-up. Clean the top of the screen and test without the case.</p>
<p>The <a href="/light-sensor-test/">light sensor test</a> checks this: cover the area by the front camera and the screen should dim within a few seconds, then brighten under a lamp. If it only reacts when you cover one particular spot, that spot is the sensor.</p>',
			'sensor',
		),
		array(
			'3. Reset the learned brightness',
			'<p>If the screen reacts to light but is always a bit too dim or too bright, the learned curve is the problem, often after you dragged the slider in an unusual situation such as a dark cinema.</p>
<ul>
<li><strong>iPhone:</strong> turn Auto-Brightness off, restart the phone, then turn it on again. Then set the slider once to a comfortable level in normal light.</li>
<li><strong>Google Pixel:</strong> Settings &gt; Apps &gt; See all apps &gt; Device Health Services &gt; Storage &amp; cache &gt; Clear storage &gt; Reset adaptive brightness.</li>
<li><strong>Samsung and other Android phones:</strong> turn Adaptive brightness off, restart, turn it on again. On Samsung, clearing the data of the brightness learning is not exposed, but switching it off and on clears most odd behavior.</li>
</ul>
<p>After a reset, use the slider sparingly for a few days. Every correction teaches the phone your preference.</p>',
			'reset',
		),
		array(
			'4. Settings that cap brightness',
			'<p>Auto-brightness may be working while something else holds the screen down:</p>
<ul>
<li><strong>Battery saver or Low Power Mode</strong> lowers the maximum brightness on many phones.</li>
<li><strong>Heat:</strong> phones dim the screen to protect themselves when hot, for example in direct sun or while charging and gaming. It recovers once the phone cools.</li>
<li><strong>Extra dim, Reduce White Point and dark mode schedules</strong> make the screen look dimmer at any brightness. On iPhone, check Accessibility &gt; Display &amp; Text Size &gt; Reduce White Point; on Android, look for Extra dim in quick settings.</li>
<li><strong>Night Light, Night Shift and Eye comfort</strong> change the color, which can look dimmer, but not the actual brightness.</li>
</ul>',
			'caps',
		),
		array(
			'5. When it is the sensor',
			'<p>If the screen never changes with the light, with auto-brightness on, the sensor clean and uncovered, after a restart, the sensor may have failed. Samsung phones show its reading in the test menu: dial <code>*#0*#</code>, tap Sensor and watch the light sensor lux value while you cover it and shine a light on it. A value that never changes means a hardware fault. The light sensor often shares a module and flex cable with the <a href="/proximity-sensor-test/">proximity sensor</a>, so if both stopped at the same time, especially after a screen replacement, the cable or its placement is the likely cause. A repair shop can usually fix that without a new screen.</p>',
			'hardware',
		),
	),
	'faq'         => array(
		array( 'Where is auto-brightness on iPhone?', 'In Settings &gt; Accessibility &gt; Display &amp; Text Size, at the bottom. It is not in Display &amp; Brightness on current iOS versions.' ),
		array( 'Why is my screen dim even with auto-brightness on?', 'The light sensor may be covered by a case or protector, the phone may have learned a dim curve, or battery saver or heat is capping brightness. Check each in that order.' ),
		array( 'How do I reset adaptive brightness on Android?', 'On Pixel phones, clear the storage of Device Health Services and tap Reset adaptive brightness. On other phones, turn adaptive brightness off, restart and turn it on again.' ),
		array( 'Where is the light sensor on my phone?', 'Next to the front camera or earpiece at the top of the front, sometimes under the screen. Covering that area with your finger should make the screen dim.' ),
		array( 'Does auto-brightness save battery?', 'Yes, usually. The screen is the biggest power user, and auto-brightness keeps it lower whenever full brightness is not needed.' ),
		array( 'Can I test the light sensor online?', 'Yes. The light sensor test on this site runs a quick auto-brightness check and a camera light meter in the browser. Most browsers do not show the raw lux value.' ),
	),
	'sources'     => array(
		array( 'Apple: Adjust the brightness and color temperature on your iPhone or iPad', 'https://support.apple.com/en-us/109351' ),
	),
	'ads'         => 'standard',
);
