<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Color Vision Test',
	'seo_title'      => 'Color Vision Test: Free Online Hue Arrangement Test',
	'description'    => 'Free online color vision test. Put 15 coloured caps in order around the colour circle and see if your pattern points to a red, green or blue colour deficiency.',
	'intro'          => 'Arrange 15 coloured caps so the colours change smoothly, starting from the fixed cap on the left. Normal colour vision follows the colour circle; colour vision deficiencies cross it along a typical line. Unlike a dot plate test, it covers blue-yellow (tritan) as well as red-green.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'color-vision-test' ),
	'scripts'        => array( 'color-vision-test' ),
	'embed_height'   => 720,
	'tool'           => '<div class="tool-stage cv-stage">
	<div class="cv-head">
		<div class="seg" role="group" aria-label="Test version">
			<button type="button" data-cv-mode="standard" aria-pressed="true">Standard</button>
			<button type="button" data-cv-mode="pale" aria-pressed="false">Pale (harder)</button>
		</div>
	</div>
	<p class="cv-label">Your order (reference cap first)</p>
	<div class="cv-row" id="cv-row"></div>
	<p class="cv-label">Caps to place</p>
	<div class="cv-tray" id="cv-tray"></div>
	<div class="cv-actions">
		<button type="button" class="btn btn-primary" id="cv-score" disabled>Score</button>
		<button type="button" class="btn" id="cv-undo">Undo</button>
		<button type="button" class="btn" id="cv-reset">Reset</button>
	</div>
	<div class="cv-result" id="cv-result" aria-live="polite" hidden></div>
</div>
<p class="tool-status" id="cv-status" aria-live="polite">The caps need JavaScript to appear.</p>
<p class="notice notice--warn">Screening only: this test cannot diagnose a colour vision deficiency. An optometrist or eye doctor can confirm the result.</p>',
	'howto'          => array(
		'Turn off Night Light, Night Shift, True Tone, Eye Comfort and any blue light filter, and set brightness to normal.',
		'Look at the reference cap at the start of the row. From the caps below, tap the one closest in colour to it.',
		'Then tap the cap closest to the one you just placed, and carry on until all 15 are in the row. Tap a placed cap to take it back, or use <strong>Undo</strong>.',
		'Take your time; there is no time limit. When the row looks like a smooth change of colour, press <strong>Score</strong>.',
		'Try the <strong>Pale</strong> version for a harder test that picks up milder colour weakness.',
	),
	'howto_title'    => 'How to take the color vision test',
	'results'        => '<p>The result shows your order drawn around the colour circle, like the score sheet of the Farnsworth D-15 test. Each cap sits at its own hue, and lines join the caps in the order you placed them.</p>
<ul>
<li><strong>Normal colour arrangement:</strong> the lines go round the circle. One or two small slips (swapping two neighbours) are normal.</li>
<li><strong>One major crossing:</strong> one line cuts across the circle. This is often a slip of attention; repeat the test.</li>
<li><strong>Two or more major crossings:</strong> lines cut across the circle again and again in the same direction. The direction is the confusion axis: protan (red), deutan (green) or tritan (blue-yellow).</li>
</ul>
<p>The <strong>confusion index</strong> compares the total colour difference along your order with the perfect order. 1.00 is perfect; mistakes make it larger. The page finds the type by simulating protan, deutan and tritan vision and checking which one makes your order look smoothest.</p>
<p>The standard version uses colours of medium strength, like the D-15, and mainly picks up moderate to strong deficiencies. The pale version is similar to the desaturated Lanthony D-15d and picks up milder ones. A clear red-green result is worth checking with the <a href="/red-green-color-blind-test/">red-green color blind test</a> too.</p>',
	'extra'          => array(
		array(
			'Arrangement tests and plate tests',
			'<p>Plate tests like the Ishihara are fast and very good at finding red-green colour blindness, but they say little about how strong it is and do not test blue-yellow vision. Arrangement tests ask you to sort colours instead. The Farnsworth D-15 (1947) is the best known: 15 caps around a hue circle, used by optometrists and in some job medicals to separate mild deficiencies from those that matter for the work. People with a strong red-green deficiency make the classic crossing patterns; most people with a mild one pass the D-15 but fail the plates.</p>
<p>This online version uses its own evenly spaced colours rather than the original Munsell caps, and a screen is never as exact as real caps under a daylight lamp. It is a useful check at home, not a replacement for the real test.</p>',
			'arrangement',
		),
		array(
			'Blue-yellow (tritan) colour deficiency',
			'<p>Tritan defects affect the short-wavelength (blue) cones. Inherited tritan colour blindness is rare, about 1 in 10,000 people, and affects men and women equally. Blue-yellow colour vision is more often lost later in life, from cataract (the lens yellows with age), glaucoma, diabetic eye disease, some medicines or other conditions. If your result shows a tritan pattern, or your colour vision has changed recently, see an eye doctor.</p>',
			'tritan',
		),
	),
	'fixes'          => array(
		array( 'All the caps look almost the same', 'Raise the screen brightness, check that no colour filter, greyscale or night mode is on, and use the Standard version. On a very dim or tinted screen the caps lose their colour.' ),
		array( 'I keep getting one crossing', 'Go slowly and compare each new cap with the last one placed, not with the reference cap. Small swaps are normal; a single long jump is usually a slip.' ),
		array( 'The result changes between screens', 'Screens show colours differently. Use the screen with the best colour (most phones with OLED displays and good laptops), and trust a formal test over any screen.' ),
	),
	'faq'            => array(
		array( 'What is a color vision test?', 'A test of how well you tell colours apart. Plate tests find red-green colour blindness; arrangement tests like this one show the type and how strong it is, including blue-yellow.' ),
		array( 'Is this the Farnsworth D-15 test?', 'It works the same way, with 15 caps around a colour circle and the same kind of score diagram, but uses its own colours on a screen. It is a screening version, not the clinical test.' ),
		array( 'What is a normal result?', 'Caps in order, or with one or two swaps between neighbours, and no lines that cut across the circle.' ),
		array( 'What do protan, deutan and tritan mean?', 'They name the cone affected: protan the red-sensitive cones, deutan the green-sensitive cones and tritan the blue-sensitive cones.' ),
		array( 'Can I pass this test and still be color blind?', 'Yes. Many people with mild red-green colour weakness sort the standard caps correctly. Try the pale version and the red-green plate test as well.' ),
		array( 'Can color vision change with age?', 'Yes. The lens of the eye slowly yellows, which mostly affects blues. A sudden or one-sided change in colour vision should be checked by a doctor straight away.' ),
	),
	'disclaimer'     => 'Medical disclaimer: this color vision test is for information and screening only. It is not a medical test and cannot diagnose a colour vision deficiency or any eye disease. Screen colours vary between devices. If you are worried about your colour vision, or it has changed, see an optometrist or eye doctor.',
	'related'        => array( 'red-green-color-blind-test', 'eye-test', 'astigmatism-test', 'blind-spot-test', 'grey-screen', 'dead-pixel-test' ),
	'updated'        => '2026-10-29',
);
