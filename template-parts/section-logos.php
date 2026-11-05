<?php
/**
 * Client logo strip. Args: field (ink|paper|gold|teal). The logo files are white, so they show in their real form on ink and teal.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a       = wp_parse_args( $args, array( 'field' => 'ink' ) );
$clients = kg_content( 'clients' );
?>
<figure class="logos f-<?php echo esc_attr( $a['field'] ); ?>">
	<div class="marquee">
		<div class="marquee__track">
			<?php for ( $r = 0; $r < 2; $r++ ) : foreach ( $clients as $c ) : ?>
				<img src="<?php echo kg_img( 'client-' . $c . '.png' ); ?>" alt="<?php echo 0 === $r ? esc_attr( ucwords( str_replace( '-', ' ', $c ) ) ) . ' logo' : ''; ?>" height="48" loading="lazy" <?php echo $r ? 'aria-hidden="true"' : ''; ?>>
			<?php endforeach; endfor; ?>
		</div>
	</div>
	<figcaption class="logos__cap"><?php esc_html_e( 'Trusted by ambitious brands across India & the Middle East', 'kgstudios' ); ?></figcaption>
</figure>
