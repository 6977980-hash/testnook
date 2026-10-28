<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Dead Pixel Test',
	'seo_title'    => 'Dead Pixel Test: Check Your Monitor or Phone Screen',
	'description'  => 'Free dead pixel test for monitors, laptops, TVs and phones. Cycle full-screen colours to spot dead, stuck and hot pixels in seconds. Works in any browser.',
	'intro'        => 'Fill your screen with solid colours one after another and look for tiny dots that do not match. It is the quickest way to check a new monitor, laptop or phone for dead or stuck pixels.',
	'device'       => 'any',
	'ads'          => 'none',
	'styles'       => array( 'dead-pixel-test' ),
	'scripts'      => array( 'dead-pixel-test' ),
	'embed_height' => 520,
	'tool'         => '<div class="tool-bar">
	<button type="button" class="btn btn-primary" id="dp-start">Start full-screen test</button>
	<label class="dp-auto"><input type="checkbox" id="dp-auto"> Auto-advance every 3 seconds</label>
</div>
<div class="tool-stage dp-stage">
	<p class="dp-pick">Or start from a colour:</p>
	<div class="dp-swatches" id="dp-swatches"></div>
	<p class="dp-keys">In full screen: <kbd>click</kbd> / <kbd>tap</kbd> / <kbd>&rarr;</kbd> next colour, <kbd>&larr;</kbd> previous, <kbd>Esc</kbd> exit.</p>
</div>
<div class="dp-screen" id="dp-screen" hidden><div class="dp-hint" id="dp-hint"></div></div>
<p class="tool-status" id="dp-status" aria-live="polite">Clean your screen first so dust is not mistaken for a pixel.</p>',
	'howto'        => array(
		'Wipe the screen with a dry microfibre cloth so specks of dust do not fool you.',
		'Press <strong>Start full-screen test</strong>. The whole screen turns black.',
		'Look slowly across the screen from about 30-50 cm away. Then <strong>click</strong>, <strong>tap</strong> or press the <strong>right arrow</strong> for the next colour: white, red, green, blue, cyan, magenta, yellow and grey.',
		'On each colour, look for a dot that is a different colour from the rest. Note where it is and on which background it shows.',
		'Press <strong>Esc</strong> (or tap through all colours on a phone) to leave full screen.',
	),
	'howto_title'  => 'How to check for dead pixels',
	'results'      => '<p>A healthy screen shows every colour perfectly evenly. If you find a dot, the background it shows on tells you what kind of fault it is:</p>
<div class="table-scroll"><table>
<thead><tr><th>What you see</th><th>Type</th><th>Can it be fixed?</th></tr></thead>
<tbody>
<tr><td>Black dot on white and on every colour</td><td>Dead pixel</td><td>Rarely. The transistor gets no power.</td></tr>
<tr><td>Bright red, green or blue dot on black</td><td>Stuck pixel (one sub-pixel always on)</td><td>Often. Try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>.</td></tr>
<tr><td>White dot on black</td><td>Hot pixel (all sub-pixels on)</td><td>Sometimes, with the stuck pixel fixer.</td></tr>
<tr><td>Dot missing only on red, green or blue</td><td>Dead sub-pixel</td><td>Rarely.</td></tr>
</tbody></table></div>
<p>A dot that moves when you wipe the screen is dust. A cloudy patch rather than a sharp dot is backlight bleed or pressure damage, not a pixel fault.</p>',
	'extra'        => array(
		array(
			'Dead pixel test for monitors, laptops and phones',
			'<p>The same test works on any screen: an office monitor, a gaming monitor, a laptop, a TV through a browser, a tablet or a phone. On a phone, tap anywhere to change colour; the page uses a full-window mode where the browser cannot go fully full screen. Turn screen brightness up to make faults easier to see, and on OLED phones look at the black screen closely, because a stuck sub-pixel glows clearly against true black.</p>
<p>Check a new device as soon as it arrives. Most shops and manufacturers only accept pixel complaints inside the return period, and many have a "pixel policy" that allows a few faulty pixels before they will swap the screen. A screenshot will not show the fault, so take a photo of the dot with your phone as evidence.</p>',
			'any-screen',
		),
	),
	'fixes'        => array(
		array( 'I found a coloured dot that is always on', 'That is a stuck pixel, and it can often be revived. Run our stuck pixel fixer over the spot for 10-20 minutes. Gently massaging the spot through a soft cloth while the screen is on can also help, but never press hard.' ),
		array( 'I found a black dot on every colour', 'A truly dead pixel usually cannot be repaired at home. If the device is new, contact the seller or manufacturer and quote their dead pixel policy. Include a photo of the dot on the white screen.' ),
		array( 'Full screen does not work on my iPhone', 'iPhone Safari does not allow web pages to go fully full screen, so the test fills the browser window instead. Rotate to landscape and scroll so the address bar shrinks, or add the page to your home screen for a cleaner view.' ),
	),
	'faq'          => array(
		array( 'How do I check my screen for dead pixels?', 'Start the full-screen test and look carefully at each solid colour. Any dot that does not match the background is a dead, stuck or hot pixel.' ),
		array( 'What is the difference between a dead pixel and a stuck pixel?', 'A dead pixel stays black because it gets no power. A stuck pixel is stuck on one colour, usually red, green or blue. Stuck pixels can often be fixed; dead pixels usually cannot.' ),
		array( 'Can dead pixels spread?', 'A single dead pixel normally does not spread. If you see more appearing over time, the panel may be failing or damaged by pressure, and you should contact the manufacturer.' ),
		array( 'Is one dead pixel acceptable?', 'It depends on the manufacturer. Many follow the ISO 9241-307 class system, which allows a small number of faulty pixels. Some brands offer a zero dead pixel guarantee. Check the policy and your return window.' ),
		array( 'Does this dead pixel test work on phones?', 'Yes. It works on Android and iPhone. Tap to change colour. On iPhone the test fills the browser window, as Safari does not allow full screen for web pages.' ),
		array( 'Can a dead pixel test damage my screen?', 'No. It only shows still, solid colours, the same as any image. It does not flash, so it is safe to use for as long as you like.' ),
	),
	'related'      => array( 'stuck-pixel-fixer', 'refresh-rate-test', 'white-screen', 'black-screen', 'burn-in-test', 'touch-screen-test', 'fps-test' ),
	'updated'      => '2026-10-28',
);
