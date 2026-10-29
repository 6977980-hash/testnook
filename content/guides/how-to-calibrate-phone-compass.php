<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Calibrate Your Phone Compass (Android and iPhone)',
	'seo_title'   => 'How to Calibrate Your Phone Compass on Android and iPhone',
	'description' => 'Calibrate your phone compass in under a minute: the figure 8 motion, the Google Maps and iPhone settings, what throws it off and how to check the result.',
	'blurb'       => 'The figure 8 calibration, the settings that help, what throws a compass off and how to check it worked.',
	'hub'         => 'phone',
	'tool'        => 'compass-test',
	'tools'       => array( 'gps-test', 'phone-sensor-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'When the blue beam in your maps app points the wrong way, or a compass app swings around while you stand still, the phone\'s magnetometer needs calibrating. It takes less than a minute and no app. Here is how to do it on any phone, what makes a compass go wrong in the first place, and how to confirm it is fixed.',
	'summary'     => array(
		'Move away from metal and electronics, then <strong>wave the phone in a figure 8</strong> three or four times, turning your wrist so the phone points in every direction.',
		'On Android, Google Maps shows a <strong>Calibrate</strong> option when you tap the blue location dot. On iPhone, keep <strong>Compass Calibration</strong> on in Location Services &gt; System Services.',
		'Magnetic cases, car mounts, laptops, speakers and steel structures are the usual cause of a wrong heading. Calibrate again after changing case.',
		'Check the result with the <a href="/compass-test/">compass test</a>: the reading should stay steady within a couple of degrees and point the right way against a map.',
	),
	'sections'    => array(
		array(
			'Why a phone compass needs calibrating',
			'<p>The compass in a phone is a magnetometer: a chip that measures the strength of the magnetic field in three directions. Earth\'s field is weak, around 25 to 65 microtesla, so anything magnetic close to the chip can drown it out. That includes parts of the phone itself: the speaker magnets, the camera and the steel frame.</p>
<p>The phone corrects for its own parts by learning their fixed offsets, which is what calibration does. When something changes, such as a new case with a magnet, a repair or a strong magnet nearby, the old correction no longer fits and the heading comes out wrong by tens of degrees. Calibration lets the phone learn the new offsets.</p>',
			'why',
		),
		array(
			'The figure 8 calibration',
			'<ol>
<li>Take off any case with a magnet or metal plate, and step away from cars, laptops, speakers and metal furniture. Outdoors is best.</li>
<li>Open a compass or maps app, or the <a href="/compass-test/">compass test</a>, so the phone is reading the sensor.</li>
<li>Hold the phone in front of you and move it in a large figure 8 (like an infinity sign), about the width of your shoulders.</li>
<li>While you do it, roll your wrist so the phone also tilts and turns: the goal is to point every edge of the phone in every direction.</li>
<li>Do three or four loops, which takes about 10 seconds, then hold the phone flat and still.</li>
</ol>
<p>The phone sees the magnetic field from every angle during those loops and works out which part of the signal is Earth and which is the phone itself. If the heading is still wrong, repeat it once more somewhere with less metal around.</p>',
			'figure-8',
		),
		array(
			'Android: Google Maps calibration',
			'<p>Google Maps shows how sure it is of your direction with the width of the blue beam around your location dot. A wide beam means low accuracy. Tap the blue dot and, on most versions, a <strong>Calibrate</strong> button opens an animation showing the figure 8 motion; Maps tells you when the accuracy is high. Keep Settings &gt; Location &gt; Location services &gt; Google Location Accuracy turned on, which helps Maps combine the compass with Wi-Fi and GPS.</p>
<p>Some Android phones also have a sensor test menu. On Samsung, dialing <code>*#0*#</code> and tapping Sensor shows a magnetic sensor self test and a heading readout that you can calibrate with the same motion.</p>',
			'android',
		),
		array(
			'iPhone: settings that keep the compass calibrated',
			'<p>iPhones calibrate themselves in the background and ask for the figure 8 (or a tilt-the-screen game in older iOS versions) when they need it. Make sure the background calibration is allowed: Settings &gt; Privacy &amp; Security &gt; Location Services &gt; System Services &gt; <strong>Compass Calibration</strong> should be on. Location Services itself must also be on.</p>
<p>The Compass app\'s settings (Settings &gt; Apps &gt; Compass on iOS 18 and later, Settings &gt; Compass before that) have a <strong>Use True North</strong> switch. With it on, the heading matches maps; with it off, you see magnetic north, which can be several degrees different depending on where you are. Testnook\'s compass test shows magnetic north.</p>',
			'iphone',
		),
		array(
			'What throws a compass off',
			'<ul>
<li><strong>Magnetic cases, wallets and car mounts:</strong> the most common cause. Magnetic charging accessories also distort the reading while attached.</li>
<li><strong>Laptops, tablets, speakers and headphones:</strong> they contain strong magnets. Keep the phone a hand\'s width away.</li>
<li><strong>Cars, trains and buildings:</strong> steel bodies and reinforced concrete bend the field. A compass inside a car is rarely accurate; navigation apps use GPS movement there instead.</li>
<li><strong>Power cables and electronics:</strong> currents create their own fields, which shows up as a heading that jumps around near a desk or a charger.</li>
<li><strong>Tilt:</strong> a phone held at an angle gives a different heading in many apps. Hold it flat like a map.</li>
</ul>',
			'interference',
		),
		array(
			'Check that it worked',
			'<p>Open the <a href="/compass-test/">compass test</a>, tap Start and hold the phone flat. Three things should be true: the steadiness box shows a wobble of about 2 degrees or less while you stand still; turning slowly makes the heading rise smoothly through 90, 180 and 270 without jumps; and the direction agrees with something you know, such as a street that runs north to south on a map, or the sun low in the east in the morning. On iPhone the accuracy box should read better than &plusmn;15&deg;.</p>
<p>If calibration never sticks, or the heading is wrong by the same large amount in open ground with no case, the sensor may be damaged, which happens after drops and repairs. If only your position is off, not the direction, the problem is GPS: see <a href="/how-to-improve-gps-accuracy/">how to improve GPS accuracy</a>.</p>',
			'check',
		),
	),
	'faq'         => array(
		array( 'How do I calibrate my phone compass?', 'Move away from metal, then wave the phone in a figure 8 three or four times while turning your wrist so it points in every direction. It takes about 10 seconds on Android and iPhone.' ),
		array( 'How often should I calibrate the compass?', 'Only when it is wrong: after changing case, after a repair, or when the maps beam is wide. Phones keep their calibration and update it in the background.' ),
		array( 'Why is my compass wrong in the car?', 'The steel car body and the electronics around the dashboard bend the magnetic field. Navigation apps use the direction of GPS movement while driving instead of the compass.' ),
		array( 'Is magnetic north the same as true north?', 'No. The difference is the magnetic declination, from 0 to more than 10 degrees depending on where you live. Maps use true north; raw compass readings use magnetic north.' ),
		array( 'Can a magnet ruin my phone compass?', 'A strong magnet can leave an offset that makes the compass wrong until you calibrate again. Permanent damage from household magnets is rare.' ),
		array( 'Does my phone have a compass?', 'Most phones do, but some budget models do not. The compass test or the phone sensor test shows whether a heading is available.' ),
	),
	'sources'     => array(
		array( 'Google Maps Help: Find and improve your location\'s accuracy', 'https://support.google.com/maps/answer/2839911' ),
	),
	'ads'         => 'standard',
);
