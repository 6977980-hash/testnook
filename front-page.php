<?php
/**
 * Homepage: hero with search, all tests grouped by hub, short guide and FAQ.
 */

defined( 'ABSPATH' ) || exit;
$home = tn_home_def();
get_header();
?>
<main id="main" class="site-main">
	<div class="wrap">
		<section class="hero">
			<h1><?php echo esc_html( $home['h1'] ); ?></h1>
			<p class="lede"><?php echo esc_html( $home['intro'] ); ?></p>
			<div class="search" role="search">
				<?php echo tn_icon( 'search', 20 ); // phpcs:ignore ?>
				<label class="visually-hidden" for="tool-search">Search tests</label>
				<input id="tool-search" type="search" placeholder="Search tests, e.g. mic, keyboard, dead pixel" autocomplete="off">
			</div>
			<ul class="chips" aria-label="Test categories">
				<?php foreach ( tn_hubs() as $tn_slug => $tn_hub ) : ?>
					<li><a href="#<?php echo esc_attr( $tn_slug ); ?>"><?php echo tn_icon( $tn_hub['icon'], 16 ); // phpcs:ignore ?><?php echo esc_html( $tn_hub['name'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</section>

		<p id="search-empty" class="search-empty" hidden>No test matches that search yet. Try a shorter word such as "mouse" or "screen".</p>

		<?php foreach ( tn_hubs() as $tn_slug => $tn_hub ) : ?>
			<section class="hub-section" id="<?php echo esc_attr( $tn_slug ); ?>" aria-labelledby="h-<?php echo esc_attr( $tn_slug ); ?>">
				<h2 id="h-<?php echo esc_attr( $tn_slug ); ?>">
					<?php echo tn_icon( $tn_hub['icon'] ); // phpcs:ignore ?>
					<?php if ( tn_hub_is_live( $tn_slug ) ) : ?>
						<a href="<?php echo esc_url( tn_hub_url( $tn_slug ) ); ?>"><?php echo esc_html( $tn_hub['title'] ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $tn_hub['title'] ); ?>
					<?php endif; ?>
				</h2>
				<p class="hub-blurb"><?php echo esc_html( $tn_hub['blurb'] ); ?></p>
				<ul class="cards">
					<?php foreach ( tn_tools_in_hub( $tn_slug ) as $tool ) : ?>
						<li><?php tn_tool_card( $tool ); ?></li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endforeach; ?>

		<h2>Why use <?php echo esc_html( TN_SITE_NAME ); ?></h2>
		<div class="features">
			<?php foreach ( $home['features'] as $feature ) : ?>
				<div class="feature"><h3><?php echo esc_html( $feature[0] ); ?></h3><p><?php echo esc_html( $feature[1] ); ?></p></div>
			<?php endforeach; ?>
		</div>

		<div class="prose">
			<?php tn_ad_slot( 'in-content' ); ?>
			<?php tn_html( $home['body'] ); ?>
			<?php tn_faq( $home['faq'] ); ?>
		</div>
	</div>
</main>
<?php
get_footer();
