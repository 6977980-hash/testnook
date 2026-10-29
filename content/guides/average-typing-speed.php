<?php
defined( 'ABSPATH' ) || exit;

$bands = require dirname( __DIR__ ) . '/tools/_bands.php';
return array(
	'title'       => 'Average Typing Speed by Age and Job (WPM Explained)',
	'seo_title'   => 'Average Typing Speed: WPM by Age, Job and Skill Level',
	'description' => 'The average typing speed is about 40 WPM. See typical words per minute by age and profession, what counts as fast, how WPM is calculated and how to type faster.',
	'blurb'       => 'Typical words per minute by age and job, how WPM is counted, and how to get faster.',
	'hub'         => 'typing-test',
	'tool'        => 'typing-test-english',
	'tools'       => array( '1-minute-typing-test', 'wpm-test', 'typing-speed-test', 'keyboard-tester' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'The average person types around 40 words per minute. Touch typists reach 60 to 80, professionals pass 100. Here is what the numbers mean, how they change with age and practice, and what actually makes you faster.',
	'summary'     => array(
		'The average typing speed for adults is <strong>about 40 WPM</strong>; the mean in a large online study was 52 WPM, because people who take typing tests are faster than average. <strong>50 to 70 WPM</strong> is good.',
		'<strong>60 to 80 WPM</strong> is a good speed for office work. <strong>Over 100 WPM</strong> is professional level; the fastest typists exceed 150 WPM for a minute.',
		'A "word" is five characters, including spaces. Accuracy matters: most tests subtract uncorrected errors, so slower and accurate beats fast and messy.',
		'Speed peaks between about 20 and 40 and falls slowly after. Touch typing, not finger speed, is what separates 40 from 80 WPM.',
	),
	'sections'    => array(
		array(
			'How WPM is calculated',
			'<p>Words per minute does not count real words. By convention a word is <strong>five characters, including spaces and punctuation</strong>, so "I am happy today" (16 characters) is 3.2 words. That keeps a test with long words fair against one with short words.</p>
<p>Most tests, including ours, report two numbers. <strong>Gross WPM</strong> is every character you typed divided by five, per minute. <strong>Net WPM</strong> (the headline score) subtracts one word for every uncorrected error. If you type 300 characters in one minute with 4 mistakes left in the text, gross is 60 WPM and net is 56 WPM. Accuracy is the share of characters that were right.</p>
<p>Errors you fix with backspace before the end cost time but not words, which is why good typists correct as they go.</p>',
			'how-wpm-works',
		),
		array(
			'Average typing speed by skill level',
			$bands['wpm'] . '
<p>The most detailed public study of real typing (168,000 volunteers, 136 million keystrokes, 2018) found a mean of 52 WPM with a long tail: the fastest 1% typed over 120 WPM. Those volunteers chose to take a typing test, so the true population average is lower, which is where the common "40 WPM" figure comes from.</p>',
			'by-level',
		),
		array(
			'Typing speed by age',
			'<p>Speed rises through the school years as children get regular keyboard time, peaks in the twenties and thirties, and declines gently after. Typical net speeds on a one minute test:</p>
<div class="table-scroll"><table>
<thead><tr><th>Age</th><th>Typical range</th><th>Notes</th></tr></thead>
<tbody>
<tr><td>8 to 11</td><td>10 to 25 WPM</td><td>Hunt and peck; speed depends almost entirely on keyboard time at school.</td></tr>
<tr><td>12 to 16</td><td>25 to 45 WPM</td><td>Big gains from chat and homework; touch typing is rarely taught now.</td></tr>
<tr><td>17 to 24</td><td>40 to 60 WPM</td><td>Peak learning years; this is when touch typing is easiest to pick up.</td></tr>
<tr><td>25 to 40</td><td>45 to 65 WPM</td><td>Fastest group on average, mostly through daily work.</td></tr>
<tr><td>41 to 60</td><td>40 to 55 WPM</td><td>Little change for people who type every day.</td></tr>
<tr><td>Over 60</td><td>30 to 45 WPM</td><td>Slower key presses, but trained touch typists keep most of their speed.</td></tr>
</tbody></table></div>
<p>The spread inside each group dwarfs the difference between groups. A 65-year-old touch typist beats most 20-year-olds who look at the keys.</p>',
			'by-age',
		),
		array(
			'Typing speed by job',
			'<ul>
<li><strong>Data entry and transcription:</strong> employers usually ask for 60 to 80 WPM with 98% accuracy; medical transcriptionists often work at 80 to 100.</li>
<li><strong>Administrative and office roles:</strong> 50 to 70 WPM is the usual expectation; 40 is a common minimum in job adverts.</li>
<li><strong>Programmers:</strong> 50 to 80 WPM is typical. Speed on code matters less than on prose because of autocomplete and the time spent thinking, but accuracy with symbols does.</li>
<li><strong>Writers and journalists:</strong> 70 to 100 WPM. Thinking, not typing, is the limit, but a fast typist loses fewer thoughts.</li>
<li><strong>Court reporters:</strong> 225 WPM on a stenotype machine, which uses chords, not single keys. On a normal keyboard they are around 100 to 120.</li>
</ul>
<p>Most companies that test typing use a one minute or three minute test with net WPM and an accuracy floor. Our <a href="/1-minute-typing-test/">1 minute test</a> and <a href="/5-minute-typing-test/">5 minute test</a> work the same way, so you can rehearse under the same conditions.</p>',
			'by-job',
		),
		array(
			'How to type faster',
			'<ol>
<li><strong>Learn touch typing properly.</strong> Home row (ASDF JKL;), each finger owning its keys, eyes on the screen. Expect your speed to drop for two or three weeks and then pass your old peak. This single change is worth more than everything else combined.</li>
<li><strong>Accuracy first, speed follows.</strong> Practice at a pace where you make almost no errors; speed comes from fewer corrections, not from faster fingers.</li>
<li><strong>Short daily sessions.</strong> Ten to fifteen minutes a day beats an hour once a week. Most people gain 5 to 10 WPM a month in the first few months.</li>
<li><strong>Type real text.</strong> Random words train finger movement; sentences and paragraphs train the rhythm and the common letter pairs that make up most of what you type. Our <a href="/typing-test-english/">English typing test</a> uses both.</li>
<li><strong>Check the keyboard.</strong> A key that registers late or needs a second press costs more time than it seems. If your accuracy is oddly low on one letter, run the <a href="/keyboard-tester/">keyboard tester</a>.</li>
<li><strong>Use shortcuts for correction.</strong> Ctrl+Backspace (Option+Delete on a Mac) deletes a whole word; fixing one mistake with one keystroke saves seconds per paragraph.</li>
</ol>',
			'type-faster',
		),
	),
	'data'        => array(
		'boards' => array( 'typing-60' ),
		'title'  => 'What people actually score on Testnook',
		'after'  => 'by-level',
		'html'   => '<p>Real numbers from the 1 minute typing tests on this site over the last 30 days: the median was <strong>{median:typing-60}</strong> and the fastest 10% typed <strong>{top10:typing-60}</strong> or more. A net speed of 60 WPM beats {beats:typing-60:60} of results here. The quickest named runs are on the <a href="/leaderboards/">leaderboards</a>.</p>',
	),
	'faq'         => array(
		array( 'What is a good typing speed?', 'About 40 WPM is average. 50 to 70 WPM is good and enough for almost any job, 70 to 100 is fast, and over 100 WPM is very fast.' ),
		array( 'Is 50 WPM fast?', 'It is a little above the average adult, and close to the mean of 52 WPM for people who take online typing tests. For office work it is adequate; most jobs that test typing ask for 40 to 60.' ),
		array( 'What is the fastest typing speed ever?', 'Sustained records on a standard keyboard are around 216 WPM over 50 minutes (Stella Pajunas, 1946, on an electric typewriter) and over 200 WPM in short modern competition runs. On a stenotype, court reporters exceed 300 WPM in bursts.' ),
		array( 'How many keystrokes per hour is 40 WPM?', 'About 12,000 KPH, since a word is five keystrokes: 40 x 5 x 60. Data entry jobs that ask for 8,000 KPH want roughly 27 WPM; 10,000 KPH is about 33 WPM.' ),
		array( 'Does the keyboard matter?', 'A little. Low-profile laptop keys and mechanical keyboards with light switches help some people by a few WPM; a layout you are used to matters more. Phone typing is slower for almost everyone, about 35 to 40 WPM with two thumbs.' ),
		array( 'Why is my accuracy good but my speed low?', 'Usually because you look at the keys, or you pause before uncommon letters. Both are signs that touch typing is not yet automatic. Keep practicing at your comfortable pace; the pauses shrink first, then the speed rises.' ),
	),
	'sources'     => array(
		array( 'Dhakal V, Feit AM, Kristensson PO, Oulasvirta A, "Observations on Typing from 136 Million Keystrokes", CHI 2018', 'https://userinterfaces.aalto.fi/136Mkeystrokes/' ),
	),
);
