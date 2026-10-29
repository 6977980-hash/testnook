<?php
defined( 'ABSPATH' ) || exit;

$cal = require __DIR__ . '/_screen-cal.php';

return array(
	'title'          => 'What Is My Screen Size',
	'seo_title'      => 'What Is My Screen Size? Measure It in Inches Online',
	'description'    => 'Find your screen size in inches. Match a bank card to measure the diagonal, width and height of a laptop, monitor or phone, or calculate it from the diagonal.',
	'intro'          => 'A browser knows how many pixels your screen has, but not how big it is. Hold a bank card against the screen and match it once, and the page measures your screen\'s diagonal, width and height in inches and centimeters. There is also a calculator for width and height from any diagonal and ratio.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'screen-cal', 'screen-info' ),
	'scripts'        => array( 'screen-cal', 'screen-info' ),
	'embed_height'   => 900,
	'tool'           => '<div class="tool-stage si-stage">
	<div class="si-hero"><small>Your screen size (diagonal)</small><strong id="sz-diag-out">-</strong><span><span data-si="size-cm">-</span> &middot; <span data-si="physical">-</span> pixels</span></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Width</span><span class="stat-value" data-si="size-w">-</span></div>
		<div class="stat"><span class="stat-label">Height</span><span class="stat-value" data-si="size-h">-</span></div>
		<div class="stat"><span class="stat-label">Aspect ratio</span><span class="stat-value" data-si="ratio">-</span></div>
		<div class="stat"><span class="stat-label">Pixel density</span><span class="stat-value" data-si="size-ppi">-</span></div>
	</div>
	<p class="si-note" id="sz-note"></p>
</div>
' . $cal( true ) . '
<h3 class="si-sub">Screen size calculator</h3>
<div class="si-form">
	<label>Diagonal (inches)<input type="number" id="sz-d" min="1" max="200" step="0.1" value="27" inputmode="decimal"></label>
	<label>Ratio width<input type="number" id="sz-rw" min="1" step="0.1" value="16" inputmode="decimal"></label>
	<label>Ratio height<input type="number" id="sz-rh" min="1" step="0.1" value="9" inputmode="decimal"></label>
</div>
<div class="si-presets"><button type="button" class="btn btn-sm" data-sz-ratio="16:9">16:9</button><button type="button" class="btn btn-sm" data-sz-ratio="16:10">16:10</button><button type="button" class="btn btn-sm" data-sz-ratio="3:2">3:2</button><button type="button" class="btn btn-sm" data-sz-ratio="4:3">4:3</button><button type="button" class="btn btn-sm" data-sz-ratio="21:9">21:9</button><button type="button" class="btn btn-sm" data-sz-ratio="19.5:9">19.5:9</button></div>
<dl class="si-out" id="sz-out"></dl>
<p class="tool-status" id="si-status" aria-live="polite">Calibrate with a card for a real measurement. Keep browser zoom at 100%.</p>',
	'howto'          => array(
		'Set the browser zoom to 100% (Ctrl+0, or Cmd+0 on a Mac).',
		'In <strong>Calibrate to your screen</strong>, hold a bank, ID or loyalty card flat against the screen. Drag the slider until the dashed box is exactly as wide as the card, then press <strong>Use this size</strong>. On a phone in portrait, match the card\'s short side.',
		'Read the diagonal at the top, with the width and height in inches and centimeters.',
		'To find the size of a screen you are not using, enter its diagonal and ratio in the <strong>Screen size calculator</strong>.',
	),
	'howto_title'    => 'How to measure your screen size',
	'results'        => '<p>Screen sizes are always the <strong>diagonal of the visible picture</strong>, from one corner to the opposite corner, without the bezel. Monitors and TVs are sold as 24", 27", 55" and so on; laptops as 13.3", 14", 15.6" or 16"; phones as about 6.1" to 6.9".</p>
<p>With a good card match the measurement is usually within 2-3% of the real size, enough to tell a 15.6 inch laptop from a 14 inch one. If the page says the screen is not calibrated, it is guessing from the web standard of 96 pixels per inch, which can be far off on laptops and phones.</p>
<p>Two other things to know: the browser measures the whole screen, so a notch or rounded corners on a phone are counted; and a few screens report a scaled size that is not quite exact, so if the result is a little off a common size (14.1" for a 14" laptop), it is that size.</p>',
	'extra'          => array(
		array(
			'Other ways to find your screen size',
			'<p><strong>Measure with a tape:</strong> from the bottom left corner of the picture to the top right, not including the frame, and divide centimeters by 2.54 for inches. <strong>Check the model:</strong> on Windows, Settings > System > About shows the model name, and a search for it gives the size; on a Mac, Apple menu > About This Mac shows the size in the model name (for example "MacBook Pro 14-inch"); on a monitor or TV, the model number usually contains the size, such as 27 in "S27..." or 55 in "...55...". <strong>Phones:</strong> the <a href="/what-phone-do-i-have/">what phone do I have</a> page names your model.</p>',
			'other-ways',
		),
		array(
			'Diagonal, width and height',
			'<p>For the same diagonal, a wider ratio gives a wider but shorter screen. A 27 inch 16:9 monitor is 59.8 x 33.6 cm; a 27 inch 16:10 one is 58.2 x 36.4 cm. That matters when comparing a 34 inch ultrawide (21:9, about 80 x 33 cm) with a 27 inch 16:9: the ultrawide is much wider but about the same height. The calculator above works out width, height and area for any diagonal and ratio, and the <a href="/aspect-ratio-calculator/">aspect ratio calculator</a> does the same for pixel sizes.</p>',
			'diagonal',
		),
	),
	'fixes'          => array(
		array( 'The size is clearly wrong', 'Reset the browser zoom to 100% and calibrate again, pressing the card flat against the glass. Make sure you used "Use this size" after moving the slider.' ),
		array( 'I have no card', 'Any card of standard size works: bank, ID, driving licence, library or loyalty card (85.60 x 53.98 mm). Or use a ruler and the fine tune buttons in the <a href="/online-ruler/">online ruler</a>, which shares the same calibration.' ),
		array( 'I have two monitors', 'The page measures the screen its window is on. Drag the window to the other monitor, then calibrate on that screen.' ),
	),
	'faq'            => array(
		array( 'How do I find out my screen size?', 'Calibrate this page with a bank card and it shows the diagonal in inches. You can also measure the picture diagonally with a tape or look up your model number.' ),
		array( 'Is screen size measured diagonally?', 'Yes. The size of every screen is the diagonal of the visible picture, corner to corner, in inches.' ),
		array( 'Can a website detect my screen size in inches?', 'No. Browsers report pixels, not physical size. That is why this page needs a card or ruler to measure it.' ),
		array( 'How wide is a 27 inch monitor?', 'A 27 inch 16:9 monitor is about 59.8 cm (23.5 in) wide and 33.6 cm (13.2 in) tall, not counting the frame.' ),
		array( 'Does the bezel count in screen size?', 'No. Only the visible picture is measured. The outside of a monitor or laptop is larger.' ),
		array( 'Is my calibration saved?', 'Yes, in this browser on this device only, and it is shared with the online ruler and the eye tests on this site.' ),
	),
	'related'        => array( 'screen-resolution', 'ppi-calculator', 'screen-ratio', 'online-ruler', 'aspect-ratio-calculator', 'device-info' ),
	'updated'        => '2026-10-29',
);
