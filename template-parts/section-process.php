<?php
/**
 * The five steps as one bar: five flat colour segments, a clause under each. Order is shown by position.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$tone = array( 'gold', 'teal', 'paper', 'gold', 'teal' );
?>
<section class="section f-ink" id="process">
	<div class="wrap">
		<h2 data-reveal="up"><?php esc_html_e( 'How we work', 'kgstudios' ); ?></h2>
		<ol class="bar" data-reveal="up">
			<?php foreach ( kg_process() as $i => $s ) : ?>
				<li class="bar__seg">
					<span class="bar__block bar__block--<?php echo esc_attr( $tone[ $i ] ); ?>"><?php echo esc_html( $s[0] ); ?></span>
					<p><?php echo esc_html( $s[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
