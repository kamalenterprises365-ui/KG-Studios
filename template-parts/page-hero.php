<?php
/**
 * Inner-page hero: a flat gold field with the page title. Args: title, lead.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a = wp_parse_args( $args, array( 'title' => get_the_title(), 'lead' => '' ) );
?>
<section class="page-hero f-gold">
	<div class="wrap">
		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
		<h1 class="page-hero__title" data-reveal="up"><?php echo wp_kses_post( $a['title'] ); ?></h1>
		<?php if ( $a['lead'] ) : ?><p class="statement" data-reveal="up" style="--d:.1s"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
	</div>
</section>
