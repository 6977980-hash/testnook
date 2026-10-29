<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'Gyroscope vs Accelerometer: What Each Sensor Does',
	'seo_title'   => 'Gyroscope vs Accelerometer: The Difference Explained',
	'description' => 'Gyroscope vs accelerometer in plain words: what each phone sensor measures, why phones need both, which apps need a gyroscope and how to check what you have.',
	'blurb'       => 'What each motion sensor measures, why phones combine them and how to tell if yours has a gyroscope.',
	'hub'         => 'phone',
	'tool'        => 'gyroscope-test',
	'tools'       => array( 'accelerometer-test', 'phone-sensor-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'Your phone knows when you turn it sideways, count your steps and steer a racing game by tilting. Two small motion sensors do most of that work: the accelerometer and the gyroscope. They sound alike and often sit on the same chip, but they measure different things. Here is the difference, why phones need both, and how to check which ones your phone has.',
	'summary'     => array(
		'The <strong>accelerometer</strong> measures acceleration, including gravity. It knows which way is down and when the phone is shaken or moved.',
		'The <strong>gyroscope</strong> measures how fast the phone rotates, in degrees per second, around three axes. It cannot tell which way is down on its own.',
		'Phones <strong>combine both</strong> (plus the compass) to get smooth, fast and stable orientation. Auto-rotate and step counting need only the accelerometer; AR, VR, 360 photos and fast motion games need the gyroscope.',
		'Every iPhone since the iPhone 4 has both. Some <strong>budget Android phones have no gyroscope</strong>; the <a href="/phone-sensor-test/">phone sensor test</a> shows which you have.',
	),
	'sections'    => array(
		array(
			'What the accelerometer measures',
			'<p>An accelerometer measures acceleration along three axes: left to right across the screen (X), bottom to top (Y) and out of the screen (Z). Inside the chip is a tiny mass on springs, etched into silicon. When the phone speeds up, slows down or is pushed, the mass lags behind and the chip measures how far it moved.</p>
<p>Gravity pulls on that mass too, all the time. So a phone lying still on a table reads about 9.81 m/s&sup2; on the Z axis, which is 1 g. That constant pull is what makes the accelerometer useful: it always knows which way is down. Tilt the phone and gravity shifts from one axis to another, which is how the phone knows it is in landscape.</p>
<p>The weakness is that it cannot tell gravity from movement. When you turn quickly or ride in a car going round a corner, the extra acceleration mixes with gravity and the tilt reading wobbles. You can see this in the <a href="/accelerometer-test/">accelerometer test</a>: shake the phone and the lines jump far beyond 9.81.</p>',
			'accelerometer',
		),
		array(
			'What the gyroscope measures',
			'<p>A gyroscope measures rotation speed: how many degrees per second the phone is turning around each of the same three axes. Phone gyroscopes are MEMS chips with a vibrating structure. When the phone rotates, the Coriolis effect pushes the vibrating part sideways and the chip measures that push.</p>
<p>A gyroscope reacts instantly and smoothly to turning, and it ignores gravity and straight-line movement. That makes it ideal for fast, precise rotation. Its weakness is drift: it measures change, not position, so to know the phone\'s angle the software adds up the rotation over time, and tiny errors build up. Left alone, a gyroscope-only view slowly turns by itself.</p>
<p>The <a href="/gyroscope-test/">gyroscope test</a> shows the raw rotation rate and has a drift check: a healthy sensor reads within about half a degree per second of zero while the phone lies still.</p>',
			'gyroscope',
		),
		array(
			'Side by side',
			'<div class="table-scroll"><table>
<thead><tr><th></th><th>Accelerometer</th><th>Gyroscope</th></tr></thead>
<tbody>
<tr><td>Measures</td><td>Acceleration and gravity (m/s&sup2;)</td><td>Rotation speed (degrees per second)</td></tr>
<tr><td>At rest it reads</td><td>About 9.81 in total (1 g)</td><td>About 0 on every axis</td></tr>
<tr><td>Knows which way is down</td><td>Yes</td><td>No</td></tr>
<tr><td>Good at</td><td>Tilt, shakes, steps, impacts</td><td>Fast, smooth turning</td></tr>
<tr><td>Weak at</td><td>Noisy during movement</td><td>Drifts over time</td></tr>
<tr><td>In every phone?</td><td>Yes</td><td>Most, not all budget models</td></tr>
</tbody></table></div>
<p>Most phones also have a magnetometer (compass) that knows where north is. On its own it is slow and easily upset by metal, which is why the <a href="/compass-test/">compass test</a> checks steadiness as well as direction.</p>',
			'compare',
		),
		array(
			'Why phones use both together',
			'<p>Each sensor covers the other\'s weakness. The gyroscope gives fast, smooth rotation; the accelerometer corrects its drift by pointing to the real "down" every moment; the compass corrects the drift around the vertical axis by pointing to north. Software called sensor fusion blends the three into one orientation, many times a second.</p>
<p>This is what websites receive as the alpha, beta and gamma angles. On a phone without a gyroscope, the same angles are worked out from the accelerometer and compass alone, so they still exist but react more slowly and wobble when you move. That is why a phone without a gyroscope may pass a tilt check but feel laggy in a game.</p>',
			'fusion',
		),
		array(
			'Which apps need a gyroscope',
			'<ul>
<li><strong>Need only the accelerometer:</strong> auto-rotate, step counting, shake to undo, lift to wake, fall and crash detection, a <a href="/bubble-level/">bubble level</a>, simple tilt games.</li>
<li><strong>Need the gyroscope:</strong> augmented reality (AR measuring apps, AR games, Google Maps Live View), VR headsets that use the phone, 360 degree and panorama photos, gyro aiming in shooters, camera stabilisation in some apps.</li>
</ul>
<p>If an AR app says "your device is not supported" or a panorama stitches badly, check for a gyroscope first.</p>',
			'apps',
		),
		array(
			'How to check which sensors your phone has',
			'<p>Open the <a href="/phone-sensor-test/">phone sensor test</a> on the phone and tap Check all sensors. If the accelerometer shows Yes and the gyroscope shows Not found, your phone has no gyroscope. For a closer look, the <a href="/gyroscope-test/">gyroscope test</a> separates "no gyroscope" from "permission blocked", and the <a href="/accelerometer-test/">accelerometer test</a> checks that gravity reads 9.81. On iPhone, tap Allow when Safari asks for motion access, or the sensors stay hidden.</p>',
			'check',
		),
	),
	'faq'         => array(
		array( 'Is a gyroscope the same as an accelerometer?', 'No. The accelerometer measures acceleration and gravity, so it knows which way is down. The gyroscope measures rotation speed. They are often on the same chip but do different jobs.' ),
		array( 'Can a phone work without a gyroscope?', 'Yes. Calls, apps, auto-rotate and step counting all work. AR, VR, 360 photos and gyro aiming in games do not work well or at all.' ),
		array( 'Does auto-rotate use the gyroscope?', 'No, auto-rotate uses the accelerometer to see which way gravity points. If auto-rotate fails, test the accelerometer and the rotation settings.' ),
		array( 'Which is more accurate?', 'Neither on its own. The gyroscope is precise over short times but drifts; the accelerometer is steady over time but noisy during movement. Combined, they are accurate both ways.' ),
		array( 'Can I add a gyroscope with an app?', 'No. Apps that claim a "virtual gyroscope" estimate rotation from the accelerometer and compass. It helps slow apps, but it is not a real sensor and lags in fast games.' ),
		array( 'Do iPhones have a gyroscope?', 'Yes, every iPhone since the iPhone 4 in 2010 has a three-axis gyroscope and an accelerometer.' ),
	),
	'ads'         => 'standard',
);
