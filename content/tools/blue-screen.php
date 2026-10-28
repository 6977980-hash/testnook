<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Blue Screen',
	'seo_title'    => 'Blue Screen: Full Screen Solid Blue Page for Any Display',
	'description'  => 'Free full-screen blue screen. Test blue subpixels for dead or stuck pixels, check OLED blue ageing and tint, or use a calm blue light. Not the Windows error screen.',
	'intro'        => 'Turn your whole screen solid blue with one click. Use it to test the blue subpixels of a monitor, laptop or phone, to look for blue fading on an older OLED, or as a calm blue light. This page is a plain colour, not the Windows "blue screen of death" error.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'blue',
		array(
			'#0000ff' => 'Pure blue',
			'#0047bb' => 'Chroma key blue',
			'#0000cc' => 'Blue 80%',
			'#000080' => 'Navy 50%',
			'#00004d' => 'Night blue 30%',
			'#1e90ff' => 'Bright sky blue',
			'#87ceeb' => 'Light sky blue',
		),
		'Use full brightness for a pixel check; blue faults are the hardest to see.'
	),
	'howto'        => array(
		'Press <strong>Open full blue screen</strong>. The whole screen turns blue and the mouse pointer hides after a moment.',
		'For a pixel check, use <strong>Pure blue</strong> at full brightness and look closely: blue looks darker to the eye than red or green, so take your time.',
		'Pick another shade from the swatches for a softer light or a chroma key backdrop.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the blue screen',
	'results'      => '<p>Pure blue (#0000FF) lights only the blue subpixel of each pixel. A healthy panel shows one even, deep blue everywhere. Look for:</p>
<ul>
<li><strong>A black dot</strong>: the blue subpixel there is dead. If it is also black on the <a href="/white-screen/">white screen</a>, the whole pixel is dead.</li>
<li><strong>A red, green or white dot</strong>: another subpixel is stuck on. The <a href="/stuck-pixel-fixer/">stuck pixel fixer</a> can sometimes revive it.</li>
<li><strong>Dim or purple-tinted areas</strong>: on an older OLED, the blue material ages fastest, so worn areas (such as where a taskbar or keyboard sat) can look dimmer. The <a href="/burn-in-test/">burn-in test</a> checks this in more detail.</li>
</ul>
<p>Test the <a href="/red-screen/">red</a> and <a href="/green-screen/">green</a> screens too, or run the <a href="/dead-pixel-test/">dead pixel test</a> for every colour in one go.</p>',
	'extra'        => array(
		array(
			'What a blue screen is used for',
			'<p><strong>Pixel checks.</strong> Blue is the third of the three single-channel tests. A dead blue subpixel is easy to miss on white, so a full blue screen is the only reliable way to find one.</p>
<p><strong>OLED ageing.</strong> Blue OLED pixels wear out faster than red and green ones. On a phone or TV that is a few years old, a blue screen shows uneven wear more clearly than any other colour.</p>
<p><strong>Backdrop and light.</strong> Chroma key blue (#0047BB) is used when the subject is green or wears green. A monitor showing it works as a small backdrop for close-ups. Blue also makes a cool, calm ambient light, but avoid bright blue light late at night, because it affects your body clock more than warm light.</p>
<p><strong>Not the blue screen of death.</strong> If your Windows PC crashed to a blue error screen, that is a system crash, not a display fault. See the fixes below.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'My PC shows a blue error screen (BSOD)', 'Write down the stop code shown on the screen (for example MEMORY_MANAGEMENT or IRQL_NOT_LESS_OR_EQUAL) and search for it on Microsoft\'s support site. Common causes are a faulty driver, a recent update, failing memory or storage. Start with Windows Update and your graphics driver, and run Windows Memory Diagnostic if it keeps happening.' ),
		array( 'The blue looks purple or too dark', 'Turn off night mode, Night Shift or blue light filters, which cut blue the most, and use the monitor\'s standard or sRGB mode. Blue always looks darker than red or green to the eye; that is normal.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not let websites go fully full screen, so the blue fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen completely blue?', 'Press "Open full blue screen" on this page. The browser fills the whole screen with pure blue (#0000FF). Press Esc or tap to exit.' ),
		array( 'Is this the blue screen of death?', 'No. This page shows a plain blue colour for display tests. The blue screen of death is a Windows crash screen with an error message and stop code.' ),
		array( 'Why does blue look darker than other colours?', 'Your eyes are least sensitive to blue, so pure blue at the same power looks much darker than green or red. That is why blue pixel faults need a closer look.' ),
		array( 'Why do OLED screens lose blue first?', 'The blue organic material in OLED panels degrades faster than red and green, so heavily used areas lose some blue over time and can look slightly yellow or dim.' ),
		array( 'What is chroma key blue?', 'A backdrop blue, commonly #0047BB, used instead of green when the subject is green or for some film looks. It keys out cleanly because skin tones contain very little blue.' ),
		array( 'Is this blue screen free?', 'Yes. It runs in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'red-screen', 'green-screen', 'dead-pixel-test', 'burn-in-test', 'purple-screen', 'black-screen' ),
	'updated'      => '2026-10-28',
);
