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
		'https://fonts.googleapis.com/css2?family=League+Spartan:wght@700&family=Figtree:wght@400;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'kg-main', get_template_directory_uri() . '/assets/css/main.css', array( 'kg-fonts' ), KG_VERSION );
	wp_enqueue_style( 'kg-motion', get_template_directory_uri() . '/assets/css/motion.css', array( 'kg-main' ), KG_VERSION );
	$defer = array( 'strategy' => 'defer', 'in_footer' => true );
	wp_enqueue_script( 'kg-main', get_template_directory_uri() . '/assets/js/main.js', array(), KG_VERSION, $defer );
	wp_enqueue_script( 'kg-motion', get_template_directory_uri() . '/assets/js/motion.js', array( 'kg-main' ), KG_VERSION, $defer );
	wp_localize_script( 'kg-motion', 'KG', array(
		'rateLow'  => (int) kg_opt( 'rate_low' ),
		'rateHigh' => (int) kg_opt( 'rate_high' ),
		'currency' => kg_opt( 'currency' ),
	) );
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

/**
 * The original KG Studios logo, inline and unchanged (white letters, gold mark). It always sits on an
 * ink tile (.brand), so it keeps its real colours on every chapter.
 */
function kg_logo( $class = '' ) {
	static $svg = null;
	if ( null === $svg ) {
		$raw = (string) file_get_contents( get_template_directory() . '/assets/img/logo.svg' );
		$svg = preg_replace( '/\s(?:id|data-name|width|height)="[^"]*"/', '', $raw );
	}
	return str_replace( '<svg ', '<svg class="kg-logo ' . esc_attr( $class ) . '" role="img" aria-label="KG Studios" ', $svg );
}

function kg_defaults() {
	return array(
		'email'     => 'connect@kgstudios.io',
		'phone'     => '9650645985',
		'whatsapp'  => '',
		'booking'   => '',
		'address'   => 'Gurgaon, India',
		'facebook'  => '',
		'instagram' => '',
		'linkedin'  => '',
		'currency'  => '₹',
		'rate_low'  => 0,
		'rate_high' => 0,
	);
}

/** Contact details and settings from the Customizer, with site defaults. */
function kg_opt( $key ) {
	$d = kg_defaults();
	return get_theme_mod( 'kg_' . $key, $d[ $key ] ?? '' );
}

/** Page URL by path or slug (e.g. "contact" or "contact/thank-you"), falling back to a URL that resolves once the page exists. */
function kg_page_url( $path ) {
	$page = get_page_by_path( $path );
	return $page ? get_permalink( $page ) : home_url( '/' . $path . '/' );
}

/** Primary nav fallback when no menu is assigned. Mirrors the menu the installer builds. */
function kg_fallback_menu() {
	$all = kg_pages();
	echo '<ul class="nav__list">';
	foreach ( kg_menu_tree( 'primary' ) as $slug => $children ) {
		printf( '<li class="%s"><a href="%s">%s</a>', $children ? 'menu-item-has-children' : '', esc_url( kg_slug_url( $slug ) ), esc_html( $all[ $slug ]['title'] ) );
		if ( $children ) {
			echo '<ul class="sub-menu">';
			foreach ( $children as $c ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( kg_slug_url( $c ) ), esc_html( $all[ $c ]['title'] ) );
			}
			echo '</ul>';
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * The old Elementor Home page uses Elementor's Canvas template, which replaces whatever template
 * the theme picks. Always render the theme's own home for the front page.
 */
add_filter( 'template_include', function ( $template ) {
	if ( is_front_page() ) {
		$home = locate_template( 'front-page.php' );
		if ( $home ) {
			return $home;
		}
	}
	return $template;
}, 99 );

/** Remove emoji scripts; unused. */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Google Search Console verification and Google Analytics (GA4).
 * Consent Mode v2: analytics storage is denied until the visitor accepts in the banner.
 * Keep either this tag or Site Kit's, not both, or visits are counted twice.
 */
add_action( 'wp_head', function () {
	?>
<meta name="google-site-verification" content="QHZ9znF5DCohfZ1H8brp3DRdLwUf997io-PMHkVecps" />
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('consent', 'default', { ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied', analytics_storage: 'denied', wait_for_update: 500 });
  try { if (localStorage.getItem('kg_consent') === 'granted') { gtag('consent', 'update', { analytics_storage: 'granted' }); } } catch (e) {}
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2NFZYHHWKH"></script>
<script>
  gtag('js', new Date());
  gtag('config', 'G-2NFZYHHWKH');
</script>
	<?php
}, 1 );
