<?php
/**
 * KG Studios theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KG_VERSION', '2.2.0' );

$kg_inc = get_template_directory() . '/inc/';
require_once $kg_inc . 'pages-data.php';
require_once $kg_inc . 'setup.php';
require_once $kg_inc . 'content.php';
require_once $kg_inc . 'post-types.php';
require_once $kg_inc . 'customizer.php';
require_once $kg_inc . 'contact-form.php';
require_once $kg_inc . 'seo.php';
require_once $kg_inc . 'install.php';
unset( $kg_inc );
