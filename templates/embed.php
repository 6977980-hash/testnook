<?php
/**
 * Tool in iframe embed mode (?embed=1): only the tool and a credit link. Not indexed.
 */

defined( 'ABSPATH' ) || exit;
$def = tn_current_def();
?><!doctype html>
<html <?php language_attributes(); ?> class="tn-embed">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<base target="_blank">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'tn-embed' ); ?>>
<main id="main" class="embed-main">
	<section class="tool" id="tool" data-tool="<?php echo esc_attr( $def['slug'] ); ?>" aria-label="<?php echo esc_attr( $def['name'] ); ?>">
		<?php tn_html( isset( $def['tool'] ) ? $def['tool'] : '' ); ?>
	</section>
	<p class="embed-credit"><a href="<?php echo esc_url( tn_tool_url( $def['slug'] ) ); ?>"><?php echo esc_html( $def['name'] ); ?></a> by <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( TN_SITE_NAME ); ?></a></p>
</main>
<?php wp_footer(); ?>
</body>
</html>
