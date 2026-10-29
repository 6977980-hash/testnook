<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'What Phone Do I Have?',
	'seo_title'      => 'What Phone Do I Have? Find Your Phone Model Online',
	'description'    => 'Find out what phone you have from the browser: make, model and model code on Android, likely iPhone models from your screen size, and where to check it.',
	'intro'          => 'Open this page on the phone you want to identify. On Android it reads the model your browser shares and turns Samsung codes into names; on iPhone, where Apple hides the model, it narrows it down from the screen size. It also shows where to find the exact model in settings.',
	'device'         => 'touch',
	'device_message' => 'You seem to be on a computer. Open this page on the phone you want to identify: type testnook.com/what-phone-do-i-have into its browser.',
	'ads'            => 'standard',
	'styles'         => array( 'device-info' ),
	'scripts'        => array( 'device-info' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-stage di-stage">
	<div class="di-hero"><small>Your phone</small><strong id="di-phone">Checking...</strong><span id="di-phone-note">This needs JavaScript.</span></div>
	<ul class="di-cands" id="di-candidates" hidden></ul>
	<div class="stats">
		<div class="stat"><span class="stat-label">System</span><span class="stat-value" data-di="os">-</span></div>
		<div class="stat"><span class="stat-label">Model code</span><span class="stat-value" data-di="model">-</span></div>
		<div class="stat"><span class="stat-label">Screen</span><span class="stat-value" data-di="screen">-</span></div>
		<div class="stat"><span class="stat-label">Browser</span><span class="stat-value" data-di="browser">-</span></div>
	</div>
</div>
<div class="btn-row"><button type="button" class="btn" id="di-copy">Copy all details</button><a class="btn" href="/device-info/">Full device info</a></div>
<p class="tool-status" id="di-status" aria-live="polite">Reading your phone...</p>',
	'howto'          => array(
		'Open this page in the browser of the phone you want to identify. Chrome gives the most detail on Android.',
		'Read the name at the top. On Android it is the model your phone reports; on iPhone it is the list of models with your exact screen.',
		'Confirm it in settings: <strong>Settings > About phone</strong> on Android, or <strong>Settings > General > About > Model Name</strong> on iPhone.',
		'Use the model code (for example SM-S918B) when you order a case, screen protector or replacement part, because it identifies the exact version.',
	),
	'howto_title'    => 'How to find out what phone you have',
	'results'        => '<p>What the page can find depends on the phone and the browser:</p>
<ul>
<li><strong>Samsung in Chrome or Samsung Internet:</strong> the model code, such as SM-S918B, and the name, here Galaxy S23 Ultra. The letters after the number show the version: B is the international model, U and U1 are US models, and other letters are other regions.</li>
<li><strong>Pixel, Xiaomi, OnePlus, Motorola and others in Chrome:</strong> the model your phone reports. Pixels report their name; many other brands report a code, which you can search with the brand name.</li>
<li><strong>iPhone:</strong> Apple does not let any website read the model. The page matches your screen size and pixel density against every iPhone since the 5s and lists the ones that fit. Phones with the same screen, such as the iPhone 15 and 15 Pro, cannot be told apart this way.</li>
<li><strong>Firefox and some other browsers on Android:</strong> they hide the model completely, so the page can only say it is an Android phone.</li>
</ul>',
	'extra'          => array(
		array(
			'Find your phone model in settings',
			'<p><strong>iPhone:</strong> Settings > General > About shows the Model Name, such as iPhone 15 Pro. Tap the Model Number to switch between the part number (starting with M or N) and the A number (such as A3102), which identifies the exact regional version.</p>
<p><strong>Samsung:</strong> Settings > About phone shows the model name and the model number (SM-...). <strong>Pixel:</strong> Settings > About phone > Model. <strong>Xiaomi, Redmi, POCO:</strong> Settings > About phone, then All specs. <strong>OnePlus, Oppo, Realme:</strong> Settings > About device.</p>
<p>Without turning the phone on, look for the model on the original box, on the SIM tray of some older phones, or dial *#06# to see the IMEI, which a carrier or an IMEI checker can turn into the exact model.</p>',
			'settings',
		),
		array(
			'Checking a used phone',
			'<p>When buying second hand, compare the model shown here and in settings with the advert. A mismatch can mean a fake or a phone with replaced parts. Then run the <a href="/touch-screen-test/">touch screen test</a>, the <a href="/dead-pixel-test/">dead pixel test</a>, the <a href="/vibration-test/">vibration test</a> and the <a href="/camera-test/">camera test</a>, and play something through the speaker. The full set is on the <a href="/phone/">phone tests</a> page.</p>',
			'used',
		),
	),
	'fixes'          => array(
		array( 'It only says "An Android phone"', 'Your browser hides the model. Open the page in Chrome, which shares it through Client Hints, or read the model in Settings > About phone.' ),
		array( 'My iPhone is not in the list', 'Zoomed display mode (Settings > Display & Brightness > Display Zoom) makes the screen look like a smaller iPhone. Switch it to Default and reload, or check Settings > General > About.' ),
		array( 'The name looks wrong', 'Some phones report a code shared by several regional versions, and resellers sometimes flash other firmware. Trust Settings > About phone and the IMEI over what the browser reports.' ),
	),
	'faq'            => array(
		array( 'How do I know what phone I have?', 'Open this page on the phone, or go to Settings > About phone on Android, or Settings > General > About on iPhone, where the model name is listed.' ),
		array( 'Why can\'t the page tell my exact iPhone model?', 'Apple blocks websites from reading the model for privacy. Several iPhones share the same screen size, so the page can only list the models that match.' ),
		array( 'What is a model number?', 'The code a manufacturer gives each version of a phone, such as SM-A556B for a Galaxy A55. It tells you the exact variant, which matters for cases, parts and software updates.' ),
		array( 'How can I find my phone model without settings?', 'Check the box or receipt, dial *#06# for the IMEI and look it up, or open this page in the phone\'s browser.' ),
		array( 'Is this page safe to use?', 'Yes. It only reads what the browser shares with every website. Nothing is sent to a server or saved.' ),
		array( 'Does it work on tablets?', 'Yes. Android tablets report their model the same way as phones. iPads hide the model, so the page only says it is an iPad.' ),
	),
	'related'        => array( 'device-info', 'what-is-my-user-agent', 'touch-screen-test', 'vibration-test', 'camera-test', 'dead-pixel-test' ),
	'updated'        => '2026-10-29',
);
