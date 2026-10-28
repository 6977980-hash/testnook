<?php
/**
 * Shared tool markup for the typing test pages. Not a tool page itself: it is
 * not in the catalog. Returns a function that builds the markup for
 * typing-test.js.
 *
 * @param array  $lengths seconds => label of the length buttons (empty for a fixed length).
 * @param int    $default Default length in seconds.
 * @param string $source  "words" (random common words) or "sentences" (English passages).
 */
defined( 'ABSPATH' ) || exit;

return function ( $lengths, $default, $source ) {
	$bar = '';
	if ( $lengths ) {
		$bar .= "\t" . '<div class="seg" role="group" aria-label="Test length">' . "\n";
		foreach ( $lengths as $secs => $label ) {
			$bar .= sprintf( "\t\t" . '<button type="button" data-tt-t="%d" aria-pressed="%s">%s</button>' . "\n", $secs, $secs === $default ? 'true' : 'false', $label );
		}
		$bar .= "\t</div>\n";
	}
	$time = $default >= 60 ? floor( $default / 60 ) . ':' . str_pad( $default % 60, 2, '0', STR_PAD_LEFT ) : $default . ' s';
	return '<div class="tool-bar">
' . $bar . '	<div class="tt-hud"><span>Time <strong id="tt-time">' . $time . '</strong></span><span>WPM <strong id="tt-live">0</strong></span></div>
	<button type="button" class="btn btn-sm" id="tt-restart">Restart</button>
</div>
<div class="tool-stage tt-stage" id="tt-stage" data-tt-text="' . $source . '" data-tt-dur="' . (int) $default . '" aria-label="Typing test text">
	<div class="tt-window"><div class="tt-text" id="tt-text"></div></div>
	<div class="tt-result" id="tt-result" hidden></div>
	<div class="tt-overlay" id="tt-overlay">Click here or press any key to start typing</div>
	<p class="tt-hint tt-mobile">Type in the box below; the words above show what to type.</p>
	<input type="text" class="tt-input" id="tt-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-label="Type the words shown above">
	<p class="tt-hint">Space after each word. Tab restarts.</p>
</div>
<div class="stats">
	<div class="stat"><span class="stat-label">WPM</span><span class="stat-value" id="tt-wpm">-</span></div>
	<div class="stat"><span class="stat-label">Accuracy</span><span class="stat-value" id="tt-acc">-</span></div>
	<div class="stat"><span class="stat-label">Raw WPM</span><span class="stat-value" id="tt-raw">-</span></div>
	<div class="stat"><span class="stat-label">Errors</span><span class="stat-value" id="tt-err">0</span></div>
	<div class="stat"><span class="stat-label">Characters</span><span class="stat-value" id="tt-chars">0</span></div>
</div>
<div class="btn-row tt-foot"><span class="tt-pb" id="tt-pb"></span></div>
<p class="tool-status" id="tt-status" aria-live="polite">Click the text and start typing. The clock starts on your first key.</p>';
};
