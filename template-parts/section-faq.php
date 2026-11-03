<?php
/**
 * FAQ accordion. Args: items (array of 1-based keys into kg_faq(); empty = all).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a   = wp_parse_args( $args, array( 'items' => array() ) );
$faq = kg_faq();
if ( $a['items'] ) {
	$faq = array_intersect_key( $faq, array_flip( $a['items'] ) );
}
?>
<section class="section" id="faq-list">
	<div class="wrap wrap--narrow">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'FAQ', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'Questions, answered', 'kgstudios' ); ?></h2>
		</header>
		<div class="faq" data-reveal="up">
			<?php foreach ( $faq as $qa ) : ?>
				<details class="faq__item">
					<summary><?php echo esc_html( $qa[0] ); ?></summary>
					<p><?php echo esc_html( $qa[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
