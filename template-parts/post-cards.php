<?php
/**
 * Post cards for the current main loop (blog index, archives, search) or a custom query. Args: query (WP_Query, optional).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$q = isset( $args['query'] ) ? $args['query'] : $GLOBALS['wp_query'];
?>
<?php if ( $q->have_posts() ) : ?>
	<div class="cards">
		<?php while ( $q->have_posts() ) : $q->the_post(); ?>
			<article <?php post_class( 'card' ); ?> data-reveal="up">
				<?php if ( has_post_thumbnail() ) : ?>
					<a class="card__img" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?></a>
				<?php endif; ?>
				<div class="card__body">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<span class="card__meta"><?php echo esc_html( get_the_date() ); ?></span>
					<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				</div>
			</article>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
<?php else : ?>
	<p class="soft"><?php esc_html_e( 'Nothing here yet.', 'kgstudios' ); ?></p>
<?php endif; ?>
