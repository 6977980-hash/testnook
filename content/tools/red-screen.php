<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_colour-screen.php';

return array(
	'title'        => 'Red Screen',
	'seo_title'    => 'Red Screen: Full Screen Solid Red Page for Any Display',
	'description'  => 'Free full-screen red screen. Check red subpixels for dead or stuck pixels, use a dim red night light that keeps your night vision, or set a red mood light.',
	'intro'        => 'Fill your whole screen with solid red in one click. Use it to check the red subpixels of a monitor or phone, as a dim red light that keeps your eyes adjusted to the dark, or as a simple red mood light or signal.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'colour-screen' ),
	'scripts'      => array( 'colour-screen' ),
	'embed_height' => 480,
	'tool'         => $tool(
		'red',
		array(
			'#ff0000' => 'Pure red',
			'#cc0000' => 'Red 80%',
			'#800000' => 'Maroon 50%',
			'#400000' => 'Night red 25%',
			'#dc143c' => 'Crimson',
			'#ff4d4d' => 'Light red',
			'#ff8080' => 'Soft red',
		),
		'Lower your screen brightness for a night light, or raise it for a pixel check.'
	),
	'howto'        => array(
		'Press <strong>Open full red screen</strong>. The whole screen turns red and the mouse pointer hides after a moment.',
		'For a pixel check, use <strong>Pure red</strong> at full brightness. For a night light, pick <strong>Night red</strong> or <strong>Maroon</strong> and turn the brightness down.',
		'Set <strong>Auto close</strong> if you leave the screen on as a light, so it switches off on its own.',
		'Press <strong>Esc</strong>, or tap the screen on a phone, to come back to this page.',
	),
	'howto_title'  => 'How to use the red screen',
	'results'      => '<p>Pure red (#FF0000) lights only the red subpixel in every pixel. The green and blue subpixels are off, so a red screen tests one channel on its own. A healthy panel shows one even red from corner to corner. Look for:</p>
<ul>
<li><strong>A black dot</strong>: the red subpixel there is dead or stuck off. If the same spot is also black on the <a href="/white-screen/">white screen</a>, the whole pixel is dead.</li>
<li><strong>A green, blue or white dot</strong>: a green or blue subpixel is stuck on. The <a href="/stuck-pixel-fixer/">stuck pixel fixer</a> can sometimes revive it.</li>
<li><strong>Darker or orange-looking areas</strong>: uneven backlight or a colour shift across the panel. Some fall-off at the edges is normal on LCDs.</li>
</ul>
<p>For a full check of all three colour channels in one go, run the <a href="/dead-pixel-test/">dead pixel test</a>, which steps through red, green, blue and more.</p>',
	'extra'        => array(
		array(
			'What a red screen is used for',
			'<p><strong>Night vision light.</strong> Your eyes adapt to the dark mostly through rod cells, which are barely sensitive to deep red light. A dim red screen lets you read a star chart, find your way or check on a sleeping child without losing your dark adaptation. Astronomers and sailors use red light for exactly this. Pick <strong>Night red</strong> and set the brightness as low as it goes.</p>
<p><strong>Pixel and colour checks.</strong> Because a red screen uses one subpixel only, it shows faults that a white screen can hide, such as a single dead red subpixel or a tint in one corner. Repeat on the <a href="/green-screen/">green</a> and <a href="/blue-screen/">blue</a> screens to cover all three channels.</p>
<p><strong>Mood light and signals.</strong> A red tablet or monitor makes a quick party or photo light, a "recording" or "do not disturb" sign outside a door, or a stop signal in a game.</p>
<p><strong>Evening use.</strong> Red light has less effect on your body clock than white or blue light at the same brightness, so a dim red screen is a gentler choice late at night than a bright white one.</p>',
			'uses',
		),
	),
	'fixes'        => array(
		array( 'The red looks orange or pink', 'Turn off night mode, Night Shift or blue light filters, and set the monitor to its standard or sRGB picture mode. Vivid modes and a wrong colour profile push pure red towards orange or pink.' ),
		array( 'The red is too bright to use as a night light', 'Choose Night red (25%) and lower the screen brightness to the minimum. On a phone, also turn on the accessibility "reduce white point" or extra dim option for an even darker red.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not let websites go fully full screen, so the red fills the browser window instead. Rotate to landscape or add the page to your home screen for the cleanest view.' ),
	),
	'faq'          => array(
		array( 'How do I make my screen completely red?', 'Open this page and press "Open full red screen". The browser fills the entire screen with pure red (#FF0000). Press Esc or tap to exit.' ),
		array( 'Why do astronomers use red light?', 'The rod cells that give you night vision are almost blind to deep red, so dim red light lets you see nearby things without undoing the 20-30 minutes your eyes need to adapt to the dark.' ),
		array( 'Can a red screen find dead pixels?', 'Yes. Red lights only the red subpixels, so a dead red subpixel shows as a black dot and a stuck green or blue one shows as a coloured dot. Check green and blue too for a full test.' ),
		array( 'Is red light better for sleep?', 'Dim red light affects your body clock less than bright white or blue light, so it is a gentler night light. Any bright light late at night can still keep you awake, so keep it dim.' ),
		array( 'Can I choose a different shade of red?', 'Yes. Pick crimson, light red, soft red or the darker 80%, 50% and 25% reds. You can switch shades while in full screen by going back and choosing another swatch.' ),
		array( 'Is this red screen free?', 'Yes. It runs entirely in your browser, has no ads inside the full screen and nothing is downloaded or uploaded.' ),
	),
	'related'      => array( 'green-screen', 'blue-screen', 'dead-pixel-test', 'stuck-pixel-fixer', 'orange-screen', 'black-screen' ),
	'updated'      => '2026-10-28',
);
