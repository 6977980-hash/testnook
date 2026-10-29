<?php
defined( 'ABSPATH' ) || exit;

$patterns = require __DIR__ . '/_monitor-patterns.php';

// One guided step: number, name, what to look for, the patterns it opens (first one is shown) and pass/problem buttons.
$step = function ( $n, $id, $name, $look, $open_label, $first_pattern, $extra = '' ) {
	$open = $first_pattern ? '<button type="button" class="btn btn-sm btn-primary" data-mc-open="' . $first_pattern . '">' . $open_label . '</button>' : '';
	return '<li class="mc-step" data-mc-step="' . $id . '">
		<div class="mc-head"><span class="mc-num">' . $n . '</span><h2 class="mc-name">' . $name . '</h2><span class="mc-state" data-mc-state>Not checked</span></div>
		<p class="mc-look">' . $look . '</p>
		<div class="btn-row">' . $open . $extra . '
			<span class="seg" role="group" aria-label="' . $name . ' result">
				<button type="button" data-mc-result="pass" aria-pressed="false">Looks fine</button>
				<button type="button" data-mc-result="problem" aria-pressed="false">Problem</button>
			</span>
		</div>
		<label class="visually-hidden" for="mc-note-' . $id . '">' . $name . ' note</label>
		<input type="text" class="mc-note" id="mc-note-' . $id . '" data-mc-note placeholder="Note (optional), e.g. bright dot near top left" hidden>
	</li>';
};

return array(
	'title'          => 'Guided Monitor Check',
	'seo_title'      => 'Guided Monitor Check: 5-Step Test for a New or Used Monitor',
	'description'    => 'Check a new or used monitor in five guided steps: dead pixels, uniformity, gradient banding, text sharpness and refresh rate, then copy a short summary.',
	'intro'          => 'Checking a monitor you just bought, or one you are about to buy second hand? Work through these five steps in order. Each one opens the right full-screen patterns, tells you what to look for and lets you mark it fine or a problem; at the end you get a summary to copy into a message, a return request or a listing.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'monitor-test', 'monitor-check' ),
	'scripts'        => array( 'monitor-test', 'monitor-check' ),
	'embed_height'   => 900,
	'tool'           => '<ol class="mc-steps" id="mc-steps">
	' . $step( 1, 'pixels', 'Dead and stuck pixels', 'Black, white, red, green and blue fill the screen in turn. Look for any dot that does not match: black dots are dead pixels, colored or bright dots are stuck pixels. On black, also look for light leaking in at the edges.', 'Show color screens', 'black' ) . '
	' . $step( 2, 'uniformity', 'Uniformity and burn-in', 'A 50% gray, then a dark gray. The screen should look even from corner to corner. Darker corners, cloudy patches or a dirty-screen look are uniformity faults; faint shapes of a taskbar or icons are burn-in.', 'Show gray screens', 'grey50' ) . '
	' . $step( 3, 'gradient', 'Gradients and banding', 'A gray gradient, then color gradients. The fades should be smooth. Visible steps or stripes (banding) point to a low bit-depth mode, a color profile or a poor cable or connection mode.', 'Show gradients', 'gradient' ) . '
	' . $step( 4, 'sharpness', 'Text sharpness', 'Fine lines, checkers and text at 100% browser zoom. They should be crisp. Halos around lines mean the sharpness setting is too high; blurry or fringed text means the resolution is not native or scaling is on.', 'Show sharpness pattern', 'sharpness' ) . '
	' . $step( 5, 'refresh', 'Refresh rate', 'Measures how often the browser draws a frame, which follows the monitor\'s refresh rate. Compare it with the monitor\'s spec, such as 60, 144 or 240 Hz. Keep the page in front and the mouse still while it runs.', '', '', '<button type="button" class="btn btn-sm btn-primary" id="mc-hz-run">Measure refresh rate</button><span class="mc-hz" id="mc-hz" aria-live="polite"></span>' ) . '
</ol>
<div class="mc-summary">
	<label for="mc-summary"><strong>Summary</strong> (updates as you go)</label>
	<textarea id="mc-summary" rows="8" readonly></textarea>
	<div class="btn-row"><button type="button" class="btn btn-sm" data-tn-copy="#mc-summary">Copy summary</button><button type="button" class="btn btn-sm" id="mc-reset">Start over</button></div>
</div>
<div class="mc-all">
	<h2 class="mc-all-title">All ten patterns</h2>
	' . $patterns(
		array( 'black', 'white', 'red', 'green', 'blue', 'grey50', 'grey20', 'gradient', 'rgb-gradients', 'sharpness' ),
		'Run all patterns in full screen',
		'Set the monitor to its native resolution and the browser zoom to 100% first.'
	) . '
</div>',
	'howto'          => array(
		'Let the monitor warm up for 10-15 minutes, set it to its native resolution and press <strong>Ctrl + 0</strong> (<strong>Cmd + 0</strong> on a Mac) so the browser zoom is 100%.',
		'Open this page on the monitor you are checking, dim the room lights a little and wipe the screen with a dry cloth.',
		'For steps 1 to 4, press the step\'s button. The patterns open in full screen with a tip; click, tap or press the right arrow for the next one and <kbd>Esc</kbd> to come back.',
		'Mark each step <strong>Looks fine</strong> or <strong>Problem</strong>. For a problem, type where you saw it, for example "two bright dots, top left".',
		'Run the refresh rate step, then press <strong>Copy summary</strong> and paste it wherever you need it.',
	),
	'howto_title'    => 'How to check a monitor step by step',
	'results'        => '<div class="table-scroll"><table>
<thead><tr><th>Step</th><th>Usually fine</th><th>Worth acting on</th></tr></thead>
<tbody>
<tr><td>Dead and stuck pixels</td><td>No odd dots, or one you only find when searching</td><td>Dots you notice in normal use, or more than the brand\'s pixel policy allows</td></tr>
<tr><td>Uniformity and burn-in</td><td>Slightly dimmer corners, light glow at an angle on IPS</td><td>Clear clouds or bands on gray, any burn-in on a used screen</td></tr>
<tr><td>Gradients and banding</td><td>Faint steps only in the darkest part</td><td>Clear stripes across the whole fade</td></tr>
<tr><td>Text sharpness</td><td>Crisp lines at native resolution</td><td>Blur or halos that stay after fixing resolution, zoom and the sharpness setting</td></tr>
<tr><td>Refresh rate</td><td>Within 1-2 Hz of the spec</td><td>Far below the spec: check the cable, the port and the Windows or macOS refresh setting</td></tr>
</tbody></table></div>
<p>A problem in one step rarely means the whole monitor is bad. Note which step showed it and read the matching fix below before you decide on a return.</p>',
	'extra'          => array(
		array(
			'When to run this check',
			'<p>On the day a new monitor arrives, while you are still inside the shop\'s return window: dead pixels, bleed and uneven backlight are the usual reasons for a swap. When buying second hand, ask the seller to open this page on the screen and send you the copied summary, or run it yourself when you collect the monitor; burn-in and banding are easy to miss in a quick look. For the full set of 16 patterns use the <a href="/monitor-test/">monitor test</a>, and for a deeper motion check the <a href="/refresh-rate-test/">refresh rate test</a> and <a href="/ufo-test/">UFO test</a>. Our guide on <a href="/how-to-test-a-used-monitor/">how to test a used monitor</a> covers what to ask the seller.</p>',
			'when',
		),
	),
	'fixes'          => array(
		array( 'The refresh rate reads 60 Hz on a 144 Hz monitor', 'Windows: Settings > System > Display > Advanced display, choose the highest refresh rate. Mac: System Settings > Displays > Refresh Rate. Use DisplayPort or an HDMI 2.0 or newer cable and port; older HDMI often stops at 60 Hz at high resolutions. On iPhone and iPad Safari, the browser may be held near 60 fps.' ),
		array( 'I found a stuck pixel', 'A stuck (colored) pixel sometimes recovers. Try the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a> for 10-20 minutes. A dead (black) pixel cannot be fixed in software; check the brand\'s pixel policy for a swap.' ),
		array( 'Text looks blurry', 'Set the native resolution, the browser zoom to 100% and display scaling to 100% if you can, then lower the monitor\'s sharpness setting to its default. On a TV, choose Game or PC mode.' ),
		array( 'Gradients show bands', 'Check the graphics driver outputs full color (8 bpc or more, full range), remove custom color profiles and try another cable. See the fixes on the <a href="/monitor-test/">monitor test</a>.' ),
	),
	'faq'            => array(
		array( 'How do I check a used monitor before buying?', 'Open this page on it, run the five steps and look hardest at black (bleed and stuck pixels) and 50% gray (burn-in and clouding). The copied summary is a quick record of what you checked.' ),
		array( 'How long does the guided check take?', 'About five minutes. The refresh rate step takes two seconds; spend most of the time on the color and gray screens.' ),
		array( 'Is anything uploaded?', 'No. The patterns are drawn in your browser and the summary stays on your device until you copy it.' ),
		array( 'What is the difference from the monitor test?', 'The monitor test shows 16 patterns for a full inspection. This check picks the ten that catch the most common faults, puts them in order, adds a refresh rate measurement and gives you a summary.' ),
		array( 'Why does the refresh rate step show less than my monitor\'s spec?', 'The browser draws at the refresh rate the system runs, which may not be the highest the monitor supports. Battery saving, a background tab or a busy computer can also lower it. See the fixes above.' ),
		array( 'Does it work on a laptop, TV or phone?', 'Yes. It runs in any modern browser. On a TV also check that the edges of the patterns are not cut off (overscan).' ),
	),
	'related'        => array( 'monitor-test', 'dead-pixel-test', 'refresh-rate-test', 'ufo-test', 'stuck-pixel-fixer', 'burn-in-test', 'lcd-test', 'oled-test' ),
	'updated'        => '2026-10-29',
);
