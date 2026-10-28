<?php
defined( 'ABSPATH' ) || exit;

return array(
	'title'          => 'Mouse DPI Analyzer',
	'seo_title'      => 'DPI Analyzer: Measure Your Mouse\'s Real DPI Online (Free)',
	'description'    => 'Free mouse DPI analyzer. Move your mouse a known distance to get its true DPI (counts per inch), compare it with your software setting and see the deviation.',
	'intro'          => 'Find out what DPI your mouse really runs at. Set a target distance, click the box, move the mouse exactly that far along a ruler or mouse pad edge, and the analyzer counts every movement report to calculate the real DPI.',
	'device'         => 'desktop',
	'device_message' => 'This test needs a real mouse. Touchpads and touch screens do not report DPI. For a touch screen check, use the <a href="/touch-screen-test/">touch screen test</a>.',
	'ads'            => 'standard',
	'styles'         => array( 'dpi-analyzer' ),
	'scripts'        => array( 'dpi-analyzer' ),
	'embed_height'   => 680,
	'tool'           => '<div class="tool-bar">
	<div class="field dpi-field"><label for="dpi-dist">Distance you will move</label><div class="dpi-dist-row"><input type="number" id="dpi-dist" min="1" max="50" step="0.5" value="5" inputmode="decimal"><div class="seg" role="group" aria-label="Unit"><button type="button" data-dpi-unit="cm" aria-pressed="true">cm</button><button type="button" data-dpi-unit="in" aria-pressed="false">inch</button></div></div></div>
	<div class="field dpi-field"><label for="dpi-set">DPI set in your software (optional)</label><input type="number" id="dpi-set" min="50" max="50000" step="50" placeholder="e.g. 800" inputmode="numeric"></div>
</div>
<div class="tool-stage dpi-stage" id="dpi-stage" tabindex="0">
	<div class="dpi-msg">
		<strong id="dpi-big">Click here to start</strong>
		<span id="dpi-small">Line the mouse up with a mark on a ruler or the edge of your mouse pad first.</span>
	</div>
	<div class="dpi-track" aria-hidden="true"><div class="dpi-fill" id="dpi-fill"></div><div class="dpi-dot" id="dpi-dot"></div></div>
	<div class="dpi-live" id="dpi-live" aria-hidden="true"></div>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">Measured DPI</span><span class="stat-value" id="dpi-result">-</span></div>
	<div class="stat"><span class="stat-label">Counts</span><span class="stat-value" id="dpi-counts">0</span></div>
	<div class="stat"><span class="stat-label">Deviation</span><span class="stat-value" id="dpi-dev">-</span></div>
	<div class="stat"><span class="stat-label">Runs averaged</span><span class="stat-value" id="dpi-runs">0</span></div>
</div>
<div class="btn-row dpi-foot"><button type="button" class="btn btn-sm" id="dpi-reset">Reset</button><span class="dpi-mode" id="dpi-mode"></span></div>
<p class="tool-status" id="dpi-status" aria-live="polite">Place a ruler next to your mouse, or use the edge of the mouse pad as the start line.</p>',
	'howto'          => array(
		'Enter the distance you are going to move, for example <strong>5 cm</strong> or <strong>2 inches</strong>. Longer is more accurate. If you know the DPI set in your mouse software, type it too so the deviation can be shown.',
		'Put a ruler on the desk next to the mouse and line up the front edge of the mouse with a mark, or line it up with the edge of your mouse pad.',
		'Click inside the box. The pointer is captured so it cannot hit the edge of the screen.',
		'Move the mouse slowly in a straight line to the right, exactly the distance you entered. The bar shows raw movement counts as they arrive.',
		'Press <strong>Space</strong> or click to finish. Repeat two or three times; the result averages your runs. Press <strong>Esc</strong> to release the pointer at any time.',
	),
	'howto_title'    => 'How to measure your mouse DPI',
	'results'        => '<p><strong>Measured DPI</strong> is the number of movement counts your mouse sent divided by the distance you moved in inches. A mouse set to 800 DPI should send about 800 counts per inch, so a 2 inch move produces about 1600 counts.</p>
<p><strong>Deviation</strong> compares the measured value with the DPI you typed in. Within about 5% is normal: your hand is not a machine and the sensor has tolerances. A deviation of 10-20% is common on cheap mice and on some sensors at very high DPI settings; it is not a fault, but if you want exact in-game sensitivity you can enter the real value instead of the nominal one in sensitivity calculators.</p>
<p>A result that is <strong>half or double</strong> what you expected usually means the operating system is scaling your movement (see the fixes), not that the mouse is wrong. Run the test again after checking pointer speed and acceleration.</p>',
	'extra'          => array(
		array(
			'What mouse DPI means and why it varies',
			'<p>DPI (dots per inch, also called CPI, counts per inch) is how many movement reports a mouse sensor sends when you move it one inch. At 400 DPI an inch of hand movement moves the pointer 400 pixels on a 100% scaled screen; at 1600 DPI, four times further. Gamers care because sensitivity calculators and aim trainers assume the stated DPI is accurate, and many sensors are off by 5-10%. The same model can measure differently depending on the surface, the firmware and the DPI step chosen, which is why reviewers test the "true" DPI.</p>
<p>This DPI analyzer uses the browser\'s pointer lock with raw, unaccelerated movement where the browser supports it (Chrome and Edge on Windows and macOS), so operating system pointer speed and acceleration do not affect the count. In other browsers it falls back to normal movement and asks you to set Windows pointer speed to the 6th notch and turn off "Enhance pointer precision", which gives a 1:1 ratio.</p>',
			'what-is-dpi',
		),
		array(
			'Tips for an accurate reading',
			'<p>Move slowly and in a straight line; sideways wobble adds counts. Use a longer distance (10 cm or 4 inches) for a smaller error from your start and stop points. Use the edge of the mouse feet as a reference, not the rounded shell. Test on the mouse pad you actually use, because cloth and hard pads can differ by a few percent. Repeat three times and read the average. If you are comparing DPI steps, test each one the same way; if the ratio between steps is correct (for example 800 to 1600 doubles exactly), the sensor is consistent even if the absolute value is a little off.</p>',
			'accuracy',
		),
	),
	'fixes'          => array(
		array( 'The result is about half or double what I set', 'Your operating system is scaling the movement. On Windows, set Settings > Mouse > pointer speed to the middle (6 of 11) and untick "Enhance pointer precision" in Additional mouse settings. On macOS, this browser may not expose raw counts; try Chrome.' ),
		array( 'The pointer does not lock or escapes the box', 'Pointer lock needs a direct click and is blocked inside some embedded frames. Open the page directly, click once inside the box, and allow the browser\'s pointer-lock prompt. Press Esc to release it.' ),
		array( 'The count keeps rising when the mouse is still', 'The sensor is jittering, usually because the surface is reflective, patterned or dirty, or the mouse is lifted a little. Clean the sensor lens and test on a plain mouse pad.' ),
		array( 'Deviation is more than 10%', 'Common on budget sensors and at DPI steps above 3200. Use the measured value in sensitivity calculators, or pick a DPI step that measures closer to its label. Update the mouse firmware; some updates fix DPI tracking.' ),
	),
	'faq'            => array(
		array( 'How do I check my mouse DPI?', 'Enter a distance, click the box, move the mouse exactly that distance along a ruler and press Space. The analyzer divides the movement counts by the distance in inches.' ),
		array( 'What is the difference between DPI and CPI?', 'Nothing in practice. CPI (counts per inch) is the technically correct term for a mouse sensor; DPI (dots per inch) is the name most brands use.' ),
		array( 'Why is my measured DPI not exactly what I set?', 'Sensors have tolerances of a few percent, and your start and stop points add error. Within 5% is normal. Larger differences are usually operating system scaling or sensor deviation.' ),
		array( 'What DPI should I use for gaming?', 'Most players use 400-1600 DPI with in-game sensitivity adjusted to taste. What matters is the total "effective DPI" (DPI x in-game sensitivity) and that you keep it consistent.' ),
		array( 'Does Windows pointer speed affect the DPI test?', 'Only if your browser does not support raw input. Chrome and Edge use unaccelerated movement during the test. Elsewhere, set pointer speed to 6/11 and disable Enhance pointer precision.' ),
		array( 'Can I measure DPI on a laptop touchpad?', 'No. Touchpads report finger position, not sensor counts, so DPI does not apply to them.' ),
	),
	'related'        => array( 'mouse-tester', 'mouse-polling-rate-test', 'double-click-test', 'cps-test', 'online-ruler', 'scroll-test' ),
	'updated'        => '2026-10-28',
);
