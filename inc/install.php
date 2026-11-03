<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the page tree and menus. Safe to run repeatedly: existing pages and
 * menus are never overwritten. Runs on theme activation and once per theme version.
 */
add_action( 'after_switch_theme', 'kg_install' );
add_action( 'admin_init', function () {
	if ( get_option( 'kg_installed' ) !== KG_VERSION && current_user_can( 'manage_options' ) ) {
		kg_install();
	}
} );

function kg_install() {
	$all   = kg_pages();
	$ids   = array();
	$paths = array();

	foreach ( $all as $slug => $p ) {
		$paths[ $slug ] = $p['parent'] ? $paths[ $p['parent'] ] . '/' . $slug : $slug;
		$existing       = get_page_by_path( $paths[ $slug ] );
		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => $p['title'],
			'post_name'   => $slug,
			'post_parent' => $p['parent'] ? ( $ids[ $p['parent'] ] ?? 0 ) : 0,
		) );
		if ( $id && ! is_wp_error( $id ) ) {
			$ids[ $slug ] = $id;
		}
	}

	kg_install_menu( 'primary', 'KG Primary', kg_menu_tree( 'primary' ), $ids );
	kg_install_menu( 'footer', 'KG Footer', kg_menu_tree( 'footer' ), $ids );

	// Author archives are redirected home (inc/seo.php); tell Yoast so its sitemap stops listing them.
	$titles = get_option( 'wpseo_titles' );
	if ( is_array( $titles ) && empty( $titles['disable-author'] ) ) {
		$titles['disable-author'] = true;
		update_option( 'wpseo_titles', $titles );
	}

	flush_rewrite_rules( false );
	update_option( 'kg_installed', KG_VERSION );
}

/** Builds a menu for a location, only if that location has none. */
function kg_install_menu( $location, $name, array $tree, array $ids ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locations[ $location ] ) ) {
		return;
	}
	$menu_id = wp_create_nav_menu( $name . ' ' . wp_generate_password( 4, false ) );
	if ( is_wp_error( $menu_id ) ) {
		return;
	}
	$add = function ( $slug, $parent_item = 0 ) use ( $menu_id, $ids ) {
		if ( empty( $ids[ $slug ] ) ) {
			return 0;
		}
		return wp_update_nav_menu_item( $menu_id, 0, array(
			'menu-item-object-id'  => $ids[ $slug ],
			'menu-item-object'     => 'page',
			'menu-item-type'       => 'post_type',
			'menu-item-status'     => 'publish',
			'menu-item-parent-id'  => $parent_item,
		) );
	};
	foreach ( $tree as $slug => $children ) {
		$item = $add( $slug );
		foreach ( $children as $child ) {
			$add( $child, is_wp_error( $item ) ? 0 : $item );
		}
	}
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
