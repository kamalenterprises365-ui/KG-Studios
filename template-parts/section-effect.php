<?php
/**
 * Before/after sliders. Args: limit (int, default all), field (default paper).
 * Odd slide-N images are "before", the following even one is "after".
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a     = wp_parse_args( $args, array( 'limit' => 0, 'field' => 'paper' ) );
$pairs = kg_content( 'pairs' );
if ( $a['limit'] ) {
	$pairs = array_slice( $pairs, 0, (int) $a['limit'] );
}
?>
<section class="section f-<?php echo esc_attr( $a['field'] ); ?>" id="our_work">
	<div class="wrap">
		<h2 data-reveal="up"><?php esc_html_e( 'The KG Studios Effect', 'kgstudios' ); ?></h2>
		<p class="statement" data-reveal="up" style="--d:.06s"><?php esc_html_e( 'Drag the slider to see the transformation yourself.', 'kgstudios' ); ?></p>
		<div class="ba-grid">
			<?php foreach ( $pairs as $i => $n ) : ?>
				<?php kg_ba_figure( kg_img( 'slide-' . $n . '.jpeg' ), kg_img( 'slide-' . ( $n + 1 ) . '.jpeg' ), ( $i % 2 ) * 0.1 ); ?>
			<?php endforeach; ?>
		</div>
		<?php if ( $a['limit'] ) : ?>
			<p class="after-grid" data-reveal="up"><a class="btn" href="<?php echo esc_url( kg_page_url( 'work' ) ); ?>"><?php esc_html_e( 'See more work', 'kgstudios' ); ?></a></p>
		<?php endif; ?>
	</div>
</section>
