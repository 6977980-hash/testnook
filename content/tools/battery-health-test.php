<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Battery Health Test',
	'seo_title'      => 'Battery Health Test: Check Laptop and Phone Battery Online',
	'description'    => 'Free battery health test: see battery level and charging state, measure drain per hour and runtime, and work out real battery health from your capacity report.',
	'intro'          => 'Check how your laptop or phone battery is doing. See the level, charging state and the browser\'s time estimates, run a drain test that measures how many percent you lose per hour, and work out battery health from the design and full charge capacity in your system report.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'battery-health-test' ),
	'scripts'        => array( 'battery-health-test' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-stage bt-stage">
	<div class="bt-battery" aria-hidden="true"><div class="bt-fill" id="bt-fill"></div><span class="bt-bolt">&#9889;</span></div>
	<div class="bt-read"><strong id="bt-pct">-</strong><span id="bt-state">Checking...</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Time to full</span><span class="stat-value" id="bt-tofull">-</span></div>
	<div class="stat"><span class="stat-label">Time left (browser)</span><span class="stat-value" id="bt-toempty">-</span></div>
</div>
<h3 class="bt-h">Drain test</h3>
<div class="tool-bar">
	<div class="btn-row"><button type="button" class="btn btn-primary" id="bt-start">Start drain test</button><button type="button" class="btn" id="bt-stop" disabled>Stop</button></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Elapsed</span><span class="stat-value" id="bt-elapsed">-</span></div>
	<div class="stat"><span class="stat-label">Used</span><span class="stat-value" id="bt-used">-</span></div>
	<div class="stat"><span class="stat-label">Drain rate</span><span class="stat-value" id="bt-rate">-</span></div>
	<div class="stat"><span class="stat-label">Full charge lasts</span><span class="stat-value" id="bt-runtime">-</span></div>
</div>
<ol class="bt-log" id="bt-log"></ol>
<p class="tool-status" id="bt-status" aria-live="polite">Reading the battery...</p>
<details class="bt-calc">
	<summary>Battery health calculator (from a capacity report)</summary>
	<div class="bt-calc-body">
		<label class="field"><span>Design capacity (mWh or mAh)</span><input type="number" id="bt-design" min="1" step="1" inputmode="numeric" placeholder="e.g. 56000"></label>
		<label class="field"><span>Full charge capacity (same unit)</span><input type="number" id="bt-fullcap" min="1" step="1" inputmode="numeric" placeholder="e.g. 48500"></label>
		<p id="bt-health">Enter both values</p>
	</div>
</details>',
	'howto'          => array(
		'Open the page in Chrome or Edge on a laptop, or Chrome on an Android phone. The level and charging state appear at the top. Safari, iPhone and Firefox do not share battery data, so use the system checks below there.',
		'For the drain test, charge to at least 50%, unplug the charger, close heavy apps and set the screen brightness you normally use.',
		'Press <strong>Start drain test</strong> and keep this tab open with the screen on. The page keeps the screen awake where the browser allows it.',
		'After the battery drops 2-3%, the page shows the drain rate in percent per hour and how long a full charge would last at that rate. Run it for 30 minutes or more for a steady figure.',
		'For the real health percentage, read the design and full charge capacity from your system report (see below) and enter them in the calculator.',
	),
	'howto_title'    => 'How to test battery health',
	'results'        => '<p><strong>Battery health</strong> is how much charge the battery can still hold compared with when it was new: full charge capacity divided by design capacity. A web page cannot read those two numbers, but it can measure the effect: how fast the level falls.</p>
<div class="table-scroll"><table>
<thead><tr><th>Health</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>90-100%</td><td>Like new.</td></tr>
<tr><td>80-89%</td><td>Normal wear after one to three years. Apple and most laptop makers treat 80% as the end of a "healthy" battery.</td></tr>
<tr><td>70-79%</td><td>Noticeably shorter runtime. Plan a replacement if you rely on battery life.</td></tr>
<tr><td>Under 70%</td><td>Worn out. Expect sudden shutdowns at 10-20% and much shorter runtime.</td></tr>
</tbody></table></div>
<p>For the drain test, a laptop doing light web work typically uses 8-15% per hour and a phone with the screen on 10-20% per hour. If your result is far higher than the battery life the device was sold with, and nothing heavy is running, the battery has lost capacity or something in the background is draining it.</p>',
	'extra'          => array(
		array(
			'How to check real battery health on each device',
			'<ul>
<li><strong>Windows laptop:</strong> open Command Prompt and run <code>powercfg /batteryreport</code>. Open the battery-report.html file it creates and read DESIGN CAPACITY and FULL CHARGE CAPACITY under Installed batteries. Enter both in the calculator above. The report also lists the cycle count and battery life estimates.</li>
<li><strong>MacBook:</strong> System Settings > Battery > the (i) next to Battery Health shows Normal or Service Recommended and the maximum capacity. Hold Option and click the Apple menu > System Information > Power for the cycle count.</li>
<li><strong>iPhone:</strong> Settings > Battery > Battery Health &amp; Charging shows Maximum Capacity. iPhone 15 and later also show the cycle count under Settings > General > About.</li>
<li><strong>Android:</strong> Pixel 8a and later: Settings > Battery > Battery health. Samsung: the Samsung Members app > Support > Phone diagnostics > Battery status. Many phones show it under Settings > Battery or Device care. The dialer code <code>*#*#4636#*#*</code> opens a testing menu with battery information on some phones.</li>
<li><strong>Chromebook:</strong> open <code>chrome://diagnostics</code> for battery health and cycle count.</li>
</ul>',
			'check-each-device',
		),
		array(
			'Make your battery last longer',
			'<p>Lithium-ion batteries wear fastest when they are hot, kept at 100% for long periods or run down to 0%. Turn on the optimized or limited charging option your device offers (Optimized Battery Charging on Apple, Adaptive Charging on Pixel, Protect Battery on Samsung, or an 80% charge limit in many laptop apps), keep the device out of the sun and off soft surfaces while it works hard, and avoid gaming while fast charging. A few full cycles are fine; there is no need to "calibrate" a modern battery often. For other phone checks, see the <a href="/device-info/">device info</a> page and the <a href="/phone/">phone tests</a>.</p>',
			'battery-tips',
		),
	),
	'fixes'          => array(
		array( 'The page says the battery is not available', 'Safari (Mac and iPhone) and Firefox deliberately hide battery data from web pages for privacy. Use Chrome or Edge on Windows, macOS, ChromeOS or Android, or use the system checks above.' ),
		array( 'It shows 100% and charging on a desktop PC', 'Desktop computers have no battery, and browsers report them as fully charged and plugged in. The drain test only works on a laptop, tablet or phone.' ),
		array( 'The battery drains much faster than expected', 'Check which apps use the most power (Windows: Settings > System > Power & battery > Battery usage; Mac: Activity Monitor > Energy; phones: Settings > Battery). Lower the screen brightness, turn off keyboard backlight and close games or video calls, then run the test again. If it is still fast, the battery is worn.' ),
		array( 'Battery percentage jumps or the device shuts off early', 'This is a sign of a worn battery or an out-of-date charge gauge. Charge to 100%, leave it charging for another hour, then use it until it shuts down once. If it still shuts off early, have the battery checked or replaced.' ),
	),
	'faq'            => array(
		array( 'Can a website check my battery health?', 'Not directly. Browsers that support the Battery Status API (Chrome, Edge, Opera) share only the level, charging state and time estimates. The page measures your drain rate from those; the exact health percentage comes from your system report.' ),
		array( 'How do I check my laptop battery health?', 'On Windows run powercfg /batteryreport in Command Prompt and compare full charge capacity with design capacity. On a Mac open System Settings > Battery > Battery Health.' ),
		array( 'What is a good battery health percentage?', 'Above 80% is considered healthy. New batteries start at 100% (sometimes slightly more) and usually lose about 10-20% in the first two to three years.' ),
		array( 'Why does it not work on my iPhone?', 'Safari does not share battery data with web pages. On iPhone open Settings > Battery > Battery Health & Charging to see the maximum capacity.' ),
		array( 'How long should the drain test run?', 'At least until the battery drops 3-5%, which takes 15-30 minutes on most laptops. A longer test gives a steadier estimate because battery percentages move in whole steps.' ),
		array( 'Does the drain test damage the battery?', 'No. It only measures normal use with the screen on. Discharging from 100% to 50% is a normal part of using the device.' ),
	),
	'related'        => array( 'device-info', 'what-phone-do-i-have', 'vibration-test', 'torch-test', 'touch-screen-test', 'speaker-cleaner', 'camera-test', 'screen-resolution' ),
	'updated'        => '2026-10-29',
);
