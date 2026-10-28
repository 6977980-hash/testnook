<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Burn-in Test',
	'seo_title'      => 'Screen Burn-in Test: Check OLED and LCD for Ghost Images',
	'description'    => 'Free online burn-in test for OLED, AMOLED and LCD screens. Full-screen grey, colour, gradient and checkerboard patterns reveal ghost images; clear retention.',
	'intro'          => 'Find out whether your phone, monitor or TV has burn-in. Open the full-screen test patterns and look for faint ghost shapes of icons, logos or a keyboard. The auto cycle runs the patterns for a set time to help clear temporary image retention.',
	'device'         => 'any',
	'ads'            => 'none',
	'styles'         => array( 'burn-in-test' ),
	'scripts'        => array( 'burn-in-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar bi-bar">
	<button type="button" class="btn btn-primary" id="bi-start">Open full-screen test</button>
	<label class="bi-opt">Cycle every <select id="bi-speed"><option value="1">1 s</option><option value="3" selected>3 s</option><option value="10">10 s</option></select></label>
	<label class="bi-opt">for <select id="bi-mins"><option value="5">5 min</option><option value="10" selected>10 min</option><option value="30">30 min</option><option value="60">1 hour</option></select></label>
</div>
<label class="bi-agree"><input type="checkbox" id="bi-agree"> I understand the auto cycle changes the whole screen between bright colours every few seconds and nobody watching is sensitive to that.</label>
<div class="tool-bar"><button type="button" class="btn" id="bi-cycle" disabled>Run auto cycle</button></div>
<div class="tool-stage bi-stage">
	<div class="bi-preview" id="bi-preview" role="button" tabindex="0" aria-label="Open full screen"><span>Click to go full screen</span></div>
	<div class="bi-swatches" aria-label="Patterns">
		<button type="button" class="bi-swatch" data-bi-pattern="grey" style="background:#808080" aria-label="50% grey" aria-pressed="true"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="white" style="background:#ffffff" aria-label="White"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="red" style="background:#ff0000" aria-label="Red"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="green" style="background:#00ff00" aria-label="Green"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="blue" style="background:#0000ff" aria-label="Blue"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="black" style="background:#000000" aria-label="Black"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="gradient" style="background:linear-gradient(to right,#000,#fff)" aria-label="Grey gradient"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="checker" style="background:repeating-conic-gradient(#000 0% 25%,#fff 0% 50%) 0 0 / 20px 20px" aria-label="Checkerboard"></button>
		<button type="button" class="bi-swatch" data-bi-pattern="bars" style="background:linear-gradient(to right,#fff 0 12.5%,#ff0 0 25%,#0ff 0 37.5%,#0f0 0 50%,#f0f 0 62.5%,#f00 0 75%,#00f 0 87.5%,#000 0)" aria-label="Colour bars"></button>
	</div>
	<p class="bi-keys">In full screen: <kbd>click</kbd> or <kbd>&rarr;</kbd> for the next pattern, <kbd>Esc</kbd> to exit.</p>
</div>
<div class="bi-screen" id="bi-screen" hidden tabindex="-1"><div class="bi-hint" id="bi-hint"></div></div>
<p class="tool-status" id="bi-status" aria-live="polite">Start with the 50% grey pattern: burn-in shows most clearly on a mid grey.</p>',
	'howto'          => array(
		'Set the screen to its normal brightness and, if you can, dim the room. Press <strong>Open full-screen test</strong>.',
		'Look at the <strong>50% grey</strong> pattern first. Burn-in shows up as darker or discoloured ghost shapes where a fixed image used to sit: the status bar, navigation buttons, a keyboard, a channel logo or a taskbar.',
		'Click or press <strong>&rarr;</strong> to move through white, red, green, blue, black, the gradient, the checkerboard and the colour bars. Some ghosts show only on one colour; the gradient shows uneven brightness and the checkerboard shows blur or crosstalk.',
		'If you see a faint ghost, it may be temporary image retention. Tick the box and run the <strong>auto cycle</strong> for 10-30 minutes, then check the grey pattern again.',
		'If the ghost looks exactly the same after the cycle, it is permanent burn-in. See the sections below for what you can and cannot do about it.',
	),
	'howto_title'    => 'How to test for screen burn-in',
	'results'        => '<ul>
<li><strong>Nothing but an even colour on every pattern:</strong> no burn-in. Faint vignetting (darker corners) on a large OLED is normal.</li>
<li><strong>A ghost of a fixed image on grey or white that fades after the cycle:</strong> image retention. The pixels were driven at the same level for too long and recover with varied content. Common on OLED phones after long sessions in one app, and on some LCDs.</li>
<li><strong>A ghost that stays after the cycle:</strong> burn-in. On OLED the pixels in that area have aged more than their neighbours and output less light, so the shape is permanent. On LCD a permanent shadow is rarer and usually means the liquid crystal has taken a set.</li>
<li><strong>A pink or green tint across a band:</strong> uneven ageing of one colour\'s subpixels, usually from a fixed white element. Also permanent.</li>
<li><strong>Patches on the gradient:</strong> brightness or colour unevenness (mura), a panel quality issue rather than burn-in.</li>
</ul>',
	'results_title'  => 'Burn-in vs image retention',
	'extra'          => array(
		array(
			'Why OLED screens burn in',
			'<p>Every pixel in an OLED screen is its own tiny light. Pixels that spend hours showing the same bright thing age faster than the rest, so when the whole screen shows one grey, those pixels are a little dimmer and the old image appears as a shadow. Modern panels fight this with pixel shifting, logo dimming, periodic refresh cycles and brighter, longer-lasting materials, so burn-in on a phone or TV bought in the last few years takes years of heavy, static use. Static elements at high brightness are the risk: a navigation bar, a game HUD, a news ticker, a desktop taskbar.</p>
<p>LCD screens do not burn in the same way because the backlight is shared. They can suffer image retention when a static image sits for a long time, especially on older IPS and VA panels, and it almost always clears with a few hours of varied content or a dark screen. The <a href="/dead-pixel-test/">dead pixel test</a> and the <a href="/white-screen/">white screen</a> and <a href="/black-screen/">black screen</a> pages help with the other panel checks: stuck pixels, backlight bleed and clouding.</p>',
			'why',
		),
		array(
			'Can burn-in be fixed?',
			'<p>Image retention: yes. Run the auto cycle here, or show varied full-screen video for a while, and it fades. Many TVs also have a "pixel refresh" or "panel refresh" in the settings that runs when the TV is off; run it once if your TV has it.</p>
<p>Permanent burn-in: no. The aged pixels cannot be restored. A TV\'s pixel refresh can reduce the contrast of the ghost by slightly ageing the surrounding pixels to match, which is why those routines run rarely and take an hour. Apps and videos that promise to "fix" burn-in do the same thing less precisely, at the cost of panel life. Prevention is what works: lower brightness, auto-hide the taskbar or navigation bar, use dark mode, turn on pixel shift and screen savers, and avoid leaving a static picture on an OLED for hours. If a new screen shows burn-in within the warranty period, claim it; several makers cover it.</p>',
			'fix',
		),
	),
	'fixes'          => array(
		array( 'A faint shadow of the keyboard or status bar', 'Run the auto cycle for 10-30 minutes and check the grey pattern again. If it has faded, it was image retention; lower the screen brightness and use dark mode to slow it down. If it is unchanged, it is burn-in and cannot be removed.' ),
		array( 'A ghost of a TV channel logo or a game HUD', 'Run the TV\'s own pixel refresh from the picture settings (sometimes under "OLED care" or "panel maintenance"), then test again. Future-proof it with logo dimming and the screen saver options in the TV menu.' ),
		array( 'Corners or edges darker than the middle', 'Normal vignetting on large OLEDs and backlight unevenness on LCDs. Not burn-in, and usually invisible on real content. The gradient and 50% grey make it look worse than it is.' ),
		array( 'A pink or green band after months of a bright static element', 'Uneven colour ageing. Permanent, but less visible at lower brightness and with a warmer colour setting. Claim the warranty if the screen is new.' ),
	),
	'faq'            => array(
		array( 'How do I check for burn-in?', 'Open the full-screen test and look at the 50% grey pattern for ghost shapes of things that usually sit in one place, such as icons, a keyboard or a logo. Step through the other patterns to confirm.' ),
		array( 'What is the difference between burn-in and image retention?', 'Image retention is temporary and fades after varied content or the auto cycle. Burn-in is permanent pixel wear and looks the same after the cycle.' ),
		array( 'Does the burn-in test work on an iPhone or Android phone?', 'Yes. Open the page in Safari or Chrome and press the full-screen button. Both OLED and LCD phones can be tested.' ),
		array( 'Can this test fix burn-in?', 'It can clear image retention. Permanent burn-in cannot be fixed by any app or video.' ),
		array( 'Does the test harm my screen?', 'No. The patterns are ordinary colours at your current brightness, the same as any app. The auto cycle changes the pattern every few seconds, which is gentler than most games.' ),
		array( 'Why test on grey instead of white?', 'Burn-in is a small difference in brightness between neighbouring pixels. On a mid grey the eye picks up that difference best; on full white some panels reduce brightness and hide it.' ),
	),
	'related'        => array( 'dead-pixel-test', 'white-screen', 'black-screen', 'stuck-pixel-fixer', 'refresh-rate-test', 'fps-test' ),
	'updated'        => '2026-10-28',
);
