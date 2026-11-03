<?php
/**
 * Tiles linking to data pages. Args: slugs (array), title, field (default paper).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a   = wp_parse_args( $args, array( 'slugs' => array(), 'title' => '', 'field' => 'paper' ) );
$all = kg_pages();
if ( ! $a['slugs'] ) {
	return;
}
?>
<section class="section f-<?php echo esc_attr( $a['field'] ); ?>">
	<div class="wrap">
		<?php if ( $a['title'] ) : ?><h2 data-reveal="up"><?php echo esc_html( $a['title'] ); ?></h2><?php endif; ?>
		<div class="cards">
			<?php foreach ( $a['slugs'] as $i => $slug ) : if ( empty( $all[ $slug ] ) ) { continue; } $c = $all[ $slug ]; ?>
				<a class="card" href="<?php echo esc_url( kg_slug_url( $slug ) ); ?>" data-reveal="up" data-cursor="<?php esc_attr_e( 'Open', 'kgstudios' ); ?>" style="--d:<?php echo esc_attr( ( $i % 3 ) * 0.08 ); ?>s">
					<?php if ( ! empty( $c['image'] ) ) : ?>
						<div class="card__img"><img src="<?php echo kg_img( $c['image'] ); ?>" alt="" loading="lazy" width="600" height="400"></div>
					<?php endif; ?>
					<div class="card__body">
						<h3><?php echo esc_html( $c['title'] ); ?></h3>
						<p><?php echo esc_html( $c['short'] ?? $c['lead'] ?? '' ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
