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
		'email'     => array( __( 'Email', 'kgstudios' ), 'sanitize_email', 'email' ),
		'phone'     => array( __( 'Phone', 'kgstudios' ), 'sanitize_text_field', 'text' ),
		'whatsapp'  => array( __( 'WhatsApp number with country code (shows a chat button)', 'kgstudios' ), 'sanitize_text_field', 'text' ),
		'booking'   => array( __( 'Booking link, e.g. Calendly (shows a "Book a call" button)', 'kgstudios' ), 'esc_url_raw', 'url' ),
		'address'   => array( __( 'Address', 'kgstudios' ), 'sanitize_text_field', 'text' ),
		'facebook'  => array( __( 'Facebook URL', 'kgstudios' ), 'esc_url_raw', 'url' ),
		'instagram' => array( __( 'Instagram URL', 'kgstudios' ), 'esc_url_raw', 'url' ),
		'linkedin'  => array( __( 'LinkedIn URL', 'kgstudios' ), 'esc_url_raw', 'url' ),
	);

	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting( 'kg_' . $key, array(
			'default'           => kg_defaults()[ $key ],
			'sanitize_callback' => $f[1],
		) );
		$wp_customize->add_control( 'kg_' . $key, array(
			'label'   => $f[0],
			'section' => 'kg_contact',
			'type'    => $f[2],
		) );
	}

	$wp_customize->add_section( 'kg_pricing', array(
		'title'       => __( 'KG Studios quote calculator', 'kgstudios' ),
		'description' => __( 'Fill both rates to show the calculator on the Pricing page. Leave blank to hide it.', 'kgstudios' ),
		'priority'    => 31,
	) );
	$rates = array(
		'currency'  => array( __( 'Currency symbol', 'kgstudios' ), 'sanitize_text_field' ),
		'rate_low'  => array( __( 'Price per slide, from', 'kgstudios' ), 'absint' ),
		'rate_high' => array( __( 'Price per slide, up to', 'kgstudios' ), 'absint' ),
	);
	foreach ( $rates as $key => $f ) {
		$wp_customize->add_setting( 'kg_' . $key, array(
			'default'           => kg_defaults()[ $key ],
			'sanitize_callback' => $f[1],
		) );
		$wp_customize->add_control( 'kg_' . $key, array(
			'label'   => $f[0],
			'section' => 'kg_pricing',
			'type'    => 'currency' === $key ? 'text' : 'number',
		) );
	}
} );
