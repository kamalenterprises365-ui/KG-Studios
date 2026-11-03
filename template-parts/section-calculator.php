<?php
/**
 * Indicative quote calculator. Shown only when both per-slide rates are set in the Customizer.
 * motion.js computes the range; the final price always comes after a brief.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! kg_opt( 'rate_low' ) || ! kg_opt( 'rate_high' ) ) {
	return;
}
?>
<section class="section section--alt" id="calculator">
	<div class="wrap wrap--narrow">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'Estimate', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'How big is your deck?', 'kgstudios' ); ?></h2>
		</header>
		<div class="calc" data-calc data-reveal="up">
			<label class="calc__row"><span><?php esc_html_e( 'Number of slides', 'kgstudios' ); ?></span>
				<input type="range" min="5" max="100" value="20" step="1" data-calc-slides aria-describedby="calc-out">
				<b data-calc-n>20</b>
			</label>
			<p class="calc__out" id="calc-out" aria-live="polite"><span data-calc-range></span></p>
			<p class="muted"><?php esc_html_e( 'This is an indicative range. Your final quote depends on content work, complexity and any motion, and comes after we see your brief.', 'kgstudios' ); ?></p>
			<a class="btn btn--gold" data-calc-cta href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Request this quote', 'kgstudios' ); ?></a>
		</div>
	</div>
</section>
