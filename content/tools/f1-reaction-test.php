<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'F1 Reaction Test',
	'seo_title'      => 'F1 Reaction Test: Five Red Lights Start Reaction Time (Free)',
	'description'    => 'Free F1 reaction test. Five red lights come on one by one and go out at a random moment; react like a Formula 1 start and get your time in seconds, averaged.',
	'intro'          => 'React like a Formula 1 driver on the grid. Five pairs of red lights come on one per second, hold for a random moment, then all go out at once. Click, tap or press Space the instant they do. Go early and it is a jump start.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'f1-reaction-test' ),
	'scripts'        => array( 'f1-reaction-test' ),
	'embed_height'   => 660,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Starts per round">
		<button type="button" data-f1-n="5" aria-pressed="true">5 starts</button>
		<button type="button" data-f1-n="10" aria-pressed="false">10 starts</button>
		<button type="button" data-f1-n="0" aria-pressed="false">Endless</button>
	</div>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#f1-stage">Full screen</button>
</div>
<div class="tool-stage f1-stage is-idle" id="f1-stage" tabindex="0" role="button" aria-label="F1 start lights reaction area">
	<div class="f1-gantry" aria-hidden="true">
		<div class="f1-col"><i></i><i></i><i></i></div>
		<div class="f1-col"><i></i><i></i><i></i></div>
		<div class="f1-col"><i></i><i></i><i></i></div>
		<div class="f1-col"><i></i><i></i><i></i></div>
		<div class="f1-col"><i></i><i></i><i></i></div>
	</div>
	<div class="f1-msg"><strong id="f1-big">Click to start</strong><span id="f1-small">Five red lights come on one by one. React the instant they all go out.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Last</span><span class="stat-value" id="f1-last">-</span></div>
	<div class="stat"><span class="stat-label">Average</span><span class="stat-value" id="f1-avg">-</span></div>
	<div class="stat"><span class="stat-label">Best</span><span class="stat-value" id="f1-best">-</span></div>
	<div class="stat"><span class="stat-label">Starts</span><span class="stat-value" id="f1-count">0 / 5</span></div>
</div>
<ol class="f1-log" id="f1-log" aria-label="Your start times"></ol>
<div class="btn-row f1-foot"><button type="button" class="btn btn-sm" id="f1-reset">Reset</button><span class="f1-pb" id="f1-pb"></span></div>
<p class="tool-status" id="f1-status" aria-live="polite">Click, tap or press Space to line up on the grid.</p>',
	'howto'          => array(
		'Click the dark box (or tap it, or press Space while it has focus) to line up on the grid.',
		'The five pairs of red lights come on from left to right, one pair per second, exactly like a real Formula 1 start.',
		'After the fifth pair the lights hold for a random 0.2 to 3 seconds. Do not move: the gap is random on purpose.',
		'The moment all five go out, click, tap or press Space. Your reaction time appears in seconds to three decimals, the way F1 timing shows it.',
		'Reacting while any light is still on is a <strong>jump start</strong> and does not count. After 5 (or 10) starts you get your average; press <strong>Reset</strong> for a fresh round.',
	),
	'howto_title'    => 'How to take the F1 reaction test',
	'results'        => '<p>Your time is the gap between the lights going out and the browser receiving your click, tap or key press. It includes the time to notice the change, the time to move your finger, and a little delay from your screen and mouse.</p>
<div class="table-scroll"><table>
<thead><tr><th>Average</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 0.150 s</td><td>Faster than a human reaction. Almost always a lucky guess at the random hold.</td></tr>
<tr><td>0.150-0.200 s</td><td>F1 driver pace. Real race starts are usually in this range.</td></tr>
<tr><td>0.200-0.250 s</td><td>Fast. Better than most people on a computer.</td></tr>
<tr><td>0.250-0.300 s</td><td>Average for adults.</td></tr>
<tr><td>0.300-0.400 s</td><td>A bit slow: tiredness, a 60 Hz screen or a laggy wireless mouse.</td></tr>
<tr><td>Over 0.400 s</td><td>Slow. Check the fixes below and try again when rested.</td></tr>
</tbody></table></div>
<p>Judge yourself on the <strong>average</strong>, not the best. Because the hold after the fifth light is random, a single very fast time usually means you guessed right; a run of five under 0.200 s is the real thing. A jump start is a reaction to the <em>fourth</em> or <em>fifth</em> light coming on instead of to the lights going out, which is exactly the mistake the random hold is designed to catch.</p>',
	'extra'          => array(
		array(
			'How the real F1 start works',
			'<p>At a Formula 1 start the gantry shows five pairs of red lights. They come on one pair at a time, one second apart, from left to right. Once all five are lit, the race director\'s system holds them for a random period, typically between 0.2 and 3 seconds, and then switches all of them off at once. Lights out is the signal to go. There is no green light.</p>
<p>Drivers react to lights out in about 0.2 seconds on average; a measured reaction of 0.1 seconds or less is treated as a jump start because a human cannot see and respond that quickly, and a jump start earns a penalty. Many drivers sit near 0.15 to 0.25 seconds, and the time from lights out to the car actually moving is longer because the clutch has to engage. This test reproduces the sequence and the random hold so you can compare your own reflexes with the people on the grid. For the classic red-then-green version, use the <a href="/reaction-time-test/">reaction time test</a>.</p>',
			'real-start',
		),
		array(
			'Why your F1 reaction time varies',
			'<p>Visual reaction time for a healthy adult sits between 0.2 and 0.3 seconds and depends on sleep, focus and practice more than on age. Your equipment adds delay: a 60 Hz screen draws a new frame every 16.7 ms, so the lights going out appears on average about 8 ms after the browser removes them, and a wireless mouse or a Bluetooth keyboard can add 5 to 30 ms. Drivers get the same frame-rate advantage from a real gantry: the lights go out instantly. Check your display with the <a href="/refresh-rate-test/">refresh rate test</a> if your times look slower on one computer than another.</p>
<p>This test listens for the earliest input event (pointer down or key down, not the full click), starts its timer from the frame the lights are actually removed, and keeps the hold random so you cannot learn it.</p>',
			'why-varies',
		),
	),
	'fixes'          => array(
		array( 'I keep getting jump starts', 'You are reacting to the fifth pair coming on instead of to the lights going out. Watch the whole gantry rather than the last column, keep your finger resting on the button, and only press when the red disappears. The hold is random, so there is nothing to time.' ),
		array( 'My times are much slower than expected', 'Close other tabs and apps, plug in a laptop charger, and use a wired mouse if you have one. On a TV, turn on Game mode: picture processing can add 50-100 ms. Try a few practice rounds first.' ),
		array( 'Pressing Space scrolls the page', 'Click inside the dark box first so it has focus. While it is focused, Space and Enter are captured by the test and the page does not scroll.' ),
		array( 'The lights stopped part way', 'The start is aborted if you switch tabs or minimize the browser while the lights are coming on. Click the box to line up again.' ),
	),
	'faq'            => array(
		array( 'What is a good F1 reaction time?', 'Under 0.250 s is good and under 0.200 s is F1 driver pace. Most adults average 0.250 to 0.300 s on a computer, because the screen and mouse add a little delay.' ),
		array( 'What is the reaction time of an F1 driver?', 'About 0.2 seconds from lights out. Drivers often start the launch in the 0.15 to 0.25 second range; anything under about 0.1 seconds is ruled a jump start because a human cannot react that fast.' ),
		array( 'Why is there no green light?', 'Because there is none in Formula 1. The start signal is the five red lights going out, and reacting to an absence of light is slightly harder than reacting to a color change, which is part of the challenge.' ),
		array( 'How long do the lights stay on?', 'Each pair comes on one second apart. After the fifth pair the hold is random, between 0.2 and 3 seconds, the same range used at real starts, so you cannot anticipate it.' ),
		array( 'Can I take the F1 reaction test on a phone?', 'Yes. Tap the box when the lights go out. Phone times are usually a little slower than a desktop with a mouse because of touch screen delay.' ),
		array( 'Is my best score saved?', 'Your best average is stored in this browser only, so you can try to beat it later. Nothing is sent to a server.' ),
	),
	'related'        => array( 'reaction-time-test', 'stroop-test', 'cps-test', 'spacebar-clicker', 'refresh-rate-test', 'mouse-polling-rate-test' ),
	'updated'        => '2026-10-28',
);
