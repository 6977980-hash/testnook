<?php
/**
 * Site footer.
 */

defined( 'ABSPATH' ) || exit;
$tn_hub_list = array_keys( tn_hubs() );
?>
<footer class="site-footer">
	<div class="wrap">
		<div class="footer-grid">
			<div class="footer-about">
				<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'templates/parts/logo-mark' ); ?><span><?php echo esc_html( TN_SITE_NAME ); ?></span></a>
				<p>Free hardware tests that run in your browser. Your camera, microphone and inputs are processed on your own device and never uploaded.</p>
			</div>
			<div>
				<h2>Tests</h2>
				<ul>
					<?php foreach ( array_slice( $tn_hub_list, 0, 4 ) as $tn_slug ) : ?>
						<li><a href="<?php echo esc_url( tn_hub_url( $tn_slug ) ); ?>"><?php echo esc_html( tn_hubs()[ $tn_slug ]['title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<h2>More tests</h2>
				<ul>
					<?php foreach ( array_slice( $tn_hub_list, 4 ) as $tn_slug ) : ?>
						<li><a href="<?php echo esc_url( tn_hub_url( $tn_slug ) ); ?>"><?php echo esc_html( tn_hubs()[ $tn_slug ]['title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div>
				<h2><?php echo esc_html( TN_SITE_NAME ); ?></h2>
				<ul>
					<?php
					foreach ( array( 'about' => 'About', 'contact' => 'Contact', 'privacy-policy' => 'Privacy Policy', 'terms' => 'Terms of Use' ) as $tn_slug => $tn_label ) :
						if ( tn_get_def( 'page:' . $tn_slug ) ) :
							?>
						<li><a href="<?php echo esc_url( home_url( '/' . $tn_slug . '/' ) ); ?>"><?php echo esc_html( $tn_label ); ?></a></li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
		</div>
		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( TN_SITE_NAME ); ?>. All tests are free.</span>
			<span>Made by <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html( TN_FOUNDER_NAME ); ?></a></span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
