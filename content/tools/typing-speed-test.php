<?php
defined( 'ABSPATH' ) || exit;

$bands = require __DIR__ . '/_bands.php';

$tool = require __DIR__ . '/_typing-test.php';

return array(
	'title'          => 'Typing Speed Test',
	'seo_title'      => 'Typing Speed Test: Check Your WPM and Accuracy (Free)',
	'description'    => 'Free typing speed test. Type common English words for 30 seconds to 5 minutes and get your words per minute, accuracy and errors, with a saved best score.',
	'intro'          => 'Find out how fast you type. Pick a length, click the text and start typing the words you see; the clock starts on your first key. At the end you get your words per minute, raw speed, accuracy and error count, with the average for adults so you know where you stand.',
	'device'         => 'any',
	'ads'            => 'content',
	'stats'          => array( 'typing-60', 'typing-30' ),
	'styles'         => array( 'typing-test' ),
	'scripts'        => array( 'typing-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( array( 30 => '30 s', 60 => '1 min', 120 => '2 min', 300 => '5 min' ), 60, 'words' ),
	'howto'          => array(
		'Choose a length. <strong>1 minute</strong> is the standard; 30 seconds is a quick check and 5 minutes measures how well your speed holds up.',
		'Click the text (or tap the box on a phone) and start typing the words you see. The timer starts on your first key.',
		'Press <strong>space</strong> after every word. Correct letters turn dark, wrong ones red; a word you skipped or misspelt gets a red underline.',
		'Keep going until the clock runs out. Press <strong>Tab</strong> or Restart at any time to start again with new words.',
		'Read your WPM and accuracy. A result with at least 90% accuracy is saved as your best for that length in this browser.',
	),
	'howto_title'    => 'How to take the typing speed test',
	'results'        => '<p>The test uses the standard definitions that typing tutors and typing jobs use:</p>
<ul>
<li><strong>WPM (words per minute):</strong> correctly typed characters, including the space after each correct word, divided by 5 and by the minutes. A "word" is always five characters, so long and short words count fairly.</li>
<li><strong>Raw WPM:</strong> everything you typed divided by 5 and the minutes, errors included. The gap between raw and net WPM is the cost of your mistakes.</li>
<li><strong>Accuracy:</strong> correct characters as a percentage of all characters typed.</li>
<li><strong>Errors:</strong> wrong, missing and extra characters across all the words you completed.</li>
</ul>
' . $bands['wpm'] . '
<p>Accuracy matters more than speed. A fast typist with 92% accuracy spends a lot of time correcting, and in this test every error is subtracted from the net score, so 60 WPM at 98% beats 70 WPM at 90%.</p>',
	'extra'          => array(
		array(
			'How to type faster',
			'<p>Speed comes from touch typing: all ten fingers on the home row (A S D F and J K L ;), each key hit by the same finger every time, eyes on the screen rather than the keyboard. If you already type with a few fingers, the first weeks of switching feel slower, but the ceiling is far higher: two-finger typing tops out around 50 WPM, touch typing at over 100. Practice short sessions daily rather than long ones weekly, and practice accuracy first; speed follows automatically once the finger movements are reliable. Sit with your wrists straight and floating, not resting on the desk, and keep the keyboard low enough that your elbows are at a right angle.</p>
<p>The words here are the 500 most common English words, which is what most typing tests use because they reflect ordinary writing. For a test with real sentences, capital letters and punctuation, take the <a href="/typing-test-english/">English typing test</a>. For a fixed length, there are dedicated <a href="/1-minute-typing-test/">1 minute</a> and <a href="/5-minute-typing-test/">5 minute</a> tests, and the <a href="/wpm-test/">WPM test</a> explains the formula in detail.</p>',
			'type-faster',
		),
		array(
			'Does the keyboard matter?',
			'<p>Less than people hope. A mechanical keyboard with light switches can add a few WPM for a fast typist, mostly from a shorter travel and a clearer actuation point, but most of the gain is comfort. Laptop keyboards with very shallow keys cause more errors for some people, and a keyboard that misses or doubles keystrokes will show up as errors here no matter how well you type: check it with the <a href="/keyboard-tester/">keyboard tester</a>. Latency is not a factor at typing speeds. What does matter is that the keyboard is the layout you expect; a QWERTY typist on an AZERTY or Dvorak layout will see the mistakes in red immediately.</p>',
			'keyboard',
		),
	),
	'fixes'          => array(
		array( 'The clock does not start', 'Click on the text first so the hidden input has focus; the dimmed overlay disappears when it does. On a phone, tap the box under the words to open the keyboard.' ),
		array( 'The words scroll out of view', 'The current line is kept as the second of the three visible lines. If you fall behind, keep typing; the text moves with you, not with the clock.' ),
		array( 'My phone autocorrects the words', 'The box asks the keyboard to turn autocorrect and auto-capitalisation off, but some keyboards ignore that. Turn off autocorrect in the keyboard settings for a fair score, or test on a computer.' ),
		array( 'Every word is marked wrong', 'Check the keyboard layout: Caps Lock, a non-English layout, or a key that is stuck. The keyboard tester shows what each key is sending.' ),
	),
	'faq'            => array(
		array( 'What is a good typing speed?', 'About 40 WPM is average for adults. 50-60 is good and what typing jobs ask for; 70 and above is fast; 100 and above is very fast.' ),
		array( 'How is WPM calculated?', 'Correct characters, including the space after a correct word, divided by 5 and by the minutes elapsed. Five characters count as one word so that long and short words are treated equally.' ),
		array( 'Why is my raw WPM higher than my WPM?', 'Raw WPM counts every character you typed, including mistakes. WPM counts only correct characters, so each error lowers it. Improve accuracy and the two numbers converge.' ),
		array( 'Does the test work on a phone?', 'Yes. A text box appears under the words and the keyboard opens when you tap it. Phone scores are lower than keyboard scores and the two should not be compared.' ),
		array( 'Can I take the test in another language?', 'The words are English. The English sentences test uses full passages with punctuation. Other languages are not available yet.' ),
		array( 'Is my result saved?', 'Your best score for each length is saved in this browser when accuracy is 90% or better. Your keystrokes stay in this browser; only your final WPM and accuracy are shared anonymously for the site averages, unless you turn sharing off under the tool. A result needs at least 85% accuracy to count in the site averages and the leaderboard.' ),
	),
	'related'        => array( '1-minute-typing-test', '5-minute-typing-test', 'wpm-test', 'typing-test-english', 'keyboard-tester', 'spacebar-clicker' ),
	'updated'        => '2026-10-29',
);
