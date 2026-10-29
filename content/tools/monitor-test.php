<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

return array(
	'title'          => 'Monitor Test',
	'seo_title'      => 'Monitor Test: Check Your Screen With 16 Test Patterns',
	'description'    => 'Free online monitor test with 16 full-screen patterns: dead pixels, backlight bleed, uniformity, banding, black and white level, gamma, sharpness and geometry.',
	'intro'          => 'A complete check for a new or used monitor in a few minutes. Step through 16 full-screen test patterns, each with a short tip on what to look for: dead pixels, backlight bleed, uneven brightness, colour banding, black and white levels, gamma, sharpness and geometry.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test' ),
	'scripts'        => array( 'monitor-test' ),
	'embed_height'   => 700,
	'tool'           => $patterns(
		array( 'black', 'white', 'red', 'green', 'blue', 'grey50', 'gradient', 'rgb-gradients', 'black-level', 'white-level', 'gamma', 'sharpness', 'grid', 'color-bars', 'inversion', 'smear' ),
		'Start full-screen monitor test',
		'Set the monitor to its native resolution and the browser zoom to 100% first.'
	),
	'howto'          => array(
		'Let the monitor warm up for 10-15 minutes, set it to its native resolution and press <strong>Ctrl + 0</strong> (<strong>Cmd + 0</strong> on a Mac) so the browser zoom is 100%. Several patterns use single pixels and only work at 100%.',
		'Dim the room lights a little and wipe the screen with a dry microfibre cloth.',
		'Press <strong>Start full-screen monitor test</strong>. Each pattern shows a tip at the bottom; press <kbd>H</kbd> to hide it.',
		'Click, tap or press the right arrow for the next pattern and the left arrow to go back. Click any pattern below the button to jump straight to it.',
		'Note anything odd and which pattern showed it, then read the results guide below to see what it means.',
	),
	'howto_title'    => 'How to test a monitor',
	'results'        => '<p>Each pattern checks one thing. A healthy monitor passes all of them; a fault usually shows on one or two patterns only.</p>
<div class="table-scroll"><table>
<thead><tr><th>Pattern</th><th>What it checks</th><th>A problem looks like</th></tr></thead>
<tbody>
<tr><td>Black, white, red, green, blue</td><td>Dead, stuck and hot pixels; backlight bleed</td><td>A dot that does not match the colour; light glowing in from the edges on black</td></tr>
<tr><td>50% grey</td><td>Uniformity and burn-in</td><td>Darker corners, cloudy patches, faint shapes of icons</td></tr>
<tr><td>Grey and colour gradients</td><td>Bit depth and banding</td><td>Visible steps or stripes in the smooth top half</td></tr>
<tr><td>Black level / white level</td><td>Brightness and contrast settings</td><td>The darkest or brightest squares disappear</td></tr>
<tr><td>Gamma</td><td>Mid-tone response</td><td>The square blends in at a value far from 2.2</td></tr>
<tr><td>Sharpness and text</td><td>Sharpness setting and native resolution</td><td>Halos around lines, blurry or colour-fringed text</td></tr>
<tr><td>Grid and geometry</td><td>Scaling and overscan</td><td>Missing outer lines, oval circles, bent lines</td></tr>
<tr><td>Colour bars</td><td>Colour reproduction</td><td>Bars that bleed into each other or look the same</td></tr>
<tr><td>Inversion</td><td>LCD pixel inversion</td><td>A band that flickers or shimmers</td></tr>
<tr><td>Dark smearing</td><td>Dark-level response time</td><td>A dark trail behind the moving boxes</td></tr>
</tbody></table></div>
<p>Small amounts of backlight bleed and IPS glow are normal on LCD monitors, especially in a dark room. Judge the screen with the brightness you actually use, not at maximum.</p>',
	'extra'          => array(
		array(
			'Checking a new or used monitor',
			'<p>Run the test on the day a new monitor arrives: most shops only take returns for dead pixels, bleed or uneven backlight within their return window, and many brands have a pixel policy that allows a few faulty pixels before they swap the panel. Take photos of any fault with your phone, because a screenshot only shows what the computer sends, not what the panel displays.</p>
<p>When buying second hand, ask the seller to open this page on the monitor. The black screen shows bleed and stuck pixels, the 50% grey shows burn-in from a static taskbar or game HUD, and the gradient shows if the panel has been damaged or set up badly.</p>',
			'new-or-used',
		),
		array(
			'More monitor tests',
			'<p>This page covers the panel itself. For motion, use the <a href="/refresh-rate-test/">refresh rate test</a> to check that the monitor runs at its full hertz and the <a href="/ufo-test/">UFO test</a> to see motion blur and ghosting. For a deeper look at one area, try the <a href="/lcd-test/">LCD test</a>, the <a href="/oled-test/">OLED test</a>, the <a href="/monitor-color-test/">monitor colour test</a> or step-by-step <a href="/monitor-calibration/">monitor calibration</a>.</p>',
			'more-tests',
		),
	),
	'fixes'          => array(
		array( 'Patterns look blurry or show moiré', 'Set the screen to its native resolution (Windows: Settings > System > Display; Mac: System Settings > Displays) and set the browser zoom to 100% with Ctrl + 0 or Cmd + 0. With display scaling above 100%, single-pixel patterns can still show fine lines; the gamma and inversion results are then only approximate.' ),
		array( 'The gradient shows clear bands', 'Check that the graphics driver outputs full colour: on Windows, NVIDIA Control Panel > Change resolution > Output colour depth (8 bpc or higher) and Output dynamic range Full. Remove any custom colour profile you do not need, and use DisplayPort or a high-speed HDMI cable.' ),
		array( 'Strong light leaks at the edges on black', 'Lower the brightness to the level you use and look again in normal room light. Some bleed is normal; large bright patches that you see in daily use are worth a return or warranty claim while you still can.' ),
		array( 'Black squares disappear or grey looks washed out', 'Adjust brightness on the black level pattern and contrast on the white level pattern, or follow the full <a href="/monitor-calibration/">monitor calibration</a> guide. On HDMI, check that the PC and monitor agree on full or limited RGB range.' ),
	),
	'faq'            => array(
		array( 'How do I test my monitor online?', 'Open this page on the monitor, set the browser zoom to 100% and press Start. Step through the 16 full-screen patterns and read the tip on each to see what to look for.' ),
		array( 'What does a monitor test check?', 'Dead and stuck pixels, backlight bleed, uniformity, colour banding, black and white levels, gamma, sharpness, geometry, colour reproduction, pixel inversion and dark smearing.' ),
		array( 'How long does the test take?', 'About three to five minutes for all 16 patterns. Spend longer on black, white and 50% grey, where most faults show.' ),
		array( 'Can this test damage my monitor?', 'No. The patterns are still images, except one slowly moving pattern. Nothing flashes, so the test is safe on LCD and OLED screens.' ),
		array( 'Does it work on a laptop or TV?', 'Yes. It works on any screen with a web browser: desktop monitors, laptops, smart TVs, tablets and phones. On a TV, also check the grid pattern for overscan.' ),
		array( 'Why do some patterns need 100% zoom?', 'The gamma, sharpness and inversion patterns are made of single pixels. Browser zoom or display scaling resizes them, which blends the lines and changes the result.' ),
	),
	'related'        => array( 'dead-pixel-test', 'lcd-test', 'oled-test', 'monitor-calibration', 'refresh-rate-test', 'ufo-test', 'monitor-color-test', 'display-test' ),
	'updated'        => '2026-10-29',
);
