<?php
/**
 * The KG Studios advantage. Args: field (default gold).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a = wp_parse_args( $args, array( 'field' => 'gold' ) );
?>
<section class="section f-<?php echo esc_attr( $a['field'] ); ?>" id="why_choose_us">
	<div class="wrap split-head">
		<h2 class="split-head__h" data-reveal="up"><?php esc_html_e( 'The KG Studios Advantage', 'kgstudios' ); ?></h2>
		<ul class="why">
			<?php foreach ( kg_content( 'why' ) as $i => $w ) : ?>
				<li data-reveal="up" style="--d:<?php echo esc_attr( $i * 0.05 ); ?>s">
					<h3><?php echo esc_html( $w[0] ); ?></h3>
					<p><?php echo esc_html( $w[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
