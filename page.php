<?php
/**
 * Default page. Pages listed in inc/pages-data.php are rendered from data;
 * any other page shows its editor content.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	$data = kg_page_data( (string) get_post_field( 'post_name' ) );
	if ( $data ) {
		get_template_part( 'template-parts/landing', null, array( 'slug' => get_post_field( 'post_name' ), 'd' => $data ) );
		continue;
	}
	get_template_part( 'template-parts/page', 'hero', array( 'title' => get_the_title() ) );
	?>
	<section class="section f-paper">
		<div class="wrap prose"><?php the_content(); ?></div>
	</section>
	<?php
endwhile;
get_footer();
