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
					<li><?php echo tn_icon( 'shield', 16 ); // phpcs:ignore ?>Nothing is uploaded</li>
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
			</section>

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
			$embed_url  = add_query_arg( 'embed', '1', tn_tool_url( $def['slug'] ) );
			$embed_code = sprintf(
				'<iframe src="%1$s" width="100%%" height="%2$d" style="border:0;max-width:100%%" title="%3$s" allow="camera; microphone; gamepad; fullscreen; autoplay" loading="lazy"></iframe>' . "\n" . '<p><a href="%4$s">%3$s</a> by %5$s</p>',
				esc_url( $embed_url ),
				isset( $def['embed_height'] ) ? (int) $def['embed_height'] : 620,
				esc_html( $def['name'] ),
				esc_url( tn_tool_url( $def['slug'] ) ),
				esc_html( TN_SITE_NAME )
			);
			?>
			<details class="embed-box">
				<summary><?php echo tn_icon( 'code', 18 ); // phpcs:ignore ?>Embed this <?php echo esc_html( strtolower( $def['name'] ) ); ?> on your site</summary>
				<p>Copy this code into your page. The tool runs inside the frame and stays free to use.</p>
				<label class="visually-hidden" for="embed-code">Embed code</label>
				<textarea id="embed-code" readonly rows="4"><?php echo esc_textarea( $embed_code ); ?></textarea>
				<button class="btn btn-sm" type="button" data-tn-copy="#embed-code">Copy code</button>
			</details>

			<?php if ( ! empty( $def['updated'] ) ) : ?>
				<p class="updated">Last updated <time datetime="<?php echo esc_attr( $def['updated'] ); ?>"><?php echo esc_html( mysql2date( 'j F Y', $def['updated'] ) ); ?></time></p>
			<?php endif; ?>
		</article>
	</div>
</main>
<?php
get_footer();
