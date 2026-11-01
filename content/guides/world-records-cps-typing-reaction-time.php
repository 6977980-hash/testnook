<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'World Records for Clicking, Typing and Reaction Time',
	'seo_title'   => 'CPS, Typing and Reaction Time World Records (Sourced)',
	'description' => 'The verified records for mouse clicks per minute, typing speed and reaction time, with sources, dates, and which "records" are just a website leaderboard.',
	'blurb'       => 'Verified records for clicks, typing speed and reaction time, with sources and dates.',
	'hub'         => 'benchmark',
	'tool'        => 'cps-test',
	'tools'       => array( 'typing-speed-test', 'reaction-time-test', '60-second-click-test', '1-minute-typing-test' ),
	'published'   => '2026-11-01',
	'updated'     => '2026-11-01',
	'intro'       => 'Search for "CPS world record" or "fastest typist" and you get dozens of different numbers, most with no source. This page lists only records we could trace to an official record body or to a dated report, and says plainly when a "record" is the top of one website\'s leaderboard.',
	'summary'     => array(
		'<strong>Mouse clicks:</strong> the Guinness World Records title for most mouse clicks in one minute is <strong>760 clicks</strong> (about 12.7 per second), set by Yiğit Arslan in Istanbul on 10 February 2026.',
		'<strong>Typing:</strong> Guinness lists <strong>216 words per minute</strong> by Stella Pajunas on an IBM electric typewriter in 1946. On Monkeytype, a typing website, the player known as Rocket typed <strong>304.76 WPM</strong> in its 15-second test (reported in May 2024). That is a website leaderboard score, not an official record.',
		'<strong>Reaction time:</strong> there is no official record. In sprinting, World Athletics counts any start faster than <strong>0.100 seconds</strong> after the gun as a false start, on the basis that nobody can react that fast to the sound.',
		'Your own numbers: about 4-6 CPS, 40 WPM and 200-300 ms reaction time are normal. See how you compare on the <a href="/leaderboards/">Testnook leaderboards</a>, which are our own and not world records.',
	),
	'sections'    => array(
		array(
			'Clicks per second (CPS) record',
			'<p>The only click speed record we found from an official record body is the Guinness World Records title <strong>"Most mouse clicks in one minute"</strong>: <strong>760 clicks</strong> by Turkish esports player Yiğit "Yigox" Arslan, set in Istanbul on 10 February 2026 with a Logitech G PRO X2 SUPERSTRIKE mouse. Averaged over the minute that is 760 / 60 = <strong>12.7 clicks per second</strong>.</p>
<p>That is a one-minute record. Guinness does not list a "clicks per second" record for 1, 5 or 10 seconds, so the CPS "world records" you see quoted for short tests (often 14, 20 or even 50+ CPS) are scores on individual websites or in videos. Very high numbers usually come from <strong>butterfly</strong> clicking (two fingers on one button) or <strong>drag</strong> clicking (dragging a finger across the button so it bounces), which depend heavily on the mouse and are not comparable with normal clicking.</p>
<p>To put 12.7 CPS in perspective: on our <a href="/cps-test/">CPS test</a> most people score 4-6 CPS over 5 seconds, fast one-finger clickers top out around 6-8, and the rate drops in longer tests as the finger tires. Sustaining more than 12 CPS for a whole minute is exceptional. Try the <a href="/60-second-click-test/">60 second click test</a> to see how far you are from 760.</p>',
			'cps',
		),
		array(
			'Typing speed records',
			'<p>Typing records depend on the test: the length, the text (simple words or real sentences), whether mistakes count, and the keyboard. Two figures can be sourced:</p>
<div class="table-scroll"><table>
<thead><tr><th>Record</th><th>Speed</th><th>Who and when</th><th>Status</th></tr></thead>
<tbody>
<tr><td>Fastest typist on an electronic typewriter</td><td>216 WPM for one minute</td><td>Stella Pajunas, Chicago, 1946, IBM machine</td><td>Guinness World Records</td></tr>
<tr><td>Monkeytype 15-second test</td><td>304.76 WPM</td><td>"Rocket" (MythicalRocket), reported May 2024</td><td>Top of a website leaderboard, not an official record</td></tr>
</tbody></table></div>
<p>The two are not comparable. A 15-second test of common English words allows a short burst without fatigue, while a one-minute test on a typewriter is a different task. Monkeytype\'s leaderboards change often, so check the <a href="https://monkeytype.com/leaderboards" rel="nofollow noopener" target="_blank">live Monkeytype leaderboard<span class="visually-hidden"> (opens in a new tab)</span></a> for the current top scores rather than trusting a number in an article, including this one.</p>
<p>Guinness also lists records for stenotype machines, which type whole syllables or words per stroke; those are far higher and measure a different skill.</p>
<p>For comparison, about 40 WPM is a typical speed for people who use a computer regularly. Test yourself on the <a href="/typing-speed-test/">typing speed test</a> or the <a href="/1-minute-typing-test/">1 minute typing test</a>, and see <a href="/average-typing-speed/">average typing speed</a> for the full scale.</p>',
			'typing',
		),
		array(
			'Reaction time: why there is no world record',
			'<p>No record body keeps a "fastest human reaction time" record, because the number depends completely on the test: the signal (light, sound or touch), the hardware delay and how a "false start" is defined. A guess that happens to land early is not a reaction.</p>
<p>The closest thing to an official limit comes from sprinting. Starting blocks measure how soon after the gun a runner pushes off, and World Athletics treats any reaction under <strong>0.100 seconds</strong> as a false start, based on tests suggesting the brain cannot hear and process the start sound faster. A 2009 study commissioned by the IAAF (now World Athletics) found that top sprinters can sometimes react in about 0.08 seconds, so the line is debated. It made headlines at the 2022 World Championships in Eugene, when hurdler Devon Allen was disqualified with a reaction of 0.099 seconds.</p>
<p>On a computer, a visual reaction time test also includes the delay of your mouse, browser and monitor, often 10-30 ms or more. Typical results are 200-300 ms; our <a href="/reaction-time-test/">reaction time test</a> does not count clicks under 100 ms because they are almost always anticipation. See <a href="/average-reaction-time/">average reaction time</a> for the scale by age and device.</p>',
			'reaction',
		),
		array(
			'How to read any "world record" claim',
			'<ul>
<li><strong>Who verified it?</strong> An official body (Guinness, a sports federation) with a dated record page, or a website\'s own leaderboard? Both are interesting; only one is a world record.</li>
<li><strong>What exactly was measured?</strong> Clicks in one minute and clicks per second over 5 seconds are different records. So are WPM on random words and WPM on sentences with punctuation.</li>
<li><strong>When?</strong> Website leaderboards change every month. A record without a date is probably out of date.</li>
<li><strong>What equipment?</strong> Mouse switches, double-click faults and special techniques change click counts; keyboard layout and stenotype machines change typing speed.</li>
</ul>
<p>Our own <a href="/leaderboards/">leaderboards</a> show the best named scores on Testnook for CPS, reaction time, typing and mouse accuracy. They are checked for impossible results, but they are a website leaderboard like any other.</p>',
			'reading-claims',
		),
	),
	'faq'         => array(
		array( 'What is the world record for clicks per second?', 'There is no official clicks-per-second record. The Guinness record is for clicks in one minute: 760, which is about 12.7 per second, by Yiğit Arslan on 10 February 2026.' ),
		array( 'What is the most mouse clicks in one minute?', '760 clicks, the Guinness World Records title set by Yiğit Arslan in Istanbul on 10 February 2026.' ),
		array( 'Who is the fastest typist in the world?', 'It depends on the test. Guinness lists Stella Pajunas at 216 WPM on an electric typewriter in 1946. On Monkeytype\'s 15-second test, Rocket reached 304.76 WPM (reported May 2024), a website leaderboard score.' ),
		array( 'What is the fastest human reaction time?', 'There is no official record. World Athletics treats any sprint start under 0.100 seconds as a false start, because a reaction faster than that is not considered possible to the gun.' ),
		array( 'Are Testnook leaderboards world records?', 'No. They are the best named scores on this site, checked for impossible results. They are useful for comparing yourself with other Testnook users.' ),
		array( 'Why do I see different CPS records on different sites?', 'Each site counts its own top score, over its own test length, with its own rules. Butterfly and drag clicking also give much higher numbers than normal clicking.' ),
	),
	'sources'     => array(
		array( 'Guinness World Records: Logitech G case study, Most mouse clicks in one minute (760, 10 February 2026)', 'https://www.guinnessworldrecords.com/business-solutions/case-studies/logitech-turkiye-en' ),
		array( 'Guinness World Records: Fastest typist on an electronic typewriter (216 WPM, 1946)', 'https://www.guinnessworldrecords.com/world-records/67967-fastest-typist-on-an-electronic-typewriter' ),
		array( 'GIGAZINE (31 May 2024), citing PCMag: 17-year-old reaches 305 WPM on Monkeytype', 'https://gigazine.net/gsc_news/en/20240531-worlds-fastest-typist-17-years-old' ),
		array( 'Monkeytype: live leaderboards', 'https://monkeytype.com/leaderboards' ),
		array( 'Wikipedia: False start (0.100 s rule and the 2009 IAAF study)', 'https://en.wikipedia.org/wiki/False_start' ),
		array( 'AP via WSLS (18 July 2022): Was Devon Allen too fast for his own good?', 'https://www.wsls.com/sports/2022/07/18/explainer-was-devon-allen-too-fast-for-his-own-good/' ),
	),
	'ads'         => 'standard',
);
