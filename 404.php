<?php
/**
 * Not found page with a way back to the tools.
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="main" class="site-main">
	<div class="wrap not-found">
		<p class="big">404</p>
		<h1>This page could not be found</h1>
		<p>The link may be old or mistyped. Every test is listed on the homepage.</p>
		<form class="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" style="margin:18px auto">
			<?php echo tn_icon( 'search', 20 ); // phpcs:ignore ?>
			<label class="visually-hidden" for="nf-q">Search tests</label>
			<input id="nf-q" type="search" name="q" placeholder="Search tests, e.g. mic, keyboard, dead pixel">
		</form>
		<ul class="chips" style="justify-content:center">
			<?php foreach ( tn_hubs() as $tn_slug => $tn_hub ) : ?>
				<li><a href="<?php echo esc_url( tn_hub_url( $tn_slug ) ); ?>"><?php echo tn_icon( $tn_hub['icon'], 16 ); // phpcs:ignore ?><?php echo esc_html( $tn_hub['name'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</main>
<?php
get_footer();
