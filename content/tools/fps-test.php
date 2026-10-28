<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'FPS Test',
	'seo_title'    => 'FPS Test: Check Your Frame Rate Online (Free)',
	'description'  => 'Free online FPS test. Measure the frame rate your browser and screen can show, with average, min and max FPS, frame times, dropped frames and a 30/15 fps comparison.',
	'intro'        => 'See how many frames per second your browser and screen really show. The FPS test counts every frame live, graphs frame times and compares smooth and choppy motion side by side.',
	'device'       => 'any',
	'ads'          => 'standard',
	'styles'       => array( 'fps-test' ),
	'scripts'      => array( 'fps-test' ),
	'embed_height' => 640,
	'tool'         => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn" id="fps-pause">Pause</button>
		<button type="button" class="btn" id="fps-reset">Reset</button>
		<button type="button" class="btn" data-tn-fullscreen="#tool">Full screen</button>
	</div>
	<div class="seg" role="group" aria-label="Motion speed">
		<button type="button" data-fps-speed="480" aria-pressed="false">Slow</button>
		<button type="button" data-fps-speed="960" aria-pressed="true">Medium</button>
		<button type="button" data-fps-speed="1920" aria-pressed="false">Fast</button>
	</div>
</div>
<div class="fps-big"><span id="fps-now">--</span><small>FPS</small></div>
<div class="tool-stage fps-stage"><canvas id="fps-lanes" aria-label="Moving objects at your frame rate, at 30 fps and at 15 fps"></canvas></div>
<canvas id="fps-graph" class="fps-graph" aria-hidden="true"></canvas>
<div class="stats">
	<div class="stat"><span class="stat-label">Average</span><span class="stat-value" id="fps-avg">-</span></div>
	<div class="stat"><span class="stat-label">Min / Max</span><span class="stat-value" id="fps-minmax">-</span></div>
	<div class="stat"><span class="stat-label">Frame time</span><span class="stat-value" id="fps-ms">-</span></div>
	<div class="stat"><span class="stat-label">Dropped frames</span><span class="stat-value" id="fps-drop">0</span></div>
	<div class="stat"><span class="stat-label">Likely refresh rate</span><span class="stat-value" id="fps-hz">-</span></div>
</div>
<p class="tool-status" id="fps-status" aria-live="polite">Measuring... keep this tab in front for a few seconds.</p>',
	'howto'        => array(
		'Open the page and wait about five seconds. The FPS test starts by itself.',
		'Read the big number: that is your current frame rate. The <strong>average</strong> settles after a few seconds.',
		'Watch the three moving squares. The top one moves once per frame at your full frame rate; the others are held to 30 and 15 fps for comparison.',
		'Look at the graph. A flat line means smooth frames; tall spikes are stutters, which are also counted as <strong>dropped frames</strong>.',
		'Use <strong>Full screen</strong> for the cleanest reading, and close other heavy tabs or apps if the number jumps around.',
	),
	'howto_title'  => 'How to use the FPS test',
	'results'      => '<p>In a browser the frame rate is capped by your screen\'s refresh rate, so the FPS test is really measuring how many frames your system manages to show per second, up to that limit:</p>
<ul>
<li><strong>About 60 FPS:</strong> a normal 60 Hz screen running smoothly. Most laptops, phones and office monitors are 60 Hz.</li>
<li><strong>About 120, 144, 165 or 240 FPS:</strong> a high refresh rate screen that is working at its full rate.</li>
<li><strong>Well below your screen\'s rate</strong> (for example 40 FPS on a 60 Hz screen): the browser is struggling. Battery saver, a busy CPU or GPU, or many open tabs are common causes.</li>
<li><strong>Exactly 30 FPS:</strong> often a power-saving mode, a low-power phone mode or a remote desktop session.</li>
</ul>
<p>A few dropped frames when the page first loads is normal. Regular spikes in the graph point to stutter that you would also feel in games and video.</p>',
	'extra'        => array(
		array(
			'FPS vs refresh rate',
			'<p><strong>FPS</strong> (frames per second) is how many new images your computer draws each second. <strong>Refresh rate</strong> (Hz) is how many times per second your screen can show a new image. You only see the lower of the two: a game running at 200 FPS on a 60 Hz monitor still looks like 60, and a 144 Hz monitor showing a game at 50 FPS looks like 50.</p>
<p>Because browsers sync animation to the display, this frame rate test also shows your likely refresh rate. If you paid for a 144 Hz monitor but the test shows 60, the monitor is probably set to 60 Hz in your display settings, or the cable cannot carry the higher rate. For the exact figure, use the <a href="/refresh-rate-test/">refresh rate test</a>.</p>',
			'fps-vs-hz',
		),
		array(
			'Can this test my FPS in games?',
			'<p>No website can read the frame rate of a game running outside the browser. For games, use the built-in counter in Steam (Settings > In-game > FPS counter), the Xbox Game Bar on Windows (<kbd>Win</kbd>+<kbd>G</kbd> > Performance), or your graphics driver overlay. This page checks your screen, browser and graphics pipeline, which is useful to confirm smooth output before you blame a game.</p>',
			'games',
		),
	),
	'fixes'        => array(
		array( 'FPS is stuck at 60 on a 120 Hz or 144 Hz monitor', 'On Windows open Settings > System > Display > Advanced display and choose the highest refresh rate. On a Mac open System Settings > Displays > Refresh rate. Use a DisplayPort or HDMI 2.0+ cable, and make sure the browser window is on the high refresh monitor.' ),
		array( 'FPS is low or keeps dropping', 'Plug in your laptop and turn off battery saver, close heavy tabs and apps, and check that hardware acceleration is on in your browser settings (Chrome: Settings > System > Use graphics acceleration when available).' ),
		array( 'FPS is capped at 30', 'Low power mode on iPhone and power saving on many Android phones limit browsers to 30 FPS. Turn it off and test again. Remote desktop and screen sharing can also cap the rate.' ),
	),
	'faq'          => array(
		array( 'What is a good FPS?', '60 FPS feels smooth for everyday use and most games. Competitive gamers aim for 120-240 FPS on a matching high refresh rate monitor. Below 30 FPS looks choppy.' ),
		array( 'Why does the FPS test show 60 when my monitor is 144 Hz?', 'The monitor is probably set to 60 Hz in display settings, the cable does not support 144 Hz, or the browser is on a different screen. Fix the setting and test again.' ),
		array( 'Is the FPS test accurate?', 'It counts the real frames your browser shows, using the same timing the browser uses to draw animation. It is accurate to within about 1 FPS once the average settles.' ),
		array( 'What are dropped frames?', 'Frames that took much longer than normal to draw, so the image stuttered. The test counts any frame that takes more than one and a half times the usual frame time.' ),
		array( 'Can I check my FPS on a phone?', 'Yes. Most phones show 60 FPS, and newer phones with 90 or 120 Hz screens show more when power saving is off.' ),
		array( 'Does the FPS test work in every browser?', 'Yes, it works in Chrome, Edge, Firefox and Safari. Some browsers limit background or low-power tabs, so keep the tab active while testing.' ),
	),
	'related'      => array( 'refresh-rate-test', 'ufo-test', 'dead-pixel-test', 'reaction-time-test', 'mouse-polling-rate-test', 'stuck-pixel-fixer', 'gamepad-tester', 'cps-test' ),
	'updated'      => '2026-10-28',
);
