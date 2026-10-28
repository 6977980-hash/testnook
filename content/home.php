<?php
/**
 * Homepage copy. The tool grid itself is built from content/catalog.php.
 */

defined( 'ABSPATH' ) || exit;

return array(
	'seo_title'   => 'Testnook: Free Online Hardware Tests (Keyboard, Mouse, Mic, Camera)',
	'description' => 'Test your keyboard, mouse, controller, screen, speakers, microphone and webcam online. Free browser tools, no download, nothing uploaded.',
	'h1'          => 'Free online hardware tests',
	'intro'       => 'Check your keyboard, mouse, controller, screen, speakers, microphone and webcam in seconds. Every test runs in your browser, so there is nothing to install and nothing leaves your device.',

	'features'    => array(
		array( 'No download', 'Open a test and it starts. Works in Chrome, Edge, Firefox and Safari on Windows, Mac, Linux, Android and iPhone.' ),
		array( 'Private by design', 'Camera, microphone and input tests are processed on your device. We never record, upload or store them.' ),
		array( 'Real answers', 'Each test explains what the result means and how to fix the most common problems, so you know what to do next.' ),
		array( 'Always free', 'No account, no trial and no limits. Use the tests as often as you like, at home or at a shop before you buy.' ),
	),

	'body'        => '<h2>Why test your hardware online?</h2>
<p>Most hardware problems are easy to miss until they get in your way: a key that only registers half the time, a mouse that double clicks on its own, a controller stick that drifts, a dead pixel in the corner of a new monitor or a microphone that sounds fine to you but silent to everyone on the call. A quick browser test tells you in seconds whether the fault is in the device or somewhere else, such as a driver, a cable or an app setting.</p>
<p>Online tests are also the fastest way to check a device before a return window closes, before you sell or buy something second hand, or before an important meeting, stream or match.</p>
<h2>How the tests work</h2>
<p>Modern browsers can read keyboards, mice, gamepads, touch screens, cameras and microphones directly through standard web APIs. Testnook uses those same APIs to show you exactly what your device reports, in real time. When a test needs your camera or microphone, your browser asks for permission first, and you can revoke it at any time from the address bar.</p>
<p>Because the tests run locally, they work even on slow connections once the page has loaded, and the results reflect your actual hardware rather than a server somewhere else.</p>',

	'faq'         => array(
		array( 'Are these tests really free?', 'Yes. Every test on Testnook is free to use with no account and no limits. The site is supported by ads on content pages.' ),
		array( 'Do you record my camera or microphone?', 'No. Camera and microphone tests run entirely in your browser. Video and audio are never uploaded or stored. Recordings you make in a playback test stay in your browser memory and disappear when you close the page.' ),
		array( 'Do I need to install anything?', 'No. All you need is an up-to-date browser such as Chrome, Edge, Firefox or Safari. Nothing is downloaded to your computer or phone.' ),
		array( 'Why does the browser ask for permission?', 'Browsers protect your camera and microphone. A test can only use them after you click Allow. If you blocked a request by mistake, click the camera or lock icon in the address bar to allow it again.' ),
		array( 'Do the tests work on phones?', 'Yes. Screen, touch, speaker, camera and microphone tests work on Android and iPhone. Keyboard and mouse tests need a physical keyboard or mouse, so they are best on a computer.' ),
		array( 'A test says my device has a problem. What now?', 'Each test page has a "Common problems and fixes" section. Start with the simple steps such as reconnecting, updating drivers or trying another port. If the fault stays, the hardware may need repair or a warranty claim.' ),
	),
);
