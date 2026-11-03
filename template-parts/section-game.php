<?php
/**
 * "Fix this slide": drag six messy blocks onto the grid. motion.js drives it.
 * Slot geometry (left, top, width, height in %) lives in data attributes.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$blocks = array(
	array( 'headline', __( 'Headline', 'kgstudios' ), 4, 6, 60, 16, 38, 44, -9 ),
	array( 'logo', __( 'Logo', 'kgstudios' ), 72, 6, 24, 16, 8, 58, 12 ),
	array( 'chart', __( 'Chart', 'kgstudios' ), 4, 28, 44, 46, 52, 8, 7 ),
	array( 'image', __( 'Image', 'kgstudios' ), 52, 28, 44, 46, 14, 20, -11 ),
	array( 'points', __( 'Key points', 'kgstudios' ), 4, 78, 60, 16, 34, 66, 8 ),
	array( 'number', __( 'Key number', 'kgstudios' ), 72, 78, 24, 16, 30, 6, -6 ),
);
?>
<section class="section f-ink" id="fix-the-slide">
	<div class="wrap game">
		<div class="game__copy" data-reveal="left">
			<h2><?php esc_html_e( 'Fix this slide', 'kgstudios' ); ?></h2>
			<p class="soft"><?php esc_html_e( 'Drag each block into its place. This is what we do for every deck: structure first, then polish.', 'kgstudios' ); ?></p>
			<p class="game__status" role="status" aria-live="polite"><span data-game-count>0</span> / <?php echo count( $blocks ); ?></p>
			<p class="game__win" data-game-win hidden><?php esc_html_e( 'Sharp. Now imagine it for your whole deck.', 'kgstudios' ); ?> <a class="btn" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a quote', 'kgstudios' ); ?></a></p>
			<button type="button" class="btn btn--ghost" data-game-solve><?php esc_html_e( 'Tidy it for me', 'kgstudios' ); ?></button>
		</div>
		<div class="game__stage" data-game data-ui data-reveal="right">
			<?php foreach ( $blocks as $b ) : ?>
				<div class="blk blk--<?php echo esc_attr( $b[0] ); ?>"
					data-l="<?php echo (int) $b[2]; ?>" data-t="<?php echo (int) $b[3]; ?>"
					data-w="<?php echo (int) $b[4]; ?>" data-h="<?php echo (int) $b[5]; ?>"
					data-sl="<?php echo (int) $b[6]; ?>" data-st="<?php echo (int) $b[7]; ?>" data-sr="<?php echo (int) $b[8]; ?>">
					<span class="blk__label"><?php echo esc_html( $b[1] ); ?></span>
					<?php if ( 'chart' === $b[0] ) : ?><span class="blk__bars"><i></i><i></i><i></i><i></i></span><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
