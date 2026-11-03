<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#0a0c10">
<link rel="icon" href="<?php echo kg_img( 'favicon.png' ); ?>">
<script>document.documentElement.classList.add('js');</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'kgstudios' ); ?></a>
<div class="progress" aria-hidden="true"><i></i></div>

<header class="site-header" data-header>
	<div class="wrap site-header__in">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
			<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
				<img src="<?php echo kg_img( 'logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="120" height="38">
			<?php endif; ?>
		</a>

		<nav class="nav" id="nav" aria-label="<?php esc_attr_e( 'Primary', 'kgstudios' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav__list',
				'fallback_cb'    => 'kg_fallback_menu',
				'depth'          => 1,
			) );
			?>
			<a class="btn btn--gold nav__cta" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'kgstudios' ); ?></a>
		</nav>

		<button class="burger" type="button" aria-controls="nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'kgstudios' ); ?>"><span></span><span></span></button>
	</div>
</header>

<main id="main">
