<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Stroop Test',
	'seo_title'      => 'Stroop Test Online: Name the Colour, Not the Word (Free)',
	'description'    => 'Free online Stroop test. Name the ink colour of colour words that say something else and measure your Stroop effect in milliseconds, with accuracy, in a minute.',
	'intro'          => 'The word says GREEN but it is printed in red. Which colour is the ink? The Stroop test measures how much reading the word slows you down when you try to name its colour. You get your reaction time for matching and mismatching words, your accuracy, and the difference, which is your Stroop effect.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'stroop-test' ),
	'scripts'        => array( 'stroop-test' ),
	'embed_height'   => 680,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Words per block">
		<button type="button" data-st-n="10" aria-pressed="false">10 words</button>
		<button type="button" data-st-n="20" aria-pressed="true">20 words</button>
		<button type="button" data-st-n="40" aria-pressed="false">40 words</button>
	</div>
	<div class="btn-row">
		<button type="button" class="btn btn-primary btn-sm" id="st-start">Start</button>
		<button type="button" class="btn btn-sm" id="st-reset">Reset</button>
	</div>
</div>
<div class="tool-stage st-stage is-idle" id="st-stage" tabindex="0" aria-label="Stroop test area">
	<div class="st-top">
		<div class="st-progress" id="st-progress">20 words per block</div>
		<div class="st-track" aria-hidden="true"><span id="st-bar"></span></div>
	</div>
	<div class="st-word" id="st-word" aria-live="polite">Stroop</div>
	<p class="st-hint" id="st-hint">Press Start. First a warm-up block where the word and its colour match, then the real block where they differ.</p>
</div>
<div class="st-answers" role="group" aria-label="Ink colour">
	<button type="button" data-st-c="red" disabled>Red<small>R or 1</small></button>
	<button type="button" data-st-c="green" disabled>Green<small>G or 2</small></button>
	<button type="button" data-st-c="blue" disabled>Blue<small>B or 3</small></button>
	<button type="button" data-st-c="yellow" disabled>Yellow<small>Y or 4</small></button>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Matching words</span><span class="stat-value" id="st-con">-</span></div>
	<div class="stat"><span class="stat-label">Mismatched words</span><span class="stat-value" id="st-inc">-</span></div>
	<div class="stat"><span class="stat-label">Stroop effect</span><span class="stat-value" id="st-effect">-</span></div>
	<div class="stat"><span class="stat-label">Accuracy</span><span class="stat-value" id="st-acc">-</span></div>
</div>
<div class="btn-row st-foot"><span class="st-pb" id="st-pb"></span></div>
<p class="tool-status" id="st-status" aria-live="polite">Press Start, then answer the ink colour with the buttons or the R, G, B, Y keys.</p>',
	'howto'          => array(
		'Choose how many words you want in each block. <strong>20</strong> takes about a minute and gives a stable result; 40 is more accurate.',
		'Press <strong>Start</strong>. In block 1 every word is printed in its own colour (RED in red). Answer the colour as fast as you can with the four buttons, or the keys <strong>R, G, B, Y</strong> (or 1-4).',
		'Block 2 is the real test: the word and the ink never match (GREEN printed in blue). Always answer the <strong>ink colour</strong>, never the word.',
		'Keep going until the bar fills. A wrong answer flashes red and is counted against your accuracy; a correct one flashes green.',
		'Read your average time for each block and the difference between them, which is your Stroop effect. Press <strong>Start again</strong> for another round.',
	),
	'howto_title'    => 'How to take the Stroop test',
	'results'        => '<p>The Stroop effect is the extra time you need to name the ink colour when the word spells a different colour. Reading is automatic for a fluent reader, so the word fights the colour and you have to suppress it. The test reports:</p>
<ul>
<li><strong>Matching words:</strong> your average correct response time in block 1, when word and colour agree. This is your baseline speed with these buttons.</li>
<li><strong>Mismatched words:</strong> your average correct response time in block 2, when they disagree.</li>
<li><strong>Stroop effect:</strong> mismatched minus matching, in milliseconds. Larger means the words interfered more.</li>
<li><strong>Accuracy:</strong> correct answers across both blocks. Below about 80% the timing is not meaningful, because you were guessing.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>Stroop effect</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 50 ms</td><td>Small. The words barely slowed you down. Check that accuracy is high, otherwise you were guessing fast.</td></tr>
<tr><td>50-150 ms</td><td>Typical. Most adults land here on a computer test with button answers.</td></tr>
<tr><td>150-300 ms</td><td>Large. Reading the word got in the way a lot. Common when tired, distracted or new to the task.</td></tr>
<tr><td>Over 300 ms</td><td>Very large. Try again when rested; practice usually brings it down.</td></tr>
</tbody></table></div>
<p>A button version like this one produces smaller effects than the classic spoken version, where people read the words aloud, because speaking a colour name is interfered with more directly than pressing a coloured button. Compare your result with your own earlier rounds rather than with lab figures.</p>',
	'extra'          => array(
		array(
			'What the Stroop test measures',
			'<p>John Ridley Stroop published the effect in 1935, and it has been one of the most used tasks in psychology ever since. It measures <strong>selective attention</strong> and <strong>cognitive control</strong>: your ability to focus on one feature of a stimulus (the colour) while suppressing an automatic response to another (the meaning of the word). Because reading cannot be switched off, every mismatched word requires a small act of inhibition, and the delay it causes is a clean, repeatable number.</p>
<p>Researchers use Stroop-type tasks to study attention, ageing, sleep deprivation, multitasking and the effects of stress or caffeine. Clinicians use standardised versions as one part of a neuropsychological assessment. This online version is for curiosity and self-tracking: it is not a diagnostic tool, and a large effect on its own does not indicate any condition. Being tired, reading in a second language, or just not having done the task before all make the effect larger.</p>',
			'what-it-measures',
		),
		array(
			'Tips for a fair Stroop result',
			'<p>Do a warm-up round and discard it. Keep your fingers resting on R, G, B and Y (or on the four buttons on a phone) so answering takes the same movement every time. Look at the centre of the word and try to see it as a coloured shape rather than reading it; many people find squinting slightly helps. Do not sacrifice accuracy for speed: an error costs more than a slow answer, and a round under 80% accuracy is reported but not saved as a best. Take the test at the same time of day if you want to compare sessions, because alertness changes the result. For a pure speed measure without the word interference, try the <a href="/reaction-time-test/">reaction time test</a>.</p>',
			'tips',
		),
	),
	'fixes'          => array(
		array( 'The keys do not work', 'Click inside the test box once so it has focus, then use R, G, B, Y or 1-4. The keys only respond while a word is on screen, not between blocks.' ),
		array( 'I keep answering the word instead of the colour', 'That is the Stroop effect in action. Slow down slightly, focus on the colour of the first letter only, and keep your fingers on the keys so the answer is a reflex. Accuracy improves within a round or two.' ),
		array( 'My times are very slow on a phone', 'Hold the phone in both hands and use both thumbs on the four buttons, so each answer is a short tap. Turn off battery saver, which slows the browser.' ),
		array( 'The result says accuracy was too low', 'Below 80% the timing is not reliable, so the round is not saved as a best. Take the 10 word version first to get used to the keys, then move to 20 or 40.' ),
	),
	'faq'            => array(
		array( 'What is the Stroop test?', 'A task where you name the ink colour of words that spell a different colour. The delay the mismatched words cause, compared with matching words, is the Stroop effect and measures selective attention.' ),
		array( 'What is a normal Stroop effect?', 'On a button-press test like this, roughly 50 to 150 ms. Spoken versions give larger numbers. The exact figure depends on the person, the device and the day, so track your own trend.' ),
		array( 'Why is the Stroop test hard?', 'Fluent readers process a word\'s meaning automatically, before they decide to. When the meaning and the colour disagree, the brain has to suppress the word, and that takes measurable time.' ),
		array( 'Does practice reduce the Stroop effect?', 'Somewhat. The first round is usually the largest; after a few rounds people settle into a stable, smaller effect. It never disappears completely in fluent readers.' ),
		array( 'Can the Stroop test diagnose ADHD or dementia?', 'No. Standardised Stroop tasks are one element of professional assessments, but an online result on its own tells you nothing about any condition. Treat this page as a brain exercise and a way to compare your own sessions.' ),
		array( 'Is my result saved?', 'Your smallest Stroop effect is stored in this browser only, and only for rounds with at least 80% accuracy. Nothing is sent to a server.' ),
	),
	'related'        => array( 'reaction-time-test', 'f1-reaction-test', 'cps-test', 'spacebar-clicker', 'keyboard-tester', 'refresh-rate-test' ),
	'updated'        => '2026-10-28',
);
