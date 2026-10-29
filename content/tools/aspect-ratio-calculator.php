<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Aspect Ratio Calculator',
	'seo_title'      => 'Aspect Ratio Calculator: Width, Height and Ratio (Free)',
	'description'    => 'Free aspect ratio calculator. Enter a ratio or size, type a new width or height to get the other, simplify any ratio and see common sizes for 16:9 and more.',
	'intro'          => 'Resize anything without stretching it. Enter the original width and height (or pick a ratio like 16:9), then type a new width or height and the calculator fills in the other. It also simplifies the ratio, gives its decimal value, and lists standard sizes in that ratio.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'screen-info' ),
	'scripts'        => array( 'screen-info' ),
	'embed_height'   => 780,
	'tool'           => '<div class="tool-stage si-stage">
	<div class="si-presets" aria-label="Common ratios">
		<button type="button" class="btn btn-sm" data-ar="16:9">16:9</button><button type="button" class="btn btn-sm" data-ar="4:3">4:3</button><button type="button" class="btn btn-sm" data-ar="16:10">16:10</button><button type="button" class="btn btn-sm" data-ar="21:9">21:9</button><button type="button" class="btn btn-sm" data-ar="1:1">1:1</button><button type="button" class="btn btn-sm" data-ar="3:2">3:2</button><button type="button" class="btn btn-sm" data-ar="4:5">4:5</button><button type="button" class="btn btn-sm" data-ar="9:16">9:16</button><button type="button" class="btn btn-sm" id="ar-mine">My screen</button>
	</div>
	<div class="si-form">
		<label>Original width (W1)<input type="number" id="ar-w1" min="0" step="any" value="1920" inputmode="decimal"></label>
		<label>Original height (H1)<input type="number" id="ar-h1" min="0" step="any" value="1080" inputmode="decimal"></label>
		<label>New width (W2)<input type="number" id="ar-w2" min="0" step="any" value="1280" inputmode="decimal"></label>
		<label>New height (H2)<input type="number" id="ar-h2" min="0" step="any" value="" inputmode="decimal"></label>
	</div>
	<div class="btn-row"><label class="si-check"><input type="checkbox" id="ar-round" checked> Round to whole pixels</label><button type="button" class="btn btn-sm" id="ar-swap">Swap width and height</button></div>
	<div class="stats" style="margin-top:14px">
		<div class="stat"><span class="stat-label">Aspect ratio</span><span class="stat-value" id="ar-ratio">-</span></div>
		<div class="stat"><span class="stat-label">Decimal</span><span class="stat-value" id="ar-dec">-</span></div>
	</div>
	<p class="si-note" id="ar-near"></p>
	<div class="ar-preview-wrap"><div class="ar-preview" id="ar-preview"><span id="ar-preview-label"></span></div></div>
	<h3 class="si-sub">Standard sizes in this ratio</h3>
	<ul class="ar-sizes" id="ar-sizes"></ul>
</div>',
	'howto'          => array(
		'Enter the original width and height, such as an image of 1920 x 1080, or press a ratio button like <strong>16:9</strong>.',
		'Type the new width in <strong>W2</strong> and the new height appears in H2. Or type the new height in <strong>H2</strong> and the width appears in W2.',
		'Keep <strong>Round to whole pixels</strong> on for image and video sizes; turn it off for exact values such as print sizes.',
		'Read the simplified ratio and decimal value, and pick a standard size from the list if you need one.',
	),
	'howto_title'    => 'How to use the aspect ratio calculator',
	'results'        => '<p>The calculator keeps the shape the same: <strong>H2 = W2 x H1 / W1</strong> and <strong>W2 = H2 x W1 / H1</strong>. Resizing 1920 x 1080 to a width of 1280 gives 1280 x 720; to a height of 1440 gives 2560 x 1440.</p>
<p>The <strong>aspect ratio</strong> is the original size divided by the greatest common divisor of width and height: 1920 x 1080 divides by 120 to give 16:9. The <strong>decimal</strong> is width divided by height, the form used in cinema (2.39:1) and in CSS (<code>aspect-ratio: 16 / 9</code>). The note under the numbers names the closest standard ratio, which helps with sizes that do not reduce neatly, like 1366 x 768.</p>',
	'extra'          => array(
		array(
			'Common aspect ratios and where they are used',
			'<div class="table-scroll"><table>
<thead><tr><th>Ratio</th><th>Sizes</th><th>Used for</th></tr></thead>
<tbody>
<tr><td>16:9</td><td>1280 x 720, 1920 x 1080, 3840 x 2160</td><td>YouTube, TVs, most monitors, presentations</td></tr>
<tr><td>9:16</td><td>1080 x 1920</td><td>TikTok, Instagram Reels and Stories, YouTube Shorts</td></tr>
<tr><td>4:5</td><td>1080 x 1350</td><td>Instagram portrait posts</td></tr>
<tr><td>1:1</td><td>1080 x 1080</td><td>Square posts, profile pictures</td></tr>
<tr><td>4:3</td><td>1024 x 768, 1600 x 1200</td><td>Old TVs, iPad, many compact cameras</td></tr>
<tr><td>3:2</td><td>6000 x 4000</td><td>35 mm film, most DSLR and mirrorless photos, 6 x 4 inch prints</td></tr>
<tr><td>16:10</td><td>1920 x 1200, 2560 x 1600</td><td>Laptops and work monitors</td></tr>
<tr><td>21:9</td><td>2560 x 1080, 3440 x 1440</td><td>Ultrawide monitors, cinema-style video</td></tr>
</tbody></table></div>',
			'common-ratios',
		),
		array(
			'Resizing images and video without distortion',
			'<p>If you change the width and height by different amounts, the picture stretches. Keep the ratio and only change one side, as this calculator does. When the target has a different ratio, such as a 16:9 video for a 9:16 phone format, you have to choose: crop the sides (fills the screen, loses part of the picture) or letterbox (shows everything with bars). Most editors call these "fill" and "fit". For a picture of your own screen\'s ratio, the <a href="/screen-ratio/">screen ratio</a> page shows it, and <a href="/screen-resolution/">screen resolution</a> gives the pixel size.</p>',
			'resizing',
		),
	),
	'fixes'          => array(
		array( 'The new height has decimals', 'Not every width gives a whole-number height in a ratio. Turn on "Round to whole pixels", or choose a width from the standard sizes list, which divide evenly.' ),
		array( 'My video size must be an even number', 'Many video encoders need even widths and heights. Round the result to the nearest even number; the change in shape is too small to see.' ),
		array( 'The ratio shows a long decimal', 'You entered a size with decimals. Use whole pixel sizes to get a simplified ratio such as 16:9.' ),
	),
	'faq'            => array(
		array( 'How do I calculate the aspect ratio?', 'Divide the width and height by their greatest common divisor. 1920 and 1080 share 120, so the ratio is 16:9. Or just type them into the calculator.' ),
		array( 'What height is 16:9 at 1280 wide?', '720 pixels. At 1920 wide it is 1080, at 2560 wide 1440, and at 3840 wide 2160.' ),
		array( 'What is the aspect ratio of 1080 x 1350?', '4:5, the portrait size Instagram uses for posts.' ),
		array( 'Is 1920 x 1080 the same as 16:9?', 'Yes. 1920 x 1080 is a 16:9 size, called Full HD.' ),
		array( 'What is the formula for the new height?', 'New height = new width x original height / original width. For 16:9 and a width of 1000, that is 1000 x 9 / 16 = 562.5.' ),
		array( 'Can I use this for print sizes?', 'Yes. Turn off rounding and enter sizes in centimetres or inches instead of pixels; the maths is the same.' ),
	),
	'related'        => array( 'screen-ratio', 'ppi-calculator', 'screen-resolution', 'screen-size', 'online-ruler', 'device-info' ),
	'updated'        => '2026-10-29',
);
