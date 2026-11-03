<?php
/**
 * Signature scroll scene: cluttered slides drift in 3D and snap into a clean grid as you scroll.
 * motion.js sets --p (0 to 1) on .scene; CSS does the rest. On small screens and with
 * reduced motion it shows the finished state.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Chaos offsets per tile: x, y (px), z (px), roll, tilt-x, tilt-y (deg).
$chaos = array(
	array( -260, -90, -240, -16, 24, 30 ),
	array( 40, 150, 120, 11, -18, 20 ),
	array( 280, -140, -160, 18, 20, -26 ),
	array( -210, 130, 160, 9, -22, -18 ),
	array( 20, -170, -60, -14, 26, 12 ),
	array( 240, 120, 200, -10, -16, -28 ),
);
$pairs = kg_content( 'pairs' );
?>
<section class="scene f-paper" data-scene aria-label="<?php esc_attr_e( 'Cluttered slides become clear', 'kgstudios' ); ?>">
	<div class="scene__stick">
		<div class="scene__copy">
			<h2 class="scene__h"><span class="scene__a"><?php esc_html_e( 'Cluttered, inconsistent slides', 'kgstudios' ); ?></span><span class="scene__b"><?php esc_html_e( 'Sharp, on-brand, high-impact', 'kgstudios' ); ?></span></h2>
			<p class="soft"><?php esc_html_e( 'We turn cluttered, inconsistent slides into sharp, on-brand, high-impact presentations built to drive decisions.', 'kgstudios' ); ?></p>
		</div>
		<div class="scene__stage" aria-hidden="true">
			<?php foreach ( $pairs as $i => $n ) : $c = $chaos[ $i ]; ?>
				<div class="tile" style="--x:<?php echo (int) $c[0]; ?>;--y:<?php echo (int) $c[1]; ?>;--z:<?php echo (int) $c[2]; ?>;--r:<?php echo (int) $c[3]; ?>;--rx:<?php echo (int) $c[4]; ?>;--ry:<?php echo (int) $c[5]; ?>">
					<img class="tile__before" src="<?php echo kg_img( 'slide-' . $n . '.jpeg' ); ?>" alt="" loading="lazy" width="800" height="450">
					<img class="tile__after" src="<?php echo kg_img( 'slide-' . ( $n + 1 ) . '.jpeg' ); ?>" alt="" loading="lazy" width="800" height="450">
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
