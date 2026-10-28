<?php
/**
 * Site header.
 */

defined( 'ABSPATH' ) || exit;
$tn_current_hub = '';
$tn_def         = tn_current_def();
if ( $tn_def ) {
	$tn_current_hub = 'hub' === $tn_def['type'] ? $tn_def['slug'] : ( isset( $tn_def['hub'] ) ? $tn_def['hub'] : '' );
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
	<div class="wrap">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( TN_SITE_NAME ); ?> home">
			<?php get_template_part( 'templates/parts/logo-mark' ); ?>
			<span><?php echo esc_html( TN_SITE_NAME ); ?></span>
		</a>
		<button class="icon-btn nav-toggle" type="button" aria-controls="main-nav" aria-expanded="false" aria-label="Menu"><?php echo tn_icon( 'menu', 20 ); // phpcs:ignore ?></button>
		<nav class="main-nav" id="main-nav" aria-label="Main">
			<ul>
				<?php foreach ( tn_hubs() as $tn_slug => $tn_hub ) : ?>
					<li><a href="<?php echo esc_url( tn_hub_url( $tn_slug ) ); ?>"<?php echo $tn_slug === $tn_current_hub ? ' aria-current="true"' : ''; ?>><?php echo esc_html( $tn_hub['name'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<button class="icon-btn theme-toggle" type="button" aria-label="Switch light or dark mode">
			<span class="icon-sun"><?php echo tn_icon( 'sun', 18 ); // phpcs:ignore ?></span>
			<span class="icon-moon"><?php echo tn_icon( 'moon', 18 ); // phpcs:ignore ?></span>
		</button>
	</div>
</header>
