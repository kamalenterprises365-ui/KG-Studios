<?php
/**
 * Blog listing as a normal page, so /insights/ works without changing the site's reading settings.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'Insights', 'kgstudios' ),
	'title'   => __( 'Ideas on presentations, <span class="gold">story and brand</span>', 'kgstudios' ),
) );
$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$posts = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged, 'posts_per_page' => 9 ) );
?>
<section class="section">
	<div class="wrap">
		<?php get_template_part( 'template-parts/post-cards', null, array( 'query' => $posts ) ); ?>
		<div class="pager">
			<?php
			echo wp_kses_post( paginate_links( array(
				'base'    => trailingslashit( get_permalink() ) . 'page/%#%/',
				'format'  => '',
				'current' => $paged,
				'total'   => $posts->max_num_pages,
			) ) );
			?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/section', 'cta' );
get_footer();
