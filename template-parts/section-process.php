<?php
/**
 * The five-step process, on a light "paper" section.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section section--paper" id="process" data-slide="<?php esc_attr_e( 'Process', 'kgstudios' ); ?>">
	<div class="wrap">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'How we work', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'From brief to a deck you are proud to present', 'kgstudios' ); ?></h2>
		</header>
		<ol class="steps">
			<?php foreach ( kg_process() as $i => $s ) : ?>
				<li class="step" data-reveal="up" style="--d:<?php echo esc_attr( $i * 0.08 ); ?>s">
					<span class="step__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3><?php echo esc_html( $s[0] ); ?></h3>
					<p><?php echo esc_html( $s[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
