<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Average Reaction Time by Age (and What Is Good)',
	'seo_title'   => 'Average Reaction Time by Age: What Is a Good Score?',
	'description' => 'The average human reaction time is about 250 ms to a visual signal. See how it changes with age, what gamers and athletes score, and what slows your result.',
	'blurb'       => 'The average human reaction time, how it changes with age, and what counts as fast.',
	'hub'         => 'benchmark',
	'tool'        => 'reaction-time-test',
	'tools'       => array( 'f1-reaction-test', 'stroop-test', 'mouse-latency-test', 'refresh-rate-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Most people react to a visual signal in about a quarter of a second. Here is how that number shifts with age, what the fastest people score, and why your screen and mouse are part of the result.',
	'summary'     => array(
		'The average visual reaction time for adults is <strong>about 250 ms</strong> in laboratory studies, and <strong>250 to 300 ms</strong> on a normal computer, where the screen and mouse add delay.',
		'Reaction time is fastest in the <strong>late teens and twenties</strong> and slows by roughly 2 to 6 ms per decade after 30, with a sharper rise after 60.',
		'Under <strong>200 ms</strong> on a computer test is excellent; it is typical of esports players and sprinters at the start line. Under 100 ms is anticipation, not reaction.',
		'Sleep, caffeine, a 60 Hz screen and a laggy wireless mouse can each move your average by 10 to 40 ms.',
	),
	'sections'    => array(
		array(
			'What a reaction time test measures',
			'<p>A simple reaction time test shows one signal and asks for one response: the box turns green, you click. The time between the two is your reaction time. It is the sum of several steps: light reaching the eye and the retina responding (about 20 to 40 ms), the visual cortex noticing the change, a decision to move, the signal travelling down the arm, and the finger pressing the button.</p>
<p>On a computer there are two more steps outside your body: the screen has to draw the green frame, and the mouse has to report the click. A 60 Hz monitor adds up to 16 ms before you even see the change; a wireless mouse in power-saving mode can add 10 ms or more on the way back. That is why computer tests read 20 to 50 ms slower than laboratory equipment.</p>
<p>Choice reaction tests, where you must decide between responses (the <a href="/stroop-test/">Stroop test</a> is one), take longer, usually 350 to 500 ms, because the decision step grows.</p>',
			'what-it-measures',
		),
		array(
			'Average reaction time by age',
			'<p>The largest published dataset on simple visual reaction time comes from a 2015 study of over 1,400 people tested with the same method. It found a mean of about 250 ms for young adults, with reaction time rising steadily with age. Combined with other studies, the picture by decade looks like this:</p>
<div class="table-scroll"><table>
<thead><tr><th>Age</th><th>Typical average (lab)</th><th>Typical on a computer test</th></tr></thead>
<tbody>
<tr><td>10 to 14</td><td>260 to 300 ms</td><td>290 to 340 ms</td></tr>
<tr><td>15 to 19</td><td>220 to 250 ms</td><td>240 to 280 ms</td></tr>
<tr><td>20 to 29</td><td>210 to 240 ms</td><td>230 to 270 ms</td></tr>
<tr><td>30 to 39</td><td>220 to 250 ms</td><td>240 to 280 ms</td></tr>
<tr><td>40 to 49</td><td>230 to 260 ms</td><td>250 to 290 ms</td></tr>
<tr><td>50 to 59</td><td>240 to 280 ms</td><td>260 to 310 ms</td></tr>
<tr><td>60 to 69</td><td>260 to 300 ms</td><td>280 to 340 ms</td></tr>
<tr><td>70 and over</td><td>290 to 350 ms</td><td>320 to 400 ms</td></tr>
</tbody></table></div>
<p>Two things stand out. The change from 20 to 50 is small, around 20 to 30 ms, far less than the difference between a rested and a tired person. And the spread inside each age group is wide: plenty of 50-year-olds beat the average 20-year-old. Age shifts the average, it does not set your number.</p>',
			'by-age',
		),
		array(
			'What is a good reaction time?',
			'<p>On a computer test, where the screen and mouse are part of the measurement:</p>
<ul>
<li><strong>Under 200 ms:</strong> excellent. Typical of competitive esports players and trained athletes, usually on a high refresh rate screen.</li>
<li><strong>200 to 250 ms:</strong> faster than most people.</li>
<li><strong>250 to 300 ms:</strong> average for a healthy adult.</li>
<li><strong>300 to 400 ms:</strong> slower than average; often tiredness, distraction or a slow setup rather than the person.</li>
<li><strong>Over 400 ms:</strong> slow. Worth retrying rested and checking the hardware notes below.</li>
</ul>
<p>Look at the average of five or more tries, never a single best time. One 150 ms result is usually a lucky click that happened to land just after the change. Times under 100 ms are physically impossible for a true reaction; in athletics a start under 100 ms is ruled a false start for that reason.</p>
<p>Elite numbers for context: Formula 1 drivers react to the start lights in roughly 200 to 250 ms (try the <a href="/f1-reaction-test/">F1 reaction test</a>), and Olympic sprinters leave the blocks 120 to 160 ms after the gun, which is faster than a visual reaction because sound reaches the brain more quickly than light.</p>',
			'good-score',
		),
		array(
			'Why your result might be slower than it should be',
			'<p>Before you blame your reflexes, check the setup. Each of these is worth 10 to 40 ms on its own:</p>
<ol>
<li><strong>Screen refresh rate.</strong> At 60 Hz the green frame appears up to 16.7 ms late; at 144 Hz, under 7 ms. Run the <a href="/refresh-rate-test/">refresh rate test</a> to see what your screen really runs at; laptops and external monitors often default to 60 Hz even when they can do more.</li>
<li><strong>Mouse delay.</strong> Bluetooth mice and wireless mice in power-saving mode report clicks later. The <a href="/mouse-latency-test/">mouse latency test</a> estimates the browser-side delay. A wired mouse or a 2.4 GHz dongle is faster.</li>
<li><strong>Tiredness and time of day.</strong> One short night adds 20 to 50 ms to the average and, more noticeably, produces occasional very slow tries. Most people are quickest in the late morning and early evening.</li>
<li><strong>Caffeine, alcohol and screens.</strong> A cup of coffee speeds reactions by a few percent for an hour or two. Alcohol slows them, even at levels well under driving limits.</li>
<li><strong>Attention.</strong> Looking away, music with words, or a notification in the corner of the screen all add time. Fix your eyes on the box and keep your finger resting on the button.</li>
</ol>',
			'slower-than-expected',
		),
		array(
			'Can you improve your reaction time?',
			'<p>Partly. The nerve signal speed is fixed, but the decision step and the movement can be trained. Studies on gamers and athletes show gains of 10 to 30 ms with practice, mostly from faster recognition of the signal and a readier finger. Beyond that, the biggest improvements come from the boring things: enough sleep, a rested body, and a fast screen and mouse.</p>
<p>A fair way to track progress: test at the same time of day, on the same device, and record the average of 10 tries once a week. Day-to-day swings of 20 ms are normal noise; a trend over a month is real.</p>',
			'improve',
		),
	),
	'data'        => array(
		'boards' => array( 'reaction' ),
		'title'  => 'What people actually score on Testnook',
		'after'  => 'good-score',
		'html'   => '<p>Real numbers from the <a href="/reaction-time-test/">reaction time test</a> on this site over the last 30 days: the median average-of-five was <strong>{median:reaction}</strong>, and the fastest 10% of people averaged <strong>{top10:reaction}</strong> or better. An average of 200 ms beats {beats:reaction:200} of results here. The quickest named results are on the <a href="/leaderboards/">leaderboards</a>.</p>',
	),
	'faq'         => array(
		array( 'What is the average human reaction time?', 'About 250 milliseconds to a visual signal for a young adult in laboratory conditions, and about 250 to 300 ms on a typical computer test, because the screen and the mouse add their own delay.' ),
		array( 'Is 200 ms a good reaction time?', 'Yes. An average of 200 ms on a computer test is better than most people manage and close to what competitive gamers score. A single 200 ms try is less meaningful than an average of five.' ),
		array( 'Is 150 ms reaction time possible?', 'As an average on a visual test, almost never. Individual tries around 150 ms happen when a click lands by luck just after the change. Sprinters react to a sound in 120 to 160 ms, but hearing is faster than seeing.' ),
		array( 'Do gamers have faster reaction times?', 'On average, slightly. Studies of action gamers find 10 to 30 ms faster simple reaction times than non-gamers, and a bigger advantage on tests that need a quick decision. Part of the difference is also hardware: high refresh rate screens and wired mice.' ),
		array( 'Why is my reaction time different on my phone?', 'Touch screens report a tap later than a mouse reports a click, often by 30 to 80 ms, and phone screens are usually 60 or 120 Hz. Compare phone results only with other phone results.' ),
		array( 'Does reaction time predict driving ability?', 'Simple reaction time is one small part. Real driving relies on anticipation and choice reactions, which is why a slower but attentive driver is safer than a fast but distracted one. The brake reaction time used in road design is about 1.5 seconds, far longer than any test result, because it includes noticing and deciding.' ),
	),
	'sources'     => array(
		array( 'Woods DL et al., "Factors influencing the latency of simple reaction time", Frontiers in Human Neuroscience, 2015', 'https://www.frontiersin.org/articles/10.3389/fnhum.2015.00131/full' ),
	),
);
