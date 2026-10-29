<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Vibration Test',
	'seo_title'      => 'Vibration Test: Check Your Phone Vibration Motor Online',
	'description'    => 'Free phone vibration test. Play short, long, pulse, heartbeat, SOS and weak-to-strong patterns to check your vibration motor works, right in the browser.',
	'intro'          => 'Check that your phone\'s vibration motor works without installing an app. Tap a pattern and the phone buzzes while the icon shakes and a timeline shows the pattern. Short, long, pulse, heartbeat, SOS, simulated weak and strong levels, a 10 second hold and a custom length.',
	'device'         => 'touch',
	'device_message' => 'Laptops and desktop computers have no vibration motor. Open this page on your phone to test it; on a gamepad, use the rumble test in the <a href="/gamepad-tester/">gamepad tester</a>.',
	'ads'            => 'content',
	'styles'         => array( 'vibration-test' ),
	'scripts'        => array( 'vibration-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-stage vb-stage">
	<div class="vb-top"><div class="vb-phone" id="vb-phone" aria-hidden="true"></div><div class="vb-line" id="vb-line" aria-hidden="true"></div></div>
	<div class="btn-row vb-ios-row"><button type="button" class="btn btn-primary" id="vb-ios" hidden>iPhone haptic tick</button></div>
	<p class="vb-label">Patterns</p>
	<div class="vb-grid">
		<button type="button" class="btn" data-vb="short" aria-pressed="false">Short</button>
		<button type="button" class="btn" data-vb="long" aria-pressed="false">Long</button>
		<button type="button" class="btn" data-vb="double" aria-pressed="false">Double tap</button>
		<button type="button" class="btn" data-vb="pulse" aria-pressed="false">Pulse</button>
		<button type="button" class="btn" data-vb="heartbeat" aria-pressed="false">Heartbeat</button>
		<button type="button" class="btn" data-vb="sos" aria-pressed="false">SOS</button>
	</div>
	<p class="vb-label">Strength</p>
	<div class="vb-grid">
		<button type="button" class="btn" data-vb="weak" aria-pressed="false">Weak</button>
		<button type="button" class="btn" data-vb="medium" aria-pressed="false">Medium</button>
		<button type="button" class="btn" data-vb="strong" aria-pressed="false">Strong</button>
		<button type="button" class="btn" data-vb="ramp" aria-pressed="false">Weak to strong</button>
		<button type="button" class="btn" data-vb="hold" aria-pressed="false">Hold 10 s</button>
		<button type="button" class="btn btn-primary" id="vb-stop">Stop</button>
	</div>
	<p class="vb-label">Custom length</p>
	<div class="vb-custom"><input type="range" id="vb-len" min="50" max="3000" step="50" value="500" aria-label="Vibration length in milliseconds"><output id="vb-lenout" for="vb-len">500 ms</output><button type="button" class="btn" id="vb-custom">Buzz</button></div>
	<div class="vb-ask" id="vb-ask" hidden><strong>Did you feel it?</strong><button type="button" class="btn btn-sm" id="vb-yes">Yes</button><button type="button" class="btn btn-sm" id="vb-no">No</button></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Vibration API</span><span class="stat-value" id="vb-support">Checking...</span></div>
		<div class="stat"><span class="stat-label">Last pattern</span><span class="stat-value" id="vb-lastlen">-</span></div>
	</div>
</div>
<p class="tool-status" id="vb-status" aria-live="polite">Open this page on your phone and tap a pattern.</p>',
	'howto'          => array(
		'Open the page on your phone in Chrome, Samsung Internet, Edge or Firefox. Turn off silent mode limits and battery saver, which can block vibration.',
		'Tap <strong>Short</strong> or <strong>Long</strong>. You should feel the buzz while the phone icon shakes and the timeline fills.',
		'Try <strong>Weak</strong>, <strong>Medium</strong> and <strong>Weak to strong</strong>. A healthy motor is felt even with the weak pulses.',
		'Use <strong>Hold 10 s</strong> to listen for rattling or a motor that fades, and answer <strong>Did you feel it?</strong> for advice.',
		'On iPhone, tap <strong>iPhone haptic tick</strong>, since Safari cannot play vibration patterns.',
	),
	'howto_title'    => 'How to test your phone\'s vibration',
	'results'        => '<p>A working vibration motor gives a crisp buzz that starts and stops with the timeline. Here is how to read what you feel:</p>
<ul>
<li><strong>Buzz on every pattern:</strong> the motor is fine.</li>
<li><strong>Long works, weak does nothing:</strong> usually normal. Weak is simulated with very short pulses, and the coin-type motors in many budget phones need a moment to spin up. On phones with a linear motor (most flagships), weak should still be felt.</li>
<li><strong>Buzz with a rattle or a grinding sound:</strong> the motor or its bracket is loose, often after a drop or a repair.</li>
<li><strong>Buzz that fades during the 10 second hold:</strong> a worn motor or a weak battery connection.</li>
<li><strong>Nothing at all, but the status says it played:</strong> vibration is switched off in settings, the phone is in a mode that blocks it, or the motor has failed. Try a system vibration such as the keyboard or a call to tell the two apart.</li>
</ul>',
	'extra'          => array(
		array(
			'Why iPhones cannot run vibration patterns',
			'<p>Websites vibrate a phone with the Vibration API, which Chrome, Edge, Samsung Internet and Firefox support on Android. Apple has never added it to Safari, and every iPhone browser uses Safari\'s engine, so no website can play a pattern on an iPhone. Since iOS 18, Safari does give a light haptic tick when a switch control is tapped, which is what the iPhone button uses. To test an iPhone motor fully, flip the ring/silent switch or Action button, or go to Settings > Sounds & Haptics and tap a ringtone with haptics on.</p>',
			'iphone',
		),
		array(
			'Weak, medium and strong: how strength works',
			'<p>The Vibration API can only turn the motor on and off for a number of milliseconds; it has no strength setting. This page simulates lower strength by switching the motor on and off very quickly: 12 ms on and 38 ms off feels weak, 30 on and 20 off feels medium, and continuous feels strong. The phone\'s own vibration intensity setting also scales every buzz, so if everything feels faint, raise it in Settings > Sound and vibration > Vibration intensity.</p>',
			'strength',
		),
	),
	'fixes'          => array(
		array( 'Nothing happens on Android', 'Open Settings > Sound and vibration and check that vibration is on and its intensity is not zero. Turn off Do Not Disturb and power saving modes, which often stop vibration. Then tap a pattern again: browsers only vibrate after a tap on the page.' ),
		array( 'It vibrates for calls but not here', 'The browser may not support vibration, or a setting blocks it for websites. Try Chrome. Some phones also block vibration in the browser while the screen is mirrored or in a car mode.' ),
		array( 'The vibration is weak or rattles', 'A loose motor rattles; a failing one buzzes weakly or only when the phone is tapped. Restart the phone to rule out software. If it persists, the motor is a cheap part that a repair shop can replace.' ),
		array( 'The motor stopped working after water damage', 'Turn the phone off and let it dry fully before testing again. Corrosion on the motor contacts is common after water and needs a repair.' ),
	),
	'faq'            => array(
		array( 'How do I test my phone\'s vibration?', 'Open this page on the phone and tap a pattern. If you feel the buzz while the icon shakes, the motor works. Try the weak pattern and the 10 second hold for a fuller check.' ),
		array( 'Does the vibration test work on iPhone?', 'Only partly. iPhone browsers do not support vibration patterns, but on iOS 18 or later the iPhone haptic tick button gives a light tap. For a full check use Settings > Sounds & Haptics.' ),
		array( 'Can the vibration test damage my phone?', 'No. It uses the same motor as notifications and calls, for a few seconds at most. The 10 second hold is shorter than a ringing phone.' ),
		array( 'Why is there no strength slider?', 'Browsers can only switch the motor on and off. The weak and medium buttons simulate strength with fast pulses; the real intensity is set in the phone\'s settings.' ),
		array( 'Can I test a controller\'s vibration here?', 'This page is for phones. Controller rumble is tested in the <a href="/gamepad-tester/">gamepad tester</a>.' ),
		array( 'Why does vibration stop when I switch apps?', 'Browsers stop vibrating when the page is hidden, to save battery. Keep the page open while the pattern plays.' ),
	),
	'related'        => array( 'touch-screen-test', 'speaker-cleaner', 'torch-test', 'phone-sensor-test', 'what-phone-do-i-have', 'camera-test' ),
	'updated'        => '2026-10-29',
);
