<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Yellow Screen',
	'seo_title'    => 'Yellow Screen: Full Screen Solid Yellow Page for Any Display',
	'description'  => 'Free full-screen yellow screen. Use a warm yellow light with no blue in it, check red and green subpixels together, or spot a stuck blue pixel on your display.',
	'intro'        => 'Fill your whole screen with solid yellow in one click. Yellow is made from red and green light only, so it makes a warm, blue-free light for the evening and a quick check for stuck blue pixels on a monitor, laptop or phone.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'yellow',
		array(
			'#ffff00' => 'Pure yellow',
			'#ffd700' => 'Golden yellow',
			'#ffbf00' => 'Amber',
			'#cccc00' => 'Yellow 80%',
			'#808000' => 'Olive 50%',
			'#fff176' => 'Soft yellow',
			'#ffffe0' => 'Pale yellow',
		),
		'Yellow has no blue light in it, which makes it a warm choice for evening use.'
	),
	'howto'        => array(
		'Press <strong>Open full yellow screen</strong>. The whole screen turns yellow and the mouse pointer hides after a moment.',
		'For a pixel check, use <strong>Pure yellow</strong> at full brightness. For a reading or ambient light, try <strong>Amber</strong> or <strong>Soft yellow</strong> at a lower brightness.',
		'Set <strong>Auto close</strong> if you use the screen as a lamp.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the yellow screen',
	'results'      => '<p>Pure yellow (#FFFF00) lights the red and green subpixels together and leaves blue off. A healthy panel shows one even yellow. Each kind of fault shows as a different colour:</p>
<ul>
<li><strong>A white dot</strong>: the blue subpixel there is stuck on. This is the easiest place to see a stuck blue subpixel.</li>
<li><strong>A green dot</strong>: the red subpixel is dead or stuck off. <strong>A red dot</strong>: the green subpixel is.</li>
<li><strong>A black dot</strong>: the whole pixel is dead. Confirm it on the <a href="/white-screen/">white screen</a>.</li>
<li><strong>Orange or greenish areas</strong>: the panel shifts colour across its surface, often from uneven backlight or ageing.</li>
</ul>
<p>Stuck subpixels can sometimes be revived with the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>. For a full sweep, use the <a href="/dead-pixel-test/">dead pixel test</a>.</p>',
	'extra'        => array(
		array(
			'What a yellow screen is used for',
			'<p><strong>Warm, blue-free light.</strong> Because the blue subpixels stay off, a yellow or amber screen gives light with almost no blue in it. That makes it a gentler evening reading light or night light than white, which has the most blue. Keep it dim for the best effect.</p>
<p><strong>Pixel checks.</strong> Yellow tests two channels at once and shows each fault as a clear colour: a stuck blue subpixel turns into a white dot, a dead red one turns green. It is a fast follow-up after the <a href="/red-screen/">red</a>, <a href="/green-screen/">green</a> and <a href="/blue-screen/">blue</a> screens.</p>
<p><strong>Signals and mood.</strong> A yellow tablet makes a "wait" or "caution" sign, a cheerful party light, or a warm glow behind a photo subject.</p>
<p><strong>Tinted reading.</strong> Some people find black text easier to read on a pale yellow background. Use <strong>Pale yellow</strong> behind a sheet of paper or as a soft backlight.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The yellow looks green or orange', 'Turn off night mode and blue light filters, set the monitor to its standard or sRGB mode, and check the colour temperature setting. A greenish yellow often means the monitor\'s colour balance is off.' ),
		array( 'The yellow looks washed out', 'Raise the brightness and contrast, and check the viewing angle: TN and some VA panels lose colour when seen from the side or from below.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not let websites go fully full screen, so the yellow fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen fully yellow?', 'Open this page and press "Open full yellow screen". The browser fills your entire screen with pure yellow (#FFFF00). Press Esc or tap to exit.' ),
		array( 'Does a yellow screen block blue light?', 'Pure yellow on a screen uses only the red and green subpixels, so it gives almost no blue light. It is a simple way to get a blue-free light from a phone or monitor.' ),
		array( 'Can a yellow screen find stuck pixels?', 'Yes. A stuck blue subpixel shows as a white dot on yellow, and a dead red or green subpixel shows as a green or red dot.' ),
		array( 'Why is my yellow screen slightly green?', 'The red and green subpixels are not balanced. Check the monitor\'s colour temperature or RGB gain settings, or compare with another screen to see which one is off.' ),
		array( 'Can I use it as a reading light?', 'Yes. Pick amber or soft yellow, lower the brightness and use the auto close timer so the screen turns off if you fall asleep.' ),
		array( 'Is this yellow screen free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'orange-screen', 'red-screen', 'green-screen', 'stuck-pixel-fixer', 'dead-pixel-test', 'white-screen' ),
	'updated'      => '2026-10-28',
);
