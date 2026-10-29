<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'What DPI Should I Use? Mouse DPI for Gaming and Work',
	'seo_title'   => 'What DPI Should I Use? Best Mouse DPI for Gaming, Work',
	'description' => 'Which mouse DPI to use for FPS games, MOBAs, design work and a 4K desktop, what eDPI and cm/360 mean, why high DPI is not better and how to check your real DPI.',
	'blurb'       => 'Good DPI settings for shooters, other games and desktop work, and why higher is not better.',
	'hub'         => 'mouse',
	'tool'        => 'dpi-analyzer',
	'tools'       => array( 'mouse-accuracy-test', 'mouse-polling-rate-test', 'mouse-tester' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Mouse boxes advertise 26,000 DPI, but most good players use 400 to 1600. The right number depends on your screen, your games and how you like to move your arm. Here is how to choose a DPI, and how to tune the sensitivity that really matters.',
	'summary'     => array(
		'For shooters, most players use <strong>400, 800 or 1600 DPI</strong> and fine-tune with the in-game sensitivity. 800 is the most common choice.',
		'What matters is <strong>eDPI</strong> (DPI times in-game sensitivity) or <strong>cm/360</strong> (how far you move the mouse to turn around), not DPI on its own.',
		'For desktop work, pick a DPI that lets you cross the screen with a short wrist movement: about <strong>800 to 1600</strong> on 1080p and <strong>1600 to 3200</strong> on 4K.',
		'Very high DPI settings add no precision you can use and can add jitter. Check your mouse\'s <strong>real DPI</strong> before copying anyone\'s settings.',
	),
	'sections'    => array(
		array(
			'What DPI actually is',
			'<p>DPI (dots per inch), also called CPI (counts per inch), is how many movement counts the mouse sensor reports for each inch you move it. At 800 DPI, one inch of movement sends 800 counts; on the desktop with no acceleration that moves the cursor about 800 pixels. At 1600 DPI the same inch moves the cursor twice as far.</p>
<p>So DPI is a speed setting, not a quality setting. A higher number does not make the mouse more accurate; it makes it more sensitive. Every gaming sensor made in the last several years tracks cleanly at normal DPI values, so the choice is about comfort and control.</p>
<p>The printed DPI is also not always exact. Sensors can be a few percent off, and two mice set to "800" may move the cursor different distances. The <a href="/dpi-analyzer/">DPI analyzer</a> measures the real value by having you move the mouse a known distance.</p>',
			'what-dpi-is',
		),
		array(
			'Good DPI by use',
			'<div class="table-scroll"><table>
<thead><tr><th>Use</th><th>Common DPI</th><th>Why</th></tr></thead>
<tbody>
<tr><td>Tactical shooters (CS2, Valorant)</td><td>400 to 800</td><td>Low sensitivity with big arm movements gives steady, precise aim.</td></tr>
<tr><td>Fast shooters (Apex, Overwatch, Fortnite)</td><td>800 to 1600</td><td>A little faster for tracking and quick turns.</td></tr>
<tr><td>MOBA and RTS</td><td>1200 to 3200</td><td>The cursor crosses the whole screen often; a higher DPI saves wrist travel.</td></tr>
<tr><td>Office work on 1080p</td><td>800 to 1600</td><td>Cross the screen with a small wrist movement.</td></tr>
<tr><td>Office work on 1440p or 4K</td><td>1600 to 3200</td><td>More pixels to cross at the same physical speed.</td></tr>
<tr><td>Photo and design work</td><td>800 to 1600, plus a zoom shortcut</td><td>Fine control near the cursor matters more than speed.</td></tr>
</tbody></table></div>
<p>These are starting points, not rules. If you play with your wrist and a small mousepad, you will want a higher sensitivity; if you play with your whole arm on a large pad, a lower one.</p>',
			'by-use',
		),
		array(
			'eDPI and cm/360: the numbers that matter in games',
			'<p>In games your aim speed is DPI multiplied by the game\'s sensitivity setting. That product is <strong>eDPI</strong>. 800 DPI at 0.5 sensitivity and 400 DPI at 1.0 sensitivity both give an eDPI of 400 and feel the same in that game.</p>
<p>eDPI only compares within one game, because each game scales sensitivity differently. To compare across games, use <strong>cm/360</strong>: how many centimetres you move the mouse to turn a full circle. Many tactical shooter players sit somewhere between 25 and 50 cm/360; fast arena shooters are often lower, around 15 to 30 cm.</p>
<p>A simple way to find your own: set a sensitivity, stand in front of a clear object in the game and move the mouse across the pad in one smooth swipe. If you overshoot targets often, lower the sensitivity by about 10%. If you run out of mousepad during a turn, raise it. Repeat over a few sessions until both feel natural, then stop changing it so muscle memory can build.</p>',
			'edpi',
		),
		array(
			'Why higher DPI is not better',
			'<p>A 26,000 DPI setting means the cursor moves 26,000 pixels per inch, which crosses a 4K screen in less than a sixth of an inch. Nobody can aim like that. Players who set a very high DPI then lower the in-game or Windows sensitivity end up with the same speed and nothing gained.</p>
<p>Some sensors also add smoothing or show tiny jitter at very high DPI, because each count stands for a smaller distance and noise becomes visible. At 400 to 3200 DPI that is not an issue on any modern gaming mouse.</p>
<p>One case for a slightly higher DPI with lower in-game sensitivity: in menus and on the desktop, very low DPI on a high resolution screen can feel sluggish. 1600 DPI with a lower in-game value gives the same aim with a quicker desktop.</p>
<p>Keep Windows pointer speed at the default (6 of 11) and turn off "Enhance pointer precision" if you want consistent movement; that option is mouse acceleration and changes how far the cursor goes depending on speed.</p>',
			'higher-not-better',
		),
		array(
			'How to check and set your DPI',
			'<ol>
<li><strong>Find the current setting</strong> in the mouse software or from the DPI button, which usually cycles through preset steps shown by a colour light.</li>
<li><strong>Measure the real DPI</strong> with the <a href="/dpi-analyzer/">DPI analyzer</a>: move the mouse a known distance along a ruler and the tool counts what it receives. A deviation of a few percent is normal.</li>
<li><strong>Pick one value</strong> from the table above and set the in-game sensitivity to taste.</li>
<li><strong>Check your aim</strong> on the <a href="/mouse-accuracy-test/">mouse accuracy test</a>. Try the same mode and target size before and after a change and compare accuracy and time per target, not just the score.</li>
<li><strong>Give it a week.</strong> Any new sensitivity feels wrong for the first few days. Judge it after your hand has adapted.</li>
</ol>',
			'check-and-set',
		),
	),
	'data'        => array(
		'boards' => array( 'aim-static-28' ),
		'title'  => 'How people aim on Testnook',
		'after'  => 'check-and-set',
		'html'   => '<p>On the mouse accuracy test in its standard mode (static targets, 28 px), the median score over the last 30 days was <strong>{median:aim-static-28}</strong> and the top 10% scored <strong>{top10:aim-static-28}</strong> or more, from {count:aim-static-28} runs. Use it as a reference when you try a new DPI: the score combines accuracy, speed and how close to the centre you click. The best named runs are on the <a href="/leaderboards/">leaderboards</a>.</p>',
	),
	'faq'         => array(
		array( 'Is 800 or 1600 DPI better?', 'Neither is better. 1600 DPI with half the in-game sensitivity feels the same as 800 DPI. 1600 makes the desktop a little quicker; 800 is the most common choice among shooter players.' ),
		array( 'What DPI do pro players use?', 'Most professional shooter players use 400 or 800 DPI with a low in-game sensitivity, and a growing number use 1600. Very few use more than 3200.' ),
		array( 'Does higher DPI make aim more accurate?', 'No. DPI is sensitivity, not accuracy. Above about 3200 DPI some sensors even get slightly noisier.' ),
		array( 'What is eDPI?', 'Effective DPI: your mouse DPI multiplied by the in-game sensitivity. It lets you compare settings with other players of the same game.' ),
		array( 'Should I turn off mouse acceleration?', 'For gaming, usually yes. Turn off "Enhance pointer precision" in Windows and any acceleration in the mouse software so the same hand movement always moves the same distance.' ),
		array( 'What DPI is good for a 4K monitor?', 'For desktop work, about 1600 to 3200 DPI so you can cross the screen without lifting the mouse. In games, DPI and resolution are unrelated; use the same eDPI you would on any screen.' ),
	),
);
