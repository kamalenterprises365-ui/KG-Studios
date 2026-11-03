<?php
/**
 * Renders a data-driven page (see inc/pages-data.php). Args: slug, d (page data).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$slug = $args['slug'];
$d    = $args['d'];

get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => $d['eyebrow'] ?? '',
	'title'   => $d['h1'] ?? esc_html( $d['title'] ),
	'lead'    => $d['lead'] ?? '',
) );

if ( 'hub' === $d['type'] ) {
	get_template_part( 'template-parts/section', 'cards', array( 'slugs' => $d['children'] ) );
	if ( 'services' === $slug ) {
		get_template_part( 'template-parts/section', 'why' );
	}
	if ( 'who-we-serve' === $slug ) {
		get_template_part( 'template-parts/section', 'testimonials' );
	}
	if ( ! empty( $d['work'] ) ) {
		get_template_part( 'template-parts/section', 'effect', array( 'limit' => (int) $d['work'] ) );
	}
	if ( ! empty( $d['faq'] ) ) {
		get_template_part( 'template-parts/section', 'faq', array( 'items' => $d['faq'] ) );
	}
	get_template_part( 'template-parts/section', 'cta' );
	return;
}
?>
<section class="section">
	<div class="wrap split">
		<div class="split__text" data-reveal="left">
			<?php if ( ! empty( $d['who'] ) ) : ?>
				<h3 class="mini"><?php esc_html_e( 'Who it is for', 'kgstudios' ); ?></h3>
				<ul class="ticks"><?php foreach ( $d['who'] as $l ) : ?><li><?php echo esc_html( $l ); ?></li><?php endforeach; ?></ul>
			<?php endif; ?>
			<?php if ( ! empty( $d['gets'] ) ) : ?>
				<h3 class="mini"><?php esc_html_e( 'What you get', 'kgstudios' ); ?></h3>
				<ul class="ticks"><?php foreach ( $d['gets'] as $l ) : ?><li><?php echo esc_html( $l ); ?></li><?php endforeach; ?></ul>
			<?php endif; ?>
			<p class="split__cta"><a class="btn btn--gold magnet" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a quote', 'kgstudios' ); ?></a></p>
		</div>
		<?php if ( ! empty( $d['image'] ) ) : ?>
			<div class="split__img" data-reveal="right"><img src="<?php echo kg_img( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['title'] ); ?>" loading="lazy" width="900" height="600"></div>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $d['outcome'] ) ) : ?>
	<section class="outcome">
		<div class="wrap wrap--narrow">
			<p class="outcome__q" data-reveal="up"><?php echo esc_html( $d['outcome'] ); ?></p>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/section', 'process' );
get_template_part( 'template-parts/section', 'cards', array(
	'slugs'   => $d['related'] ?? array(),
	'eyebrow' => __( 'Related', 'kgstudios' ),
	'title'   => __( 'You may also need', 'kgstudios' ),
) );
get_template_part( 'template-parts/section', 'faq', array( 'items' => $d['faq'] ?? array() ) );
get_template_part( 'template-parts/section', 'cta' );
