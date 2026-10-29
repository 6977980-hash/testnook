<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Torch Test',
	'seo_title'      => 'Torch Test: Check Your Phone Flashlight Online (Free)',
	'description'    => 'Free torch test for phones. Switch the flashlight LED on and off, run a strobe or SOS from the browser to check the flash works, with a screen light fallback.',
	'intro'          => 'Check your phone\'s flashlight from the browser. The test opens the back camera, finds the LED and lets you switch it on and off, strobe it at 1 to 10 flashes a second, or flash SOS. If your browser cannot control the torch, a bright white screen light is one tap away.',
	'device'         => 'touch',
	'device_message' => 'Laptop and desktop webcams have no flash LED. Open this page on your phone, or use the <a href="/white-screen/">white screen</a> as a light.',
	'ads'            => 'standard',
	'styles'         => array( 'torch-test' ),
	'scripts'        => array( 'torch-test' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-stage tt-stage">
	<div class="tt-top"><div class="tt-bulb" id="tt-bulb" aria-hidden="true"></div><video class="tt-video" id="tt-video" autoplay muted playsinline hidden></video>
		<div class="btn-row"><button type="button" class="btn btn-primary" id="tt-start">Start torch test</button><button type="button" class="btn" id="tt-screen">Screen light</button></div></div>
	<div class="tt-controls" id="tt-controls" hidden>
		<div class="btn-row"><button type="button" class="btn btn-primary" id="tt-on" aria-pressed="false">Turn torch on</button><button type="button" class="btn" id="tt-strobe" aria-pressed="false">Strobe</button><button type="button" class="btn" id="tt-sos" aria-pressed="false">SOS</button></div>
		<label class="tt-rate">Strobe speed <input type="range" id="tt-hz" min="1" max="10" step="1" value="3"><output id="tt-hzout" for="tt-hz">3 Hz</output></label>
	</div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Torch control</span><span class="stat-value" id="tt-support">Not checked</span></div>
		<div class="stat"><span class="stat-label">Torch</span><span class="stat-value" id="tt-state">Off</span></div>
		<div class="stat"><span class="stat-label">Camera</span><span class="stat-value" id="tt-cam">-</span></div>
	</div>
	<div class="tt-light" id="tt-light" hidden>Tap anywhere to close the screen light</div>
</div>
<p class="tool-status" id="tt-status" aria-live="polite">Tap "Start torch test" and allow the camera. The flash is controlled through the camera.</p>',
	'howto'          => array(
		'Open the page on your phone in Chrome, Samsung Internet or Edge, and tap <strong>Start torch test</strong>.',
		'Allow the camera when asked. The torch is part of the camera, so browsers need camera permission to switch it. Nothing is recorded.',
		'Tap <strong>Turn torch on</strong> and look at the LED next to the back camera. The yellow circle on the page shows what the phone has been told to do.',
		'Try <strong>Strobe</strong> at different speeds and <strong>SOS</strong> to check the LED switches cleanly. Tap again to stop.',
		'If torch control is not available, tap <strong>Screen light</strong> for a full white screen.',
	),
	'howto_title'    => 'How to test your phone\'s torch',
	'results'        => '<p>The status boxes show whether the browser can control the torch, what it has been told to do and which camera owns the LED.</p>
<ul>
<li><strong>Torch control: Supported, LED lights up:</strong> the flash works.</li>
<li><strong>Supported, but the LED stays dark:</strong> the phone accepted the command but the LED did not light. That points to a failed LED, a broken flex cable or, after a repair, a flash that was not reconnected.</li>
<li><strong>LED flickers or is dim:</strong> often a heat or battery limit. Phones dim the torch when hot or below about 15% battery. Let it cool, charge and try again.</li>
<li><strong>Not available:</strong> the browser cannot control the flash. This says nothing about the hardware. Test it from the phone\'s own torch shortcut instead.</li>
</ul>',
	'extra'          => array(
		array(
			'Which phones and browsers can control the torch',
			'<p>Websites switch the flash through the camera\'s "torch" setting. Chrome, Edge, Samsung Internet and Opera on Android support it on most phones. Firefox on Android does not. On iPhone, support depends on the iOS version and is limited, so if the page says "Not available" use the torch button in Control Centre to check the LED. Laptops and webcams have no flash, which is why the screen light is offered as a fallback.</p>
<p>Some phones put the LED on one specific back camera. The test tries each back camera until it finds the one with a torch, which is why the camera name may say "camera2 0" or "back camera 1".</p>',
			'support',
		),
		array(
			'If the flashlight does not work',
			'<p>First rule out software: restart the phone, close the camera and any app that uses the flash, and turn off power saving. If the torch tile in quick settings is greyed out, the camera service is stuck; a restart usually clears it. On Android, clearing the storage of the Camera app helps when the flash works in the torch but not in photos. If the LED never lights in this test, in the quick setting or in the camera, the LED or its cable has failed and needs a repair. Check the rest of the camera with the <a href="/camera-test/">camera test</a>.</p>',
			'not-working',
		),
	),
	'fixes'          => array(
		array( 'The torch says "Not available"', 'Your browser cannot control the flash. Open the page in Chrome on Android. On iPhone, test the LED from Control Centre instead.' ),
		array( 'Camera permission was blocked', 'Tap the lock or camera icon in the address bar, allow the camera for this site and reload. The camera picture is only shown to you.' ),
		array( 'The torch turns off by itself', 'Phones switch the torch off when they overheat or the battery is low, and browsers turn it off when you leave the page. Keep the page open and let the phone cool.' ),
		array( 'The flash works here but not in photos', 'The LED is fine. Clear the Camera app\'s cache or data, check the flash setting in the camera app, and update the phone.' ),
	),
	'faq'            => array(
		array( 'How do I test my phone flashlight online?', 'Open this page on the phone, tap Start torch test, allow the camera and tap Turn torch on. If the LED lights, the flashlight works.' ),
		array( 'Why does a torch test need the camera?', 'The flash LED belongs to the camera, and browsers only let a page switch it while it has the camera open. The picture is shown only to you and nothing is recorded or uploaded.' ),
		array( 'Does the torch test work on iPhone?', 'Often not, because Safari limits torch control. If it says Not available, use Control Centre to check the LED, or the screen light for light.' ),
		array( 'Can the strobe damage the LED?', 'No. A few seconds of strobe is far less than normal use. Phones also limit the LED automatically when it gets hot.' ),
		array( 'How fast can the strobe go?', 'Up to 10 flashes per second. Each change has to go through the camera system, so some phones cannot keep up above 4 or 5.' ),
		array( 'Is the SOS pattern real Morse code?', 'Yes: three short flashes, three long, three short, then a pause, repeated until you stop it.' ),
	),
	'related'        => array( 'camera-test', 'vibration-test', 'white-screen', 'webcam-test', 'what-phone-do-i-have', 'touch-screen-test' ),
	'updated'        => '2026-10-29',
);
