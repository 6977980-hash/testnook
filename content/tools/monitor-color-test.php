<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

return array(
	'title'          => 'Monitor Color Test',
	'seo_title'      => 'Monitor Color Test: Check Screen Colors, Gradients and Tint',
	'description'    => 'Free monitor color test: color bars, RGB gradients, a spectrum, saturation steps and 24 reference patches show clipped, tinted or banded colors on any screen.',
	'intro'          => 'See how well your screen shows color. Fifteen full-screen patterns check primary and secondary colors, smooth gradients, the whole hue spectrum, saturation steps, natural reference colors such as skin and sky, and whether grays stay neutral.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test' ),
	'scripts'        => array( 'monitor-test' ),
	'embed_height'   => 640,
	'tool'           => $patterns(
		array( 'color-bars', 'rgb-gradients', 'hue', 'saturation', 'checker', 'gradient', 'grey50', 'gamma', 'red', 'green', 'blue', 'cyan', 'magenta', 'yellow', 'white' ),
		'Start full-screen color test',
		'Turn off night light, True Tone and vivid picture modes before you judge colors.'
	),
	'howto'          => array(
		'Turn off night light, Night Shift, True Tone, eye comfort and any vivid, dynamic or game picture mode. These change colors on purpose.',
		'Use normal room lighting, not a dark room or direct sunlight, and set the browser zoom to 100%.',
		'Press <strong>Start full-screen color test</strong>. Step through the patterns with a click, tap or the arrow keys.',
		'Check the color bars and gradients first, then the reference patches: skin tones should look like real skin and the gray row should have no tint.',
		'If two screens are side by side, open the page on both and compare the same pattern.',
	),
	'howto_title'    => 'How to test monitor colors',
	'results'        => '<p>You are looking for four kinds of color problem:</p>
<ul>
<li><strong>Tint (wrong white point):</strong> grays and whites look pink, green, blue or yellow. Usually the color temperature or a night mode; fix it in the monitor menu (choose 6500K or sRGB) or by calibration.</li>
<li><strong>Clipping:</strong> the last few saturation steps or the brightest end of a gradient look the same. Saturation or contrast is set too high, or a vivid mode is on.</li>
<li><strong>Banding:</strong> steps in the RGB gradients or the spectrum. Low bit depth, a reduced color output setting, or a color profile adjustment.</li>
<li><strong>Oversaturation:</strong> skin tones look orange or sunburnt and greens look neon. Common on wide gamut monitors showing normal web content without an sRGB mode.</li>
</ul>
<p>Color is also personal: your eyes adapt to the white of the screen within a minute, so compare with another trusted screen or a white sheet of paper in daylight if you can.</p>',
	'extra'          => array(
		array(
			'What the reference patches show',
			'<p>The color patches page uses 24 colors modelled on a standard photographic color chart: dark and light skin, sky blue, foliage, a blue flower, primary and secondary colors, and six grays from white to black. These are colors everyone knows from real life, so a screen that shows them wrongly is easy to spot. Skin that looks orange or pink, a sky blue that looks purple, or grays that are not neutral all point to a color setting worth changing.</p>',
			'reference-patches',
		),
		array(
			'sRGB, wide gamut and HDR',
			'<p>Almost all web pages, photos and games are made in the sRGB color space. Wide gamut monitors (DCI-P3, Adobe RGB) can show deeper reds and greens, but they make sRGB content look oversaturated unless the monitor has an sRGB mode or the system manages color. If skin tones look too red, look for an sRGB mode or "sRGB clamp" in the monitor menu. Browsers show this page in SDR, so it does not test HDR brightness. For brightness, contrast and gamma, follow our <a href="/monitor-calibration/">monitor calibration</a> steps; for a full panel check, run the <a href="/monitor-test/">monitor test</a>.</p>',
			'srgb-wide-gamut',
		),
	),
	'fixes'          => array(
		array( 'Whites look blue or yellow', 'In the monitor menu set Color temperature to 6500K, Warm or sRGB, and turn off blue light filters while comparing. On Windows check Settings > System > Display > Night light; on a Mac, Night Shift and True Tone.' ),
		array( 'Colors are too strong', 'Choose the Standard or sRGB picture mode instead of Vivid or Dynamic, and lower the saturation if the monitor has a setting for it. On Samsung phones choose Natural under Screen mode.' ),
		array( 'Gradients show bands', 'Set the graphics card output to full RGB at 8 bits per color or more, remove custom ICC profiles you do not need, and turn off dynamic contrast. On HDMI make sure the PC and monitor agree on full or limited range.' ),
	),
	'faq'            => array(
		array( 'How do I test my monitor colors?', 'Open the color test full screen with night modes off and step through the bars, gradients, spectrum, saturation steps and reference patches. Look for tint, clipping, banding and unnatural skin tones.' ),
		array( 'Why do my two monitors show different colors?', 'Each panel has its own white point, gamut and settings. Set both to the same mode (sRGB or 6500K) and similar brightness; for an exact match you need a hardware calibrator.' ),
		array( 'Can I calibrate colors without a colorimeter?', 'You can set brightness, contrast, gamma and color temperature by eye with our calibration steps, which gets most screens close. Accurate color for print or video work needs a hardware colorimeter.' ),
		array( 'What is a color gamut?', 'The range of colors a screen can show. sRGB is the standard for the web; DCI-P3 and Adobe RGB are wider gamuts used by many newer monitors, phones and laptops.' ),
		array( 'Why does the gray look slightly colored?', 'The screen\'s white point is off (too warm or too cool), or a night light mode is on. A neutral gray should look like neither pink, green, blue nor yellow.' ),
		array( 'Does this test check for color blindness?', 'No, it checks the screen. To check your own color vision, use the <a href="/color-vision-test/">color vision test</a>.' ),
	),
	'related'        => array( 'monitor-calibration', 'monitor-test', 'display-test', 'oled-test', 'color-vision-test', 'dead-pixel-test', 'lcd-test', 'grey-screen' ),
	'updated'        => '2026-10-29',
);
