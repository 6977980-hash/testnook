<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Verbal Memory Test',
	'seo_title'      => 'Verbal Memory Test: Seen or New? Word Recognition (Free)',
	'description'    => 'Free verbal memory test. Words appear one at a time: press Seen if the word came up earlier in the round, New if it did not. Three mistakes end the game.',
	'intro'          => 'Words appear one after another. For each one, decide: have you seen this word already in this round, or is it new? The list of words you have to keep track of grows with every answer. Three mistakes end the game, and your score is the number of words you got right.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'memory' ),
	'scripts'        => array( 'verbal-memory-test' ),
	'embed_height'   => 620,
	'tool'           => '<div class="tool-bar">
	<div class="mm-hud" style="margin:0"><span>Score <strong id="vb-score">0</strong></span><span>Lives <strong class="mm-lives" id="vb-lives"></strong></span></div>
	<button type="button" class="btn btn-primary btn-sm" id="vb-start">Start</button>
</div>
<div class="tool-stage mm-stage vb-stage" id="vb-stage" tabindex="0" aria-label="Verbal memory test">
	<div class="mm-intro" id="vb-intro"><h2>Seen or new?</h2><p>Words appear one at a time. Press SEEN if the word already appeared in this round, NEW if it did not. Three mistakes end the game.</p></div>
	<div id="vb-play" hidden><div class="vb-word" id="vb-word" aria-live="polite"></div><div class="vb-btns"><button type="button" class="btn btn-primary" id="vb-seen">Seen <small>(S)</small></button><button type="button" class="btn btn-primary" id="vb-new">New <small>(N)</small></button></div></div>
</div>
<span class="mm-pb" id="vb-pb"></span>
<p class="tool-status" id="vb-status" aria-live="polite">Press Start. The first word is always new.</p>',
	'howto'          => array(
		'Press <strong>Start</strong>. A word appears.',
		'Press <strong>New</strong> if you have not seen the word in this round, or <strong>Seen</strong> if it has already appeared. The keys S and N or the left and right arrows work too.',
		'Every correct answer scores a point and shows the next word. Words you answered are added to the pool and can come back later, sometimes many words later.',
		'A wrong answer costs a life. The status line tells you whether the word was really seen or new.',
		'Three mistakes end the game. Your score is the number of correct answers; the best is kept in this browser.',
	),
	'howto_title'    => 'How to take the verbal memory test',
	'results'        => '<p>Your score is the number of correct answers before the third mistake. The test measures <strong>recognition memory</strong> for words: not recalling them from nothing, but knowing whether you have met one before. The hard part is that the pool of seen words grows throughout the round, so by score 60 you are checking every new word against dozens of old ones.</p>
<div class="table-scroll"><table>
<thead><tr><th>Score</th><th>Rating</th></tr></thead>
<tbody>
<tr><td>Under 20</td><td>Below average. Usually a few early slips before the task feels natural.</td></tr>
<tr><td>20-50</td><td>Average. Most rounds end in this range.</td></tr>
<tr><td>50-100</td><td>Above average. You are linking words to images or to each other.</td></tr>
<tr><td>Over 100</td><td>Excellent. Recognition stays reliable even against a large pool of old words.</td></tr>
</tbody></table></div>
<p>Two kinds of mistake happen. A <em>false alarm</em> is pressing Seen on a new word that merely feels familiar, which becomes common after many similar words. A <em>miss</em> is pressing New on a word you saw a long time ago. Most players lose their lives to false alarms, which is the signature of recognition memory under load.</p>',
	'extra'          => array(
		array(
			'Recognition versus recall',
			'<p>Psychologists separate <strong>recall</strong> (producing an item from memory, like naming the words you studied) from <strong>recognition</strong> (judging whether an item was present). Recognition is much easier, which is why multiple-choice exams feel kinder than essay questions and why you can know a face without remembering the name. This test is pure recognition, and the feeling it relies on, familiarity, is fast but fallible: a word that looks like one you saw, or that you simply read often, feels familiar too. Experienced players compensate by trying to <em>recollect</em> a detail, such as what word came before it, rather than going on the feeling alone.</p>
<p>Word recognition tasks are part of many memory assessments, including the Rey Auditory Verbal Learning Test and the Warrington Recognition Memory Test, where they help distinguish memory problems from attention problems. This page is a self-test and a game and should not be read as a diagnosis of anything.</p>',
			'science',
		),
		array(
			'How to score higher',
			'<p>Give each new word a quick <strong>image</strong>: a lantern, a falcon, a copper kettle. Images are recognized more reliably than letter strings, and the half-second it takes is paid back many times over. Link the current word to the previous one in a small scene so the words form a chain. Answer at a steady pace rather than racing, because false alarms come from reacting to familiarity before checking it. And trust your first instinct on genuinely old words: a word you saw thirty words ago usually does produce a small flash of recognition. For recall rather than recognition, try the <a href="/number-memory-test/">number memory test</a>; for positions, the <a href="/visual-memory-test/">visual memory test</a>.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'The S and N keys do nothing', 'Click inside the test box once so it has keyboard focus, or just use the two buttons. The keys only work while a word is on screen.' ),
		array( 'The same word came back immediately', 'That can happen; the choice of a seen word is random. It still counts as Seen.' ),
		array( 'A word felt familiar but was marked new', 'Familiarity from everyday reading is the main trap in this test. Only words shown in this round count as Seen.' ),
		array( 'My best score was lost', 'Best scores are kept in this browser only. Private browsing or cleared site data resets them.' ),
	),
	'faq'            => array(
		array( 'What is the verbal memory test?', 'A word recognition test. Words appear one at a time and you say whether each one already appeared in the round. The pool of seen words grows as you go; three mistakes end the game and your score is the number of correct answers.' ),
		array( 'What is a good verbal memory score?', 'Most rounds end between 20 and 50. Above 50 is good, and over 100 is excellent.' ),
		array( 'Why do I keep pressing Seen on new words?', 'That is a false alarm, the typical error in recognition memory. Common words feel familiar from daily reading. Checking for a specific memory of the word, rather than a feeling, reduces them.' ),
		array( 'Does the test use difficult words?', 'No. The pool is about 200 everyday English nouns, chosen so that none is rare and none looks too much like another.' ),
		array( 'Does verbal memory decline with age?', 'Recognition memory for words holds up well with age; recall declines earlier. Sleep, stress and attention affect a single round far more than age does.' ),
		array( 'Is my score saved?', 'Your best score is stored in this browser only. Nothing is sent to a server.' ),
	),
	'related'        => array( 'number-memory-test', 'chimp-test', 'visual-memory-test', 'sequence-memory-test', 'memory-game', 'stroop-test' ),
	'updated'        => '2026-10-29',
);
