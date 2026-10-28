<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Visual Memory Test',
	'seo_title'      => 'Visual Memory Test: Remember the Pattern of Tiles (Free)',
	'description'    => 'Free visual memory test. A pattern of tiles lights up, then you click the same tiles from memory. The grid grows every level and you have three lives.',
	'intro'          => 'A set of tiles lights up for a second or two. Then they go dark, and you have to click the ones that were lit. Each level adds a tile and the grid grows from 3x3 up to 10x10. Three misses in one level cost a life; lose three lives and the game is over.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'memory' ),
	'scripts'        => array( 'visual-memory-test' ),
	'embed_height'   => 700,
	'tool'           => '<div class="tool-bar">
	<div class="mm-hud" style="margin:0"><span>Level <strong id="vm-level">1</strong></span><span>Lives <strong class="mm-lives" id="vm-lives"></strong></span></div>
	<button type="button" class="btn btn-primary btn-sm" id="vm-start">Start</button>
</div>
<div class="tool-stage mm-stage" id="vm-stage" aria-label="Visual memory test grid">
	<div class="mm-intro" id="vm-intro"><h3>Remember the pattern</h3><p>Tiles light up, then go dark. Click the ones that were lit. Each level adds a tile. Three mistakes in a level cost a life.</p></div>
	<div class="mm-board vm-board" id="vm-board" hidden></div>
</div>
<span class="mm-pb" id="vm-pb"></span>
<p class="tool-status" id="vm-status" aria-live="polite">Press Start. Level 1 has 3 tiles on a 3x3 grid.</p>',
	'howto'          => array(
		'Press <strong>Start</strong>. Three tiles on a 3x3 grid light up for about a second.',
		'When they go dark, click the tiles that were lit, in any order. A correct tile turns green; a wrong one turns red.',
		'Find every lit tile to finish the level. The next level adds one tile, and the grid grows by one row and column every two levels.',
		'Three wrong clicks in a single level cost a life and the pattern is shown again before the level restarts. You have three lives.',
		'When the lives are gone, the level you reached is your score. Your best level is kept in this browser.',
	),
	'howto_title'    => 'How to take the visual memory test',
	'results'        => '<p>Your score is the level at which the game ended, which is also the number of tiles you were trying to remember plus two. It measures <strong>visuospatial short-term memory</strong>: how many positions you can hold after a brief look.</p>
<div class="table-scroll"><table>
<thead><tr><th>Level</th><th>Tiles</th><th>Rating</th></tr></thead>
<tbody>
<tr><td>Under 6</td><td>Under 8</td><td>Below average. A pattern of 7 tiles usually stays after a few tries.</td></tr>
<tr><td>6-9</td><td>8-11</td><td>Average. Most people finish here.</td></tr>
<tr><td>10-13</td><td>12-15</td><td>Above average. You are seeing the pattern as shapes rather than single tiles.</td></tr>
<tr><td>14 and over</td><td>16 and over</td><td>Excellent. Few people hold this many positions without training.</td></tr>
</tbody></table></div>
<p>The pattern is shown for one second plus a little extra per tile, so the test is about capacity, not speed. If you lose lives on levels you normally pass, you are probably tired or distracted; the score varies more with attention than most people expect.</p>',
	'extra'          => array(
		array(
			'How visual memory works',
			'<p>Visual short-term memory is limited to roughly <strong>four objects</strong> at a time when the objects are unrelated. People manage many more tiles on this test because the brain does not store the tiles one by one; it stores the <em>shape</em> they make. A diagonal line of five tiles is one object. An L, a cross, a pair of parallel bars, a near-square: each is a single chunk, and the capacity limit applies to chunks. That is why the best strategy is to look at the whole pattern and name its shapes rather than counting tiles.</p>
<p>This kind of task is close to the Corsi block test and the visual patterns test used in neuropsychology, which assess the visuospatial sketchpad of working memory. Those are administered under controlled conditions and scored against age norms; this page is a game for curiosity and self-tracking, not an assessment.</p>',
			'science',
		),
		array(
			'Tips for a higher score',
			'<p>Fix your eyes on the centre of the grid and take in the whole pattern at once; scanning tile by tile loses the edges. Describe the pattern to yourself in shapes ("a diagonal from the top left, and a pair in the bottom right"). Click the tiles you are sure of first; the ones you are unsure of often come back once the shape is partly rebuilt on screen. Avoid guessing when you are down to one or two uncertain tiles, since three misses cost a life; a slower careful click is cheaper than a quick wrong one. For a version that tests order as well as position, try the <a href="/sequence-memory-test/">sequence memory test</a>, and for numbers on a grid the <a href="/chimp-test/">chimp test</a>.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'The tiles light up too briefly', 'The display lasts one second plus 0.12 seconds per tile, which is the same for everyone. Focus on the centre of the grid before the pattern appears so you see all of it.' ),
		array( 'Nothing happens when I click', 'Clicks are ignored while the pattern is shown and during the short pause between levels. Wait until the tiles go dark.' ),
		array( 'I clicked a correct tile and it turned red', 'Each tile only counts once. If a tile is already green and you click it again, nothing happens; red always means the tile was not part of the pattern.' ),
		array( 'The grid is cramped on a phone', 'Later levels use up to a 10x10 grid. Landscape orientation keeps the tiles large enough to tap accurately.' ),
	),
	'faq'            => array(
		array( 'What is the visual memory test?', 'A test of visuospatial short-term memory. A pattern of tiles is shown briefly and you reproduce it by clicking the tiles that were lit. Each level adds a tile; three misses in a level cost one of three lives.' ),
		array( 'What is a good visual memory score?', 'Most people reach level 6 to 9. Level 10 and above is above average; 14 and above is excellent.' ),
		array( 'How can I improve my visual memory?', 'See the pattern as shapes rather than single tiles, look at the centre of the grid, and click the certain tiles first. Scores improve quickly over a few sessions as you learn to chunk.' ),
		array( 'Is the visual memory test the same as the Corsi block test?', 'Similar idea, different format. Corsi shows blocks tapped in sequence and you repeat the order. This test shows a static pattern and ignores order. The sequence memory test on this site is closer to Corsi.' ),
		array( 'Does the test work on a phone?', 'Yes. Tap the tiles. Use landscape for the larger grids on later levels.' ),
		array( 'Is my result saved?', 'Your best level is stored in this browser only. Nothing is sent to a server.' ),
	),
	'related'        => array( 'sequence-memory-test', 'chimp-test', 'number-memory-test', 'verbal-memory-test', 'memory-game', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
