<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page', 'hero', array( 'title' => get_the_title() ) );
	?>
	<section class="section">
		<div class="wrap prose"><?php the_content(); ?></div>
	</section>
	<?php
endwhile;
get_footer();
