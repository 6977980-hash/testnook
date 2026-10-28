<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Auto Clicker Test',
	'seo_title'      => 'Auto Clicker Test: Check Your Auto Clicker\'s Real CPS (Free)',
	'description'    => 'Free auto clicker test. Point your auto clicker at the box and see its real clicks per second, the gap between clicks in ms and whether clicks are dropped.',
	'intro'          => 'Set your auto clicker going over the box and find out what it actually delivers: clicks per second, the average gap between clicks in milliseconds and how regular that gap is. The regularity score tells a program apart from a finger, which is also how anti-cheat systems spot one. Works with any auto clicker on Windows, Mac, Linux and Android.',
	'device'         => 'desktop',
	'device_message' => 'This test is for an auto clicker on a computer or an Android tap app. Manual taps on a touch screen are not counted here; use the <a href="/cps-test/">CPS test</a> for a tap speed test.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 640,
	'tool'           => '<div class="tool-bar">
	<div class="seg cps-seg" role="group" aria-label="Test length">
		<button type="button" data-cps-t="5" aria-pressed="false">5 s</button>
		<button type="button" data-cps-t="10" aria-pressed="true">10 s</button>
		<button type="button" data-cps-t="30" aria-pressed="false">30 s</button>
		<button type="button" data-cps-t="60" aria-pressed="false">60 s</button>
	</div>
</div>
<div class="tool-stage cps-stage" id="cps-stage" data-cps-mode="auto" tabindex="0" role="button" aria-label="Auto clicker target area">
	<div class="cps-ring" id="cps-ring"><span id="cps-timer">10.0</span><small>seconds</small></div>
	<div class="cps-msg"><strong id="cps-big">Start your auto clicker here</strong><span id="cps-small">The timer starts on the first click.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Clicks / second</span><span class="stat-value" id="cps-cps">0.0</span></div>
	<div class="stat"><span class="stat-label">Clicks</span><span class="stat-value" id="cps-count">0</span></div>
	<div class="stat"><span class="stat-label">Peak CPS</span><span class="stat-value" id="cps-peak">0.0</span></div>
	<div class="stat"><span class="stat-label">Click gap</span><span class="stat-value" id="cps-interval">-</span></div>
	<div class="stat"><span class="stat-label">Variation</span><span class="stat-value" id="cps-spread">-</span></div>
	<div class="stat"><span class="stat-label">Verdict</span><span class="stat-value" id="cps-rank">-</span></div>
</div>
<div class="cps-graph" id="cps-graph" aria-hidden="true"></div>
<div class="btn-row cps-foot"><button type="button" class="btn btn-sm" id="cps-reset">Reset</button><span class="cps-pb" id="cps-pb"></span></div>
<p class="tool-status" id="cps-status" aria-live="polite">Pick a time, move the pointer into the box and start your auto clicker. The timer starts on the first click.</p>',
	'howto'          => array(
		'Open your auto clicker and set the click interval you want to test, for example 100 ms for 10 CPS or 10 ms for 100 CPS.',
		'Pick a test length. <strong>10 seconds</strong> is enough to measure the rate; 30 or 60 seconds also shows whether the rate holds up.',
		'Move the mouse pointer into the box and start the auto clicker with its hotkey (often F6 or F8). The timer starts on the first click.',
		'Leave the pointer in the box until the timer reaches zero. Then stop the auto clicker.',
		'Read the clicks per second, the measured gap between clicks and the verdict. Compare the gap with the interval you set: if they differ, the box below explains why.',
	),
	'howto_title'    => 'How to test an auto clicker',
	'results'        => '<p>Four numbers describe what the browser actually received:</p>
<ul>
<li><strong>Clicks per second:</strong> total clicks divided by the test length. This is the rate games and websites see, not the rate shown in the auto clicker\'s settings.</li>
<li><strong>Click gap:</strong> the average time between one click and the next, in milliseconds. 1000 divided by the gap is the CPS. An auto clicker set to 50 ms should show close to 50 ms here.</li>
<li><strong>Variation:</strong> how much the gap wanders, as a standard deviation and a percentage of the gap. A program typically varies by under 5%; a human finger by 20 to 40%.</li>
<li><strong>Verdict:</strong> <em>Automated</em> when the variation is under 8% over at least 20 clicks, <em>Probably automated</em> under 20%, otherwise <em>Looks human</em>.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>Interval set</th><th>Expected CPS</th><th>What you usually get</th></tr></thead>
<tbody>
<tr><td>100 ms</td><td>10</td><td>10, accurately. Any auto clicker manages this.</td></tr>
<tr><td>20 ms</td><td>50</td><td>45-50. Windows timer resolution starts to matter.</td></tr>
<tr><td>10 ms</td><td>100</td><td>60-100. Depends on the clicker and the browser\'s event handling.</td></tr>
<tr><td>1 ms</td><td>1000</td><td>Far less, often 100-250. The operating system and browser cap how many events a second get through.</td></tr>
</tbody></table></div>
<p>The graph shows clicks in each second of the test. A flat line means the rate is stable; dips mean the browser or the computer stalled for a moment, which happens when other windows are busy or the auto clicker shares a core with the browser.</p>',
	'extra'          => array(
		array(
			'Why an auto clicker delivers fewer clicks than its setting',
			'<p>An auto clicker asks the operating system to send a click, waits the interval you set, and repeats. Three things stretch the interval. First, <strong>timer resolution</strong>: Windows timers tick at about 15.6 ms by default, so a 1 ms setting can become 15 ms unless the program raises the resolution, and many free clickers do not. Second, every click is two events, a press and a release, so the OS has twice the work and may merge or delay them. Third, the <strong>browser</strong> processes input on the same thread that draws the page, and when clicks arrive faster than it can handle them, some are coalesced. The result is that settings below 10 ms rarely deliver what they promise. If the figure matters, test here and set the clicker by what you measure rather than by the box in its settings.</p>',
			'why-fewer-clicks',
		),
		array(
			'Auto clickers, games and fairness',
			'<p>Most multiplayer games treat auto clickers as cheating, and the regularity you see on this page is exactly how they get caught: a human cannot produce 100 clicks with 2% variation. Minecraft servers with anti-cheat plugins flag suspiciously regular clicking well before 20 CPS, and many ban for it. Where auto clickers are legitimate, idle games, repetitive form work, accessibility for people who cannot click repeatedly, testing your own software, use the random delay option that most clickers offer and keep the rate within what the task needs. This page measures; it does not provide an auto clicker. For your own clicking speed, try the <a href="/cps-test/">CPS test</a> and the <a href="/jitter-click-test/">jitter click test</a>, and to check whether a mouse button is faulty, the <a href="/double-click-test/">double click test</a>.</p>',
			'fairness',
		),
	),
	'fixes'          => array(
		array( 'The counter stays at zero', 'The auto clicker is clicking somewhere else. Make sure the browser window is in front and the pointer is inside the dashed box when you press the hotkey. Some clickers click at a fixed saved position rather than the current pointer; set the position to the box.' ),
		array( 'The CPS is much lower than the interval I set', 'That is normal below about 20 ms: operating system timer resolution and the browser\'s event handling cap the rate. Try the same interval in another browser; Chrome and Edge usually pass the most clicks.' ),
		array( 'The verdict says "Looks human" with the auto clicker running', 'Either the clicker has a random delay enabled, or fewer than 20 clicks reached the page. Turn the random delay off for the test and run at least 10 seconds.' ),
		array( 'The page or the whole browser froze', 'Rates above a few hundred clicks a second can overwhelm the page. Stop the clicker with its hotkey, press Reset and use a longer interval. Hotkeys keep working while the page is busy; a mouse click on a Stop button often does not.' ),
		array( 'My Android tap app is not counted', 'Accessibility-based auto tappers inject touches, which this page counts as clicks. If nothing registers, the app may be tapping a point outside the box; move its target marker onto the box.' ),
	),
	'faq'            => array(
		array( 'What does the auto clicker test measure?', 'How many clicks per second actually reach a web page from your auto clicker, the average gap between clicks in milliseconds, and how regular that gap is. It is the real rate rather than the rate in the clicker\'s settings.' ),
		array( 'Why is my auto clicker slower than its setting?', 'Operating system timers and the browser cap how many events get through. Intervals of 20 ms and above are delivered accurately; 1 ms settings usually produce 100 to 250 CPS, not 1000.' ),
		array( 'How does the test know it is an auto clicker?', 'From the regularity of the clicks. A program repeats the same gap to within a few percent; a human finger varies by 20 to 40%. Under 8% variation over 20 or more clicks is reported as automated.' ),
		array( 'Can games detect my auto clicker?', 'Yes, by the same regularity. Many game servers flag clicking that is too regular or too fast, and most games ban auto clickers in competitive play. Use them only where the rules allow.' ),
		array( 'Does the test work on a phone?', 'With an Android auto tap app, yes: the injected taps are counted. iOS does not allow auto tap apps without Switch Control, which is slower. Manual taps are not meant for this page; use the CPS test for those.' ),
		array( 'Does this page provide an auto clicker?', 'No. It only measures one you already have. There is nothing to download here, and nothing is sent anywhere.' ),
	),
	'related'        => array( 'cps-test', 'jitter-click-test', 'right-click-cps-test', 'double-click-test', 'mouse-tester', 'mouse-polling-rate-test' ),
	'updated'        => '2026-10-29',
);
