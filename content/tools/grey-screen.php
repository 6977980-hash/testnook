<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Gray Screen',
	'seo_title'    => 'Gray Screen (Grey): Full Screen Page for Uniformity Tests',
	'description'  => 'Free full-screen gray (grey) screen in 5% to 90% shades. Check panel uniformity, dirty screen effect, banding, burn-in and tint on any monitor, TV or phone.',
	'intro'        => 'Fill your whole screen with an even gray (or grey) in one click. Gray is the best color for spotting uneven brightness, dirty screen effect, banding, color tints and burn-in, with shades from a near-black 5% up to a light 90%.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'gray',
		array(
			'#808080' => '50% gray',
			'#0d0d0d' => '5% gray',
			'#1a1a1a' => '10% gray',
			'#333333' => '20% gray',
			'#595959' => '35% gray',
			'#bfbfbf' => '75% gray',
			'#e6e6e6' => '90% gray',
		),
		'Dim the room and set your normal brightness; check 50% first, then the darker shades.'
	),
	'howto'        => array(
		'Set the screen to the brightness you normally use and dim the room lights.',
		'Press <strong>Open full gray screen</strong>. The screen turns 50% gray and the mouse pointer hides after a moment.',
		'Look across the whole panel for darker or lighter patches, tinted areas and faint shapes. Then try <strong>5%</strong>, <strong>10%</strong> and <strong>20%</strong>, where clouding and dirty screen effect show most.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the gray screen',
	'results'      => '<p>A perfect panel shows one flat, neutral gray with no shapes or tints. Real panels are never perfect, so judge what you can see at normal viewing distance:</p>
<ul>
<li><strong>Darker corners or edges</strong> (vignetting): a little is normal on LCDs. Strong fall-off points to an uneven backlight.</li>
<li><strong>Blotches, vertical bands or a "dirty" look</strong> that is most visible when you move your eyes across the screen: dirty screen effect (DSE), common on large TVs. It shows in sports and panning shots.</li>
<li><strong>A faint logo, taskbar or HUD</strong>: burn-in or image retention, most common on OLED. Confirm with the <a href="/burn-in-test/">burn-in test</a>.</li>
<li><strong>A pink, green or blue cast</strong> in one area or across the whole screen: a white balance or uniformity problem. Gray should look neutral next to a sheet of white paper.</li>
<li><strong>Clouds on the darkest shades</strong>: clouding or "mura" on VA and IPS panels, also visible on the <a href="/black-screen/">black screen</a>.</li>
</ul>',
	'extra'        => array(
		array(
			'What a gray screen is used for',
			'<p><strong>Uniformity testing.</strong> Reviewers photograph TVs and monitors on a full gray screen because gray shows every brightness and color difference. A 50% gray reveals backlight unevenness and tints; 5-20% gray shows clouding and dirty screen effect; 75-90% shows dark spots and dust.</p>
<p><strong>Burn-in checks.</strong> A mid gray is the best background for seeing image retention on OLED phones, TVs and laptops. Static elements such as a news ticker, a game HUD or a navigation bar show up as a faint shape.</p>
<p><strong>Checking a new TV or monitor.</strong> Most shops allow returns for serious uniformity faults. Check new screens in the first days, using gray and the <a href="/dead-pixel-test/">dead pixel test</a>, and take photos of anything you find.</p>
<p><strong>Neutral reference.</strong> Photographers and designers use a mid gray to judge whether a screen is tinted. If gray looks warm or cold next to another display, adjust the color temperature until they match.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The gray looks blotchy only when I move my eyes', 'That is dirty screen effect. It cannot be fixed in software. Lowering the backlight and turning off local dimming can make it less visible; on a new TV, compare with the shop\'s return policy.' ),
		array( 'The gray has a pink or green tint', 'Reset the picture settings, choose a "standard", "movie" or "filmmaker" mode, set color temperature to "warm" or 6500 K, and turn off eye-care filters. A tint that only covers part of the screen is a panel fault.' ),
		array( 'I can see a faint image on the gray', 'If it fades after 10-20 minutes of varied content, it was temporary image retention. If it stays, it is burn-in. Many OLEDs have a "pixel refresh" option in the settings that can reduce it.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not let websites go fully full screen, so the gray fills the browser window instead. Rotate to landscape or add the page to your home screen.' ),
	),
	'faq'          => array(
		array( 'Is it gray screen or grey screen?', 'Both are correct: "grey" is the British spelling and "gray" the American one. The color and this test are the same.' ),
		array( 'What is a uniformity test?', 'A check that the screen shows the same brightness and color everywhere. Showing a full gray screen in a dark room is the simplest way to do it.' ),
		array( 'What is dirty screen effect?', 'Uneven patches or bands on a large screen that look like a dirty window, most visible on flat gray or when the camera pans in sports. It comes from small variations in the panel and backlight.' ),
		array( 'Which gray shade should I use?', 'Start with 50% for tints and backlight, use 5-20% for clouding and dirty screen effect, and 75-90% for dark spots and dust.' ),
	),
	'related'      => array( 'burn-in-test', 'black-screen', 'white-screen', 'dead-pixel-test', 'refresh-rate-test', 'stuck-pixel-fixer' ),
	'updated'      => '2026-10-28',
);
