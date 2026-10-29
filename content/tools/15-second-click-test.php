<?php
defined( 'ABSPATH' ) || exit;

$tool = require __DIR__ . '/_click-test.php';

return array(
	'title'          => '15 Second Click Test',
	'seo_title'      => '15 Second Click Test: Count Your Clicks in 15 Seconds',
	'description'    => 'Free 15 second click test. Click as fast as you can for fifteen seconds and get your total clicks, clicks per second, peak second and a consistency score.',
	'intro'          => 'Fifteen seconds sits between a sprint and an endurance run: long enough that you have to pace yourself, short enough to stay near full speed. Click the box to start and see your total clicks, your CPS and how steady you were.',
	'device'         => 'desktop',
	'device_message' => 'This test is made for a mouse or touchpad. Taps on a touch screen are counted too, but compare only with other touch scores. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'content',
	'styles'         => array( 'cps-test' ),
	'scripts'        => array( 'cps-test' ),
	'embed_height'   => 620,
	'tool'           => $tool( 15 ),
	'howto'          => array(
		'Settle your hand on the mouse and point at the box.',
		'Click to start. The fifteen second countdown begins with that click.',
		'Keep a fast but sustainable rhythm. Breathe normally; holding your breath works for five seconds, not fifteen.',
		'When the ring empties, read your <strong>clicks</strong>, <strong>CPS</strong> and <strong>consistency</strong>, and look at the graph for the point where you slowed down.',
	),
	'howto_title'    => 'How to take the 15 second click test',
	'results'        => '<p>Your CPS is your clicks divided by fifteen: 90 clicks is 6 CPS. People usually lose about a click per second between their <a href="/5-second-cps-test/">5 second score</a> and their 15 second score.</p>
<div class="table-scroll"><table>
<thead><tr><th>Clicks in 15 s</th><th>CPS</th><th>What it means</th></tr></thead>
<tbody>
<tr><td>Under 60</td><td>Under 4</td><td>Relaxed clicking.</td></tr>
<tr><td>60-90</td><td>4-6</td><td>Normal fast clicking.</td></tr>
<tr><td>90-115</td><td>6-7.7</td><td>Fast and well paced.</td></tr>
<tr><td>115-150</td><td>7.7-10</td><td>Jitter clicking held well.</td></tr>
<tr><td>Over 150</td><td>Over 10</td><td>Butterfly or drag clicking.</td></tr>
</tbody></table></div>
<p>A consistency score above 85% means you held your pace. A graph that drops in steps every few seconds is the sign of a grip that tightens; loosen it and try again.</p>',
	'extra'          => array(
		array(
			'What 15 seconds tells you',
			'<p>At fifteen seconds the test stops being about your fastest finger and starts being about technique. A good normal clicker keeps the same rate from start to finish. A jitter clicker often holds ten seconds and then the vibration breaks up. Use this length to check a technique that feels fast in a <a href="/5-second-cps-test/">5 second test</a> before you rely on it in a game, and step up to the <a href="/30-second-click-test/">30 second click test</a> when the graph stays flat.</p>',
			'tells',
		),
	),
	'fixes'          => array(
		array( 'I slow down after five seconds', 'Your grip is tightening. Hold the mouse lightly, rest the wrist and click from the finger, not the arm. Try starting a little slower.' ),
		array( 'Clicks stop being counted', 'Check that the pointer has not drifted out of the box; fast clicking moves the mouse. A large mouse pad and a firm wrist rest help.' ),
		array( 'My hand or wrist hurts', 'Stop. Fifteen seconds of fast clicking is hard on the tendons. Rest, stretch and keep tries short.' ),
	),
	'faq'            => array(
		array( 'How many clicks in 15 seconds is good?', 'Around 90 clicks (6 CPS) is good for normal clicking. Above 120 usually means jitter or butterfly clicking.' ),
		array( 'What is the average for a 15 second click test?', 'Most people land between 70 and 100 clicks, which is about 4.5 to 6.5 clicks per second.' ),
		array( 'How do I turn my clicks into CPS?', 'Divide by fifteen. The page does it for you and shows the CPS live while you click.' ),
		array( 'Why do I lose speed in a 15 second test?', 'The small muscles that move the finger tire, and most people tense up when they notice. A relaxed grip loses less.' ),
		array( 'Can I click with two fingers?', 'Yes. Alternate two fingers on the left button, or tick "Count right clicks too" and alternate both buttons.' ),
		array( 'Is my best saved?', 'Your best 15 second CPS is stored in this browser only. Nothing is sent to a server.' ),
	),
	'related'        => array( '10-second-cps-test', '30-second-click-test', '5-second-cps-test', 'jitter-click-test', 'cps-test', 'mouse-tester' ),
	'updated'        => '2026-10-29',
);
