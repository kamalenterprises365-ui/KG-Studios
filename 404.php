<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => '404',
	'title'   => __( 'This slide went <span class="gold">missing</span>', 'kgstudios' ),
	'lead'    => __( 'The page you are looking for does not exist or has moved.', 'kgstudios' ),
) );
?>
<section class="section center">
	<a class="btn btn--gold" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'kgstudios' ); ?></a>
</section>
<?php
get_footer();
