<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Types of Color Blindness Explained (With What Each Looks Like)',
	'seo_title'   => 'Types of Color Blindness: Protan, Deutan, Tritan and More',
	'description' => 'The types of color blindness explained: red-green (protan and deutan), blue-yellow (tritan) and total color blindness, how common each is and what each sees.',
	'blurb'       => 'Red-green, blue-yellow and total color blindness: how common each is and what each looks like.',
	'hub'         => 'vision-test',
	'tool'        => 'color-vision-test',
	'tools'       => array( 'red-green-color-blind-test', 'eye-test', 'monitor-color-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'About 1 in 12 men and 1 in 200 women see color differently from most people. "Color blind" covers several distinct conditions, most of them mild, almost none of them actual blindness to color. The color vision tests on this site are screening checks, not a diagnosis; an optometrist or ophthalmologist can confirm the type and degree.',
	'summary'     => array(
		'<strong>Red-green</strong> color vision deficiency is by far the most common: about 8% of men and 0.5% of women. It comes in two families, <strong>protan</strong> (red cone affected) and <strong>deutan</strong> (green cone affected), each mild (anomaly) or complete (anopia).',
		'<strong>Blue-yellow</strong> (tritan) deficiency is rare, about 1 in 10,000, affects both sexes equally and is often acquired rather than inherited.',
		'<strong>Total color blindness</strong> (achromatopsia) is very rare, about 1 in 30,000, and comes with light sensitivity and reduced sharpness.',
		'Online plate tests, like ours, are screening tools: they can suggest a type, but a diagnosis needs an optometrist with printed plates or an anomaloscope.',
	),
	'sections'    => array(
		array(
			'How color vision works, in two paragraphs',
			'<p>The retina has three kinds of cone cells, each most sensitive to a different band of light: long wavelengths (L, "red"), medium (M, "green") and short (S, "blue"). Every color you see is the brain comparing the signals from these three. Yellow, for example, is "L and M about equally, little S".</p>
<p>Color vision deficiency happens when one cone type is missing, or its sensitivity peak has shifted toward one of the others. If L and M cones respond almost alike, the brain cannot separate the colors that differ mainly in that comparison, which is the red-to-green axis. That is why almost all color blindness is red-green, and why it is inherited on the X chromosome: the genes for the L and M cone pigments live there, so men, with one X, are affected far more often.</p>',
			'how-colour-vision-works',
		),
		array(
			'Red-green color blindness: protan and deutan',
			'<div class="table-scroll"><table>
<thead><tr><th>Type</th><th>Cone affected</th><th>Share of men</th><th>Severity</th></tr></thead>
<tbody>
<tr><td>Deuteranomaly</td><td>M (green) shifted</td><td>about 5%</td><td>Mild to moderate; the most common form of all</td></tr>
<tr><td>Protanomaly</td><td>L (red) shifted</td><td>about 1%</td><td>Mild to moderate; reds also look darker</td></tr>
<tr><td>Deuteranopia</td><td>M (green) missing</td><td>about 1%</td><td>Complete red-green</td></tr>
<tr><td>Protanopia</td><td>L (red) missing</td><td>about 1%</td><td>Complete red-green; reds look very dark</td></tr>
</tbody></table></div>
<p><strong>What it looks like.</strong> People with red-green deficiency do see red and green; what they struggle with is colors that differ only along that axis. Confusion pairs are red and green, orange and yellow-green, brown and dark green, purple and blue, pink and gray. A ripe and unripe tomato, a red LED and a green LED, a green traffic light and a white street lamp at night, and many map and chart color schemes are common problems. Saturated, bright colors in good light are usually easy; pale or dark shades in dim light are hard.</p>
<p><strong>Protan vs deutan.</strong> Both confuse red with green. The protan difference is brightness: because the L cone carries much of the sensitivity to long wavelengths, reds appear dimmer to a protan. A red brake light at a distance can look like it is off. The anomalous forms (-anomaly) are a spectrum, from barely detectable to nearly as severe as the complete form.</p>
<p>Our <a href="/red-green-color-blind-test/">red-green test</a> uses plates designed to separate protan from deutan responses, and the full <a href="/color-vision-test/">color vision test</a> adds the blue-yellow plates.</p>',
			'red-green',
		),
		array(
			'Blue-yellow color blindness: tritan',
			'<p>Tritan deficiency affects the S (blue) cone. It is rare (roughly 1 in 10,000 for the inherited form) and is carried on chromosome 7, so it affects men and women equally. Confusion pairs are blue and green, yellow and violet, and sometimes red and pink. The sky and a green lawn can look similar; yellow can look pale or pinkish.</p>
<p>Much tritan-like vision is acquired rather than inherited. Aging of the lens (which yellows), cataract, glaucoma, diabetes, some medications and optic nerve conditions all reduce blue sensitivity. Because of that, a new blue-yellow problem in an adult is worth mentioning to an eye doctor; it can be an early sign of something treatable.</p>',
			'blue-yellow',
		),
		array(
			'Total color blindness: achromatopsia and monochromacy',
			'<p><strong>Rod monochromacy (achromatopsia)</strong> is the condition people imagine when they hear "color blind": the world in shades of gray. The cones do not work, so vision depends on rods, which are made for low light. People with achromatopsia have very poor sharpness, strong light sensitivity (bright days are painful without dark glasses) and often nystagmus. It affects about 1 in 30,000 people and is present from birth.</p>
<p><strong>Blue cone monochromacy</strong> is rarer still: only the S cones work. It has similar symptoms with some residual color discrimination between blue and other shades.</p>
<p>Neither can be detected by plate tests; both are diagnosed in childhood through the other symptoms.</p>',
			'total',
		),
		array(
			'How the tests work, and what they can and cannot tell you',
			'<p><strong>Pseudoisochromatic plates</strong> (Ishihara and similar) hide a number or shape in dots that differ from the background only along a confusion axis, with brightness and dot size scrambled so there is no other clue. Someone with normal color vision reads the figure; someone with the matching deficiency sees only dots, or reads a different figure printed for them. Standard sets include plates for red-green screening, plates that separate protan from deutan, and (in some sets) tritan plates.</p>
<p>Online plates have two limitations. Screen colors vary: an uncalibrated monitor, Night Shift, a blue-light filter or a very dim screen can shift the colors enough to change a result in either direction. Run the <a href="/monitor-color-test/">monitor color test</a> first and turn off any color filters. And plate tests say "probably deficient, probably this type"; they cannot measure severity well.</p>
<p>A proper diagnosis uses printed plates under controlled lighting, arrangement tests (Farnsworth D-15 or the 100 Hue, where you put colored caps in order) that measure type and severity, or an anomaloscope, which is the reference standard for red-green. If a screening result matters to you, for a job that requires color vision (pilot, electrician, some police and transport roles), ask for the formal test.</p>',
			'testing',
		),
		array(
			'Living with it: what helps',
			'<ul>
<li><strong>Software filters.</strong> Windows (Settings &gt; Accessibility &gt; Color filters), macOS and iOS (Accessibility &gt; Display &gt; Color Filters) and Android (Accessibility &gt; Color correction) each have protan, deutan and tritan modes that shift colors to make confusion pairs more distinct on screen.</li>
<li><strong>Labels, not colors.</strong> Ask for charts with patterns or text labels; most office software can switch to a color-blind-safe palette. Game "colourblind modes" change team colors and markers.</li>
<li><strong>Tinted glasses.</strong> Notch-filter glasses (EnChroma and others) increase the contrast between red and green for many people with anomalous trichromacy. They do not give normal color vision, do not work for the complete forms, and are not accepted for occupational tests. Reviews are mixed; try before buying if you can.</li>
<li><strong>Know your confusion pairs.</strong> Most people with red-green deficiency manage well by learning which situations are risky (meat doneness, LED status lights, certain maps) and using position, brightness or a phone app with a color picker instead.</li>
</ul>',
			'what-helps',
		),
	),
	'disclaimer'  => 'This guide and the color vision tests on this site are for information and screening only. They do not diagnose any condition. If a result concerns you, or your color vision has changed recently, see an optometrist or ophthalmologist.',
	'faq'         => array(
		array( 'What is the most common type of color blindness?', 'Deuteranomaly, a mild to moderate red-green deficiency where the green cone\'s sensitivity is shifted toward red. It affects about 5% of men, which is more than all other types combined.' ),
		array( 'Why are men color blind more often than women?', 'The genes for the red and green cone pigments are on the X chromosome. Men have one X, so one faulty copy is enough. Women have two and need both copies affected, which is why red-green deficiency is about 16 times rarer in women.' ),
		array( 'Can color blindness be cured?', 'Inherited color vision deficiency has no cure today; gene therapy has worked in animals and is in early human trials. Acquired deficiencies can improve if the cause (a cataract, a medication, an illness) is treated. Filters and glasses help with specific tasks but do not restore normal color vision.' ),
		array( 'Can you become color blind later in life?', 'Yes. Cataracts, glaucoma, diabetes, macular degeneration, some drugs (including certain antibiotics and heart medications) and optic nerve conditions can reduce color discrimination, most often along the blue-yellow axis. A new change deserves an eye examination.' ),
		array( 'Can color blind people drive?', 'In almost every country, yes. Traffic lights have a fixed position order and brightness, and road signs rely on shape. Some commercial licences and jobs (pilots, train drivers, electricians, some maritime roles) have color vision requirements with specific tests.' ),
		array( 'Are online color blind tests accurate?', 'They are good at flagging a likely red-green deficiency when the screen is set up properly and color filters are off, and reasonable at suggesting protan versus deutan. They cannot measure severity or diagnose. Treat a failed screen as a reason to see an optometrist, not as a diagnosis.' ),
	),
	'sources'     => array(
		array( 'National Eye Institute: Color Blindness', 'https://www.nei.nih.gov/learn-about-eye-health/eye-conditions-and-diseases/color-blindness' ),
		array( 'Color Blind Awareness: Types of color blindness', 'https://www.colourblindawareness.org/colour-blindness/types-of-colour-blindness/' ),
	),
);
