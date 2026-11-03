<?php
/**
 * FAQ as filled tiles, one open at a time. Args: items (1-based keys into kg_faq(); empty = all), field (default ink).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a   = wp_parse_args( $args, array( 'items' => array(), 'field' => 'ink' ) );
$faq = kg_faq();
if ( $a['items'] ) {
	$faq = array_intersect_key( $faq, array_flip( $a['items'] ) );
}
?>
<section class="section f-<?php echo esc_attr( $a['field'] ); ?>" id="faq-list">
	<div class="wrap split-head">
		<h2 class="split-head__h" data-reveal="up"><?php esc_html_e( 'Questions, answered', 'kgstudios' ); ?></h2>
		<div class="faq" data-reveal="up">
			<?php foreach ( $faq as $qa ) : ?>
				<details class="faq__item" name="faq">
					<summary><?php echo esc_html( $qa[0] ); ?></summary>
					<p><?php echo esc_html( $qa[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
