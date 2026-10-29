<?php
/**
 * /leaderboards/: the public top 10 boards (CPS, reaction time, typing, mouse accuracy) and the rules.
 * The tables are printed by tn_leaderboards_hub() (inc/leaderboards.php) after the body.
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'       => 'Testnook Leaderboards',
	'seo_title'   => 'Leaderboards: Top CPS, Reaction and Typing Scores | Testnook',
	'description' => 'Top 10 scores on Testnook for click speed (CPS), reaction time, typing and mouse accuracy: today, this week and all time. Add your nickname after any test.',
	'updated'     => '2026-10-29',
	'render'      => 'tn_leaderboards_hub',
	'body'        => '<p>These are the best scores people have chosen to put their name to on Testnook. Every entry comes from a real run of the <a href="/cps-test/">click speed test</a>, <a href="/reaction-time-test/">reaction time test</a>, <a href="/typing-test-english/">typing test</a> or <a href="/mouse-accuracy-test/">mouse accuracy test</a> on this site. Finish a test, press <strong>Add my score to the leaderboard</strong> and type a nickname: no account, no email.</p>
<h2 id="rules">How the boards work</h2>
<ul>
<li><strong>Today, This week, All time.</strong> Today resets at midnight UTC; This week covers the last seven days. All-time scores stay as long as the site runs.</li>
<li><strong>One spot per name.</strong> Only your best score for a name is shown on each board, so one person cannot fill the top 10.</li>
<li><strong>Same checks as the site stats.</strong> A score is accepted only if the test ran for its full length, the result is within human range, and the clicks do not look like a program. Auto clickers and bots are not welcome, and scores that would take an all-time top 3 place are checked by hand before they appear.</li>
<li><strong>Nicknames are public.</strong> Use a nickname, not your real name: 3 to 16 letters, digits, spaces, dashes or underscores, no links, no offensive words. Names that break the rules are refused or removed, and a name used for abuse is blocked.</li>
<li><strong>Ten entries per day.</strong> Each connection can add up to ten scores a day; plenty for an honest run of attempts.</li>
</ul>
<h2 id="scoring">What counts</h2>
<ul>
<li><strong>Click speed:</strong> clicks per second in the left-click mode of the <a href="/cps-test/">CPS test</a>, one board per length from 1 to 100 seconds.</li>
<li><strong>Reaction time:</strong> the average of five tries on the <a href="/reaction-time-test/">reaction time test</a>, in milliseconds. Lower is better.</li>
<li><strong>Typing speed:</strong> words per minute on the <a href="/1-minute-typing-test/">1 minute</a> and <a href="/5-minute-typing-test/">5 minute</a> typing tests with at least 85% accuracy. On a tie, the higher accuracy ranks first.</li>
<li><strong>Mouse accuracy:</strong> points from the <a href="/mouse-accuracy-test/">mouse accuracy test</a>, with a board for each mode and target size.</li>
</ul>
<p>To have a name removed, email <a href="mailto:' . esc_attr( TN_CONTACT_EMAIL ) . '">' . esc_html( TN_CONTACT_EMAIL ) . '</a> with the nickname, the board and the date. See the <a href="/privacy-policy/#results">privacy policy</a> for what is stored.</p>
<h2 id="boards">The boards</h2>
<p>Pick a test length or mode where there is a choice, then switch between today, this week and all time.</p>',
);
