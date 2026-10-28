<?php
/**
 * Plain content page (About, Contact, Privacy, Terms) from content/pages/<slug>.php.
 */

defined( 'ABSPATH' ) || exit;
$def = tn_current_def();
get_header();
?>
<main id="main" class="site-main static-page">
	<div class="wrap">
		<?php tn_breadcrumbs( $def ); ?>
		<article class="prose">
			<h1><?php echo esc_html( $def['title'] ); ?></h1>
			<?php if ( ! empty( $def['updated'] ) ) : ?>
				<p class="updated">Last updated <time datetime="<?php echo esc_attr( $def['updated'] ); ?>"><?php echo esc_html( mysql2date( 'j F Y', $def['updated'] ) ); ?></time></p>
			<?php endif; ?>
			<?php tn_html( $def['body'] ); ?>
		</article>
	</div>
</main>
<?php
get_footer();
