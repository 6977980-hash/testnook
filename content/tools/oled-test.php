<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

return array(
	'title'          => 'OLED Test',
	'seo_title'      => 'OLED Test: Check True Black, Near-Black Mura and Burn-in',
	'description'    => 'Free OLED test for phones, TVs and monitors. Check true black, near-black uniformity (mura), banding, burn-in, tint and dark smearing with full-screen patterns.',
	'intro'          => 'OLED screens light every pixel on its own, so they have perfect blacks but their own set of faults: blotchy near-black greys (mura), a tint, banding in dark gradients, burn-in from static images and smearing in dark scenes. These patterns check each one on any OLED or AMOLED phone, TV, laptop or monitor.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test' ),
	'scripts'        => array( 'monitor-test' ),
	'embed_height'   => 640,
	'tool'           => $patterns(
		array(
			'black'      => array( 'True black', 'On a working OLED, black looks exactly like the screen is off, even in a dark room. Any glow, bright dot or coloured pixel is a fault.' ),
			'grey5',
			'near-black',
			'grey20'     => array( '20% grey (mura)', 'Look for vertical bands, blotches or a dirty-screen look. Mild mura is common on OLED in very dark greys and fades at higher levels.' ),
			'grey50'     => array( '50% grey (burn-in)', 'Look for faint shapes of the status bar, navigation bar, keyboard, logos or a game HUD. That is burn-in. Also check that the whole screen has the same tint.' ),
			'white'      => array( 'White (tint and uniformity)', 'The white should be even. A pink, green or yellow cast on one side, or a darker band, is a tint fault. Burn-in shows here as slightly darker shapes.' ),
			'red',
			'green',
			'blue'       => array( 'Blue (ageing)', 'Blue OLED pixels age fastest. Burned-in areas often show as yellowish or darker shapes on blue and white.' ),
			'gradient',
			'rgb-gradients',
			'smear',
		),
		'Start full-screen OLED test',
		'Turn brightness up for burn-in and down for near-black patterns, and use a dark room.'
	),
	'howto'          => array(
		'Turn off auto brightness, night light, True Tone and any eye comfort mode so they do not tint the patterns.',
		'Dim the room. Set the brightness to about 50% for the dark patterns, and turn it up to full for the grey, white and blue burn-in checks.',
		'Press <strong>Start full-screen OLED test</strong>. On a phone, tap to go to the next pattern; turn the phone to landscape to see the full width.',
		'For burn-in, look at where the status bar, navigation bar, keyboard and app icons usually sit. Tilt the phone slightly, which can make faint shapes easier to see.',
		'Compare what you see with the results table below.',
	),
	'howto_title'    => 'How to test an OLED screen',
	'results'        => '<div class="table-scroll"><table>
<thead><tr><th>Pattern</th><th>A healthy OLED</th><th>Possible fault</th></tr></thead>
<tbody>
<tr><td>True black</td><td>Looks switched off</td><td>Lit dots (stuck pixels) or a glow (it may be an LCD)</td></tr>
<tr><td>5% grey and near-black steps</td><td>Even dark grey, each step slightly brighter</td><td>Blotches, bands, green or magenta tint (near-black mura); steps that merge (black crush)</td></tr>
<tr><td>50% grey, white, blue</td><td>Even colour everywhere</td><td>Faint shapes of bars, icons or text (burn-in); tinted edges</td></tr>
<tr><td>Gradients</td><td>Smooth fade</td><td>Visible steps, especially in the darkest part (banding)</td></tr>
<tr><td>Dark smearing</td><td>Clean moving boxes</td><td>A smudge behind the darkest boxes (rare on OLED, common on VA LCDs)</td></tr>
</tbody></table></div>
<p>Near-black mura at very low levels is common on phones and TVs and not usually covered by warranty. Burn-in that you can see in normal apps or video is a fault worth reporting.</p>',
	'extra'          => array(
		array(
			'Burn-in vs image retention',
			'<p><strong>Image retention</strong> is temporary: a faint ghost of something that was on screen for a while, which fades after a few minutes of different content. <strong>Burn-in</strong> is permanent: the pixels in that area have aged more than their neighbours and are now dimmer. If the shape is still there after an hour of video, it is burn-in. Our <a href="/burn-in-test/">burn-in test</a> has a timed colour cycle that helps clear retention, and the <a href="/grey-screen/">grey screen</a> lets you check at different shades.</p>',
			'burn-in-vs-retention',
		),
		array(
			'OLED and AMOLED',
			'<p>AMOLED (active-matrix OLED) is what almost every OLED phone, watch, TV and laptop uses; the name is mostly used by Samsung. P-OLED, LTPO and QD-OLED are variations of the same idea. All of them light each pixel on its own, so this test works the same on every one. Screens without that self-lit design, including Mini-LED, are LCDs; use the <a href="/lcd-test/">LCD test</a> for them.</p>',
			'oled-amoled',
		),
	),
	'fixes'          => array(
		array( 'I can see burn-in', 'Run the colour cycle in the <a href="/burn-in-test/">burn-in test</a> for 10-30 minutes; if the shape fades it was image retention. TVs and monitors have a "pixel refresh" or "panel care" routine in their settings that evens out wear; run it as the manual describes. True burn-in on a phone can only be fixed by a screen replacement.' ),
		array( 'Dark greys look blotchy or green', 'That is near-black mura, a known OLED trait. Raising the brightness slightly or using a light theme in dark rooms makes it less visible. Some phones improve it with a software update; on a new device you can ask for an exchange if it bothers you in normal use.' ),
		array( 'Prevent burn-in', 'Use dark mode and auto-hiding bars, lower the brightness, set a short screen timeout, avoid leaving static images such as maps or game HUDs on screen for hours, and let TVs and monitors run their pixel refresh when you turn them off.' ),
	),
	'faq'            => array(
		array( 'How do I test an OLED screen?', 'Open the patterns full screen in a dim room and check true black, the near-black greys for mura, the grey, white and blue screens for burn-in, and the gradients for banding.' ),
		array( 'How can I tell if my phone has burn-in?', 'Open the 50% grey and white patterns at full brightness and look where the status bar, navigation bar and keyboard sit. Faint shapes there that stay after watching a video for a while are burn-in.' ),
		array( 'What is OLED mura?', 'Mura is uneven brightness. On OLED it shows mostly in very dark greys as blotches, bands or a dirty-screen look, because each pixel behaves slightly differently at its lowest light levels.' ),
		array( 'Can this test cause burn-in?', 'No. Burn-in takes hundreds of hours of the same static image. A few minutes of test patterns has no lasting effect.' ),
		array( 'Is black supposed to look completely off on OLED?', 'Yes. OLED pixels switch off fully for black, so in a dark room a black screen looks like the device is off. If it glows, the screen is an LCD or the content is not pure black.' ),
		array( 'Does this work on Samsung AMOLED and iPhone OLED?', 'Yes. It works on every OLED and AMOLED phone, including Samsung Galaxy, iPhone X and later, Pixel and OnePlus, and on OLED TVs, laptops and monitors.' ),
	),
	'related'        => array( 'burn-in-test', 'black-screen', 'grey-screen', 'dead-pixel-test', 'lcd-test', 'monitor-test', 'display-test', 'stuck-pixel-fixer' ),
	'updated'        => '2026-10-29',
);
