<?php
defined( 'ABSPATH' ) || exit;
return array(
	'title'       => 'How to Improve GPS Accuracy on Your Phone',
	'seo_title'   => 'How to Improve GPS Accuracy on Your Android or iPhone',
	'description' => 'Why your phone GPS is inaccurate and how to fix it: precise location, Wi-Fi scanning, a clear sky view, resets, cases and when the GPS antenna is at fault.',
	'blurb'       => 'The settings, habits and checks that bring phone location accuracy down to a few meters.',
	'hub'         => 'phone',
	'tool'        => 'gps-test',
	'tools'       => array( 'compass-test', 'phone-sensor-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'According to GPS.gov, GPS-enabled smartphones are typically accurate to within about 4.9 meters (16 feet) under open sky. If the blue dot sits in the next street, jumps around or takes minutes to appear, it is usually a setting or the environment rather than a broken chip. These fixes start with the quickest and end with how to tell when the hardware is the problem.',
	'summary'     => array(
		'Turn on <strong>precise location</strong> for the app or browser (iPhone: Precise Location; Android: Google Location Accuracy). Without it you only get an approximate area.',
		'GPS needs a <strong>view of the sky</strong>. Indoors, between tall buildings and under thick trees, accuracy drops from meters to tens of meters.',
		'Keep <strong>Wi-Fi and Bluetooth scanning</strong> and mobile data on: they give a fast first fix and help in cities. Airplane mode on and off, or a restart, clears a stuck GPS.',
		'Measure it with the <a href="/gps-test/">GPS test</a>: under 15 m outdoors within a minute is healthy. Much worse in open ground points to the antenna, a metal case or damage.',
	),
	'sections'    => array(
		array(
			'How phone location works',
			'<p>Your phone listens to navigation satellites: GPS (USA), Galileo (Europe), GLONASS (Russia) and BeiDou (China). Each satellite broadcasts its position and the exact time; the phone measures how long each signal took to arrive and works out where it must be. It needs at least four satellites, and more gives a better fix. Recent phones also receive a second frequency (L5/E5a) that is much better at rejecting reflected signals in cities.</p>
<p>Satellites are not the only source. The phone also estimates location from nearby Wi-Fi networks and mobile masts, which is fast and works indoors but is only accurate to tens or hundreds of meters. The location you see is a blend of all of these, which is why accuracy changes as you move.</p>',
			'how',
		),
		array(
			'Turn on the right settings',
			'<p><strong>iPhone:</strong> open Settings &gt; Privacy &amp; Security &gt; Location Services and check it is on. Tap the app (or Safari Websites for the browser), set it to While Using the App, and turn on <strong>Precise Location</strong>. With Precise Location off, iPhones deliberately give an area several kilometers wide.</p>
<p><strong>Android:</strong> open Settings &gt; Location and turn it on. Under Location services, turn on <strong>Google Location Accuracy</strong> (called Improve accuracy on some phones), plus Wi-Fi scanning and Bluetooth scanning. In the app permissions, choose "Precise" rather than "Approximate" for the apps you navigate with, and for Chrome if you use location in the browser.</p>
<p>Battery saver modes can limit GPS to save power, especially with the screen off. Turn them off while navigating, or exclude your maps app from battery optimization.</p>',
			'settings',
		),
		array(
			'Give it a clear view of the sky',
			'<p>Satellite signals are very weak and blocked by roofs, walls, car roofs with metal coatings and even your body. Tall buildings also reflect them, so the phone measures a longer path and places you on the wrong side of the street, a problem called multipath.</p>
<ul>
<li>Step outside or at least next to a window before starting navigation.</li>
<li>Wait 20 to 30 seconds after the dot appears: accuracy usually tightens as more satellites lock on.</li>
<li>In a car, put the phone on the dashboard or windscreen mount, not in a pocket or a door bin.</li>
<li>In a city, expect 10 to 30 m between tall buildings even on a good phone. Moving to a wider street or a square helps.</li>
</ul>',
			'sky',
		),
		array(
			'Reset a stuck or slow GPS',
			'<p>When the first fix takes minutes, the phone is downloading satellite positions the slow way, from the satellites themselves. Mobile data lets it fetch them from the internet in seconds (called assisted GPS), so keep data on, at least briefly. If the location is stuck in a place you left, or wildly wrong, toggle airplane mode on for 10 seconds and off again, or restart the phone. This clears the cached position and makes the chip start fresh.</p>
<p>If the position is right but the direction is wrong (the dot faces the wrong way), that is the compass, not GPS. See <a href="/how-to-calibrate-phone-compass/">how to calibrate your phone compass</a>.</p>',
			'reset',
		),
		array(
			'Measure your accuracy',
			'<p>Open the <a href="/gps-test/">GPS test</a> outdoors and tap Start. Watch three numbers:</p>
<div class="table-scroll"><table>
<thead><tr><th>Check</th><th>Healthy</th><th>Problem sign</th></tr></thead>
<tbody>
<tr><td>Accuracy</td><td>3 to 15 m within a minute outdoors</td><td>Stays above 50 m outdoors</td></tr>
<tr><td>First fix</td><td>A few seconds to 30 seconds</td><td>Several minutes with data on</td></tr>
<tr><td>95% within (standing still)</td><td>Under about 10 m</td><td>Tens of meters in open ground</td></tr>
</tbody></table></div>
<p>The Source box shows whether the fix came from satellites or only from Wi-Fi and mobile networks. A laptop or a tablet without GPS will always show the second; that is normal.</p>',
			'measure',
		),
		array(
			'When it is the hardware',
			'<p>If accuracy stays poor in an open field with every setting right and no case, compare with another phone in the same spot. A large difference points to your phone. Common causes are a metal or carbon fiber case, a magnetic mount plate stuck over the antenna area, a repaired back glass or frame where the antenna contact was not refitted, and water damage. A repair shop can check the GPS antenna connection, which is often a cheap fix compared with the board itself.</p>',
			'hardware',
		),
	),
	'faq'         => array(
		array( 'How accurate is phone GPS?', 'Outdoors with a clear sky, most phones reach 3 to 10 meters. Dual-frequency phones can reach 1 to 3 meters. Indoors and in dense cities, 15 to 50 meters is common.' ),
		array( 'Why is my GPS accurate outside but not inside?', 'Roofs and walls block satellite signals, so indoors the phone falls back to Wi-Fi and mobile networks, which are accurate to tens of meters at best.' ),
		array( 'Does mobile data affect GPS accuracy?', 'Not the accuracy itself, but data lets the phone download satellite information in seconds, so it gets a good fix much faster. Wi-Fi positioning also needs data.' ),
		array( 'Can a phone case affect GPS?', 'Metal, carbon fiber and some magnetic cases can weaken the signal. Normal plastic, silicone and leather cases have no real effect.' ),
		array( 'Why does my location jump around?', 'Reflections from buildings and weak signals make each fix slightly different. Standing in the open for a minute usually settles it. Large jumps in open ground point to a hardware issue.' ),
		array( 'Do GPS booster apps work?', 'Most do nothing more than the settings above or clearing the cached GPS data, which airplane mode or a restart also does. They cannot improve the antenna.' ),
	),
	'sources'     => array(
		array( 'GPS.gov: GPS accuracy', 'https://www.gps.gov/gps-accuracy' ),
		array( 'Apple: Turn Location Services and GPS on or off on iPhone', 'https://support.apple.com/en-us/102647' ),
	),
	'ads'         => 'standard',
);
