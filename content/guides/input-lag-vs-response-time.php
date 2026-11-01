<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Input Lag vs Response Time: What Is the Difference?',
	'seo_title'   => 'Input Lag vs Response Time: The Difference Explained',
	'description' => 'Input lag is the delay before a new frame appears; response time is how fast pixels change. What each causes, what a UFO test shows and how reviewers test.',
	'blurb'       => 'Two different monitor delays, what each one causes, and why a browser cannot measure input lag.',
	'hub'         => 'screen',
	'tool'        => 'ufo-test',
	'tools'       => array( 'refresh-rate-test', 'mouse-latency-test' ),
	'published'   => '2026-11-01',
	'updated'     => '2026-11-01',
	'intro'       => 'Monitor boxes print "1 ms" in big letters, and reviews talk about input lag in milliseconds too. They are not the same thing. One decides how soon a new frame starts to appear; the other decides how cleanly it appears. Here is what each one means, what you can see for yourself in a browser, and what needs lab equipment.',
	'summary'     => array(
		'<strong>Input lag</strong> is the time from the signal reaching the monitor to the new image <em>starting</em> to show. It makes the game feel delayed. It comes from the monitor\'s processing and from the refresh cycle itself.',
		'<strong>Response time</strong> is how long a pixel takes to change from one shade to another, usually quoted as gray-to-gray (GtG). Slow response causes blur and smearing behind moving objects; too much overdrive causes bright or dark halos (overshoot).',
		'The <a href="/ufo-test/">UFO test</a> shows the <strong>visible result</strong> of response time and refresh rate: blur, ghosting, overshoot and skipped frames. It cannot show input lag, because a delay that affects the whole picture equally looks the same as no delay.',
		'A browser <strong>cannot measure</strong> monitor input lag: it never learns when the panel actually lit up. Reviewers use a photodiode on the screen or a high-speed camera.',
	),
	'sections'    => array(
		array(
			'Input lag: when the new frame starts to appear',
			'<p>Input lag (also called display lag) is the delay between the computer sending a frame and the monitor starting to show it. RTINGS defines it as the time a monitor takes "to process the signal sent from a computer or console and for the image to start appearing on the screen." Part of it is processing inside the monitor: scaling a non-native resolution, picture modes, frame buffering for some overdrive or motion features. On TVs this processing is why "Game mode" exists.</p>
<p>The other part is the refresh itself. A monitor draws the screen from top to bottom over one refresh cycle, so the center of the screen is reached half a frame after the top. That gives a floor nobody can go below at a given refresh rate:</p>
<div class="table-scroll"><table>
<thead><tr><th>Refresh rate</th><th>One frame</th><th>Half a frame (center of the screen)</th></tr></thead>
<tbody>
<tr><td>60 Hz</td><td>16.7 ms</td><td>8.3 ms</td></tr>
<tr><td>144 Hz</td><td>6.9 ms</td><td>3.5 ms</td></tr>
<tr><td>240 Hz</td><td>4.2 ms</td><td>2.1 ms</td></tr>
<tr><td>360 Hz</td><td>2.8 ms</td><td>1.4 ms</td></tr>
</tbody></table></div>
<p>So the biggest input lag improvement most people can buy is a higher refresh rate, and making sure it is really turned on. The <a href="/refresh-rate-test/">refresh rate test</a> shows what your screen is running at right now.</p>
<p>Input lag is only one link of the chain. The full delay you feel from click to screen also includes the mouse (polling interval), the game and the graphics card (frame time and render queue) and the operating system. The monitor is often the smaller part on a good gaming setup.</p>',
			'input-lag',
		),
		array(
			'Response time: how fast pixels change',
			'<p>Response time is how long a pixel takes to move from one shade to another. Because the speed depends on the start and end shade, reviewers measure many gray-to-gray (GtG) transitions, from dark to bright and back, and report an average and the worst cases. The "1 ms" on the box is usually the best single transition with the strongest overdrive setting, which often adds overshoot.</p>
<p>What slow response time looks like: a dark smear or trail behind a moving object, worst on dark backgrounds on many VA panels. What too much overdrive looks like: a bright or dark halo in front of or around the object (inverse ghosting). Both are about how clean the image is, not how soon it arrives.</p>
<p>Response time is also not the whole story of motion blur. On a normal LCD or OLED every frame stays on screen until the next one (sample-and-hold), and your eye tracking a moving object smears it across the screen even with instant pixels. That kind of blur only shrinks with a higher refresh rate or with backlight strobing (often called motion blur reduction or ULMB). RTINGS now scores motion with a single number that combines response time and overshoot, called Cumulative Absolute Deviation.</p>',
			'response-time',
		),
		array(
			'Side by side',
			'<div class="table-scroll"><table>
<thead><tr><th></th><th>Input lag</th><th>Response time</th></tr></thead>
<tbody>
<tr><td>What it is</td><td>Delay before a new frame starts to appear</td><td>Time for a pixel to finish changing shade</td></tr>
<tr><td>What you notice</td><td>The game feels sluggish or "floaty"</td><td>Blur, smearing, ghost trails or halos</td></tr>
<tr><td>Main causes</td><td>Monitor processing, scaling, refresh rate</td><td>Panel type, overdrive setting, temperature</td></tr>
<tr><td>How to improve it</td><td>Higher refresh rate, native resolution, game mode, no extra processing</td><td>Try each overdrive step, pick the one with the least trail and no halo</td></tr>
<tr><td>Visible in a UFO test?</td><td>No</td><td>Yes, as blur, trails and overshoot</td></tr>
</tbody></table></div>',
			'side-by-side',
		),
		array(
			'What a UFO test can and cannot show',
			'<p>The <a href="/ufo-test/">UFO test</a> moves objects across the screen at a fixed speed. That makes it very good for things you see in the picture itself:</p>
<ul>
<li><strong>Blur and trails</strong> from slow pixels or sample-and-hold. Compare the UFOs at full and reduced frame rates to see how much a higher refresh rate helps.</li>
<li><strong>Overshoot</strong>: change the monitor\'s overdrive setting one step at a time and watch for a halo in front of the UFO.</li>
<li><strong>Skipped or uneven frames</strong>: stutter in the motion means the browser or the monitor is dropping frames.</li>
</ul>
<p>It cannot show input lag, because every part of the picture is delayed by the same amount and there is nothing to compare it with. It also cannot give response time in milliseconds; that needs a light sensor and an oscilloscope. Use it to compare settings and monitors with your own eyes, not to get a lab number.</p>',
			'ufo-test',
		),
		array(
			'Why a browser cannot measure input lag',
			'<p>A web page knows when it asked for a new frame and when the browser says that frame was ready. It does not know when the graphics card sent it down the cable, when the monitor finished processing it, or when the pixels changed. There is no browser feature that reports when light left the panel. On the input side, the page only sees an event after the mouse, USB and operating system have already handled the click.</p>
<p>So a browser tool can measure the parts inside the computer, which is what the <a href="/mouse-latency-test/">mouse latency test</a> does: polling interval, event handling and time to the next frame. A <a href="/reaction-time-test/">reaction time test</a> includes all of the delays, yours and the hardware\'s, in one number, but cannot separate them. Any web page that claims to measure your monitor\'s input lag in milliseconds is guessing.</p>',
			'browser-limits',
		),
		array(
			'How reviewers measure them',
			'<p><strong>Input lag:</strong> RTINGS uses a photodiode device connected to a PC. A program flashes a white square in the middle of the screen and records the time until the sensor sees the image start to appear, at the monitor\'s native resolution and at different refresh rates, averaging many measurements. Others film a mouse click and the screen with a high-speed camera and count frames, or use a latency analyzer built into some gaming monitors and mice.</p>
<p><strong>Response time:</strong> a light sensor on the screen records the brightness of a patch while it switches between shades of gray, from black (0%) to white (100%) in steps, in both directions. Software turns those curves into a table of transition times. RTINGS measured this at the center of the screen for each overdrive setting and picked the best one for its reviews; its newer test bench combines response time and overshoot into one motion score.</p>
<p>When you read a review, check which refresh rate and which overdrive mode the numbers are for. A monitor can have low input lag and still smear, or respond fast and still feel delayed because of heavy processing.</p>',
			'how-measured',
		),
	),
	'faq'         => array(
		array( 'Is 1 ms response time the same as 1 ms input lag?', 'No. Response time is how fast a pixel changes shade, input lag is how soon a new frame starts to appear. A "1 ms" monitor can still have several milliseconds of input lag.' ),
		array( 'Which matters more for gaming, input lag or response time?', 'Both, for different reasons. Low input lag makes aim feel immediate; fast response time keeps moving targets sharp. For most players the biggest gain for both is a higher refresh rate that is actually turned on.' ),
		array( 'Does a higher refresh rate reduce input lag?', 'Yes. Frames arrive more often, so a new image starts sooner: the half-frame floor drops from 8.3 ms at 60 Hz to 3.5 ms at 144 Hz.' ),
		array( 'Can I test input lag online?', 'Not the monitor part. A browser cannot see when the panel lights up. It can measure the computer side, which is what our mouse latency test does.' ),
		array( 'What is overshoot?', 'When overdrive pushes a pixel too hard, it goes past the target shade before settling, which shows as a bright or dark halo around moving objects. Lower the overdrive setting one step.' ),
		array( 'Does game mode reduce input lag?', 'On TVs and some monitors, yes. It turns off processing such as motion smoothing and noise reduction that holds frames back.' ),
	),
	'sources'     => array(
		array( 'RTINGS: Monitor input lag test methodology', 'https://www.rtings.com/monitor/tests/inputs/input-lag' ),
		array( 'RTINGS: Monitor response time test methodology', 'https://www.rtings.com/monitor/tests/motion/motion-blur-and-response-time' ),
		array( 'RTINGS: Cumulative Absolute Deviation (CAD) motion test', 'https://www.rtings.com/monitor/tests/motion/cumulative-absolute-deviation' ),
		array( 'Wikipedia: Display lag', 'https://en.wikipedia.org/wiki/Display_lag' ),
		array( 'Blur Busters: TestUFO motion tests', 'https://www.testufo.com/' ),
	),
	'ads'         => 'standard',
);
