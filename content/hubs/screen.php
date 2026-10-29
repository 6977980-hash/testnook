<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Screen & Monitor Tests',
	'seo_title'   => 'Screen Tests: Dead Pixels, Refresh Rate, Burn-in & More',
	'description' => 'Free online screen and monitor tests. Find dead and stuck pixels, check your refresh rate and FPS, spot burn-in, and use full white, black or colour screens.',
	'intro'       => 'Check any monitor, laptop, TV or phone display in the browser: dead pixel and stuck pixel tests, a refresh rate and FPS check, a burn-in test, solid white, black and colour screens, a touch screen test, a calibrated on-screen ruler, and pages that show your screen resolution, size and aspect ratio.',
	'body'        => '<h2>Which screen test do you need?</h2>
<p>For a new or second-hand display, start with the <a href="/dead-pixel-test/">dead pixel test</a>. It cycles full-screen colours so a pixel that stays black, white or one colour shows up against each background. If you find a pixel stuck on one colour, the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a> flashes rapid colours over it, which revives some stuck pixels (never truly dead ones).</p>
<p>Gamers and anyone who just bought a high-refresh monitor should run the <a href="/refresh-rate-test/">refresh rate test</a>: it measures the rate the browser is actually drawing at, which is how you catch a 144 Hz monitor running at 60 Hz because of a cable or a Windows setting. The <a href="/fps-test/">FPS test</a> shows the frame rate your browser can hold, and the <a href="/ufo-test/">UFO test</a> moves saucers at set speeds so you can see motion blur, ghosting and overdrive overshoot and tune the monitor\'s response time setting.</p>
<p>OLED owners can check for ghost images with the <a href="/burn-in-test/">burn-in test</a>. The <a href="/white-screen/">white screen</a> and <a href="/black-screen/">black screen</a> pages give you a clean full-screen colour for backlight bleed checks, cleaning, lighting and spotting dust, and the <a href="/red-screen/">red</a>, <a href="/green-screen/">green</a> and <a href="/blue-screen/">blue</a> screens test one subpixel colour at a time. The <a href="/grey-screen/">grey screen</a> is the one to use for uniformity and dirty screen effect, while the <a href="/yellow-screen/">yellow</a>, <a href="/orange-screen/">orange</a>, <a href="/pink-screen/">pink</a> and <a href="/purple-screen/">purple</a> screens double as warm or coloured lights. The <a href="/online-ruler/">online ruler</a> calibrates to your screen so you can measure real objects, and the <a href="/touch-screen-test/">touch screen test</a> covers phones and tablets.</p>
<h2>Screen resolution, size and ratio</h2>
<p>To find out what screen you have, the <a href="/screen-resolution/">screen resolution</a> page reads the real pixel count, display scaling and browser window size, and names it (Full HD, QHD, 4K). A browser cannot know inches, so the <a href="/screen-size/">screen size</a> page measures the diagonal after you match a bank card on screen. The <a href="/screen-ratio/">screen ratio</a> page tells you whether you have 16:9, 16:10, 3:2 or an ultrawide. Two calculators help when buying or resizing: the <a href="/ppi-calculator/">PPI calculator</a> gives pixel density and the distance at which pixels disappear, and the <a href="/aspect-ratio-calculator/">aspect ratio calculator</a> works out a missing width or height.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>Dead pixels:</strong> always black. Not fixable, but often covered by warranty when there are enough of them.</li>
<li><strong>Stuck pixels:</strong> fixed on red, green, blue or white. Sometimes fixable by rapid flashing.</li>
<li><strong>Backlight bleed and clouding:</strong> light patches on a black screen in a dark room. Normal in small amounts on LCD.</li>
<li><strong>Refresh rate lower than expected:</strong> usually the display setting, a cable that cannot carry the bandwidth, or a laptop power-saving mode.</li>
<li><strong>Burn-in or image retention:</strong> a faint ghost of a logo, taskbar or HUD visible on a grey screen.</li>
</ul>

<h2>Testing tips</h2>
<p>Use the fullscreen button so the browser chrome does not hide the edges. Check in a dark room for black-level faults and in a bright room for dead pixels on white. Clean the screen first: a speck of dust looks exactly like a dead pixel until you wipe it. On a laptop, plug in the charger before a refresh rate test, because many laptops drop to 60 Hz on battery.</p>

<h2>Related pages</h2>
<p>Phone users will find the same tests plus speaker and camera checks on the <a href="/phone/">phone tests</a> page.</p>',
	'faq'         => array(
		array( 'What is the difference between a dead pixel and a stuck pixel?', 'A dead pixel receives no power and stays black on every colour. A stuck pixel is on all the time, so it shows as a bright red, green, blue or white dot. The dead pixel test shows both; only stuck pixels have a chance of being fixed.' ),
		array( 'Why does the refresh rate test show 60 Hz on my 144 Hz monitor?', 'The monitor is capable of 144 Hz but the system is sending 60. Set the refresh rate in your display settings, use a DisplayPort or HDMI 2.0+ cable, and on laptops check that the external monitor is set as the main display or that the browser is on it.' ),
		array( 'Can a browser test damage my screen?', 'No. The pages only show colours. The stuck pixel fixer and burn-in cycle flash colours quickly, so they carry a flashing-light warning and are not recommended for people with photosensitive epilepsy, but they cannot harm the panel.' ),
		array( 'How many dead pixels does a warranty cover?', 'It depends on the maker and the pixel class. Many accept a replacement from 3 to 5 dead pixels or 1 bright pixel in the centre. Check your maker\'s pixel policy and photograph the result of the dead pixel test as evidence.' ),
		array( 'Do these tests work on a TV?', 'Yes, if the TV has a browser or you connect a laptop to it. Use fullscreen mode so the whole panel is covered. The burn-in and black screen tests are the most useful on OLED TVs.' ),
		array( 'Is backlight bleed a defect?', 'A little glow at the edges of an LCD on a black screen in a dark room is normal and not grounds for a return. Large bright patches that you can see at normal brightness in a normally lit room are worth a replacement request.' ),
	),
	'updated'     => '2026-10-29',
	'ads'         => 'standard',
);
