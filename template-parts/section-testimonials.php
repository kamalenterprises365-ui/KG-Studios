<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$items = kg_content( 'testimonials' );
?>
<section class="section f-teal">
	<div class="wrap">
		<h2 data-reveal="up"><?php esc_html_e( 'What People Say', 'kgstudios' ); ?></h2>
		<div class="slider" data-slider data-reveal="up">
			<div class="slider__track">
				<?php foreach ( $items as $t ) : ?>
					<figure class="quote">
						<blockquote><p>&ldquo;<?php echo esc_html( $t[2] ); ?>&rdquo;</p></blockquote>
						<figcaption><b><?php echo esc_html( $t[0] ); ?></b><span><?php echo esc_html( $t[1] ); ?></span></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
			<div class="slider__dots" role="tablist">
				<?php foreach ( $items as $i => $t ) : ?>
					<button type="button" role="tab" aria-label="<?php echo esc_attr( $t[0] ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"></button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
