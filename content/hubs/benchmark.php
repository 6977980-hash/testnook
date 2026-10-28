<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Reaction & Speed Benchmarks',
	'seo_title'   => 'Benchmarks: Reaction Time, CPS, Stroop & F1 Start Tests (Free)',
	'description' => 'Free online reaction and speed benchmarks: reaction time, F1 start lights, Stroop test, CPS, right click and jitter click tests, spacebar speed and FPS.',
	'intro'       => 'Put a number on your reflexes and your hardware: reaction time and F1 start light tests, a Stroop test for attention, CPS tests for normal, right and jitter clicking, a spacebar clicker, a UFO motion test and an FPS test. Every result comes with what is typical so you know where you stand.',
	'body'        => '<h2>Which benchmark do you need?</h2>
<p>The <a href="/reaction-time-test/">reaction time test</a> measures how quickly you click after the screen turns green and averages several rounds. Most people land between 200 and 300 ms; gamers often reach the 150s. It is the simplest check of your own reflexes and of input lag on a new mouse, keyboard or monitor, since a change in setup shows up as a change in your average.</p>
<p>Two variations test the same reflex in different ways. The <a href="/f1-reaction-test/">F1 reaction test</a> replays a Formula 1 start: five red lights come on one per second and go out after a random hold, and you react to the lights going out. The <a href="/stroop-test/">Stroop test</a> adds a mental step: colour words printed in the wrong colour, where you must answer the ink colour and the delay the words cause is your Stroop effect.</p>
<p>The <a href="/cps-test/">CPS test</a> counts clicks per second over 1 to 100 seconds and is the standard way to compare clicking techniques. The <a href="/jitter-click-test/">jitter click test</a> is a 10 second version with a consistency score for jitter clicking, and the <a href="/right-click-cps-test/">right click CPS test</a> counts the right button only. The <a href="/spacebar-clicker/">spacebar clicker</a> does the same for the spacebar, and the <a href="/tap-bpm/">tap BPM counter</a> turns steady tapping into a tempo. The <a href="/fps-test/">FPS test</a> and the <a href="/ufo-test/">UFO test</a> move the question from you to the machine: frame rate, motion blur and skipped frames, all capped by the monitor\'s refresh rate.</p>

<h2>What counts as a good score</h2>
<ul>
<li><strong>Reaction time:</strong> under 200 ms is fast, 200 to 250 ms is average for adults, over 300 ms is slow or a sign of a laggy display or input.</li>
<li><strong>CPS:</strong> 5 to 7 with normal clicking, 8 to 12 with jitter clicking, 15 or more with butterfly or drag clicking on a suitable mouse. Right click scores run about one CPS lower.</li>
<li><strong>Stroop effect:</strong> 50 to 150 ms is typical on a button test; accuracy under 80% makes the timing meaningless.</li>
<li><strong>Spacebar:</strong> similar to CPS; most people manage 6 to 10 presses per second.</li>
<li><strong>FPS:</strong> the test should hold the refresh rate of your monitor (60, 120, 144, 240 Hz). A lower, unstable number means the browser or the computer is struggling.</li>
</ul>

<h2>How to get a fair result</h2>
<p>Use a wired mouse and keyboard if you have them, close other tabs and programs, and run several rounds; the first attempt is almost always the slowest. For reaction time, sit the same way each time and compare only with results from the same device, because the monitor and mouse add their own delay. Turn off pointer acceleration and any mouse macro before a CPS test if you want a number that matches what others report.</p>

<h2>Checking the hardware behind the score</h2>
<p>If your reaction time is much slower on one computer than another, run the <a href="/refresh-rate-test/">refresh rate test</a> and the <a href="/mouse-polling-rate-test/">polling rate test</a>. A 60 Hz display or a 125 Hz mouse adds tens of milliseconds compared with a 144 Hz screen and a 1000 Hz mouse.</p>',
	'faq'         => array(
		array( 'What is the average human reaction time?', 'About 250 ms for a visual stimulus with a mouse click, including the delay of the screen and mouse. Trained gamers and athletes reach 150 to 180 ms. Reaction time slows gradually from the mid-20s onward.' ),
		array( 'Does my monitor affect my reaction time score?', 'Yes. A 60 Hz monitor can add up to 16 ms before the green appears, and a slow mouse adds a few more. Compare scores on the same setup, or test your refresh rate and polling rate if a score looks slow.' ),
		array( 'Is a high CPS score possible without an auto clicker?', 'Yes, up to a point. Jitter clicking gives 8 to 12 CPS and butterfly or drag clicking can reach 15 to 25 on a mouse that registers both. Anything far above 30 for a full 10 seconds is almost always software.' ),
		array( 'Why does the FPS test stop at 60?', 'The browser draws at most once per screen refresh, so a 60 Hz display caps the test at 60 fps. If your monitor is 144 Hz but the test shows 60, the display setting is wrong; the refresh rate test explains how to fix it.' ),
		array( 'Can I use these tests on a phone?', 'The reaction time test and CPS test work with taps. The spacebar clicker needs a keyboard. FPS works on phones and reports the screen\'s refresh rate, often 60, 90 or 120.' ),
		array( 'Are my scores saved?', 'Scores stay on the page only. Nothing is sent to a server and there is no leaderboard, so take a screenshot if you want to keep a result.' ),
	),
	'updated'     => '2026-10-28',
	'ads'         => 'standard',
);
