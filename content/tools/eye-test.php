<?php
defined( 'ABSPATH' ) || exit;

$cal = require __DIR__ . '/_screen-cal.php';

return array(
	'title'          => 'Eye Test',
	'seo_title'      => 'Online Eye Test: Free Vision Check With a Calibrated E Chart',
	'description'    => 'Free online eye test. A calibrated tumbling E chart estimates your visual acuity (20/20, 6/6) for each eye at 40 cm to 6 m, plus a printable-style letter chart.',
	'intro'          => 'Check how sharp your vision is, one eye at a time. Calibrate the screen with a bank card, choose how far away you are, and say which way each E points. The letters get smaller until you can no longer tell, and the page gives your score as 20/20 or 6/6 style acuity.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'screen-cal', 'eye-test' ),
	'scripts'        => array( 'screen-cal', 'eye-test' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-bar et-bar">
	<div class="seg" role="group" aria-label="Test type">
		<button type="button" data-et-mode="e" aria-pressed="true">E test</button>
		<button type="button" data-et-mode="chart" aria-pressed="false">Letter chart</button>
	</div>
	<div class="seg" role="group" aria-label="Eye">
		<button type="button" data-et-eye="right" aria-pressed="true">Right eye</button>
		<button type="button" data-et-eye="left" aria-pressed="false">Left eye</button>
	</div>
	<label>Distance <select id="et-dist">
		<option value="400">40 cm (phone)</option>
		<option value="1000">1 m</option>
		<option value="2000">2 m</option>
		<option value="3000" selected>3 m (10 ft)</option>
		<option value="6000">6 m (20 ft)</option>
	</select></label>
	<button type="button" class="btn btn-primary" id="et-start">Start</button>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#et-stage">Full screen</button>
</div>
<div class="tool-stage et-stage" id="et-stage"><canvas id="et-canvas" aria-label="Eye test chart"></canvas></div>
<p class="et-line" id="et-line">&nbsp;</p>
<div class="et-answers" id="et-answers" hidden>
	<button type="button" class="btn" data-et="up" aria-label="Up">&uarr;</button>
	<button type="button" class="btn" data-et="left" aria-label="Left">&larr;</button>
	<button type="button" class="btn" data-et="none">Can\'t tell</button>
	<button type="button" class="btn" data-et="right" aria-label="Right">&rarr;</button>
	<button type="button" class="btn" data-et="down" aria-label="Down">&darr;</button>
</div>
' . $cal( false ) . '
<div class="stats et-results">
	<div class="stat"><span class="stat-label">Right eye</span><span class="stat-value" id="et-res-right">-</span></div>
	<div class="stat"><span class="stat-label">Left eye</span><span class="stat-value" id="et-res-left">-</span></div>
</div>
<p class="tool-status" id="et-status" aria-live="polite">Calibrate the screen, choose your distance and press Start.</p>
<p class="notice notice--warn">Screening only: an online eye test is not an eye examination and cannot check eye health or give a prescription.</p>',
	'howto'          => array(
		'Open <strong>Calibrate to your screen</strong> and match a bank card (or enter your screen size). Without this the letters are the wrong size and the score is meaningless.',
		'Choose the distance you will sit or stand from the screen and measure it with a tape: 3 m (10 ft) or more on a computer or TV, 40 cm on a phone. Use <strong>Full screen</strong> for the far distances.',
		'Keep your glasses or contact lenses on if you wear them for distance. Cover your left eye with your palm (do not press) and press <strong>Start</strong> with <strong>Right eye</strong> selected.',
		'For each E, press the arrow for the way its arms point, on the keyboard or the buttons. A helper can press for you. If you cannot tell, press <strong>Can\'t tell</strong>; do not lean closer.',
		'The test moves to a smaller line after three right answers and stops after three wrong answers on one line. Then pick <strong>Left eye</strong>, cover your right eye and repeat.',
	),
	'howto_title'    => 'How to take the online eye test',
	'results'        => '<p>Your score is the smallest line you got at least three out of five right on, written the way an optometrist writes it:</p>
<div class="table-scroll"><table>
<thead><tr><th>US (feet)</th><th>Metric</th><th>Decimal</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>20/15 or 20/10</td><td>6/4.5 or 6/3</td><td>1.33-2.0</td><td>Sharper than average. Common in young adults.</td></tr>
<tr><td>20/20</td><td>6/6</td><td>1.0</td><td>Normal sharp vision: you see at 20 feet what a typical eye sees at 20 feet.</td></tr>
<tr><td>20/25 to 20/30</td><td>6/7.5 to 6/9</td><td>0.8-0.67</td><td>Slightly below normal. Often a small prescription change.</td></tr>
<tr><td>20/40</td><td>6/12</td><td>0.5</td><td>The usual minimum for driving (with glasses if needed) in many countries.</td></tr>
<tr><td>20/50 to 20/100</td><td>6/15 to 6/30</td><td>0.4-0.2</td><td>Reduced vision. Book an eye examination.</td></tr>
<tr><td>20/200 or worse</td><td>6/60</td><td>0.1</td><td>Very reduced vision. See an eye doctor soon, especially if it is new.</td></tr>
</tbody></table></div>
<p>If the page says <strong>or better (screen limit)</strong>, your screen did not have enough pixels to draw the smaller lines at that distance. Step further back, choose the longer distance and test again. On a phone at 40 cm the test checks near vision, which is different from distance vision.</p>',
	'extra'          => array(
		array(
			'How the letter size is worked out',
			'<p>Visual acuity charts are built on one rule: a letter on the 20/20 line is 5 minutes of arc tall at the viewing distance (one twelfth of a degree), and each stroke and gap of the E is 1 minute of arc. At 6 m (20 ft) that is 8.7 mm; at 3 m it is 4.4 mm; at 40 cm it is 0.58 mm. A 20/40 letter is twice that size, 20/200 ten times. The page works out each size from your distance and your screen calibration and draws the E on exact pixels.</p>
<p>The tumbling E is used for children and people who do not read the Latin alphabet, and it cannot be guessed from the letter shape. Letter mode shows a classic chart with rows of letters for reading aloud to a helper; it uses a standard bold font rather than the official Sloan letters, so treat it as a quick check and use the E test for a score.</p>',
			'letter-size',
		),
		array(
			'What an online eye test cannot do',
			'<p>A chart checks one thing: how sharp your vision is at one distance. A full eye examination also measures your exact prescription, checks eye pressure, looks at the retina and optic nerve, and tests eye movement, depth perception and the visual field. Many eye diseases, including glaucoma and early diabetic eye disease, cause no blur until late. Have a full eye examination every two years (every year for children, people over 60 and people with diabetes), even when an online test looks fine.</p>
<p>See a doctor straight away for sudden loss of vision, a curtain or shadow over your vision, new floaters with flashes of light, double vision, or a painful red eye.</p>',
			'limits',
		),
	),
	'fixes'          => array(
		array( 'The letters look too big or too small', 'Calibrate with a bank card and keep browser zoom at 100% (Ctrl+0 or Cmd+0). Measure the distance from your eyes to the screen with a tape, not by guessing.' ),
		array( 'I cannot reach the keyboard from 3 meters', 'Ask a helper to press the arrows while you call out the direction, use a wireless keyboard, or use the phone setting at 40 cm.' ),
		array( 'The smallest lines are skipped', 'Your screen does not have enough pixels for them at this distance. Move further away and choose the longer distance, or use a screen with a higher resolution.' ),
		array( 'My result is worse than at the optician', 'Screen glare, low brightness, a dirty screen, tired eyes or the wrong distance all lower the score. Test in a well lit room with the screen at full brightness.' ),
	),
	'faq'            => array(
		array( 'Is an online eye test accurate?', 'With the screen calibrated and the distance measured, the letter sizes are correct and the score is a fair estimate of your acuity. It is still not a replacement for an eye examination, which checks much more than sharpness.' ),
		array( 'What does 20/20 vision mean?', 'It means you can read at 20 feet (6 m) what a person with normal vision reads at 20 feet. 20/40 means you need to be at 20 feet to read what a normal eye reads from 40 feet.' ),
		array( 'Can I get a glasses prescription from this test?', 'No. A prescription needs a refraction by an optometrist or eye doctor. This test tells you whether your vision is sharp, not which lenses would fix it.' ),
		array( 'Should I wear my glasses for the test?', 'Test with the glasses or contacts you normally wear for distance to check whether they are still right. Test without them to see how your eyes do on their own.' ),
		array( 'Why test each eye separately?', 'One weaker eye is easy to miss with both eyes open, because the good eye takes over. That is common in children (lazy eye) and in some eye diseases.' ),
		array( 'What is the vision standard for driving?', 'In many countries you must read at about 20/40 (6/12) with both eyes, with glasses if needed. Check the rule where you live; only an official test counts.' ),
	),
	'disclaimer'     => 'Medical disclaimer: this online eye test is for information and screening only. It is not an eye examination, cannot detect eye disease and does not give a prescription. Its accuracy depends on your screen calibration, distance and lighting. If you notice blurred vision, any change in your sight, or eye pain, see an optometrist or eye doctor.',
	'related'        => array( 'astigmatism-test', 'red-green-color-blind-test', 'color-vision-test', 'blind-spot-test', 'online-ruler', 'screen-size' ),
	'updated'        => '2026-10-29',
);
