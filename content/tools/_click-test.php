<?php
/**
 * Shared markup for the fixed-length click test pages (1-second-cps-test ...
 * 100-second-click-test). Not a page. Returns a function that builds the tool
 * for a number of seconds; the length row links the sibling pages instead of
 * switching length in place, so each page keeps its own fixed test.
 */

defined( 'ABSPATH' ) || exit;

return function ( $secs ) {
	$pages = array(
		1   => '1-second-cps-test',
		5   => '5-second-cps-test',
		10  => '10-second-cps-test',
		15  => '15-second-click-test',
		30  => '30-second-click-test',
		60  => '60-second-click-test',
		100 => '100-second-click-test',
	);
	$links = '';
	foreach ( $pages as $s => $slug ) {
		$links .= $s === $secs
			? '<a href="/' . $slug . '/" aria-current="page">' . $s . ' s</a>'
			: '<a href="/' . $slug . '/">' . $s . ' s</a>';
	}
	return '<div class="tool-bar">
	<nav class="cps-len" aria-label="Other test lengths"><span>Length:</span>' . $links . '</nav>
	<label class="cps-opt"><input type="checkbox" id="cps-right"> Count right clicks too</label>
</div>
<div class="tool-stage cps-stage" id="cps-stage" data-cps-dur="' . $secs . '" tabindex="0" role="button" aria-label="Click area">
	<div class="cps-ring" id="cps-ring"><span id="cps-timer">' . $secs . '.0</span><small>' . ( 1 === $secs ? 'second' : 'seconds' ) . '</small></div>
	<div class="cps-msg"><strong id="cps-big">Click here to start</strong><span id="cps-small">The timer starts on your first click.</span></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Clicks / second</span><span class="stat-value" id="cps-cps">0.0</span></div>
	<div class="stat"><span class="stat-label">Clicks</span><span class="stat-value" id="cps-count">0</span></div>
	<div class="stat"><span class="stat-label">Peak CPS</span><span class="stat-value" id="cps-peak">0.0</span></div>
	' . ( $secs >= 10 ? '<div class="stat"><span class="stat-label">Consistency</span><span class="stat-value" id="cps-consist">-</span></div>
	' : '' ) . '<div class="stat"><span class="stat-label">Rank</span><span class="stat-value" id="cps-rank">-</span></div>
</div>
<div class="cps-graph" id="cps-graph" aria-hidden="true"></div>
<div class="btn-row cps-foot"><button type="button" class="btn btn-sm" id="cps-reset">Reset</button><span class="cps-pb" id="cps-pb"></span></div>
<p class="tool-status" id="cps-status" aria-live="polite">Click in the box as fast as you can.</p>';
};
