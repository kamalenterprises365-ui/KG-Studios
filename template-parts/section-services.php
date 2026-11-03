<?php
/**
 * Home services: the three pillars as large linked cards, then the presentation offer list.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$all     = kg_pages();
$pillars = array( 'presentation-design', 'brand-identity', 'digital-design' );
?>
<section class="section" id="what_we_do" data-slide="<?php esc_attr_e( 'What we do', 'kgstudios' ); ?>">
	<div class="wrap">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'What We Do', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'Three things, done exceptionally well', 'kgstudios' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'Where ideas rise, flow, dive, and shine – through powerful presentations.', 'kgstudios' ); ?></p>
		</header>

		<div class="pillars">
			<?php foreach ( $pillars as $i => $slug ) : $c = $all[ $slug ]; ?>
				<a class="pillar tilt" href="<?php echo esc_url( kg_slug_url( $slug ) ); ?>" data-reveal="up" data-cursor="<?php esc_attr_e( 'Explore', 'kgstudios' ); ?>" style="--d:<?php echo esc_attr( $i * 0.1 ); ?>s">
					<img src="<?php echo kg_img( $c['image'] ); ?>" alt="" loading="lazy" width="900" height="600">
					<span class="pillar__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<span class="pillar__body">
						<h3><?php echo esc_html( $c['title'] ); ?></h3>
						<span><?php echo esc_html( $c['short'] ); ?></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

		<h3 class="mini center" data-reveal="up"><?php esc_html_e( 'Presentation services', 'kgstudios' ); ?></h3>
		<ul class="pills" data-reveal="up">
			<?php foreach ( $all['presentation-design']['children'] as $child ) : ?>
				<li><a href="<?php echo esc_url( kg_slug_url( $child ) ); ?>"><?php echo esc_html( $all[ $child ]['title'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
