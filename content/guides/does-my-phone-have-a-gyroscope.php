<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Does My Phone Have a Gyroscope? How to Check in 30 Seconds',
	'seo_title'   => 'Does My Phone Have a Gyroscope? How to Check in 30 Seconds',
	'description' => 'Find out if your Android phone or iPhone has a gyroscope, why some budget phones do not, what a "virtual gyroscope" is, and what you lose without one.',
	'blurb'       => 'How to tell whether a phone has a real gyroscope, and what you lose without one.',
	'hub'         => 'phone',
	'tool'        => 'gyroscope-test',
	'tools'       => array( 'phone-sensor-test', 'accelerometer-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Gyro aiming in mobile games, 360 degree videos, VR viewers and smooth panorama photos all need a gyroscope, and not every phone has one. Every iPhone does; many cheaper Android phones and tablets leave it out to save cost. Here is the fastest way to check yours, and what it means if the answer is no.',
	'summary'     => array(
		'<strong>Every iPhone since the iPhone 4</strong> has a gyroscope. Most mid-range and flagship Android phones do too; some <strong>budget Android phones and tablets</strong> do not.',
		'The quickest check: open the <a href="/gyroscope-test/">gyroscope test</a> on the phone, tap Start and turn the phone. If the rotation graph moves, you have one.',
		'If the test says motion data arrives "without rotation rate", the phone has an accelerometer but <strong>no gyroscope</strong>.',
		'A "virtual gyroscope" estimates rotation from the accelerometer and compass. It is fine for slow tilting but too slow and jumpy for gyro aiming.',
	),
	'sections'    => array(
		array(
			'The 30 second check',
			'<ol>
<li>Open the <a href="/gyroscope-test/">gyroscope test</a> in the phone\'s browser (Chrome on Android, Safari on iPhone).</li>
<li>Tap <strong>Start</strong>. On iPhone, Safari asks for permission to use motion and orientation; tap Allow. If you tapped Deny before, close the tab and open the page again.</li>
<li>Turn the phone in your hand. With a gyroscope, the 3D phone follows you and the graph shows the rotation rate around each axis.</li>
</ol>
<p>The page tells you in words what it found. "Gyroscope is working" means a real sensor is reporting. "Motion data arrives but without rotation rate" means the phone has an accelerometer and no gyroscope. "No motion data" usually means the browser blocks sensors (some privacy browsers do) or the page was opened on a computer, which almost never has one. The <a href="/phone-sensor-test/">phone sensor test</a> lists every motion, orientation, light and location sensor the browser can see in one go.</p>',
			'check',
		),
		array(
			'Which phones do not have a gyroscope?',
			'<p>All iPhones from the iPhone 4 onward have a three-axis gyroscope, and so do iPads from the iPad 2. On Android, the gyroscope is a cheap part but still one that makers leave out of their lowest-priced models, mostly entry-level phones and tablets. The same model name can even differ by region or year, so a spec sheet that says "Gyro: No" or simply does not list it is a warning sign.</p>
<p>Android settings do not list the sensors, so the easiest proofs are a browser test like ours or an app that lists hardware sensors. Spec sites usually list the sensors under a "Features" or "Sensors" line.</p>',
			'which-phones',
		),
		array(
			'What is a virtual gyroscope?',
			'<p>Some phones without the chip offer a software "virtual gyroscope" or "gyro emulation". It estimates rotation from the accelerometer (which senses gravity and movement) and the magnetometer (the compass). It can tell roughly which way the phone is tilted, so slow things such as auto-rotate and simple 360 degree photo viewers work.</p>
<p>What it cannot do is measure fast rotation precisely. The compass reacts slowly and is thrown off by nearby metal and magnets, and the accelerometer cannot tell turning from moving. The result is lag and jitter, which is why gyro aiming in games feels unusable and VR views drift on these phones. Our guide to the <a href="/gyroscope-vs-accelerometer/">gyroscope and the accelerometer</a> explains the difference between the two sensors.</p>',
			'virtual',
		),
		array(
			'What you lose without a gyroscope',
			'<ul>
<li><strong>Gyro aiming</strong> in shooters such as PUBG Mobile, Call of Duty Mobile and Fortnite: the option is missing or does nothing.</li>
<li><strong>360 degree videos and photos</strong> on YouTube and Facebook: you swipe to look around instead of turning the phone.</li>
<li><strong>VR viewers</strong> such as cardboard headsets: the view drifts or does not follow your head.</li>
<li><strong>Augmented reality</strong>: AR apps track how the phone turns in space, so on phones without a gyroscope many refuse to install or lose track of the scene.</li>
<li><strong>Panoramas and stabilization:</strong> panorama modes and some video stabilization rely on the gyro; without it they are less smooth or missing.</li>
</ul>
<p>Auto-rotate, step counting and the <a href="/bubble-level/">bubble level</a> work fine with the accelerometer alone.</p>',
			'what-you-lose',
		),
		array(
			'When the gyroscope is there but misbehaves',
			'<p>If the test shows a gyroscope but games drift or the view slowly spins, run the <strong>drift check</strong> on the <a href="/gyroscope-test/">gyroscope test</a>: lay the phone flat and still for ten seconds. A healthy sensor reads close to zero; a steady non-zero rate is drift. Restarting the phone clears most short-term drift, and the in-game "calibrate gyroscope" option (with the phone flat on a table) handles the rest. A gyroscope that drifts badly after a restart and a calibration, or stops reporting after a drop, is a hardware fault.</p>',
			'misbehaves',
		),
	),
	'faq'         => array(
		array( 'Do all iPhones have a gyroscope?', 'Every iPhone from the iPhone 4 (2010) onward has a three-axis gyroscope, and every iPad from the iPad 2. Safari only asks for permission before a website can read it.' ),
		array( 'Can I add a gyroscope to my phone?', 'No. The gyroscope is a chip on the main board. Software "virtual gyroscopes" only estimate rotation from other sensors and are not a real replacement.' ),
		array( 'Why does my game not show a gyroscope option?', 'Either the phone has no gyroscope, or the game hides the option on devices that report no gyroscope. Check the phone with the gyroscope test first.' ),
		array( 'Is the gyroscope the same as the accelerometer?', 'No. The accelerometer measures movement and the pull of gravity, so it knows which way is down. The gyroscope measures how fast the phone rotates. Most phones have both.' ),
		array( 'Does a laptop have a gyroscope?', 'Almost never. Some 2-in-1 tablets and convertibles have one for screen rotation. Test it on the device itself.' ),
		array( 'Is the gyroscope data sent anywhere by the test?', 'No. The readings are processed in your browser to draw the graph and are not sent to Testnook.' ),
	),
	'sources'     => array(
		array( 'Apple: iPhone 4 technical specifications (three-axis gyro)', 'https://support.apple.com/en-us/112562' ),
		array( 'Google: ARCore supported devices and requirements', 'https://developers.google.com/ar/devices' ),
		array( 'W3C: DeviceOrientation Event Specification', 'https://www.w3.org/TR/orientation-event/' ),
	),
	'ads'         => 'standard',
);
