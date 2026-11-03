<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page', 'hero', array(
		'eyebrow' => get_the_date(),
		'title'   => get_the_title(),
	) );
	?>
	<article <?php post_class( 'section' ); ?>>
		<div class="wrap prose">
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?>
			<?php the_content(); ?>
		</div>
	</article>
	<?php
	if ( comments_open() || get_comments_number() ) {
		echo '<div class="wrap prose">';
		comments_template();
		echo '</div>';
	}
endwhile;
get_footer();
