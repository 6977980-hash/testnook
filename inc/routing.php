<?php
/**
 * Sends theme-managed pages to the right template.
 */

defined( 'ABSPATH' ) || exit;

/** Definition of the page being viewed, or null. */
function tn_current_def() {
	static $def = false;
	if ( false === $def ) {
		$def = null;
		if ( is_page() ) {
			$key = get_post_meta( get_queried_object_id(), TN_META_KEY, true );
			if ( $key ) {
				$def = tn_get_def( $key );
			}
		}
	}
	return $def;
}

/** True when a tool page is requested in iframe embed mode (?embed=1). */
function tn_is_embed() {
	$def = tn_current_def();
	return $def && 'tool' === $def['type'] && isset( $_GET['embed'] ); // phpcs:ignore WordPress.Security.NonceVerification
}

add_filter(
	'template_include',
	function ( $template ) {
		$def = tn_current_def();
		if ( ! $def ) {
			return $template;
		}
		$map  = array( 'tool' => 'tool', 'hub' => 'hub', 'page' => 'static' );
		$file = tn_is_embed() ? 'embed' : $map[ $def['type'] ];
		return TN_DIR . '/templates/' . $file . '.php';
	}
);

/** Body classes for theme-managed pages. */
add_filter(
	'body_class',
	function ( $classes ) {
		$def = tn_current_def();
		if ( $def ) {
			$classes[] = 'tn-' . $def['type'];
			$classes[] = 'tn-' . $def['type'] . '-' . $def['slug'];
		}
		return $classes;
	}
);
