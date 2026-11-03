<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$socials = array( 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn' );
$legal   = array(
	'privacy-policy'          => __( 'Privacy policy', 'kgstudios' ),
	'terms'                   => __( 'Terms', 'kgstudios' ),
	'cookie-policy'           => __( 'Cookie policy', 'kgstudios' ),
	'confidentiality-and-nda' => __( 'Confidentiality', 'kgstudios' ),
	'accessibility'           => __( 'Accessibility', 'kgstudios' ),
);
$wa = preg_replace( '/\D/', '', (string) kg_opt( 'whatsapp' ) );
?>
</main>

<footer class="site-footer f-ink">
	<p class="site-footer__name" aria-hidden="true">KG Studios</p>
	<div class="site-footer__grid">
		<ul class="site-footer__places">
			<li><a href="mailto:<?php echo esc_attr( kg_opt( 'email' ) ); ?>"><?php echo esc_html( kg_opt( 'email' ) ); ?></a></li>
			<?php if ( kg_opt( 'phone' ) ) : ?>
				<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', kg_opt( 'phone' ) ) ); ?>"><?php echo esc_html( kg_opt( 'phone' ) ); ?></a></li>
			<?php endif; ?>
			<li><?php echo esc_html( kg_opt( 'address' ) ); ?></li>
		</ul>
		<div class="site-footer__links">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'site-footer__list',
				'fallback_cb'    => function () {
					$all = kg_pages();
					echo '<ul class="site-footer__list">';
					foreach ( array_keys( kg_menu_tree( 'footer' ) ) as $s ) {
						printf( '<li><a href="%s">%s</a></li>', esc_url( kg_slug_url( $s ) ), esc_html( $all[ $s ]['title'] ) );
					}
					echo '</ul>';
				},
				'depth'          => 1,
			) );
			?>
			<ul class="site-footer__list">
				<?php foreach ( $socials as $key => $label ) : if ( kg_opt( $key ) ) : ?>
					<li><a href="<?php echo esc_url( kg_opt( $key ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a></li>
				<?php endif; endforeach; ?>
			</ul>
			<p class="site-footer__about">KG Studios is a specialized presentation, brand, and digital design agency headquartered in Gurgaon, India. Led by alumni from BCG, KPMG, and ZS, we blend consulting strategy with world-class design to help startups, corporates, and consulting firms communicate with clarity, confidence, and measurable impact – across India and the Middle East.</p>
		</div>
	</div>
	<div class="site-footer__bar">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> KG Studios. All rights reserved.</p>
		<ul class="legal">
			<?php foreach ( $legal as $slug => $label ) : $page = get_page_by_path( $slug ); if ( $page ) : ?>
				<li><a href="<?php echo esc_url( get_permalink( $page ) ); ?>"><?php echo esc_html( $label ); ?></a></li>
			<?php endif; endforeach; ?>
			<li><button type="button" class="linklike" data-consent-open><?php esc_html_e( 'Cookie settings', 'kgstudios' ); ?></button></li>
			<li><button type="button" class="linklike" data-motion-toggle aria-pressed="false"><?php esc_html_e( 'Reduce motion', 'kgstudios' ); ?></button></li>
			<li><a href="#main"><?php esc_html_e( 'Back to top', 'kgstudios' ); ?></a></li>
		</ul>
	</div>
</footer>

<?php if ( $wa ) : ?>
	<a class="wa" href="<?php echo esc_url( 'https://wa.me/' . $wa ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'kgstudios' ); ?>"><?php esc_html_e( 'WhatsApp', 'kgstudios' ); ?></a>
<?php endif; ?>

<div class="consent f-paper" role="dialog" aria-label="<?php esc_attr_e( 'Cookie consent', 'kgstudios' ); ?>" hidden>
	<p><?php esc_html_e( 'We use analytics cookies to understand how the site is used and to improve it. You can accept or decline.', 'kgstudios' ); ?></p>
	<div class="consent__btns">
		<button type="button" class="btn btn--ghost" data-consent="denied"><?php esc_html_e( 'Decline', 'kgstudios' ); ?></button>
		<button type="button" class="btn" data-consent="granted"><?php esc_html_e( 'Accept', 'kgstudios' ); ?></button>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
