<?php
/**
 * Shown after a successful enquiry. Fires the GA4 conversion event (once per load, only if consent was given).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'Message received', 'kgstudios' ),
	'title'   => __( 'Thank you. <span class="gold">We will be in touch.</span>', 'kgstudios' ),
	'lead'    => __( 'We have your brief and will get back to you shortly. In the meantime, see what we have done for others.', 'kgstudios' ),
) );
?>
<section class="section center">
	<a class="btn btn--gold" href="<?php echo esc_url( kg_page_url( 'work' ) ); ?>"><?php esc_html_e( 'See our work', 'kgstudios' ); ?></a>
	<a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'kgstudios' ); ?></a>
</section>
<script>if (window.gtag) { gtag('event', 'generate_lead'); }</script>
<?php
get_footer();
