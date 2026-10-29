<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'GPS Test',
	'seo_title'      => 'GPS Test: Check Your GPS Accuracy and Signal Online',
	'description'    => 'Free online GPS test for phones and laptops. See your location accuracy in metres, time to first fix, altitude and speed, and how much the position wanders.',
	'intro'          => 'Test your phone\'s GPS in the browser. Tap Start and the page shows how long the first fix takes, how accurate it is in metres, whether it comes from satellites or Wi-Fi, your altitude and speed, and a plot of how much the position wanders while you stand still. Your location stays on your device.',
	'device'         => 'any',
	'ads'            => 'standard',
	'styles'         => array( 'sensors' ),
	'scripts'        => array( 'gps-test' ),
	'embed_height'   => 980,
	'tool'           => '<div class="tool-stage sn-stage">
	<div class="btn-row"><button type="button" class="btn btn-primary" id="gp-start">Start GPS test</button><label class="btn btn-sm"><input type="checkbox" id="gp-hide"> Hide coordinates</label></div>
	<p class="sn-label">Your position</p>
	<p class="gp-coords" id="gp-coords">-</p>
	<div class="btn-row"><button type="button" class="btn btn-sm" id="gp-copy" hidden>Copy</button><a class="btn btn-sm" id="gp-map" href="#" target="_blank" rel="noopener nofollow" hidden>Open in Google Maps</a></div>
	<div class="gp-grid">
		<div class="stats">
			<div class="stat"><span class="stat-label">Accuracy</span><span class="stat-value" id="gp-acc">-</span></div>
			<div class="stat"><span class="stat-label">Rating</span><span class="stat-value" id="gp-rating">-</span></div>
			<div class="stat"><span class="stat-label">Best so far</span><span class="stat-value" id="gp-best">-</span></div>
			<div class="stat"><span class="stat-label">First fix</span><span class="stat-value" id="gp-ttff">-</span></div>
			<div class="stat"><span class="stat-label">Source</span><span class="stat-value" id="gp-src">-</span></div>
			<div class="stat"><span class="stat-label">Altitude</span><span class="stat-value" id="gp-alt">-</span></div>
			<div class="stat"><span class="stat-label">Speed</span><span class="stat-value" id="gp-speed">-</span></div>
			<div class="stat"><span class="stat-label">Heading</span><span class="stat-value" id="gp-head">-</span></div>
			<div class="stat"><span class="stat-label">Fixes</span><span class="stat-value" id="gp-n">-</span></div>
			<div class="stat"><span class="stat-label">Update every</span><span class="stat-value" id="gp-every">-</span></div>
			<div class="stat"><span class="stat-label">Half within</span><span class="stat-value" id="gp-r50">-</span></div>
			<div class="stat"><span class="stat-label">95% within</span><span class="stat-value" id="gp-r95">-</span></div>
		</div>
		<div><p class="sn-label">Position wander (metres from the average)</p><canvas class="gp-plot" id="gp-plot" aria-label="Scatter plot of location fixes"></canvas></div>
	</div>
</div>
<p class="tool-status" id="gp-status" aria-live="polite">Tap Start and allow location access. For a real satellite test, go outside with a clear view of the sky.</p>',
	'howto'          => array(
		'Turn on Location (GPS) in the phone settings. On Android, also turn on Google Location Accuracy for faster fixes.',
		'Tap <strong>Start GPS test</strong> and allow location access when the browser asks.',
		'Go outside with a clear view of the sky and wait. The first fix may come from Wi-Fi with a large radius; within a minute satellite fixes should bring the accuracy under 15 m.',
		'Stand still for a minute and watch the plot. The red dots show each fix; the circle around the blue dot is the accuracy the phone claims.',
		'Walk or drive (as a passenger) to check that speed and heading update. Tick <strong>Hide coordinates</strong> before taking a screenshot to share.',
	),
	'howto_title'    => 'How to test your GPS',
	'results'        => '<p>Accuracy is the radius in metres around the reported point within which the phone is confident you are. Lower is better.</p>
<div class="table-scroll"><table>
<thead><tr><th>Accuracy</th><th>Rating</th><th>What it usually means</th></tr></thead>
<tbody>
<tr><td>Under 5 m</td><td>Excellent</td><td>Satellite fix outdoors with a clear sky, often dual-frequency GPS.</td></tr>
<tr><td>5 to 15 m</td><td>Good</td><td>A normal satellite fix. Fine for walking and driving directions.</td></tr>
<tr><td>15 to 50 m</td><td>Fair</td><td>Satellites with a poor view (near buildings, trees, indoors by a window) or a Wi-Fi fix.</td></tr>
<tr><td>Over 50 m</td><td>Poor</td><td>Wi-Fi or mobile network position only. Laptops and tablets without GPS stay here.</td></tr>
</tbody></table></div>
<p><strong>Source</strong> is a best guess: satellite fixes nearly always include an altitude and a tight radius, while Wi-Fi and cell fixes do not. <strong>Half within</strong> and <strong>95% within</strong> measure how far your fixes wander from their average while you stand still: a few metres is healthy; tens of metres outdoors means weak signal or a GPS problem. A first fix within 5 to 30 seconds outdoors is normal; minutes means the phone had to download satellite data from scratch.</p>',
	'extra'          => array(
		array(
			'Why accuracy is worse indoors and in cities',
			'<p>GPS satellites are about 20,000 km away and their signal is very weak by the time it reaches you. Roofs and walls block it, and tall buildings reflect it, so the phone measures a longer path and puts you on the wrong side of the street. Phones combine GPS with Galileo, GLONASS and BeiDou satellites and with Wi-Fi networks to help, which is why the accuracy improves as you move into the open. Tips in <a href="/how-to-improve-gps-accuracy/">how to improve GPS accuracy</a>.</p>',
			'indoors',
		),
		array(
			'Laptops, desktops and privacy',
			'<p>Most laptops and desktops have no GPS chip. Their browser asks a location service to estimate the position from nearby Wi-Fi networks or the IP address, so accuracy of 50 m to several kilometres is normal there. This page reads the position only in your browser and never sends it to Testnook. The Google Maps button opens the coordinates in a new tab only if you tap it.</p>',
			'privacy',
		),
	),
	'fixes'          => array(
		array( 'Location permission was refused', 'Tap the lock icon by the address, open Permissions and allow Location. On iPhone, also check Settings > Privacy & Security > Location Services is on and Safari Websites is set to "While Using the App" with Precise Location on.' ),
		array( 'Accuracy never gets better than 50 m', 'You may be indoors, or precise location is off. On iPhone turn on Precise Location for Safari; on Android open Settings > Location and turn on Google Location Accuracy (or Improve accuracy). Then test outside.' ),
		array( 'The first fix takes minutes', 'The phone has to download satellite positions. Keep mobile data on (it speeds this up), stay outside and keep the screen on. Restarting the phone or turning airplane mode on and off clears a stuck GPS.' ),
		array( 'The position jumps around', 'Reflections from buildings cause jumps. Watch the plot in an open field: if the 95% radius is still tens of metres, the GPS antenna or a metal case may be the issue. A <a href="/compass-test/">compass test</a> helps if only the direction is wrong.' ),
	),
	'faq'            => array(
		array( 'How do I check my GPS accuracy?', 'Open this page, tap Start and allow location. The Accuracy box shows the radius in metres. Outdoors, a working phone GPS reaches 3 to 15 metres within a minute.' ),
		array( 'Does the GPS test work on iPhone?', 'Yes, in Safari and other iPhone browsers. Allow location when asked and make sure Precise Location is on for Safari Websites, otherwise iPhones only give an approximate area.' ),
		array( 'Why is my laptop location so inaccurate?', 'Laptops usually have no GPS. Their position comes from nearby Wi-Fi networks or the IP address, which is accurate to tens of metres at best and sometimes only to the city.' ),
		array( 'What is time to first fix?', 'How long the phone took from the start of the test to its first position. It includes the time it took you to tap Allow. A few seconds is normal when GPS was used recently.' ),
		array( 'Does this test use mobile data?', 'The test itself uses none. The phone may use a little data to download satellite information, which makes the first fix faster.' ),
		array( 'Is my location saved or shared?', 'No. Your position is shown only in your browser and is never sent to Testnook. Nothing is stored after you close the page.' ),
	),
	'related'        => array( 'compass-test', 'phone-sensor-test', 'device-info', 'what-phone-do-i-have', 'battery-health-test', 'accelerometer-test' ),
	'updated'        => '2026-10-29',
);
