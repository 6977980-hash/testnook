<?php
/**
 * /llms.txt: a plain-text map of the site for language models (llmstxt.org).
 *
 * Built from the registry on each request, so new tools, hubs, guides and pages
 * appear without editing this file. Linked from robots.txt (inc/seo.php).
 */

defined( 'ABSPATH' ) || exit;

/** One "- [Title](url): description" line. */
function tn_llms_line( $title, $slug, $description ) {
	$description = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $description ) ) );
	$line        = '- [' . wp_strip_all_tags( $title ) . '](' . home_url( '/' . $slug . '/' ) . ')';
	return $line . ( $description ? ': ' . $description : '' ) . "\n";
}

/** The whole llms.txt document. */
function tn_llms_txt() {
	$home = tn_home_def();
	$out  = '# ' . TN_SITE_NAME . "\n\n";
	$out .= '> ' . $home['description'] . "\n\n";
	$out .= 'Home: ' . home_url( '/' ) . "\n";
	$out .= 'Each tool page has the test itself, how to use it, what the result means, fixes for common problems and an FAQ. Guides explain results and walk through fixes. Hubs group the tools by device.' . "\n";

	$out .= "\n## Hubs\n\n";
	foreach ( array_keys( tn_hubs() ) as $hub ) {
		$def = tn_get_def( 'hub:' . $hub );
		if ( $def ) {
			$out .= tn_llms_line( $def['title'], $hub, $def['description'] );
		}
	}

	// Tools grouped by their primary hub, in catalog order inside each hub.
	$out .= "\n## Tools\n\n";
	foreach ( array_keys( tn_hubs() ) as $hub ) {
		foreach ( tn_tools() as $slug => $tool ) {
			if ( $tool['live'] && $tool['hub'] === $hub ) {
				$def  = tn_get_def( 'tool:' . $slug );
				$out .= tn_llms_line( $def['name'], $slug, $def['description'] );
			}
		}
	}

	$out .= "\n## Guides\n\n";
	foreach ( tn_guides() as $slug => $def ) {
		$out .= tn_llms_line( $def['title'], $slug, $def['description'] );
	}

	$out .= "\n## Pages\n\n";
	foreach ( glob( TN_DIR . '/content/pages/*.php' ) as $file ) {
		$slug = basename( $file, '.php' );
		$def  = tn_get_def( 'page:' . $slug );
		if ( $def ) {
			$out .= tn_llms_line( $def['title'], $slug, isset( $def['description'] ) ? $def['description'] : '' );
		}
	}
	return $out;
}

/** Serve /llms.txt (same pattern as /ads.txt in inc/ads.php). */
add_action(
	'parse_request',
	function () {
		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) : '';
		if ( '/llms.txt' === $path ) {
			header( 'Content-Type: text/plain; charset=utf-8' );
			header( 'X-Robots-Tag: noindex' );
			echo tn_llms_txt(); // phpcs:ignore WordPress.Security.EscapeOutput -- plain text built from theme content.
			exit;
		}
	},
	0
);
