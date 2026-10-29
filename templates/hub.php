<?php
/**
 * Hub page: intro, every tool in the hub (live and coming soon), guide text, FAQ.
 * Content comes from content/hubs/<slug>.php.
 */

defined( 'ABSPATH' ) || exit;
$def = tn_current_def();
get_header();
?>
<main id="main" class="site-main">
	<div class="wrap">
		<?php tn_breadcrumbs( $def ); ?>
		<header class="page-head">
			<h1><?php echo esc_html( $def['title'] ); ?></h1>
			<?php if ( ! empty( $def['intro'] ) ) : ?>
				<p class="lede"><?php tn_html( $def['intro'] ); ?></p>
			<?php endif; ?>
		</header>
		<ul class="cards">
			<?php foreach ( tn_tools_in_hub( $def['slug'] ) as $tool ) : ?>
				<li><?php tn_tool_card( $tool ); ?></li>
			<?php endforeach; ?>
		</ul>
		<div class="prose">
			<?php tn_ad_slot( 'in-content' ); ?>
			<?php
			if ( ! empty( $def['body'] ) ) {
				tn_html( $def['body'] );
			}
			tn_faq( $def['faq'] );
			tn_ad_slot( 'after-faq' );
			?>
		</div>
		<?php tn_guides_section( tn_guides_in_hub( $def['slug'] ), 'Guides' ); ?>
		<?php if ( ! empty( $def['updated'] ) ) : ?>
			<p class="updated">Last updated <time datetime="<?php echo esc_attr( $def['updated'] ); ?>"><?php echo esc_html( mysql2date( 'j F Y', $def['updated'] ) ); ?></time></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
