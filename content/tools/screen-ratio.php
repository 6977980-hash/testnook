<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'What Is My Screen Ratio',
	'seo_title'      => 'What Is My Screen Ratio? Find Your Aspect Ratio Online',
	'description'    => 'Find your screen aspect ratio in one second: 16:9, 16:10, 3:2, 21:9 or a phone ratio like 19.5:9, with the exact ratio, decimal value and browser window ratio.',
	'intro'          => 'The shape of your screen, worked out from its real pixels: the common name such as 16:9 or 16:10, the exact reduced ratio, the decimal value, and the ratio of this browser window. Your screen is drawn next to the common ratios so you can see how it compares.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'screen-info' ),
	'scripts'        => array( 'screen-info' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-stage si-stage">
	<div class="si-hero"><small>Your screen aspect ratio</small><strong data-si="ratio">-</strong><span><span data-si="ratio-near">-</span> &middot; <span data-si="physical">-</span> pixels</span></div>
	<div class="si-you" id="si-you-box">Your screen</div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Exact ratio</span><span class="stat-value" data-si="ratio-reduced">-</span></div>
		<div class="stat"><span class="stat-label">Decimal</span><span class="stat-value" data-si="ratio-dec">-</span></div>
		<div class="stat"><span class="stat-label">Browser window</span><span class="stat-value" data-si="vp-ratio">-</span></div>
		<div class="stat"><span class="stat-label">Orientation</span><span class="stat-value" data-si="orientation">-</span></div>
	</div>
	<div class="si-boxes" aria-label="Common aspect ratios">
		<div class="si-box" data-ratio="4:3" style="aspect-ratio:4/3">4:3</div>
		<div class="si-box" data-ratio="3:2" style="aspect-ratio:3/2">3:2</div>
		<div class="si-box" data-ratio="16:10" style="aspect-ratio:16/10">16:10</div>
		<div class="si-box" data-ratio="16:9" style="aspect-ratio:16/9">16:9</div>
		<div class="si-box" data-ratio="19.5:9" style="aspect-ratio:19.5/9">19.5:9</div>
		<div class="si-box" data-ratio="21:9" style="aspect-ratio:64/27">21:9</div>
		<div class="si-box" data-ratio="32:9" style="aspect-ratio:32/9">32:9</div>
	</div>
</div>
<p class="tool-status" id="si-status" aria-live="polite">Rotate a phone or resize the window and the values update.</p>',
	'howto'          => array(
		'Open the page on the screen you want to check. With two monitors, move the browser window to the one you want.',
		'Read the ratio at the top. If your screen matches a common ratio exactly, the page says so; otherwise it gives the closest one.',
		'Compare the outline of your screen with the common ratios below it; yours is highlighted.',
		'Check <strong>Browser window</strong> to see the ratio of this tab, which changes as you resize it.',
	),
	'howto_title'    => 'How to find your screen ratio',
	'results'        => '<p>The aspect ratio is the screen\'s width divided by its height, written as two numbers. The <strong>exact ratio</strong> is the pixel count reduced as far as it goes: 1920 x 1080 reduces to 16:9, 2560 x 1600 to 8:5 (which everyone calls 16:10). Some resolutions do not reduce neatly: 1366 x 768 is 683:384, which is 1.779:1, close enough to 16:9 (1.778:1) to be sold as 16:9.</p>
<div class="table-scroll"><table>
<thead><tr><th>Ratio</th><th>Decimal</th><th>Where you find it</th></tr></thead>
<tbody>
<tr><td>4:3</td><td>1.33</td><td>Old monitors and TVs, iPad (close to 4:3)</td></tr>
<tr><td>3:2</td><td>1.50</td><td>Microsoft Surface, Framework laptop, many cameras</td></tr>
<tr><td>16:10</td><td>1.60</td><td>MacBooks, business laptops and monitors</td></tr>
<tr><td>16:9</td><td>1.78</td><td>Most monitors, laptops, TVs and YouTube</td></tr>
<tr><td>19.5:9 to 20:9</td><td>2.17-2.22</td><td>Modern phones (in landscape)</td></tr>
<tr><td>21:9</td><td>2.37-2.39</td><td>Ultrawide monitors and cinema films</td></tr>
<tr><td>32:9</td><td>3.56</td><td>Super ultrawide monitors (two 16:9 side by side)</td></tr>
</tbody></table></div>',
	'extra'          => array(
		array(
			'Why the ratio matters',
			'<p>Video and games are made for a ratio. A 16:9 film fills a 16:9 screen; on a 16:10 laptop it gets thin black bars at the top and bottom, and on a 21:9 ultrawide it gets bars at the sides unless the game or player supports ultrawide. Taller ratios such as 16:10 and 3:2 show more lines of a document or web page, which is why many work laptops use them. Phones went from 16:9 to 19.5:9 and taller as bezels shrank, so apps show more in portrait.</p>
<p>To work out a size in a given ratio, or simplify any ratio, use the <a href="/aspect-ratio-calculator/">aspect ratio calculator</a>. To see your exact pixel count and display scaling, use the <a href="/screen-resolution/">screen resolution</a> page.</p>',
			'why-ratio-matters',
		),
		array(
			'"21:9" is not really 21:9',
			'<p>Ultrawide monitors are sold as 21:9, but the common resolutions are 2560 x 1080 (64:27, about 2.37:1) and 3440 x 1440 (43:18, about 2.39:1). True 21:9 would be 2.33:1. The name was borrowed from cinema, where films are shot at 2.39:1. The same goes for phones: "20:9" is a family name rather than an exact ratio, so this page shows both the closest common name and the exact reduced ratio.</p>',
			'ultrawide',
		),
	),
	'fixes'          => array(
		array( 'The ratio looks wrong for my monitor', 'Windows may not be running the monitor at its native resolution. Check Settings > System > Display > Display resolution and choose the "Recommended" value, then reload this page.' ),
		array( 'I get black bars in videos', 'The video and the screen have different ratios. Most players have a zoom or fill option; it crops the picture instead of showing bars.' ),
		array( 'My phone shows a strange ratio', 'Phones report their full panel, including the area under a notch or camera cut-out, so the ratio is often an odd number such as 2.16:1. That is normal.' ),
	),
	'faq'            => array(
		array( 'What is my screen aspect ratio?', 'This page shows it at the top as soon as it opens, worked out from your screen\'s real pixel count.' ),
		array( 'Is 1920 x 1080 16:9?', 'Yes. 1920 divided by 1080 is 1.78, which is exactly 16:9.' ),
		array( 'Is 16:10 better than 16:9?', '16:10 is a little taller, so it shows more of documents and web pages. 16:9 fits films and games with no bars. For work, many people prefer 16:10.' ),
		array( 'What aspect ratio is a phone screen?', 'Most modern phones are about 19.5:9 or 20:9, written long side first. In portrait that is 9:19.5.' ),
		array( 'How do I calculate aspect ratio?', 'Divide the width and height by their greatest common divisor. For 2560 x 1440 that is 160, giving 16:9. The aspect ratio calculator does it for you.' ),
		array( 'Does the browser window ratio matter?', 'For web pages and videos played in a window, yes: they fit the window, not the whole screen. Full screen mode uses the screen ratio.' ),
	),
	'related'        => array( 'aspect-ratio-calculator', 'screen-resolution', 'screen-size', 'ppi-calculator', 'device-info', 'white-screen' ),
	'updated'        => '2026-10-29',
);
