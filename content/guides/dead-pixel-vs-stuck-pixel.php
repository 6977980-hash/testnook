<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Dead Pixel vs Stuck Pixel: How to Tell and How to Fix',
	'seo_title'   => 'Dead Pixel vs Stuck Pixel: Differences, Fixes and Warranty',
	'description' => 'A dead pixel stays black, a stuck pixel stays one color. How to tell them apart, which kind can be fixed, what to try, and when a warranty swap applies.',
	'blurb'       => 'Black is dead, colored is stuck. Which ones can be fixed, and when a screen qualifies for replacement.',
	'hub'         => 'screen',
	'tool'        => 'dead-pixel-test',
	'tools'       => array( 'stuck-pixel-fixer', 'white-screen', 'black-screen', 'monitor-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'One wrong dot on a new screen is maddening. Whether you can fix it, and whether the shop has to replace the screen, depends on which kind of dot it is.',
	'summary'     => array(
		'A <strong>dead pixel</strong> is black on every color: its transistor gets no power. It cannot be fixed by software.',
		'A <strong>stuck pixel</strong> is a bright red, green, blue or white dot: one sub-pixel is stuck on. These sometimes recover with a flashing-colour fixer or time.',
		'A <strong>hot pixel</strong> (white on black) is a stuck pixel with all three sub-pixels on. Dark smudges that move when pressed are dust or pressure marks, not pixels.',
		'Most makers follow ISO 9241-307 class II: a few defects per million pixels are "within spec". Premium zero-pixel policies and the retailer\'s own return window are your best route to a swap.',
	),
	'sections'    => array(
		array(
			'First, find every bad pixel',
			'<p>Clean the screen with a dry microfiber cloth: most "dead pixels" reported to us turn out to be a speck of dust. Then run the <a href="/dead-pixel-test/">dead pixel test</a> full screen and step through black, white, red, green and blue. Look at each color from about 30 cm, scanning in rows. Note what each dot does:</p>
<div class="table-scroll"><table>
<thead><tr><th>On white</th><th>On black</th><th>On red, green, blue</th><th>What it is</th></tr></thead>
<tbody>
<tr><td>Black dot</td><td>Invisible</td><td>Black dot</td><td><strong>Dead pixel</strong> (all sub-pixels off).</td></tr>
<tr><td>Colored dot (e.g. magenta)</td><td>Invisible</td><td>Black on one color only</td><td><strong>Dead sub-pixel</strong>: one of the three is off.</td></tr>
<tr><td>Invisible</td><td>Red, green or blue dot</td><td>Visible on the other two colors</td><td><strong>Stuck sub-pixel</strong>: one is always on.</td></tr>
<tr><td>Invisible</td><td>White dot</td><td>Visible on every color</td><td><strong>Hot pixel</strong>: all three stuck on.</td></tr>
<tr><td>Gray smudge, often larger than a pixel</td><td>Invisible or faint</td><td>Faint</td><td><strong>Pressure mark or mura</strong>, not a pixel defect.</td></tr>
</tbody></table></div>
<p>The test lets you mark where the dot is; it is anonymously added to the site map of where bad pixels sit. Most sit near the edges, where the panel is handled and flexed during assembly and shipping.</p>',
			'identify',
		),
		array(
			'Why dead pixels stay dead',
			'<p>Each pixel on an LCD is three liquid-crystal cells (red, green, blue), each driven by its own thin-film transistor. When a transistor fails open, its cell never receives a charge, the crystal stays in its blocking state, and the sub-pixel is black no matter what the computer sends. On an OLED, a dead pixel is an emitter that no longer lights. There is no software path to a broken transistor, so a dead pixel is permanent. The only fix is a panel replacement.</p>
<p>The one exception: a cell that only looks dead because its transistor is stuck in a nearly-off state can occasionally be nudged by the same methods that help stuck pixels. It costs nothing to try, but do not expect much.</p>',
			'dead-pixels',
		),
		array(
			'How to fix a stuck pixel',
			'<p>A stuck sub-pixel has a transistor that is passing charge when it should not, often because the liquid crystal in that cell has settled. Rapidly cycling the cell sometimes frees it. Success rates reported by users are around 30 to 50% for recently appeared stuck pixels and lower for old ones.</p>
<ol>
<li><strong>Run the <a href="/stuck-pixel-fixer/">stuck pixel fixer</a></strong> over the dot for 10 to 20 minutes. It flashes the colors at high speed in a small window you drag over the pixel. Repeat two or three times; some pixels free up after an hour.</li>
<li><strong>Leave it running longer.</strong> A few hours of flashing colors or a full-screen color cycle overnight is the next step. OLED owners should limit this to under an hour at a time.</li>
<li><strong>Gentle pressure (LCD only, at your own risk).</strong> Turn the screen off, wrap a fingertip or a stylus tip in a microfiber cloth, press lightly exactly on the pixel for a few seconds, and turn the screen on while pressing. The idea is to redistribute the liquid crystal. Press too hard and you create more defects, so this is a last resort, and never on an OLED, which has no liquid crystal.</li>
<li><strong>Warmth.</strong> A warm (not hot) damp cloth in a sealed bag held on the spot for a minute, combined with the fixer, is a folk remedy with occasional success.</li>
</ol>
<p>If the pixel is still stuck after a couple of days of trying, it is unlikely to change.</p>',
			'fix-stuck',
		),
		array(
			'Does one dead pixel qualify for a warranty replacement?',
			'<p>Usually not on its own, which surprises people. Panels are made with millions of transistors, and makers accept a few failures as normal. Most follow the ISO 9241-307 standard, where class II (the common class) allows per million pixels: up to 2 fully bright pixels, 2 fully dark pixels and 5 stuck sub-pixels. A 4K screen has 8.3 million pixels, so class II permits up to 16 bright, 16 dark and 41 sub-pixel defects. Many makers set stricter internal limits, especially for premium lines, and some add a rule about clusters (two defects within 5 mm) or dead pixels in the center.</p>
<p>What actually works:</p>
<ul>
<li><strong>Use the retailer\'s return window first.</strong> In the first 14 to 30 days most shops take a return for any reason; a dead pixel on day 3 is a return, not a warranty claim.</li>
<li><strong>Check for a zero-pixel policy.</strong> Some brands (Dell Premium Panel Guarantee, EIZO, some ASUS ProArt and LG lines) replace for a single bright pixel. The policy is in the warranty document for your exact model.</li>
<li><strong>Photograph it.</strong> A clear photo of the pixel on a white screen and on a black screen, with the model and serial visible in another photo, makes the claim simple.</li>
<li><strong>Phones and laptops</strong> are usually judged by the same standards; Apple, for instance, has an internal threshold that is not published but is known to replace for a small number of bright pixels under AppleCare.</li>
</ul>',
			'warranty',
		),
		array(
			'Preventing pixel defects',
			'<p>You cannot prevent a transistor failing, but most defects after purchase come from physical stress: pressing on the screen to clean it, closing a laptop on a pen or earphone, or carrying a laptop in a bag that flexes the lid. Clean with a dry microfiber cloth and no pressure, keep anything hard off the keyboard before closing the lid, and use a sleeve with a stiff back. Run a quick pixel check on any new screen, used or new, within the return window; it takes two minutes.</p>',
			'prevention',
		),
	),
	'data'        => array(
		'boards' => array( 'deadpixel' ),
		'title'  => 'What people find on Testnook',
		'after'  => 'identify',
		'html'   => '<p>Over the last 30 days, <strong>{count:deadpixel}</strong> people recorded a result from the dead pixel test on this site. The map below shows where on the screen the reported pixels were.</p>',
	),
	'faq'         => array(
		array( 'Can a dead pixel be fixed?', 'A truly dead pixel (black on every color) cannot be fixed by software; the transistor driving it has failed. A stuck pixel (a bright colored dot) sometimes can, with a flashing-colour fixer.' ),
		array( 'Can dead pixels spread?', 'A single dead pixel does not spread. A growing dark patch, a line of pixels, or a cluster appearing over days is panel damage (a cracked layer or a failing driver), which does get worse and is a warranty case.' ),
		array( 'Will a stuck pixel go away on its own?', 'Sometimes. Stuck pixels that appear and vanish within days are common on new panels. If one has been there for weeks, running a pixel fixer is worth a try; after that it is probably permanent.' ),
		array( 'How many dead pixels are acceptable?', 'Under ISO 9241-307 class II, the most common standard, a few per million pixels: on a Full HD monitor that is up to 4 bright, 4 dark and 10 sub-pixel defects before a warranty claim must be accepted. Many brands and retailers are more generous in the first weeks after purchase.' ),
		array( 'Is a white dot on a black screen a dead pixel?', 'No, that is a hot pixel: all three sub-pixels stuck on. It is the most visible kind and the one most zero-pixel policies cover. Try the stuck pixel fixer on it first.' ),
		array( 'Do OLED screens get dead pixels?', 'Yes, though less often than LCDs. On OLED a dead pixel is an emitter that stopped lighting. There is no pressure fix for OLED; do not press on the panel.' ),
	),
);
