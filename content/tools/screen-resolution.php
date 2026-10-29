<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'What Is My Screen Resolution',
	'seo_title'      => 'What Is My Screen Resolution? Check It Instantly (Free)',
	'description'    => 'See your screen resolution instantly: real pixels, scaled size, browser window size, pixel ratio and display scaling, with names like Full HD, QHD and 4K.',
	'intro'          => 'Your screen resolution, read straight from the browser: the real number of pixels on the panel, the scaled size that apps and websites use, your display scaling, and the size of this browser window. It updates live when you resize the window or rotate a phone.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'screen-info' ),
	'scripts'        => array( 'screen-info' ),
	'embed_height'   => 560,
	'tool'           => '<div class="tool-stage si-stage">
	<div class="si-hero"><small>Your screen resolution</small><strong data-si="physical">-</strong><span><span data-si="name">Reading your screen...</span> &middot; <span data-si="ratio">-</span></span></div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Scaled (CSS) size</span><span class="stat-value" data-si="css">-</span></div>
		<div class="stat"><span class="stat-label">Display scaling</span><span class="stat-value" data-si="scaling">-</span></div>
		<div class="stat"><span class="stat-label">Pixel ratio</span><span class="stat-value" data-si="dpr">-</span></div>
		<div class="stat"><span class="stat-label">Browser window</span><span class="stat-value" data-si="viewport">-</span></div>
		<div class="stat"><span class="stat-label">Available area</span><span class="stat-value" data-si="avail">-</span></div>
		<div class="stat"><span class="stat-label">Color depth</span><span class="stat-value" data-si="depth">-</span></div>
		<div class="stat"><span class="stat-label">Total pixels</span><span class="stat-value" data-si="megapixels">-</span></div>
		<div class="stat"><span class="stat-label">Orientation</span><span class="stat-value" data-si="orientation">-</span></div>
	</div>
</div>
<div class="btn-row"><button type="button" class="btn btn-primary" id="si-copy">Copy resolution</button><a class="btn" href="/screen-size/">Measure screen size</a></div>
<p class="tool-status" id="si-status" aria-live="polite">Values update live as you resize the window.</p>',
	'howto'          => array(
		'Open this page on the screen you want to check. If you have two monitors, drag the browser window onto the one you want; the values follow the window.',
		'Read the big number: that is the resolution of the panel in real pixels.',
		'Check <strong>Display scaling</strong>: at 150% scaling a 1920 x 1080 laptop screen gives apps a scaled size of 1280 x 720.',
		'Resize the window to see the <strong>Browser window</strong> size change, which is what a web page has to fit in.',
		'Press <strong>Copy resolution</strong> to paste the values into a support ticket or forum post.',
	),
	'howto_title'    => 'How to check your screen resolution',
	'results'        => '<ul>
<li><strong>Screen resolution</strong> (the big number) is the scaled size multiplied by the pixel ratio. On Windows, Android, ChromeOS and iPhone this is the native resolution of the panel. On a Mac it is the resolution macOS renders at, which can be higher than the panel when you choose "More space".</li>
<li><strong>Scaled (CSS) size</strong> is the size in the pixels that apps and websites lay out for. Windows calls it the result of "Scale", Macs call it "Looks like".</li>
<li><strong>Display scaling</strong> and <strong>pixel ratio</strong> are the same thing written two ways: 1.25 is 125%, 2 is 200%. Browser zoom changes them too, so press Ctrl+0 (Cmd+0 on a Mac) for a clean reading.</li>
<li><strong>Browser window</strong> is the space inside this tab. <strong>Available area</strong> is the screen minus the taskbar or dock.</li>
<li><strong>Color depth</strong> is usually 24-bit (8 bits per color). 30-bit appears on some HDR or 10-bit setups.</li>
</ul>
<h3>Common screen resolutions</h3>
<div class="table-scroll"><table class="si-res-table" id="si-res-table">
<thead><tr><th>Resolution</th><th>Name</th><th>Ratio</th><th>Typical screens</th></tr></thead>
<tbody>
<tr data-res="1366x768"><td>1366 x 768</td><td>HD (WXGA)</td><td>16:9</td><td>Budget laptops</td></tr>
<tr data-res="1600x900"><td>1600 x 900</td><td>HD+</td><td>16:9</td><td>Older laptops, small monitors</td></tr>
<tr data-res="1920x1080"><td>1920 x 1080</td><td>Full HD (1080p)</td><td>16:9</td><td>Most monitors, laptops and TVs</td></tr>
<tr data-res="1920x1200"><td>1920 x 1200</td><td>WUXGA</td><td>16:10</td><td>Business laptops and monitors</td></tr>
<tr data-res="2560x1440"><td>2560 x 1440</td><td>QHD (1440p)</td><td>16:9</td><td>27 inch gaming monitors</td></tr>
<tr data-res="2560x1600"><td>2560 x 1600</td><td>WQXGA</td><td>16:10</td><td>MacBook Air 13" (M1), tablets</td></tr>
<tr data-res="3440x1440"><td>3440 x 1440</td><td>UWQHD</td><td>21:9</td><td>34 inch ultrawide monitors</td></tr>
<tr data-res="3840x2160"><td>3840 x 2160</td><td>4K UHD</td><td>16:9</td><td>4K monitors and TVs</td></tr>
<tr data-res="5120x2880"><td>5120 x 2880</td><td>5K</td><td>16:9</td><td>Apple Studio Display, iMac 27"</td></tr>
<tr data-res="7680x4320"><td>7680 x 4320</td><td>8K UHD</td><td>16:9</td><td>8K TVs</td></tr>
</tbody></table></div>
<p>Your row is highlighted if it is in the table. Phones use taller ratios: an iPhone 16 is 1179 x 2556 and many Android phones are 1080 x 2400.</p>',
	'extra'          => array(
		array(
			'Native resolution, scaling and why websites see less',
			'<p>A modern screen packs so many pixels into a small area that text drawn at one pixel per point would be unreadably small. So the operating system scales everything up: a 14 inch laptop with a 2880 x 1800 panel at 200% shows things as big as a 1440 x 900 screen, just much sharper. Apps and websites lay out in those scaled "CSS pixels" and the system draws them with all the real pixels. That is why a website may say your screen is 1440 x 900 while the box says 2880 x 1800. This page multiplies the two to show both.</p>
<p>To change it: on <strong>Windows</strong>, Settings > System > Display > Display resolution (keep the one marked "Recommended") and Scale. On a <strong>Mac</strong>, System Settings > Displays, and pick a size from "Larger text" to "More space". On <strong>Android</strong>, Settings > Display > Screen resolution on phones that offer it. The native resolution gives the sharpest image on LCD and OLED panels.</p>',
			'scaling',
		),
		array(
			'Resolution is not the same as size or sharpness',
			'<p>Resolution counts pixels; it says nothing about inches. A 24 inch and a 32 inch 4K monitor both have 3840 x 2160 pixels, but the smaller one packs them more densely and looks sharper up close. To find the physical size of your screen, use the <a href="/screen-size/">screen size</a> tool; to work out pixel density from resolution and size, use the <a href="/ppi-calculator/">PPI calculator</a>; and for the shape of the screen, see the <a href="/screen-ratio/">screen ratio</a> page. The <a href="/device-info/">device info</a> page lists the resolution along with your browser, GPU and other details.</p>',
			'size-vs-resolution',
		),
	),
	'fixes'          => array(
		array( 'The resolution is lower than my monitor\'s', 'Windows may be set below native: Settings > System > Display > Display resolution, choose the "Recommended" value. Also check the cable (old HDMI or VGA can cap the resolution) and update the graphics driver.' ),
		array( 'The numbers change when I zoom the page', 'Browser zoom changes the pixel ratio the page sees. Press Ctrl+0 (Cmd+0 on a Mac) to reset zoom to 100% and the values return to normal.' ),
		array( 'It shows the wrong monitor', 'The browser reports the screen its window is on. Drag the window fully onto the other monitor; the values update by themselves.' ),
		array( 'My Mac shows a resolution higher than the panel', 'With a "More space" setting macOS renders at a higher resolution and scales the picture down to the panel. Choose the "Default" size to match the panel more closely.' ),
	),
	'faq'            => array(
		array( 'How do I find my screen resolution?', 'This page shows it the moment it opens. On Windows you can also go to Settings > System > Display; on a Mac, Apple menu > About This Mac > More Info > Displays.' ),
		array( 'What does 1920 x 1080 mean?', 'The screen is 1920 pixels wide and 1080 pixels tall, about 2.07 million pixels. It is called Full HD or 1080p.' ),
		array( 'Why does a website say my resolution is smaller?', 'Websites see the scaled size. With 150% display scaling, a 1920 x 1080 screen appears as 1280 x 720 to websites. This page shows both numbers.' ),
		array( 'Is 1080p, 1440p or 4K better?', 'More pixels give a sharper picture but need a stronger graphics card for games. 1080p suits 24 inch screens, 1440p 27 inch, and 4K 27 inch and up or TVs.' ),
		array( 'What is the most common screen resolution?', '1920 x 1080 is still the most common on desktops and laptops. On phones, sizes around 390 x 844 CSS pixels (1170 x 2532 real) and 412 x 915 are common.' ),
		array( 'Does this page store my resolution?', 'No. It is read and shown in your browser only, and nothing is sent to a server.' ),
	),
	'related'        => array( 'screen-size', 'screen-ratio', 'ppi-calculator', 'device-info', 'refresh-rate-test', 'dead-pixel-test' ),
	'updated'        => '2026-10-29',
);
