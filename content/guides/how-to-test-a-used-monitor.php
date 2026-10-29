<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Test a Used Monitor Before You Buy It',
	'seo_title'   => 'How to Test a Used Monitor Before You Buy: 10-Minute Check',
	'description' => 'A 10-minute checklist for a second-hand monitor: dead pixels, backlight bleed, burn-in, refresh rate, ports and panel hours, with free browser tests for each step.',
	'blurb'       => 'A 10-minute checklist for a second-hand monitor, from dead pixels to refresh rate and ports.',
	'hub'         => 'screen',
	'tool'        => 'monitor-test',
	'tools'       => array( 'dead-pixel-test', 'refresh-rate-test', 'burn-in-test', 'black-screen', 'screen-resolution', 'ufo-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A used monitor can be a bargain or a box of problems that only show up at home. Most faults are visible in ten minutes if you know where to look: dead pixels, uneven backlight, burn-in on OLEDs, a refresh rate that will not go above 60 Hz, or a port that does not work. Bring a laptop and a cable, and go through the checks below in order.',
	'summary'     => array(
		'Bring a <strong>laptop, the right cable</strong> (DisplayPort or HDMI 2.0+ for high refresh rates) and ideally a USB-C cable if the monitor has a USB-C input.',
		'Run full-screen <strong>white, black, red, green and blue</strong> to find dead or stuck pixels, then a dark room check for <strong>backlight bleed</strong> or, on OLED, <strong>burn-in</strong>.',
		'Set the advertised resolution and refresh rate and confirm both with the <a href="/refresh-rate-test/">refresh rate test</a> and <a href="/screen-resolution/">screen resolution</a> page.',
		'Try <strong>every input and the buttons</strong>, look at the stand and the panel surface, and ask for the on-screen usage hours if the menu shows them.',
	),
	'sections'    => array(
		array(
			'What to bring',
			'<ul>
<li><strong>A laptop</strong> with a browser. All the tests on this page run in it, so nothing needs installing on the seller\'s computer.</li>
<li><strong>The right cable.</strong> For 1440p at 144 Hz you need DisplayPort 1.2 or HDMI 2.0; for 4K at 144 Hz, DisplayPort 1.4 or HDMI 2.1. A cheap old HDMI cable can make a good monitor look stuck at 60 Hz. If your laptop only has USB-C, bring a USB-C to DisplayPort cable or adapter that supports the rate you want.</li>
<li><strong>A phone torch</strong> for looking at the surface and the back, and a microfiber cloth.</li>
<li>Ask the seller to have the monitor <strong>on and warm</strong> when you arrive; some faults, such as flicker or a dimming backlight, show up only after 15 minutes.</li>
</ul>',
			'bring',
		),
		array(
			'Step 1: dead and stuck pixels (2 minutes)',
			'<p>Connect the laptop, set the monitor as the main display and open the <a href="/dead-pixel-test/">dead pixel test</a> in full screen on it. Step through white, black, red, green and blue, and look at the whole screen from about 50 cm, then closer at the corners.</p>
<ul>
<li>A <strong>black dot on white</strong> is a dead pixel.</li>
<li>A <strong>colored or white dot on black</strong> is a stuck or hot pixel, which sometimes recovers with the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a>, but do not count on it.</li>
<li>A dot visible on only one of red, green or blue is a single dead subpixel; it is small but permanent.</li>
</ul>
<p>Whether one bad pixel is acceptable is your call; for the price difference it often is, as long as it is not in the middle of the screen. Our guide to <a href="/dead-pixel-vs-stuck-pixel/">dead and stuck pixels</a> explains the difference.</p>',
			'pixels',
		),
		array(
			'Step 2: backlight bleed, uniformity and burn-in (3 minutes)',
			'<p>Dim the room as much as you can and open the <a href="/black-screen/">black screen</a>. On an LCD, look for bright patches leaking in from the edges and corners: some glow at an angle is normal for IPS panels ("IPS glow", which shifts as you move your head), but bright yellow or white patches that stay put are bleed. Our guide to <a href="/backlight-bleed-fix/">backlight bleed</a> shows what is normal.</p>
<p>Then use a mid-gray screen from the <a href="/monitor-test/">monitor test</a>. It should look like one even gray. Dark corners, cloudy blotches or vertical bands are uniformity faults that show in games and films with dark scenes.</p>
<p><strong>On an OLED monitor</strong>, open the <a href="/burn-in-test/">burn-in test</a> and look at the solid gray and color screens for faint shapes of a taskbar, a game HUD or window edges. Ask how the monitor was used; a screen that showed the same desktop all day for two years is the riskiest kind. The <a href="/oled-burn-in-fix/">OLED burn-in guide</a> explains what the panel refresh feature can and cannot fix.</p>',
			'backlight',
		),
		array(
			'Step 3: resolution, refresh rate and motion (3 minutes)',
			'<p>In the laptop\'s display settings, select the monitor\'s full resolution and the highest refresh rate listed. Then check what you actually get:</p>
<ul>
<li>The <a href="/screen-resolution/">screen resolution</a> page shows the resolution and scaling the browser sees.</li>
<li>The <a href="/refresh-rate-test/">refresh rate test</a> should settle on the advertised number (144, 165, 240 Hz) within a few seconds. If it stays at 60, try the other cable or port before you blame the monitor.</li>
<li>The <a href="/ufo-test/">UFO test</a> shows motion blur and overdrive ghosting. A dark trail is normal at slow settings; a bright "inverse ghost" halo means overdrive is set too high, which a menu setting usually fixes.</li>
</ul>
<p>If the monitor has adaptive sync (FreeSync or G-Sync Compatible), check that the option is on in its menu. A monitor that flickers in dark scenes with adaptive sync on may have a fault, but some flicker in loading screens is common.</p>',
			'refresh',
		),
		array(
			'Step 4: inputs, buttons and the body (2 minutes)',
			'<ul>
<li>Plug into <strong>every input</strong> you might use: each HDMI port, DisplayPort and USB-C. A port that shows nothing is a common hidden fault, and often the reason a monitor is sold.</li>
<li>Press every button or the joystick and go through the menu. Look for the <strong>usage hours</strong> or panel information page; many Dell, LG, Samsung and ASUS models show it in a service or information menu.</li>
<li>Check the <strong>surface</strong> with the torch at an angle for scratches, pressure marks and a peeling anti-glare coating, and look for cracks around the stand mount.</li>
<li>Test the <strong>stand</strong>: height, tilt and swivel should move smoothly and hold their position.</li>
<li>If the monitor has <strong>speakers or a USB hub</strong>, play a sound with the <a href="/sound-test/">sound test</a> and plug in a USB stick.</li>
</ul>',
			'inputs',
		),
		array(
			'Red flags and fair prices',
			'<p>Walk away, or negotiate hard, if you see: lines across the screen, flicker at normal brightness, a backlight that dims or changes color after warming up, burn-in visible on a gray screen, a missing input, or a refresh rate that will not go above 60 Hz with a known-good cable. Missing the original power brick is not a fault, but check that a replacement is easy to buy; some monitors need a specific adapter.</p>
<p>Before you agree a price, look up the model number on the label at the back, not the seller\'s description, and compare it with the current new price and recent sold listings for the same model. Knock something off for an expired warranty, a missing stand or a bad pixel.</p>',
			'red-flags',
		),
	),
	'faq'         => array(
		array( 'Can I test a monitor without a computer?', 'Partly. Many monitors have a built-in self-test pattern when no cable is connected, which shows dead pixels and backlight bleed. For refresh rate and the inputs you need a computer, a laptop or a games console.' ),
		array( 'Is one dead pixel a reason not to buy?', 'Not necessarily. Most new monitors are allowed a few under the manufacturer\'s pixel policy. One dead pixel near an edge is usually worth a lower price, one in the center is harder to live with.' ),
		array( 'How do I know how many hours a monitor has been used?', 'Some monitors show it in the menu, often under Information, Display Info or a service menu. If the monitor does not show it, judge by the wear on the stand and the screen surface and ask how it was used.' ),
		array( 'Why does the monitor show only 60 Hz?', 'Usually the cable or port. HDMI 1.4 and many older cables stop at 60 Hz for 1440p and 4K. Use DisplayPort or a certified HDMI 2.0 or 2.1 cable, and pick the higher refresh rate in the display settings.' ),
		array( 'Is OLED burn-in a deal breaker?', 'Visible burn-in on a gray screen does not go away, and it shows in dark games and films. Faint burn-in that you can only see on a pure color screen may be acceptable at a big discount.' ),
		array( 'Can I test a used monitor on a phone?', 'Only with an adapter that sends the phone screen to the monitor, which only some phones support (over USB-C or with a special adapter). A laptop is easier and lets you test high refresh rates.' ),
	),
	'ads'         => 'standard',
);
