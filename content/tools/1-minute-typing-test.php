<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_typing-test.php';

return array(
	'title'          => '1 Minute Typing Test',
	'seo_title'      => '1 Minute Typing Test: Your WPM in 60 Seconds (Free)',
	'description'    => 'Free 1 minute typing test on real English sentences. Type for 60 seconds and get your words per minute, accuracy and errors, plus the averages to compare with.',
	'intro'          => 'The standard one minute test, the length used by most typing courses and job assessments. You type real English sentences with capitals and punctuation for 60 seconds, then see your words per minute and accuracy.',
	'device'         => 'any',
	'ads'            => 'content',
	'stats'          => array( 'typing-60' ),
	'styles'         => array( 'typing-test' ),
	'scripts'        => array( 'typing-test' ),
	'embed_height'   => 600,
	'tool'           => $tool( array(), 60, 'sentences' ),
	'howto'          => array(
		'Click the text (or tap the box on a phone). The 60 second clock starts on your first key.',
		'Type the sentences exactly as shown, including capital letters, commas and full stops. Press <strong>space</strong> after every word.',
		'Correct letters turn dark; mistakes turn red. Backspace within a word fixes it; once you press space the word is scored.',
		'When the minute is up the result appears. Press <strong>Tab</strong> or Restart for a new set of sentences.',
		'Take it three times and keep the middle score; a single minute is short enough that one slip changes the number.',
	),
	'howto_title'    => 'How to take the 1 minute typing test',
	'results'        => '<p>In one minute an average adult types about 40 words, a good office typist 60 and a professional 80 or more. The sentences include punctuation and capitals, which typically cost 5-10 WPM compared with a plain word test, because the shift key and the symbol keys are slower than letters.</p>
<div class="table-scroll"><table>
<thead><tr><th>WPM in 1 minute</th><th>Level</th></tr></thead>
<tbody>
<tr><td>Under 30</td><td>Beginner. Usually two or three fingers and looking at the keys.</td></tr>
<tr><td>30-50</td><td>Average adult.</td></tr>
<tr><td>50-70</td><td>Good. The range most typing jobs require.</td></tr>
<tr><td>70-100</td><td>Fast. Daily typists with full touch typing.</td></tr>
<tr><td>Over 100</td><td>Very fast.</td></tr>
</tbody></table></div>
<p><strong>WPM</strong> is correct characters divided by five; <strong>raw WPM</strong> includes mistakes; <strong>accuracy</strong> is the share of characters you typed correctly. Only results with accuracy of 90% or better are saved as a best, because a fast run full of errors is not a useful benchmark.</p>',
	'extra'          => array(
		array(
			'Why one minute is the standard',
			'<p>Typing courses, schools and recruitment tests settled on one minute because it is long enough to average out a slow start and short enough to repeat several times in a session. Most published averages, such as the figure of about 40 WPM for adults, come from one minute tests on everyday text, so a one minute score is the one to quote. The downside is variance: a single bad word costs two or three WPM, so take three runs and use the middle one. For a measure of stamina, the <a href="/5-minute-typing-test/">5 minute typing test</a> shows how much your speed drops over a longer passage; for pure speed on common words without punctuation, use the <a href="/typing-speed-test/">typing speed test</a>.</p>',
			'why-one-minute',
		),
		array(
			'Typing tests for jobs',
			'<p>Employers that test typing usually ask for 40-60 WPM for general office work, 60-80 for data entry, transcription and legal secretarial roles, and 80 or more for medical transcription and court reporting (which often use shorthand machines instead). Most job tests are 1-5 minutes on prose with punctuation, like this page, and set a minimum accuracy of 95% or higher; some count only net WPM, which is what the WPM figure here is. Practise on the same kind of text: sentences with capitals, commas and numbers, not just lowercase words.</p>',
			'jobs',
		),
	),
	'fixes'          => array(
		array( 'The sentences have words I cannot see yet', 'Only three lines are visible and the text scrolls as you type. The next sentence appears when you reach it.' ),
		array( 'My score is lower than on a words-only test', 'Expected: capital letters and punctuation slow everyone down. Compare one minute sentence scores with other sentence tests, not with word tests.' ),
		array( 'A comma was marked as an error', 'Punctuation is part of the word it is attached to, so "day," needs the comma before the space. Apostrophes count too.' ),
		array( 'The clock does not start', 'Click the text first so the hidden input has focus. On a phone, tap the box under the words to open the keyboard.' ),
	),
	'faq'            => array(
		array( 'What is a good score on a 1 minute typing test?', 'About 40 WPM is average, 50-60 is good, and 70 or more is fast. With punctuation and capitals, as here, scores run a little lower than on plain word tests.' ),
		array( 'Why do typing tests last one minute?', 'It is long enough to average out a slow start and short enough to repeat. Most published averages come from one minute tests, so it is the score to compare with.' ),
		array( 'Does punctuation count?', 'Yes. The sentences include commas, full stops, apostrophes and capital letters, and each has to be typed for the word to count as correct.' ),
		array( 'Can I take the test again with different text?', 'Yes. Every restart picks a new random set of sentences from the pool, so you cannot learn the text.' ),
		array( 'Is this the same as a typing test for a job?', 'It is the same format: timed prose with punctuation, scored as net WPM and accuracy. Employers set their own minimums, often 40-60 WPM at 95% accuracy.' ),
		array( 'Is my result saved?', 'Your best score is stored in this browser only, when accuracy is at least 90%. Nothing is uploaded.' ),
	),
	'related'        => array( 'typing-speed-test', '5-minute-typing-test', 'wpm-test', 'typing-test-english', 'keyboard-tester', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
