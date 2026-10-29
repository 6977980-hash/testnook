<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Webcam & Camera Tests',
	'seo_title'   => 'Camera Tests: Webcam Test, Phone Camera Test & Online Mirror',
	'description' => 'Free online camera tests. See your webcam or phone camera live with resolution and frame rate, switch front and back cameras, and use an online mirror.',
	'intro'       => 'Check that your camera works before the call: a webcam test that shows resolution and frame rate, a camera test for front and back phone cameras, an online mirror with zoom and brightness, and a mic test to go with it. Video never leaves your device.',
	'body'        => '<h2>Which camera test do you need?</h2>
<p>On a laptop or with a USB webcam, open the <a href="/webcam-test/">webcam test</a>. It shows the live picture, the resolution the camera is actually delivering, the frame rate and the camera name, so you can tell a 720p webcam from a 1080p one and spot a camera that drops to 15 fps in low light. It lets you pick a camera when more than one is connected, which fixes the common problem of a video call using the wrong one.</p>
<p>On a phone or tablet, the <a href="/camera-test/">camera test</a> adds switching between the front and back cameras, a torch button where the browser supports it, and a list of every camera it has tested. The <a href="/online-mirror/">online mirror</a> turns the front camera into a mirror with zoom, brightness and a white ring-light frame, and can freeze and save a photo.</p>
<p>Camera tests are usually followed by a sound check, so the <a href="/mic-test/">mic test</a> is listed here too. It shows a live level meter and records a short sample for playback.</p>
<p>About to join a video call? The <a href="/zoom-test/">Zoom test</a> checks the camera, the lighting on your face, the microphone and your speakers on one page, plays back a short recording of your voice and ticks off each item, so you know everything works before you click Join in Zoom, Teams or Meet.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>Black picture:</strong> a privacy shutter, a disabled camera in the system settings, or another app holding the camera.</li>
<li><strong>Wrong camera used:</strong> laptops with a virtual camera (from streaming software) often pick that by default.</li>
<li><strong>Low resolution:</strong> the camera is delivering 640x480 because of a slow USB port, a driver, or a bandwidth limit on a hub.</li>
<li><strong>Low frame rate:</strong> usually poor lighting; most webcams halve their frame rate in a dim room.</li>
<li><strong>Blurry or dirty image:</strong> a smudge on the lens is the most common fault on both laptops and phones.</li>
</ul>

<h2>Before you blame the camera</h2>
<p>Close every other app that could be using the camera, including video call apps running in the background. Allow the camera when the browser asks, or click the camera icon in the address bar to change the choice. On Windows, check the camera privacy setting that lets desktop apps use the camera. On a Mac, a green light with no picture usually means another app has the camera.</p>

<h2>Privacy</h2>
<p>Every camera test on this site runs in your browser. Nothing is recorded, uploaded or stored. Photos you save go straight to your downloads folder.</p>',
	'faq'         => array(
		array( 'The page says the camera is blocked. How do I allow it?', 'Click the camera or lock icon in the address bar, set the camera to Allow and reload. On a phone, also check the browser\'s camera permission in the system settings.' ),
		array( 'Why is my webcam showing 640x480 instead of 1080p?', 'The webcam test asks for the highest resolution the camera offers. If it reports a low one, the camera may be on a USB 2.0 hub, the driver may limit it, or another app is already using it at a lower setting. Try a direct USB port.' ),
		array( 'Is my video uploaded anywhere?', 'No. The picture goes from the camera to your browser window and nowhere else. The site has no server-side video processing at all.' ),
		array( 'Can I test the back camera on my phone?', 'Yes. The camera test has a switch camera button that moves between the front and back cameras, and a camera picker when the phone exposes several lenses.' ),
		array( 'My webcam works here but not in Zoom or Teams. Why?', 'The camera is fine. Check the camera picked in the app settings, close other apps that use the camera, and on Windows allow desktop apps to use the camera in the privacy settings. Restarting the app after changing the camera often helps.' ),
		array( 'Why does the picture look dark or grainy?', 'Almost always lighting. Face a window or a lamp rather than having it behind you. Webcams drop their frame rate and raise noise in low light. Wipe the lens as well; fingerprints make everything look hazy.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
