<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Memory Game',
	'seo_title'      => 'Memory Game Online: Match the Pairs (Free, No Download)',
	'description'    => 'Free online memory game. Flip the cards, remember where each picture is and match every pair in as few moves as you can. Boards from 4x3 to 8x6 with a timer.',
	'intro'          => 'The classic card matching game, in your browser. Every card has a twin somewhere on the board. Flip two at a time, remember what you saw, and clear the board in as few moves as possible. Pick a board from 12 to 48 cards and race your own best time.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'memory' ),
	'share'          => true,
	'scripts'        => array( 'memory-game' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Board size">
		<button type="button" data-mg-size="4x3" aria-pressed="false">4x3</button>
		<button type="button" data-mg-size="4x4" aria-pressed="true">4x4</button>
		<button type="button" data-mg-size="6x4" aria-pressed="false">6x4</button>
		<button type="button" data-mg-size="6x6" aria-pressed="false">6x6</button>
		<button type="button" data-mg-size="8x6" aria-pressed="false">8x6</button>
	</div>
	<div class="seg" role="group" aria-label="Card faces">
		<button type="button" data-mg-set="emoji" aria-pressed="true">Pictures</button>
		<button type="button" data-mg-set="numbers" aria-pressed="false">Numbers</button>
		<button type="button" data-mg-set="letters" aria-pressed="false">Letters</button>
	</div>
	<button type="button" class="btn btn-primary btn-sm" id="mg-start">Start</button>
</div>
<div class="tool-stage mm-stage" id="mg-stage" aria-label="Memory game board">
	<div class="mm-hud"><span>Moves <strong id="mg-moves">0</strong></span><span>Time <strong id="mg-time">0 s</strong></span><span>Pairs <strong id="mg-pairs">0 / 8</strong></span><span>Accuracy <strong id="mg-acc">-</strong></span></div>
	<div class="mm-intro" id="mg-intro"><h2>Match the pairs</h2><p>Pick a board size, press Start and flip two cards at a time. Matched pairs stay face up. The timer starts on your first flip.</p></div>
	<div class="mm-board mg-board" id="mg-board" hidden></div>
</div>
<span class="mm-pb" id="mg-pb"></span>
<p class="tool-status" id="mg-status" aria-live="polite">Press Start to deal the cards.</p>',
	'howto'          => array(
		'Choose a board. <strong>4x4</strong> (8 pairs) is a quick warm-up; 6x6 (18 pairs) is the classic; 8x6 (24 pairs) is a proper workout.',
		'Choose what is on the cards: pictures, numbers or letters. Numbers and letters are harder because the faces look alike.',
		'Press <strong>Start</strong> and flip any two cards. If they match, they stay face up; if not, they turn back after a moment.',
		'Remember where each picture was. When a new card shows a picture you have seen, go straight to its twin.',
		'Clear the board. Your moves, time and accuracy appear at the top; the best result for each board size is kept in this browser.',
	),
	'howto_title'    => 'How to play the memory game',
	'results'        => '<p>Three numbers describe a round:</p>
<ul>
<li><strong>Moves:</strong> every pair of flips counts as one move. The minimum is the number of pairs on the board (8 on 4x4, 18 on 6x6), which you can only hit with perfect luck or perfect memory.</li>
<li><strong>Accuracy:</strong> matches divided by moves. 50% means half your guesses were right; a strong player on a 6x6 board reaches 60-70%.</li>
<li><strong>Time:</strong> from the first flip to the last match. Time rewards decisiveness, so it tends to improve faster than moves.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>Board</th><th>Pairs</th><th>Good</th><th>Average</th></tr></thead>
<tbody>
<tr><td>4x4</td><td>8</td><td>10-12 moves</td><td>14-18 moves</td></tr>
<tr><td>6x4</td><td>12</td><td>16-20 moves</td><td>22-30 moves</td></tr>
<tr><td>6x6</td><td>18</td><td>26-32 moves</td><td>36-50 moves</td></tr>
<tr><td>8x6</td><td>24</td><td>36-44 moves</td><td>50-70 moves</td></tr>
</tbody></table></div>
<p>The ratio that matters is moves divided by pairs. Under 1.5 is excellent, 1.5-2 is good, 2-3 is normal and over 3 means you were mostly guessing. The status line translates your result after every round.</p>',
	'extra'          => array(
		array(
			'Strategy: how to win with fewer moves',
			'<p>The game is really about <strong>spatial memory</strong>, remembering where things are, more than what they are. A few habits make a big difference. Start by flipping cards you have not seen; a fresh card always adds information, while re-flipping a known card without a match in mind wastes a move. When a card is turned back over, say its position in your head ("top right, strawberry"), because naming a location fixes it better than looking at it. Scan the board in a fixed order, row by row, so you never lose track of which cards are unexplored. And when the second card of a pair is already known, flip the unknown card <em>first</em>: if it happens to show a face you know, you can complete that pair instead and save a move.</p>
<p>The numbers and letters sets are harder because the faces are visually similar and easy to confuse, which is closer to the way real memory tasks work. The pictures set is better for children and for a quick break.</p>',
			'strategy',
		),
		array(
			'Does a memory game train your memory?',
			'<p>Playing improves your score on this game quickly, mostly because you learn the strategy above. Whether that transfers to remembering names or shopping lists is less clear: studies of brain-training games find strong gains on the trained task and small or no gains elsewhere. What a round does reliably do is give you a few minutes of focused attention, which is why memory games are used in classrooms, in recovery after concussion and in care homes. If you want numbers that are closer to the tests psychologists use, try the <a href="/number-memory-test/">number memory test</a>, the <a href="/visual-memory-test/">visual memory test</a> and the <a href="/chimp-test/">chimp test</a>.</p>',
			'training',
		),
	),
	'fixes'          => array(
		array( 'The cards do not flip', 'Press Start first to deal the board. During the short pause after a wrong guess, clicks are ignored so both cards can turn back; wait for them to flip and try again.' ),
		array( 'The board is too small on my phone', 'Turn the phone sideways for the 8x6 board, or pick 4x4 or 6x4, which keep the cards large enough to tap in portrait.' ),
		array( 'The pictures are not showing', 'The picture set uses standard emoji. On a very old system without color emoji the cards may show empty boxes: switch to Numbers or Letters.' ),
		array( 'My best score disappeared', 'Best scores are stored in this browser only. Clearing site data, private browsing or switching browsers starts fresh.' ),
	),
	'faq'            => array(
		array( 'How does the memory game work?', 'Every card has one matching twin on the board. Flip two cards per move; matching pairs stay face up and mismatches turn back. The round ends when all pairs are found, and you are scored on moves, accuracy and time.' ),
		array( 'What is a good score in the memory game?', 'Divide your moves by the number of pairs. Under 1.5 is excellent, under 2 is good, 2 to 3 is average. On a 4x4 board that means about 12 moves is good and 16 is typical.' ),
		array( 'Is the memory game good for kids?', 'Yes. The picture set on a 4x3 or 4x4 board suits children from about four years old. Matching games are a standard way to practice attention and working memory at that age.' ),
		array( 'Does playing memory games improve memory?', 'You get better at the game itself within a few rounds. Evidence that it improves memory in daily life is weak; think of it as practice for attention and a few minutes of focus rather than a treatment.' ),
		array( 'Can I play the memory game on a phone?', 'Yes, it works with taps on any phone or tablet. Smaller boards fit portrait screens; use landscape for 6x6 and 8x6.' ),
		array( 'Is my result saved or shared?', 'Your best moves and time for each board size are kept in this browser only. Nothing is uploaded and there is no account.' ),
	),
	'related'        => array( 'chimp-test', 'number-memory-test', 'visual-memory-test', 'sequence-memory-test', 'verbal-memory-test', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
