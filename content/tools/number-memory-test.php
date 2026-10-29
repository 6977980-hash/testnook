<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Number Memory Test',
	'seo_title'      => 'Number Memory Test: How Many Digits Can You Remember?',
	'description'    => 'Free number memory test. A number flashes up for a few seconds, then you type it back. Each level adds a digit until you slip. Find your digit span.',
	'intro'          => 'How long a number can you hold in your head? A number appears, you get a few seconds to memorize it, and then you type it back. Every level adds one digit. The average person manages about 7; the game ends on your first mistake and tells you your digit span.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'memory' ),
	'share'          => true,
	'scripts'        => array( 'number-memory-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="mm-hud" style="margin:0"><span>Level <strong id="nm-level">1</strong></span></div>
	<button type="button" class="btn btn-primary btn-sm" id="nm-start">Start</button>
</div>
<div class="tool-stage mm-stage" id="nm-stage" aria-label="Number memory test">
	<div class="mm-intro" id="nm-intro"><h2>Remember the number</h2><p>A number appears for a few seconds. When it disappears, type it back. Each level is one digit longer.</p></div>
	<div id="nm-show" hidden><div class="nm-number" id="nm-number" aria-live="polite"></div><div class="nm-track" aria-hidden="true"><span id="nm-bar"></span></div></div>
	<div class="nm-form" id="nm-form" hidden><label for="nm-input">What was the number?</label><input type="text" inputmode="numeric" pattern="[0-9]*" id="nm-input" autocomplete="off" enterkeyhint="done"><button type="button" class="btn btn-primary" id="nm-submit">Submit</button></div>
	<div id="nm-result" hidden><p class="mm-big" id="nm-verdict"></p><p>Number: <span class="nm-diff" id="nm-want"></span></p><p>Your answer: <span class="nm-diff" id="nm-got"></span></p><button type="button" class="btn btn-primary" id="nm-next">Next</button></div>
</div>
<span class="mm-pb" id="nm-pb"></span>
<p class="tool-status" id="nm-status" aria-live="polite">Press Start. Level 1 is a single digit.</p>',
	'howto'          => array(
		'Press <strong>Start</strong>. A number appears with a shrinking bar under it that shows how long it stays.',
		'Memorize it. The display time grows with the level: 2 seconds for short numbers, up to one second per digit later on.',
		'When it disappears, type the number and press <strong>Submit</strong> or Enter. On a phone the numeric keypad opens automatically.',
		'If you are right, press <strong>Next</strong> for a number one digit longer. If you are wrong, the digits you got wrong are underlined in red and your score is the last level you passed.',
		'Play again to improve. Your best score is remembered in this browser.',
	),
	'howto_title'    => 'How to take the number memory test',
	'results'        => '<p>Your score is your <strong>digit span</strong>: the longest number you repeated correctly. Digit span is one of the oldest measures in psychology and still appears in standard tests of working memory.</p>
<div class="table-scroll"><table>
<thead><tr><th>Digits</th><th>Rating</th></tr></thead>
<tbody>
<tr><td>Under 6</td><td>Below average. Tiredness, distraction and anxiety all shrink the span.</td></tr>
<tr><td>6-8</td><td>Average. George Miller\'s classic figure of "seven, plus or minus two".</td></tr>
<tr><td>9-11</td><td>Above average. You are chunking the digits into groups.</td></tr>
<tr><td>12 and over</td><td>Exceptional. Memory athletes use systems that turn digits into images.</td></tr>
</tbody></table></div>
<p>Because you have a few seconds to look rather than hearing the digits once, scores here run a little higher than on a spoken digit span test. Compare your rounds against each other rather than against clinical norms.</p>',
	'extra'          => array(
		array(
			'Why seven? The science of digit span',
			'<p>In 1956 George Miller published "The Magical Number Seven, Plus or Minus Two", observing that people can hold roughly seven items in immediate memory. Later work by Alan Baddeley showed the real limit is about <strong>two seconds of speech</strong>: you can hold as many digits as you can say to yourself in two seconds, which is why spans are a little longer in languages with short number words. Working memory holds items by rehearsing them, and anything that interrupts the rehearsal (a distraction, a second task) drops items out.</p>
<p>Digit span is part of the Wechsler intelligence scales and many clinical batteries, where forward and backward versions are scored separately. Backward span (repeating the digits in reverse) is harder and taps more of the control part of working memory. This page tests forward span only, and it is a game, not an assessment.</p>',
			'science',
		),
		array(
			'How to remember longer numbers',
			'<p><strong>Chunk</strong> the digits into groups of two to four, the way phone numbers are written: 4817 2093 65 is three items, not ten. Say the chunks in a rhythm; rhythm is the cheapest memory aid there is. Look for patterns within chunks: a year, a known number, an ascending run, a repeated digit. Memory athletes go further and convert each pair of digits into a fixed image (a person, an object) and place the images along a familiar route, which is how 100-digit numbers get memorized, but chunking and rhythm alone will add two or three digits to most people\'s span within a few rounds. For the same skill with positions instead of digits, try the <a href="/chimp-test/">chimp test</a>; for words, the <a href="/verbal-memory-test/">verbal memory test</a>.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'The keyboard does not open on my phone', 'Tap the answer box once. The box uses the numeric keypad; if it still does not open, your browser may block automatic focus, which tapping fixes.' ),
		array( 'I typed the right number but it says wrong', 'Look at the red digits in your answer: a swapped pair or an extra digit counts as wrong. Spaces are ignored, so you can type the chunks with spaces if that helps.' ),
		array( 'The number disappears too fast', 'The time grows with the length: one second per digit from level 3 onward. If the first level feels short, it is only 2 seconds for one digit, which is plenty once you expect it.' ),
		array( 'My best score was lost', 'Best scores live in this browser\'s storage only. Private browsing and cleared site data reset them.' ),
	),
	'faq'            => array(
		array( 'What is the number memory test?', 'A digit span test. A number is shown for a few seconds and you type it back; each level adds a digit until you make a mistake. Your score is the longest number you got right.' ),
		array( 'What is the average number memory score?', 'About 7 digits, with most adults between 5 and 9. With a few seconds to look and chunking, 9 to 11 is reachable by many people.' ),
		array( 'Is a digit span of 10 good?', 'Yes. Ten is above average. Twelve or more is exceptional, and memory competitors reach far beyond that with trained image systems.' ),
		array( 'Does number memory decline with age?', 'Slowly. Forward digit span holds up well into the 60s and 70s; backward span and speed decline a little earlier. Sleep and attention matter more than age in a single round.' ),
		array( 'How do I improve my number memory?', 'Chunk the digits into groups of three or four, say them in a rhythm, and look for patterns. Those three habits add digits within a session. Memory systems that turn digits into images do the rest.' ),
		array( 'Is my result saved?', 'Your best span is stored in this browser only. Nothing is sent anywhere.' ),
	),
	'related'        => array( 'chimp-test', 'verbal-memory-test', 'visual-memory-test', 'sequence-memory-test', 'memory-game', 'stroop-test' ),
	'updated'        => '2026-10-29',
);
