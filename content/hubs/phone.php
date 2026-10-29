<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Phone Tests',
	'seo_title'   => 'Phone Tests: Touch Screen, Sensors, GPS, Camera & More',
	'description' => 'Free online phone tests for Android and iPhone. Check the touch screen, sensors, GPS, compass, vibration, torch and cameras, and find out what phone you have.',
	'intro'       => 'Test a phone or tablet straight from its browser, no app needed: touch screen, motion sensors, compass, GPS, vibration motor, torch, front and back cameras, speaker, dead pixels and burn-in, plus pages that tell you what phone you have and everything the browser knows about it. Ideal before buying or selling a used phone.',
	'body'        => '<h2>Which phone test do you need?</h2>
<p>For a screen that misses taps or scrolls on its own, open the <a href="/touch-screen-test/">touch screen test</a>. Drawing mode shows every finger, and grid mode fills squares as you swipe so an area that never fills is a dead zone. Follow it with the <a href="/dead-pixel-test/">dead pixel test</a> for black or colored dots and, on OLED phones, the <a href="/burn-in-test/">burn-in test</a> for ghost images of the keyboard or status bar.</p>
<p>To check the motors and lights, the <a href="/vibration-test/">vibration test</a> plays short, long and pattern buzzes (Android browsers; iPhones get a haptic tick only), and the <a href="/torch-test/">torch test</a> switches the flash LED on, off and as a strobe through the camera.</p>
<p>If the speaker is muffled after water, the <a href="/speaker-cleaner/">speaker cleaner</a> plays a low tone that pushes droplets out. The <a href="/headphone-test/">headphone test</a> checks wired or Bluetooth earphones for a dead side, and the <a href="/camera-test/">camera test</a> switches between the front and back cameras and tries the flash. The <a href="/online-mirror/">online mirror</a> is a handy front-camera mirror, and the <a href="/online-ruler/">online ruler</a> calibrates to your phone screen for measuring small objects. The <a href="/voice-recorder/">voice recorder</a> records and downloads audio from the phone\'s microphone.</p>
<p>Battery running down fast? The <a href="/battery-health-test/">battery health test</a> shows the level and charging state in Chrome on Android, measures how many percent the battery loses per hour, and explains where Android and iPhone show the real battery health.</p>

<h2>Phone sensor tests</h2>
<p>Start with the <a href="/phone-sensor-test/">phone sensor test</a>: one tap shows which sensors your phone has and whether the browser can read them. Then test each one in depth. The <a href="/accelerometer-test/">accelerometer test</a> shows X, Y and Z acceleration, g-force and a gravity check, and tells you whether an auto-rotate problem is the sensor or a setting. The <a href="/gyroscope-test/">gyroscope test</a> draws the rotation rate with a 3D phone and runs a drift check and a full-turn check. The <a href="/compass-test/">compass test</a> shows your heading with its accuracy and steadiness, so you know when to calibrate, and the <a href="/gps-test/">GPS test</a> measures location accuracy, time to first fix and how much the position wanders.</p>
<p>The <a href="/bubble-level/">bubble level</a> turns the phone into a spirit level for shelves and pictures. Browsers hide the light and proximity sensors, so their tests use other routes: the <a href="/light-sensor-test/">light sensor test</a> has a camera light meter and an auto-brightness check, and the <a href="/proximity-sensor-test/">proximity sensor test</a> runs a guided call test with the hidden test codes for Android. On iPhone, tap Allow when Safari asks for motion access.</p>

<h2>Which phone do I have?</h2>
<p>The <a href="/what-phone-do-i-have/">what phone do I have</a> page reads the model an Android phone reports and turns Samsung model codes into names; on iPhone, where Apple hides the model, it lists the models that match your screen. The <a href="/device-info/">device info</a> page shows the operating system, screen resolution, CPU threads, memory, GPU and battery, and the <a href="/what-is-my-user-agent/">user agent</a> page shows the exact browser string support teams ask for. For the display itself, <a href="/screen-resolution/">screen resolution</a> shows the real pixel count and pixel ratio, and <a href="/screen-size/">screen size</a> measures the diagonal in inches with a bank card.</p>

<h2>Checking a used phone</h2>
<p>These tests take about five minutes together and cover the faults that are hardest to see in a photo or an advert. Run them in this order: what phone do I have (does the model match the advert?), touch screen (whole surface, then grid), dead pixel test on white and black, burn-in test on gray, phone sensor test, vibration test, torch test, speaker cleaner at a moderate volume to confirm the speaker plays cleanly, camera test on both cameras, headphone test with your own earphones. Anything that fails here is a reason to negotiate or walk away.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>Dead touch zones:</strong> a strip or corner that ignores taps, common after a screen replacement or a drop.</li>
<li><strong>Ghost touches:</strong> taps that register with no finger on the screen, usually a damaged digitizer or a bad screen protector.</li>
<li><strong>Dead or stuck pixels and OLED burn-in:</strong> permanent, so check before buying.</li>
<li><strong>A crackling or quiet speaker:</strong> water, dust or a torn membrane.</li>
<li><strong>A camera that will not start or focus:</strong> a lens that was replaced badly, or software holding the camera.</li>
<li><strong>A dead vibration motor or torch:</strong> common after drops and water damage, and easy to miss in a quick look.</li>
<li><strong>Faulty sensors:</strong> a screen that will not rotate, a compass that points the wrong way, GPS that never gets a fix or a screen that stays on during calls.</li>
</ul>

<h2>Tips for phone testing</h2>
<p>Use Chrome on Android and Safari on iPhone for the best support. Allow camera and microphone access when asked. Rotate the phone for the touch test so the edges are covered, and take off the case and screen protector if touches are being missed. For the keyboard and mouse tests on this site you will need a computer or an external keyboard.</p>',
	'faq'         => array(
		array( 'Do I need to install an app?', 'No. Every test runs in the phone\'s browser. Open the page, allow camera or microphone when asked, and the test starts.' ),
		array( 'Which tests work on iPhone?', 'Most of them work in Safari on iOS 14 or later: touch screen, dead pixel, burn-in, speaker cleaner, headphone test, camera test, mirror, ruler, voice recorder and device info. Vibration patterns and torch control are limited on iPhone because Safari does not support them fully. Fullscreen on iPhone uses a page-level fallback, since Safari has no fullscreen API for pages.' ),
		array( 'Why does the touch screen test show fewer fingers than I am using?', 'Most phones support 5 or 10 touches, but some browsers cap it lower, and a thick screen protector or wet screen can drop touches. Try again with the protector off and dry hands before assuming the digitizer is faulty.' ),
		array( 'Can the speaker cleaner damage my phone?', 'No. It plays a normal audio tone at a moderate level, the same as music would. It cannot push water deeper into the phone. Start at a medium volume and run it a few times with the speaker facing down.' ),
		array( 'How do I check for burn-in on an OLED phone?', 'Open the burn-in test, pick the gray screen and look for a faint outline of the keyboard, navigation bar or a logo. Light retention fades after a few minutes of varied content; true burn-in stays. Check in a dim room.' ),
		array( 'Can I test the phone\'s vibration, torch and sensors here?', 'Yes. The vibration test plays patterns on Android phones (iPhone browsers only allow a haptic tick), and the torch test switches the flash LED in Chrome on Android. The gyroscope, accelerometer, compass, GPS, light and proximity sensors each have their own test too.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
