<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'What We Do', 'kgstudios' ),
	'title'   => __( 'Presentations, brands and <span class="gold">digital design</span>', 'kgstudios' ),
	'lead'    => __( 'Where ideas rise, flow, dive, and shine – through powerful presentations.', 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'services', array( 'heading' => false ) );
get_template_part( 'template-parts/section', 'why' );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
