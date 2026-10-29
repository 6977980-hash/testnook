<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mouse Accuracy Test',
	'seo_title'      => 'Mouse Accuracy Test: Aim Trainer With Hit Rate and Speed',
	'description'    => 'Free mouse accuracy test and aim trainer. Click 30 targets as fast and precisely as you can and get your accuracy, time per target, offset and aim bias.',
	'intro'          => 'How precise is your aim? Click 30 targets that pop up at random spots. The test measures your hit rate, how long each target takes, how far from the centre you click, and whether your clicks drift to one side, which can point to sensitivity that is too high or a mouse sensor problem.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. It works with touch too, but compare touch scores only with other touch scores.',
	'ads'            => 'content',
	'stats'          => array( 'aim-static-28', 'aim-shrink-28' ),
	'styles'         => array( 'mouse-accuracy-test' ),
	'scripts'        => array( 'mouse-accuracy-test' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-bar ma-opts">
	<div class="seg" role="group" aria-label="Mode">
		<button type="button" data-ma-mode="static" aria-pressed="true">Static</button>
		<button type="button" data-ma-mode="shrink" aria-pressed="false">Shrinking</button>
	</div>
	<div class="seg" role="group" aria-label="Target size">
		<button type="button" data-ma-size="40" aria-pressed="false">Large</button>
		<button type="button" data-ma-size="28" aria-pressed="true">Medium</button>
		<button type="button" data-ma-size="16" aria-pressed="false">Small</button>
	</div>
</div>
<div class="tool-stage ma-stage" id="ma-stage">
	<div class="ma-intro" id="ma-intro">
		<button type="button" class="btn btn-primary" id="ma-go">Start: 30 targets</button>
		<p>Click the centre of each target as quickly as you can. Clicks outside the target count as misses.</p>
	</div>
	<div class="ma-target" id="ma-target" hidden></div>
</div>
<div class="ma-result">
	<div class="stats">
		<div class="stat"><span class="stat-label">Targets left</span><span class="stat-value" id="ma-left">30</span></div>
		<div class="stat"><span class="stat-label">Accuracy</span><span class="stat-value" id="ma-acc">-</span></div>
		<div class="stat"><span class="stat-label">Time per target</span><span class="stat-value" id="ma-time">-</span></div>
		<div class="stat"><span class="stat-label">From centre</span><span class="stat-value" id="ma-dist">-</span></div>
		<div class="stat"><span class="stat-label">Score</span><span class="stat-value" id="ma-score">-</span></div>
		<div class="stat"><span class="stat-label">Best score</span><span class="stat-value" id="ma-best">-</span></div>
	</div>
	<div class="ma-plot-wrap"><canvas class="ma-plot" id="ma-plot" aria-label="Where your clicks landed relative to the target centre"></canvas>Where you clicked (green = hit)</div>
</div>
<p class="tool-status" id="ma-status" aria-live="polite">Pick a mode and size, then press Start.</p>',
	'howto'          => array(
		'Choose <strong>Static</strong> (targets wait until you hit them) or <strong>Shrinking</strong> (each target shrinks and vanishes after 1.6 seconds), and a target size.',
		'Press <strong>Start</strong>. A target appears at a random spot.',
		'Move to it and click its centre as fast as you can. Every click outside a target is a miss.',
		'After 30 targets you get your accuracy, average time per target, average distance from the centre and a score. Your best score is saved in this browser for each mode and size.',
		'Check the dot plot: if most dots sit on one side of the centre, you consistently over- or under-shoot in that direction.',
	),
	'howto_title'    => 'How to take the mouse accuracy test',
	'results'        => '<p><strong>Accuracy</strong> is hits divided by all clicks. <strong>Time per target</strong> is from the moment a target appears to your hit. <strong>From centre</strong> is how far your hits land from the exact centre, in pixels. The <strong>score</strong> rewards all three, so racing with many misses scores lower than steady, precise clicking.</p>
<div class="table-scroll"><table>
<thead><tr><th>Medium targets, static</th><th>Accuracy</th><th>Time per target</th></tr></thead>
<tbody>
<tr><td>Beginner</td><td>Under 80%</td><td>Over 900 ms</td></tr>
<tr><td>Average</td><td>80-90%</td><td>650-900 ms</td></tr>
<tr><td>Good</td><td>90-95%</td><td>500-650 ms</td></tr>
<tr><td>Excellent</td><td>Over 95%</td><td>Under 500 ms</td></tr>
</tbody></table></div>
<p>These ranges are rough guides from typical mouse users on a desktop screen; your numbers also depend on screen size, mouse sensitivity and whether you use a touchpad. Compare yourself with your own earlier scores.</p>',
	'extra'          => array(
		array(
			'Improve your mouse accuracy',
			'<p>Most aim problems come from sensitivity that is too high. If you often overshoot targets, lower the mouse DPI or the in-game sensitivity a little and play again. Turn off "Enhance pointer precision" in Windows mouse settings for games: it adds acceleration, so the same hand movement moves the pointer different distances depending on speed. Use a mouse pad with an even surface, keep your wrist relaxed and move from the elbow for long flicks. Practise accuracy first, then speed: speed follows once the movement is consistent.</p>',
			'improve',
		),
		array(
			'Is it me or the mouse?',
			'<p>If the pointer jumps, stutters or drifts on its own, the sensor may be dirty or the surface may not suit it. Measure your real DPI with the <a href="/dpi-analyzer/">DPI analyzer</a>, check how often the mouse reports with the <a href="/mouse-polling-rate-test/">polling rate test</a>, and see whether the cursor lags with the <a href="/mouse-latency-test/">mouse latency test</a>. To test reflexes rather than aim, try the <a href="/reaction-time-test/">reaction time test</a>.</p>',
			'mouse-or-me',
		),
	),
	'fixes'          => array(
		array( 'The pointer skips or jitters', 'Clean the sensor window under the mouse with a dry cotton bud, use a plain cloth mouse pad instead of a glossy or glass desk, and replace the battery of a wireless mouse. Move a wireless receiver closer with a USB extension cable.' ),
		array( 'My clicks land to one side', 'A steady offset often means you stop too early or overshoot in one direction. Lower the sensitivity slightly. On a touchpad or touch screen, an offset can also come from where your finger touches compared with where you look.' ),
		array( 'Targets are hard to reach on a big monitor', 'Your sensitivity may be too low for the screen size. Raise the DPI or pointer speed until you can cross the screen in one comfortable movement.' ),
	),
	'faq'            => array(
		array( 'What is a good mouse accuracy?', 'Over 90% on medium static targets is good, and over 95% with under 500 ms per target is excellent. Shrinking targets are harder, so expect lower numbers there.' ),
		array( 'How is the score calculated?', 'The score combines accuracy, targets per second and how close to the centre you click. Missing a lot or clicking near the edge lowers it even if you are fast.' ),
		array( 'Is this an aim trainer?', 'Yes. It works like a basic flick aim trainer for games: random targets, hit rate and time. Play a few rounds every day to warm up or track progress.' ),
		array( 'Does DPI affect accuracy?', 'Indirectly. What matters is your final sensitivity (DPI times in-game or system speed). Too high makes small corrections hard; too low makes long movements slow.' ),
		array( 'Can I do the test on a touchpad or phone?', 'Yes, it works with touchpads and touch screens. Touch is usually faster and touchpads slower than a mouse, so compare scores only on the same device.' ),
		array( 'Are my scores saved?', 'Your best score for each mode and size is stored only in this browser. Nothing is uploaded.' ),
	),
	'related'        => array( 'dpi-analyzer', 'mouse-tester', 'mouse-latency-test', 'reaction-time-test', 'cps-test', 'mouse-polling-rate-test', 'double-click-test', 'chimp-test' ),
	'updated'        => '2026-10-29',
);
