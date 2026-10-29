<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Jitter Click Test',
	'seo_title'      => 'Jitter Click Test: Measure Your Jitter Clicking CPS (Free)',
	'description'    => 'Free jitter click test. Jitter click for 5, 10 or 30 seconds and see your clicks per second, peak CPS and how consistent your jitter is, with tips to learn it.',
	'intro'          => 'Tense your arm, let your hand vibrate on the mouse and see how many clicks per second your jitter clicking really produces. The 10 second test is the default, because jitter clicking is about holding a high rate, not a one second burst. You get CPS, peak CPS, a consistency score and a graph of every second.',
	'device'         => 'desktop',
	'device_message' => 'Jitter clicking needs a mouse. Taps on a touch screen are counted, but that is a tap test, not a jitter click test. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="seg cps-seg" role="group" aria-label="Test length">
		<button type="button" data-cps-t="5" aria-pressed="false">5 s</button>
		<button type="button" data-cps-t="10" aria-pressed="true">10 s</button>
		<button type="button" data-cps-t="15" aria-pressed="false">15 s</button>
		<button type="button" data-cps-t="30" aria-pressed="false">30 s</button>
		<button type="button" data-cps-t="60" aria-pressed="false">60 s</button>
	</div>
	<label class="cps-opt"><input type="checkbox" id="cps-right"> Count right clicks too</label>
</div>
<div class="tool-stage cps-stage" id="cps-stage" data-cps-mode="jitter" tabindex="0" role="button">
	<div class="cps-ring" id="cps-ring"><span id="cps-timer">10.0</span><small>seconds</small></div>
	<div class="cps-msg"><strong id="cps-big">Click here to start</strong><span id="cps-small">The timer starts on your first click.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Clicks / second</span><span class="stat-value" id="cps-cps">0.0</span></div>
	<div class="stat"><span class="stat-label">Clicks</span><span class="stat-value" id="cps-count">0</span></div>
	<div class="stat"><span class="stat-label">Peak CPS</span><span class="stat-value" id="cps-peak">0.0</span></div>
	<div class="stat"><span class="stat-label">Consistency</span><span class="stat-value" id="cps-consist">-</span></div>
	<div class="stat"><span class="stat-label">Rank</span><span class="stat-value" id="cps-rank">-</span></div>
</div>
<div class="cps-graph" id="cps-graph" aria-hidden="true"></div>
<div class="btn-row cps-foot"><button type="button" class="btn btn-sm" id="cps-reset">Reset</button><span class="cps-pb" id="cps-pb"></span></div>
<p class="tool-status" id="cps-status" aria-live="polite">Pick a time, then jitter click in the box as fast as you can.</p>',
	'howto'          => array(
		'Hold the mouse lightly with your index finger resting on the left button and the heel of your hand on the desk or mouse pad.',
		'Tense your forearm and wrist so the hand starts to shake. The finger should barely move; the vibration does the clicking.',
		'Click inside the box to start the timer, then keep the vibration going until the countdown reaches zero. <strong>10 seconds</strong> is the standard jitter test length.',
		'Read your <strong>CPS</strong>, your <strong>peak</strong> second and the <strong>consistency</strong> score, which compares each second with the others. Press <strong>Reset</strong> or click again to retry.',
		'Stop if your wrist or forearm hurts. Jitter clicking strains the tendons, so keep sessions short and take breaks.',
	),
	'howto_title'    => 'How to take the jitter click test',
	'results'        => '<p>Jitter clicking is a technique where you tense the muscles of the forearm so the whole hand vibrates and the finger taps the button many times per second. Done well it gives 9 to 14 clicks per second; normal clicking gives 4 to 7.</p>
<div class="table-scroll"><table>
<thead><tr><th>CPS (10 s)</th><th>Rank</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 6</td><td>Not jittering yet</td><td>You are still clicking normally. Tense harder and relax the finger.</td></tr>
<tr><td>6-9</td><td>Warming up</td><td>The vibration is starting, but it is not steady for the whole test.</td></tr>
<tr><td>9-12</td><td>Jitter</td><td>Proper jitter clicking. Good enough for most PvP situations.</td></tr>
<tr><td>12-15</td><td>Fast jitter</td><td>Very fast. Few people hold this for 10 seconds.</td></tr>
<tr><td>Over 15</td><td>Pro jitter</td><td>Exceptional, or a mouse switch that double registers. Check with the double click test.</td></tr>
</tbody></table></div>
<p><strong>Consistency</strong> is 100% when every second had the same number of clicks and falls as the seconds vary. A high peak with low consistency means you can start the vibration but not hold it; that is the usual stage when learning. The graph shows exactly where the rate dropped.</p>',
	'extra'          => array(
		array(
			'How to learn jitter clicking',
			'<p>Start with the grip. Many jitter clickers use a claw grip with the palm slightly raised and the wrist resting on the pad, so the vibration travels into the finger instead of the mouse body. Tense the forearm as if you were squeezing a stress ball without closing the hand, and let the tremor start. At first the clicks come in bursts; the goal is a steady hum. Practice in 10 second rounds with a minute of rest between them, and check the graph: flat bars mean you are holding the rate.</p>
<p>A light mouse with a low click force makes a big difference. Heavy clicks damp the vibration, and tall buttons with a lot of pre-travel miss presses. Lower your sensitivity slightly in game, because the shaking hand also moves the pointer.</p>',
			'learn',
		),
		array(
			'Jitter clicking, butterfly clicking and drag clicking',
			'<p><strong>Jitter clicking</strong> uses one finger and muscle tension: 9-14 CPS, legal on almost every server, but tiring. <strong>Butterfly clicking</strong> alternates two fingers on the same button for 10-20 CPS; it is easier on the arm but many anticheats flag it, and some mice double register, which servers treat as cheating. <strong>Drag clicking</strong> slides a finger across a grippy button so the switch bounces; it can show 30+ CPS, but only on specific mice and only for a second or two. For long fights, jitter clicking is the most reliable of the three, and this test measures it over 10 seconds for that reason. Compare with your normal score on the <a href="/cps-test/">CPS test</a> and try the <a href="/right-click-cps-test/">right click CPS test</a> for the other button.</p>',
			'techniques',
		),
	),
	'fixes'          => array(
		array( 'My jitter score is no higher than normal clicking', 'You are probably moving the finger instead of vibrating the arm. Rest the wrist, tense the forearm until the hand shakes on its own, and keep the fingertip just touching the button. It takes a few sessions to find the tension.' ),
		array( 'Peak is high but the average is low', 'You can start the vibration but it fades. That is the normal learning stage. Shorten the test to 5 seconds, build consistency, then move back to 10 and 30 seconds.' ),
		array( 'The count jumps even when I barely click', 'The switch may be double registering. Run the <a href="/double-click-test/">double click test</a>; if it finds double clicks, the inflated score is the mouse, not you, and anticheats will notice too.' ),
		array( 'My wrist or arm hurts', 'Stop. Jitter clicking strains the forearm tendons, and pain is a sign to rest. Keep sessions under a minute, stretch the wrist, and never jitter click through discomfort.' ),
	),
	'faq'            => array(
		array( 'What is a good jitter click CPS?', 'Around 10 CPS held for 10 seconds is good jitter clicking. 12 or more is fast, and 15+ sustained is rare without a switch that double registers.' ),
		array( 'Is jitter clicking bad for your hand?', 'It strains the forearm and wrist tendons. Short sessions with breaks are fine for most people, but pain, tingling or numbness means you should stop and rest for a few days.' ),
		array( 'Is jitter clicking allowed in Minecraft?', 'On most servers, yes. Anticheats look for perfectly regular click timing and for CPS far above 20, which are signs of auto clickers. Jitter clicking is irregular and usually stays under 15.' ),
		array( 'Why is the default test 10 seconds?', 'Jitter clicking is about holding a high rate. A 1 or 5 second burst flatters everyone; 10 seconds shows whether you can keep it up through a fight.' ),
		array( 'What does the consistency score mean?', 'It compares your click count in each second with the others. 100% means a perfectly steady rate; below about 70% means the vibration came in bursts.' ),
		array( 'Is my best score saved?', 'Your best jitter CPS for each test length is stored in this browser only. Nothing is sent to a server.' ),
	),
	'related'        => array( 'cps-test', 'right-click-cps-test', 'auto-clicker-test', 'double-click-test', 'mouse-tester', 'reaction-time-test' ),
	'updated'        => '2026-10-28',
);
