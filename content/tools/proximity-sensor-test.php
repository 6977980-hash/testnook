<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Proximity Sensor Test',
	'seo_title'      => 'Proximity Sensor Test: Check Your Phone\'s Call Sensor',
	'description'    => 'Test your phone\'s proximity sensor in two minutes: a guided call test with a verdict, a live reading where browsers allow it and hidden Android test codes.',
	'intro'          => 'The proximity sensor turns the screen off when the phone is at your ear, so your cheek does not hang up the call. If the screen stays on during calls, or goes black and will not come back, this two minute test finds out whether the sensor, a screen protector or a setting is to blame.',
	'device'         => 'touch',
	'device_message' => 'The proximity sensor is a phone part. Open this page on the phone you want to test.',
	'ads'            => 'standard',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'proximity-sensor-test' ),
	'embed_height'   => 980,
	'tool'           => '<div class="tool-stage sn-stage">
	<p class="sn-label">Live reading</p>
	<div class="px-top"><div class="px-face" id="px-face" aria-hidden="true"></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Proximity API</span><span class="stat-value" id="px-api">Checking...</span></div>
		<div class="stat"><span class="stat-label">State</span><span class="stat-value" id="px-near">-</span></div>
		<div class="stat"><span class="stat-label">Distance</span><span class="stat-value" id="px-dist">-</span></div>
	</div></div>
	<div class="btn-row" style="margin-top:10px"><button type="button" class="btn" id="px-read" hidden>Read proximity sensor</button></div>
	<p class="sn-label">Call test</p>
	<ol class="sn-steps" id="px-steps">
		<li data-step="call"><div><strong>Call your voicemail or a friend</strong> and hold the phone to your ear (or cover the top edge by the earpiece with your hand). Does the screen turn off?<div class="btn-row"><button type="button" class="btn btn-sm" data-pass>Screen turned off</button><button type="button" class="btn btn-sm" data-fail>Stayed on</button></div></div></li>
		<li data-step="back"><div><strong>Move the phone away from your ear.</strong> Does the screen come back on within a second?<div class="btn-row"><button type="button" class="btn btn-sm" data-pass>It came back</button><button type="button" class="btn btn-sm" data-fail>Stayed black</button></div></div></li>
		<li data-step="clean"><div><strong>Clean and uncover:</strong> wipe the top of the screen and remove any screen protector or case lip near the earpiece. Done?<div class="btn-row"><button type="button" class="btn btn-sm" data-pass>Done</button><button type="button" class="btn btn-sm" data-fail>Cannot remove it</button></div></div></li>
	</ol>
	<div class="sn-result" id="px-verdict" hidden></div>
</div>
<p class="tool-status" id="px-status" aria-live="polite">Most browsers do not expose the proximity sensor, so the call test is the reliable check.</p>',
	'howto'          => array(
		'Open this page on the phone. If <strong>Proximity API</strong> says Available, tap <strong>Read proximity sensor</strong> and cover the top of the phone: the state should switch to Near.',
		'For the call test, ring your voicemail or a friend and put the phone to your ear. Pull it away now and then to see whether the screen went off.',
		'Answer each step. If the screen misbehaves, clean the top of the screen, remove the protector and repeat.',
		'Read the verdict. If it still fails, try the hidden test menu codes below or see the fixes.',
	),
	'howto_title'    => 'How to test the proximity sensor',
	'results'        => '<p>A working proximity sensor turns the screen off within about half a second when something is 3 to 5 cm from the earpiece, and turns it back on as soon as it moves away. It only works during calls and a few other moments (pocket mode on some Android phones), so the screen staying on outside a call is normal.</p>
<ul>
<li><strong>Screen stays on during calls:</strong> the sensor does not see your ear. A screen protector, dirt or a case lip is the most common cause; a failed sensor or one lost in a screen repair is next.</li>
<li><strong>Screen goes black and stays black:</strong> the sensor always sees something near. A dark or cracked protector, dirt in the sensor window or a bad calibration causes this.</li>
<li><strong>Works with the hand, not with the ear:</strong> dark hair or skin reflects less infrared, and some phones need the ear close to the earpiece. A slight change in how you hold the phone helps; recalibration helps more.</li>
</ul>
<p>Browsers hide the sensor from websites, so the live reading usually says "Not exposed". That is not a fault in the phone.</p>',
	'extra'          => array(
		array(
			'Hidden test menus',
			'<p>Many Android phones have a hardware test menu that shows the proximity sensor directly. Open the Phone app and dial the code. These work only on the brands listed and can change between models and updates.</p>
<div class="table-scroll sn-codes"><table>
<thead><tr><th>Phone</th><th>Code or path</th><th>What to look for</th></tr></thead>
<tbody>
<tr><td>Samsung Galaxy</td><td><code>*#0*#</code>, then Sensor</td><td>Proximity turns the screen green and vibrates when covered</td></tr>
<tr><td>Xiaomi, Redmi, POCO</td><td><code>*#*#6484#*#*</code> (CIT menu)</td><td>Proximity sensor test with near and far values</td></tr>
<tr><td>Google Pixel</td><td>No public code</td><td>Use the call test</td></tr>
<tr><td>iPhone</td><td>No code</td><td>Use the call test</td></tr>
</tbody></table></div>',
			'codes',
		),
		array(
			'How the sensor works',
			'<p>Most phones use an infrared LED and a detector behind a small window near the earpiece. The LED sends invisible light out; when your ear is close, more of it bounces back and the phone switches the screen off. Newer phones with very thin bezels place it under the display, or use an "ultrasonic" or software sensor that combines the earpiece, the microphones and the touch screen. Those can be less reliable and are more sensitive to screen protectors. The ambient light sensor usually sits next to it: test that with the <a href="/light-sensor-test/">light sensor test</a>, and read <a href="/proximity-sensor-not-working/">proximity sensor not working</a> for every fix.</p>',
			'how',
		),
	),
	'fixes'          => array(
		array( 'The screen stays on during calls', 'Remove the screen protector or test with it peeled back at the top, and clean the area above the display. Restart the phone. On some Android phones, check Settings for "Pocket mode", "Prevent accidental touches" or a proximity setting in the Phone app\'s call settings.' ),
		array( 'The screen goes black and will not come back', 'Press the power button twice to wake the screen, or put the call on speaker. Then clean the sensor window and remove dark or tinted protectors, which absorb infrared. A crack over the sensor also causes it.' ),
		array( 'It stopped after a screen replacement', 'The sensor bracket or the small rubber gasket around it may be missing, or the new screen may lack the infrared window. Ask the repair shop to check the proximity sensor; many need a recalibration after a new screen.' ),
		array( 'Can I recalibrate the sensor?', 'Some phones recalibrate in the hidden test menu or reset it with a restart. Others need the maker\'s service tools. If the call test fails with a clean screen and no protector, a repair is the reliable fix.' ),
	),
	'faq'            => array(
		array( 'How do I test my proximity sensor?', 'Make a call, hold the phone to your ear or cover the top edge with your hand, and check that the screen turns off; then move it away and check the screen comes back. The steps on this page give a verdict.' ),
		array( 'Why does the live reading say "Not exposed"?', 'Browsers removed the proximity events years ago for privacy and battery reasons, and only a few test builds expose the newer sensor API. Your phone still has the sensor, and the call test checks it.' ),
		array( 'Can a screen protector block the proximity sensor?', 'Yes, it is the most common cause. Thick, dark or privacy protectors and those with a dust cut-out in the wrong place block the infrared light. Peel the top back and test again.' ),
		array( 'Where is the proximity sensor on my phone?', 'Near the earpiece at the top of the front, often beside the front camera. On thin-bezel phones it sits under the screen and is not visible.' ),
		array( 'Does the proximity sensor test work on iPhone?', 'Yes, the call test works on any phone. iPhones have no hidden test menu, so if the call test fails after cleaning and removing the protector, Apple or a repair shop can run diagnostics.' ),
		array( 'Is it the same as the light sensor?', 'No, though they often share a module. The light sensor sets the screen brightness; the proximity sensor detects your ear. A screen repair can break either.' ),
	),
	'related'        => array( 'light-sensor-test', 'touch-screen-test', 'phone-sensor-test', 'speaker-cleaner', 'what-phone-do-i-have', 'vibration-test' ),
	'updated'        => '2026-10-29',
);
