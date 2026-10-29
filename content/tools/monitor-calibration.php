<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

return array(
	'title'          => 'Monitor Calibration',
	'seo_title'      => 'Monitor Calibration Online: Set Brightness, Contrast, Gamma',
	'description'    => 'Calibrate your monitor online in six steps without a colorimeter: brightness, contrast, gamma, color temperature and sharpness, using full-screen patterns.',
	'intro'          => 'Get your screen close to correct by eye, without any hardware. Six guided steps use full-screen test patterns to set brightness, contrast, gamma, color temperature and sharpness in your monitor\'s own menu, then a final check with natural colors.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test' ),
	'scripts'        => array( 'monitor-test' ),
	'embed_height'   => 620,
	'tool'           => $patterns(
		array(
			'black-level'   => array( 'Brightness', 'Step 1: adjust the monitor\'s Brightness (or Black level) until squares 3 or 4 and up are just visible and the background stays pure black. Too bright: the background turns gray. Too dark: the low squares vanish.' ),
			'white-level'   => array( 'Contrast', 'Step 2: raise Contrast until white is bright, then back off until you can tell the 254 to 250 squares apart from the background. If they melt into white, contrast is too high.' ),
			'gamma'         => array( 'Gamma', 'Step 3: step back or squint. The solid square should blend into the stripes in the 2.2 column. If it blends at 2.0 or below, choose a higher gamma setting in the monitor menu; at 2.4 or above, a lower one.' ),
			'gradient'      => array( 'Color temperature', 'Step 4: the gray ramp should look neutral all the way, with no pink, green or blue cast. Set Color temperature to 6500K, Normal or sRGB; if it still looks tinted, adjust the RGB gain sliders a few steps.' ),
			'sharpness'     => array( 'Sharpness', 'Step 5: lower Sharpness until there are no bright or dark halos around the lines and text, but they still look crisp. On many monitors the right value is the default (0, 50 or 10).' ),
			'checker'       => array( 'Final check', 'Step 6: skin tones should look natural and the gray row neutral. If everything looks right, you are done. If not, go back to the step that looks wrong.' ),
		),
		'Start calibration (step 1)',
		'Warm the monitor up for 15 minutes and reset its picture settings before you start.'
	),
	'howto'          => array(
		'Let the monitor run for 15-30 minutes so its brightness and color settle. Set it to its native resolution and the browser zoom to 100% (<strong>Ctrl + 0</strong> / <strong>Cmd + 0</strong>).',
		'Open the monitor\'s on-screen menu with the buttons on the monitor. Choose the Standard, User or sRGB picture mode and turn off dynamic contrast, eco modes and blue light filters.',
		'Press <strong>Start calibration</strong>. Each step shows the pattern and a tip at the bottom. Change one setting in the monitor menu, then look again.',
		'Move to the next step with a click, tap or the right arrow. Repeat steps 1 and 2 once more at the end, because brightness and contrast affect each other.',
		'Calibrate in the lighting you normally work in. A screen set up at night will look dim in the day.',
	),
	'howto_title'    => 'How to calibrate your monitor',
	'results'        => '<p>After calibration a screen should show deep blacks that still have shadow detail, bright whites without lost highlights, mid-tones that are neither washed out nor too dark (gamma 2.2), neutral grays and crisp text without halos. Typical good settings:</p>
<div class="table-scroll"><table>
<thead><tr><th>Setting</th><th>Target</th><th>Typical value</th></tr></thead>
<tbody>
<tr><td>Brightness</td><td>Squares from 3-4 visible on black</td><td>About 120 cd/m² for office light; often 20-40% on a modern monitor</td></tr>
<tr><td>Contrast</td><td>254-250 visible on white</td><td>Often the default (50, 70 or 75)</td></tr>
<tr><td>Gamma</td><td>2.2</td><td>Gamma 2, Mode 2 or 2.2 in the menu</td></tr>
<tr><td>Color temperature</td><td>6500K (D65)</td><td>Normal, Standard, 6500K or sRGB</td></tr>
<tr><td>Sharpness</td><td>No halos</td><td>Default or lower</td></tr>
</tbody></table></div>',
	'extra'          => array(
		array(
			'Calibrating with Windows and Mac tools',
			'<p>Not every monitor has a gamma or RGB setting; laptops have almost none. The operating system can help. On <strong>Windows</strong>, search for <em>Calibrate display color</em> (dccw.exe): it walks through gamma, brightness, contrast and color balance and saves a profile. On a <strong>Mac</strong>, open System Settings > Displays > Color profile > Customize > + to make a profile; hold Option for expert mode with gamma and white point. Use our patterns to check the result.</p>',
			'os-tools',
		),
		array(
			'When you need a hardware calibrator',
			'<p>Calibrating by eye gets brightness, contrast, gamma and a roughly neutral white right, which is all most people need for games, films and office work. For photo editing, print matching or video grading, use a colorimeter such as a Calibrite or Datacolor Spyder with its software or DisplayCAL. It measures the screen and builds an exact profile. Check the result with the <a href="/monitor-color-test/">monitor color test</a>, and run the <a href="/monitor-test/">monitor test</a> to check the panel for faults that calibration cannot fix.</p>',
			'hardware-calibrator',
		),
	),
	'fixes'          => array(
		array( 'My monitor has no gamma setting', 'Use the Windows Calibrate display color tool or a custom profile on a Mac to correct gamma. Some monitors call it Gamma Mode, Picture Mode or put it under Advanced; on others the sRGB mode fixes gamma at about 2.2.' ),
		array( 'I cannot see the low squares at any brightness', 'Check that the graphics card and monitor agree on RGB range: on HDMI, set both to Full (or both to Limited). Turn off dynamic contrast, black stabilizer and eco modes, which change the dark levels by themselves.' ),
		array( 'Colors look different after calibration', 'That is normal: most screens ship too blue and too bright. Your eyes adapt in a day or two. If colors look clearly wrong, reset the monitor and redo step 4 with 6500K.' ),
	),
	'faq'            => array(
		array( 'Can I calibrate my monitor online?', 'Yes, for the settings your eyes can judge: brightness, contrast, gamma, color temperature and sharpness. You change them in the monitor\'s menu while looking at our test patterns.' ),
		array( 'What is the best brightness for a monitor?', 'Bright enough that white matches a sheet of paper in your room. That is about 100-140 cd/m² in a normal office, often 20-40% brightness on a modern monitor. Use the black level step to make sure shadows stay visible.' ),
		array( 'What gamma should my monitor use?', '2.2. It is the standard for Windows, macOS, the web and games. Use 2.4 only for video work in a dark room.' ),
		array( 'Should I use 6500K color temperature?', 'Yes, 6500K (D65) is the standard white point for sRGB, the web and video. Warmer settings are easier on the eyes at night but make whites look yellow.' ),
		array( 'How often should I calibrate?', 'Once when you set the monitor up, and again every few months or after changing the room lighting. Hardware calibration for color work is usually repeated every month.' ),
		array( 'Can I calibrate a laptop screen?', 'Yes, with brightness on the keyboard and the operating system tools for gamma and color balance. Laptop screens usually have no menu, so use the Windows or Mac calibration tool and check with these patterns.' ),
	),
	'related'        => array( 'monitor-color-test', 'monitor-test', 'display-test', 'lcd-test', 'refresh-rate-test', 'dead-pixel-test', 'oled-test', 'grey-screen' ),
	'updated'        => '2026-10-29',
);
