<?php
/**
 * Keeps WordPress pages in step with the files in content/.
 *
 * Every time the content files change (a deploy updates their mtimes), the next
 * request creates missing pages, updates titles/slugs, and drafts pages whose
 * content file was removed. Pages are linked to content by the _tn_key meta.
 * Page bodies are rendered from the theme at request time, so editing a page in
 * wp-admin does not change what visitors see: edit the content file instead.
 */

defined( 'ABSPATH' ) || exit;

const TN_META_KEY = '_tn_key';

function tn_content_signature() {
	$parts = array( TN_VERSION );
	foreach ( tn_content_files() as $file ) {
		$parts[] = basename( dirname( $file ) ) . '/' . basename( $file ) . ':' . filesize( $file ) . ':' . filemtime( $file );
	}
	return md5( implode( '|', $parts ) );
}

function tn_maybe_sync() {
	$sig = tn_content_signature();
	if ( get_option( 'tn_sync_sig' ) === $sig || get_transient( 'tn_sync_lock' ) ) {
		return;
	}
	set_transient( 'tn_sync_lock', 1, 60 );
	tn_sync_pages();
	update_option( 'tn_sync_sig', $sig, true );
	delete_transient( 'tn_sync_lock' );
}
add_action( 'init', 'tn_maybe_sync', 20 );

/** Map of _tn_key => WP_Post for every page the theme manages. */
function tn_managed_pages() {
	$map   = array();
	$pages = get_posts(
		array(
			'post_type'        => 'page',
			'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'meta_key'         => TN_META_KEY, // phpcs:ignore WordPress.DB.SlowDBQuery
			'numberposts'      => -1,
			'suppress_filters' => true,
		)
	);
	foreach ( $pages as $page ) {
		$map[ get_post_meta( $page->ID, TN_META_KEY, true ) ] = $page;
	}
	return $map;
}

function tn_sync_pages() {
	$managed = tn_managed_pages();
	$keys    = tn_all_keys();
	$created = array();
	$drafted = array();

	foreach ( $keys as $key ) {
		$def = tn_get_def( $key );
		if ( ! $def ) {
			continue;
		}
		$data = array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'post_title'     => isset( $def['page_title'] ) ? $def['page_title'] : ( isset( $def['name'] ) ? $def['name'] : $def['title'] ),
			'post_name'      => $def['slug'],
			'post_parent'    => 0,
			'post_excerpt'   => isset( $def['description'] ) ? $def['description'] : '',
			'post_content'   => wp_strip_all_tags( isset( $def['intro'] ) ? $def['intro'] : ( isset( $def['description'] ) ? $def['description'] : '' ) ),
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
		);

		$page = isset( $managed[ $key ] ) ? $managed[ $key ] : null;
		if ( ! $page ) {
			// Adopt a page that already uses the slug (e.g. WordPress's draft Privacy Policy).
			$page = get_page_by_path( $def['slug'], OBJECT, 'page' );
		}

		if ( $page ) {
			$data['ID'] = $page->ID;
			$changed    = false;
			foreach ( array( 'post_status', 'post_title', 'post_name', 'post_parent', 'post_excerpt', 'post_content' ) as $field ) {
				if ( (string) $page->$field !== (string) $data[ $field ] ) {
					$changed = true;
				}
			}
			$id = $changed ? wp_update_post( wp_slash( $data ), true ) : $page->ID;
		} else {
			$id        = wp_insert_post( wp_slash( $data ), true );
			$created[] = $key;
		}

		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		update_post_meta( $id, TN_META_KEY, $key );
		if ( 'page:privacy-policy' === $key ) {
			update_option( 'wp_page_for_privacy_policy', $id );
		}
		unset( $managed[ $key ] );
	}

	// Content file removed: keep the page but take it offline.
	foreach ( $managed as $key => $page ) {
		if ( 'publish' === $page->post_status ) {
			wp_update_post( array( 'ID' => $page->ID, 'post_status' => 'draft' ) );
			$drafted[] = $key;
		}
	}

	/**
	 * Fires after the pages match the content files (inc/indexnow.php listens).
	 *
	 * @param string[] $created Page keys that were just created.
	 * @param string[] $drafted Page keys that were just taken offline.
	 */
	do_action( 'tn_after_sync', $created, $drafted );
}

/**
 * One-time setup when the theme is activated: pretty permalinks (only if the
 * site still uses plain ?p= links), comments off, and the untouched WordPress
 * sample post/page moved to the trash.
 */
function tn_on_activate() {
	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );

	foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $type ) {
		$post = get_page_by_path( $slug, OBJECT, $type );
		if ( $post && $post->post_modified === $post->post_date ) {
			wp_trash_post( $post->ID );
		}
	}

	delete_option( 'tn_sync_sig' );
	tn_sync_pages();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'tn_on_activate' );
