<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Phone Tests',
	'seo_title'   => 'Phone Tests: Touch Screen, Speaker, Camera & Display Checks',
	'description' => 'Free online phone tests for Android and iPhone. Check the touch screen, eject water from the speaker, test both cameras, and find dead pixels and burn-in.',
	'intro'       => 'Test a phone or tablet straight from its browser, no app needed: a touch screen test for dead zones, a speaker cleaner, front and back camera tests, dead pixel and burn-in checks, a headphone test and an actual-size ruler. Ideal before buying or selling a used phone.',
	'body'        => '<h2>Which phone test do you need?</h2>
<p>For a screen that misses taps or scrolls on its own, open the <a href="/touch-screen-test/">touch screen test</a>. Drawing mode shows every finger, and grid mode fills squares as you swipe so an area that never fills is a dead zone. Follow it with the <a href="/dead-pixel-test/">dead pixel test</a> for black or coloured dots and, on OLED phones, the <a href="/burn-in-test/">burn-in test</a> for ghost images of the keyboard or status bar.</p>
<p>If the speaker is muffled after water, the <a href="/speaker-cleaner/">speaker cleaner</a> plays a low tone that pushes droplets out. The <a href="/headphone-test/">headphone test</a> checks wired or Bluetooth earphones for a dead side, and the <a href="/camera-test/">camera test</a> switches between the front and back cameras and tries the flash. The <a href="/online-mirror/">online mirror</a> is a handy front-camera mirror, and the <a href="/online-ruler/">online ruler</a> calibrates to your phone screen for measuring small objects.</p>

<h2>Checking a used phone</h2>
<p>These tests take about five minutes together and cover the faults that are hardest to see in a photo or an advert. Run them in this order: touch screen (whole surface, then grid), dead pixel test on white and black, burn-in test on grey, speaker cleaner at a moderate volume to confirm the speaker plays cleanly, camera test on both cameras with the flash, headphone test with your own earphones. Anything that fails here is a reason to negotiate or walk away.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>Dead touch zones:</strong> a strip or corner that ignores taps, common after a screen replacement or a drop.</li>
<li><strong>Ghost touches:</strong> taps that register with no finger on the screen, usually a damaged digitiser or a bad screen protector.</li>
<li><strong>Dead or stuck pixels and OLED burn-in:</strong> permanent, so check before buying.</li>
<li><strong>A crackling or quiet speaker:</strong> water, dust or a torn membrane.</li>
<li><strong>A camera that will not start or focus:</strong> a lens that was replaced badly, or software holding the camera.</li>
</ul>

<h2>Tips for phone testing</h2>
<p>Use Chrome on Android and Safari on iPhone for the best support. Allow camera and microphone access when asked. Rotate the phone for the touch test so the edges are covered, and take off the case and screen protector if touches are being missed. For the keyboard and mouse tests on this site you will need a computer or an external keyboard.</p>',
	'faq'         => array(
		array( 'Do I need to install an app?', 'No. Every test runs in the phone\'s browser. Open the page, allow camera or microphone when asked, and the test starts.' ),
		array( 'Which tests work on iPhone?', 'All of the tests on this page work in Safari on iOS 14 or later: touch screen, dead pixel, burn-in, speaker cleaner, headphone test, camera test, online mirror and ruler. Fullscreen on iPhone uses a page-level fallback, since Safari has no fullscreen API for pages.' ),
		array( 'Why does the touch screen test show fewer fingers than I am using?', 'Most phones support 5 or 10 touches, but some browsers cap it lower, and a thick screen protector or wet screen can drop touches. Try again with the protector off and dry hands before assuming the digitiser is faulty.' ),
		array( 'Can the speaker cleaner damage my phone?', 'No. It plays a normal audio tone at a moderate level, the same as music would. It cannot push water deeper into the phone. Start at a medium volume and run it a few times with the speaker facing down.' ),
		array( 'How do I check for burn-in on an OLED phone?', 'Open the burn-in test, pick the grey screen and look for a faint outline of the keyboard, navigation bar or a logo. Light retention fades after a few minutes of varied content; true burn-in stays. Check in a dim room.' ),
		array( 'Can I test the phone\'s vibration, gyroscope or sensors here?', 'Not yet. Sensor tests are planned for a later update. The current pages cover the screen, speaker, headphones and cameras, which are the parts most likely to fail or be damaged.' ),
	),
	'updated'     => '2026-10-28',
	'ads'         => 'standard',
);
