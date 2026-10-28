<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Purple Screen',
	'seo_title'    => 'Purple Screen: Full Screen Solid Purple Page for Any Display',
	'description'  => 'Free full-screen purple screen. Set a purple mood light for gaming and streaming, use lavender as a soft light, or check how your display mixes red and blue.',
	'intro'        => 'Turn your whole screen solid purple with one click. Use it as a purple mood light behind a gaming or streaming setup, choose lavender for a soft calm light, or check how evenly your monitor or phone mixes red and blue.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'purple',
		array(
			'#800080' => 'Purple',
			'#9b30ff' => 'Bright purple',
			'#8a2be2' => 'Blue violet',
			'#4b0082' => 'Indigo',
			'#9370db' => 'Medium purple',
			'#e6e6fa' => 'Lavender',
			'#2a0a3d' => 'Night purple',
		),
		'Bright purple and blue violet give the strongest glow for a mood light.'
	),
	'howto'        => array(
		'Press <strong>Open full purple screen</strong>. The whole screen turns purple and the mouse pointer hides after a moment.',
		'Pick a shade: <strong>Bright purple</strong> or <strong>Blue violet</strong> for a vivid mood light, <strong>Lavender</strong> for a soft light, <strong>Night purple</strong> for a very dim glow.',
		'Set <strong>Auto close</strong> if you leave the screen on in the background.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the purple screen',
	'results'      => '<p>Purple (#800080) is red and blue at half power with green off. Because it mixes two channels at a middle level, purple shows how evenly the panel handles colour, and stuck green subpixels stand out against it:</p>
<ul>
<li><strong>A green or white dot</strong>: a green subpixel is stuck on. Try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>.</li>
<li><strong>Areas that look more blue or more pink</strong>: colour shift across the panel, often worse at the edges or from an angle.</li>
<li><strong>Banding</strong> in large dark purple areas: low colour depth or an image "enhancement" mode. Turn off dynamic contrast.</li>
</ul>
<p>For a complete pixel check, run the <a href="/dead-pixel-test/">dead pixel test</a>.</p>',
	'extra'        => array(
		array(
			'What a purple screen is used for',
			'<p><strong>Gaming and streaming mood light.</strong> Purple is a favourite backlight colour for desks, streams and photos. An old tablet or second monitor showing bright purple behind you adds a coloured rim of light without any extra lamps. Pair it with the <a href="/blue-screen/">blue</a> or <a href="/pink-screen/">pink</a> screen on another device for a two-colour look.</p>
<p><strong>Soft calm light.</strong> Lavender is a pale, gentle purple that works as a quiet night light or a relaxing background while music plays. Keep the brightness low in the evening.</p>
<p><strong>Not ultraviolet.</strong> A purple screen looks a little like a black light, but screens cannot produce UV. It will not make fluorescent paint glow or check banknotes.</p>
<p><strong>Colour check.</strong> Purple tests the mix of red and blue at partial levels, a combination that pure single-colour screens do not cover.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The purple looks blue or pink', 'Turn off night mode and blue light filters, which turn purple pink, and set the monitor to its standard or sRGB mode. A vivid mode can push purple towards blue.' ),
		array( 'The purple is very dark', 'Purple uses red and blue at half power, and blue looks dark to the eye. Choose Bright purple or Medium purple, or raise the screen brightness.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not let websites go fully full screen, so the purple fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen purple?', 'Open this page and press "Open full purple screen". The browser fills your entire screen with purple (#800080). Press Esc or tap to exit.' ),
		array( 'What is the colour code for purple?', 'This page uses the web colour purple, #800080 (RGB 128, 0, 128). Bright purple, blue violet, indigo and lavender are available as extra shades.' ),
		array( 'Can a purple screen work as a black light?', 'No. A screen only emits visible light, so it cannot make UV-reactive paint or ink glow. It just looks purple.' ),
		array( 'What is the difference between purple and violet?', 'On screens, purple is a mix of red and blue. True violet is a single short wavelength that screens can only imitate, so "blue violet" is the closest shade here.' ),
		array( 'Can I use the purple screen for a stream background?', 'Yes. Put a tablet or spare monitor showing purple behind you, out of focus, for a coloured glow. Lower the brightness if it overpowers your face.' ),
		array( 'Is this purple screen free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'pink-screen', 'blue-screen', 'red-screen', 'black-screen', 'stuck-pixel-fixer', 'dead-pixel-test' ),
	'updated'      => '2026-10-28',
);
