<?php
/**
 * HTML sitemap for visitors. The XML sitemap for search engines comes from core or your SEO plugin.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$thanks  = get_page_by_path( 'contact/thank-you' );
$exclude = $thanks ? (string) $thanks->ID : '';
get_template_part( 'template-parts/page', 'hero', array(
	'eyebrow' => __( 'Sitemap', 'kgstudios' ),
	'title'   => __( 'Every page, <span class="gold">one list</span>', 'kgstudios' ),
) );
?>
<section class="section">
	<div class="wrap prose sitemap">
		<h2><?php esc_html_e( 'Pages', 'kgstudios' ); ?></h2>
		<ul><?php wp_list_pages( array( 'title_li' => '', 'exclude' => $exclude ) ); ?></ul>
		<?php
		$cases = get_posts( array( 'post_type' => 'kg_case', 'numberposts' => 50 ) );
		if ( $cases ) :
			?>
			<h2><?php esc_html_e( 'Case studies', 'kgstudios' ); ?></h2>
			<ul><?php foreach ( $cases as $c ) : ?><li><a href="<?php echo esc_url( get_permalink( $c ) ); ?>"><?php echo esc_html( get_the_title( $c ) ); ?></a></li><?php endforeach; ?></ul>
		<?php endif; ?>
		<?php
		$posts = get_posts( array( 'numberposts' => 50 ) );
		if ( $posts ) :
			?>
			<h2><?php esc_html_e( 'Insights', 'kgstudios' ); ?></h2>
			<ul><?php foreach ( $posts as $p ) : ?><li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></li><?php endforeach; ?></ul>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
