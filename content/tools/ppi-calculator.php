<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'PPI Calculator',
	'seo_title'      => 'PPI Calculator: Pixels Per Inch, Dot Pitch & Screen Size',
	'description'    => 'Free PPI calculator. Enter a screen\'s resolution and diagonal to get pixels per inch, dot pitch, physical size and the distance at which pixels disappear.',
	'intro'          => 'Work out the pixel density of any screen. Enter the resolution and the diagonal size, or pick a common monitor, laptop or phone, and the calculator gives pixels per inch (PPI), pixels per centimeter, dot pitch, the screen\'s width and height, and the viewing distance at which single pixels can no longer be seen.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'screen-info' ),
	'scripts'        => array( 'screen-info' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-stage si-stage">
	<div class="si-form">
		<label>Common screens<select id="pp-preset">
			<option value="">Choose a screen...</option>
			<option value="1920,1080,24">24" Full HD monitor</option>
			<option value="2560,1440,27">27" QHD monitor</option>
			<option value="3840,2160,27">27" 4K monitor</option>
			<option value="3840,2160,32">32" 4K monitor</option>
			<option value="3440,1440,34">34" ultrawide</option>
			<option value="1920,1080,15.6">15.6" Full HD laptop</option>
			<option value="2560,1664,13.6">MacBook Air 13" (13.6")</option>
			<option value="3024,1964,14.2">MacBook Pro 14" (14.2")</option>
			<option value="1179,2556,6.1">iPhone 16 / 15 (6.1")</option>
			<option value="1080,2340,6.2">Galaxy S25 (6.2")</option>
			<option value="3840,2160,55">55" 4K TV</option>
			<option value="3840,2160,65">65" 4K TV</option>
		</select></label>
		<button type="button" class="btn" id="pp-mine">Use my screen</button>
	</div>
	<div class="si-form" style="margin-top:10px">
		<label>Width (pixels)<input type="number" id="pp-w" min="1" max="32768" step="1" value="2560" inputmode="numeric"></label>
		<label>Height (pixels)<input type="number" id="pp-h" min="1" max="32768" step="1" value="1440" inputmode="numeric"></label>
		<label>Diagonal<input type="number" id="pp-d" min="1" max="200" step="any" value="27" inputmode="decimal"></label>
		<label>Unit<select id="pp-unit"><option value="in">inches</option><option value="cm">cm</option></select></label>
	</div>
	<div class="si-hero" style="margin-top:16px"><small>Pixel density</small><strong><span data-si="pp-ppi">-</span> PPI</strong><span data-si="pp-verdict"></span></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Pixels per cm</span><span class="stat-value" data-si="pp-ppcm">-</span></div>
		<div class="stat"><span class="stat-label">Dot pitch</span><span class="stat-value" data-si="pp-pitch">-</span></div>
		<div class="stat"><span class="stat-label">Screen size</span><span class="stat-value" data-si="pp-size">-</span></div>
		<div class="stat"><span class="stat-label">Aspect ratio</span><span class="stat-value" data-si="pp-ratio">-</span></div>
		<div class="stat"><span class="stat-label">Total pixels</span><span class="stat-value" data-si="pp-mp">-</span></div>
		<div class="stat"><span class="stat-label">Pixels vanish beyond</span><span class="stat-value" data-si="pp-retina">-</span></div>
	</div>
</div>',
	'howto'          => array(
		'Pick a screen from <strong>Common screens</strong>, or type the horizontal and vertical resolution in pixels.',
		'Enter the diagonal size from the spec sheet, in inches or centimeters.',
		'Press <strong>Use my screen</strong> to fill in this device\'s resolution; add its diagonal (the <a href="/screen-size/">screen size</a> page can measure it).',
		'Read the PPI and the other values; they update as you type.',
	),
	'howto_title'    => 'How to use the PPI calculator',
	'results'        => '<p><strong>PPI</strong> (pixels per inch) is the diagonal in pixels divided by the diagonal in inches: <code>PPI = &radic;(width&sup2; + height&sup2;) / diagonal</code>. A 27 inch 2560 x 1440 monitor has &radic;(2560&sup2; + 1440&sup2;) = 2937 pixels across its diagonal, so 2937 / 27 = 108.8 PPI.</p>
<ul>
<li><strong>Dot pitch</strong> is the distance between the centers of two pixels, 25.4 / PPI in millimeters. Smaller is sharper.</li>
<li><strong>Pixels vanish beyond</strong> is the distance at which one pixel covers one arcminute, the detail limit of 20/20 vision. Further away than this, a person with normal sight cannot see single pixels. Apple\'s "Retina" idea is based on the same calculation.</li>
<li><strong>Screen size</strong> is the width and height of the picture, worked out from the diagonal and the pixel ratio.</li>
</ul>
<div class="table-scroll"><table>
<thead><tr><th>Screen</th><th>Typical PPI</th></tr></thead>
<tbody>
<tr><td>55-65 inch 4K TV</td><td>68-80</td></tr>
<tr><td>24 inch 1080p monitor</td><td>92</td></tr>
<tr><td>27 inch 1440p monitor</td><td>109</td></tr>
<tr><td>27 inch 4K monitor</td><td>163</td></tr>
<tr><td>Laptops (Full HD to Retina)</td><td>140-260</td></tr>
<tr><td>Phones</td><td>400-500</td></tr>
</tbody></table></div>',
	'extra'          => array(
		array(
			'How much PPI do you need?',
			'<p>It depends on how far away you sit. A desktop monitor at 60-70 cm looks sharp from about 110 PPI and very sharp from 160 PPI; that is why a 27 inch 1440p monitor is popular and 4K is the step up. Laptops sit closer, so 200 PPI and above looks clean. Phones are held at 25-30 cm and need 400 PPI or more for pixels to disappear. TVs are watched from 2-3 meters, where 70-80 PPI on a 4K set is already beyond what the eye can resolve; 8K adds little at normal distances.</p>
<p>High PPI is not free: it needs display scaling (often 150-200%) to keep text readable, and in games it needs a stronger graphics card. See your current scaling on the <a href="/screen-resolution/">screen resolution</a> page.</p>',
			'how-much-ppi',
		),
		array(
			'PPI and DPI',
			'<p>PPI describes screens: how many pixels sit in an inch of the panel. DPI (dots per inch) describes printers, which build each pixel from many tiny ink dots, and it is also used loosely for mouse sensitivity, which is a different thing again (counts per inch of movement; see the <a href="/dpi-analyzer/">DPI analyzer</a>). For printing, 300 pixels per inch of the printed size is the usual target for photos.</p>',
			'ppi-dpi',
		),
	),
	'fixes'          => array(
		array( 'The PPI does not match the spec sheet', 'Spec sheets round the diagonal (a "27 inch" monitor is often 27.0 to 27.2 inches) and some round the PPI. A difference of 1-2% is normal.' ),
		array( 'Use my screen gives the wrong resolution', 'The browser reports the screen this window is on, multiplied by the pixel ratio. Reset browser zoom to 100% (Ctrl+0) and make sure the window is on the right monitor.' ),
		array( 'I only know the size in centimeters', 'Choose cm as the unit. The calculator converts it to inches for you.' ),
	),
	'faq'            => array(
		array( 'How do I calculate PPI?', 'Square the width and height in pixels, add them, take the square root, and divide by the diagonal in inches. The calculator does it for you.' ),
		array( 'What is a good PPI for a monitor?', 'About 110 PPI is sharp at normal desk distance, and 140-165 PPI is very sharp. Less than 90 PPI shows visible pixels up close.' ),
		array( 'What is the PPI of a 27 inch 4K monitor?', 'About 163 PPI. A 27 inch 1440p monitor is about 109 PPI and a 27 inch 1080p one about 82 PPI.' ),
		array( 'What is Retina display PPI?', 'Apple calls a screen Retina when single pixels cannot be seen at the normal viewing distance. That is around 220 PPI for laptops and 300-460 PPI for phones.' ),
		array( 'Is higher PPI always better?', 'Higher PPI gives sharper text and images but needs display scaling and more graphics power. Beyond the distance where pixels vanish, extra PPI makes little visible difference.' ),
		array( 'What is dot pitch?', 'The distance between two pixel centers, in millimeters. A 24 inch 1080p monitor has a dot pitch of about 0.277 mm.' ),
	),
	'related'        => array( 'screen-size', 'screen-resolution', 'aspect-ratio-calculator', 'screen-ratio', 'online-ruler', 'dpi-analyzer' ),
	'updated'        => '2026-10-29',
);
