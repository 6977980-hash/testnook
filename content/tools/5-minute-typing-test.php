<?php
defined( 'ABSPATH' ) || exit;

$bands = require __DIR__ . '/_bands.php';

$tool = require __DIR__ . '/_typing-test.php';

return array(
	'title'          => '5 Minute Typing Test',
	'seo_title'      => '5 Minute Typing Test: WPM, Accuracy and Stamina (Free)',
	'description'    => 'Free 5 minute typing test with real English sentences. A longer test shows whether your speed holds up, with words per minute, accuracy and errors at the end.',
	'intro'          => 'Five minutes of typing real sentences is the test that shows your sustained speed rather than a one minute burst. It is the format used for professional typing certificates and many job tests. Type the passages for five minutes and get your net words per minute and accuracy.',
	'device'         => 'any',
	'ads'            => 'content',
	'stats'          => array( 'typing-300' ),
	'styles'         => array( 'typing-test' ),
	'scripts'        => array( 'typing-test' ),
	'embed_height'   => 600,
	'tool'           => $tool( array(), 300, 'sentences' ),
	'howto'          => array(
		'Sit comfortably with your wrists straight; five minutes is long enough for posture to matter.',
		'Click the text (or tap the box on a phone). The five minute clock starts on your first key.',
		'Type the sentences exactly, with capitals and punctuation, pressing <strong>space</strong> after each word. New sentences keep appearing until the time is up.',
		'Keep a steady rhythm rather than sprinting; most people who start fast lose 5-10 WPM by the fourth minute.',
		'Read your WPM, accuracy and errors at the end. Press <strong>Tab</strong> or Restart to go again with new sentences.',
	),
	'howto_title'    => 'How to take the 5 minute typing test',
	'results'        => '<p>Scores on a five minute test run 5-15% lower than on a one minute test for the same typist, because fatigue, the occasional awkward word and small lapses of concentration all have time to show up. That is the point: the five minute figure is the speed you can rely on for a page of work.</p>
' . $bands['wpm'] . '
<p><strong>WPM</strong> counts only correct characters (five per word); <strong>raw WPM</strong> counts everything; <strong>accuracy</strong> is the share of characters typed correctly. In five minutes a 50 WPM typist produces about 250 words and 1,250 characters, so a handful of errors barely moves the accuracy figure, while a run of mistakes in one difficult sentence does.</p>',
	'extra'          => array(
		array(
			'Why a longer test is a fairer test',
			'<p>A one minute test rewards a sprint. A five minute test rewards technique, because the things that let you sustain speed, touch typing without looking down, a light touch, relaxed shoulders, correct finger assignment, are exactly the things that fail under fatigue. Typing certificates issued by secretarial colleges and the tests used by courts and government offices are usually five minutes for that reason, and some are ten. If your five minute score is far below your one minute score, the difference is usually concentration rather than fingers: practice typing a full page without stopping, and notice where your eyes go when you lose the thread. For a quick check, the <a href="/1-minute-typing-test/">1 minute test</a> is on a separate page, and the <a href="/typing-speed-test/">typing speed test</a> lets you choose the length.</p>',
			'longer-test',
		),
		array(
			'Posture and comfort for long typing',
			'<p>Over five minutes, posture starts to affect the score. Keep the keyboard low enough that your forearms are level and your wrists are straight, not bent up. Float the wrists rather than resting them on the desk edge. Sit back in the chair with the screen at eye level so your neck is not craned forward. Light keystrokes are faster and less tiring than hammered ones; if the keys bottom out hard, you are pressing harder than needed. A short stretch of the hands and shoulders between runs does more for the next score than another immediate attempt.</p>',
			'posture',
		),
	),
	'fixes'          => array(
		array( 'My speed dropped in the last two minutes', 'That is what the test is for. Keep a steady pace from the start instead of sprinting; a consistent 50 beats a 60 that falls to 40.' ),
		array( 'The test stopped by itself', 'The test resets if the tab is hidden, for example when you switch to another window or the phone locks. Keep the page in front for the full five minutes.' ),
		array( 'The sentences repeat', 'The pool has 40 sentences and five minutes covers 15-25 of them, so a fast typist sees some twice in long runs. The same sentence is never shown twice in a row.' ),
		array( 'The clock does not start', 'Click the text so the hidden input has focus, or tap the box under the words on a phone.' ),
	),
	'faq'            => array(
		array( 'What is a good score on a 5 minute typing test?', 'About 35-45 WPM is average, 45-65 is good and over 65 is fast. Five minute scores are a little lower than one minute scores for the same person.' ),
		array( 'Why is my 5 minute score lower than my 1 minute score?', 'Fatigue, concentration and a wider mix of words. A 5-15% drop is normal; a larger drop usually means you are sprinting at the start and tiring.' ),
		array( 'Do typing certificates use 5 minute tests?', 'Most do. Secretarial colleges, courts and many government offices test for five or ten minutes on prose, scored as net WPM with a minimum accuracy.' ),
		array( 'Can I pause the test?', 'No. The clock runs for five minutes once you start, and hiding the tab resets it. Set aside five quiet minutes before you begin.' ),
		array( 'Does the test include punctuation?', 'Yes. The sentences have capitals, commas, full stops and apostrophes, as a real passage does.' ),
		array( 'Is my result saved?', 'Your best score for each length is saved in this browser when accuracy is 90% or better. Your keystrokes stay in this browser; only your final WPM and accuracy are shared anonymously for the site averages, unless you turn sharing off under the tool. A result needs at least 85% accuracy to count in the site averages and the leaderboard.' ),
	),
	'related'        => array( '1-minute-typing-test', 'typing-speed-test', 'wpm-test', 'typing-test-english', 'keyboard-tester', 'stroop-test' ),
	'updated'        => '2026-10-29',
);
