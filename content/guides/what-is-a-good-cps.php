<?php
defined( 'ABSPATH' ) || exit;
$bands = require dirname( __DIR__ ) . '/tools/_bands.php';
return array(
	'title'       => 'What Is a Good CPS? Click Speed Explained',
	'seo_title'   => 'What Is a Good CPS? Average Click Speed and Records',
	'description' => 'What counts as a good CPS score: the average clicks per second for normal, jitter and butterfly clicking, how test length changes it, and how to click faster.',
	'blurb'       => 'Average clicks per second, what each click method reaches, and how to get faster.',
	'hub'         => 'benchmark',
	'tool'        => 'cps-test',
	'tools'       => array( '5-second-cps-test', '10-second-cps-test', 'jitter-click-test', 'auto-clicker-test', 'double-click-test' ),
	'published'   => '2026-10-29',
	'updated'     => '2026-10-29',
	'intro'       => 'A good CPS (clicks per second) depends on how you click and for how long. Here is what normal, fast and record scores look like, why your number drops on longer tests, and what actually makes you faster.',
	'summary'     => array(
		'Most people click <strong>6 to 7 times per second</strong> on a 5 second test with one finger. That is a normal, healthy score.',
		'<strong>8 to 10 CPS</strong> is fast and usually needs jitter clicking. <strong>Over 10 CPS</strong> on a 5 second test almost always means butterfly or drag clicking.',
		'Scores fall on longer tests: a 60 second run is often 1 to 3 CPS lower than your 5 second best, because the forearm tires.',
		'A lighter mouse switch, a relaxed grip and short daily practice raise CPS more than any "trick".',
	),
	'sections'    => array(
		array(
			'CPS in one sentence',
			'<p>CPS is the number of clicks you make divided by the length of the test in seconds. Click 34 times in a 5 second test and your score is 6.8 CPS. The number says nothing about accuracy; it only measures how fast your finger, your mouse switch and your browser can register clicks in a row.</p>
<p>That is why the same person can score very differently on different setups. A cheap office mouse with a stiff switch, a laptop touchpad and a gaming mouse with light switches will each give a different number, even on the same day.</p>',
			'cps-basics',
		),
		array(
			'Typical CPS scores by click method',
			'<p>The biggest single factor is technique. These ranges are for a 5 second test, the most common benchmark:</p>
' . $bands['cps_methods'] . '
<p>So "good" has two answers. For normal clicking, anything from <strong>6 CPS</strong> up is good and <strong>8 CPS</strong> is excellent. With jitter or butterfly technique, competitive players aim for 10 to 14 CPS. Scores above 15 on a 5 second test are rare and tied to specific mice and drag clicking.</p>
<p>The <a href="/cps-test/">CPS test</a> on this site gives every 5 second result a rank on the same scale:</p>' . $bands['cps'],
			'by-method',
		),
		array(
			'How test length changes your score',
			'<p>The shorter the test, the higher the number. In a <a href="/1-second-cps-test/">1 second test</a> you can sprint without tiring, so most people score one or two CPS above their 5 second result. Over a <a href="/10-second-cps-test/">10 second test</a> most people fade by about one click per second, and on a <a href="/60-second-click-test/">60 second test</a> the drop is often 2 or 3 CPS, because the forearm muscles tire, the grip tightens and the tapping rhythm breaks down.</p>
<p>That is why scores are only comparable at the same length. A friend who brags about 11 CPS on a 1 second test has not necessarily beaten your 8 CPS on 10 seconds. Our leaderboards keep one board per length for exactly this reason.</p>
<p>The per-second graph after each test shows where you slowed down. A flat line means steady clicking; a line that falls after second three or four is normal fatigue; sudden gaps usually mean the finger lost its rhythm or the mouse missed a click.</p>',
			'test-length',
		),
		array(
			'What a CPS score means in games',
			'<p>In Minecraft PvP, the place most people meet CPS tests, attack speed and knockback rules decide how much clicking helps. In versions before the 1.9 combat update every click could attack, so high CPS mattered a lot and 10 to 14 CPS was competitive. From 1.9 on, an attack cooldown means timing beats raw speed, and around 6 to 8 well-timed clicks per second is plenty.</p>
<p>Many servers cap accepted clicks between 15 and 20 CPS and flag anything steadier or faster as an auto clicker. Butterfly and drag clicking are banned on some servers for the same reason, so check the rules before you practice a technique.</p>
<p>Outside games, a high CPS has no real use, but the test is a quick health check for a mouse: if your count stops rising while your finger keeps moving, the switch is missing clicks.</p>',
			'in-games',
		),
		array(
			'How to click faster',
			'<p>Real gains come from relaxed technique and a mouse that does not fight you:</p>
<ol>
<li><strong>Use your fingertip, not the pad of the finger.</strong> A short, light tap near the front of the button needs less travel than pressing with a flat finger.</li>
<li><strong>Rest the wrist and let the finger do the work.</strong> Gripping the mouse hard slows the finger down. Keep the palm or wrist on the desk and move only the clicking finger.</li>
<li><strong>Practice short bursts.</strong> Five rounds of 5 seconds with a pause between them train speed better than one long minute, which mostly trains fatigue.</li>
<li><strong>Try jitter clicking carefully.</strong> Tense the forearm until the hand vibrates, and keep the wrist off the desk. Stop if it hurts; it is a strain on tendons, and the tool page on <a href="/jitter-click-test/">jitter clicking</a> explains the safe way.</li>
<li><strong>Check the mouse.</strong> A light, clicky switch with a short pre-travel helps. If your score jumps or skips oddly, run the <a href="/double-click-test/">double click test</a>: a worn switch can double click (inflating CPS) or miss clicks (lowering it).</li>
</ol>
<p>Expect about half a click per second of improvement in the first week of short daily practice, then smaller gains. Most people settle within one CPS of their natural ceiling for a technique.</p>',
			'click-faster',
		),
		array(
			'When a CPS score is not real',
			'<p>Mouse software macros, auto clickers and switches that bounce can all produce numbers no finger can reach. Signs of a fake or faulty score: perfectly even gaps between clicks, more than 20 CPS on a long test, or a score that changes wildly when you swap mice.</p>
<p>Testnook leaves results like that out of the site averages and leaderboards: a click test only counts if it ran for its full length, stays within human range and the click gaps are not machine-regular. If you want to see what a real auto clicker looks like, the <a href="/auto-clicker-test/">auto clicker test</a> measures one on purpose.</p>',
			'fake-scores',
		),
	),
	'data'        => array(
		'boards' => array( 'cps-5', 'cps-10' ),
		'title'  => 'What people actually score on Testnook',
		'after'  => 'test-length',
		'html'   => '<p>Real numbers from this site: over the last 30 days the median 5 second score was <strong>{median:cps-5}</strong> and the median 10 second score <strong>{median:cps-10}</strong>. To be in the top 10% you needed <strong>{top10:cps-5}</strong> on 5 seconds. A score of 8 CPS on the 5 second test beats {beats:cps-5:8} of results. The best named scores are on the <a href="/leaderboards/">leaderboards</a>.</p>',
	),
	'faq'         => array(
		array( 'What is the average CPS?', 'For normal one-finger clicking the average is about 6 to 7 clicks per second on a 5 second test. Over 10 seconds most people average 5 to 6.' ),
		array( 'Is 10 CPS good?', 'Yes. 10 CPS on a 5 or 10 second test is very fast for normal clicking and a solid score for jitter clicking. Most people cannot reach it without a special technique.' ),
		array( 'What is the world record for CPS?', 'There is no official body that tracks CPS records, so "records" online are self-reported and mostly come from drag clicking on specific mice, where 30 to 50 CPS on short tests is claimed. For normal clicking, sustained scores above 14 CPS are exceptional.' ),
		array( 'Is butterfly clicking allowed?', 'It depends on the server or competition. Some Minecraft servers allow it, others ban butterfly and drag clicking because they look like auto clicking to anti-cheat systems. Always check the rules.' ),
		array( 'Does a gaming mouse increase CPS?', 'A little. Light, crisp switches and a good shape help, often by 0.5 to 1 CPS. A mouse that double clicks by fault can inflate the score, but that is a defect, not a feature.' ),
		array( 'Why is my CPS lower on a laptop touchpad?', 'Touchpad taps have more delay and many touchpads ignore taps that come too fast. Use a physical mouse button for a fair score.' ),
	),
);
