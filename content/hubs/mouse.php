<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Mouse Tests',
	'seo_title'   => 'Mouse Tests: Buttons, Double Click, Scroll, DPI & Polling',
	'description' => 'Free online mouse tests. Check every button, catch a mouse that double clicks on its own, test the scroll wheel, and measure real DPI and polling rate in Hz.',
	'intro'       => 'Six browser tests for any wired, wireless or gaming mouse: buttons and side buttons, accidental double clicks, scroll wheel skipping, real DPI, polling rate in Hz and clicks per second. Nothing to install.',
	'body'        => '<h2>Which mouse test do you need?</h2>
<p>If a button feels unreliable, begin with the <a href="/mouse-tester/">mouse tester</a>. It lights up left, right, middle, side and extra buttons as you press them and shows scroll wheel movement, so a button that does not register or that registers late is obvious. If one click sometimes opens two things, run the <a href="/double-click-test/">double click test</a>: it counts clicks that arrive closer together than a human can click, which is the classic sign of a worn switch.</p>
<p>The <a href="/scroll-test/">scroll test</a> looks at the wheel alone: skipped notches, double steps and wrong-way scrolls where the page jumps back a line while you scroll down. Those point to a dirty or worn encoder rather than a software setting.</p>
<p>Gaming mice get two more pages. The <a href="/dpi-analyzer/">DPI analyzer</a> measures the sensor\'s real DPI by moving the mouse a known distance, and the <a href="/mouse-polling-rate-test/">polling rate test</a> reports how often the mouse sends its position, nearest to 125, 500, 1000 Hz or higher. The <a href="/cps-test/">CPS test</a> measures how fast you can click rather than the mouse itself.</p>

<h2>What the tests can find</h2>
<ul>
<li><strong>A button that does not register:</strong> dead switch or cable fault. If it works on another computer, it is a driver or software conflict instead.</li>
<li><strong>Phantom double clicks:</strong> switch bounce from a worn microswitch. Very common after a year or two of heavy use.</li>
<li><strong>Scroll wheel skipping or reversing:</strong> dirt or wear on the wheel encoder.</li>
<li><strong>DPI that does not match the setting:</strong> the sensor or the driver profile is wrong, which throws off game sensitivity.</li>
<li><strong>Polling rate lower than advertised:</strong> the mouse is in a power-saving mode, the software set a lower rate, or a USB hub is slowing it down.</li>
</ul>

<h2>Before you blame the mouse</h2>
<p>Plug the mouse directly into the computer, not a hub or a monitor port. Check the double-click speed in your operating system, because a very fast setting can make normal clicks look like doubles. Turn off any mouse software profile and test again. Wireless mice often behave differently when the battery is low or the receiver is far away.</p>

<h2>On a phone or tablet?</h2>
<p>These tests need a physical mouse. For the screen itself, the <a href="/touch-screen-test/">touch screen test</a> finds dead touch zones and tests multi-touch.</p>',
	'faq'         => array(
		array( 'Why does my mouse double click when I click once?', 'The microswitch under the button has worn and the contacts bounce, so one press is read as two. The double click test confirms it. Fixes range from a drop of contact cleaner to replacing the switch or the mouse.' ),
		array( 'Do the tests work with a wireless mouse?', 'Yes. Bluetooth and 2.4 GHz mice send the same events to the browser. A wireless mouse that fails only sometimes may have a low battery or interference, so test with the receiver close to it.' ),
		array( 'What polling rate should my mouse have?', 'Office mice usually run at 125 Hz, which is fine for everyday use. Gaming mice run at 500 or 1000 Hz, and some reach 4000 or 8000 Hz over a wired connection. The polling rate test shows the nearest standard rate.' ),
		array( 'Can the browser read my side buttons?', 'Most browsers report the two side buttons (back and forward) as buttons 4 and 5. Extra buttons on gaming mice are often mapped to keyboard shortcuts by the mouse software and show up as keys instead.' ),
		array( 'My scroll wheel jumps back while scrolling down. Is the mouse broken?', 'Usually the wheel encoder is dirty or worn. The scroll test counts those wrong-way scrolls. Cleaning the wheel with compressed air sometimes helps; a worn encoder needs replacing.' ),
		array( 'Why does the DPI analyzer show a different number than my mouse software?', 'Small differences come from measurement error and acceleration settings. A large difference means the active profile does not match what you think, or the sensor is not running at its stated resolution. Turn off pointer acceleration and measure again.' ),
	),
	'updated'     => '2026-10-28',
	'ads'         => 'standard',
);
