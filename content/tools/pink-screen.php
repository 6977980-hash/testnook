<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Pink Screen',
	'seo_title'    => 'Pink Screen: Full Screen Solid Pink Page for Any Display',
	'description'  => 'Free full-screen pink screen. Use a soft pink light for selfies, makeup and video calls, set a pink mood light, or use magenta to check for stuck green pixels.',
	'intro'        => 'Fill your whole screen with soft pink in one click. A pink screen makes a flattering light for selfies, makeup and video calls, a gentle mood light for a room, and in its magenta shade a quick check for stuck green pixels.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'pink',
		array(
			'#ffc0cb' => 'Pink',
			'#ffb6c1' => 'Light pink',
			'#ff69b4' => 'Hot pink',
			'#ff1493' => 'Deep pink',
			'#ff00ff' => 'Magenta',
			'#e75480' => 'Dark pink',
			'#ffe4ec' => 'Blush',
		),
		'For a flattering selfie light, turn the brightness up and hold the screen to one side of your face.'
	),
	'howto'        => array(
		'Press <strong>Open full pink screen</strong>. The whole screen turns pink and the mouse pointer hides after a moment.',
		'For a face light, choose <strong>Pink</strong>, <strong>Blush</strong> or <strong>Light pink</strong> at full brightness and hold the device about an arm\'s length away, slightly above eye level.',
		'For a pixel check, pick <strong>Magenta</strong> and look across the screen for green or white dots.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the pink screen',
	'results'      => '<p>Light pinks like #FFC0CB use all three subpixels, with red at full and green and blue lower. <strong>Magenta</strong> (#FF00FF) is red plus blue with green switched off, which makes it a useful pixel test:</p>
<ul>
<li><strong>A green or white dot on magenta</strong>: the green subpixel there is stuck on. Try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>.</li>
<li><strong>A red or blue dot on magenta</strong>: the other channel is dead at that spot. <strong>A black dot</strong> is a fully dead pixel.</li>
<li><strong>Uneven pink</strong>, with some areas warmer or more purple: colour shift across the panel, or a tinted viewing angle.</li>
</ul>
<p>For a full single-colour sweep, use the <a href="/dead-pixel-test/">dead pixel test</a>.</p>',
	'extra'        => array(
		array(
			'What a pink screen is used for',
			'<p><strong>Flattering face light.</strong> Soft pink light warms skin tones and softens shadows, which is why beauty creators like it. A phone or laptop showing pink at full brightness is an instant fill light for selfies, makeup, video calls and live streams. Use <strong>Blush</strong> for a subtle effect and <strong>Light pink</strong> for a stronger tint. A <a href="/white-screen/">white screen</a> gives a neutral light if pink is too much.</p>
<p><strong>Mood light.</strong> A dim pink or deep pink screen makes a soft ambient light for a bedroom, a party or a photo backdrop. Hot pink and magenta suit gaming and stream setups.</p>
<p><strong>Pixel check.</strong> Magenta turns green off completely, so any green you see on it is a fault. It complements the <a href="/green-screen/">green screen</a>, which turns red and blue off.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The pink looks orange or salmon', 'Night mode and blue light filters remove blue, which turns pink towards orange. Turn them off and use the monitor\'s standard or sRGB mode.' ),
		array( 'The pink light is too weak for photos', 'Turn the device brightness to 100%, move it closer to your face, and switch off the room lights that are washing it out. A larger screen, such as a laptop or tablet, gives softer and stronger light than a phone.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not allow websites to go fully full screen, so the pink fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen pink?', 'Open this page and press "Open full pink screen". The browser fills your entire screen with pink (#FFC0CB). Press Esc or tap to exit.' ),
		array( 'Why is pink light flattering?', 'Pink light adds warmth to skin and softens shadows and blemishes, so faces look healthier and smoother than under cold white light.' ),
		array( 'What is the difference between pink and magenta?', 'Pink is a light red that uses all three subpixels. Magenta (#FF00FF) is full red plus full blue with no green, a much stronger colour.' ),
		array( 'Can I use a pink screen as a ring light?', 'Yes, in a small way. A screen at full brightness is a soft, wide light that works well at close range for selfies and calls, though a real ring light is much brighter.' ),
		array( 'Can a pink screen find stuck pixels?', 'The magenta shade can: a stuck green subpixel shows as a green or white dot because green should be fully off.' ),
		array( 'Is this pink screen free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'purple-screen', 'red-screen', 'orange-screen', 'white-screen', 'online-mirror', 'stuck-pixel-fixer' ),
	'updated'      => '2026-10-28',
);
