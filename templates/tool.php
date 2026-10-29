<?php
/**
 * Tool page: H1, the tool above the fold, then How to use, results,
 * fixes, FAQ, related tools and the embed code.
 * Content comes from content/tools/<slug>.php (see docs/content-format.md).
 */

defined( 'ABSPATH' ) || exit;
$def = tn_current_def();
get_header();
?>
<main id="main" class="site-main">
	<div class="wrap">
		<?php tn_breadcrumbs( $def ); ?>
		<article class="tool-page">
			<header class="page-head">
				<h1><?php echo esc_html( $def['title'] ); ?></h1>
				<?php if ( ! empty( $def['intro'] ) ) : ?>
					<p class="lede"><?php tn_html( $def['intro'] ); ?></p>
				<?php endif; ?>
				<ul class="trust">
					<li><?php echo tn_icon( 'shield', 16 ); // phpcs:ignore ?>Runs in your browser</li>
					<li><?php echo tn_icon( 'shield', 16 ); // phpcs:ignore ?><?php echo $def['stats'] ? 'Only your score is shared, anonymously' : 'Nothing is uploaded'; ?></li>
					<li><?php echo tn_icon( 'shield', 16 ); // phpcs:ignore ?>Free, no sign-up</li>
				</ul>
			</header>

			<?php if ( 'any' !== $def['device'] ) : ?>
				<div id="device-note" class="device-note" data-device="<?php echo esc_attr( $def['device'] ); ?>" hidden>
					<?php echo tn_icon( 'info', 18 ); // phpcs:ignore ?>
					<div><?php tn_html( ! empty( $def['device_message'] ) ? $def['device_message'] : 'This test may not work on this device.' ); ?></div>
				</div>
			<?php endif; ?>

			<section class="tool" id="tool" data-tool="<?php echo esc_attr( $def['slug'] ); ?>" aria-label="<?php echo esc_attr( $def['name'] ); ?>">
				<?php tn_html( isset( $def['tool'] ) ? $def['tool'] : '' ); ?>
				<noscript><p class="notice notice--warn">This tool needs JavaScript. Please enable it in your browser settings.</p></noscript>
				<?php if ( $def['stats'] ) : ?>
					<p class="share-line" data-tn-share-line hidden></p>
					<?php tn_leaderboard_claim( $def ); ?>
				<?php endif; ?>
			</section>
			<?php if ( $def['stats'] ) : ?>
				<p class="share-note" data-tn-share-note>
					<span data-tn-share-on>Your score is shared anonymously to build the site averages (<a href="<?php echo esc_url( home_url( '/privacy-policy/#results' ) ); ?>">what is stored</a>). <button type="button" class="link-btn" data-tn-share-set="off">Turn off</button></span>
					<span data-tn-share-off hidden>Score sharing is off for this browser. <button type="button" class="link-btn" data-tn-share-set="on">Turn on</button></span>
				</p>
			<?php endif; ?>

			<?php tn_leaderboard_section( $def ); ?>

			<?php tn_ad_slot( 'below-tool' ); ?>

			<div class="prose">
				<?php if ( $def['howto'] ) : ?>
					<section id="how-to-use">
						<h2><?php echo esc_html( isset( $def['howto_title'] ) ? $def['howto_title'] : 'How to use the ' . $def['name'] ); ?></h2>
						<ol>
							<?php foreach ( $def['howto'] as $step ) : ?>
								<li><?php tn_html( $step ); ?></li>
							<?php endforeach; ?>
						</ol>
					</section>
				<?php endif; ?>

				<?php if ( ! empty( $def['results'] ) ) : ?>
					<section id="results">
						<h2><?php echo esc_html( isset( $def['results_title'] ) ? $def['results_title'] : 'What the results mean' ); ?></h2>
						<?php tn_html( $def['results'] ); ?>
					</section>
				<?php endif; ?>

				<?php tn_stats_block( $def['stats'] ); ?>

				<?php tn_ad_slot( 'in-content' ); ?>

				<?php foreach ( $def['extra'] as $i => $section ) : ?>
					<section id="<?php echo esc_attr( isset( $section[2] ) ? $section[2] : 'more-' . ( $i + 1 ) ); ?>">
						<h2><?php echo esc_html( $section[0] ); ?></h2>
						<?php tn_html( $section[1] ); ?>
					</section>
				<?php endforeach; ?>

				<?php if ( $def['fixes'] ) : ?>
					<section id="fixes">
						<h2><?php echo esc_html( isset( $def['fixes_title'] ) ? $def['fixes_title'] : 'Common problems and fixes' ); ?></h2>
						<?php foreach ( $def['fixes'] as $fix ) : ?>
							<h3><?php echo esc_html( $fix[0] ); ?></h3>
							<?php tn_html( wpautop( $fix[1] ) ); ?>
						<?php endforeach; ?>
					</section>
				<?php endif; ?>

				<?php tn_faq( $def['faq'] ); ?>

				<?php if ( ! empty( $def['disclaimer'] ) ) : ?>
					<p class="notice notice--warn"><?php tn_html( $def['disclaimer'] ); ?></p>
				<?php endif; ?>

				<?php tn_ad_slot( 'after-faq' ); ?>
			</div>

			<?php tn_guides_section( tn_guides_for_tool( $def['slug'] ), 'Guides for this test' ); ?>

			<?php $related = tn_related_tools( $def ); ?>
			<?php if ( $related ) : ?>
				<section class="related" aria-labelledby="related-title">
					<h2 id="related-title">Related tools</h2>
					<ul class="cards">
						<?php foreach ( $related as $tool ) : ?>
							<li><?php tn_tool_card( $tool ); ?></li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<?php
			$embed_url    = add_query_arg( 'embed', '1', tn_tool_url( $def['slug'] ) );
			$embed_height = isset( $def['embed_height'] ) ? (int) $def['embed_height'] : 620;
			$embed_code   = tn_embed_code( $def, '100%', $embed_height, '' );
			?>
			<details class="embed-box" data-embed-src="<?php echo esc_url( $embed_url ); ?>" data-embed-url="<?php echo esc_url( tn_tool_url( $def['slug'] ) ); ?>" data-embed-title="<?php echo esc_attr( $def['name'] ); ?>" data-embed-site="<?php echo esc_attr( TN_SITE_NAME ); ?>">
				<summary><?php echo tn_icon( 'code', 18 ); // phpcs:ignore ?>Embed this <?php echo esc_html( strtolower( $def['name'] ) ); ?> on your site</summary>
				<p>Free for any site. Copy the code into your page; the tool runs inside the frame without ads. Please keep the credit link under it. <a href="<?php echo esc_url( home_url( '/embed-tools/' ) ); ?>">All embeddable tools</a>.</p>
				<div class="embed-opts">
					<label>Width <select name="embed-w"><option value="100%">Full width</option><option value="800">800 px</option><option value="600">600 px</option><option value="400">400 px</option></select></label>
					<label>Height <input type="number" name="embed-h" min="300" max="1400" step="10" value="<?php echo esc_attr( $embed_height ); ?>"> px</label>
					<label>Theme <select name="embed-theme"><option value="">Visitor's choice</option><option value="light">Light</option><option value="dark">Dark</option></select></label>
				</div>
				<label class="visually-hidden" for="embed-code">Embed code</label>
				<textarea id="embed-code" readonly rows="4"><?php echo esc_textarea( $embed_code ); ?></textarea>
				<button class="btn btn-sm" type="button" data-tn-copy="#embed-code">Copy code</button>
				<iframe id="embed-preview" class="embed-preview" title="Preview of the embedded <?php echo esc_attr( strtolower( $def['name'] ) ); ?>" hidden loading="lazy"></iframe>
			</details>

			<?php if ( ! empty( $def['updated'] ) ) : ?>
				<p class="updated">Last updated <time datetime="<?php echo esc_attr( $def['updated'] ); ?>"><?php echo esc_html( mysql2date( 'j F Y', $def['updated'] ) ); ?></time></p>
			<?php endif; ?>
		</article>
	</div>
</main>
<?php
get_footer();
