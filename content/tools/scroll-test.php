<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Scroll Test',
	'seo_title'      => 'Mouse Scroll Wheel Test: Find Skipping and Reverse Scrolls',
	'description'    => 'Free online scroll wheel test. Scroll in the box to count every notch up and down, catch wrong-way scrolls and skipped steps, and see the distance per click.',
	'intro'          => 'Check whether your mouse wheel scrolls the wrong way, skips or jumps. Scroll inside the box: every notch is counted, a notch that goes against the direction you are scrolling is flagged, and the strip shows exactly how far each click moves.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a mouse with a scroll wheel. Finger scrolling on a touch screen does not reach the test. Try the <a href="/touch-screen-test/">touch screen test</a> instead.',
	'ads'            => 'standard',
	'styles'         => array( 'scroll-test' ),
	'scripts'        => array( 'scroll-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn" id="sc-reset">Reset</button>
		<button type="button" class="btn" data-tn-fullscreen="#tool">Full screen</button>
	</div>
</div>
<div class="tool-stage sc-stage" id="sc-stage">
	<div class="sc-wheel" aria-hidden="true">
		<div class="sc-arrow" id="sc-up">&#9650;</div>
		<div class="sc-arrow" id="sc-down">&#9660;</div>
	</div>
	<div class="sc-strip-wrap">
		<div class="sc-strip" id="sc-strip"></div>
		<p>Scroll the wheel here. The stripes move with each notch.</p>
	</div>
</div>
<div class="stats sc-stats">
	<div class="stat"><span class="stat-label">Up</span><span class="stat-value" id="sc-upc">0</span></div>
	<div class="stat"><span class="stat-label">Down</span><span class="stat-value" id="sc-downc">0</span></div>
	<div class="stat"><span class="stat-label">Wrong-way scrolls</span><span class="stat-value" id="sc-flips">0</span></div>
	<div class="stat"><span class="stat-label">Double steps</span><span class="stat-value" id="sc-skips">0</span></div>
	<div class="stat"><span class="stat-label">Last notch (deltaY)</span><span class="stat-value" id="sc-delta">-</span></div>
	<div class="stat"><span class="stat-label">Notches per second</span><span class="stat-value" id="sc-rate">0/s</span></div>
	<div class="stat"><span class="stat-label">Delta mode</span><span class="stat-value" id="sc-mode">-</span></div>
</div>
<div class="sc-log" id="sc-log" aria-label="Recent notches"></div>
<p class="tool-status" id="sc-status" aria-live="polite">Scroll the wheel inside the box, slowly at first, then faster.</p>',
	'howto'          => array(
		'Put the pointer inside the box and scroll <strong>down</strong> slowly, one click at a time, for about ten clicks. Every click should add one to the Down count and show a ▼ chip.',
		'Scroll <strong>up</strong> the same way. Then scroll quickly in each direction for a few seconds.',
		'Watch <strong>Wrong-way scrolls</strong>. A red chip appears when a notch goes against the direction you were scrolling: that is the classic worn-encoder fault that makes pages jump back.',
		'Watch <strong>Double steps</strong>: a notch that moved twice the usual distance, which means the wheel skipped a step.',
		'Press <strong>Reset</strong> after cleaning the wheel or changing a setting, and test again.',
	),
	'howto_title'    => 'How to test your scroll wheel',
	'results'        => '<ul>
<li><strong>Up and down counts match your clicks:</strong> the wheel encoder is healthy.</li>
<li><strong>Wrong-way scrolls appear while scrolling steadily in one direction:</strong> the wheel encoder is worn or dirty. The mouse sends a notch in the opposite direction every few clicks, which you feel as a page that jerks back. This is the most common scroll wheel fault and it gets worse over time.</li>
<li><strong>Double steps appear:</strong> the wheel sometimes jumps two notches at once. Often dust in the encoder; sometimes a game or browser smooth-scroll setting merging two events.</li>
<li><strong>Nothing counts for some clicks:</strong> missed notches. If you scroll ten clicks and the count says seven, the encoder is skipping.</li>
<li><strong>Last notch (deltaY)</strong> is the distance the browser scrolls per click, in pixels for most mice (100 or 120 in Chrome on Windows, 3 lines on some systems). A free-spinning or smooth-scroll wheel sends many small values, which is normal.</li>
</ul>',
	'results_title'  => 'What the scroll test shows',
	'extra'          => array(
		array(
			'Why a mouse wheel scrolls the wrong way',
			'<p>Most scroll wheels use a mechanical rotary encoder: a small drum with metal contacts that opens and closes two switches as it turns. The order in which they switch tells the mouse the direction. When the contacts wear or pick up dust and skin oil, one switch bounces, and the mouse reads a click backwards. The result is a page that jumps up while you scroll down, which is what this scroll test flags as a wrong-way scroll. Optical encoders, used in some newer and more expensive mice, do not have this problem.</p>
<p>If your wheel scrolls in the wrong direction <em>all</em> the time, that is a setting, not a fault: "natural scrolling" on macOS, or the "Scroll direction" option in Windows 11 mouse settings.</p>',
			'why-reverse',
		),
		array(
			'Cleaning a scroll wheel',
			'<p>Unplug the mouse or turn it off. Blow compressed air into the gap around the wheel from several angles while spinning the wheel. Then spin it fast in both directions for twenty seconds to scrape the contacts clean. Test again here. If wrong-way scrolls persist, a drop of contact cleaner on the encoder (this needs the mouse opened) often fixes it for months; replacing the encoder is a cheap repair for anyone comfortable with a soldering iron. Check the rest of the mouse with the <a href="/mouse-tester/">mouse tester</a>, the <a href="/double-click-test/">double click test</a> and the <a href="/mouse-polling-rate-test/">polling rate test</a>.</p>',
			'cleaning',
		),
	),
	'fixes'          => array(
		array( 'The wheel scrolls back on its own', 'A worn encoder. Clean it with compressed air and spin the wheel hard in both directions. If the test still shows wrong-way scrolls, the encoder needs contact cleaner or replacement.' ),
		array( 'Scrolling is jerky or skips lines', 'Check "Double steps" and missed clicks here. If the test counts every notch correctly, the jerkiness comes from software: turn off smooth scrolling in the browser or the mouse software, or lower the lines-per-notch setting in Windows mouse settings.' ),
		array( 'The wheel scrolls the wrong way everywhere', 'That is a setting. On macOS, untick "Natural scrolling" under Mouse in System Settings. On Windows 11, change "Scroll direction" in Bluetooth & devices, Mouse. Logitech and Razer software also have a reverse option per mouse.' ),
		array( 'Nothing happens when I scroll', 'Make sure the pointer is inside the box. If the wheel works on other pages but not here, a browser extension may be intercepting wheel events; try a private window.' ),
	),
	'faq'            => array(
		array( 'How do I test my mouse scroll wheel?', 'Scroll inside the box on this page. Every click is counted up or down, and a notch that goes against your direction is flagged as a wrong-way scroll.' ),
		array( 'Why does my mouse scroll up when I scroll down?', 'Usually a worn or dirty wheel encoder that sends an occasional backwards click. The test shows exactly how often it happens.' ),
		array( 'What does deltaY mean?', 'The scroll distance the browser receives per notch. 100 or 120 pixels per click is typical; smooth-scroll wheels send many small values.' ),
		array( 'Can I test horizontal scrolling?', 'Not on this page. It counts vertical notches only, which is where almost all scroll wheel faults appear.' ),
		array( 'Does the test work with a trackpad?', 'Two-finger scrolling sends wheel events, so the counts and strip work, but the wrong-way and double-step checks are meant for a physical wheel.' ),
		array( 'Can a scroll wheel be fixed?', 'Often yes. Compressed air and spinning the wheel fixes most cases; a replacement encoder costs very little and takes ten minutes with a soldering iron.' ),
	),
	'related'        => array( 'mouse-tester', 'double-click-test', 'mouse-polling-rate-test', 'dpi-analyzer', 'cps-test', 'keyboard-tester' ),
	'updated'        => '2026-10-28',
);
