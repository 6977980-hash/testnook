<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Chimp Test',
	'seo_title'      => 'Chimp Test: Can You Beat a Chimpanzee\'s Memory? (Free)',
	'description'    => 'Free online chimp test. Numbers appear on a grid, hide when you click 1, and you tap the rest in order from memory. One more number each level, three strikes.',
	'intro'          => 'The chimp test copies an experiment from Kyoto University in which a chimpanzee named Ayumu remembered the positions of nine numbers after seeing them for a fraction of a second. Numbers appear on the grid; the moment you click 1 they turn into blank squares, and you have to click them in order from memory. Each level adds one number. Three strikes and the game ends.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'memory' ),
	'scripts'        => array( 'chimp-test' ),
	'embed_height'   => 700,
	'tool'           => '<div class="tool-bar">
	<div class="mm-hud" style="margin:0"><span>Numbers <strong id="cm-level">4</strong></span><span>Strikes <strong class="mm-lives" id="cm-lives"></strong></span><span>Score <strong id="cm-best">-</strong></span></div>
	<button type="button" class="btn btn-primary btn-sm" id="cm-start">Start</button>
</div>
<div class="tool-stage mm-stage" id="cm-stage" aria-label="Chimp test grid">
	<div class="mm-intro" id="cm-intro"><h2>Are you smarter than a chimpanzee?</h2><p>Click the numbers in order. After you click 1, the others are hidden. Each round adds a number; three mistakes end the game.</p></div>
	<div class="mm-board cm-board" id="cm-board" hidden></div>
</div>
<span class="mm-pb" id="cm-pb"></span>
<p class="tool-status" id="cm-status" aria-live="polite">Press Start. The first round has 4 numbers.</p>',
	'howto'          => array(
		'Press <strong>Start</strong>. Four numbers appear at random positions on the grid.',
		'Memorize where each number is. Take as long as you want; the clock is not running.',
		'Click <strong>1</strong>. All other numbers turn into blank squares at once.',
		'Click the squares in order: 2, 3, 4 and so on. A correct square disappears; a wrong one flashes red and costs a strike.',
		'Finish the round and the next one has one more number. The game ends after three strikes, and the number of squares in your last round is your score.',
	),
	'howto_title'    => 'How to take the chimp test',
	'results'        => '<p>Your score is the number of squares in the last round you were playing. It measures <strong>working memory capacity</strong> for positions, the number of items you can hold at once, plus how quickly you can encode them.</p>
<div class="table-scroll"><table>
<thead><tr><th>Score</th><th>Rating</th></tr></thead>
<tbody>
<tr><td>Under 7</td><td>Below average. Most people pass 7 after a few rounds of practice.</td></tr>
<tr><td>7-9</td><td>Average. The classic "seven plus or minus two" working memory span.</td></tr>
<tr><td>10-13</td><td>Above average. You are using chunking or a scanning pattern.</td></tr>
<tr><td>14 and over</td><td>Exceptional. Few people reach this without a lot of practice.</td></tr>
</tbody></table></div>
<p>The chimpanzee in the original study, Ayumu, could do 9 numbers after seeing them for 210 milliseconds, and his accuracy barely dropped when the display time was cut. People given the same task were slower and less accurate at short display times, though with unlimited time to look, as on this page, adults usually match or beat him. The point of the study was not that chimps are smarter but that young chimpanzees seem to have a very fast photographic-style memory that humans trade away for language.</p>',
	'extra'          => array(
		array(
			'The science behind the chimp test',
			'<p>The experiment was published in 2007 by Tetsuro Matsuzawa and Sana Inoue at the Primate Research Institute of Kyoto University. Chimpanzees were taught to touch the numerals 1 to 9 in ascending order on a touch screen. In the memory version, the numbers were replaced by white squares as soon as the first one was touched. Ayumu, then five years old, was faster and more accurate than any of the human university students tested, and his performance held up when the numbers were shown for only 210 ms, which is roughly the time of one eye movement.</p>
<p>Researchers link this to <strong>eidetic</strong> or photographic memory, which some young children show and which fades with age. Later work found that humans who practiced for months could approach Ayumu\'s scores, so the gap is partly experience. This page gives you unlimited viewing time, which makes it a test of how many positions you can hold rather than how fast you can capture them.</p>',
			'science',
		),
		array(
			'Tips for a higher chimp test score',
			'<p>Do not try to remember the numbers; remember the <strong>path</strong>. Trace a line through the squares from 1 to the last number and rehearse the shape of the line. Group the squares into chunks of three or four that form a recognisable shape (a triangle, an L, a diagonal). Keep your eyes on the next square while you click the current one, so you never lose your place. Above 10 numbers most people also benefit from saying the positions to themselves ("top left, middle, bottom right"), because it recruits verbal memory in addition to visual memory. For a pure visual version without numbers, try the <a href="/visual-memory-test/">visual memory test</a>, and for a pure sequence version the <a href="/sequence-memory-test/">sequence memory test</a>.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'The numbers disappear before I am ready', 'They hide only when you click 1. Look as long as you like first; nothing is timed.' ),
		array( 'I clicked a blank square and nothing happened', 'Only the squares that held numbers react. Blank squares that never had a number are ignored, so a click there is neither right nor wrong.' ),
		array( 'The grid is tiny on my phone', 'Turn the phone sideways. The grid is 8 squares wide and uses the full width of the screen.' ),
		array( 'The game ended with lives still showing', 'A third strike ends the game immediately and the last heart is grayed out on the final screen. Press Start to play again.' ),
	),
	'faq'            => array(
		array( 'What is the chimp test?', 'A memory test from a 2007 Kyoto University study. Numbers appear on a grid, hide when you touch 1, and you touch the rest in order. Each round adds a number. Your score is the highest number of squares you managed before three strikes.' ),
		array( 'What is a good chimp test score?', 'Most people score 7 to 9. Above 10 is good, and 14 or more is exceptional. Scores improve quickly with practice because you learn to chunk the positions.' ),
		array( 'Can a chimpanzee really beat humans?', 'At short display times, yes. Ayumu remembered 9 numbers shown for 210 ms with about 80% accuracy; students did worse at that speed. With unlimited viewing time, as here, adults usually match him.' ),
		array( 'Why do chimps have better working memory?', 'The leading theory is a trade-off: young chimpanzees keep a fast, photographic style of memory that humans partly lose as language and symbolic thinking develop. Human children show more of it than adults.' ),
		array( 'Does the chimp test measure IQ?', 'No. It measures visuospatial working memory, one narrow ability. It correlates loosely with other cognitive scores but is not an intelligence test and not diagnostic of anything.' ),
		array( 'Is my score saved?', 'Your best score is kept in this browser only. Nothing is sent to a server.' ),
	),
	'related'        => array( 'visual-memory-test', 'sequence-memory-test', 'number-memory-test', 'verbal-memory-test', 'memory-game', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
