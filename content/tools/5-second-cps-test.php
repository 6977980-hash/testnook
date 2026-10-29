<?php
defined( 'ABSPATH' ) || exit;

$bands = require __DIR__ . '/_bands.php';

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '5 Second CPS Test',
	'seo_title'      => '5 Second CPS Test: Standard Click Speed Test (Free)',
	'description'    => 'Free 5 second CPS test, the standard click speed benchmark. Click for five seconds and get your clicks per second, peak second, rank and saved best score.',
	'intro'          => 'Five seconds is the length almost every CPS leaderboard and Minecraft server uses, so this is the number to compare with friends. Click the box, keep going until the ring empties, and get your average clicks per second, your fastest second and a rank.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'stats'          => array( 'cps-5' ),
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 600,
	'tool'           => $tool( 5 ),
	'howto'          => array(
		'Point at the box and rest a fingertip on the left button. A relaxed grip is faster than a tense one.',
		'Click to start. The five second timer begins on that first click, which counts.',
		'Keep a steady rhythm until the timer reaches zero. Watch the live CPS to pace yourself.',
		'Read your average <strong>CPS</strong>, your <strong>peak</strong> second and your rank. The bar graph shows your clicks in each of the five seconds.',
	),
	'howto_title'    => 'How to take the 5 second CPS test',
	'results'        => '<p>Your CPS is your total clicks divided by five. Thirty clicks is 6 CPS, which is a good score for normal clicking.</p>
' . $bands['cps'] . '
<p>The graph is the useful part. Five even bars mean you held your pace; a tall first bar that shrinks means you start too hard. Most people lose one or two clicks between the first and the last second.</p>',
	'extra'          => array(
		array(
			'Reading your five bars',
			'<p>The graph after a 5 second test has one bar per second, and its shape tells you more than the average. Most people produce a high first or second bar and a fifth bar that is half a click to a click lower: that is ordinary fatigue, and it is why your <strong>peak</strong> is usually above your average. A flat row of five bars means you held your speed, and the next gain will come from technique or a lighter switch rather than pacing. A low first bar means a slow start; a single tall bar in the middle with lower bars around it usually means one burst of tension that you could not keep.</p>
<p>Because five seconds is the length most people quote, the <a href="#leaderboard">5 second leaderboard on this page</a> is the main board, and the site averages for this length fill up first. Your result is compared only with other 5 second runs.</p>',
			'five-bars',
		),
		array(
			'Why 5 seconds is the standard',
			'<p>One second is too noisy, because a single click moves the score a whole CPS, and a minute mostly measures stamina. Five seconds is long enough that one lucky click barely matters and short enough that everyone can go flat out. That is why click speed rankings, Minecraft PvP practice and most CPS sites use it, and why a "my CPS" claim without a length usually means five seconds.</p>',
			'standard',
		),
		array(
			'How to raise your 5 second score',
			'<p>Click with the tip of the finger, not the whole finger, and keep the movement small: the button only needs to travel a millimeter or two. Rest the heel of your hand so the arm does not move. Breathe out and stay loose; tension in the shoulder slows the finger. A lighter mouse with a short-travel switch adds one or two CPS on its own. For more, learn <a href="/jitter-click-test/">jitter clicking</a> or tick "Count right clicks too" and alternate both buttons.</p>',
			'improve',
		),
	),
	'fixes'          => array(
		array( 'The timer does not start', 'It starts on your first click inside the box, not on page load. Click the gray area. If nothing happens, check that JavaScript is not blocked by an extension.' ),
		array( 'Clicks are missing', 'Clicks outside the box are ignored. If the counter stalls while you click inside it, the switch may be failing; try the <a href="/mouse-tester/">mouse tester</a> or another mouse.' ),
		array( 'Right click opens a menu', 'The menu is blocked inside the box. Click once in the box first so the page has focus, or untick "Count right clicks too".' ),
	),
	'faq'            => array(
		array( 'What is a good 5 second CPS?', 'Around 6 CPS is good, 7 to 8 is very fast for one finger, and above 10 almost always means jitter, butterfly or drag clicking.' ),
		array( 'What is the average CPS in 5 seconds?', 'Most people land between 5 and 7 CPS, or 25 to 35 clicks in five seconds, with normal clicking.' ),
		array( 'How many clicks is 10 CPS in 5 seconds?', 'Fifty clicks. Multiply the CPS by five, or divide your clicks by five to get the CPS.' ),
		array( 'Is this the same as the main CPS test?', 'It is the same counter fixed at five seconds, and it shares the saved 5 second best with the <a href="/cps-test/">CPS test</a>, where you can also pick other lengths.' ),
		array( 'Can I take it on a phone?', 'Yes, taps count the same way. Phone scores are usually a little lower, so compare them with other phone scores.' ),
		array( 'Is my score sent anywhere?', 'Your best score is saved in this browser. Your clicks stay in this browser; only your final score is shared anonymously for the site averages, unless you turn sharing off under the tool.' ),
	),
	'related'        => array( '1-second-cps-test', '10-second-cps-test', 'cps-test', 'jitter-click-test', 'right-click-cps-test', 'spacebar-clicker' ),
	'updated'        => '2026-10-29',
);
