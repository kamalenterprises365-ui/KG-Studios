<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'kgstudios', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	register_nav_menus( array(
		'primary' => __( 'Primary menu', 'kgstudios' ),
		'footer'  => __( 'Footer menu', 'kgstudios' ),
	) );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'kg-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'kg-main', get_template_directory_uri() . '/assets/css/main.css', array( 'kg-fonts' ), KG_VERSION );
	wp_enqueue_script( 'kg-main', get_template_directory_uri() . '/assets/js/main.js', array(), KG_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

/** Theme image URL helper. */
function kg_img( $file ) {
	return esc_url( get_template_directory_uri() . '/assets/img/' . $file );
}

/** Contact details from the Customizer, with site defaults. */
function kg_opt( $key ) {
	$defaults = array(
		'email'     => 'connect@kgstudios.io',
		'phone'     => '9650645985',
		'address'   => 'Gurgaon, India',
		'facebook'  => '',
		'instagram' => '',
		'linkedin'  => '',
	);
	return get_theme_mod( 'kg_' . $key, $defaults[ $key ] ?? '' );
}

/** Page URL by slug, falling back to a home anchor so links never 404. */
function kg_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/** Primary nav fallback when no menu is assigned. */
function kg_fallback_menu() {
	$items = array(
		'Home'     => home_url( '/' ),
		'Services' => kg_page_url( 'services' ),
		'Work'     => kg_page_url( 'work' ),
		'About'    => kg_page_url( 'about' ),
		'Contact'  => kg_page_url( 'contact' ),
	);
	echo '<ul class="nav__list">';
	foreach ( $items as $label => $url ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/** Remove emoji scripts; unused and render-blocking-adjacent. */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
