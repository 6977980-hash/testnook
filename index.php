<?php
/**
 * Fallback for blog posts, archives and pages written in wp-admin.
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main">
	<div class="wrap">
		<div class="prose">
			<?php if ( have_posts() ) : ?>
				<?php if ( ! is_singular() ) : ?>
					<h1><?php echo esc_html( is_search() ? 'Search results' : wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
				<?php endif; ?>
				<?php
				while ( have_posts() ) :
					the_post();
					if ( is_singular() ) :
						?>
						<article <?php post_class(); ?>>
							<h1><?php the_title(); ?></h1>
							<?php the_content(); ?>
						</article>
					<?php else : ?>
						<article <?php post_class(); ?>>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php the_excerpt(); ?>
						</article>
						<?php
					endif;
				endwhile;
				the_posts_pagination();
				?>
			<?php else : ?>
				<h1>Nothing found</h1>
				<p>Try the <a href="<?php echo esc_url( home_url( '/' ) ); ?>">full list of tests</a>.</p>
			<?php endif; ?>
		</div>
	</div>
</main>
<?php
get_footer();
