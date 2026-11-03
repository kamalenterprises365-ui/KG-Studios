<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section cta" id="contact-us">
	<div class="orb orb--gold" data-parallax="0.12"></div>
	<div class="wrap cta__grid">
		<div data-reveal="left">
			<p class="eyebrow"><?php esc_html_e( 'Contact Us', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( "Let's Work Together", 'kgstudios' ); ?></h2>
			<p class="muted"><?php esc_html_e( "Tell us who you are and what you need – we'll do the rest.", 'kgstudios' ); ?></p>
			<ul class="contact-list">
				<li><span><?php esc_html_e( 'Email', 'kgstudios' ); ?></span><a href="mailto:<?php echo esc_attr( kg_opt( 'email' ) ); ?>"><?php echo esc_html( kg_opt( 'email' ) ); ?></a></li>
				<?php if ( kg_opt( 'phone' ) ) : ?>
					<li><span><?php esc_html_e( 'Phone', 'kgstudios' ); ?></span><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', kg_opt( 'phone' ) ) ); ?>"><?php echo esc_html( kg_opt( 'phone' ) ); ?></a></li>
				<?php endif; ?>
				<li><span><?php esc_html_e( 'Studio', 'kgstudios' ); ?></span><?php echo esc_html( kg_opt( 'address' ) ); ?></li>
			</ul>
		</div>
		<div class="cta__form" data-reveal="right" id="contact">
			<?php kg_lead_form( 'lead-' . wp_unique_id() ); ?>
		</div>
	</div>
</section>
