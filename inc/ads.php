<?php
/**
 * AdSense slots and ads.txt.
 *
 * Placement rules (AdSense policy, agreed in research):
 *  - No ads next to click/tap areas: tools where the user clicks fast (CPS,
 *    double click, spacebar, reaction) use 'ads' => 'content', which skips the
 *    slot directly under the tool.
 *  - No ads on screens without publisher content: solid colour screens, dead
 *    pixel, burn-in, fullscreen tools use 'ads' => 'none'.
 *  - Never in embed mode, on legal pages or on the 404 page.
 * Slots have a fixed min-height in CSS so ads cannot shift the layout.
 * Nothing is printed until TN_ADS_ENABLED is true and TN_ADSENSE_CLIENT is set.
 */

defined( 'ABSPATH' ) || exit;

function tn_ads_mode() {
	if ( is_front_page() ) {
		return 'content';
	}
	$def = tn_current_def();
	return $def ? $def['ads'] : 'none';
}

function tn_ads_allowed_here() {
	return TN_ADS_ENABLED && TN_ADSENSE_CLIENT && ! tn_is_embed() && ! is_404() && 'none' !== tn_ads_mode();
}

/**
 * Print an ad slot if the current page's mode allows this position.
 *
 * @param string $position below-tool | in-content | after-faq
 */
function tn_ad_slot( $position ) {
	if ( ! tn_ads_allowed_here() ) {
		return;
	}
	$allowed = array(
		'standard' => array( 'below-tool', 'in-content', 'after-faq' ),
		'content'  => array( 'in-content', 'after-faq' ),
	);
	$mode = tn_ads_mode();
	if ( ! isset( $allowed[ $mode ] ) || ! in_array( $position, $allowed[ $mode ], true ) ) {
		return;
	}
	printf(
		'<div class="ad-slot ad-slot--%1$s" aria-label="Advertisement"><ins class="adsbygoogle" style="display:block" data-ad-client="%2$s" data-ad-format="auto" data-full-width-responsive="true"></ins></div>',
		esc_attr( $position ),
		esc_attr( TN_ADSENSE_CLIENT )
	);
}

/** Serve /ads.txt from the publisher id (WordPress routes unknown paths to index.php). */
add_action(
	'parse_request',
	function () {
		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) : '';
		if ( '/ads.txt' === $path && TN_ADSENSE_CLIENT ) {
			header( 'Content-Type: text/plain; charset=utf-8' );
			echo 'google.com, ' . esc_html( str_replace( 'ca-', '', TN_ADSENSE_CLIENT ) ) . ", DIRECT, f08c47fec0942fa0\n";
			exit;
		}
	},
	0
);
