<?php
/**
 * IndexNow: serves the key file and pings Bing/Yandex/Seznam/Naver (they share
 * one endpoint) when a page is created, changed or taken offline.
 *
 * The key lives in inc/config.php (TN_INDEXNOW_KEY). It is public by design:
 * the engines fetch /<key>.txt to verify the site. Pings only go out from the
 * production site (wp_get_environment_type() === 'production') so local and
 * staging copies never submit their URLs.
 *
 * Which URLs are pinged: after every content sync (inc/sync.php) the hash of
 * each content file is compared with the last pinged hash; changed files, new
 * pages and drafted pages are submitted, plus the homepage when the catalog
 * changes. Admins can also force a full submission by opening
 * /wp-admin/?tn_indexnow=all.
 */

defined( 'ABSPATH' ) || exit;

const TN_INDEXNOW_ENDPOINT = 'https://api.indexnow.org/indexnow';

function tn_indexnow_enabled() {
	return (bool) preg_match( '/^[a-f0-9]{32}$/i', TN_INDEXNOW_KEY );
}

function tn_indexnow_key_url() {
	return home_url( '/' . TN_INDEXNOW_KEY . '.txt' );
}

/** Serve /<key>.txt (WordPress routes unknown paths to index.php). */
add_action(
	'parse_request',
	function () {
		if ( ! tn_indexnow_enabled() ) {
			return;
		}
		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) : '';
		if ( '/' . TN_INDEXNOW_KEY . '.txt' === $path ) {
			header( 'Content-Type: text/plain; charset=utf-8' );
			header( 'X-Robots-Tag: noindex' );
			echo esc_html( TN_INDEXNOW_KEY );
			exit;
		}
	},
	0
);

/**
 * Submit a list of URLs. Returns true when a request was sent.
 *
 * @param string[] $urls Absolute URLs on this site (max 10,000 per call).
 */
function tn_indexnow_ping( array $urls ) {
	$urls = array_values( array_unique( array_filter( $urls ) ) );
	if ( ! $urls || ! tn_indexnow_enabled() ) {
		return false;
	}
	if ( 'production' !== wp_get_environment_type() || ! apply_filters( 'tn_indexnow_send', true, $urls ) ) {
		return false;
	}
	$host = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
	$body = array(
		'host'        => $host,
		'key'         => TN_INDEXNOW_KEY,
		'keyLocation' => tn_indexnow_key_url(),
		'urlList'     => array_slice( $urls, 0, 10000 ),
	);
	$response = wp_remote_post(
		TN_INDEXNOW_ENDPOINT,
		array(
			'headers'  => array( 'Content-Type' => 'application/json; charset=utf-8' ),
			'body'     => wp_json_encode( $body ),
			'timeout'  => 5,
			'blocking' => false,
		)
	);
	update_option(
		'tn_indexnow_last',
		array(
			'time'  => time(),
			'count' => count( $urls ),
			'error' => is_wp_error( $response ) ? $response->get_error_message() : '',
		),
		false
	);
	return ! is_wp_error( $response );
}

/** Every public URL the theme manages, homepage first. */
function tn_indexnow_all_urls() {
	$urls = array( home_url( '/' ) );
	foreach ( tn_all_keys() as $key ) {
		$def = tn_get_def( $key );
		if ( $def ) {
			$urls[] = home_url( '/' . $def['slug'] . '/' );
		}
	}
	return $urls;
}

/**
 * After a content sync: ping URLs whose content file changed since the last
 * ping, plus pages that were just created or drafted.
 *
 * @param string[] $created Keys of pages inserted by the sync.
 * @param string[] $drafted Keys of pages drafted by the sync.
 */
function tn_indexnow_after_sync( $created, $drafted ) {
	if ( ! tn_indexnow_enabled() ) {
		return;
	}
	$old    = (array) get_option( 'tn_indexnow_hashes', array() );
	$new    = array();
	$urls   = array();
	$by_key = array();

	foreach ( tn_content_files() as $file ) {
		$rel         = basename( dirname( $file ) ) . '/' . basename( $file );
		$new[ $rel ] = md5_file( $file );
		if ( isset( $old[ $rel ] ) && $old[ $rel ] === $new[ $rel ] ) {
			continue;
		}
		if ( 'content/catalog.php' === $rel ) {
			$urls[] = home_url( '/' );
			continue;
		}
		$slug = basename( $file, '.php' );
		if ( '_' === $slug[0] ) {
			continue; // shared markup helper, not a page
		}
		$urls[] = home_url( '/' . $slug . '/' );
	}

	foreach ( array_merge( (array) $created, (array) $drafted ) as $key ) {
		list( , $slug ) = array_pad( explode( ':', $key, 2 ), 2, '' );
		if ( $slug ) {
			$urls[] = home_url( '/' . $slug . '/' );
		}
	}
	if ( $created ) {
		$urls[] = home_url( '/' ); // the homepage and hubs list the new page
	}

	// First run on a fresh install: submit the whole site once.
	if ( ! $old ) {
		$urls = tn_indexnow_all_urls();
	}

	update_option( 'tn_indexnow_hashes', $new, false );
	tn_indexnow_ping( $urls );
}
add_action( 'tn_after_sync', 'tn_indexnow_after_sync', 10, 2 );

/** /wp-admin/?tn_indexnow=all resubmits every page (admins only). */
add_action(
	'admin_init',
	function () {
		if ( ! isset( $_GET['tn_indexnow'] ) || ! current_user_can( 'manage_options' ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}
		$sent = tn_indexnow_ping( tn_indexnow_all_urls() );
		add_action(
			'admin_notices',
			function () use ( $sent ) {
				$msg = $sent ? 'IndexNow: every page was submitted.' : 'IndexNow: nothing sent (key missing, or this is not the production site).';
				echo '<div class="notice notice-' . ( $sent ? 'success' : 'warning' ) . '"><p>' . esc_html( $msg ) . '</p></div>';
			}
		);
	}
);
