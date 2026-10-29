<?php
defined( 'ABSPATH' ) || exit;

$cal = require __DIR__ . '/_screen-cal.php';

return array(
	'title'          => 'Blind Spot Test',
	'seo_title'      => 'Blind Spot Test: Find and Measure the Blind Spot in Each Eye',
	'description'    => 'Free online blind spot test. Watch a dot vanish as it crosses the blind spot of each eye, measure where it starts and ends in degrees, and see it filled in.',
	'intro'          => 'Everybody has a blind spot in each eye, where the optic nerve leaves the retina and there are no light-sensitive cells. Close one eye, look at the cross, and a moving dot disappears for a moment. Mark where it goes and comes back, and the page measures your blind spot in degrees.',
	'device'         => 'any',
	'ads'            => 'content',
	'styles'         => array( 'screen-cal', 'blind-spot-test' ),
	'scripts'        => array( 'screen-cal', 'blind-spot-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-bar bs-bar">
	<div class="seg" role="group" aria-label="Mode">
		<button type="button" data-bs-mode="measure" aria-pressed="true">Measure</button>
		<button type="button" data-bs-mode="classic" aria-pressed="false">Classic</button>
		<button type="button" data-bs-mode="fill" aria-pressed="false">Fill-in</button>
	</div>
	<div class="seg" role="group" aria-label="Eye">
		<button type="button" data-bs-eye="right" aria-pressed="true">Right eye</button>
		<button type="button" data-bs-eye="left" aria-pressed="false">Left eye</button>
	</div>
	<label>Distance <select id="bs-dist">
		<option value="300">30 cm</option>
		<option value="400">40 cm</option>
		<option value="500" selected>50 cm</option>
		<option value="600">60 cm</option>
	</select></label>
	<button type="button" class="btn btn-sm" data-tn-fullscreen="#bs-stage">Full screen</button>
</div>
<div class="tool-stage bs-stage" id="bs-stage"><canvas id="bs-canvas" aria-label="Blind spot chart with a cross and a red dot"></canvas></div>
<div class="bs-mark-row"><button type="button" class="btn btn-primary" id="bs-start">Start measuring</button><button type="button" class="btn" id="bs-mark" disabled>Dot gone (space)</button></div>
' . $cal( false ) . '
<div class="stats">
	<div class="stat"><span class="stat-label">Dot vanished</span><span class="stat-value" id="bs-start-deg">-</span></div>
	<div class="stat"><span class="stat-label">Dot came back</span><span class="stat-value" id="bs-end-deg">-</span></div>
	<div class="stat"><span class="stat-label">Center</span><span class="stat-value" id="bs-mid-deg">-</span></div>
	<div class="stat"><span class="stat-label">Width</span><span class="stat-value" id="bs-width-deg">-</span></div>
</div>
<p class="tool-status" id="bs-status" aria-live="polite">Calibrate the screen, sit at the chosen distance, cover your left eye and press Start measuring.</p>
<p class="notice notice--warn">Screening only: this is a demonstration of the normal blind spot, not a visual field test.</p>',
	'howto'          => array(
		'Calibrate the screen with a bank card (below the chart) so the angles are right. On a phone, turn it sideways.',
		'Sit at the distance you choose, measured from your eye to the screen: 50 cm is about an arm\'s length.',
		'For the right eye, cover your left eye and look at the black cross on the left with your right eye. Do not look at the red dot.',
		'Press <strong>Start measuring</strong>. The dot moves slowly away from the cross. Press <strong>space</strong> (or tap the chart) the moment it disappears, and again when it comes back.',
		'Choose <strong>Left eye</strong>: the cross moves to the right side. Cover your right eye and repeat.',
	),
	'howto_title'    => 'How to find your blind spot',
	'results'        => '<p>The page shows where the dot vanished and came back, as an angle from the point you were looking at. In a typical eye:</p>
<ul>
<li>the blind spot starts at about <strong>12 to 13 degrees</strong> from where you look, towards the ear;</li>
<li>it ends at about <strong>18 degrees</strong>, so its center is near <strong>15 degrees</strong>;</li>
<li>it is about <strong>5 to 6 degrees wide</strong> and a little taller than it is wide, roughly the size of your fist at arm\'s length seen 15 degrees off to the side.</li>
</ul>
<p>A result a degree or two away from these numbers is usually a wrong distance, a missing calibration, a wandering eye or a late press. Repeat the test once or twice and take the average. The <strong>Classic</strong> mode shows the textbook picture: a dot placed at 15.5 degrees that vanishes when you are at the right distance. <strong>Fill-in</strong> shows a line with a gap at the blind spot that looks unbroken, because the brain fills the hole with what surrounds it.</p>',
	'extra'          => array(
		array(
			'Why we have a blind spot',
			'<p>The light-sensitive cells of the retina sit behind a layer of nerve fibers. All those fibers leave the eye together through one hole, the optic disc, to form the optic nerve, and there is no room for rods or cones there. The disc is about 1.5 mm across and lies about 15 degrees to the nose side of the center of the retina, so in what you see the blind spot falls about 15 degrees to the ear side.</p>
<p>You never notice it for two reasons. With both eyes open, each eye covers the other\'s blind spot. And with one eye closed, the brain fills the gap with the color and pattern around it, which is why the fill-in demo looks like an unbroken line. The French physicist Edme Mariotte first described the blind spot in 1660.</p>',
			'why',
		),
		array(
			'Blind spot or visual field loss?',
			'<p>The normal blind spot is small, in the same place in both eyes, and you do not notice it in daily life. Gaps you do notice are different. Missing patches, a shadow or curtain, a part of the page that disappears while reading, or bumping into things on one side can be a sign of glaucoma, retinal problems, optic nerve disease or a stroke. A visual field test at an optometrist or eye clinic maps your whole field properly. Seek urgent care for sudden loss of part of your vision.</p>',
			'field-loss',
		),
	),
	'fixes'          => array(
		array( 'The dot never disappears', 'Make sure the other eye is fully covered and you keep looking at the cross, not following the dot. Check the distance: if you sit much closer or further than chosen, the blind spot falls somewhere else on the screen.' ),
		array( 'The screen says it is too narrow', 'The dot must travel about 20 degrees. Turn a phone sideways, use full screen, or choose a shorter distance.' ),
		array( 'My angles look too big or too small', 'Calibrate the screen with a bank card, keep the browser zoom at 100%, and measure the distance to your eye with a tape.' ),
	),
	'faq'            => array(
		array( 'Does everyone have a blind spot?', 'Yes. Every healthy eye has one, where the optic nerve leaves the eye. It is normal and not a sign of disease.' ),
		array( 'Why can\'t I see my blind spot normally?', 'The other eye covers it, and the brain fills in the missing patch with the surrounding color and pattern.' ),
		array( 'Where is the blind spot?', 'About 15 degrees from the center of vision, towards the ear, and slightly below the horizontal.' ),
		array( 'How big is the blind spot?', 'About 5 to 6 degrees wide and 7 to 8 degrees tall, which is the size of a fist at arm\'s length.' ),
		array( 'Can the blind spot get bigger?', 'It can, for example with glaucoma or swelling of the optic nerve. A larger blind spot needs a proper visual field test to measure it.' ),
		array( 'Is the blind spot the same in both eyes?', 'Yes, it is a mirror image: to the right of where you look for the right eye and to the left for the left eye.' ),
	),
	'disclaimer'     => 'Medical disclaimer: this blind spot test is a demonstration for information only. It is not a visual field test and cannot detect glaucoma, retinal disease or other eye conditions. If you notice gaps, shadows or loss in your vision, see an optometrist or eye doctor straight away.',
	'related'        => array( 'eye-test', 'astigmatism-test', 'color-vision-test', 'red-green-color-blind-test', 'online-ruler', 'reaction-time-test' ),
	'updated'        => '2026-10-29',
);
