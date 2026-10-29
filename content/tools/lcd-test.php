<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

return array(
	'title'          => 'LCD Test',
	'seo_title'      => 'LCD Test: Check for Backlight Bleed, IPS Glow and Clouding',
	'description'    => 'Free online LCD test. Full-screen patterns reveal backlight bleed, IPS glow, clouding, dead pixels, inversion flicker and viewing angle shift on LED screens.',
	'intro'          => 'LCD screens, including every "LED" monitor and TV, light the picture with a backlight behind the panel. These patterns show the faults that come with that design: light leaking at the edges, glow in the corners, cloudy patches, pixel inversion flicker and colour shift at an angle, plus the usual dead pixel check.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test' ),
	'scripts'        => array( 'monitor-test' ),
	'embed_height'   => 640,
	'tool'           => $patterns(
		array(
			'black'         => array( 'Black (backlight bleed)', 'Look at the edges and corners. Light spilling in from the edge is backlight bleed; a milky glow in the corners that changes as you move your head is IPS glow. Use the brightness you normally use, in a dim room.' ),
			'grey5',
			'grey20'        => array( '20% grey (clouding)', 'Look for brighter blotches, bands or a cloudy look across the dark grey. That is clouding from uneven backlight, common on edge-lit LCDs.' ),
			'grey50',
			'white',
			'red',
			'green',
			'blue',
			'inversion',
			'viewing-angle',
			'gradient',
			'black-level',
			'sharpness',
		),
		'Start full-screen LCD test',
		'Bleed and glow show best in a dim room at your normal brightness.'
	),
	'howto'          => array(
		'Let the screen warm up for 10 minutes, set the brightness you normally use and dim the room lights. Bleed looks far worse at 100% brightness in a dark room than in daily use.',
		'Set the browser zoom to 100% (<strong>Ctrl + 0</strong> or <strong>Cmd + 0</strong>) so the inversion and sharpness patterns are drawn pixel for pixel.',
		'Press <strong>Start full-screen LCD test</strong> and sit at your usual distance, centred on the screen.',
		'On the black screen, look at the edges first, then move your head slightly left and right: glow that moves is IPS glow, light that stays put is bleed.',
		'Step through the remaining patterns with a click, tap or the arrow keys, and read each tip.',
	),
	'howto_title'    => 'How to run the LCD test',
	'results'        => '<p>Most LCD faults come from the backlight, not from the pixels. Here is how to tell them apart:</p>
<div class="table-scroll"><table>
<thead><tr><th>What you see</th><th>Cause</th><th>Normal?</th></tr></thead>
<tbody>
<tr><td>Light leaking from one edge or corner, fixed in place</td><td>Backlight bleed: pressure on the panel or a loose frame</td><td>A little is normal; bright patches visible on dark scenes are a fault</td></tr>
<tr><td>Silvery or orange glow in corners that changes with your head position</td><td>IPS glow</td><td>Yes, on all IPS panels. Sitting further back reduces it</td></tr>
<tr><td>Brighter blotches on dark grey</td><td>Clouding (uneven backlight)</td><td>Mild clouding is common on edge-lit LCDs and TVs</td></tr>
<tr><td>Darker corners or bands on 50% grey</td><td>Poor uniformity</td><td>Up to about 10-15% variation is typical</td></tr>
<tr><td>A band of the inversion pattern flickers or crawls</td><td>Pixel inversion artefact</td><td>Common on cheaper and older panels, usually harmless</td></tr>
<tr><td>Colours change or invert when viewed from below</td><td>TN panel viewing angles</td><td>Normal for TN; IPS barely shifts</td></tr>
</tbody></table></div>',
	'extra'          => array(
		array(
			'LCD, LED, IPS, VA and TN: what is the difference?',
			'<p>An "LED monitor" or "LED TV" is an LCD with an LED backlight: the liquid crystal panel makes the image, the LEDs behind it make the light. That is why bleed and glow happen: the panel can never block all of the light. <strong>IPS</strong> panels have the best colours and viewing angles but show glow; <strong>VA</strong> panels have deep blacks and little glow but can smear in dark scenes; <strong>TN</strong> panels are fast and cheap but shift colour at an angle. Mini-LED screens split the backlight into many zones, which helps black levels but can show halos (blooming) around bright objects on black.</p>
<p>OLED screens have no backlight at all, so none of the faults above apply to them. Use the <a href="/oled-test/">OLED test</a> for those, and the <a href="/dead-pixel-test/">dead pixel test</a> for pixel faults on any screen.</p>',
			'lcd-types',
		),
		array(
			'Should I return a monitor for backlight bleed?',
			'<p>Judge it in normal use, not in a pitch-black room at full brightness. If you notice the bleed while watching a film or playing a dark game, it is worth a return while you are inside the return window. If you only see it on a black test screen with the lights off, it is within the range most manufacturers consider normal, and an exchange may arrive with similar or worse bleed. Photograph the screen at an exposure close to what your eyes see; phone cameras exaggerate bleed badly.</p>',
			'return-for-bleed',
		),
	),
	'fixes'          => array(
		array( 'Reduce backlight bleed', 'Lower the brightness, add some light behind or around the monitor (bias lighting), and check the frame is not twisted on the stand. Some people loosen the screws on the back slightly to relieve pressure, but that can void the warranty, so try it only on an old monitor.' ),
		array( 'Reduce IPS glow', 'Sit further back and centred, lower the brightness, and keep some light on in the room. Glow is an angle effect, so a monitor that sits higher or lower than your eyes shows more of it.' ),
		array( 'The inversion pattern flickers', 'Make sure the monitor runs at its native resolution and the browser zoom is 100%. Changing the refresh rate or the overdrive setting sometimes changes the flicker. It rarely shows in normal content, so it is not a reason to return the screen by itself.' ),
	),
	'faq'            => array(
		array( 'What is an LCD test?', 'A set of full-screen test patterns that reveal the faults typical of LCD screens: backlight bleed, IPS glow, clouding, poor uniformity, dead pixels, pixel inversion flicker and viewing angle shift.' ),
		array( 'How do I check for backlight bleed?', 'Open the black pattern full screen in a dim room at your normal brightness and look at the edges and corners. Light that leaks in from the edge and stays in place when you move is bleed.' ),
		array( 'Is IPS glow a defect?', 'No. All IPS panels glow a little in the corners on dark images, and the glow changes as you move your head. It is part of the technology. Bright, fixed patches are bleed instead.' ),
		array( 'Can backlight bleed get worse?', 'It can change with heat and pressure, and sometimes improves a little in the first weeks as the panel settles. Strong bleed caused by a damaged frame usually stays.' ),
		array( 'Does this LCD test work on laptops and TVs?', 'Yes. It works on any LCD or LED screen with a browser: monitors, laptops, TVs, tablets and phones with LCD displays.' ),
		array( 'Is my screen LCD or OLED?', 'Open the black pattern in a dark room. If the screen still glows faintly, it is an LCD with a backlight. If black looks like the screen is switched off, it is OLED.' ),
	),
	'related'        => array( 'monitor-test', 'oled-test', 'dead-pixel-test', 'black-screen', 'burn-in-test', 'display-test', 'grey-screen', 'monitor-calibration' ),
	'updated'        => '2026-10-29',
);
