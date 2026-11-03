<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'Our Work', 'kgstudios' ),
	'title'   => __( 'Cluttered slides, <span class="gold">transformed</span>', 'kgstudios' ),
	'lead'    => __( 'Drag each slider to compare the original slide with the KG Studios redesign.', 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'effect' );
get_template_part( 'template-parts/section', 'testimonials' );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
