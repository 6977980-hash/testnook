<?php
/**
 * Guide page: H1, byline, short answer, the tool to try, contents, the
 * article sections (with the live site numbers when there are enough), FAQ,
 * sources, more guides and related tools.
 * Content comes from content/guides/<slug>.php (see docs/content-format.md).
 */

defined( 'ABSPATH' ) || exit;
$def      = tn_current_def();
$tools    = tn_tools();
$main     = isset( $tools[ $def['tool'] ] ) && $tools[ $def['tool'] ]['live'] ? $tools[ $def['tool'] ] : null;
$data     = $def['data'] ? tn_guide_data_html( $def['data']['html'] ) : '';
$after    = $data && ! empty( $def['data']['after'] ) ? $def['data']['after'] : '';
$toc      = array();
foreach ( $def['sections'] as $section ) {
	$toc[] = array( $section[2], $section[0] );
	if ( $after && $after === $section[2] ) {
		$toc[] = array( 'site-data', $def['data']['title'] );
	}
}
if ( $def['faq'] ) {
	$toc[] = array( 'faq', 'FAQ' );
}
get_header();
?>
<main id="main" class="site-main">
	<div class="wrap">
		<?php tn_breadcrumbs( $def ); ?>
		<article class="guide-page">
			<header class="page-head">
				<h1><?php echo esc_html( $def['title'] ); ?></h1>
				<?php if ( $def['intro'] ) : ?>
					<p class="lede"><?php tn_html( $def['intro'] ); ?></p>
				<?php endif; ?>
				<p class="byline">
					By <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html( TN_FOUNDER_NAME ); ?></a>
					<span aria-hidden="true">&middot;</span>
					Updated <time datetime="<?php echo esc_attr( $def['updated'] ); ?>"><?php echo esc_html( mysql2date( 'j F Y', $def['updated'] ) ); ?></time>
					<span aria-hidden="true">&middot;</span>
					<?php echo esc_html( tn_guide_minutes( $def ) ); ?> min read
				</p>
			</header>

			<div class="guide-top">
				<?php if ( $def['summary'] ) : ?>
					<div class="takeaways">
						<h2>The short answer</h2>
						<ul>
							<?php foreach ( $def['summary'] as $point ) : ?>
								<li><?php tn_html( $point ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				<?php if ( $main ) : ?>
					<div class="guide-cta">
						<p class="guide-cta__label">Try it in your browser</p>
						<?php tn_tool_card( $main ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( count( $toc ) > 2 ) : ?>
				<nav class="toc" aria-labelledby="toc-title">
					<h2 id="toc-title">On this page</h2>
					<ol>
						<?php foreach ( $toc as $item ) : ?>
							<li><a href="#<?php echo esc_attr( $item[0] ); ?>"><?php echo esc_html( $item[1] ); ?></a></li>
						<?php endforeach; ?>
					</ol>
				</nav>
			<?php endif; ?>

			<div class="prose">
				<?php foreach ( $def['sections'] as $i => $section ) : ?>
					<section id="<?php echo esc_attr( $section[2] ); ?>">
						<h2><?php echo esc_html( $section[0] ); ?></h2>
						<?php tn_html( $section[1] ); ?>
					</section>
					<?php
					if ( $after && $after === $section[2] ) {
						tn_stats_block( $def['data']['boards'], $def['data']['title'], $data, 'site-data' );
					}
					if ( 1 === $i ) {
						tn_ad_slot( 'in-content' );
					}
					?>
				<?php endforeach; ?>

				<?php tn_faq( $def['faq'] ); ?>

				<?php if ( $def['sources'] ) : ?>
					<section id="sources" class="sources">
						<h2>Sources</h2>
						<ol>
							<?php foreach ( $def['sources'] as $source ) : ?>
								<li><a href="<?php echo esc_url( $source[1] ); ?>" rel="noopener"><?php echo esc_html( $source[0] ); ?></a></li>
							<?php endforeach; ?>
						</ol>
					</section>
				<?php endif; ?>

				<?php if ( ! empty( $def['disclaimer'] ) ) : ?>
					<p class="notice notice--warn"><?php tn_html( $def['disclaimer'] ); ?></p>
				<?php endif; ?>

				<?php tn_ad_slot( 'after-faq' ); ?>
			</div>

			<?php
			$more = tn_guides_in_hub( $def['hub'] );
			foreach ( tn_guides() as $slug => $guide ) {
				if ( count( $more ) >= 7 ) {
					break;
				}
				$more += array( $slug => $guide );
			}
			unset( $more[ $def['slug'] ] );
			tn_guides_section( array_slice( $more, 0, 6, true ), 'More guides', 'more-guides' );

			$related = tn_related_tools(
				array(
					'slug'    => $def['slug'],
					'hub'     => $def['hub'],
					'related' => array_merge( array( $def['tool'] ), $def['tools'] ),
				),
				6
			);
			?>
			<?php if ( $related ) : ?>
				<section class="related" aria-labelledby="related-title">
					<h2 id="related-title">Tools from this guide</h2>
					<ul class="cards">
						<?php foreach ( $related as $tool ) : ?>
							<li><?php tn_tool_card( $tool ); ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>
		</article>
	</div>
</main>
<?php
get_footer();
