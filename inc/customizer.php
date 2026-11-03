<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'kg_contact', array(
		'title'    => __( 'KG Studios contact & social', 'kgstudios' ),
		'priority' => 30,
	) );

	$fields = array(
		'email'     => array( __( 'Email', 'kgstudios' ), 'sanitize_email' ),
		'phone'     => array( __( 'Phone', 'kgstudios' ), 'sanitize_text_field' ),
		'address'   => array( __( 'Address', 'kgstudios' ), 'sanitize_text_field' ),
		'facebook'  => array( __( 'Facebook URL', 'kgstudios' ), 'esc_url_raw' ),
		'instagram' => array( __( 'Instagram URL', 'kgstudios' ), 'esc_url_raw' ),
		'linkedin'  => array( __( 'LinkedIn URL', 'kgstudios' ), 'esc_url_raw' ),
	);

	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting( 'kg_' . $key, array(
			'default'           => kg_opt( $key ),
			'sanitize_callback' => $f[1],
		) );
		$wp_customize->add_control( 'kg_' . $key, array(
			'label'   => $f[0],
			'section' => 'kg_contact',
			'type'    => 'email' === $key ? 'email' : 'text',
		) );
	}
} );
