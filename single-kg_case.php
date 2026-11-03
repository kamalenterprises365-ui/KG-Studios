<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
while ( have_posts() ) :
	the_post();
	$id     = get_the_ID();
	$client = get_post_meta( $id, 'kg_client', true );
	$result = get_post_meta( $id, 'kg_result', true );
	$before = get_post_meta( $id, 'kg_before', true );
	$after  = get_post_meta( $id, 'kg_after', true );
	get_template_part( 'template-parts/page', 'hero', array(
		'title'   => get_the_title(),
		'lead'    => $result,
	) );
	?>
	<section class="section f-paper">
		<div class="wrap">
			<?php if ( $before && $after ) : ?>
				<div class="case-ba"><?php kg_ba_figure( $before, $after ); ?></div>
			<?php endif; ?>
			<div class="prose"><?php the_content(); ?></div>
			<p class="center"><a class="btn btn--ghost" href="<?php echo esc_url( kg_page_url( 'work' ) ); ?>"><?php esc_html_e( 'All work', 'kgstudios' ); ?></a></p>
		</div>
	</section>
	<?php
	get_template_part( 'template-parts/section', 'cta' );
endwhile;
get_footer();
