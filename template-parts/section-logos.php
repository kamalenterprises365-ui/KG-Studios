<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$clients = kg_content( 'clients' );
?>
<section class="logos" aria-label="<?php esc_attr_e( 'Clients', 'kgstudios' ); ?>">
	<p class="logos__title" data-reveal><?php esc_html_e( 'Trusted by ambitious brands across India & the Middle East', 'kgstudios' ); ?></p>
	<div class="marquee">
		<div class="marquee__track">
			<?php for ( $r = 0; $r < 2; $r++ ) : foreach ( $clients as $c ) : ?>
				<img src="<?php echo kg_img( 'client-' . $c . '.png' ); ?>" alt="<?php echo 0 === $r ? esc_attr( ucwords( str_replace( '-', ' ', $c ) ) ) . ' logo' : ''; ?>" height="48" loading="lazy" <?php echo $r ? 'aria-hidden="true"' : ''; ?>>
			<?php endforeach; endfor; ?>
		</div>
	</div>
</section>
