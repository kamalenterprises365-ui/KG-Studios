<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * On activation: create the core pages and the primary menu if they do not exist,
 * and use a static front page. Existing pages and menus are never overwritten.
 */
add_action( 'after_switch_theme', function () {
	$pages = array(
		'home'     => 'Home',
		'services' => 'Services',
		'work'     => 'Our Work',
		'about'    => 'About',
		'contact'  => 'Contact',
	);

	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}
		$ids[ $slug ] = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => $title,
			'post_name'   => $slug,
		) );
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locations['primary'] ) ) {
		return;
	}

	$menu_id = wp_create_nav_menu( 'KG Primary ' . wp_generate_password( 4, false ) );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}
	foreach ( array( 'home', 'services', 'work', 'about', 'contact' ) as $slug ) {
		if ( empty( $ids[ $slug ] ) || is_wp_error( $ids[ $slug ] ) ) {
			continue;
		}
		wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-object-id' => $ids[ $slug ],
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		) );
	}
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
} );
