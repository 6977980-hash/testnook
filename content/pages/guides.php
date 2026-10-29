<?php
/**
 * /guides/: every guide, grouped by hub. The cards are printed by
 * tn_guides_index() (inc/guides.php) after the body.
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Guides',
	'seo_title'   => 'Hardware Guides: Fixes, Averages and Explainers | Testnook',
	'description' => 'Plain-English guides to go with the Testnook tests: what a good CPS or reaction time is, how to fix stick drift, dead pixels, a webcam or mic that will not work.',
	'updated'     => '2026-10-29',
	'render'      => 'tn_guides_index',
	'body'        => '<p>Each guide goes with one of the free tests on this site. Some answer "is my score good?" with real numbers, including anonymous results from people who took the same test on Testnook. Others walk through a fix, step by step, for hardware that is acting up: a drifting stick, keys that do not register, a webcam or microphone the computer cannot find, dead pixels, screen burn-in.</p>
<p>Every guide starts with a short answer, then explains the why. Where a test can show the problem, there is a link to run it in your browser first, so you know what you are fixing before you open a settings menu or a screwdriver.</p>',
);
