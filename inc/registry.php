<?php
/**
 * Registry: reads content/ and answers "which pages exist and what is on them".
 *
 * Page keys:
 *   tool:<slug>  content/tools/<slug>.php  (must also be listed in content/catalog.php)
 *   hub:<slug>   content/hubs/<slug>.php   (slug must be a hub in content/catalog.php)
 *   page:<slug>  content/pages/<slug>.php  (About, Privacy, Contact, Terms...)
 */

defined( 'ABSPATH' ) || exit;

/** The catalog of hubs and planned tools. */
function tn_catalog() {
	static $catalog = null;
	if ( null === $catalog ) {
		$catalog = require TN_DIR . '/content/catalog.php';
	}
	return $catalog;
}

function tn_hubs() {
	return tn_catalog()['hubs'];
}

/** True when a tool has a content file and is therefore published. */
function tn_tool_is_live( $slug ) {
	return isset( tn_catalog()['tools'][ $slug ] ) && is_readable( TN_DIR . '/content/tools/' . $slug . '.php' );
}

function tn_hub_is_live( $slug ) {
	return isset( tn_hubs()[ $slug ] ) && is_readable( TN_DIR . '/content/hubs/' . $slug . '.php' );
}

/**
 * All catalog tools with a 'live' flag, in launch order.
 *
 * @return array slug => catalog entry + slug + live.
 */
function tn_tools() {
	$out = array();
	foreach ( tn_catalog()['tools'] as $slug => $tool ) {
		$tool['slug'] = $slug;
		$tool['live'] = tn_tool_is_live( $slug );
		$out[ $slug ] = $tool;
	}
	return $out;
}

/** Tools listed in a hub (primary hub first, then tools that list it in 'also'). */
function tn_tools_in_hub( $hub ) {
	$primary = array();
	$extra   = array();
	foreach ( tn_tools() as $slug => $tool ) {
		if ( $tool['hub'] === $hub ) {
			$primary[ $slug ] = $tool;
		} elseif ( in_array( $hub, $tool['also'], true ) ) {
			$extra[ $slug ] = $tool;
		}
	}
	return $primary + $extra;
}

/**
 * Full definition for a page key, or null when it does not exist.
 * Content files return arrays; see docs/content-format.md for the fields.
 */
function tn_get_def( $key ) {
	static $cache = array();
	if ( array_key_exists( $key, $cache ) ) {
		return $cache[ $key ];
	}
	$def = null;
	list( $type, $slug ) = array_pad( explode( ':', $key, 2 ), 2, '' );

	if ( 'tool' === $type && tn_tool_is_live( $slug ) ) {
		$def = array_merge(
			tn_catalog()['tools'][ $slug ],
			array(
				'device'  => 'any',
				'ads'     => 'standard',
				'scripts' => array(),
				'styles'  => array(),
				'related' => array(),
				'extra'   => array(),
				'faq'     => array(),
				'fixes'   => array(),
				'howto'   => array(),
			),
			(array) require TN_DIR . '/content/tools/' . $slug . '.php'
		);
	} elseif ( 'hub' === $type && tn_hub_is_live( $slug ) ) {
		$def = array_merge(
			tn_hubs()[ $slug ],
			array( 'faq' => array(), 'ads' => 'standard' ),
			(array) require TN_DIR . '/content/hubs/' . $slug . '.php'
		);
	} elseif ( 'page' === $type && preg_match( '/^[a-z0-9-]+$/', $slug ) && is_readable( TN_DIR . '/content/pages/' . $slug . '.php' ) ) {
		$def = array_merge( array( 'ads' => 'none' ), (array) require TN_DIR . '/content/pages/' . $slug . '.php' );
	}

	if ( $def ) {
		$def['type'] = $type;
		$def['slug'] = $slug;
		$def['key']  = $key;
	}
	$cache[ $key ] = $def;
	return $def;
}

/** Every page key that should exist as a WordPress page right now. */
function tn_all_keys() {
	$keys = array();
	foreach ( tn_tools() as $slug => $tool ) {
		if ( $tool['live'] ) {
			$keys[] = 'tool:' . $slug;
		}
	}
	foreach ( array_keys( tn_hubs() ) as $slug ) {
		if ( tn_hub_is_live( $slug ) ) {
			$keys[] = 'hub:' . $slug;
		}
	}
	foreach ( glob( TN_DIR . '/content/pages/*.php' ) as $file ) {
		$keys[] = 'page:' . basename( $file, '.php' );
	}
	return $keys;
}

/** Files whose changes should trigger a page sync. */
function tn_content_files() {
	return array_merge(
		array( TN_DIR . '/content/catalog.php' ),
		glob( TN_DIR . '/content/tools/*.php' ),
		glob( TN_DIR . '/content/hubs/*.php' ),
		glob( TN_DIR . '/content/pages/*.php' )
	);
}
