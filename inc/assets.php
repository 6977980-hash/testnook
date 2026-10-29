<?php
/**
 * CSS, JS, favicons and analytics tags.
 *
 * main.css is small and inlined into <head> so the first paint needs no extra
 * request. A tool can add its own CSS (assets/css/tools/<name>.css, also
 * inlined) and JS modules (assets/js/tools/<name>.js, deferred).
 */

defined( 'ABSPATH' ) || exit;

function tn_asset_ver( $rel ) {
	$file = TN_DIR . '/' . $rel;
	return is_readable( $file ) ? TN_VERSION . '.' . filemtime( $file ) : TN_VERSION;
}

/** Runs first in <head>: applies the saved/system theme before paint to avoid a flash. */
add_action(
	'wp_head',
	function () {
		echo "<script>(function(){var m=location.search.match(/[?&]theme=(light|dark)\b/);var t=m?m[1]:'';if(!t){try{t=localStorage.getItem('tn-theme');}catch(e){}}if(t!=='light'&&t!=='dark'){t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}document.documentElement.setAttribute('data-theme',t);document.documentElement.className+=' js';})();</script>\n";
	},
	0
);

add_action(
	'wp_head',
	function () {
		$css = (string) file_get_contents( TN_DIR . '/assets/css/main.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$def = tn_current_def();
		if ( $def && ! empty( $def['styles'] ) ) {
			foreach ( (array) $def['styles'] as $name ) {
				$file = TN_DIR . '/assets/css/tools/' . sanitize_file_name( $name ) . '.css';
				if ( is_readable( $file ) ) {
					$css .= "\n" . file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
				}
			}
		}
		// Strip comments and collapse whitespace; the files stay readable in the repo.
		$css = preg_replace( '#/\*.*?\*/#s', '', $css );
		$css = preg_replace( '/\s+/', ' ', $css );
		echo '<style id="tn-css">' . trim( $css ) . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput
	},
	5
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_script( 'tn-site', TN_URI . '/assets/js/site.js', array(), tn_asset_ver( 'assets/js/site.js' ), array( 'strategy' => 'defer', 'in_footer' => false ) );
		$def = tn_current_def();
		wp_add_inline_script(
			'tn-site',
			'window.TN=' . wp_json_encode(
				array(
					'ads'      => tn_ads_allowed_here() ? TN_ADSENSE_CLIENT : '',
					'ga4'      => TN_GA4_ID,
					'clarity'  => TN_CLARITY_ID,
					'embed'    => tn_is_embed(),
					'rest'     => esc_url_raw( rest_url( 'testnook/v1/' ) ),
					'slug'     => $def && 'tool' === $def['type'] ? $def['slug'] : '',
				)
			) . ';',
			'before'
		);

		if ( $def && ! empty( $def['stats'] ) && ! tn_is_embed() ) {
			wp_enqueue_script( 'tn-stats', TN_URI . '/assets/js/stats.js', array( 'tn-site' ), tn_asset_ver( 'assets/js/stats.js' ), array( 'strategy' => 'defer', 'in_footer' => true ) );
		}
		if ( $def && tn_lb_page_has_boards( $def ) ) {
			wp_enqueue_script( 'tn-leaderboard', TN_URI . '/assets/js/leaderboard.js', array( 'tn-site' ), tn_asset_ver( 'assets/js/leaderboard.js' ), array( 'strategy' => 'defer', 'in_footer' => true ) );
		}
		if ( $def && ! empty( $def['scripts'] ) ) {
			foreach ( (array) $def['scripts'] as $name ) {
				$rel = 'assets/js/tools/' . sanitize_file_name( $name ) . '.js';
				if ( is_readable( TN_DIR . '/' . $rel ) ) {
					wp_enqueue_script( 'tn-tool-' . $name, TN_URI . '/' . $rel, array( 'tn-site' ), tn_asset_ver( $rel ), array( 'strategy' => 'defer', 'in_footer' => true ) );
				}
			}
		}
	}
);

/** Favicons, unless a Site Icon was set in the Customizer. */
add_action(
	'wp_head',
	function () {
		if ( has_site_icon() ) {
			return;
		}
		$img = TN_URI . '/assets/img';
		echo '<link rel="icon" href="' . esc_url( $img . '/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
		echo '<link rel="icon" href="' . esc_url( $img . '/favicon-32.png' ) . '" sizes="32x32" type="image/png">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( $img . '/apple-touch-icon.png' ) . '">' . "\n";
		echo '<meta name="theme-color" content="#0f766e">' . "\n";
	},
	6
);
