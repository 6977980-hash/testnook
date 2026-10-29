<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Battery Health Explained: What the Percentage Means',
	'seo_title'   => 'Battery Health Explained: Capacity, Cycles, Replacing',
	'description' => 'What battery health percentage means on phones and laptops, how charge cycles wear a battery, when to replace it, how to check it and habits that slow wear.',
	'blurb'       => 'What maximum capacity and charge cycles mean, when to replace a battery and how to slow wear.',
	'hub'         => 'phone',
	'tool'        => 'battery-health-test',
	'tools'       => array( 'device-info', 'what-phone-do-i-have' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Battery health is how much charge your battery can still hold compared with when it was new. Every phone and laptop battery loses some with use. Here is what the percentage and cycle count mean, how fast wear is normal, when a replacement makes sense and what actually slows the decline.',
	'summary'     => array(
		'Battery health (or <strong>maximum capacity</strong>) is today\'s full charge as a share of the original. 85% means a full charge holds 85% of what it did when new.',
		'Lithium-ion batteries wear with <strong>charge cycles</strong>, heat and time. Most phones are designed to keep about <strong>80% after 500 to 1000 full cycles</strong>.',
		'Below <strong>80%</strong>, runtime gets noticeably shorter and some phones slow down or shut off at low charge. That is the usual point to replace the battery.',
		'Heat is the biggest enemy. Avoid charging in a hot car or under a pillow, and use the phone\'s <strong>optimised or limited charging</strong> option if you keep it plugged in for long.',
	),
	'sections'    => array(
		array(
			'What battery health means',
			'<p>A new battery has a design capacity, measured in milliamp-hours (mAh) for phones or watt-hours (Wh) for laptops. As it ages, chemical changes inside the cells reduce how much charge they can store. Battery health is the current full charge capacity divided by the design capacity.</p>
<p>So a phone with a 4,000 mAh battery at 85% health now holds about 3,400 mAh when the screen says 100%. The charge indicator still runs from 0 to 100, but each percent lasts a little less time. A phone that used to last a full day at 100% health lasts roughly until late afternoon at 80%.</p>
<p>The number comes from the battery\'s own controller chip, which tracks charge flowing in and out. It is an estimate and can jump a point or two after an update or a full charge as the chip recalibrates.</p>',
			'what-it-means',
		),
		array(
			'Charge cycles and normal wear',
			'<p>One charge cycle is 100% of the battery\'s capacity used, in any number of steps. Using 50% today and 50% tomorrow is one cycle. Most modern phones are rated to keep about 80% of their capacity after 500 cycles, and recent iPhone models are rated for 1000 cycles. Laptops are usually rated between 300 and 1000 cycles.</p>
<div class="table-scroll"><table>
<thead><tr><th>Health</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>90 to 100%</td><td>Like new. Typical for the first year.</td></tr>
<tr><td>80 to 89%</td><td>Normal wear after one to three years. Still fine for most people.</td></tr>
<tr><td>70 to 79%</td><td>Noticeably shorter runtime. Plan a replacement if you rely on battery life.</td></tr>
<tr><td>Under 70%</td><td>Worn out. Expect sudden shutdowns at 10 to 20% and much shorter use.</td></tr>
</tbody></table></div>
<p>Wear is fastest in the first months and then slows to a steady decline. A phone charged once a day reaches about 365 cycles a year, so most phones land somewhere in the 80s by the end of their second year.</p>',
			'cycles',
		),
		array(
			'How to check battery health',
			'<ul>
<li><strong>iPhone:</strong> Settings > Battery > Battery Health (or Battery Health & Charging) shows Maximum Capacity. iPhone 15 and later also show the cycle count in Settings > General > About.</li>
<li><strong>Android:</strong> it depends on the maker. Many phones show a battery health status or capacity under Settings > Battery or the maker\'s device care app; some only show it in a service menu or a diagnostics app.</li>
<li><strong>Windows laptops:</strong> run <code>powercfg /batteryreport</code> in a command prompt and open the report. Compare FULL CHARGE CAPACITY with DESIGN CAPACITY.</li>
<li><strong>Mac:</strong> hold Option and click the Apple menu > System Information > Power. It shows the cycle count and the condition.</li>
</ul>
<p>The <a href="/battery-health-test/">battery health test</a> on this site shows the current level and charging state where the browser allows it, measures drain per hour while you use the device, and works out health from the capacity figures in your report.</p>',
			'check',
		),
		array(
			'When to replace the battery',
			'<p>A replacement is worth it when the phone or laptop still does what you need but no longer lasts the day. Good signs it is time:</p>
<ul>
<li>Health is below 80%, or the phone shows a service warning.</li>
<li>The device shuts down at 10 to 30% charge, or in the cold.</li>
<li>The phone slows down under load. Some phones limit performance on a worn battery to avoid shutdowns.</li>
<li>The battery is swollen: a lifting screen, a bulging back or a trackpad that no longer clicks. <strong>Stop using and charging it</strong> and get it replaced, because swollen lithium-ion cells can catch fire.</li>
</ul>
<p>A battery swap at an authorised repair shop costs much less than a new phone and usually brings runtime back to new. Cheap unbranded batteries are often lower capacity than claimed; use a reputable shop.</p>',
			'replace',
		),
		array(
			'How to make a battery last longer',
			'<ol>
<li><strong>Keep it cool.</strong> Heat speeds up wear more than anything else. Do not leave a phone in a hot car or sun, and take it out of a thick case if it gets hot while charging or gaming.</li>
<li><strong>Use optimised or limited charging.</strong> iPhones have Optimized Charging and an 80% limit option on newer models; many Android phones have "protect battery" or adaptive charging; many laptops can stop at 80% when plugged in all day.</li>
<li><strong>Avoid sitting at 0% or 100% for long.</strong> Short top-ups between about 20% and 80% are gentler than full cycles, but there is no need to obsess: modern phones manage this well.</li>
<li><strong>Use a decent charger.</strong> Fast charging is safe on phones designed for it, but cheap uncertified chargers can overheat.</li>
<li><strong>Store at about half charge</strong> if you put a device away for weeks, and charge it every few months.</li>
</ol>
<p>Old habits such as "always drain it to zero" come from older battery types and do not apply to lithium-ion. Draining fully is worse, not better.</p>',
			'last-longer',
		),
	),
	'faq'         => array(
		array( 'What is a good battery health percentage?', 'Above 80% is good for a phone or laptop in daily use. 90% or more is typical for the first year; below 80% is the usual point to think about a replacement.' ),
		array( 'How fast does battery health drop?', 'Typically a few percent in the first months and then about 1 percent a month with daily charging, so most phones are in the 80s after two years. Heat speeds it up.' ),
		array( 'Is it bad to charge my phone overnight?', 'Not much on modern phones. They stop charging at 100%, and optimised charging holds the battery at about 80% until shortly before you wake up. Avoid doing it under a pillow where it gets hot.' ),
		array( 'Does fast charging damage the battery?', 'Not noticeably on phones designed for it. The heat it makes is what matters, so avoid fast charging in a hot place or while gaming.' ),
		array( 'Can battery health go back up?', 'Not really. The number can rise a point or two after recalibration, but lost capacity does not come back. Only a new battery restores it.' ),
		array( 'Why does my phone die at 20%?', 'A worn battery cannot deliver enough power under load when its charge is low, so the phone shuts down early. It is a common sign that the battery needs replacing.' ),
	),
	'sources'     => array(
		array( 'Apple: iPhone battery and performance', 'https://support.apple.com/en-us/101575' ),
		array( 'Battery University: How to prolong lithium-based batteries', 'https://batteryuniversity.com/article/bu-808-how-to-prolong-lithium-based-batteries' ),
	),
);
