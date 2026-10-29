<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Light Sensor Test',
	'seo_title'      => 'Light Sensor Test: Check Auto-Brightness on Your Phone',
	'description'    => 'Test your phone\'s ambient light sensor and auto-brightness. Read lux where the browser allows it, use the camera light meter and run a quick pass or fail check.',
	'intro'          => 'Find out whether your phone\'s ambient light sensor and auto-brightness work. The page reads the sensor in lux where the browser exposes it, offers a camera light meter that reacts to light like the sensor should, and walks you through a 30 second auto-brightness check with a clear verdict.',
	'device'         => 'touch',
	'device_message' => 'The ambient light sensor is built into phones and tablets (and some laptops). Open this page on your phone for the auto-brightness check.',
	'ads'            => 'standard',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'light-sensor-test' ),
	'embed_height'   => 1100,
	'tool'           => '<div class="tool-stage sn-stage">
	<p class="sn-label">1. Light sensor reading</p>
	<div class="stats">
		<div class="stat"><span class="stat-label">Light sensor API</span><span class="stat-value" id="lt-api">Checking...</span></div>
		<div class="stat"><span class="stat-label">Illuminance</span><span class="stat-value" id="lt-lux">-</span></div>
	</div>
	<div class="btn-row" style="margin-top:10px"><button type="button" class="btn" id="lt-luxstart" hidden>Read light sensor</button></div>
	<p class="sn-label">2. Camera light meter</p>
	<div class="btn-row"><button type="button" class="btn btn-primary" id="lt-cam">Start camera light meter</button><video class="lt-video" id="lt-video" muted playsinline hidden></video></div>
	<div class="lt-meter" aria-hidden="true"><span id="lt-meter"></span></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Camera brightness</span><span class="stat-value" id="lt-bright">-</span></div>
		<div class="stat"><span class="stat-label">Light index</span><span class="stat-value" id="lt-index">-</span></div>
		<div class="stat"><span class="stat-label">Exposure</span><span class="stat-value" id="lt-exp">-</span></div>
		<div class="stat"><span class="stat-label">Lowest</span><span class="stat-value" id="lt-min">-</span></div>
		<div class="stat"><span class="stat-label">Highest</span><span class="stat-value" id="lt-max">-</span></div>
	</div>
	<canvas class="sn-graph" id="lt-graph" aria-label="Light level graph" style="margin-top:10px"></canvas>
	<p class="sn-label">3. Auto-brightness check</p>
	<ol class="sn-steps" id="lt-steps">
		<li data-step="on"><div><strong>Turn auto-brightness on.</strong> Android: Settings &gt; Display &gt; Adaptive brightness. iPhone: Settings &gt; Accessibility &gt; Display &amp; Text Size &gt; Auto-Brightness. Is it on now?<div class="btn-row"><button type="button" class="btn btn-sm" data-pass>Yes</button><button type="button" class="btn btn-sm" data-fail>It was off</button></div></div></li>
		<li data-step="dim"><div><strong>Cover the top of the phone</strong> beside the front camera with your palm for 5 seconds, indoors. Does the screen dim?<div class="btn-row"><button type="button" class="btn btn-sm" data-pass>It dimmed</button><button type="button" class="btn btn-sm" data-fail>No change</button></div></div></li>
		<li data-step="bright"><div><strong>Shine a lamp or torch</strong> on the same spot, or step into daylight, for 5 seconds. Does the screen get brighter?<div class="btn-row"><button type="button" class="btn btn-sm" data-pass>It brightened</button><button type="button" class="btn btn-sm" data-fail>No change</button></div></div></li>
	</ol>
	<div class="sn-result" id="lt-verdict" hidden></div>
</div>
<p class="tool-status" id="lt-status" aria-live="polite">Start with the camera light meter or go straight to the auto-brightness check.</p>',
	'howto'          => array(
		'Open this page on your phone. If <strong>Light sensor API</strong> says Available, tap <strong>Read light sensor</strong> to see the reading in lux.',
		'Otherwise tap <strong>Start camera light meter</strong> and allow the camera. Cover the front camera, then point it at a lamp; the brightness should drop to near 0% and rise high.',
		'Work through the <strong>auto-brightness check</strong>: turn auto-brightness on, cover the top of the phone, then shine a light on it, and answer each step.',
		'Read the verdict, then the fixes below if the screen did not follow the light.',
	),
	'howto_title'    => 'How to test the light sensor',
	'results'        => '<p>The ambient light sensor measures how much light falls on the front of the phone, in lux. The phone uses it to set the screen brightness and, on some models, the keyboard backlight and the colour tone of the display.</p>
<div class="table-scroll"><table>
<thead><tr><th>Lux</th><th>Typical place</th></tr></thead>
<tbody>
<tr><td>0 to 10</td><td>Dark room, or the sensor covered</td></tr>
<tr><td>50 to 200</td><td>Living room in the evening</td></tr>
<tr><td>300 to 500</td><td>Office lighting</td></tr>
<tr><td>1,000 to 10,000</td><td>Overcast day outdoors</td></tr>
<tr><td>30,000 to 100,000</td><td>Direct sunlight</td></tr>
</tbody></table></div>
<p>Most browsers do not let websites read the sensor directly, for privacy, so the lux reading usually shows "Not exposed". That does not mean the phone lacks the sensor. The camera light meter and the auto-brightness check test the same thing from the outside: if the screen dims when covered and brightens in strong light, the sensor works. The camera meter shows relative brightness, compensated for exposure on phones whose camera reports exposure time and ISO; it is not a calibrated lux meter.</p>',
	'extra'          => array(
		array(
			'Where the light sensor is',
			'<p>The sensor sits on the front of the phone, usually next to the front camera or the earpiece. On phones with a notch or a hole-punch camera it is often hidden under the display or in the notch, so a dark screen protector, a thick case lip or a dirty corner of the screen can block it. If auto-brightness reacts only when you cover a particular spot, that spot is the sensor.</p>',
			'where',
		),
		array(
			'Why auto-brightness seems wrong but the sensor is fine',
			'<p>Modern phones learn from you: every time you drag the brightness slider, adaptive brightness adjusts its curve. After a few corrections in a dark room it may stay dimmer than you expect elsewhere. Resetting the learned settings usually fixes it (on Pixel phones: Settings &gt; Apps &gt; Device Health Services &gt; Storage &amp; cache &gt; Clear storage &gt; Reset adaptive brightness; on other Android phones and iPhone, turn auto-brightness off and on again). More in <a href="/auto-brightness-not-working/">auto-brightness not working</a>.</p>',
			'learning',
		),
	),
	'fixes'          => array(
		array( 'The screen does not dim when covered', 'Check that auto-brightness is on, then clean the top of the screen and remove any screen protector or case that covers the sensor. Restart the phone. Some phones only adjust slowly; keep the sensor covered for 5 to 10 seconds.' ),
		array( 'Brightness jumps up and down', 'A flickering light, a hand near the top of the phone or a sensor half covered by a case causes jumps. Move the case and test again. On Android, resetting adaptive brightness clears a bad learned curve.' ),
		array( 'I want to see the raw sensor value', 'Samsung phones show it in the test menu: dial *#0*#, tap Sensor and look at the light sensor lux. Other Android phones show it in their hardware test menus or in sensor apps from the Play Store. iPhones do not show the raw value.' ),
		array( 'Auto-brightness stopped after a screen replacement', 'The sensor may be on a flex cable that has to be moved to the new screen, or covered by the new frame. Take it back to the repair shop and ask them to check the light and proximity sensor flex.' ),
	),
	'faq'            => array(
		array( 'How do I test my phone\'s light sensor?', 'Turn auto-brightness on, cover the top of the phone for 5 seconds and see if the screen dims, then shine a light on it and see if it brightens. The check on this page walks you through it and gives a verdict.' ),
		array( 'Why does it say the light sensor API is not exposed?', 'Most browsers keep the light sensor away from websites because it can leak information. Your phone still has the sensor; use the camera meter and the auto-brightness check instead.' ),
		array( 'Is the camera light meter accurate?', 'It shows how bright the scene looks to the camera. It reacts like a light sensor, which is enough to test, but it is not calibrated in lux, so do not use it for photography or workplace light measurements.' ),
		array( 'Does the light sensor test work on iPhone?', 'The camera meter and the auto-brightness check work in Safari. Safari does not expose the light sensor reading itself.' ),
		array( 'Is the light sensor the same as the proximity sensor?', 'They often sit together near the earpiece, but they do different jobs: the light sensor measures brightness, the proximity sensor detects your ear during calls. Test the second with the <a href="/proximity-sensor-test/">proximity sensor test</a>.' ),
		array( 'Is the camera image saved?', 'No. The page reads the average brightness of each frame in your browser. No image is stored or uploaded.' ),
	),
	'related'        => array( 'proximity-sensor-test', 'phone-sensor-test', 'torch-test', 'camera-test', 'dead-pixel-test', 'display-test' ),
	'updated'        => '2026-10-29',
);
