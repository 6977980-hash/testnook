<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Sequence Memory Test',
	'seo_title'      => 'Sequence Memory Test: Repeat the Growing Pattern (Free)',
	'description'    => 'Free sequence memory test. Tiles flash one after another and you repeat the order. Every level adds a step until you slip. Find your span and the average.',
	'intro'          => 'Watch the tiles flash, then click them in the same order. Every level repeats the sequence so far and adds one more step, like the Simon game. One wrong click ends the game. Most people reach level 8 or so; can you do better?',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'memory' ),
	'scripts'        => array( 'sequence-memory-test' ),
	'embed_height'   => 680,
	'tool'           => '<div class="tool-bar">
	<div class="mm-hud" style="margin:0"><span>Level <strong id="sm-level">1</strong></span></div>
	<button type="button" class="btn btn-primary btn-sm" id="sm-start">Start</button>
</div>
<div class="tool-stage mm-stage" id="sm-stage" aria-label="Sequence memory test grid">
	<div class="mm-intro" id="sm-intro"><h3>Repeat the sequence</h3><p>Tiles flash in order. Click them in the same order. Each level adds a step. One mistake ends the game.</p></div>
	<div class="mm-board sm-board is-locked" id="sm-board" hidden>
		<button type="button" class="mm-cell" aria-label="Tile 1"></button><button type="button" class="mm-cell" aria-label="Tile 2"></button><button type="button" class="mm-cell" aria-label="Tile 3"></button>
		<button type="button" class="mm-cell" aria-label="Tile 4"></button><button type="button" class="mm-cell" aria-label="Tile 5"></button><button type="button" class="mm-cell" aria-label="Tile 6"></button>
		<button type="button" class="mm-cell" aria-label="Tile 7"></button><button type="button" class="mm-cell" aria-label="Tile 8"></button><button type="button" class="mm-cell" aria-label="Tile 9"></button>
	</div>
</div>
<span class="mm-pb" id="sm-pb"></span>
<p class="tool-status" id="sm-status" aria-live="polite">Press Start. Level 1 is a single flash.</p>',
	'howto'          => array(
		'Press <strong>Start</strong>. One tile flashes.',
		'Click that tile. The sequence plays again with one more tile added to the end.',
		'Repeat the whole sequence from the beginning each level. The same tile can appear more than once in a row.',
		'A wrong click ends the game and shows the tile you should have pressed. Your score is the last level you completed.',
		'Press <strong>Start again</strong> for a new sequence. Your best level is kept in this browser.',
	),
	'howto_title'    => 'How to take the sequence memory test',
	'results'        => '<p>Your score is the length of the longest sequence you repeated correctly. It measures <strong>serial working memory</strong>: holding items in order, which is harder than holding them in any order because each extra step can be confused with its neighbours.</p>
<div class="table-scroll"><table>
<thead><tr><th>Level</th><th>Rating</th></tr></thead>
<tbody>
<tr><td>Under 6</td><td>Below average. Most people pass 6 once they start grouping the steps.</td></tr>
<tr><td>6-9</td><td>Average. The typical span for ordered positions.</td></tr>
<tr><td>10-14</td><td>Above average. You are chunking the sequence into short phrases.</td></tr>
<tr><td>15 and over</td><td>Excellent. Electronic Simon players call this the start of serious scores.</td></tr>
</tbody></table></div>
<p>Because every level replays the full sequence, the early steps get rehearsed many times and are rarely the ones you forget; mistakes nearly always happen in the last two or three steps. The flashes speed up slightly as the level rises, so later levels test attention as well as memory.</p>',
	'extra'          => array(
		array(
			'Sequence memory, Simon and the Corsi test',
			'<p>This format comes from two places. In 1978 the Simon electronic game turned an ordered sequence of lights into a toy, and in the 1970s the <strong>Corsi block-tapping test</strong> turned it into a clinical measure: the examiner taps wooden blocks in a sequence and the patient repeats it. Corsi span is one of the standard measures of visuospatial working memory and averages around 6 for adults, somewhat lower than digit span because positions are harder to rehearse than words.</p>
<p>Repeating a sequence uses a loop of encoding, rehearsal and recall. Each new step has to be attached to the end of a chain you have already stored, and the chain decays unless you rehearse it, which is why the pause before you can click matters so much. Serial memory also underlies learning a tune, a dance step or a sequence of moves, so practice here feels familiar to musicians and gamers.</p>',
			'science',
		),
		array(
			'How to get further',
			'<p>Rehearse the sequence <strong>while</strong> it plays rather than waiting for it to finish; mouth the positions or tap your fingers in time. Group the steps into phrases of three or four, the way you would remember a phone number, and notice repeats within a phrase ("corner, corner, middle"). Give the tiles names (top left, centre, bottom right) and say the names, because a verbal label survives longer than a visual flash. When you click, go at the speed you rehearsed; rushing the end of a long sequence is the most common way to lose. For the unordered version, try the <a href="/visual-memory-test/">visual memory test</a>; for numbers on a grid, the <a href="/chimp-test/">chimp test</a>.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'I clicked during the playback and it counted as wrong', 'Clicks during playback are ignored, not counted. Wait for the status line to say "Now repeat it" before clicking.' ),
		array( 'The same tile flashed twice in a row and I missed it', 'Repeats are allowed. A double flash on one tile is two steps; watch for the tile going dark between them.' ),
		array( 'The flashes are too fast', 'The gap shrinks slightly with the level, from 0.7 s down to about 0.4 s. Rehearsing out loud as the sequence plays makes the speed matter less.' ),
		array( 'My best level disappeared', 'The best level lives in this browser only. Clearing site data or private browsing resets it.' ),
	),
	'faq'            => array(
		array( 'What is the sequence memory test?', 'A Simon-style test. Tiles flash one after another and you click them in the same order. Each level repeats the sequence and adds one step; one mistake ends the game. Your score is the longest sequence you completed.' ),
		array( 'What is a good sequence memory score?', 'Most people end between level 6 and 9. Level 10 and up is above average; 15 or more is excellent.' ),
		array( 'How is this different from the visual memory test?', 'The visual memory test shows a pattern all at once and ignores order. The sequence test shows tiles one at a time and the order has to match, which is a harder task and gives lower scores.' ),
		array( 'Can the same tile appear twice?', 'Yes. Each step is random, so repeats happen. The tile goes dark briefly between two flashes on the same tile.' ),
		array( 'Does practice improve sequence memory?', 'Scores rise noticeably over a few sessions as you learn to group steps into phrases and rehearse while the sequence plays. The ceiling varies from person to person.' ),
		array( 'Is my score saved?', 'Your best level is stored in this browser only. Nothing is sent to a server.' ),
	),
	'related'        => array( 'visual-memory-test', 'chimp-test', 'number-memory-test', 'verbal-memory-test', 'memory-game', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
