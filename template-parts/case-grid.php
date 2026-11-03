<?php
/**
 * Case study cards. Prints nothing when there are no published case studies.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$cases = new WP_Query( array( 'post_type' => 'kg_case', 'posts_per_page' => 12, 'no_found_rows' => true ) );
if ( ! $cases->have_posts() ) {
	return;
}
?>
<section class="section f-paper">
	<div class="wrap">
		<header class="section__head" data-reveal="up">
			<h2><?php esc_html_e( 'Work that moved the needle', 'kgstudios' ); ?></h2>
		</header>
		<div class="cards">
			<?php while ( $cases->have_posts() ) : $cases->the_post(); $img = get_post_meta( get_the_ID(), 'kg_after', true ); ?>
				<a class="card" href="<?php the_permalink(); ?>" data-reveal="up" data-cursor="<?php esc_attr_e( 'View', 'kgstudios' ); ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="card__img"><?php the_post_thumbnail( 'large', array( 'loading' => 'lazy', 'alt' => '' ) ); ?></div>
					<?php elseif ( $img ) : ?>
						<div class="card__img"><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy" width="800" height="450"></div>
					<?php endif; ?>
					<div class="card__body">
						<span class="card__meta"><?php echo esc_html( get_post_meta( get_the_ID(), 'kg_service', true ) ); ?></span>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( get_post_meta( get_the_ID(), 'kg_result', true ) ); ?></p>
					</div>
				</a>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
