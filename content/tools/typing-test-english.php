<?php
defined( 'ABSPATH' ) || exit;

$bands = require __DIR__ . '/_bands.php';

$tool = require __DIR__ . '/_typing-test.php';

return array(
	'title'          => 'English Typing Test',
	'seo_title'      => 'English Typing Test: Sentences With Punctuation (Free)',
	'description'    => 'Free English typing test with real sentences, capitals and punctuation. Choose 1, 2 or 5 minutes and get your words per minute, accuracy and errors.',
	'intro'          => 'Type real English sentences, with capitals, commas and full stops, for one, two or five minutes. This is the format of typing tests for jobs, exams and typing certificates, and the closest measure of how fast you type actual English text. You get net words per minute, accuracy and an error count.',
	'device'         => 'any',
	'ads'            => 'content',
	'stats'          => array( 'typing-60' ),
	'styles'         => array( 'typing-test' ),
	'scripts'        => array( 'typing-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( array( 60 => '1 min', 120 => '2 min', 300 => '5 min' ), 60, 'sentences' ),
	'howto'          => array(
		'Pick a length. <strong>1 minute</strong> matches most online tests; 2 and 5 minutes match typing exams and job assessments.',
		'Click the text (or tap the box on a phone) and start typing. The clock starts on your first key.',
		'Type each sentence exactly: capital letters, commas, full stops and apostrophes all count. Press <strong>space</strong> after every word.',
		'Correct characters turn dark and mistakes red; a word with any error gets a red underline once you move on.',
		'When the time is up, read your WPM, accuracy and errors. Press <strong>Tab</strong> or Restart for new sentences.',
	),
	'howto_title'    => 'How to take the English typing test',
	'results'        => '<p>The test scores net <strong>words per minute</strong> (correct characters divided by 5 and by the minutes), <strong>raw WPM</strong> (all characters typed), <strong>accuracy</strong> and the number of <strong>errors</strong>. Because the sentences include punctuation and capitals, scores run 5-10 WPM below a plain word test; that is the realistic figure for typing emails, essays and documents.</p>
' . $bands['wpm'] . '
<p>Most job tests set a minimum accuracy, usually 95% or higher, as well as a speed. If your accuracy is below that, the speed figure will not help; slow down until the errors stop, then build speed back up.</p>',
	'extra'          => array(
		array(
			'Why sentences are harder than words',
			'<p>Common lowercase words use the letter keys and the space bar, the fastest keys on the board. Sentences add the shift key for capitals, the comma and full stop keys on the bottom row, and apostrophes, all of which involve the weaker fingers and a change of hand position. Sentences also carry meaning, which helps a fluent typist (you can read ahead and your fingers follow) but trips people who type letter by letter. For practice, the 40 passages here are plain English prose at an everyday reading level with no technical vocabulary, chosen to resemble the text in typing exams. The <a href="/typing-speed-test/">typing speed test</a> uses common words only, and the <a href="/1-minute-typing-test/">1 minute</a> and <a href="/5-minute-typing-test/">5 minute</a> tests use these same sentences at fixed lengths.</p>',
			'sentences',
		),
		array(
			'Typing tests for English learners',
			'<p>If English is not your first language, a typing test doubles as reading practice: the sentences are short, concrete and grammatical, and typing them fixes spelling and punctuation habits. Expect a lower score than in your own language at first, because your fingers are used to different letter sequences; English has common pairs like "th", "ing" and "ou" that become automatic with practice. Read the whole sentence before you start typing it, type at a pace where you make no errors, and let speed come afterwards. Typing tests in other languages, including Urdu and Hindi, are planned for this site.</p>',
			'learners',
		),
	),
	'fixes'          => array(
		array( 'The apostrophe or quote key gives a different character', 'Some keyboard layouts and phone keyboards insert a curly quote. The test expects the straight apostrophe found in the sentences; switch off smart punctuation in the keyboard settings.' ),
		array( 'Capital letters are marked wrong', 'Check Caps Lock. Each sentence starts with a capital and the rest is lower case unless it is a name.' ),
		array( 'My phone changes the words as I type', 'Turn off autocorrect and predictive text in the keyboard settings, or take the test on a computer for a comparable score.' ),
		array( 'The clock does not start', 'Click the text so the hidden input has focus, or tap the box under the words on a phone.' ),
	),
	'faq'            => array(
		array( 'What is a good English typing speed?', 'About 40 WPM is average on sentence text, 45-65 is good, and over 65 is fast. Job tests usually ask for 40-60 WPM at 95% accuracy or better.' ),
		array( 'Does punctuation count in the score?', 'Yes. Every comma, full stop, apostrophe and capital letter must be typed for the word to count as correct, exactly as in a job or exam typing test.' ),
		array( 'Is this the same as a government or exam typing test?', 'It is the same format: timed English prose, scored as net WPM and accuracy. The minimum speed and accuracy vary by exam, so check the one you are preparing for.' ),
		array( 'Why is my score lower than on a words-only test?', 'Shift, punctuation and reading real text slow everyone down by 5-10 WPM. Compare sentence scores with sentence scores.' ),
		array( 'Can I take the test in Urdu or Hindi?', 'Not yet. Only English passages are available at the moment; other languages are planned.' ),
		array( 'Is my result saved?', 'Your best score for each length is saved in this browser when accuracy is 90% or better. Your keystrokes stay in this browser; only your final WPM and accuracy are shared anonymously for the site averages, unless you turn sharing off under the tool. A result needs at least 85% accuracy to count in the site averages and the leaderboard.' ),
	),
	'related'        => array( '1-minute-typing-test', '5-minute-typing-test', 'typing-speed-test', 'wpm-test', 'keyboard-tester', 'spacebar-clicker' ),
	'updated'        => '2026-10-29',
);
