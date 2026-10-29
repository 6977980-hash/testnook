<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Online Ruler',
	'seo_title'    => 'Online Ruler: Actual Size Ruler in cm, mm and Inches',
	'description'  => 'Free online ruler at actual size. Measure in centimeters, millimeters or inches on any screen, calibrate with a bank card or screen size, and drag to measure.',
	'intro'        => 'An actual-size ruler on your screen, in centimeters and inches. Calibrate it once with a bank card or your screen size and the marks match a real ruler. Drag along the ruler to measure anything you hold against the screen.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'online-ruler' ),
	'scripts'      => array( 'online-ruler' ),
	'embed_height' => 640,
	'tool'         => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Units">
		<button type="button" data-rl-unit="cm" aria-pressed="true">cm / mm</button>
		<button type="button" data-rl-unit="in" aria-pressed="false">inches</button>
	</div>
	<div class="btn-row">
		<button type="button" class="btn btn-sm" id="rl-flip">Vertical</button>
		<button type="button" class="btn btn-sm" data-tn-fullscreen="#rl-stage">Full screen</button>
	</div>
</div>
<div class="tool-stage rl-stage" id="rl-stage">
	<div class="rl-wrap" id="rl-wrap">
		<canvas class="rl-canvas" id="rl-canvas" aria-label="Ruler"></canvas>
		<div class="rl-measure" id="rl-measure" hidden><span class="rl-measure-label" id="rl-measure-label"></span></div>
	</div>
	<p class="rl-tip" id="rl-tip">Drag along the ruler to measure. Hold an object against the screen and read the length.</p>
</div>
<details class="rl-cal" id="rl-cal">
	<summary>Calibrate for exact size <span class="rl-cal-state" id="rl-cal-state">(not calibrated: using the browser\'s default 96 px per inch)</span></summary>
	<div class="rl-cal-body">
		<div class="rl-cal-opt">
			<h3>1. Bank card</h3>
			<p>Hold any bank card against the screen and drag the slider until the box is exactly as wide as the card (85.60 mm).</p>
			<div class="rl-card" id="rl-card"><span>Match a bank card</span></div>
			<input type="range" id="rl-card-slider" min="200" max="900" step="1" value="323" aria-label="Card width">
			<button type="button" class="btn btn-sm btn-primary" id="rl-card-apply">Use this size</button>
		</div>
		<div class="rl-cal-opt">
			<h3>2. Screen size</h3>
			<p>Enter your screen\'s diagonal in inches (from the box or spec sheet). The resolution is read from the browser.</p>
			<div class="rl-diag-row"><input type="number" id="rl-diag" min="3" max="100" step="0.1" placeholder="e.g. 15.6" inputmode="decimal"><span>inch</span><button type="button" class="btn btn-sm btn-primary" id="rl-diag-apply">Use screen size</button></div>
			<p class="rl-res" id="rl-res"></p>
		</div>
		<div class="rl-cal-opt">
			<h3>3. Fine tune</h3>
			<p>Hold a real ruler against the screen and adjust until the marks line up.</p>
			<div class="btn-row"><button type="button" class="btn btn-sm" data-rl-adj="-1">-1%</button><button type="button" class="btn btn-sm" data-rl-adj="-0.2">-0.2%</button><button type="button" class="btn btn-sm" data-rl-adj="0.2">+0.2%</button><button type="button" class="btn btn-sm" data-rl-adj="1">+1%</button><button type="button" class="btn btn-sm" id="rl-cal-reset">Reset</button></div>
		</div>
	</div>
</details>
<div class="stats">
	<div class="stat"><span class="stat-label">Pixels per inch</span><span class="stat-value" id="rl-ppi">96</span></div>
	<div class="stat"><span class="stat-label">Pixels per cm</span><span class="stat-value" id="rl-ppcm">37.8</span></div>
	<div class="stat"><span class="stat-label">Ruler length</span><span class="stat-value" id="rl-len">-</span></div>
	<div class="stat"><span class="stat-label">Measured</span><span class="stat-value" id="rl-val">-</span></div>
</div>
<p class="tool-status" id="rl-status" aria-live="polite">Calibrate once and the setting is remembered on this device.</p>',
	'howto'        => array(
		'Open <strong>Calibrate for exact size</strong> and pick a method: match a bank card to the box, type your screen\'s diagonal in inches, or hold a real ruler against the screen and fine tune.',
		'Choose <strong>cm / mm</strong> or <strong>inches</strong>. Press <strong>Vertical</strong> to turn the ruler for tall objects, or <strong>Full screen</strong> for the longest ruler.',
		'Hold the object against the screen at the zero mark and read its length from the ruler.',
		'Or <strong>drag</strong> along the ruler: the highlighted span shows the exact length between your start and end points.',
		'Your calibration is saved in this browser, so the ruler stays accurate next time.',
	),
	'howto_title'  => 'How to use the online ruler',
	'results'      => '<p>Without calibration, the ruler uses the web standard of <strong>96 pixels per inch</strong>, which most desktop monitors are close to but phones, laptops and 4K screens are not. After calibration the ruler knows your real <strong>pixels per inch</strong> and the marks match a physical ruler to within about half a millimeter.</p>
<p><strong>Ruler length</strong> is how much of a real ruler fits on your screen at the current size; a 24 inch monitor shows about 50 cm in full screen, a phone around 6-7 cm in portrait. <strong>Measured</strong> is the length of your last drag.</p>
<p>Accuracy depends on your calibration. A bank card is the easiest reference: every card is 85.60 mm by 53.98 mm. If you have a real ruler, the fine tune buttons get the last fraction of a percent.</p>',
	'extra'        => array(
		array(
			'Why screen rulers need calibration',
			'<p>A web page measures everything in CSS pixels, and the browser assumes 96 of them make an inch. Real screens have anywhere from 90 to 500 physical pixels per inch, and operating systems scale pages by 125%, 150%, 200% or odd amounts, so "1 inch" on a page is rarely 1 inch of glass. The browser does not know the physical size of your screen, which is why every online ruler needs a reference object or your screen size to be exact.</p>
<p>The screen size method uses your diagonal and the screen resolution reported by the browser to calculate pixels per inch. It is accurate when the browser is at 100% zoom and the display scaling is a standard value. The bank card method works everywhere, because you match the real object directly. Keep browser zoom at 100% (Ctrl+0) after calibrating, or the ruler will be off by the zoom factor.</p>',
			'calibration',
		),
		array(
			'Common sizes to check against',
			'<p>Bank or ID card: 85.60 x 53.98 mm. A4 paper: 210 x 297 mm. US letter: 8.5 x 11 inches. A one euro coin: 23.25 mm; a US quarter: 24.26 mm; a UK pound coin: 23.43 mm. A standard pencil: about 7 mm thick. Hold one of these at the zero mark to double check your calibration before measuring something that matters, such as ring size, screw length or a phone case.</p>',
			'reference-sizes',
		),
	),
	'fixes'        => array(
		array( 'The ruler is the wrong size', 'Calibrate it: open "Calibrate for exact size" and match a bank card, or enter your screen diagonal. Then check that browser zoom is at 100%.' ),
		array( 'It was right yesterday and is wrong today', 'Browser zoom or display scaling changed, or you are on a different screen. Press Ctrl+0 to reset zoom, or calibrate again. Each browser stores its own calibration.' ),
		array( 'The ruler is too short for my object', 'Use Full screen for the longest ruler, or switch to Vertical if your screen is taller than it is wide. Measure in sections by lining up the end of the first measurement with the zero mark.' ),
		array( 'The ruler looks blurry', 'Set browser zoom to 100% and avoid fractional display scaling (such as 125%) if you can. The ruler is drawn at your screen\'s pixel density, so blur usually means the page is being scaled after drawing.' ),
	),
	'faq'          => array(
		array( 'Is this online ruler actual size?', 'Yes, once calibrated. Match a bank card or enter your screen size and the marks match a real ruler. Without calibration it assumes 96 pixels per inch, which is close on many desktop monitors.' ),
		array( 'How do I calibrate the ruler without a card?', 'Enter your screen\'s diagonal size in inches, or hold any object you know the size of (a coin, a sheet of A4) against the ruler and use the fine tune buttons until it matches.' ),
		array( 'How long is the ruler?', 'As long as your screen allows. The "Ruler length" box shows the current length. Full screen and Vertical modes give you the longest ruler your display can show.' ),
		array( 'Does the online ruler work on a phone?', 'Yes. Phone screens show about 6-7 cm across in portrait and 12-15 cm in landscape. Calibrate with a bank card for best accuracy.' ),
		array( 'Can I measure in millimeters?', 'Yes. The cm / mm mode has a mark every millimeter, with longer marks every 5 mm and numbers every centimeter. Inch mode shows sixteenths.' ),
		array( 'Is my calibration saved?', 'It is stored in this browser on this device only. Nothing is sent to a server, and you can reset it any time.' ),
	),
	'related'      => array( 'dpi-analyzer', 'dead-pixel-test', 'white-screen', 'refresh-rate-test', 'touch-screen-test', 'online-mirror' ),
	'updated'      => '2026-10-28',
);
