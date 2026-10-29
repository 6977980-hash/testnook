<?php
/**
 * Shared tool markup for the solid color screen pages (red, green, blue...).
 * Not a tool page itself: it is not in the catalog. Returns a function that
 * builds the markup for colour-screen.js. The first swatch is the page's
 * main color.
 *
 * @param string $color   Color name for the button, e.g. "red".
 * @param array  $swatches hex => label.
 * @param string $status   Hint shown under the tool.
 */
defined( 'ABSPATH' ) || exit;

return function ( $color, $swatches, $status ) {
	$buttons = '';
	$first   = true;
	foreach ( $swatches as $hex => $label ) {
		$buttons .= sprintf(
			"\t\t" . '<button type="button" class="cs-swatch" data-cs-color="%1$s" style="background:%1$s" aria-label="%2$s"%3$s></button>' . "\n",
			$hex,
			$label,
			$first ? ' aria-pressed="true"' : ''
		);
		$first = false;
	}
	return '<div class="tool-bar cs-bar">
	<button type="button" class="btn btn-primary" id="cs-start">Open full ' . $color . ' screen</button>
	<label class="cs-timer">Auto close <select id="cs-timer"><option value="0">never</option><option value="1">after 1 min</option><option value="5">after 5 min</option><option value="15">after 15 min</option><option value="60">after 1 hour</option></select></label>
</div>
<div class="tool-stage cs-stage">
	<div class="cs-preview" id="cs-preview" role="button" tabindex="0" aria-label="Open full screen"><span>Click to go full screen</span></div>
	<div class="cs-swatches" aria-label="Shades">
' . $buttons . '	</div>
	<p class="cs-keys">In full screen: <kbd>Esc</kbd> or <kbd>tap</kbd> to exit.</p>
</div>
<div class="cs-screen" id="cs-screen" hidden tabindex="-1"><div class="cs-hint" id="cs-hint"></div></div>
<p class="tool-status" id="cs-status" aria-live="polite">' . $status . '</p>';
};
