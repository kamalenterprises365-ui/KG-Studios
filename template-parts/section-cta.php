<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$wa = preg_replace( '/\D/', '', (string) kg_opt( 'whatsapp' ) );
?>
<section class="section cta" id="contact-us" data-slide="<?php esc_attr_e( 'Contact', 'kgstudios' ); ?>">
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
			<?php if ( $wa || kg_opt( 'booking' ) ) : ?>
				<p class="cta__quick">
					<?php if ( kg_opt( 'booking' ) ) : ?><a class="btn btn--ghost" href="<?php echo esc_url( kg_opt( 'booking' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Book a 20-minute call', 'kgstudios' ); ?></a><?php endif; ?>
					<?php if ( $wa ) : ?><a class="btn btn--ghost" href="<?php echo esc_url( 'https://wa.me/' . $wa ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Chat on WhatsApp', 'kgstudios' ); ?></a><?php endif; ?>
				</p>
			<?php endif; ?>
		</div>
		<div class="cta__form" data-reveal="right" id="contact">
			<?php kg_lead_form( 'lead-' . wp_unique_id() ); ?>
		</div>
	</div>
</section>
