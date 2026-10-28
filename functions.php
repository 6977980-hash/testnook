<?php
/**
 * Testnook theme bootstrap.
 *
 * Pages for tools, hubs and legal pages are defined as PHP files under content/
 * and synced into WordPress pages automatically (see inc/sync.php).
 */

defined( 'ABSPATH' ) || exit;

define( 'TN_VERSION', '0.2.0' );
define( 'TN_DIR', get_template_directory() );
define( 'TN_URI', get_template_directory_uri() );

require TN_DIR . '/inc/config.php';
require TN_DIR . '/inc/icons.php';
require TN_DIR . '/inc/registry.php';
require TN_DIR . '/inc/setup.php';
require TN_DIR . '/inc/sync.php';
require TN_DIR . '/inc/routing.php';
require TN_DIR . '/inc/assets.php';
require TN_DIR . '/inc/seo.php';
require TN_DIR . '/inc/ads.php';
require TN_DIR . '/inc/indexnow.php';
require TN_DIR . '/inc/helpers.php';
