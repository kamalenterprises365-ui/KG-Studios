<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section" id="why_choose_us">
	<div class="wrap">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'Why Choose Us', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'The KG Studios Advantage', 'kgstudios' ); ?></h2>
		</header>
		<div class="stats" data-reveal="up">
			<div><b data-count="30" data-suffix="+">30+</b><span><?php esc_html_e( 'years of combined consulting experience', 'kgstudios' ); ?></span></div>
			<div><b>30–50%</b><span><?php esc_html_e( 'faster execution with AI workflows', 'kgstudios' ); ?></span></div>
			<div><b>5</b><span><?php esc_html_e( 'platforms mastered, from PowerPoint to Figma', 'kgstudios' ); ?></span></div>
		</div>
		<div class="why">
			<?php foreach ( kg_content( 'why' ) as $i => $w ) : ?>
				<article class="why__item tilt" data-reveal="up" style="--d:<?php echo esc_attr( ( $i % 3 ) * 0.08 ); ?>s">
					<span class="why__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $w[0] ); ?></h3>
					<p><?php echo esc_html( $w[1] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
