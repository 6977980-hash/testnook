<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'        => 'UFO Test',
	'seo_title'    => 'UFO Test: Motion Blur, Ghosting & Frame Skipping Check',
	'description'  => 'Free UFO test for monitors. Watch UFOs move at 240 to 1920 px/s, see motion blur and ghosting trails, check for skipped frames and read your refresh rate.',
	'intro'        => 'The UFO test shows flying saucers moving at steady speeds so you can judge how your monitor handles motion. Follow a UFO with your eyes: a sharp saucer means low motion blur, a trail or shadow behind it means ghosting or overshoot, and a stutter means skipped frames. Your refresh rate and pixels per frame are measured live.',
	'device'       => 'any',
	'ads'          => 'content',
	'styles'       => array( 'ufo-test' ),
	'scripts'      => array( 'ufo-test' ),
	'embed_height' => 700,
	'tool'         => '<div class="tool-bar ufo-bar">
	<div class="seg" role="group" aria-label="Speed">
		<button type="button" data-ufo-speed="480" aria-pressed="false">Slow</button>
		<button type="button" data-ufo-speed="960" aria-pressed="true">Medium</button>
		<button type="button" data-ufo-speed="1920" aria-pressed="false">Fast</button>
		<button type="button" data-ufo-speed="3840" aria-pressed="false">Very fast</button>
	</div>
	<div class="seg" role="group" aria-label="Background">
		<button type="button" data-ufo-bg="light" aria-pressed="true">Light</button>
		<button type="button" data-ufo-bg="dark" aria-pressed="false">Dark</button>
		<button type="button" data-ufo-bg="stripes" aria-pressed="false">Stripes</button>
	</div>
	<div class="seg" role="group" aria-label="Rows">
		<button type="button" data-ufo-rows="1" aria-pressed="false">1 row</button>
		<button type="button" data-ufo-rows="3" aria-pressed="true">3 rows</button>
		<button type="button" data-ufo-rows="4" aria-pressed="false">4 rows</button>
	</div>
	<div class="btn-row">
		<button type="button" class="btn btn-sm" id="ufo-again">Measure again</button>
		<button type="button" class="btn btn-sm" data-tn-fullscreen="#ufo-stage">Full screen</button>
	</div>
</div>
<div class="tool-stage ufo-stage" id="ufo-stage" data-bg="light"><canvas id="ufo-canvas" aria-label="UFOs moving at three speeds across the screen"></canvas></div>
<div class="stats">
	<div class="stat"><span class="stat-label">Refresh rate</span><span class="stat-value" id="ufo-hz">--</span></div>
	<div class="stat"><span class="stat-label">Frame time</span><span class="stat-value" id="ufo-ms">-</span></div>
	<div class="stat"><span class="stat-label">Pixels per frame</span><span class="stat-value" id="ufo-px">-</span></div>
	<div class="stat"><span class="stat-label">Skipped frames</span><span class="stat-value" id="ufo-skipped">0</span></div>
</div>
<div class="btn-row ufo-foot"><span class="ufo-tip">Tip: track one UFO with your eyes, do not stare at a fixed point.</span></div>
<p class="tool-status" id="ufo-status" aria-live="polite">Measuring your display. Keep this tab in front for a few seconds.</p>',
	'howto'        => array(
		'Let the test run for a few seconds so it can measure your refresh rate. Then pick a speed: <strong>Medium</strong> (960 px/s) is the usual reference, Fast and Very fast show blur more clearly.',
		'Follow one UFO with your eyes as it crosses the screen, the way you would follow a car. This is called smooth pursuit, and it is how motion blur shows up in games.',
		'Look at the edge of the saucer. A crisp edge means low blur. A soft smear or a second faint saucer behind it means ghosting; a bright or dark halo ahead of it means overdrive overshoot (inverse ghosting).',
		'Switch to the <strong>Dark</strong> background to check dark-to-light transitions, which are the slowest on many VA and IPS panels, and to <strong>Stripes</strong> to spot stutter against a fixed pattern.',
		'Watch the <strong>Skipped frames</strong> counter. It should stay at 0 while the tab is in front. Use <strong>Full screen</strong> for the cleanest view.',
	),
	'howto_title'  => 'How to use the UFO test',
	'results'      => '<p>The UFO test does not give a pass or fail score; it shows you motion so you can judge it, and measures the timing behind it.</p>
<ul>
<li><strong>Refresh rate:</strong> the rate the browser is drawing at, which is your monitor\'s current refresh rate. If you own a 144 Hz or 165 Hz monitor and see 60 Hz, the display setting is wrong; the <a href="/refresh-rate-test/">refresh rate test</a> explains the fix.</li>
<li><strong>Frame time:</strong> the time between frames. 16.67 ms is 60 Hz, 6.94 ms is 144 Hz, 4.17 ms is 240 Hz.</li>
<li><strong>Pixels per frame:</strong> how far each UFO jumps between refreshes at the selected speed. Motion blur on a sample-and-hold display is roughly this wide: at 960 px/s a 60 Hz screen smears about 16 px, a 144 Hz screen about 7 px, a 240 Hz screen 4 px. That is why high refresh rates look sharper in motion even when the pixel response time is the same.</li>
<li><strong>Skipped frames:</strong> frames the browser failed to deliver on time. A few after you change a setting or move the window are normal; a steadily rising count while the tab sits still means the computer, a browser extension or a background app is interrupting the display.</li>
</ul>
<p><strong>What you see:</strong> a soft blur that is the same on every UFO is sample-and-hold blur from the refresh rate itself. A <em>trail</em> that follows the saucer, often darker or a different colour, is ghosting from slow pixel response. A <em>bright halo</em> ahead of the saucer is overshoot from an overdrive setting that is too aggressive. Identical UFOs that stutter instead of gliding are skipped or uneven frames.</p>',
	'extra'        => array(
		array(
			'Motion blur, ghosting and overdrive explained',
			'<p>Almost every LCD and OLED is a <strong>sample-and-hold</strong> display: each frame stays on screen until the next one replaces it. When your eye follows a moving UFO, the image sits still on the panel for a whole frame while your eye keeps moving, so the frame is smeared across the retina. The blur is proportional to the frame time, which is why 120, 144 and 240 Hz monitors look sharper in motion even with the same pixel response. Backlight strobing (names like ULMB, ELMB, DyAc, 1 ms MPRT mode) reduces this blur by flashing the image briefly instead of holding it.</p>
<p><strong>Ghosting</strong> is different: it comes from pixels that cannot change colour fast enough, so the old colour lingers behind the moving object. VA panels are the slowest for dark-to-dark transitions, which is why the Dark background often shows a longer trail. Monitors fight ghosting with <strong>overdrive</strong>, which pushes the pixel voltage past the target; too much overdrive overshoots and produces a bright or inverse ghost ahead of the object. The best overdrive setting is the one where the trail is short but there is no halo, which this test lets you compare setting by setting.</p>',
			'blur-ghosting',
		),
		array(
			'How to use the UFO test to tune your monitor',
			'<p>Open your monitor\'s on-screen menu and find the response time or overdrive setting (Off, Normal, Fast, Faster, Extreme, or a number). Run the UFO test at Medium speed on the Dark background, change the setting one step at a time and watch the trail. Pick the strongest setting that does not show a halo ahead of the UFO. Then repeat with the Light background, because overshoot tends to show up on light-to-dark transitions. If a trail remains on every setting, that is the panel\'s limit; no setting removes it. Players who use variable refresh rate (G-Sync, FreeSync) should test at the frame rates they actually play at, because overdrive tuned for 144 Hz often overshoots at 60 Hz. Check that the browser is really running at your refresh rate with the <a href="/fps-test/">FPS test</a>.</p>',
			'tune',
		),
	),
	'fixes'        => array(
		array( 'Every UFO looks blurry', 'Some blur is normal on any display and is wider the lower the refresh rate. Compare rows: the slow row should be sharp. If even the slow row smears, check that the refresh rate shown matches your monitor, and turn on any motion blur reduction mode in the monitor menu.' ),
		array( 'The UFOs stutter instead of gliding', 'Skipped frames. Close other tabs and apps, disable browser extensions, plug in a laptop, and make sure the window is not spanning two monitors with different refresh rates. On Windows, hardware acceleration in the browser settings must be on.' ),
		array( 'I see a bright or dark halo in front of the UFO', 'That is overdrive overshoot. Lower the response time or overdrive setting in the monitor menu by one step and look again.' ),
		array( 'The refresh rate shows 60 Hz on a 144 Hz monitor', 'The display is set to 60 Hz, or the cable cannot carry the higher rate. Set the refresh rate in Windows (Settings, System, Display, Advanced display) or macOS (Displays, Refresh Rate) and use a DisplayPort or a certified HDMI cable.' ),
	),
	'faq'          => array(
		array( 'What is the UFO test?', 'A motion test that moves objects (traditionally flying saucers) across the screen at known speeds so you can see motion blur, ghosting, overshoot and stutter on your own display, and measure the refresh rate behind them.' ),
		array( 'What should the UFO test look like on a good monitor?', 'Sharp saucers with a short, even blur that shrinks as refresh rate rises, no coloured trail behind them, no bright halo in front, and a skipped frame count that stays at zero.' ),
		array( 'Why is the blur the same in every row?', 'If the trail is a plain smear with no colour, it is sample-and-hold blur, which depends on refresh rate and speed, not on the panel. Faster rows should show a wider smear; if they do not, raise the speed setting.' ),
		array( 'Does the UFO test work on a phone?', 'Yes. Phones with 90 or 120 Hz screens show less blur than 60 Hz phones, and OLED phones show almost no ghosting trail because the pixels switch in well under a millisecond.' ),
		array( 'Can this test measure pixel response time in milliseconds?', 'No. Response time needs a photodiode and an oscilloscope. The UFO test shows the visible result of response time so you can compare settings and monitors with your own eyes.' ),
		array( 'Is this the same as the TestUFO ghosting test?', 'It is the same idea: moving saucers at fixed pixel speeds with live frame timing. Use whichever you like; the physics on your screen is identical.' ),
	),
	'related'      => array( 'refresh-rate-test', 'fps-test', 'dead-pixel-test', 'burn-in-test', 'black-screen', 'grey-screen' ),
	'updated'      => '2026-10-28',
);
