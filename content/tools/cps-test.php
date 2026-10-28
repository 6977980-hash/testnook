<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'CPS Test',
	'seo_title'      => 'CPS Test: Clicks Per Second Speed Test (1 to 100 Seconds)',
	'description'    => 'Free CPS test. Click as fast as you can for 1, 5, 10, 30, 60 or 100 seconds and see your clicks per second, total clicks and best score. Works with any mouse.',
	'intro'          => 'How many times can you click in a second? Pick a time, click the box as fast as you can and the timer starts on your first click. You get your clicks per second, total clicks and a rank from Turtle to Cheetah.',
	'device'         => 'desktop',
	'device_message' => 'This CPS test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="seg cps-seg" role="group" aria-label="Test length">
		<button type="button" data-cps-t="1" aria-pressed="false">1 s</button>
		<button type="button" data-cps-t="5" aria-pressed="true">5 s</button>
		<button type="button" data-cps-t="10" aria-pressed="false">10 s</button>
		<button type="button" data-cps-t="30" aria-pressed="false">30 s</button>
		<button type="button" data-cps-t="60" aria-pressed="false">60 s</button>
		<button type="button" data-cps-t="100" aria-pressed="false">100 s</button>
	</div>
	<label class="cps-opt"><input type="checkbox" id="cps-right"> Count right clicks too</label>
</div>
<div class="tool-stage cps-stage" id="cps-stage" tabindex="0" role="button" aria-label="Click area">
	<div class="cps-ring" id="cps-ring"><span id="cps-timer">5.0</span><small>seconds</small></div>
	<div class="cps-msg"><strong id="cps-big">Click here to start</strong><span id="cps-small">The timer starts on your first click.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Clicks / second</span><span class="stat-value" id="cps-cps">0.0</span></div>
	<div class="stat"><span class="stat-label">Clicks</span><span class="stat-value" id="cps-count">0</span></div>
	<div class="stat"><span class="stat-label">Peak CPS</span><span class="stat-value" id="cps-peak">0.0</span></div>
	<div class="stat"><span class="stat-label">Rank</span><span class="stat-value" id="cps-rank">-</span></div>
</div>
<div class="cps-graph" id="cps-graph" aria-hidden="true"></div>
<div class="btn-row cps-foot"><button type="button" class="btn btn-sm" id="cps-reset">Reset</button><span class="cps-pb" id="cps-pb"></span></div>
<p class="tool-status" id="cps-status" aria-live="polite">Pick a time, then click in the box as fast as you can.</p>',
	'howto'          => array(
		'Pick a test length. <strong>5 seconds</strong> is the standard most leaderboards use; 1 second is a burst test; 100 seconds tests stamina.',
		'Click inside the box. The countdown starts on your first click, so there is no ready-steady-go delay.',
		'Click as fast as you can until the timer reaches zero. The live counter shows your current clicks per second.',
		'Read your <strong>CPS</strong> (total clicks divided by the seconds) and your rank. Press <strong>Reset</strong> or just click again for another round.',
		'Tick "Count right clicks too" if you want to try butterfly or drag clicking with both buttons.',
	),
	'howto_title'    => 'How to take the CPS test',
	'results'        => '<p>CPS means <strong>clicks per second</strong>: your total clicks divided by the test length. A 5 second test is the common benchmark, because almost everyone slows down over longer runs.</p>
<div class="table-scroll"><table>
<thead><tr><th>CPS (5 s)</th><th>Rank</th><th>Typical of</th></tr></thead>
<tbody>
<tr><td>Under 4</td><td>Turtle</td><td>Careful single clicking.</td></tr>
<tr><td>4-6</td><td>Rabbit</td><td>Normal fast clicking with one finger.</td></tr>
<tr><td>6-8</td><td>Fox</td><td>Practised gamers using a light mouse.</td></tr>
<tr><td>8-10</td><td>Cheetah</td><td>Jitter clicking or two fingers alternating.</td></tr>
<tr><td>Over 10</td><td>Lightning</td><td>Butterfly or drag clicking. Many games treat this as suspicious.</td></tr>
</tbody></table></div>
<p><strong>Peak CPS</strong> is your fastest single second. The graph shows your clicks in each second of the test, so you can see where you slowed down. If the count stops rising while you are clicking, your mouse or browser is missing clicks; try the <a href="/double-click-test/">double click test</a> to check the switch.</p>',
	'extra'          => array(
		array(
			'Clicking techniques explained',
			'<p><strong>Normal clicking</strong> uses one finger and a full press each time: 4-7 CPS for most people. <strong>Jitter clicking</strong> tenses the forearm so the hand vibrates and taps the button very quickly, reaching 8-14 CPS, at the cost of accuracy and sore wrists. <strong>Butterfly clicking</strong> alternates two fingers on the same button, often 10-20 CPS. <strong>Drag clicking</strong> drags a finger across a textured button so the switch bounces many times per pass; it can show 30+ CPS, but only on mice with very light switches and rough coatings, and it wears the switch quickly.</p>
<p>Minecraft PvP players care most about CPS because hits land per click. Many servers cap or flag clicks above about 20 CPS, so a very high score is not always an advantage. Casual players and office workers never need more than 6-7.</p>',
			'techniques',
		),
		array(
			'Why your CPS test score varies',
			'<p>Mouse switches, polling rate and the browser all shape your score. A heavy switch takes longer to reset, so light optical or 50 g switches click faster. Some browsers merge very fast clicks into double clicks; this test counts raw button presses, not "click" events, so every press is seen. Posture matters: resting the heel of your hand and clicking with your fingertip is faster than hovering. Make sure the pointer stays over the box, because clicks outside it are not counted, and that nothing else is running that could stall the page.</p>',
			'why-varies',
		),
	),
	'fixes'          => array(
		array( 'Clicks are not counted', 'Keep the pointer inside the box; clicks elsewhere do not count. If some clicks vanish, your mouse may be missing presses or have a worn switch. Try another mouse to compare.' ),
		array( 'Right click opens a menu', 'The context menu is blocked inside the box. If it still appears, click once inside the box first so the page has focus, or untick "Count right clicks too".' ),
		array( 'The timer does not start', 'The countdown starts on your first click, not when you choose a length. Click inside the grey box. If the box never responds, check that JavaScript is enabled and no extension blocks scripts.' ),
		array( 'My score is far below others', 'Most posted "20 CPS" scores use drag or butterfly clicking. For normal clicking, 5-7 CPS is good. Hold the mouse lightly, use your fingertip and warm up for a round or two.' ),
	),
	'faq'            => array(
		array( 'What is a good CPS?', 'Around 6 CPS is good for normal clicking, 8-10 is very fast, and anything above 10 usually means jitter, butterfly or drag clicking.' ),
		array( 'What does CPS mean?', 'Clicks per second: the number of mouse clicks you make in one second, averaged over the test. A 5 second test with 30 clicks is 6 CPS.' ),
		array( 'What is the world record for clicks per second?', 'Claimed records with drag clicking go well above 50 CPS, but they depend heavily on the mouse. For honest single-finger clicking, a sustained 10+ CPS is exceptional.' ),
		array( 'Does the CPS test count double clicks?', 'It counts every button press the browser receives. If your mouse double clicks on its own, the extra clicks inflate your score; use our double click test to check.' ),
		array( 'Can I take the CPS test on a phone?', 'Yes, taps are counted the same way. Phone scores are usually a bit lower because the touch screen adds a small delay between taps.' ),
		array( 'Is my best score saved?', 'Your best CPS for each test length is stored in this browser only. Nothing is sent anywhere.' ),
	),
	'related'        => array( 'jitter-click-test', 'right-click-cps-test', 'spacebar-clicker', 'reaction-time-test', 'double-click-test', 'mouse-tester' ),
	'updated'        => '2026-10-28',
);
