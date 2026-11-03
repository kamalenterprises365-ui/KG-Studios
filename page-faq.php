<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'FAQ', 'kgstudios' ),
	'title'   => __( 'Questions, <span class="gold">answered</span>', 'kgstudios' ),
	'lead'    => __( 'Anything else? Send us a message and we will reply.', 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'faq' );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
