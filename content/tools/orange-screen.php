<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Orange Screen',
	'seo_title'    => 'Orange Screen: Full Screen Solid Orange Page for Any Display',
	'description'  => 'Free full-screen orange screen. Make a warm sunset-style light, add a golden glow to photos and video calls, or check how evenly your display shows colour.',
	'intro'        => 'Turn your whole screen solid orange with one click. Use it as a warm, sunset-style light in the evening, a golden fill light for photos and video calls, or a quick check that your monitor or phone shows colour evenly across the panel.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'orange',
		array(
			'#ff8000' => 'Pure orange',
			'#ffa500' => 'Light orange',
			'#ff4500' => 'Red orange',
			'#ff8c42' => 'Sunset orange',
			'#ffb37a' => 'Peach',
			'#cc5500' => 'Burnt orange',
			'#663000' => 'Ember 40%',
		),
		'Pick Sunset orange or Ember and lower the brightness for a cosy evening light.'
	),
	'howto'        => array(
		'Press <strong>Open full orange screen</strong>. The whole screen turns orange and the mouse pointer hides after a moment.',
		'Choose a shade: <strong>Pure orange</strong> for a colour check, <strong>Sunset orange</strong> or <strong>Ember</strong> for a soft warm light, <strong>Peach</strong> for a gentle fill light on faces.',
		'Set <strong>Auto close</strong> if you leave the screen on as a lamp.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the orange screen',
	'results'      => '<p>Orange (#FF8000) is full red plus half green, with blue off. Because the green subpixels run at a middle level, orange is a good test of how evenly a panel handles in-between brightness, not just fully on or off. A healthy screen shows the same orange in every area. Look for:</p>
<ul>
<li><strong>Patches that look redder or more yellow</strong>: uneven colour across the panel, common on older LCDs and on viewing angles away from the centre.</li>
<li><strong>Visible steps or bands</strong> on a large orange area: the panel or its settings reduce colour depth. Turn off dynamic contrast and similar "enhancement" modes.</li>
<li><strong>Single odd-coloured dots</strong>: a stuck or dead subpixel. Confirm with the <a href="/dead-pixel-test/">dead pixel test</a>.</li>
</ul>',
	'extra'        => array(
		array(
			'What an orange screen is used for',
			'<p><strong>Warm evening light.</strong> Orange light has very little blue in it, much like a sunset or a candle. Set a tablet or monitor to <strong>Ember</strong> or <strong>Sunset orange</strong> at low brightness for a cosy ambient light that is easier on your body clock than a white screen.</p>
<p><strong>Golden fill light.</strong> Placed to one side of your face, a peach or light orange screen adds a warm "golden hour" glow to selfies, portraits and video calls. Combine it with the <a href="/white-screen/">white screen</a> on a second device for a key and fill setup.</p>
<p><strong>Themes and events.</strong> An orange screen is a quick backdrop for Halloween, autumn photos, sports team colours or a party light.</p>
<p><strong>Colour evenness check.</strong> Orange mixes two channels at different levels, so it shows colour shifts that pure red, green and blue miss. Use it with the <a href="/grey-screen/">grey screen</a> for a full uniformity check.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The orange looks red or brown', 'Raise the brightness, turn off night mode and blue light filters, and check the monitor is not in a "warm" or "reading" picture mode, which pulls orange towards red. Dark rooms also make orange look browner.' ),
		array( 'One side of the screen looks different', 'Sit straight in front of the centre of the screen. If the shift remains, it is backlight or panel unevenness, which software cannot fix.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not allow websites to go fully full screen, so the orange fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen orange?', 'Open this page and press "Open full orange screen". The browser fills your entire screen with orange (#FF8000). Press Esc or tap to exit.' ),
		array( 'Is orange light good at night?', 'Dim orange light contains very little blue, so it disturbs your sleep cycle less than white or blue light. Keep it dim and use the auto close timer.' ),
		array( 'What is the colour code for orange?', 'This page uses #FF8000 (RGB 255, 128, 0) as pure orange. The web colour named "orange" is #FFA500, offered here as Light orange.' ),
		array( 'Can I use an orange screen as a photo light?', 'Yes. Hold a phone or tablet showing peach or light orange close to the subject for a warm fill light. Turn the brightness up and keep the screen out of the shot.' ),
		array( 'Can an orange screen show dead pixels?', 'It can show stuck or dead subpixels as odd-coloured dots, but the dead pixel test, which cycles single colours, is more thorough.' ),
		array( 'Is this orange screen free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'yellow-screen', 'red-screen', 'pink-screen', 'white-screen', 'grey-screen', 'dead-pixel-test' ),
	'updated'      => '2026-10-28',
);
