<?php
/**
 * The one CPS and WPM scale used on every tool, hub and guide page, so the
 * numbers never drift apart. Returns HTML snippets:
 *   'cps'         rank table for a 5 second test (ranks match cps-test.js)
 *   'cps_methods' typical CPS by clicking technique
 *   'cps_short'   one-sentence summary of the CPS scale
 *   'wpm'         typing speed levels (net WPM on common words)
 *   'wpm_short'   one-sentence summary of the WPM scale
 */

defined( 'ABSPATH' ) || exit;

return array(
	'cps'         => '<div class="table-scroll"><table>
<thead><tr><th>CPS (5 s)</th><th>Rank</th><th>Typical of</th></tr></thead>
<tbody>
<tr><td>Under 4</td><td>Turtle</td><td>Slow, careful single clicking.</td></tr>
<tr><td>4-6</td><td>Rabbit</td><td>Normal clicking with one finger. Most people score here.</td></tr>
<tr><td>6-8</td><td>Fox</td><td>Fast regular clicking. Practiced players top out around 7 or 8.</td></tr>
<tr><td>8-10</td><td>Cheetah</td><td>The low end of jitter clicking, or two fingers taking turns.</td></tr>
<tr><td>Over 10</td><td>Lightning</td><td>Jitter, butterfly or drag clicking. Many game servers flag clicking above about 20 CPS.</td></tr>
</tbody></table></div>',

	'cps_methods' => '<div class="table-scroll"><table>
<thead><tr><th>Method</th><th>Typical CPS (5 s)</th><th>How it works</th></tr></thead>
<tbody>
<tr><td>Normal clicking</td><td>4 to 7</td><td>One finger, a normal press and release.</td></tr>
<tr><td>Fast regular clicking</td><td>6 to 8</td><td>One finger, a quick, light tap. Most players top out here.</td></tr>
<tr><td>Jitter clicking</td><td>8 to 12</td><td>Tensing the forearm so the hand vibrates over the button.</td></tr>
<tr><td>Butterfly clicking</td><td>12 to 20</td><td>Two fingers tapping the same button in turn; many mice register extra clicks.</td></tr>
<tr><td>Drag clicking</td><td>15 to 30+</td><td>Dragging a fingertip across the button so the switch bounces. Depends on the mouse surface.</td></tr>
</tbody></table></div>',

	'cps_short'   => 'Over 5 seconds, normal clicking gives 4 to 7 CPS, fast regular clicking 6 to 8, jitter clicking 8 to 12, butterfly clicking 12 to 20 and drag clicking 15 or more on a suitable mouse.',

	'wpm'         => '<div class="table-scroll"><table>
<thead><tr><th>Net WPM</th><th>Level</th><th>Who types this fast</th></tr></thead>
<tbody>
<tr><td>Under 30</td><td>Beginner</td><td>Two-finger or hunt-and-peck typing, looking at the keys.</td></tr>
<tr><td>30-50</td><td>Average</td><td>Most adults. The average is about 40 WPM.</td></tr>
<tr><td>50-70</td><td>Good</td><td>People who type every day. Jobs that test typing usually ask for 40 to 60.</td></tr>
<tr><td>70-100</td><td>Fast</td><td>Touch typists who write all day: programmers, writers, transcriptionists.</td></tr>
<tr><td>Over 100</td><td>Very fast</td><td>Competitive typists. The best sustain 150 or more for a minute.</td></tr>
</tbody></table></div>',

	'wpm_short'   => 'About 40 WPM is average, 50 to 70 is good, 70 to 100 is fast and over 100 is very fast.',
);
