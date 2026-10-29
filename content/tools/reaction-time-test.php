<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Reaction Time Test',
	'seo_title'      => 'Reaction Time Test: How Fast Are Your Reflexes? (Free)',
	'description'    => 'Free reaction time test. Click or tap the moment the box turns green and get your time in milliseconds, your average over 5 tries and how you compare.',
	'intro'          => 'Wait for the box to turn green, then click, tap or press Space as fast as you can. Five tries give you an average reaction time in milliseconds that you can compare with typical human scores.',
	'device'         => 'any',
	'ads'            => 'content',
	'stats'          => array( 'reaction' ),
	'styles'         => array( 'reaction-time-test' ),
	'scripts'        => array( 'reaction-time-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Tries per round">
		<button type="button" data-rt-n="5" aria-pressed="true">5 tries</button>
		<button type="button" data-rt-n="10" aria-pressed="false">10 tries</button>
		<button type="button" data-rt-n="0" aria-pressed="false">Endless</button>
	</div>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#rt-stage">Full screen</button>
</div>
<div class="tool-stage rt-stage is-idle" id="rt-stage" tabindex="0" role="button" aria-label="Reaction test area">
	<div class="rt-msg"><strong id="rt-big">Click to start</strong><span id="rt-small">When the box turns red, wait. Click the moment it turns green.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Last</span><span class="stat-value" id="rt-last">-</span></div>
	<div class="stat"><span class="stat-label">Average</span><span class="stat-value" id="rt-avg">-</span></div>
	<div class="stat"><span class="stat-label">Best</span><span class="stat-value" id="rt-best">-</span></div>
	<div class="stat"><span class="stat-label">Tries</span><span class="stat-value" id="rt-count">0 / 5</span></div>
</div>
<ol class="rt-log" id="rt-log" aria-label="Your times"></ol>
<div class="btn-row rt-foot"><button type="button" class="btn btn-sm" id="rt-reset">Reset</button><span class="rt-pb" id="rt-pb"></span></div>
<p class="tool-status" id="rt-status" aria-live="polite">Click, tap or press Space in the box to begin.</p>',
	'howto'          => array(
		'Sit comfortably with your finger resting on the mouse button, the screen or the Space bar.',
		'Click the blue box to start. It turns <strong>red</strong>: wait, and do not click yet.',
		'After a random delay of 1.5 to 5 seconds it turns <strong>green</strong>. Click, tap or press Space as fast as you can.',
		'Your time appears in milliseconds. Click again for the next try. Clicking while it is still red counts as "too soon" and the try is repeated.',
		'After 5 tries (or 10) you get your average. Press <strong>Reset</strong> to start a fresh round.',
	),
	'howto_title'    => 'How to take the reaction time test',
	'results'        => '<p>Your reaction time is the gap between the box turning green and the browser receiving your click. It includes the time your eyes and brain need to notice the change, the time to move your finger, and a small delay from your mouse and screen.</p>
<div class="table-scroll"><table>
<thead><tr><th>Average</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 200 ms</td><td>Excellent. Typical of practised gamers and sprinters at the start line.</td></tr>
<tr><td>200-250 ms</td><td>Faster than most people.</td></tr>
<tr><td>250-300 ms</td><td>Average. Most adults score here on a normal computer.</td></tr>
<tr><td>300-400 ms</td><td>A bit slow. Often caused by tiredness, a slow screen or a laggy wireless mouse.</td></tr>
<tr><td>Over 400 ms</td><td>Slow. Check your setup (see the fixes) and try again when rested.</td></tr>
</tbody></table></div>
<p>Look at your <strong>average</strong>, not your best. A single 150 ms try is often a lucky guess that happened to land at the right moment. Times under 100 ms are almost always anticipation, because the eye and brain cannot react that fast.</p>',
	'extra'          => array(
		array(
			'What affects your reaction time?',
			'<p>Visual reaction time for most healthy adults sits between 200 and 300 milliseconds. It is fastest in your twenties and slows slowly with age, by a few milliseconds per decade. Sleep, caffeine, warm-up and focus matter more than age over a single day: a tired person can easily lose 50 ms.</p>
<p>Your equipment adds delay too. A 60 Hz screen only updates every 16.7 ms, so on average the green appears about 8 ms after the browser draws it. A 144 Hz or 240 Hz monitor cuts that. Wireless mice, Bluetooth keyboards, TV "picture modes" and browser extensions can each add 5 to 30 ms. That is why the same person scores better on a gaming PC than on a phone. Check your display with the <a href="/refresh-rate-test/">refresh rate test</a>, and if you play games, our <a href="/cps-test/">CPS test</a> measures how fast you can click once you have reacted.</p>
<p>This reaction time test uses the browser\'s high resolution timer and listens for the earliest input event (pointer down, not the full click), so it adds as little delay as possible.</p>',
			'what-affects',
		),
		array(
			'How to improve your reaction time',
			'<p>Reaction time improves with practice up to a point, mostly because you learn to stay relaxed and focused. Warm up with a few rounds, keep your finger touching the button so it only has to press, look at the centre of the box rather than around it, and sit at a comfortable distance. Regular sleep and staying hydrated help more than any trick. Gamers also lower system latency: a wired mouse, a high refresh rate monitor, game mode on the TV and turning off V-Sync in games.</p>',
			'improve',
		),
	),
	'fixes'          => array(
		array( 'My times are much slower than expected', 'Close other tabs and apps, plug in a laptop charger (battery saver can slow the browser), and use a wired mouse. On a TV or projector, turn on Game mode, because picture processing can add 50-100 ms.' ),
		array( 'It always says "too soon"', 'Wait for the box to turn fully green. The delay is random on purpose, so you cannot predict it. Rest your finger on the button instead of hovering, and press only when you see green.' ),
		array( 'Pressing Space scrolls the page', 'Click inside the test box first so it has focus. While the box is focused, Space and Enter are captured by the test and the page does not scroll.' ),
		array( 'The test feels slow on my phone', 'Phone screens and touch panels add some delay. Turn off battery saver, raise the screen brightness and tap with your thumb resting just above the screen.' ),
	),
	'faq'            => array(
		array( 'What is a good reaction time?', 'Around 250 ms is average for adults on a computer. Under 200 ms is very good, and consistent scores under 170 ms are rare.' ),
		array( 'What is the average human reaction time?', 'Studies put simple visual reaction time at about 200 to 250 ms. Online tests usually show 250 to 300 ms because the mouse and screen add some delay.' ),
		array( 'Why is my first try slower?', 'You are still getting into rhythm. That is why the test averages several tries. Do a practice round, then press Reset and do a real one.' ),
		array( 'Does a higher refresh rate monitor improve reaction time?', 'It lowers the delay before you see the green, by up to about 12 ms going from 60 Hz to 240 Hz. Your brain is not faster, but your measured time is.' ),
		array( 'Can I take the reaction time test on a phone?', 'Yes. Tap the box when it turns green. Times are usually a little slower than on a desktop with a mouse because of touch screen delay.' ),
		array( 'Is my best score saved?', 'Your best average is stored in this browser only, so you can try to beat it later. Nothing is sent to a server.' ),
	),
	'related'        => array( 'f1-reaction-test', 'stroop-test', 'cps-test', 'spacebar-clicker', 'refresh-rate-test', 'fps-test' ),
	'updated'        => '2026-10-28',
);
