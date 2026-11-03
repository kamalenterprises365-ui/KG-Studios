<?php
/**
 * Breadcrumbs for the current page, built from its ancestors. Hidden when there are none.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! is_page() || ! get_post_ancestors( get_queried_object_id() ) ) {
	return;
}
$ids   = array_reverse( get_post_ancestors( get_queried_object_id() ) );
$trail = array( array( __( 'Home', 'kgstudios' ), home_url( '/' ) ) );
foreach ( $ids as $id ) {
	$trail[] = array( get_the_title( $id ), get_permalink( $id ) );
}
?>
<nav class="crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'kgstudios' ); ?>" data-reveal>
	<?php foreach ( $trail as $i => $c ) : ?>
		<a href="<?php echo esc_url( $c[1] ); ?>"><?php echo esc_html( $c[0] ); ?></a><span aria-hidden="true">/</span>
	<?php endforeach; ?>
	<span aria-current="page"><?php echo esc_html( get_the_title() ); ?></span>
</nav>
