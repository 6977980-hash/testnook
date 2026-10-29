<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'Refresh Rate Test',
	'seo_title'    => 'Refresh Rate Test: Check Your Monitor Hz Online (Free)',
	'description'  => 'Free refresh rate test. Find your monitor\'s real refresh rate in Hz (60, 120, 144, 165, 240 Hz), check frame timing and skipped frames, and compare motion live.',
	'intro'        => 'Find out how many times per second your screen really refreshes. The refresh rate test measures your display in hertz within a few seconds and shows moving objects at full and reduced rates so you can see the difference.',
	'device'       => 'any',
	'ads'          => 'content',
	'styles'       => array( 'refresh-rate-test' ),
	'scripts'      => array( 'refresh-rate-test' ),
	'embed_height' => 700,
	'tool'         => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn" id="rr-again">Measure again</button>
		<button type="button" class="btn" data-tn-fullscreen="#tool">Full screen</button>
	</div>
	<div class="seg" role="group" aria-label="Motion speed">
		<button type="button" data-rr-speed="480" aria-pressed="false">Slow</button>
		<button type="button" data-rr-speed="960" aria-pressed="true">Medium</button>
		<button type="button" data-rr-speed="1920" aria-pressed="false">Fast</button>
	</div>
</div>
<div class="rr-big"><span id="rr-hz">--</span><small>Hz</small></div>
<p class="rr-exact" id="rr-exact">Measuring your display...</p>
<div class="tool-stage rr-stage"><canvas id="rr-lanes" aria-label="Moving objects at your refresh rate, at half your refresh rate and at 30 Hz"></canvas></div>
<div class="rr-skip" id="rr-skip" aria-hidden="true"></div>
<div class="stats">
	<div class="stat"><span class="stat-label">Measured</span><span class="stat-value" id="rr-measured">-</span></div>
	<div class="stat"><span class="stat-label">Frame time</span><span class="stat-value" id="rr-ms">-</span></div>
	<div class="stat"><span class="stat-label">Jitter</span><span class="stat-value" id="rr-jitter">-</span></div>
	<div class="stat"><span class="stat-label">Skipped frames</span><span class="stat-value" id="rr-skipped">0</span></div>
</div>
<p class="tool-status" id="rr-status" aria-live="polite">Keep this tab in front and do not move the window for about three seconds.</p>',
	'howto'        => array(
		'Open the page on the monitor you want to test and keep the browser window on that screen. The test starts by itself.',
		'Wait about three seconds. The big number is your refresh rate, rounded to the usual value (60, 120, 144 Hz and so on). The line under it shows the exact measurement, for example 59.94 Hz.',
		'Watch the moving shapes. The top one moves every refresh; the middle one at half the rate and the bottom one at 30 Hz. On a high refresh rate screen the top one looks clearly smoother and sharper.',
		'Check the row of squares under the motion area. One square lights per frame. If you photograph it with a slow shutter, a gap in the lit squares means a skipped frame.',
		'If you move the window to another monitor or change a display setting, press <strong>Measure again</strong>.',
	),
	'howto_title'  => 'How to check your refresh rate',
	'results'      => '<p>The <strong>refresh rate</strong> is how many new images your screen can show each second, measured in hertz (Hz). The test times the gaps between the frames your browser draws, which are locked to your display, so it reports the rate the screen is actually running at right now, not what the box or spec sheet promises.</p>
<ul>
<li><strong>60 Hz</strong> (or 59.94 Hz): the standard for most office monitors, laptops, TVs and older phones.</li>
<li><strong>75, 90 or 100 Hz:</strong> budget gaming monitors and some phones and tablets.</li>
<li><strong>120, 144 or 165 Hz:</strong> gaming monitors, gaming laptops, iPhone Pro and many Android phones.</li>
<li><strong>240 Hz and above:</strong> high-end esports monitors.</li>
</ul>
<p><strong>Jitter</strong> is how much the frame time varies. Under about 0.5 ms is excellent; a few milliseconds means the browser or system is busy. <strong>Skipped frames</strong> counts refreshes where the browser missed its turn. A few at the start are normal; a steady climb points to a busy system or a power-saving mode.</p>',
	'extra'        => array(
		array(
			'Why is my monitor showing 60 Hz instead of 144 Hz?',
			'<p>This is the most common surprise. A new 144 Hz or 165 Hz monitor often runs at 60 Hz out of the box because the operating system picks a safe default, or because the cable cannot carry the higher rate. Older HDMI cables and ports (HDMI 1.4) top out at 60 Hz at 1440p and above, while DisplayPort and HDMI 2.0/2.1 can carry 144 Hz and more. Laptop users should also check that the browser is on the built-in or external screen they mean to test.</p>
<p>Variable refresh rate (G-Sync, FreeSync, Adaptive-Sync and ProMotion on Apple devices) can also lower the rate when little is moving. Phones and tablets with adaptive displays often drop to 60 Hz in the browser or in battery saver, then rise to 120 Hz in games.</p>',
			'stuck-at-60',
		),
		array(
			'Refresh rate vs FPS',
			'<p>Refresh rate belongs to the screen; FPS (frames per second) belongs to the computer or game. You see whichever is lower. A 144 Hz monitor fed 60 FPS looks like 60, and a game at 200 FPS on a 60 Hz panel still shows 60 new images a second. To measure how many frames your browser actually manages, with a frame-time graph, use the <a href="/fps-test/">FPS test</a>. To check the screen itself for faults, run the <a href="/dead-pixel-test/">dead pixel test</a>.</p>',
			'hz-vs-fps',
		),
	),
	'fixes'        => array(
		array( 'Set the refresh rate on Windows', 'Open Settings > System > Display > Advanced display, select the monitor and choose the highest value under "Choose a refresh rate". In NVIDIA Control Panel (Change resolution) or AMD Software (Display) you can set it too. Then press Measure again.' ),
		array( 'Set the refresh rate on a Mac', 'Open System Settings > Displays, select the monitor and pick the highest option in the Refresh rate menu. MacBook Pro screens use ProMotion: choose "ProMotion" for up to 120 Hz. Low Power Mode can limit it to 60 Hz.' ),
		array( 'High refresh rate is missing from the list', 'Use the cable that came with the monitor, preferably DisplayPort, or a certified HDMI 2.0/2.1 cable, plugged into the graphics card, not the motherboard. Update the graphics driver and enable the high refresh mode or overclock option in the monitor\'s own menu if it has one.' ),
		array( 'Phone shows 60 Hz instead of 90 or 120 Hz', 'Turn off battery saver or Low Power Mode, then check Settings > Display > Motion smoothness (Samsung), Smooth display (Pixel) or Screen refresh rate (other Android phones). On an iPhone or iPad, Safari has its own 60 fps setting; see the next fix.' ),
		array( 'iPhone or iPad shows 60 Hz in Safari', 'Safari on iPhone and iPad draws web pages near 60 fps by default, even on ProMotion screens that run at 120 Hz everywhere else. To let the test see 120 Hz, open Settings &gt; Apps &gt; Safari &gt; Advanced &gt; Feature Flags, turn off <strong>Prefer Page Rendering Updates near 60fps</strong> and reload the page. Low Power Mode also caps the screen at 60 Hz, so turn it off first. iPhones without ProMotion have 60 Hz screens, so 60 is the right answer there.' ),
	),
	'faq'          => array(
		array( 'How do I check my monitor\'s refresh rate?', 'Open this page on that monitor and wait three seconds. The big number shows the refresh rate it is running at now. Windows and macOS also show it in the display settings.' ),
		array( 'Is this refresh rate test accurate?', 'Yes, it times hundreds of real frames and reports the median, so it is usually within 0.1 Hz of the true rate. A busy system can make the reading jump; close other tabs and measure again.' ),
		array( 'Why does it say 59.94 Hz and not 60?', 'Many screens and TVs run at 59.94 Hz, a broadcast standard close to 60. It is normal and looks identical to 60 Hz.' ),
		array( 'Can my browser show more than 60 Hz?', 'Yes. Chrome, Edge, Firefox and Safari on computers draw at the full refresh rate of the screen when the system allows it, up to 240 Hz and beyond. Safari on iPhone and iPad is the exception: it stays near 60 fps unless you change a setting (see the iPhone question below).' ),
		array( 'Does refresh rate matter for normal use?', 'Higher rates make scrolling, mouse movement and games look smoother and feel more responsive. For office work 60 Hz is fine; for gaming 120-144 Hz is a big step up.' ),
		array( 'Why do I get a different result on each monitor?', 'Each display has its own refresh rate. The test measures the screen the browser window is on, so move the window and press Measure again for each one.' ),
		array( 'Why does my iPhone Pro show 60 Hz in Safari?', 'Safari renders web pages near 60 fps by default to save battery, so every browser test reads about 60 on a 120 Hz ProMotion iPhone or iPad. Turn off <strong>Prefer Page Rendering Updates near 60fps</strong> in Settings &gt; Apps &gt; Safari &gt; Advanced &gt; Feature Flags, make sure Low Power Mode is off, and reload.' ),
	),
	'related'      => array( 'ufo-test', 'fps-test', 'dead-pixel-test', 'stuck-pixel-fixer', 'burn-in-test', 'mouse-polling-rate-test' ),
	'updated'      => '2026-10-28',
);
