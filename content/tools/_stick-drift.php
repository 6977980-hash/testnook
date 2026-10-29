<?php
/**
 * Shared markup for the stick drift and Joy-Con drift pages (not a tool page
 * itself: it is not in the catalog). Read by stick-drift-test.js.
 */
defined( 'ABSPATH' ) || exit;

return array(
	// One stick: heading, canvas and its readouts.
	'stick' => function ( $i, $label ) {
		return '<div class="sd-stick">
		<h2 id="sd-h' . $i . '">' . $label . '</h2>
		<canvas id="sd-c' . $i . '" aria-label="' . $label . ' position"></canvas>
		<div class="stats">
			<div class="stat"><span class="stat-label">X</span><span class="stat-value" id="sd-x' . $i . '">0.000</span></div>
			<div class="stat"><span class="stat-label">Y</span><span class="stat-value" id="sd-y' . $i . '">0.000</span></div>
			<div class="stat"><span class="stat-label">Distance</span><span class="stat-value" id="sd-d' . $i . '">0%</span></div>
			<div class="stat"><span class="stat-label">At rest</span><span class="stat-value" id="sd-rest' . $i . '">-</span></div>
			<div class="stat"><span class="stat-label">Dead zone</span><span class="stat-value" id="sd-dzs' . $i . '">-</span></div>
			<div class="stat"><span class="stat-label">Outer range</span><span class="stat-value" id="sd-range' . $i . '">-</span></div>
			<div class="stat"><span class="stat-label">Circularity error</span><span class="stat-value" id="sd-circ' . $i . '">-</span></div>
		</div>
	</div>';
	},
	// Drift tiers; the script marks the row the worst stick falls in.
	'tiers' => '<div class="table-scroll sd-tiers-wrap"><table class="sd-tiers" id="sd-tiers">
	<caption>Drift at rest, as a share of full tilt</caption>
	<thead><tr><th scope="col">At rest</th><th scope="col">Verdict</th><th scope="col">What it means</th></tr></thead>
	<tbody>
		<tr data-sd-tier="0"><td>1% or less</td><td>Excellent</td><td>As good as new. No dead zone needed.</td></tr>
		<tr data-sd-tier="1"><td>1-5%</td><td>Normal</td><td>Normal sensor noise. Default game dead zones hide it.</td></tr>
		<tr data-sd-tier="2"><td>5-10%</td><td>Noticeable</td><td>Slow camera creep in some games. Raise the dead zone or clean the stick.</td></tr>
		<tr data-sd-tier="3"><td>Over 10%</td><td>Needs attention</td><td>Clear drift. The stick module is worn or dirty; try the fixes below.</td></tr>
	</tbody>
</table></div>',
);
