<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mouse Latency Test',
	'seo_title'      => 'Mouse Latency Test: Measure Input Lag and Cursor Delay',
	'description'    => 'Free mouse latency test. See how far a drawn dot lags your cursor and measure polling interval, browser event delay, event-to-frame and click-to-frame time.',
	'intro'          => 'Move your mouse inside the box: the red dot is drawn by the page, while the arrow is drawn by your system, so the gap between them when you move fast is the lag the browser adds. Below, the test breaks that delay down into the mouse polling interval, browser event delay and the wait for the next screen refresh, and measures click-to-frame time too.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. On a touch screen use the <a href="/touch-screen-test/">touch screen test</a> instead.',
	'ads'            => 'content',
	'styles'         => array( 'mouse-latency-test' ),
	'scripts'        => array( 'mouse-latency-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<label class="ml-opt"><input type="checkbox" id="ml-trail" checked> Show raw mouse path</label>
	<button type="button" class="btn" id="ml-reset">Reset</button>
</div>
<div class="ml-grid">
	<div class="tool-stage ml-stage" id="ml-stage"><canvas id="ml-canvas" aria-label="A red dot drawn at your mouse position"></canvas><p class="ml-hint">Move the mouse fast in circles here</p></div>
	<div class="ml-pad" id="ml-pad">Click here 20 times for click-to-frame time</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Polling rate</span><span class="stat-value" id="ml-poll">-</span></div>
	<div class="stat"><span class="stat-label">Event delay</span><span class="stat-value" id="ml-delay">-</span></div>
	<div class="stat"><span class="stat-label">Event to frame</span><span class="stat-value" id="ml-e2f">-</span></div>
	<div class="stat"><span class="stat-label">Frame time</span><span class="stat-value" id="ml-frame">-</span></div>
	<div class="stat"><span class="stat-label">Est. browser latency</span><span class="stat-value" id="ml-est">-</span></div>
	<div class="stat"><span class="stat-label">Click to frame</span><span class="stat-value" id="ml-click">-</span></div>
	<div class="stat"><span class="stat-label">Clicks</span><span class="stat-value" id="ml-clicks">0</span></div>
</div>
<p class="tool-status" id="ml-status" aria-live="polite">Move the mouse around inside the box for a few seconds.</p>',
	'howto'          => array(
		'Close other heavy tabs and apps, and keep the browser window on the monitor you want to test.',
		'Move the mouse quickly in circles inside the box for about five seconds. Watch how far the red dot trails behind your arrow.',
		'Read the numbers: polling rate, event delay, event to frame, frame time and the estimated browser latency.',
		'Click the box on the right about 20 times at your own pace to measure click-to-frame time.',
		'Change one thing (refresh rate, wired vs wireless, browser, power mode), press <strong>Reset</strong> and compare.',
	),
	'howto_title'    => 'How to test mouse latency',
	'results'        => '<p>Total input lag is the time from moving or clicking the mouse to seeing the result on screen. A web page can measure the part inside the computer:</p>
<ul>
<li><strong>Polling rate:</strong> how often the mouse reports to the computer. At 125 Hz a movement can wait up to 8 ms to be reported; at 1000 Hz, up to 1 ms. Half the interval is the average wait.</li>
<li><strong>Event delay:</strong> time from when the system time-stamped the movement to when the page could handle it. Chrome and Edge line mouse movements up with the next frame, so there it is often a few milliseconds up to one frame; clicks and other browsers are usually under 2 ms. Large jumps mean the browser is busy.</li>
<li><strong>Event to frame:</strong> how long each movement waits for the next frame to be drawn. On average this is about half a frame.</li>
<li><strong>Frame time:</strong> the time per screen refresh; 16.7 ms at 60 Hz, 6.9 ms at 144 Hz, 4.2 ms at 240 Hz. Drawing and showing a frame takes about one more frame.</li>
<li><strong>Estimated browser latency:</strong> the sum of half a polling interval, event to frame, and one frame. Typical results are 20-35 ms at 60 Hz and 8-15 ms at 144 Hz or more.</li>
</ul>
<p>The monitor adds its own input lag (often 1-10 ms on gaming monitors, more on TVs outside game mode) plus pixel response time. Measuring the full chain needs a high-speed camera or a dedicated tool such as NVIDIA LDAT or Reflex Latency Analyzer.</p>',
	'extra'          => array(
		array(
			'Why the red dot lags behind the cursor',
			'<p>Your operating system draws the mouse arrow as a "hardware cursor" on a separate layer, updated straight from the latest mouse report. Web pages, games and apps draw their content in frames, which then go through the browser\'s compositor and the display pipeline. That is why the red dot sits a little behind the arrow when you move fast, and why the gap shrinks on a higher refresh rate: each frame is shorter, so content waits less. Games that render their own cursor show the same effect, which is one reason high refresh rate monitors feel more responsive.</p>',
			'why-lag',
		),
		array(
			'Lower your mouse latency',
			'<p>Use the highest refresh rate your monitor supports and check it with the <a href="/refresh-rate-test/">refresh rate test</a>. Set the mouse to 1000 Hz polling in its software and confirm it with the <a href="/mouse-polling-rate-test/">polling rate test</a>. Use a cable or the mouse\'s own 2.4 GHz receiver rather than Bluetooth, which often adds 10 ms or more. Turn on the monitor\'s game mode, and in games use exclusive full screen with NVIDIA Reflex or AMD Anti-Lag when available. To see how latency affects your clicking, try the <a href="/reaction-time-test/">reaction time test</a>.</p>',
			'lower-latency',
		),
	),
	'fixes'          => array(
		array( 'Polling rate shows 125 Hz or less', 'Open the mouse software and set the report rate to 500 or 1000 Hz. Plug the mouse or receiver straight into the computer, not into a hub or monitor USB port. Bluetooth mice usually report at about 90-133 Hz.' ),
		array( 'Event delay is high or jumps around', 'The browser is busy. Close other tabs, especially video and games, switch the laptop to its high performance power mode, and turn off extensions you do not need. Then press Reset.' ),
		array( 'Frame time says 60 Hz on a 144 Hz monitor', 'The monitor is running at 60 Hz. Set the refresh rate in the display settings, use DisplayPort or a fast HDMI cable, and check with the refresh rate test.' ),
	),
	'faq'            => array(
		array( 'Can a website measure mouse latency?', 'Partly. It can measure the polling interval, how long the browser takes to handle each movement, and how long until the next frame. It cannot see the time inside the mouse or the monitor, which needs a high-speed camera.' ),
		array( 'What is good mouse latency?', 'For the browser-side estimate, under 15 ms is excellent and typical of 144 Hz or faster monitors; 20-35 ms is normal at 60 Hz. Total end-to-end latency in fast games is usually 10-30 ms on a good setup.' ),
		array( 'Does a higher polling rate reduce latency?', 'Yes, slightly. Going from 125 Hz to 1000 Hz cuts the average wait from about 4 ms to 0.5 ms and makes movement smoother. Above 1000 Hz the gain is under half a millisecond.' ),
		array( 'Is wireless mouse latency worse?', 'Modern gaming mice with their own 2.4 GHz receiver are as fast as wired. Bluetooth usually adds latency and lowers the polling rate.' ),
		array( 'Why is click to frame higher than event to frame?', 'Click to frame includes the frame that shows the change, so it is the wait for the frame plus about one frame time. It is close to the delay you would see on screen.' ),
		array( 'Does the refresh rate matter more than the mouse?', 'Often yes. At 60 Hz the frame time alone is 16.7 ms, far more than the 1 ms polling interval of a gaming mouse. A higher refresh rate is the biggest latency improvement for most people.' ),
	),
	'related'        => array( 'mouse-polling-rate-test', 'refresh-rate-test', 'mouse-accuracy-test', 'mouse-tester', 'reaction-time-test', 'dpi-analyzer', 'fps-test', 'keyboard-ghosting-test' ),
	'updated'        => '2026-10-29',
);
