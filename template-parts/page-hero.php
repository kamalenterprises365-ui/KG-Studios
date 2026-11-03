<?php
/**
 * Inner-page hero. Args: eyebrow, title, lead.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a = wp_parse_args( $args, array( 'eyebrow' => '', 'title' => get_the_title(), 'lead' => '' ) );
?>
<section class="page-hero">
	<div class="orb orb--gold" data-parallax="0.15"></div>
	<div class="orb orb--teal" data-parallax="-0.1"></div>
	<div class="wrap">
		<?php if ( $a['eyebrow'] ) : ?><p class="eyebrow" data-reveal><?php echo esc_html( $a['eyebrow'] ); ?></p><?php endif; ?>
		<h1 class="page-hero__title" data-reveal="up"><?php echo wp_kses_post( $a['title'] ); ?></h1>
		<?php if ( $a['lead'] ) : ?><p class="lead-text" data-reveal="up" style="--d:.1s"><?php echo esc_html( $a['lead'] ); ?></p><?php endif; ?>
	</div>
</section>
