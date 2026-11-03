<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section" id="our_team">
	<div class="wrap">
		<header class="section__head" data-reveal="up">
			<p class="eyebrow"><?php esc_html_e( 'Our Team', 'kgstudios' ); ?></p>
			<h2><?php esc_html_e( 'The Minds Behind the Work', 'kgstudios' ); ?></h2>
			<p class="muted"><?php esc_html_e( 'Strategy thinkers. Visual storytellers. Design experts. Together we build work that moves people and drives business forward.', 'kgstudios' ); ?></p>
		</header>
		<div class="team">
			<?php foreach ( kg_content( 'team' ) as $i => $m ) : ?>
				<article class="member tilt" data-reveal="up" style="--d:<?php echo esc_attr( $i * 0.08 ); ?>s">
					<div class="member__img"><img src="<?php echo kg_img( $m[3] ); ?>" alt="<?php echo esc_attr( $m[0] ); ?>" loading="lazy" width="600" height="600"></div>
					<h3><?php echo esc_html( $m[0] ); ?></h3>
					<p class="member__role"><?php echo esc_html( $m[1] ); ?></p>
					<p class="muted"><?php echo esc_html( $m[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
