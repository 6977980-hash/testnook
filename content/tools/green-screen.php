<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Green Screen',
	'seo_title'    => 'Green Screen: Full Screen Solid Green Page for Any Display',
	'description'  => 'Free full-screen green screen. Test green subpixels for dead or stuck pixels, check panel uniformity, or use chroma key green as a small backdrop for close-ups.',
	'intro'        => 'Turn your whole screen solid green with one click. Use it to check the green subpixels and evenness of a monitor, laptop or phone, or pick the chroma key shade to use the screen as a small backdrop for close-up shots.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'green',
		array(
			'#00ff00' => 'Pure green',
			'#00b140' => 'Chroma key green',
			'#00cc00' => 'Green 80%',
			'#008000' => 'Green 50%',
			'#004d00' => 'Dark green 30%',
			'#7cfc00' => 'Lawn green',
			'#90ee90' => 'Light green',
		),
		'Green is the colour your eyes see as brightest, so uneven areas stand out quickly.'
	),
	'howto'        => array(
		'Press <strong>Open full green screen</strong>. The whole screen turns green and the mouse pointer hides after a moment.',
		'For a pixel check, stay on <strong>Pure green</strong> at full brightness and look across the panel from about 30-50 cm away.',
		'For a backdrop, choose <strong>Chroma key green</strong>, place the object in front of the screen and light the object, not the screen.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the green screen',
	'results'      => '<p>Pure green (#00FF00) lights only the green subpixel of each pixel. Your eyes are most sensitive to green, so a green screen is the clearest single-colour test for brightness differences. A healthy panel shows one even green everywhere. Look for:</p>
<ul>
<li><strong>A black dot</strong>: the green subpixel there is dead. If it is also black on the <a href="/white-screen/">white screen</a>, the whole pixel is dead.</li>
<li><strong>A red, blue or white dot</strong>: a red or blue subpixel is stuck on. Try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>.</li>
<li><strong>Yellowish or bluish patches</strong>: the panel shifts colour across its surface. Darker edges are normal in small amounts on LCDs.</li>
</ul>
<p>Check the <a href="/red-screen/">red</a> and <a href="/blue-screen/">blue</a> screens as well to cover every subpixel, or run the <a href="/dead-pixel-test/">dead pixel test</a> for all colours in sequence.</p>',
	'extra'        => array(
		array(
			'What a green screen is used for',
			'<p><strong>Pixel and uniformity checks.</strong> Green carries most of the brightness your eyes see, so a full green screen makes backlight bleed, dark corners and banding easy to spot. It is also one of the three single-channel tests every new display should pass.</p>
<p><strong>Small chroma key backdrop.</strong> Looking for a green screen for video editing? A monitor or tablet showing chroma key green (#00B140) works as a backdrop for close-up product shots, jewellery or a small figure, and editing software can key it out. Light the subject separately and turn the screen brightness down so green does not spill onto the edges. A person-sized green screen still needs fabric or paint, because a monitor is too small and too glossy for that.</p>
<p><strong>Calm light and signals.</strong> A green screen makes a soft ambient light, an "available" or "come in" sign, or a "go" signal for games and timers.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The green looks yellow or too bright', 'Set the monitor to its standard or sRGB mode and turn off night mode and blue light filters. Wide-gamut monitors in vivid mode show a very saturated, almost neon green; that is the panel, not a fault.' ),
		array( 'The chroma key will not cut out cleanly', 'Lower the screen brightness, angle the screen so it does not reflect lights, keep the subject a little in front of it, and use chroma key green instead of pure green. Glossy screens reflect the subject, which leaves green fringes.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not allow websites to go fully full screen, so the green fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen fully green?', 'Open this page and press "Open full green screen". The browser fills your entire screen with pure green (#00FF00). Press Esc or tap to exit.' ),
		array( 'Can I use my monitor as a green screen for video?', 'For small close-ups, yes: show the chroma key green shade and key it out in your editor. For people, use a green fabric or painted backdrop, which is larger, matte and easier to light evenly.' ),
		array( 'What is the chroma key green colour code?', 'The common chroma key green is #00B140 (RGB 0, 177, 64). It is darker than pure green, which reduces spill onto the subject.' ),
		array( 'Why is green good for finding dead pixels?', 'Green is the colour your eyes are most sensitive to, so a dead green subpixel or a dim patch is very visible against it.' ),
		array( 'Does a green screen help my eyes?', 'There is no good evidence that looking at a green screen improves eyesight. It is just a colour test and a light source; rest your eyes by looking into the distance instead.' ),
		array( 'Is this green screen free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'red-screen', 'blue-screen', 'dead-pixel-test', 'stuck-pixel-fixer', 'white-screen', 'webcam-test' ),
	'updated'      => '2026-10-28',
);
