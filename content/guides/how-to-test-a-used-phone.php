<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Test a Used Phone Before Buying',
	'seo_title'   => 'How to Test a Used Phone Before Buying: 15-Minute Check',
	'description' => 'A 15-minute checklist for testing a used iPhone or Android before you pay: screen, touch, speakers, mic, cameras, battery health, locks, IMEI and repairs.',
	'blurb'       => 'A 15-minute checklist for any second-hand iPhone or Android before you hand over money.',
	'hub'         => 'phone',
	'tool'        => 'touch-screen-test',
	'tools'       => array( 'dead-pixel-test', 'burn-in-test', 'sound-test', 'mic-test', 'camera-test', 'vibration-test', 'torch-test', 'battery-health-test', 'what-phone-do-i-have' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A used phone can be a great deal or an expensive mistake. Most problems show up in a few minutes if you know where to look, and you can test nearly everything in the phone\'s browser. Here is the order to check things in, what each test reveals and the red flags that mean walk away.',
	'summary'     => array(
		'Check the <strong>paperwork and locks</strong> first: the phone must be signed out of iCloud or Google, not carrier locked (unless that suits you) and the IMEI must not be reported lost or stolen.',
		'Then test the <strong>screen</strong> (dead pixels, burn-in, touch dead zones), <strong>sound</strong> (speakers, earpiece, mic), <strong>cameras</strong>, <strong>buttons</strong>, vibration, flash and charging.',
		'Look at <strong>battery health</strong> in the settings. Under 80% means a battery replacement soon; factor it into the price.',
		'Walk away if the seller will not let you test, the phone is still locked to an account, or the model and IMEI in the settings do not match the box.',
	),
	'sections'    => array(
		array(
			'Before you meet: what to ask',
			'<ul>
<li><strong>The exact model and storage.</strong> "iPhone 13" or "Galaxy S22" is not enough; ask for the storage size and, for Android, the model number.</li>
<li><strong>The IMEI.</strong> Most honest sellers will share it. You can check it with the carrier or an IMEI blacklist service in your country before you travel.</li>
<li><strong>Repairs.</strong> Ask whether the screen, battery or back glass was ever replaced, and by whom.</li>
<li><strong>The box and receipt.</strong> Proof of purchase protects you if the phone turns out to be stolen and helps with any remaining warranty.</li>
</ul>
<p>Meet in a public place with Wi-Fi or bring your own SIM card and a charging cable, and give yourself 15 minutes. A seller who is in a hurry is a warning sign.</p>',
			'before',
		),
		array(
			'Locks, accounts and identity',
			'<ol>
<li><strong>Account lock.</strong> On an iPhone, go to Settings and check that no Apple ID is signed in, then make sure "Find My" is off. On Android, the phone should be signed out of Google, or be reset in front of you. A phone with Activation Lock or Google Factory Reset Protection is useless to you without the original account.</li>
<li><strong>Model and IMEI.</strong> Dial <code>*#06#</code> to show the IMEI and compare it with the box and the SIM tray. Check the model in Settings > About. The <a href="/what-phone-do-i-have/">what phone do I have</a> page confirms what the browser sees.</li>
<li><strong>Carrier lock.</strong> Put your SIM in and make a short call. If the phone asks for an unlock code, it is locked to another network.</li>
<li><strong>Software.</strong> Check that it can update to a recent version of iOS or Android. Phones that no longer get updates are worth much less.</li>
</ol>',
			'locks',
		),
		array(
			'Screen and touch',
			'<p>The screen is the most expensive part to replace, so test it carefully:</p>
<ol>
<li><strong>Look for cracks and lifting</strong> at an angle under light. A screen that sits raised at one edge can mean a swollen battery underneath, which is a serious red flag.</li>
<li><strong>Dead and stuck pixels.</strong> Open the <a href="/dead-pixel-test/">dead pixel test</a> full screen and step through the colours. Look for dots that stay black or one colour.</li>
<li><strong>Burn-in.</strong> On OLED phones (most recent iPhones and many Androids), open the <a href="/burn-in-test/">burn-in test</a> on a grey screen and look for ghost outlines of the keyboard or navigation bar.</li>
<li><strong>Touch.</strong> Run the <a href="/touch-screen-test/">touch screen test</a>, fill the grid with your finger and check every square lights up, especially the corners and edges. Then test multi-touch with several fingers.</li>
<li><strong>Brightness and True Tone.</strong> Slide brightness from min to max and check it changes smoothly. An iPhone that shows an "Unknown Part" message, or says it cannot verify a genuine Apple display, has had a screen fitted from another source.</li>
</ol>',
			'screen',
		),
		array(
			'Sound, cameras and sensors',
			'<ul>
<li><strong>Speakers:</strong> play the <a href="/sound-test/">sound test</a> at full volume. Listen for crackle and check both the bottom speaker and the earpiece work.</li>
<li><strong>Microphone:</strong> record a few seconds with the <a href="/mic-test/">mic test</a> and play it back. Also make a short call and ask the other side if they hear you clearly.</li>
<li><strong>Cameras:</strong> open the <a href="/camera-test/">camera test</a> and switch between front and back cameras. Then use the phone\'s own camera app: check every lens (wide, ultra-wide, zoom), autofocus, and that video records with sound. Look for dust or fog behind the lens glass.</li>
<li><strong>Flash and vibration:</strong> the <a href="/torch-test/">torch test</a> and the <a href="/vibration-test/">vibration test</a> check both in seconds.</li>
<li><strong>Face ID or fingerprint:</strong> set it up as a test. Failure often means past water damage or a bad repair.</li>
<li><strong>Buttons and ports:</strong> press every button, flip the silent switch, plug in a charger and a cable to check the port is firm and charging starts.</li>
<li><strong>Wi-Fi, Bluetooth and GPS:</strong> connect to Wi-Fi, pair headphones if you have them, and open a map to see the location settle.</li>
</ul>',
			'sound-camera',
		),
		array(
			'Battery health',
			'<p>On an iPhone, go to Settings > Battery > Battery Health (or Battery Health & Charging) and note the Maximum Capacity. On iPhone 15 and later, Settings > General > About also shows the cycle count. On many Android phones the closest equivalent is in Settings > Battery or the maker\'s device care app, and some show a battery health status.</p>
<div class="table-scroll"><table>
<thead><tr><th>Capacity</th><th>What it means for a buyer</th></tr></thead>
<tbody>
<tr><td>90 to 100%</td><td>Like new, or a fresh replacement battery</td></tr>
<tr><td>85 to 89%</td><td>Normal for a phone one to two years old</td></tr>
<tr><td>80 to 84%</td><td>Usable, but plan for a replacement soon</td></tr>
<tr><td>Under 80%</td><td>Needs a new battery; ask for the cost off the price</td></tr>
</tbody></table></div>
<p>The <a href="/battery-health-test/">battery health test</a> shows the level and charging state, and can measure drain while you test the phone. A battery that drops several percent in a 15-minute check, or a phone that gets hot while idle, is a bad sign. The guide on <a href="/battery-health-explained/">battery health explained</a> covers what the numbers mean in more detail.</p>',
			'battery',
		),
		array(
			'Red flags: when to walk away',
			'<ul>
<li>The phone is signed in to someone else\'s account and the seller cannot remove it.</li>
<li>The IMEI on the phone, the tray and the box do not match, or the IMEI is reported lost or stolen.</li>
<li>The screen lifts at an edge or the back bulges: a swollen battery.</li>
<li>Face ID or the fingerprint sensor does not work and the seller "never used it".</li>
<li>The seller will not let you test, or only lets you see it switched on for a minute.</li>
<li>The price is far below every other listing for the same model.</li>
</ul>
<p>Smaller issues such as a worn battery, scratches or a third-party screen are not deal breakers, but they lower what the phone is worth. Use what you find to agree a fair price.</p>',
			'red-flags',
		),
	),
	'faq'         => array(
		array( 'How do I check if a used phone is stolen?', 'Get the IMEI by dialling *#06# and check it with your carrier or a national IMEI blacklist service. Make sure it matches the box and the SIM tray.' ),
		array( 'What battery health is acceptable on a used iPhone?', '85% or more is good. 80 to 84% is usable but will need a new battery soon. Below 80% the price should cover a battery replacement.' ),
		array( 'Can I test a phone without a SIM card?', 'Mostly yes. Use Wi-Fi to run the browser tests. You need a SIM only to check calls, mobile data and whether the phone is carrier locked.' ),
		array( 'What is Activation Lock?', 'An iPhone security feature that ties the phone to the owner\'s Apple ID. If it is on, you cannot use the phone after a reset without the owner\'s password. Never buy a phone with it on.' ),
		array( 'How can I tell if the screen was replaced?', 'On recent iPhones, Settings > General > About shows parts and service history. On any phone, look for a raised edge, uneven gaps, poor colours or touch problems at the edges.' ),
		array( 'Should I factory reset a used phone after buying?', 'Yes. Reset it and set it up as new, so nothing from the previous owner is left and you know no account is still attached.' ),
	),
);
