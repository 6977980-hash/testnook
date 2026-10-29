<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Red-Green Color Blind Test',
	'seo_title'      => 'Red-Green Color Blind Test: Free 12-Plate Online Check',
	'description'    => 'Free red-green color blind test with 12 dot plates. Find out in two minutes if you may have protan or deutan color blindness, then see what the result means.',
	'intro'          => 'Twelve dot plates, each hiding a number. People with normal colour vision read them all; people with red-green colour blindness miss most of them. The last two plates hint at the type: protan (red-weak) or deutan (green-weak). It takes about two minutes.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'red-green-color-blind-test' ),
	'scripts'        => array( 'red-green-color-blind-test' ),
	'embed_height'   => 820,
	'tool'           => '<div class="tool-stage cb-stage">
	<div class="cb-top"><span class="cb-step" id="cb-step">12 plates</span><div class="cb-progress" aria-hidden="true"><span id="cb-bar"></span></div><button type="button" class="btn btn-primary" id="cb-start">Start the test</button></div>
	<div class="cb-wrap" id="cb-wrap"><canvas id="cb-plate" width="400" height="400" aria-label="Colour test plate with a hidden number"></canvas></div>
	<div class="cb-answers" id="cb-answers"></div>
	<div class="cb-result" id="cb-result" aria-live="polite" hidden></div>
</div>
<p class="tool-status" id="cb-status" aria-live="polite">Turn off Night Light, True Tone and any blue light filter, set brightness to normal, then press Start.</p>
<p class="notice notice--warn">Screening only: this test cannot diagnose colour blindness. An optometrist or eye doctor can confirm the result.</p>',
	'howto'          => array(
		'Turn off Night Light (Windows), Night Shift and True Tone (Apple), Eye Comfort (Samsung) or any blue light filter. They tint the screen and change the plates.',
		'Sit about an arm\'s length from the screen in normal room light. Keep your glasses on if you wear them.',
		'Press <strong>Start the test</strong>. Look at each plate for no more than about three seconds and pick the number you see.',
		'If you cannot see a number, press <strong>I see no number</strong>. Guessing makes the result less useful.',
		'After plate 12 the page shows your result and the answer for every plate.',
	),
	'howto_title'    => 'How to take the red-green color blind test',
	'results'        => '<p>The test has three kinds of plates:</p>
<ul>
<li><strong>Plate 1</strong> uses a brightness difference, so everybody should read it. If you missed it, the problem is the screen or the setup, and the page asks you to try again.</li>
<li><strong>Plates 2 to 10</strong> hide the number in a red-green colour difference only, getting fainter as you go. Normal colour vision reads all or nearly all of them. Missing four or more points to red-green colour blindness; missing two or three, mostly the faint ones, can be a mild weakness or just a screen that shows colour poorly.</li>
<li><strong>Plates 11 and 12</strong> have two digits. One digit is drawn in a colour that people with protan colour blindness cannot see, the other in a colour that people with deutan colour blindness cannot see. If you read only the right-hand digit, the pattern is protan; only the left-hand digit, deutan.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>Result</th><th>Plates 2-10 missed</th><th>What to do</th></tr></thead>
<tbody>
<tr><td>No sign of red-green colour blindness</td><td>0-1</td><td>Nothing; your red-green colour vision looks normal.</td></tr>
<tr><td>Possible mild red-green weakness</td><td>2-3</td><td>Repeat on another screen; mention it at your next eye test.</td></tr>
<tr><td>Signs of red-green colour blindness</td><td>4 or more</td><td>Book an optometrist for a full colour vision test.</td></tr>
</tbody></table></div>',
	'extra'          => array(
		array(
			'What red-green colour blindness is',
			'<p>The retina has three kinds of cone cells, tuned to long (red), medium (green) and short (blue) wavelengths. Red-green colour blindness happens when the long or medium cones are missing or shifted. <strong>Protan</strong> types affect the red cones: reds look darker and can be confused with greens, browns and black. <strong>Deutan</strong> types affect the green cones and are the most common of all colour vision deficiencies. Each comes in a mild form (protanomaly, deuteranomaly), where colours are only weaker, and a strong form (protanopia, deuteranopia), where one cone type is missing.</p>
<p>Red-green colour blindness is usually inherited on the X chromosome, which is why it affects about 1 in 12 men but only about 1 in 200 women of European descent. It is present from birth, does not get worse, and does not affect sharpness of vision. Colour vision that changes later in life is different: it can come from eye disease, diabetes or some medicines, and should always be checked by a doctor.</p>',
			'about',
		),
		array(
			'How these plates work',
			'<p>The plates follow the idea of the Ishihara test, which Dr Shinobu Ishihara published in 1917: a circle of dots in varied sizes and brightness, with a number drawn only by a difference in colour. The plates on this page are generated in your browser, not copied from the Ishihara book. The colours were chosen with published models of how protans and deutans see (Machado, Oliveira and Fernandes, 2009) so that the number vanishes along their confusion lines, and every dot gets a random brightness so the number cannot be found by lightness alone.</p>
<p>A screen is less exact than printed plates under daylight. Screens differ in colour, so a result on one device can differ from another. Use the result as a reason to get tested, not as a diagnosis. For a broader check of all colours, including blue-yellow, try the <a href="/color-vision-test/">color vision test</a>.</p>',
			'how-it-works',
		),
		array(
			'Living with red-green colour blindness',
			'<p>Most people adapt without thinking about it. A few things help: turn on the colour filter in your phone or computer settings (Accessibility > Display > Color filters on iPhone, Android and Windows), use apps that name a colour from the camera, and label clothes or cables. Some jobs, such as pilot, electrician, train driver and some police and armed forces roles, have colour vision standards, so check them early with a formal test. Tinted glasses sold for colour blindness can make some colours stand out more, but they do not restore normal colour vision or help you pass a plate test.</p>',
			'living-with-it',
		),
	),
	'fixes'          => array(
		array( 'I could not read the first plate', 'Something is changing the screen colours. Turn off Night Light, Night Shift, True Tone, Eye Comfort and any blue light filter, raise brightness, and make sure no colour filter or high contrast mode is on in accessibility settings.' ),
		array( 'My result differs on my phone and laptop', 'Screens show colours differently, and a laptop panel with a narrow colour range can wash out the faint plates. Take the test on the best screen you have, at full brightness, and trust a formal test over any screen.' ),
		array( 'I wear glasses with a blue light filter', 'Take them off for this test, or use your normal clear glasses. Tinted lenses change the colours the same way a screen filter does.' ),
	),
	'faq'            => array(
		array( 'How accurate is an online color blind test?', 'It is a good screening tool but not a diagnosis. Screens vary in colour, so an online test can miss mild colour weakness or flag it when it is not there. An optometrist confirms it with printed plates under controlled light and, if needed, an anomaloscope.' ),
		array( 'What number should I see if I am not color blind?', 'You should read nearly every plate, including both digits on plates 11 and 12. The page shows the correct number for every plate at the end.' ),
		array( 'What is the difference between protan and deutan?', 'Protan colour blindness affects the red-sensitive cones, so reds also look darker. Deutan affects the green-sensitive cones and is more common. Both cause red-green confusion.' ),
		array( 'Can color blindness be cured?', 'Inherited colour blindness cannot be cured. Colour filters on phones and computers, colour naming apps and, for some people, special tinted glasses help with everyday tasks.' ),
		array( 'Why are men more often red-green color blind?', 'The genes for the red and green cones sit on the X chromosome. Men have one X, so one faulty copy is enough; women need two, which is much rarer.' ),
		array( 'Does this test check blue-yellow color blindness?', 'No. It looks at red-green only. The color vision test on this site arranges colours around the whole colour circle and can also show a blue-yellow (tritan) pattern.' ),
	),
	'disclaimer'     => 'Medical disclaimer: this red-green color blind test is for information and screening only. It is not a medical test and cannot diagnose colour blindness or any eye condition. Screen colours vary between devices. If you are worried about your colour vision, or it has changed, see an optometrist or eye doctor.',
	'related'        => array( 'color-vision-test', 'eye-test', 'astigmatism-test', 'blind-spot-test', 'dead-pixel-test', 'white-screen' ),
	'updated'        => '2026-10-29',
);
