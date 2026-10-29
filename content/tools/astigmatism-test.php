<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Astigmatism Test',
	'seo_title'      => 'Astigmatism Test: Free Online Clock Dial Chart (Each Eye)',
	'description'    => 'Free online astigmatism test. Look at the clock dial with one eye: if some lines look darker or sharper than others, you may have astigmatism. Shows the axis.',
	'intro'          => 'A quick home check for astigmatism. Cover one eye and look at the dot in the center of the clock dial. With normal focus every line looks equally black; with astigmatism, the lines in one direction look darker and sharper, and the others grayer or blurred. Tap the darkest lines to note the direction.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'astigmatism-test' ),
	'scripts'        => array( 'astigmatism-test' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-bar">
	<div class="seg" role="group" aria-label="Chart">
		<button type="button" data-as-chart="dial" aria-pressed="true">Clock dial</button>
		<button type="button" data-as-chart="fan" aria-pressed="false">Fan chart</button>
	</div>
	<div class="seg" role="group" aria-label="Eye">
		<button type="button" data-as-eye="right" aria-pressed="true">Right eye</button>
		<button type="button" data-as-eye="left" aria-pressed="false">Left eye</button>
	</div>
	<button type="button" class="btn" id="as-same">All look the same</button>
</div>
<div class="tool-stage as-stage" id="as-stage"><canvas id="as-canvas" aria-label="Astigmatism clock dial: tap the darkest lines"></canvas></div>
<div class="stats as-results">
	<div class="stat"><span class="stat-label">Right eye</span><span class="stat-value" id="as-res-right">-</span></div>
	<div class="stat"><span class="stat-label">Left eye</span><span class="stat-value" id="as-res-left">-</span></div>
</div>
<p class="tool-status" id="as-status" aria-live="polite">Cover your left eye and look at the dot in the middle. Tap the darkest lines, or press "All look the same".</p>
<p class="notice notice--warn">Screening only: this chart cannot measure astigmatism or replace an eye examination.</p>',
	'howto'          => array(
		'Take off your glasses or contact lenses to check your eyes on their own, or keep them on to check that they still correct you well.',
		'Sit about 50 cm (an arm\'s length) from the screen, or a little further on a big monitor. Make sure the page is at 100% zoom.',
		'Cover your left eye with your palm, without pressing, and look at the dot in the center with your right eye.',
		'If the lines in one direction look darker, sharper or more black than the others, tap them. If every line looks the same, press <strong>All look the same</strong>.',
		'Choose <strong>Left eye</strong>, cover your right eye and repeat. Try the <strong>Fan chart</strong> too: it has single lines every 15 degrees and can show smaller differences.',
	),
	'howto_title'    => 'How to do the astigmatism test',
	'results'        => '<p><strong>All lines look the same:</strong> no sign of astigmatism on this chart. Small amounts of astigmatism are very common and do not always show here.</p>
<p><strong>Some lines look darker or sharper:</strong> this is the classic sign of astigmatism. The eye focuses lines in one direction better than lines at right angles to it. The page notes the pair of clock hours you picked and an estimated axis using the optometrist\'s "rule of 30": the lower of the two hours times 30. Lines darkest at 12 and 6 give an axis of about 180 degrees; lines darkest at 3 and 9 give about 90 degrees.</p>
<p>The estimate is rough. Your prescription states the axis of the lens that corrects you, and only a refraction by an optometrist measures it with the strength (the cylinder value). If one eye shows a clear difference, or the result changed since your last glasses, book an eye examination.</p>',
	'extra'          => array(
		array(
			'What astigmatism is',
			'<p>In a perfect eye, the cornea (the clear front window) is curved like a football: the same in every direction. In an eye with astigmatism it is curved more like a rugby ball or the back of a spoon, steeper in one direction than the other, and sometimes the lens inside adds to this. Light in one direction then focuses at a different point from light in the other, so some lines are sharp while others are blurred. It often comes with short or long sight.</p>
<p>Astigmatism is very common: most people have a little, and roughly one in three adults has enough to be worth correcting. Typical signs are blur at all distances, letters that look stretched or doubled, squinting, eye strain, headaches after screen work, and glare or halos around lights at night. Glasses with a cylinder lens, toric contact lenses or laser eye surgery correct it.</p>',
			'what-is-astigmatism',
		),
		array(
			'The clock dial chart',
			'<p>The chart on this page is a version of the astigmatic fan or clock dial that optometrists have used for over a century. It is not a measurement: lighting, screen sharpness and how hard you stare all change what you see, and an eye that is long-sighted may "focus through" small astigmatism. When the result is unclear, blink, look away for a few seconds and look again at the dot, not at the lines. For a check of overall sharpness, use the <a href="/eye-test/">eye test</a>.</p>',
			'clock-dial',
		),
	),
	'fixes'          => array(
		array( 'All the lines look gray', 'Raise the screen brightness and zoom the page to 100%. On a small phone screen, hold it a little further away so the lines are not too thin to see.' ),
		array( 'The darkest lines change when I look again', 'That happens when the eye refocuses. Look at the center dot only, blink, and go with your first impression. Changing results usually mean little or no astigmatism.' ),
		array( 'I see a difference even with my glasses on', 'Your prescription may have changed, or the glasses may be bent so the lenses sit at the wrong angle. Have them checked and book an eye examination.' ),
	),
	'faq'            => array(
		array( 'How do I know if I have astigmatism?', 'If some lines on the clock dial look clearly darker or sharper than others with one eye, you may have astigmatism. An optometrist confirms it and measures how much.' ),
		array( 'Is this astigmatism test accurate?', 'It is a classic screening chart and good at showing noticeable astigmatism, but it cannot give the amount or exact axis. Small astigmatism often does not show.' ),
		array( 'What does the axis in my prescription mean?', 'The axis is the angle, from 1 to 180 degrees, of the cylinder lens that corrects your astigmatism. The darkest lines on the dial point roughly to it.' ),
		array( 'Can astigmatism get worse?', 'It usually stays fairly stable in adults. A change that grows quickly can be a sign of keratoconus, a thinning of the cornea, and should be checked.' ),
		array( 'Does astigmatism make lights look blurry at night?', 'Yes. Streaks or halos around headlights and street lamps are a common sign, because the pupil opens wide in the dark.' ),
		array( 'Should I do the test with both eyes open?', 'No. With both eyes open the better eye hides the other. Test each eye on its own.' ),
	),
	'disclaimer'     => 'Medical disclaimer: this astigmatism test is for information and screening only. It is not an eye examination and cannot diagnose or measure astigmatism or any eye condition. If your vision is blurred, distorted or has changed, see an optometrist or eye doctor.',
	'related'        => array( 'eye-test', 'blind-spot-test', 'color-vision-test', 'red-green-color-blind-test', 'white-screen', 'screen-resolution' ),
	'updated'        => '2026-10-29',
);
