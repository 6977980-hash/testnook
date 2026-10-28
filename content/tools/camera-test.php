<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Camera Test',
	'seo_title'      => 'Camera Test: Check Front and Back Phone Cameras Online',
	'description'    => 'Free online camera test for phones, tablets and laptops. Check front and back cameras, switch between them, see real resolution and frame rate, take a photo.',
	'intro'          => 'Check that every camera on your phone or laptop works. Start the test, switch between the front and back cameras, and read the real resolution and frame rate each one delivers. Nothing is uploaded; the picture never leaves your device.',
	'device'         => 'media',
	'device_message' => 'Your browser cannot access cameras. Open this page in an up-to-date Chrome, Edge, Firefox or Safari over HTTPS.',
	'ads'            => 'standard',
	'styles'         => array( 'camera-test' ),
	'scripts'        => array( 'camera-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="ct-start">Start camera</button>
		<button type="button" class="btn" id="ct-flip" disabled>Switch front / back</button>
		<button type="button" class="btn" id="ct-stop" disabled>Stop</button>
	</div>
	<label class="visually-hidden" for="ct-device">Camera</label>
	<select id="ct-device" class="ct-select" hidden></select>
</div>
<div class="tool-stage ct-stage" id="ct-stage">
	<video id="ct-video" playsinline muted autoplay hidden></video>
	<div class="ct-empty" id="ct-empty"><p><strong>Your camera is off.</strong></p><p>Press <em>Start camera</em> and allow access when your browser asks. The picture stays on your device.</p></div>
</div>
<div class="btn-row ct-actions">
	<button type="button" class="btn btn-sm" id="ct-snap" disabled>Take photo</button>
	<button type="button" class="btn btn-sm" id="ct-torch" aria-pressed="false" hidden>Flash</button>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#tool">Full screen</button>
</div>
<div class="stats ct-stats">
	<div class="stat"><span class="stat-label">Camera</span><span class="stat-value" id="ct-name">-</span></div>
	<div class="stat"><span class="stat-label">Facing</span><span class="stat-value" id="ct-facing">-</span></div>
	<div class="stat"><span class="stat-label">Resolution</span><span class="stat-value" id="ct-res">-</span></div>
	<div class="stat"><span class="stat-label">Frame rate</span><span class="stat-value" id="ct-fps">-</span></div>
	<div class="stat"><span class="stat-label">Aspect ratio</span><span class="stat-value" id="ct-ar">-</span></div>
	<div class="stat"><span class="stat-label">Cameras found</span><span class="stat-value" id="ct-count">-</span></div>
</div>
<div class="ct-results" hidden><strong>Cameras tested so far</strong><ul id="ct-list"></ul></div>
<p class="tool-status" id="ct-status" aria-live="polite"></p>',
	'howto'          => array(
		'Press <strong>Start camera</strong> and choose <strong>Allow</strong> when the browser asks. The front camera opens first.',
		'On a phone or tablet, press <strong>Switch front / back</strong> to test the back camera. On a laptop with more than one camera, pick each one from the camera list.',
		'Read the <strong>Resolution</strong> and <strong>Frame rate</strong> for each camera. Point the camera at something bright and then something dark to see whether it focuses and adjusts exposure.',
		'Press <strong>Take photo</strong> to save a still from the current camera and check it for blur, spots or a colour cast.',
		'Every camera you test is listed under the stats, so you can compare them. Press <strong>Stop</strong> when you are done.',
	),
	'howto_title'    => 'How to test your phone camera',
	'results'        => '<p><strong>Resolution</strong> is the video size the camera delivers to the browser, up to the 1920x1080 this test asks for. Phone cameras take photos at 12 MP or more, but browsers receive video, so 1080p (2.1 MP) or 720p is normal here and does not mean your camera is limited. A camera that only gives 640x480 when the other one gives 1080p is either an older sensor or is being throttled by the system.</p>
<p><strong>Frame rate</strong> is measured from the frames that actually arrive. 30 fps is normal; 24-29 is fine; 15 or lower means the camera is in a low-light mode or the phone is busy. Try again with more light before blaming the hardware.</p>
<p><strong>Facing</strong> tells you which camera is on. Phones with several back lenses show them as one "back" camera to the browser; the system picks the main lens. Laptops report "Unknown" when the camera does not say which way it faces, which is normal.</p>
<p>If a camera starts, shows a clear picture, focuses and reports a steady frame rate, it works. A black picture with a frame rate, a green or pink tint, or a picture that never sharpens are hardware or driver faults.</p>',
	'results_title'  => 'What the camera test shows',
	'extra'          => array(
		array(
			'Testing a phone camera before buying or after a repair',
			'<p>This camera test is the quickest way to check a second-hand phone or a phone back from repair. Start the front camera, switch to the back camera, and look for the usual problems: a camera that does not start at all (a disconnected flex cable or a failed sensor), a black or very dark picture (a dead sensor or a lens cover left in the case), spots that stay in the same place when you move the phone (dust or damage on the sensor), a pink or green tint (a damaged sensor or a bad repair), and a picture that stays blurry close up (a stuck focus motor, which is common after a drop). The <strong>Flash</strong> button appears on phones whose browser can control the torch, so you can check the LED too.</p>
<p>For a laptop webcam with more detail, including resolution choices up to 4K, use the <a href="/webcam-test/">webcam test</a>. To check your face lighting before a call, the <a href="/online-mirror/">online mirror</a> adds brightness and zoom controls.</p>',
			'before-buying',
		),
		array(
			'Front camera vs back camera',
			'<p>The front camera on a phone is tuned for selfies and video calls: a wide lens, lower resolution, and a mirrored preview so that it feels like a mirror (this test mirrors the front camera the same way; the photo you save is mirrored too, like a phone selfie). The back camera is the main camera with the larger sensor, autofocus and the flash. Both should start here. If one does not, the fixes below cover the common causes.</p>',
			'front-back',
		),
	),
	'fixes'          => array(
		array( 'The back camera does not start', 'Close the camera app and any app that uses the camera (video calls, scanners), then press Start again. On Android, check that the browser has camera permission in Settings, Apps. If the back camera fails in every app, restart the phone; if it still fails, the camera module or its flex cable is faulty.' ),
		array( 'The permission prompt never appears', 'The site was blocked earlier. Tap the lock icon in the address bar and allow the camera, or on iPhone go to Settings, Safari, Camera and choose Ask or Allow. The page must be loaded over HTTPS.' ),
		array( 'The picture is black but the frame rate shows a number', 'The camera is sending frames with no image: a lens cover, a case blocking the lens, or a sensor fault. Remove the case and clean the lens; if the picture is still black in the phone\'s own camera app, the hardware has failed.' ),
		array( 'The picture is blurry or will not focus', 'Clean the lens with a soft cloth; fingerprints are the usual cause. The front camera on most phones has fixed focus and is blurry close up by design. A back camera that never sharpens has a stuck focus motor, often after a drop or a magnet (some mounts and cases) sitting next to the lens.' ),
	),
	'faq'            => array(
		array( 'How do I test my phone camera?', 'Open this page, press Start camera and allow access. Then press Switch front / back to test the other camera and read the resolution and frame rate for each.' ),
		array( 'Why is the resolution lower than my camera\'s megapixels?', 'Browsers receive a video stream, not full-size photos. 1080p or 720p video is normal for a camera that takes 12 MP or 48 MP photos.' ),
		array( 'Is anything uploaded or recorded?', 'No. The video stays in your browser. A photo you take is only saved if you press Download.' ),
		array( 'Can I test all the back cameras on my phone?', 'The browser shows the back cameras as one camera and the system picks the main lens. The wide and telephoto lenses are not selectable from a web page on most phones.' ),
		array( 'Why is the front camera mirrored?', 'The preview is mirrored to feel like a mirror, the way phone selfie previews are. The back camera is not mirrored.' ),
		array( 'Does the camera test work on a laptop?', 'Yes. It shows the built-in webcam and any USB cameras in the camera list. The switch button only appears on phones and tablets.' ),
	),
	'related'        => array( 'webcam-test', 'online-mirror', 'mic-test', 'touch-screen-test', 'dead-pixel-test', 'sound-test' ),
	'updated'        => '2026-10-28',
);
