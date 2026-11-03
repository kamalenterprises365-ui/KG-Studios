<?php
/**
 * Archives, search results and the fallback blog index.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

if ( is_search() ) {
	/* translators: %s: search query */
	$title = sprintf( __( 'Search: %s', 'kgstudios' ), get_search_query() );
} elseif ( is_archive() ) {
	$title = get_the_archive_title();
} else {
	$title = __( 'Insights', 'kgstudios' );
}
get_template_part( 'template-parts/page', 'hero', array( 'title' => esc_html( $title ) ) );
?>
<section class="section f-paper">
	<div class="wrap">
		<?php get_template_part( 'template-parts/post-cards' ); ?>
		<div class="pager"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		<?php if ( ! have_posts() ) : ?>
			<div class="center"><?php get_search_form(); ?></div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
