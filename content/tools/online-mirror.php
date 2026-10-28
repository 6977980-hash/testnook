<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Online Mirror',
	'seo_title'      => 'Online Mirror: Use Your Camera as a Mirror (Free, Private)',
	'description'    => 'Free online mirror that turns your webcam or front camera into a mirror. Zoom in, brighten it, use a white ring light, freeze the view and save a photo.',
	'intro'          => 'Need a mirror? Press start and your front camera or webcam becomes a mirror on your screen. Zoom in, brighten the picture or turn on the ring light for a better look.',
	'device'         => 'media',
	'device_message' => 'Your browser cannot use the camera. Open this page in an up-to-date Chrome, Edge, Firefox or Safari over HTTPS.',
	'ads'            => 'standard',
	'styles'         => array( 'online-mirror' ),
	'scripts'        => array( 'online-mirror' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<button type="button" class="btn btn-primary" id="om-start">Start mirror</button>
	<label class="visually-hidden" for="om-device">Camera</label>
	<select id="om-device" class="om-select" hidden></select>
</div>
<div class="tool-stage om-stage" id="om-stage">
	<video id="om-video" playsinline muted autoplay hidden></video>
	<canvas id="om-still" hidden aria-label="Frozen mirror image"></canvas>
	<div class="om-empty" id="om-empty"><p><strong>Your mirror is off.</strong></p><p>Press <em>Start mirror</em> and allow the camera. The picture stays on your device.</p></div>
</div>
<div class="btn-row om-actions">
	<button type="button" class="btn btn-sm" id="om-freeze" aria-pressed="false" disabled>Freeze</button>
	<button type="button" class="btn btn-sm" id="om-save" hidden>Save photo</button>
	<button type="button" class="btn btn-sm" id="om-flip" aria-pressed="true">Mirror view</button>
	<button type="button" class="btn btn-sm" id="om-light" aria-pressed="false">Ring light</button>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#tool">Full screen</button>
</div>
<div class="om-sliders">
	<div class="field"><label for="om-zoom">Zoom <output id="om-zoomout" for="om-zoom">1.0x</output></label><input type="range" id="om-zoom" min="100" max="300" step="10" value="100"></div>
	<div class="field"><label for="om-bright">Brightness <output id="om-brightout" for="om-bright">100%</output></label><input type="range" id="om-bright" min="60" max="180" step="5" value="100"></div>
</div>
<p class="tool-status" id="om-status" aria-live="polite"></p>',
	'howto'          => array(
		'Press <strong>Start mirror</strong> and choose <strong>Allow</strong> when your browser asks to use the camera. On a phone the front camera is used.',
		'Look at the screen: the picture is flipped like a real mirror, so raising your right hand raises the hand on the right.',
		'Drag <strong>Zoom</strong> to get closer, for example to check make-up, teeth or contact lenses, and <strong>Brightness</strong> to lighten a dark room.',
		'Press <strong>Ring light</strong> for a bright white frame that lights your face at night, and <strong>Full screen</strong> to use the whole display.',
		'Press <strong>Freeze</strong> to hold the picture still, and <strong>Save photo</strong> if you want to keep it. Press <strong>Stop mirror</strong> to turn the camera off.',
	),
	'howto_title'    => 'How to use the online mirror',
	'results'        => '<p>A normal camera shows you as other people see you. A mirror shows you flipped left to right, which is the face you are used to. This mirror online flips the camera image by default so it feels natural. Turn off <strong>Mirror view</strong> to see the unflipped image, which is how you appear on a video call to others.</p>
<p>The <strong>zoom</strong> is a digital zoom: it enlarges the middle of the image, so it gets softer as you zoom in. For the sharpest close-up, move closer to the camera and add light in front of you. The <strong>ring light</strong> turns the edge of your screen bright white, which works best with screen brightness turned up in a dark room.</p>',
	'extra'          => array(
		array(
			'Is this online mirror private?',
			'<p>Yes. The camera image goes straight from your camera to your screen. Nothing is recorded, uploaded or stored on our servers, and frozen pictures stay on your device unless you press Save photo. You can remove the camera permission at any time from the address bar.</p>',
			'privacy',
		),
		array(
			'Mirror on your computer, phone or tablet',
			'<p>The mirror works with laptop webcams, USB webcams and the front camera of phones and tablets. It is handy before a meeting, to fix your hair on the go or to check your outfit when no mirror is near. If the camera does not start, run the <a href="/webcam-test/">webcam test</a> to see its resolution and frame rate and find the cause. Planning a call? Check your microphone with the <a href="/mic-test/">mic test</a> too.</p>',
			'devices',
		),
	),
	'fixes'          => array(
		array( 'The mirror shows a black screen', 'Open the privacy shutter on your laptop camera, or press the camera key (often F8 or F10). Close Zoom, Teams, FaceTime and other apps that may be using the camera, then press Start mirror again.' ),
		array( 'Camera permission is blocked', 'Click the camera or lock icon in the address bar, allow the camera and reload. On iPhone go to Settings > Safari > Camera and choose Ask or Allow; on Android open the browser\'s site settings. On Windows and Mac also check the system privacy settings for the camera.' ),
		array( 'The image is dark or blurry', 'Turn on Ring light and raise your screen brightness, or face a window or lamp. Wipe the camera lens with a soft cloth, and zoom less: digital zoom loses detail.' ),
		array( 'The mirror is the wrong way round', 'Press Mirror view to switch between a mirrored and a normal image. On phones with several front cameras, choose another one from the camera list.' ),
	),
	'faq'            => array(
		array( 'How do I use my phone camera as a mirror?', 'Open this page on your phone, press Start mirror and allow the camera. The front camera turns into a mirror right away. Press Full screen for a bigger view.' ),
		array( 'Is the online mirror free?', 'Yes, it is completely free with no sign-up and no app to install. It works in your browser.' ),
		array( 'Does the mirror record or save my video?', 'No. Nothing is recorded or sent anywhere. Only a picture you choose to save with Save photo is stored, and only on your own device.' ),
		array( 'Why does my mirror look different from my real mirror?', 'Cameras use wide-angle lenses that can stretch faces slightly when you are close. Hold the device at arm\'s length for a more natural look.' ),
		array( 'Can I zoom in on the mirror?', 'Yes. Use the Zoom slider to enlarge up to 3x. For fine detail, move closer and add light rather than zooming all the way.' ),
		array( 'Does it work with a webcam on a desktop?', 'Yes. Any webcam works. If you have more than one camera, pick the one you want from the list that appears after you start.' ),
	),
	'related'        => array( 'webcam-test', 'camera-test', 'mic-test', 'touch-screen-test', 'dead-pixel-test', 'speaker-cleaner' ),
	'updated'        => '2026-10-28',
);
