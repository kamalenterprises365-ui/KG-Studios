<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'Pricing', 'kgstudios' ),
	'title'   => __( 'Three ways to <span class="gold">work with us</span>', 'kgstudios' ),
	'lead'    => __( 'Every project is scoped to your content, your audience and your timeline. Pick the model that fits, then send us your brief for a quote.', 'kgstudios' ),
) );
$models = array(
	array( __( 'Per project', 'kgstudios' ), __( 'A pitch deck, a keynote, a report or a brand identity, scoped and delivered as one project.', 'kgstudios' ), 'pitch-and-investor-decks' ),
	array( __( 'Outsourced team', 'kgstudios' ), __( 'Your own presentation design team on call, working under NDA-backed workflows.', 'kgstudios' ), 'outsourced-presentation-design' ),
	array( __( 'Template system', 'kgstudios' ), __( 'A scalable, on-brand, Copilot-compatible template system your whole team can use.', 'kgstudios' ), 'presentation-template-creation' ),
);
?>
<section class="section">
	<div class="wrap">
		<div class="cards">
			<?php foreach ( $models as $i => $m ) : ?>
				<article class="card plan" data-reveal="up" style="--d:<?php echo esc_attr( $i * 0.08 ); ?>s">
					<div class="card__body">
						<span class="card__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $m[0] ); ?></h3>
						<p><?php echo esc_html( $m[1] ); ?></p>
						<p><a class="link-arrow" href="<?php echo esc_url( kg_slug_url( $m[2] ) ); ?>"><?php esc_html_e( 'Learn more', 'kgstudios' ); ?></a></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/section', 'calculator' );
get_template_part( 'template-parts/section', 'faq', array( 'items' => array( 5, 6, 1 ) ) );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
