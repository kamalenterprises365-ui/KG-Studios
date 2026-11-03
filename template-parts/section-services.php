<?php
/**
 * Home services as an index: the nine presentation services listed by name; hovering, focusing
 * or tapping one swaps the sheet beside it. Every name is a real link, so it works without JS.
 * Below, the three service pillars as large text links.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$all     = kg_pages();
$items   = $all['presentation-design']['children'];
$pillars = array( 'presentation-design', 'brand-identity', 'digital-design' );
?>
<section class="section f-teal" id="what_we_do">
	<div class="wrap">
		<h2 data-reveal="up"><?php esc_html_e( 'Presentation Services', 'kgstudios' ); ?></h2>
		<p class="statement" data-reveal="up" style="--d:.06s"><?php esc_html_e( 'Where ideas rise, flow, dive, and shine – through powerful presentations.', 'kgstudios' ); ?></p>

		<div class="idx" data-index data-reveal="up">
			<ul class="idx__list">
				<?php foreach ( $items as $i => $slug ) : ?>
					<li><a class="<?php echo 0 === $i ? 'is-on' : ''; ?>" href="<?php echo esc_url( kg_slug_url( $slug ) ); ?>" data-idx="<?php echo (int) $i; ?>"><?php echo esc_html( $all[ $slug ]['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<div class="idx__stage">
				<?php foreach ( $items as $i => $slug ) : $c = $all[ $slug ]; ?>
					<div class="idx__panel<?php echo 0 === $i ? ' is-on' : ''; ?>" data-panel="<?php echo (int) $i; ?>">
						<img src="<?php echo kg_img( $c['image'] ); ?>" alt="<?php echo esc_attr( $c['title'] ); ?>" loading="lazy" width="900" height="600">
						<p><?php echo esc_html( $c['short'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<ul class="rows" id="services" data-reveal="up">
			<?php foreach ( $pillars as $slug ) : $c = $all[ $slug ]; ?>
				<li><a href="<?php echo esc_url( kg_slug_url( $slug ) ); ?>" data-cursor="<?php esc_attr_e( 'Open', 'kgstudios' ); ?>"><span class="rows__t"><?php echo esc_html( $c['title'] ); ?></span><span class="rows__d"><?php echo esc_html( $c['short'] ); ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
