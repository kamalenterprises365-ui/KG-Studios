<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'Contact Us', 'kgstudios' ),
	'title'   => __( "Let's Work <span class=\"gold\">Together</span>", 'kgstudios' ),
	'lead'    => __( "Tell us who you are and what you need – we'll do the rest.", 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
