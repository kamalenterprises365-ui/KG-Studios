<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'title'   => __( 'Consulting strategy, <span class="gold">design craft</span>', 'kgstudios' ),
	'lead'    => __( 'KG Studios is a specialized presentation, brand, and digital design agency headquartered in Gurgaon, India. Led by alumni from BCG, KPMG, and ZS, we help startups, corporates, and consulting firms communicate with clarity, confidence, and measurable impact – across India and the Middle East.', 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'why', array( 'field' => 'ink' ) );
get_template_part( 'template-parts/section', 'team' );
get_template_part( 'template-parts/section', 'logos', array( 'field' => 'teal' ) );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
