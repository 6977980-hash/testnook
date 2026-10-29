<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

return array(
	'title'          => 'Display Test',
	'seo_title'      => 'Display Test: Check Any Screen for Colour and Sharpness',
	'description'    => 'Free display test for laptops, TVs, tablets and phones. Full-screen colours, colour bars, gradients, a sharpness chart and a geometry grid check any screen.',
	'intro'          => 'A quick health check for any display: a laptop screen, a TV, a tablet, a phone or a projector. Twelve full-screen patterns check pixels, colours, smooth gradients, black and white detail, sharpness and whether the picture fits the screen.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test' ),
	'scripts'        => array( 'monitor-test' ),
	'embed_height'   => 620,
	'tool'           => $patterns(
		array(
			'white',
			'black',
			'red',
			'green',
			'blue',
			'color-bars',
			'gradient',
			'rgb-gradients',
			'black-level',
			'white-level',
			'sharpness',
			'grid' => array( 'Grid and overscan', 'All four green edge lines must be visible. If an edge is cut off, the display is overscanning or scaling: set the TV picture size to Just Scan, Screen Fit or 1:1, or turn off overscan in the graphics settings.' ),
		),
		'Start full-screen display test',
		'On a TV or projector, open this page in its browser or from a computer connected to it.'
	),
	'howto'          => array(
		'Open this page on the display you want to check: in the laptop, tablet or phone browser, the TV\'s own browser, or on a computer connected to the TV or projector.',
		'Turn off night mode, blue light filters and dynamic or vivid picture modes for a fair result.',
		'Press <strong>Start full-screen display test</strong>. Tap, click or use the arrow keys to move through the 12 patterns.',
		'Read the tip on each pattern. Most faults show on the solid colours (pixels), the gradients (banding) and the grid (picture not fitting the screen).',
	),
	'howto_title'    => 'How to test a display',
	'results'        => '<p>A good display shows clean solid colours with no odd dots, gradients without steps, every square on the black and white level patterns, crisp single-pixel lines and all four edges of the grid.</p>
<ul>
<li><strong>Odd dots on a colour:</strong> dead or stuck pixels. Check them on the <a href="/dead-pixel-test/">dead pixel test</a> and try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>.</li>
<li><strong>Steps in the gradients:</strong> banding from a low bit-depth panel, a video mode with fewer colours, or a heavy picture mode.</li>
<li><strong>Missing dark or bright squares:</strong> brightness or contrast set wrongly; see <a href="/monitor-calibration/">monitor calibration</a>.</li>
<li><strong>Blurry or fringed text:</strong> the display is not at its native resolution, or sharpness is set too high or too low.</li>
<li><strong>Grid edges missing:</strong> overscan. The display is cropping the picture and scaling it, which also softens it.</li>
</ul>',
	'extra'          => array(
		array(
			'Testing a TV or projector',
			'<p>Smart TVs have a browser, usually called Internet or Web Browser, that can open this page directly. Otherwise connect a laptop by HDMI and set it to the TV\'s native resolution (usually 1920 x 1080 or 3840 x 2160). Pick a picture mode called Movie, Cinema, Filmmaker or Calibrated for the most accurate colours, and set the picture size to Just Scan or Screen Fit so the grid edges are visible. Projectors also show focus problems on the sharpness pattern and keystone distortion on the grid, where the circles turn into eggs.</p>',
			'tv-projector',
		),
		array(
			'Laptop and phone displays',
			'<p>Laptop screens are often set to 125% or 150% scaling, which is fine for daily use but makes the single-pixel patterns look uneven; that is the scaling, not the panel. Phones and tablets cannot always go fully full screen in the browser: rotate to landscape, or add the page to the home screen. For specific checks, use the <a href="/touch-screen-test/">touch screen test</a> for touch dead zones, the <a href="/screen-resolution/">screen resolution</a> page for the real pixel count, and the <a href="/refresh-rate-test/">refresh rate test</a> for the hertz.</p>',
			'laptop-phone',
		),
	),
	'fixes'          => array(
		array( 'Colours look too strong or too blue', 'Switch off Vivid, Dynamic or Sports picture modes and choose Standard, Movie or sRGB. On phones, choose the Natural or Standard screen mode, and check that night light or eye comfort is off while testing.' ),
		array( 'Text looks soft on a laptop or monitor', 'Set the display to its recommended (native) resolution and use the system scaling setting to make things bigger instead. On Windows, run ClearType Text Tuner for sharper text.' ),
		array( 'The picture does not fill the TV or is cut off', 'In the TV picture settings set Picture size or Aspect ratio to Just Scan, Screen Fit, Full Pixel or 1:1. On a PC with AMD or Intel graphics, also check the overscan / underscan slider in the graphics settings.' ),
	),
	'faq'            => array(
		array( 'How do I test my display?', 'Open this page on the display and press Start. Look at each of the 12 full-screen patterns and read the tip: solid colours for pixel faults, gradients for banding, level patterns for brightness and contrast, and the grid for overscan.' ),
		array( 'What is the difference between a display test and a monitor test?', 'This display test is a shorter set aimed at any screen, including TVs, laptops and phones. The <a href="/monitor-test/">monitor test</a> adds gamma, inversion and smearing patterns for PC monitors.' ),
		array( 'Can I test a TV display online?', 'Yes. Open the page in the TV\'s browser, or connect a laptop by HDMI at the TV\'s native resolution and open it there.' ),
		array( 'Why does the grid show only three edges?', 'The display is overscanning, which crops the picture slightly. Set the picture size to Just Scan, Screen Fit or 1:1 to see every pixel.' ),
		array( 'Does this display test work on iPhone and Android?', 'Yes. Tap to move to the next pattern. iPhone Safari cannot go fully full screen, so turn the phone sideways and the patterns fill the browser window.' ),
		array( 'Is it safe for my screen?', 'Yes. The patterns are still images that do not flash. They are safe on LCD, OLED, plasma and projector displays.' ),
	),
	'related'        => array( 'monitor-test', 'dead-pixel-test', 'touch-screen-test', 'screen-resolution', 'oled-test', 'lcd-test', 'monitor-color-test', 'refresh-rate-test' ),
	'updated'        => '2026-10-29',
);
