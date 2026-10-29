<?php
/**
 * Shared tool markup for the monitor pattern pages (monitor test, LCD, OLED,
 * display, monitor colour, calibration). Not a tool page itself: it is not in
 * the catalog. Returns a function that builds the pattern grid for
 * assets/js/tools/monitor-test.js, which draws each pattern by its id.
 *
 * @param array  $list   Pattern ids in order, or id => array( label, tip ) to
 *                       override the default label and tip for this page.
 * @param string $start  Text of the start button.
 * @param string $status Hint shown under the tool.
 */

defined( 'ABSPATH' ) || exit;

return function ( $list, $start, $status ) {
	$defaults = array(
		'black'          => array( 'Black', 'Look for bright dots (stuck or hot pixels) and for light leaking in from the edges or corners (backlight bleed). Dim the room lights first.' ),
		'white'          => array( 'White', 'Look for black dots (dead pixels), dust under the panel and a tint or darker patches across the screen.' ),
		'red'            => array( 'Red', 'Look for black or differently coloured dots. A dot missing only on red is a dead red sub-pixel.' ),
		'green'          => array( 'Green', 'Look for black or differently coloured dots. A dot missing only on green is a dead green sub-pixel.' ),
		'blue'           => array( 'Blue', 'Look for black or differently coloured dots. A dot missing only on blue is a dead blue sub-pixel.' ),
		'cyan'           => array( 'Cyan', 'Cyan is green plus blue with no red. Look for red-tinted dots and for an even colour across the screen.' ),
		'magenta'        => array( 'Magenta', 'Magenta is red plus blue with no green. Look for green dots and for an even colour across the screen.' ),
		'yellow'         => array( 'Yellow', 'Yellow is red plus green with no blue. Look for blue dots and for an even colour across the screen.' ),
		'grey50'         => array( '50% grey', 'The whole screen should be one even grey. Darker corners, cloudy patches or a dirty-screen look are uniformity faults, and faint shapes of icons are burn-in.' ),
		'grey20'         => array( '20% grey', 'A dark grey shows clouding and uneven backlight on LCDs better than black does. Look for brighter blotches and bands.' ),
		'grey5'          => array( '5% grey', 'A very dark grey. OLED panels can show blotches, vertical bands or a green or magenta tint here (near-black mura).' ),
		'gradient'       => array( 'Grey gradient', 'The top half should be a smooth fade from black to white. Visible steps (banding) point to a low bit-depth panel, a colour profile or a low-quality connection mode. The bottom half shows 32 steps on purpose, for comparison.' ),
		'rgb-gradients'  => array( 'Colour gradients', 'Each strip should fade smoothly with no steps, and the grey strip should stay neutral without turning pink or green.' ),
		'near-black'     => array( 'Near-black steps', 'Steps from 0 (black) to 40 out of 255. Each step should be a little brighter than the one before. Steps that merge mean black crush; blotchy or tinted steps are common on OLED.' ),
		'black-level'    => array( 'Black level', 'Squares from level 1 to 32 on pure black. You should see the squares from about 3 or 4 upward. If many squares disappear, raise the brightness or black level; if the background itself looks grey, lower it.' ),
		'white-level'    => array( 'White level', 'Squares from 254 down to 216 on pure white. You should tell most of them apart from the background. If the squares near 254 vanish, lower the contrast.' ),
		'gamma'          => array( 'Gamma', 'Step back or squint. In each column the solid square blends into the striped background at one gamma value: the column where it disappears best is your gamma. 2.2 is the standard. Works only at 100% browser zoom.' ),
		'sharpness'      => array( 'Sharpness and text', 'Lines and checkers should be crisp and even. Bright or dark halos around the lines and text mean the monitor sharpness is set too high; blurry text means it is too low or the resolution is not native.' ),
		'grid'           => array( 'Grid and geometry', 'Lines should be straight, the circles round, and the outermost lines visible at all four edges. Missing edges on a TV mean overscan: set the picture size to Just Scan, Screen Fit or 1:1.' ),
		'color-bars'     => array( 'Colour bars', 'Top: 75% bars, bottom: 100% bars, in the order white, yellow, cyan, green, magenta, red, blue. Every bar should be clean and distinct, with no bar bleeding into its neighbour.' ),
		'hue'            => array( 'Colour spectrum', 'The full range of hues from light to dark. It should look smooth, with no hard bands or patches where colours jump.' ),
		'saturation'     => array( 'Saturation steps', 'Each row goes from grey on the left to full colour on the right. You should see every step; if the last few look the same, the colour is clipped or saturation is set too high.' ),
		'checker'        => array( 'Colour patches', 'Twenty-four reference colours such as skin tones, sky blue and foliage, plus a grey row. Skin tones should look natural and the grey row neutral, with no tint.' ),
		'inversion'      => array( 'Inversion patterns', 'Each band is made of single-pixel patterns and should look like flat, even colour. Flicker, shimmer or crawling lines in a band show the panel\'s pixel inversion. Use 100% browser zoom.' ),
		'viewing-angle'  => array( 'Viewing angle', 'Move your head up, down and to the sides. On IPS and OLED the colours barely change. On TN panels they shift and may invert from below; on VA panels dark tones lighten at an angle.' ),
		'smear'          => array( 'Dark smearing', 'Dark grey boxes move over black. A dark trail or smudge behind them is black smearing, which is common on VA panels. Overdrive settings change it.' ),
	);

	$items = '';
	$i     = 0;
	foreach ( $list as $key => $value ) {
		$id = is_int( $key ) ? $value : $key;
		$d  = isset( $defaults[ $id ] ) ? $defaults[ $id ] : array( $id, '' );
		if ( is_array( $value ) ) {
			$d = array( $value[0], isset( $value[1] ) ? $value[1] : $d[1] );
		}
		$i++;
		$items .= sprintf(
			"\t\t" . '<li><button type="button" class="mt-pat" data-mt="%1$s" data-tip="%3$s"><canvas width="160" height="90" aria-hidden="true"></canvas><span><b>%4$d.</b> %2$s</span></button></li>' . "\n",
			esc_attr( $id ),
			esc_html( $d[0] ),
			esc_attr( $d[1] ),
			$i
		);
	}

	return '<div class="tool-bar">
	<button type="button" class="btn btn-primary" id="mt-start">' . $start . '</button>
	<label class="mt-opt"><input type="checkbox" id="mt-tips" checked> Show tips in full screen</label>
</div>
<div class="tool-stage mt-stage">
	<ol class="mt-grid" id="mt-grid">
' . $items . '	</ol>
	<p class="mt-keys">In full screen: <kbd>click</kbd> / <kbd>tap</kbd> / <kbd>&rarr;</kbd> next, <kbd>&larr;</kbd> back, <kbd>H</kbd> tips, <kbd>Esc</kbd> exit.</p>
</div>
<div class="mt-screen" id="mt-screen" hidden tabindex="-1">
	<canvas id="mt-canvas"></canvas>
	<div class="mt-tip" id="mt-tip"><b id="mt-tip-name"></b> <span id="mt-tip-text"></span></div>
	<div class="mt-nav" id="mt-nav"><button type="button" data-mt-go="-1" aria-label="Previous pattern">&#8249;</button><button type="button" data-mt-go="1" aria-label="Next pattern">&#8250;</button><button type="button" data-mt-go="0" aria-label="Close">&#215;</button></div>
</div>
<p class="tool-status" id="mt-status" aria-live="polite">' . $status . '</p>';
};
