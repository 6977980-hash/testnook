<?php
/**
 * Shared screen calibration box (bank card or screen diagonal), used by the
 * eye tests and screen size page. Wired up by assets/js/tools/screen-cal.js,
 * which stores the result under the same key as the online ruler.
 */

defined( 'ABSPATH' ) || exit;

return function ( $open = false ) {
	return '<details class="sc-cal" id="sc-cal"' . ( $open ? ' open' : '' ) . '>
	<summary>Calibrate to your screen <span class="sc-state" id="sc-state">(not calibrated)</span></summary>
	<div class="sc-body">
		<div class="sc-opt">
			<h3>Bank card</h3>
			<p id="sc-hint">Hold any bank or ID card flat against the screen and drag the slider until the box is exactly as wide as the card.</p>
			<div class="sc-card" id="sc-card"><span>Match a bank card</span></div>
			<input type="range" id="sc-slider" min="100" max="900" step="1" value="323" aria-label="Card width">
			<button type="button" class="btn btn-sm btn-primary" id="sc-card-apply">Use this size</button>
		</div>
		<div class="sc-opt">
			<h3>Screen size</h3>
			<p>Or enter the diagonal of this screen in inches, from the box or spec sheet.</p>
			<div class="sc-diag"><input type="number" id="sc-diag" min="3" max="100" step="0.1" placeholder="e.g. 15.6" inputmode="decimal" aria-label="Screen diagonal in inches"><span>inch</span><button type="button" class="btn btn-sm btn-primary" id="sc-diag-apply">Use screen size</button></div>
			<button type="button" class="btn btn-sm" id="sc-reset">Reset calibration</button>
		</div>
	</div>
</details>';
};
