<?php
/**
 * Renders a data-driven page (see inc/pages-data.php). Args: slug, d (page data).
 * Field order alternates so neighbouring sections never share a colour.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$slug = $args['slug'];
$d    = $args['d'];

get_template_part( 'template-parts/page', 'hero', array(
	'title' => $d['h1'] ?? esc_html( $d['title'] ),
	'lead'  => $d['lead'] ?? '',
) );

if ( 'hub' === $d['type'] ) {
	get_template_part( 'template-parts/section', 'cards', array( 'slugs' => $d['children'], 'field' => 'paper' ) );
	if ( 'services' === $slug ) {
		get_template_part( 'template-parts/section', 'why' );
	}
	if ( 'who-we-serve' === $slug ) {
		get_template_part( 'template-parts/section', 'testimonials' );
	}
	if ( ! empty( $d['work'] ) ) {
		get_template_part( 'template-parts/section', 'effect', array( 'limit' => (int) $d['work'], 'field' => 'ink' ) );
	}
	if ( ! empty( $d['faq'] ) ) {
		get_template_part( 'template-parts/section', 'faq', array( 'items' => $d['faq'], 'field' => 'paper' ) );
	}
	// "services" ends on a gold field, so its closing contact block is ink.
	get_template_part( 'template-parts/section', 'cta', array( 'field' => 'services' === $slug ? 'ink' : 'gold' ) );
	return;
}
?>
<section class="section f-paper">
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
			<p class="split__cta"><a class="btn magnet" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a quote', 'kgstudios' ); ?></a></p>
		</div>
		<?php if ( ! empty( $d['image'] ) ) : ?>
			<div class="split__img" data-reveal="right"><img src="<?php echo kg_img( $d['image'] ); ?>" alt="<?php echo esc_attr( $d['title'] ); ?>" loading="lazy" width="900" height="600"></div>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $d['outcome'] ) ) : ?>
	<section class="outcome f-teal">
		<div class="wrap">
			<p class="outcome__q" data-reveal="up"><?php echo esc_html( $d['outcome'] ); ?></p>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/section', 'process' );
get_template_part( 'template-parts/section', 'cards', array(
	'slugs' => $d['related'] ?? array(),
	'title' => __( 'You may also need', 'kgstudios' ),
	'field' => 'paper',
) );
get_template_part( 'template-parts/section', 'faq', array( 'items' => $d['faq'] ?? array(), 'field' => 'ink' ) );
get_template_part( 'template-parts/section', 'cta' );
