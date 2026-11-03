<?php
/**
 * Blog index, archives and search results.
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
<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="cards">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'card tilt' ); ?> data-reveal="up">
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="card__img" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?></a>
						<?php endif; ?>
						<div class="card__body">
							<span class="card__n"><?php echo esc_html( get_the_date() ); ?></span>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pager"><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?></div>
		<?php else : ?>
			<p class="muted center"><?php esc_html_e( 'Nothing found.', 'kgstudios' ); ?></p>
			<div class="center"><?php get_search_form(); ?></div>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
