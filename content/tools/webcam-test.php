<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Webcam Test',
	'seo_title'      => 'Webcam Test: Check Your Camera Online (Free)',
	'description'    => 'Test your webcam online in one click. See a live preview with real resolution, frame rate and camera name, take a snapshot, and fix a webcam that does not work.',
	'intro'          => 'Check that your webcam works before a call or stream. Press start to see a live preview with the real resolution and frame rate your camera delivers.',
	'device'         => 'media',
	'device_message' => 'Your browser cannot access cameras. Open this page in an up-to-date Chrome, Edge, Firefox or Safari over HTTPS.',
	'ads'            => 'standard',
	'styles'         => array( 'webcam-test' ),
	'scripts'        => array( 'webcam-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="wc-start">Start camera</button>
		<button type="button" class="btn" id="wc-stop" disabled>Stop</button>
	</div>
	<div class="btn-row">
		<label class="visually-hidden" for="wc-device">Camera</label>
		<select id="wc-device" class="wc-select" hidden></select>
		<label class="visually-hidden" for="wc-res">Requested resolution</label>
		<select id="wc-res" class="wc-select">
			<option value="3840">Best (up to 4K)</option>
			<option value="1920" selected>1080p</option>
			<option value="1280">720p</option>
			<option value="640">480p</option>
		</select>
	</div>
</div>
<div class="tool-stage wc-stage" id="wc-stage">
	<video id="wc-video" playsinline muted autoplay hidden></video>
	<div class="wc-empty" id="wc-empty"><p><strong>Your camera is off.</strong></p><p>Press <em>Start camera</em> and allow access when your browser asks. Nothing is recorded or uploaded.</p></div>
	<img id="wc-shot" class="wc-shot" alt="Snapshot from your webcam" hidden>
</div>
<div class="btn-row wc-actions">
	<button type="button" class="btn btn-sm" id="wc-mirror" aria-pressed="true" disabled>Mirror</button>
	<button type="button" class="btn btn-sm" id="wc-snap" disabled>Take snapshot</button>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#tool">Full screen</button>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Resolution</span><span class="stat-value" id="wc-resv">-</span></div>
	<div class="stat"><span class="stat-label">Frame rate</span><span class="stat-value" id="wc-fps">-</span></div>
	<div class="stat"><span class="stat-label">Megapixels</span><span class="stat-value" id="wc-mp">-</span></div>
	<div class="stat"><span class="stat-label">Aspect ratio</span><span class="stat-value" id="wc-ar">-</span></div>
</div>
<p class="tool-status" id="wc-status" aria-live="polite"></p>',
	'howto'          => array(
		'Press <strong>Start camera</strong>. Your browser asks for permission: choose <strong>Allow</strong>.',
		'Look at the live preview. If you see yourself, your webcam works.',
		'If you have more than one camera, pick it from the camera list that appears. Use the resolution menu to ask for 4K, 1080p, 720p or 480p.',
		'Read the resolution and frame rate boxes. They show what your camera really sends, not what the box says.',
		'Use <strong>Take snapshot</strong> to save a still image, and <strong>Stop</strong> to turn the camera off when you are done.',
	),
	'howto_title'    => 'How to test your webcam',
	'results'        => '<p><strong>Resolution</strong> is the size of each video frame in pixels. 1280x720 is HD (720p), 1920x1080 is Full HD (1080p) and 3840x2160 is 4K. Most laptop webcams top out at 720p or 1080p. If you asked for 1080p and see 640x480, the camera, its driver or the USB port cannot deliver more.</p>
<p><strong>Frame rate</strong> is measured live from the frames your browser receives. 30 fps is normal and smooth for video calls; 24-29 fps is fine; under 15 fps looks choppy. Many webcams drop to 15 fps or lower in a dark room because they keep the shutter open longer, so try more light before blaming the camera.</p>
<p><strong>Megapixels</strong> and <strong>aspect ratio</strong> follow from the resolution. 16:9 is widescreen; 4:3 is the older, squarer format some cameras use at low resolutions.</p>',
	'extra'          => array(
		array(
			'Is this webcam test private?',
			'<p>Yes. The webcam test runs entirely in your browser. The video goes from your camera to your screen and nowhere else: it is not recorded, uploaded or stored. Snapshots are created on your device and only saved if you download them. You can check the camera icon in the address bar at any time to see or remove the permission.</p>',
			'privacy',
		),
		array(
			'Test your webcam for Zoom, Teams and Google Meet',
			'<p>If the camera works here, it works in the browser. If it still fails in a meeting app, the problem is usually that the app has picked the wrong camera or another app is holding the camera. Close other programs that use video (OBS, Zoom, Teams, Discord, Snapchat Camera), then choose the correct camera in the meeting app\'s video settings.</p>',
			'meetings',
		),
	),
	'fixes'          => array(
		array( 'Permission denied or blocked', 'Click the camera or lock icon at the left of the address bar, set Camera to Allow, then reload the page. On Windows also check Settings > Privacy & security > Camera and make sure "Let apps access your camera" and "Let desktop apps access your camera" are on. On a Mac open System Settings > Privacy & Security > Camera and enable your browser.' ),
		array( 'Camera is in use by another app', 'Only one program can use most webcams at a time. Quit Zoom, Teams, Skype, OBS and other video apps (check the system tray too), then press Start camera again.' ),
		array( 'Black screen or no camera found', 'Check for a privacy shutter or a camera key (often F8, F10 or a key with a camera icon) on laptops. For USB webcams try another port and avoid unpowered hubs. In Windows Device Manager, look under Cameras for a warning sign and update or reinstall the driver.' ),
		array( 'Image is dark, grainy or laggy', 'Add light in front of you, not behind you. Low light lowers the frame rate and adds noise. Clean the lens with a soft cloth, and pick a lower resolution if your computer struggles.' ),
	),
	'faq'            => array(
		array( 'How do I test my webcam online?', 'Open this page, press Start camera and allow access. If you see a live picture, your webcam works. The boxes below the video show its real resolution and frame rate.' ),
		array( 'Why does my webcam show a black screen?', 'Usually a closed privacy shutter, a camera turned off with a keyboard key, another app using the camera, or blocked permissions. Work through the fixes above in that order.' ),
		array( 'Is it safe to allow camera access on this site?', 'Yes. The video stays on your device and is never uploaded or recorded. Permission only lasts for this site, and you can remove it any time from the address bar.' ),
		array( 'What is a good webcam resolution and frame rate?', '1080p at 30 fps is a good standard for video calls and streaming. 720p at 30 fps is fine for most meetings. 60 fps matters mainly for streamers.' ),
		array( 'Why is my frame rate lower than 30 fps?', 'Most often because the room is dark, so the camera uses a longer exposure. A slow USB port, a busy computer or a high resolution can also reduce it.' ),
		array( 'Can I test my phone camera here?', 'Yes, the page works in mobile browsers and uses the front camera by default. Pick the back camera from the camera list, or use the <a href="/camera-test/">camera test</a>, which switches between front and back cameras with one button.' ),
	),
	'related'        => array( 'zoom-test', 'online-mirror', 'camera-test', 'mic-test', 'sound-test', 'headphone-test', 'speaker-cleaner' ),
	'updated'        => '2026-10-28',
);
