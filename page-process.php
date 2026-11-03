<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'title'   => __( 'How we turn a brief into a <span class="gold">deck that lands</span>', 'kgstudios' ),
	'lead'    => __( 'Strict NDA-backed processes and secure workflows keep your data, ideas and strategies protected at every step.', 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'process' );
get_template_part( 'template-parts/section', 'faq', array( 'items' => array( 1, 2, 3, 7 ), 'field' => 'paper' ) );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
