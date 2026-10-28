<?php
/**
 * Shared controller diagram for the PS5, Xbox and PS4 controller test pages
 * (not a tool page itself: it is not in the catalog). Returns a function that
 * builds the markup for gamepad-tester.js with the page's button labels.
 */
defined( 'ABSPATH' ) || exit;

return function ( $pad, $labels ) {
	$map = array( '{pad}' => $pad );
	foreach ( $labels as $i => $label ) {
		$map[ '{b' . $i . '}' ] = $label;
	}
	return strtr(
		'<div class="tool-bar">
	<div class="btn-row">
		<button type="button" class="btn" id="gp-rumble" disabled>Test vibration</button>
		<button type="button" class="btn" id="gp-reset">Reset</button>
	</div>
	<label class="visually-hidden" for="gp-pad">Controller</label>
	<select id="gp-pad" class="gp-select" hidden></select>
</div>
<div class="tool-stage gp-stage">
	<div class="gp-pad" data-pad="{pad}" aria-hidden="true">
		<div class="gp-shoulders">
			<div class="gp-shoulder">
				<div class="gp-trig" data-gp-btn="6"><span id="gp-lt"></span><b class="gp-t">{b6}</b></div>
				<div class="gp-b" data-gp-btn="4"><span class="gp-t">{b4}</span></div>
			</div>
			<div class="gp-shoulder">
				<div class="gp-trig" data-gp-btn="7"><span id="gp-rt"></span><b class="gp-t">{b7}</b></div>
				<div class="gp-b" data-gp-btn="5"><span class="gp-t">{b5}</span></div>
			</div>
		</div>
		<div class="gp-body">
			<div class="gp-side">
				<div class="gp-dpad">
					<div class="gp-b" data-gp-btn="12"><span class="gp-t">{b12}</span></div>
					<div class="gp-b" data-gp-btn="14"><span class="gp-t">{b14}</span></div>
					<div class="gp-b" data-gp-btn="15"><span class="gp-t">{b15}</span></div>
					<div class="gp-b" data-gp-btn="13"><span class="gp-t">{b13}</span></div>
				</div>
				<div class="gp-stick" id="gp-ls" data-gp-btn="10"><div class="gp-dot"></div><span class="gp-xy">0.00, 0.00</span></div>
			</div>
			<div class="gp-mid">
				<div class="gp-row">
					<div class="gp-b" data-gp-btn="8"><span class="gp-t">{b8}</span></div>
					<div class="gp-b" data-gp-btn="9"><span class="gp-t">{b9}</span></div>
				</div>
				<div class="gp-row">
					<div class="gp-b" data-gp-btn="16"><span class="gp-t">{b16}</span></div>
					<div class="gp-b" data-gp-btn="17"><span class="gp-t">{b17}</span></div>
				</div>
			</div>
			<div class="gp-side">
				<div class="gp-face">
					<div class="gp-b" data-gp-btn="3"><span class="gp-t">{b3}</span></div>
					<div class="gp-b" data-gp-btn="2"><span class="gp-t">{b2}</span></div>
					<div class="gp-b" data-gp-btn="1"><span class="gp-t">{b1}</span></div>
					<div class="gp-b" data-gp-btn="0"><span class="gp-t">{b0}</span></div>
				</div>
				<div class="gp-stick" id="gp-rs" data-gp-btn="11"><div class="gp-dot"></div><span class="gp-xy">0.00, 0.00</span></div>
			</div>
		</div>
	</div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Controller</span><span class="stat-value gp-name" id="gp-name">None</span></div>
	<div class="stat"><span class="stat-label">Mapping</span><span class="stat-value" id="gp-map">-</span></div>
	<div class="stat"><span class="stat-label">Buttons / axes</span><span class="stat-value" id="gp-counts">-</span></div>
	<div class="stat"><span class="stat-label">Buttons tested</span><span class="stat-value" id="gp-tested">0</span></div>
</div>
<div class="gp-raw" id="gp-raw"></div>
<p class="tool-status" id="gp-status" aria-live="polite">No controller found yet. Connect it by USB or Bluetooth, then press any button on it.</p>',
		$map
	);
};
