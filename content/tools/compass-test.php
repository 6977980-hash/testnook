<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Compass Test',
	'seo_title'      => 'Compass Test: Check Your Phone Compass Online (Free)',
	'description'    => 'Free compass test for Android and iPhone. See your heading in degrees, check accuracy and steadiness, spot magnetic interference and learn how to calibrate.',
	'intro'          => 'Check that your phone\'s compass points the right way, without an app. Tap Start, hold the phone flat and turn around: the dial shows your heading in degrees, how steady the reading is and, on iPhone, the accuracy the phone reports. If maps point you the wrong way, this test tells you whether the compass needs calibrating.',
	'device'         => 'touch',
	'device_message' => 'Laptops and desktop computers have no compass sensor the browser can read. Open this page on your phone or tablet.',
	'ads'            => 'content',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'compass-test' ),
	'embed_height'   => 860,
	'tool'           => '<div class="tool-stage sn-stage">
	<div class="btn-row"><button type="button" class="btn btn-primary" id="cp-start">Start compass</button></div>
	<div class="cp-wrap">
		<div class="cp-dial"><div class="cp-needle" aria-hidden="true"></div><div class="cp-rose" id="cp-rose"></div><div class="cp-arrow" id="cp-arrow" hidden></div></div>
		<div class="cp-read" aria-live="off"><span id="cp-deg">-</span><small id="cp-dir"></small></div>
		<div class="cp-target"><label for="cp-target">Target bearing</label><input type="number" id="cp-target" min="0" max="359" step="1" inputmode="numeric" placeholder="e.g. 90"><span id="cp-turn"></span></div>
	</div>
	<div class="stats">
		<div class="stat"><span class="stat-label">Compass</span><span class="stat-value" id="cp-src">-</span></div>
		<div class="stat"><span class="stat-label">Accuracy</span><span class="stat-value" id="cp-acc">-</span></div>
		<div class="stat"><span class="stat-label">Steadiness (3 s)</span><span class="stat-value" id="cp-steady">-</span></div>
		<div class="stat"><span class="stat-label">Held flat</span><span class="stat-value" id="cp-tilt">-</span></div>
		<div class="stat"><span class="stat-label">Magnetic field</span><span class="stat-value" id="cp-field">-</span></div>
	</div>
	<div class="sn-result is-bad" id="cp-result" hidden><strong>The compass needs calibrating.</strong> Move away from metal and electronics, then wave the phone in a figure 8 a few times, turning your wrist so the phone points in every direction. The accuracy should drop below &plusmn;15&deg;.</div>
</div>
<p class="tool-status" id="cp-status" aria-live="polite">Open this page on your phone and tap Start. On iPhone, tap Allow when Safari asks for motion access.</p>',
	'howto'          => array(
		'Open this page on your phone and tap <strong>Start compass</strong>. On iPhone, tap <strong>Allow</strong> when Safari asks for motion and orientation access.',
		'Hold the phone flat in front of you, screen up and away from metal, magnets, laptops and speakers. The red N on the dial points to magnetic north.',
		'Turn slowly on the spot. The heading should rise smoothly from 0 to 359 degrees without jumps, and the steadiness box should stay within a couple of degrees when you stop.',
		'Check it against a known direction: a street that runs north-south on a map, or the sun low in the east in the morning and the west in the evening.',
		'If the accuracy or steadiness is poor, wave the phone in a figure 8 to calibrate it and check again. Type a bearing in <strong>Target bearing</strong> to turn until the arrow says On target.',
	),
	'howto_title'    => 'How to test your phone\'s compass',
	'results'        => '<p>The heading is the direction the top of the phone points, in degrees clockwise from north: 0 is north, 90 east, 180 south and 270 west. Here is how to read the boxes:</p>
<ul>
<li><strong>Compass: Yes</strong> means the phone has a magnetometer and the browser gives a real north-referenced heading. <strong>No</strong> means there is no compass, or the browser only reports orientation relative to where the page started.</li>
<li><strong>Accuracy</strong> (iPhone only) is the phone\'s own estimate. Under &plusmn;15&deg; is good; "Not calibrated" or more than &plusmn;30&deg; means it needs a figure 8 calibration. Android browsers do not report accuracy, so use steadiness and a known direction instead.</li>
<li><strong>Steadiness</strong> is how much the reading wobbles over 3 seconds while you hold still. Within &plusmn;2&deg; is steady; more points to interference from something magnetic nearby, or a phone being moved.</li>
<li><strong>Held flat</strong> warns when the phone is tilted more than 25&deg;. The heading here assumes a flat phone, like holding a paper map.</li>
<li><strong>Magnetic field</strong> appears only in browsers that expose the raw magnetometer. Earth\'s field is 25 to 65 &micro;T; much higher means a magnet or metal is close.</li>
</ul>',
	'extra'          => array(
		array(
			'Magnetic north and true north',
			'<p>Phone compasses sense Earth\'s magnetic field, so this page shows <strong>magnetic</strong> north. True north, the direction of the North Pole on a map, differs by the magnetic declination, which is close to 0&deg; in some places and more than 10&deg; in others. Map apps correct for it using your location; this test does not, so a few degrees of difference from a map is expected. For your declination, search for a magnetic declination calculator from NOAA or the British Geological Survey.</p>',
			'north',
		),
		array(
			'Why phone compasses go wrong',
			'<p>The magnetometer is a tiny chip that measures magnetic fields in three directions. Anything magnetic near it bends the reading: magnetic phone cases and car mounts, a laptop, speakers, steel desks, rebar in concrete floors and car bodies. The phone learns the offsets of its own metal parts during calibration, which is why a figure 8 fixes most bad readings. After a new magnetic case or a repair, the old calibration no longer fits, so calibrate again. More in <a href="/how-to-calibrate-phone-compass/">how to calibrate your phone compass</a>.</p>',
			'why',
		),
	),
	'fixes'          => array(
		array( 'The compass points the wrong way', 'Take off magnetic cases and step away from metal and electronics. Wave the phone in a figure 8 for 10 seconds, rotating it in every direction. On Android, Google Maps also offers compass calibration from the blue dot. On iPhone, check Settings > Privacy & Security > Location Services > System Services > Compass Calibration is on.' ),
		array( 'The page says "Compass: No"', 'The phone may have no magnetometer: many budget Android phones and most tablets without GPS leave it out. It may also be the browser: use Chrome or Samsung Internet on Android and Safari on iPhone, and allow motion sensors in the site settings.' ),
		array( 'The heading jumps around', 'Something magnetic is close, or the phone is tilted. Hold it flat, away from your car dashboard, laptop or speaker, and test again outdoors. If it still jumps in open space after calibration, the sensor may be faulty.' ),
		array( 'Maps shows a wide blue beam', 'A wide beam means the phone is unsure of its heading. Calibrate with a figure 8 and the beam narrows. If location itself is off, try the <a href="/gps-test/">GPS test</a> next.' ),
	),
	'faq'            => array(
		array( 'How do I test my phone compass?', 'Open this page on the phone, tap Start and hold it flat. Turn around slowly and check that N points north against a map or the sun. Steady readings and good accuracy mean the compass works.' ),
		array( 'How do I calibrate my phone compass?', 'Move away from metal, then wave the phone in a figure 8 a few times while turning your wrist, so it points in every direction. Most phones calibrate themselves this way within a few seconds.' ),
		array( 'Does the compass test work on iPhone?', 'Yes. Tap Start and allow motion access in Safari. iPhones also report the compass accuracy, which the page shows.' ),
		array( 'Why is my compass a few degrees off from the map?', 'Phones measure magnetic north, and maps use true north. The difference is the magnetic declination where you are. Local metal can add a few degrees more.' ),
		array( 'Can a magnet damage my phone compass?', 'A magnet nearby makes the compass wrong while it is close and can leave an offset until you calibrate again. It does not normally damage the sensor permanently.' ),
		array( 'Is my location used?', 'No. The compass uses only the motion and magnetic sensors in your phone. Nothing is sent anywhere.' ),
	),
	'related'        => array( 'gps-test', 'gyroscope-test', 'accelerometer-test', 'bubble-level', 'phone-sensor-test', 'what-phone-do-i-have' ),
	'updated'        => '2026-10-29',
);
