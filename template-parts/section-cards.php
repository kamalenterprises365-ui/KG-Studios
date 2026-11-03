<?php
/**
 * Cards linking to data pages. Args: slugs (array), eyebrow, title.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a   = wp_parse_args( $args, array( 'slugs' => array(), 'eyebrow' => '', 'title' => '' ) );
$all = kg_pages();
if ( ! $a['slugs'] ) {
	return;
}
?>
<section class="section">
	<div class="wrap">
		<?php if ( $a['title'] ) : ?>
			<header class="section__head" data-reveal="up">
				<?php if ( $a['eyebrow'] ) : ?><p class="eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></p><?php endif; ?>
				<h2><?php echo esc_html( $a['title'] ); ?></h2>
			</header>
		<?php endif; ?>
		<div class="cards">
			<?php foreach ( $a['slugs'] as $i => $slug ) : if ( empty( $all[ $slug ] ) ) { continue; } $c = $all[ $slug ]; ?>
				<a class="card tilt" href="<?php echo esc_url( kg_slug_url( $slug ) ); ?>" data-reveal="up" data-cursor="<?php esc_attr_e( 'Open', 'kgstudios' ); ?>" style="--d:<?php echo esc_attr( ( $i % 3 ) * 0.08 ); ?>s">
					<?php if ( ! empty( $c['image'] ) ) : ?>
						<div class="card__img"><img src="<?php echo kg_img( $c['image'] ); ?>" alt="" loading="lazy" width="600" height="400"></div>
					<?php endif; ?>
					<div class="card__body">
						<span class="card__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $c['title'] ); ?></h3>
						<p><?php echo esc_html( $c['short'] ?? $c['lead'] ?? '' ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
