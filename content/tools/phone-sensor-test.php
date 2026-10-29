<?php
defined( 'ABSPATH' ) || exit;

$row = function ( $id, $name, $link, $what ) {
	return '<li data-ss="' . $id . '"><span class="ss-name"><a href="/' . $link . '/">' . $name . '</a></span><span class="ss-state">-</span><span class="ss-val">' . $what . '</span></li>';
};

return array(
	'title'          => 'Phone Sensor Test',
	'seo_title'      => 'Phone Sensor Test: Check All Your Phone Sensors at Once',
	'description'    => 'Check every phone sensor in one tap: accelerometer, gyroscope, compass, GPS, light, proximity, vibration and more, with live values and a full test for each.',
	'intro'          => 'One tap shows which sensors your phone has and whether the browser can read them: accelerometer, gyroscope, orientation, compass, location, light, magnetometer, proximity, vibration, battery, touch and screen rotation. Each row shows a live value and links to the full test for that sensor.',
	'device'         => 'touch',
	'device_message' => 'Computers have few or none of these sensors. Open this page on your phone or tablet to see them all.',
	'ads'            => 'standard',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'sensors', 'phone-sensor-test' ),
	'embed_height'   => 1050,
	'tool'           => '<div class="tool-stage sn-stage">
	<div class="btn-row"><button type="button" class="btn btn-primary" id="ss-start">Check all sensors</button><button type="button" class="btn" id="ss-gps">Check location</button></div>
	<p class="sn-label" id="ss-summary" hidden></p>
	<ul class="ss-list">'
		. $row( 'acc', 'Accelerometer', 'accelerometer-test', 'Tilt, shake, auto-rotate, step counting' )
		. $row( 'gyro', 'Gyroscope', 'gyroscope-test', 'Rotation speed for games, AR and 360 photos' )
		. $row( 'orient', 'Orientation', 'bubble-level', 'Tilt angles worked out from the motion sensors' )
		. $row( 'compass', 'Compass', 'compass-test', 'Heading from the magnetometer' )
		. $row( 'gps', 'Location (GPS)', 'gps-test', 'Satellite or Wi-Fi position, never sent anywhere' )
		. $row( 'light', 'Light sensor', 'light-sensor-test', 'Auto-brightness; browsers usually hide the reading' )
		. $row( 'prox', 'Proximity sensor', 'proximity-sensor-test', 'Turns the screen off during calls; usually hidden' )
		. $row( 'mag', 'Magnetometer (raw)', 'compass-test', 'Raw magnetic field; usually hidden' )
		. $row( 'vibrate', 'Vibration motor', 'vibration-test', 'Browser vibration support' )
		. $row( 'battery', 'Battery', 'battery-health-test', 'Level and charging state' )
		. $row( 'touch', 'Touch screen', 'touch-screen-test', 'Multi-touch points reported' )
		. $row( 'rotate', 'Screen rotation', 'accelerometer-test', 'Current screen orientation' )
		. '</ul>
</div>
<p class="tool-status" id="ss-status" aria-live="polite">Tap Check all sensors. On iPhone, tap Allow when Safari asks for motion access.</p>',
	'howto'          => array(
		'Open this page on your phone and tap <strong>Check all sensors</strong>. On iPhone, tap <strong>Allow</strong> for motion and orientation access.',
		'Move the phone a little. Within a few seconds each motion row turns green with a live value, or red if the sensor is missing.',
		'Tap <strong>Check location</strong> and allow location to see whether the phone gets a satellite or a Wi-Fi fix.',
		'Tap any sensor name for its full test: calibration checks, graphs and fixes.',
	),
	'howto_title'    => 'How to check your phone sensors',
	'results'        => '<p>Each row has one of three results:</p>
<ul>
<li><strong>Green (Yes, Supported):</strong> the phone has the sensor and the browser can read it. The live value under it should change as you move the phone.</li>
<li><strong>Red (Not found, No):</strong> no data arrived. For the accelerometer, gyroscope and compass on a phone, that usually means the sensor is missing (many budget phones have no gyroscope or compass) or motion access is blocked.</li>
<li><strong>Amber (Not exposed):</strong> the browser hides this sensor from websites. The light sensor, proximity sensor and raw magnetometer are hidden in almost every browser, so amber is normal there; their full tests use other ways to check them.</li>
</ul>
<p>The score at the top counts the green rows. Two phones that work perfectly can score differently because browsers expose different sensors: Chrome on Android usually shows the most, Safari on iPhone shows motion and compass but no battery or vibration.</p>',
	'extra'          => array(
		array(
			'Which sensors does a phone have?',
			'<p>Almost every smartphone has an accelerometer, a proximity sensor, a light sensor and GPS. Most mid-range and flagship phones add a gyroscope and a magnetometer (compass); some budget phones leave them out to save cost, which is why some games, AR apps and Google Maps live view do not work on them. Flagships also add a barometer for altitude, a fingerprint sensor and sometimes a color temperature sensor. Browsers cannot read the barometer or fingerprint sensor, so this page does not list them.</p>',
			'which',
		),
		array(
			'Gyroscope vs accelerometer',
			'<p>The two are easy to mix up. The accelerometer feels gravity and pushes, so it knows which way is down and when you shake the phone; the gyroscope measures how fast the phone turns. Together they give smooth, fast motion tracking. The full explanation is in <a href="/gyroscope-vs-accelerometer/">gyroscope vs accelerometer</a>.</p>',
			'gyro-vs-acc',
		),
	),
	'fixes'          => array(
		array( 'Every motion row says Not found', 'On iPhone, close Safari fully and reopen the page, then tap Allow. On Android, tap the lock icon by the address, open Permissions and allow Motion sensors. Battery saver can also pause sensors.' ),
		array( 'Only the gyroscope is missing', 'The phone probably has no gyroscope. Check the specification of your model; the <a href="/what-phone-do-i-have/">what phone do I have</a> page helps find the exact model.' ),
		array( 'Compass says Not found', 'Some phones have no magnetometer, and some browsers only give relative orientation. Try Chrome on Android or Safari on iPhone, then the <a href="/compass-test/">compass test</a>.' ),
		array( 'Location is approximate only', 'Turn on Location and precise location for the browser, then test outdoors. The <a href="/gps-test/">GPS test</a> tracks the accuracy over time.' ),
	),
	'faq'            => array(
		array( 'How can I check which sensors my phone has?', 'Open this page on the phone and tap Check all sensors. Green rows are sensors the phone has and the browser can read; tap a name for its full test.' ),
		array( 'Does the sensor test work on iPhone?', 'Yes. Tap the button and allow motion access in Safari. iPhones show the accelerometer, gyroscope, orientation, compass, location and touch; Safari does not expose battery or vibration.' ),
		array( 'Why does it say the light and proximity sensors are not exposed?', 'Browsers keep these sensors away from websites for privacy. Your phone still has them; their own tests check them with the camera and a quick call test instead.' ),
		array( 'Can a phone work without a gyroscope?', 'Yes. Auto-rotate, the step counter and tilt work with the accelerometer alone. Fast motion games, AR, VR headsets and 360 degree photos need the gyroscope.' ),
		array( 'Can this page fix a sensor?', 'No page can fix hardware. It shows whether each sensor works, and each full test lists the settings and calibration steps that fix the common software problems.' ),
		array( 'Is any sensor data sent anywhere?', 'No. Every reading, including your location, stays in your browser.' ),
	),
	'related'        => array( 'gyroscope-test', 'accelerometer-test', 'compass-test', 'gps-test', 'device-info', 'what-phone-do-i-have' ),
	'updated'        => '2026-10-29',
);
