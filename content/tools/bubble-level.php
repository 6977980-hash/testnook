<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Bubble Level',
	'seo_title'      => 'Bubble Level: Free Online Spirit Level for Your Phone',
	'description'    => 'A free bubble level for your phone. Lay it flat for a round level or stand it on an edge for a bar level, with angles to 0.1 degrees and one-tap calibration.',
	'intro'          => 'Turn your phone into a spirit level, no app needed. Lay it on a shelf, table or picture frame to see the bubble and the tilt in degrees, or stand it on its edge for a bar level. Set zero on a surface you know is level to calibrate it.',
	'device'         => 'touch',
	'device_message' => 'A bubble level needs the tilt sensor in a phone or tablet. Open this page on your phone.',
	'ads'            => 'content',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'bubble-level' ),
	'embed_height'   => 760,
	'tool'           => '<div class="tool-stage sn-stage">
	<div class="btn-row">
		<button type="button" class="btn btn-primary" id="lv-start">Start level</button>
		<button type="button" class="btn" id="lv-zero" disabled>Set zero here</button>
		<button type="button" class="btn" id="lv-hold" aria-pressed="false" disabled>Hold reading</button>
		<button type="button" class="btn btn-sm" id="lv-clear" hidden>Clear calibration</button>
	</div>
	<div class="lv-wrap" id="lv-wrap">
		<div class="lv-disc" id="lv-disc" aria-hidden="true"><div class="lv-cross"></div><div class="lv-bubble" id="lv-bubble"></div></div>
		<div class="lv-bar" id="lv-bar" aria-hidden="true" hidden><div class="lv-bubble" id="lv-bubble2"></div></div>
		<div class="lv-read"><div><small id="lv-al">Left / right</small><span id="lv-a">-</span></div><div><small id="lv-bl">Front / back</small><span id="lv-b">-</span></div></div>
		<p class="sn-label" id="lv-mode">Flat (lay the phone down)</p>
	</div>
</div>
<p class="tool-status" id="lv-status" aria-live="polite">Open this page on your phone and tap Start. On iPhone, tap Allow when Safari asks for motion access.</p>',
	'howto'          => array(
		'Open this page on the phone and tap <strong>Start level</strong>. On iPhone, tap <strong>Allow</strong> for motion access.',
		'Lay the phone flat on the surface. The bubble moves to the high side; when it sits in the small circle and both angles read 0.0&deg;, the surface is level and the ring turns green.',
		'To check a shelf edge, door frame or picture, stand the phone on its long or short edge against it. The page switches to the bar level and tells you which side is low.',
		'For the best accuracy, calibrate: put the phone on a surface you know is level (or check one by turning the phone round 180&deg; and seeing the same reading), then tap <strong>Set zero here</strong>.',
		'Tap <strong>Hold reading</strong> to freeze the numbers when you cannot see the screen, such as on a high shelf.',
	),
	'howto_title'    => 'How to use the bubble level',
	'results'        => '<p>The angle is how far the surface tilts from level, in degrees. As a rule of thumb, 1&deg; is a rise of about 1.7 cm over a metre (or 0.2 inches per foot).</p>
<ul>
<li><strong>Under 0.3&deg;:</strong> level for any household job: shelves, pictures, a washing machine, a fridge.</li>
<li><strong>0.3 to 1&deg;:</strong> visibly off over a long shelf or a wide picture frame. Adjust the low side.</li>
<li><strong>Over 1&deg;:</strong> clearly sloping. Liquids in a pan run to one side, balls roll and doors swing.</li>
</ul>
<p>Phone tilt sensors are accurate to about 0.1 to 0.5&deg; after calibration. A camera bump stops many phones lying flat, so lay it on a book or use a case, and calibrate on the same setup.</p>',
	'extra'          => array(
		array(
			'The 180 degree check',
			'<p>Not sure the phone itself is accurate? Put it on a surface and note the reading, then turn it round 180&deg; on the same spot. If the surface is level, both readings are 0. If the reading flips sign but keeps the same size (say 0.8&deg; left, then 0.8&deg; right), the surface slopes and the phone is accurate. If the readings differ in size, the phone has an offset: tap Set zero halfway between them, or calibrate on a known level surface. Builders check real spirit levels the same way.</p>',
			'check',
		),
		array(
			'How the phone knows which way is level',
			'<p>The bubble level uses the accelerometer, which always feels gravity pulling down. When the phone lies flat, gravity points straight through the screen; when it tilts, part of gravity shows up on the side axes and the page converts that into an angle. The same sensor runs auto-rotate and step counting. If the level never settles at 0 on a known flat surface, check the sensor with the <a href="/accelerometer-test/">accelerometer test</a>.</p>',
			'how',
		),
	),
	'fixes'          => array(
		array( 'The bubble does not move', 'Tap Start first, then allow motion access (iPhone). In Chrome on Android, tap the lock icon by the address and allow Motion sensors. A laptop has no tilt sensor.' ),
		array( 'It never reads zero on a flat table', 'The camera bump tilts the phone. Put it in a flat case or on a book, then calibrate with Set zero. The calibration is kept on this phone until you clear it.' ),
		array( 'The reading wobbles', 'Footsteps, a washing machine or a hand on the table move the phone slightly. Let it settle for a second, or tap Hold reading to freeze it.' ),
		array( 'Edge mode shows the wrong side', 'Make sure the screen faces you while the phone stands on its edge. If auto-rotate turned the page, the level follows the screen.' ),
	),
	'faq'            => array(
		array( 'How accurate is a phone bubble level?', 'After calibration, most phones are accurate to about 0.1 to 0.5 degrees, which is fine for shelves, pictures and appliances. For building work, check against a real spirit level.' ),
		array( 'Does the bubble level work on iPhone?', 'Yes, in Safari and other iPhone browsers. Tap Start and allow motion access. iPhones also have a built-in level in the Measure app.' ),
		array( 'How do I calibrate the level?', 'Put the phone on a surface you know is level and tap Set zero here. Or do the 180 degree check: if two readings 180 degrees apart differ, the phone has an offset that calibration removes.' ),
		array( 'Can I use it to level a picture frame?', 'Yes. Stand the phone on its long edge on top of the frame. The bar level shows how many degrees it tilts and which side is low.' ),
		array( 'Why does the phone buzz?', 'On Android it gives a short buzz when the reading becomes level, so you know without looking. iPhones do not allow websites to vibrate.' ),
		array( 'Does it need the internet?', 'Only to load the page. The level itself runs in your browser and sends nothing anywhere.' ),
	),
	'related'        => array( 'accelerometer-test', 'gyroscope-test', 'compass-test', 'online-ruler', 'phone-sensor-test', 'screen-size' ),
	'updated'        => '2026-10-29',
);
