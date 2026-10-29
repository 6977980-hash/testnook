<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Zoom Test',
	'seo_title'      => 'Zoom Test: Check Camera, Mic and Speakers Before a Meeting',
	'description'    => 'Free Zoom test: check your camera, microphone, speakers and lighting before a Zoom meeting, hear a recording of your voice and fix problems. No sign-in needed.',
	'intro'          => 'Make sure you look and sound right before you join a Zoom call. This page checks your camera, microphone, speakers or headphones and your lighting in one go, and lets you hear a short recording of your own voice, without opening Zoom or joining a meeting.',
	'device'         => 'media',
	'device_message' => 'This browser cannot use a camera or microphone. Open the page in an up-to-date Chrome, Edge, Firefox or Safari.',
	'ads'            => 'standard',
	'styles'         => array( 'zoom-test' ),
	'scripts'        => array( 'zoom-test' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-bar">
	<button type="button" class="btn btn-primary" id="zt-start">Start camera and mic</button>
	<div class="btn-row zt-selects">
		<label class="visually-hidden" for="zt-cam">Camera</label><select id="zt-cam" class="zt-select" hidden></select>
		<label class="visually-hidden" for="zt-mic">Microphone</label><select id="zt-mic" class="zt-select" hidden></select>
		<label class="visually-hidden" for="zt-spk">Speaker</label><select id="zt-spk" class="zt-select" hidden></select>
	</div>
</div>
<div class="zt-grid">
	<div class="tool-stage zt-stage">
		<video id="zt-video" autoplay muted playsinline hidden></video>
		<div class="zt-empty" id="zt-empty"><p><strong>Your camera preview appears here.</strong></p><p>Press Start and allow the camera and microphone. Nothing is recorded or uploaded unless you press Record, and that recording stays on this page.</p></div>
	</div>
	<div class="zt-side">
		<h3>Microphone</h3>
		<div class="meter zt-meter" aria-hidden="true"><span id="zt-meter"></span></div>
		<button type="button" class="btn btn-sm" id="zt-rec" disabled>Record 5 s and play back</button>
		<audio id="zt-playback" controls hidden></audio>
		<h3>Speakers</h3>
		<button type="button" class="btn btn-sm" id="zt-chime">Play test sound</button>
		<div class="zt-heard" id="zt-heard" hidden>Did you hear the chime? <button type="button" class="btn btn-sm" data-zt-heard="1">Yes</button> <button type="button" class="btn btn-sm" data-zt-heard="0">No</button></div>
	</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Video</span><span class="stat-value" id="zt-res">-</span></div>
	<div class="stat"><span class="stat-label">Frame rate</span><span class="stat-value" id="zt-fps">-</span></div>
	<div class="stat"><span class="stat-label">Face light</span><span class="stat-value" id="zt-light">-</span></div>
	<div class="stat"><span class="stat-label">Mic level</span><span class="stat-value" id="zt-level">-</span></div>
</div>
<ul class="zt-checks" aria-live="polite">
	<li class="zt-check" id="zt-ck-cam"><b>Camera</b> <span>Not tested yet</span></li>
	<li class="zt-check" id="zt-ck-light"><b>Lighting</b> <span>Not tested yet</span></li>
	<li class="zt-check" id="zt-ck-mic"><b>Microphone</b> <span>Not tested yet</span></li>
	<li class="zt-check" id="zt-ck-spk"><b>Speakers</b> <span>Not tested yet</span></li>
</ul>
<p class="tool-status" id="zt-status" aria-live="polite">Close Zoom and other video apps first, so the camera is free.</p>',
	'howto'          => array(
		'Close Zoom, Teams, Meet and any other app that might be using the camera, so the browser can open it.',
		'Press <strong>Start camera and mic</strong> and allow both when the browser asks. If you have more than one camera or microphone, pick the one you will use in Zoom from the menus.',
		'Look at the preview: you should be centred, at eye level, with light on your face. The lighting check tells you if the picture is too dark or the window is behind you.',
		'Speak normally and watch the microphone bar move. Press <strong>Record 5 s and play back</strong> to hear how you sound.',
		'Press <strong>Play test sound</strong> and answer whether you heard the chime. When all four checks are green, you are ready to join.',
	),
	'howto_title'    => 'How to test your setup before a Zoom call',
	'results'        => '<p>The checklist turns green item by item:</p>
<ul>
<li><strong>Camera:</strong> the browser opened the camera and shows a picture. A resolution of 1280 x 720 or more is HD, which is what Zoom sends when HD video is enabled. A frame rate under about 15 fps looks choppy, usually because of low light or a busy computer.</li>
<li><strong>Lighting:</strong> the brightness of the centre of the picture, where your face usually is. Between about 25% and 85% is fine. A bright background with a dark centre means a window behind you.</li>
<li><strong>Microphone:</strong> the bar should jump to about half way when you talk at a normal volume. If it hits the end, you are clipping; if it barely moves, raise the input volume or move closer.</li>
<li><strong>Speakers:</strong> you heard the chime from the device you will use in the meeting.</li>
</ul>
<p>This page tests your devices, not your internet connection or Zoom itself. Zoom also offers its own test meeting at <a href="https://zoom.us/test" rel="noopener" target="_blank">zoom.us/test</a>.</p>',
	'extra'          => array(
		array(
			'Look and sound better on Zoom',
			'<p>Put the camera at eye level: stack the laptop on books so you are not looking down into it. Sit an arm\'s length away with your head and shoulders in the frame and a little space above your head. Face the main light source, such as a window or a lamp behind the screen, and avoid sitting with a window behind you. For sound, a headset or earphones with a mic beat a laptop microphone, because they stay close to your mouth and stop echo from your speakers. Turn off fans and close the door, and use Zoom\'s noise suppression setting if the room is noisy.</p>',
			'tips',
		),
		array(
			'Test each device in more detail',
			'<p>If one item fails, test it on its own: the <a href="/webcam-test/">webcam test</a> shows resolution and frame rate options and lets you take a snapshot, the <a href="/mic-test/">mic test</a> has a waveform, echo cancellation switches and longer recordings, and the <a href="/sound-test/">sound test</a> checks left and right speakers. The same checks work before Microsoft Teams, Google Meet, Skype or any other video call.</p>',
			'more-tests',
		),
	),
	'fixes'          => array(
		array( 'Camera is busy or shows a black picture', 'Close Zoom and every other app that may use the camera, including the Zoom desktop app running in the background (check the system tray or menu bar). Then press Restart. On laptops, check for a privacy shutter or a camera key (often F8 or F10) that turns the camera off.' ),
		array( 'Permission was blocked', 'Click the camera or lock icon in the address bar and allow the camera and microphone. On Windows, also check Settings > Privacy & security > Camera and Microphone; on a Mac, System Settings > Privacy & Security > Camera and Microphone, and allow your browser and Zoom.' ),
		array( 'Microphone works here but not in Zoom', 'In Zoom open Settings > Audio and choose the same microphone that worked here, then use Test Mic. Turn off "Automatically adjust microphone volume" if your voice keeps fading, and make sure you are not muted in the meeting (Alt + A on Windows, Cmd + Shift + A on a Mac).' ),
		array( 'Others hear an echo', 'Use headphones, or lower your speaker volume. Echo happens when your microphone picks up the meeting audio from your speakers. In Zoom, keep echo cancellation on under Settings > Audio.' ),
	),
	'faq'            => array(
		array( 'How do I test my camera and mic before a Zoom meeting?', 'Open this page, press Start camera and mic, and allow both. Check the preview and lighting, speak to see the mic level, record a 5 second sample and play the test sound. All four checks should be green.' ),
		array( 'Do I need a Zoom account for this test?', 'No. The test runs in your browser and does not connect to Zoom. You do not need to sign in or install anything.' ),
		array( 'Is my video recorded or uploaded?', 'No. The camera preview is shown only on your screen. The 5 second voice sample is kept in this page and is deleted when you close it.' ),
		array( 'Why does my camera work here but not in Zoom?', 'Zoom may be set to a different camera. In Zoom open Settings > Video and pick the camera that worked here. Also close the browser tab first, as only one app can use some cameras at a time.' ),
		array( 'Does this work for Teams and Google Meet too?', 'Yes. Camera, microphone, speakers and lighting matter the same way in every video call app, so this check works before any meeting.' ),
		array( 'Can I test on my phone?', 'Yes. Open the page in Chrome on Android or Safari on iPhone and allow the camera and microphone. The speaker picker is only available on computers.' ),
	),
	'disclaimer'     => 'Testnook is not affiliated with or endorsed by Zoom Video Communications. Zoom is a trademark of its owner and is used here only to describe what the test is for.',
	'related'        => array( 'webcam-test', 'mic-test', 'sound-test', 'camera-test', 'online-mirror', 'headphone-test', 'voice-recorder', 'speaker-cleaner' ),
	'updated'        => '2026-10-29',
);
