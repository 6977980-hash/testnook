<?php
/**
 * Theme supports and removal of WordPress front-end extras we do not use.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array( 'footer' => 'Footer extra links' ) );
	}
);

// Lighter <head>: no emoji script, generator tag, RSD/WLW links or shortlinks.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
add_filter( 'emoji_svg_url', '__return_false' );
// XML-RPC is not used: no logins and no methods at all (pingback included).
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

// Logged-out visitors cannot list users over the REST API (wp-admin still can).
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( ! is_user_logged_in() ) {
			unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\\d]+)'] );
		}
		return $endpoints;
	}
);

/*
 * There is no blog: author, date and attachment archives and feeds only show
 * "Nothing found" (and /?author=1 would reveal the login name), so send them
 * home. Priority 1 runs before redirect_canonical, which would otherwise
 * redirect /?author=1 to /author/<username>/.
 */
add_action(
	'template_redirect',
	function () {
		if ( is_author() || is_date() || is_attachment() || is_feed() ) {
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	},
	1
);

// Block editor styles are only needed on normal posts/pages written in the editor.
add_action(
	'wp_enqueue_scripts',
	function () {
		if ( is_front_page() || tn_current_def() || is_404() ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
		}
	},
	100
);

// No comments anywhere on this site.
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

// Leaner core sitemap: no user archives, no tag archives.
add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return 'users' === $name ? false : $provider;
	},
	10,
	2
);
add_filter(
	'wp_sitemaps_taxonomies',
	function ( $taxonomies ) {
		unset( $taxonomies['post_tag'], $taxonomies['post_format'] );
		return $taxonomies;
	}
);
// Embed-mode URLs and drafts never belong in the sitemap; theme pages are all published pages already.
