<?php
/**
 * Before/after sliders. Args: limit (int, default all).
 * Odd slide-N images are "before", the following even one is "after".
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a     = wp_parse_args( $args, array( 'limit' => 0 ) );
$pairs = kg_content( 'pairs' );
if ( $a['limit'] ) {
	$pairs = array_slice( $pairs, 0, (int) $a['limit'] );
}
?>
<section class="section section--alt" id="our_work">
	<div class="wrap">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'Our Work', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'The KG Studios Effect', 'kgstudios' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'We turn cluttered, inconsistent slides into sharp, on-brand, high-impact presentations built to drive decisions. Drag the slider to see the transformation yourself.', 'kgstudios' ); ?></p>
		</header>
		<div class="ba-grid">
			<?php foreach ( $pairs as $i => $n ) : ?>
				<figure class="ba" data-ba data-reveal="up" style="--d:<?php echo esc_attr( ( $i % 2 ) * 0.1 ); ?>s">
					<img class="ba__after" src="<?php echo kg_img( 'slide-' . ( $n + 1 ) . '.jpeg' ); ?>" alt="<?php esc_attr_e( 'After: redesigned slide', 'kgstudios' ); ?>" loading="lazy" width="800" height="450" draggable="false">
					<img class="ba__before" src="<?php echo kg_img( 'slide-' . $n . '.jpeg' ); ?>" alt="<?php esc_attr_e( 'Before: original slide', 'kgstudios' ); ?>" loading="lazy" width="800" height="450" draggable="false">
					<span class="ba__tag ba__tag--l"><?php esc_html_e( 'Before', 'kgstudios' ); ?></span>
					<span class="ba__tag ba__tag--r"><?php esc_html_e( 'After', 'kgstudios' ); ?></span>
					<span class="ba__handle" aria-hidden="true"></span>
					<input class="ba__range" type="range" min="0" max="100" value="50" aria-label="<?php esc_attr_e( 'Before and after slider', 'kgstudios' ); ?>">
				</figure>
			<?php endforeach; ?>
		</div>
		<?php if ( $a['limit'] ) : ?>
			<p class="center" data-reveal="up"><a class="btn btn--ghost" href="<?php echo esc_url( kg_page_url( 'work' ) ); ?>"><?php esc_html_e( 'See more work', 'kgstudios' ); ?></a></p>
		<?php endif; ?>
	</div>
</section>
