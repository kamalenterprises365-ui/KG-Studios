<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$socials = array( 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn' );
?>
</main>

<footer class="site-footer">
	<div class="wrap site-footer__grid">
		<div>
			<img class="site-footer__logo" src="<?php echo kg_img( 'logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="140" height="44" loading="lazy">
			<p class="site-footer__about">KG Studios is a specialized presentation, brand, and digital design agency headquartered in Gurgaon, India. Led by alumni from BCG, KPMG, and ZS, we blend consulting strategy with world-class design to help startups, corporates, and consulting firms communicate with clarity, confidence, and measurable impact – across India and the Middle East.</p>
		</div>
		<div>
			<h3 class="site-footer__h"><?php esc_html_e( 'Explore', 'kgstudios' ); ?></h3>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'site-footer__list',
				'fallback_cb'    => function () {
					echo '<ul class="site-footer__list">';
					foreach ( array( 'Services' => 'services', 'Our Work' => 'work', 'About' => 'about', 'Contact' => 'contact' ) as $l => $s ) {
						printf( '<li><a href="%s">%s</a></li>', esc_url( kg_page_url( $s ) ), esc_html( $l ) );
					}
					echo '</ul>';
				},
				'depth'          => 1,
			) );
			?>
		</div>
		<div>
			<h3 class="site-footer__h"><?php esc_html_e( 'Get in touch', 'kgstudios' ); ?></h3>
			<ul class="site-footer__list">
				<li><a href="mailto:<?php echo esc_attr( kg_opt( 'email' ) ); ?>"><?php echo esc_html( kg_opt( 'email' ) ); ?></a></li>
				<?php if ( kg_opt( 'phone' ) ) : ?>
					<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', kg_opt( 'phone' ) ) ); ?>"><?php echo esc_html( kg_opt( 'phone' ) ); ?></a></li>
				<?php endif; ?>
				<li><?php echo esc_html( kg_opt( 'address' ) ); ?></li>
			</ul>
			<ul class="social">
				<?php foreach ( $socials as $key => $label ) : if ( kg_opt( $key ) ) : ?>
					<li><a href="<?php echo esc_url( kg_opt( $key ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a></li>
				<?php endif; endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="wrap site-footer__bar">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> KG Studios. All rights reserved.</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
