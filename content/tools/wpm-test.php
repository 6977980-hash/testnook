<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_typing-test.php';

return array(
	'title'          => 'WPM Test',
	'seo_title'      => 'WPM Test: Measure Your Words Per Minute Typing Speed (Free)',
	'description'    => 'Free WPM test. Type for 15, 30 or 60 seconds and get your words per minute, raw WPM and accuracy, with a plain explanation of how WPM is calculated.',
	'intro'          => 'A quick words per minute test on common English words. Pick 15, 30 or 60 seconds, type what you see, and get your WPM, raw WPM and accuracy. Below the test, the exact formula behind the number, so you know what your score means and how to compare it with other tests.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'typing-test' ),
	'scripts'        => array( 'typing-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( array( 15 => '15 s', 30 => '30 s', 60 => '60 s' ), 60, 'words' ),
	'howto'          => array(
		'Choose a length. <strong>60 seconds</strong> gives the most stable WPM; 15 seconds is a sprint that usually reads 5-10 WPM higher.',
		'Click the text and type the words shown, with a <strong>space</strong> after each. The clock starts on your first key.',
		'Watch the live WPM in the top bar; it settles after the first ten seconds or so.',
		'When the clock stops, read your WPM, raw WPM, accuracy and errors.',
		'Press <strong>Tab</strong> or Restart for a new set of words. Your best WPM for each length is saved in this browser.',
	),
	'howto_title'    => 'How to take the WPM test',
	'results'        => '<p><strong>Words per minute</strong> does not count actual words, because "a" and "extraordinary" would then be worth the same. The convention, used by every serious typing test, is that one word is <strong>five characters</strong>, spaces included:</p>
<p><code>WPM = (correct characters / 5) / minutes</code></p>
<p>So 300 correct characters in one minute is 60 WPM, whatever the word lengths. The space after a correctly typed word counts as a correct character; a wrong word loses its letters and its space.</p>
<ul>
<li><strong>Raw WPM</strong> = all characters typed / 5 / minutes, including mistakes. It is the speed of your fingers before accuracy is taken into account.</li>
<li><strong>Net WPM</strong> (shown as WPM here) is the figure to quote. Some tests calculate it as raw WPM minus errors per minute; this test counts correct characters directly, which gives almost the same number without punishing a single typo twice.</li>
<li><strong>Accuracy</strong> = correct characters / typed characters. 95% or better is expected in most job tests.</li>
<li><strong>CPM</strong> (characters per minute), used by some tests and most non-English ones, is simply WPM multiplied by 5.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>WPM</th><th>CPM</th><th>Level</th></tr></thead>
<tbody>
<tr><td>30</td><td>150</td><td>Slow; hunt-and-peck.</td></tr>
<tr><td>40</td><td>200</td><td>Average adult.</td></tr>
<tr><td>60</td><td>300</td><td>Good; typical office requirement.</td></tr>
<tr><td>80</td><td>400</td><td>Fast.</td></tr>
<tr><td>100</td><td>500</td><td>Very fast.</td></tr>
<tr><td>150+</td><td>750+</td><td>Competitive.</td></tr>
</tbody></table></div>',
	'extra'          => array(
		array(
			'Why WPM differs between typing tests',
			'<p>Two tests can give the same typist scores 20 WPM apart. The text matters most: common lowercase words (as here) are fastest; sentences with punctuation and capitals cost 5-10 WPM; random letters or code cost far more. The length matters: a 15 second sprint reads higher than a 5 minute passage. The error rule matters: some tests stop you until a wrong letter is corrected, some subtract errors from raw speed, some ignore errors and show only raw WPM, which is why social media screenshots of 150 WPM often come from tests that do not count mistakes. Finally, whether the space counts as a character changes the result by a few percent. When comparing scores, compare on the same test; the <a href="/typing-speed-test/">typing speed test</a> here uses the same formula on the same word list with longer options, and the <a href="/typing-test-english/">English typing test</a> uses sentences.</p>',
			'differences',
		),
		array(
			'Average WPM by age and group',
			'<p>Surveys of typing tests put the adult average at 40 WPM with an accuracy of about 92%. Children learning to type reach 20-30 WPM by age 10 and 35-45 by the mid-teens if they are taught touch typing. Office workers who type daily average around 50; professional typists and transcriptionists 70-90; programmers are spread widely because code typing is different from prose. The fastest recorded typists exceed 200 WPM on short tests. Speed declines a little with age after 60, mostly from reduced practice rather than physical limits. These are typical ranges, not norms; a score above 50 with 97% accuracy is good enough for nearly any job that lists typing as a requirement.</p>',
			'averages',
		),
	),
	'fixes'          => array(
		array( 'My WPM is lower than on another site', 'Different tests use different text and error rules. This test counts net WPM with the five-character convention; a test showing raw WPM or ignoring errors will read higher.' ),
		array( 'The live WPM jumps around at the start', 'In the first few seconds a single word swings the average a lot. It settles after about ten seconds; the final figure is what counts.' ),
		array( 'The clock does not start', 'Click on the text first so the hidden input has focus. On a phone, tap the box under the words.' ),
		array( 'Words keep getting marked wrong', 'Check Caps Lock and the keyboard layout. If a specific key never registers, test it with the keyboard tester.' ),
	),
	'faq'            => array(
		array( 'What does WPM mean?', 'Words per minute. In typing tests a word is defined as five characters including spaces, so WPM is correct characters divided by five, divided by the minutes elapsed.' ),
		array( 'What is a good WPM?', 'The adult average is about 40. 50-60 is good and what most typing jobs want; 70 and above is fast; over 100 is very fast.' ),
		array( 'What is the difference between WPM and raw WPM?', 'Raw WPM counts everything you typed, mistakes included. WPM (net) counts only correct characters. The gap between them is the cost of your errors.' ),
		array( 'How do I convert WPM to CPM?', 'Multiply by five. 60 WPM is 300 characters per minute.' ),
		array( 'Does a 15 second test give the same WPM as a 60 second one?', 'Usually a little higher, because you can sprint for 15 seconds. Use 60 seconds for a figure to compare with published averages.' ),
		array( 'Is my result saved?', 'Your best WPM for each length is stored in this browser only, when accuracy is 90% or better. Nothing is uploaded.' ),
	),
	'related'        => array( 'typing-speed-test', '1-minute-typing-test', '5-minute-typing-test', 'typing-test-english', 'keyboard-tester', 'cps-test' ),
	'updated'        => '2026-10-29',
);
