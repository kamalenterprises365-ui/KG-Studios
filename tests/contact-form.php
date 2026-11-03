<?php
/**
 * Smoke test for kg_process_lead(). Run on a staging site with the theme active:
 *   wp eval-file wp-content/themes/KG-Studios/tests/contact-form.php
 * Mail is intercepted, test leads are deleted afterwards.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( "Run with WP-CLI: wp eval-file tests/contact-form.php\n" );
}

$mails = 0;
add_filter( 'pre_wp_mail', function () use ( &$mails ) { $mails++; return true; } );

$ip   = '203.0.113.' . wp_rand( 1, 250 );
$good = array( 'kg_name' => 'Test User', 'kg_email' => 'test@example.com', 'kg_message' => 'Hi' );
$fail = 0;
$check = function ( $label, $actual, $expected ) use ( &$fail ) {
	$ok = $actual === $expected;
	$fail += $ok ? 0 : 1;
	printf( "%s %s\n", $ok ? 'PASS' : 'FAIL', $label . ( $ok ? '' : " (got " . var_export( $actual, true ) . ')' ) );
};

$check( 'bad email is invalid', kg_process_lead( array( 'kg_name' => 'A', 'kg_email' => 'nope' ), $ip ), 'invalid' );
$check( 'missing name is invalid', kg_process_lead( array( 'kg_email' => 'a@example.com' ), $ip ), 'invalid' );
$check( 'honeypot fakes ok, sends nothing', kg_process_lead( $good + array( 'kg_website' => 'spam.com' ), $ip ), 'ok' );
$check( 'no mail sent so far', $mails, 0 );
$check( 'valid lead is ok', kg_process_lead( $good, $ip ), 'ok' );
$check( 'valid lead sent one mail', $mails, 1 );
$check( 'second lead from same IP waits', kg_process_lead( $good, $ip ), 'wait' );

$leads = get_posts( array( 'post_type' => 'kg_lead', 'post_status' => 'private', 'title' => 'Test User', 'numberposts' => -1 ) );
$check( 'valid lead was stored once', count( $leads ), 1 );

// Hourly cap: with a different (forged) IP every time, enquiries stop after the cap.
$cap = (int) apply_filters( 'kg_lead_hourly_cap', 20 );
$last = '';
for ( $i = 0; $i <= $cap; $i++ ) {
	$last = kg_process_lead( $good, '198.51.100.' . $i );
}
$check( 'enquiry beyond the hourly cap waits', $last, 'wait' );

foreach ( get_posts( array( 'post_type' => 'kg_lead', 'post_status' => 'private', 'title' => 'Test User', 'numberposts' => -1 ) ) as $p ) {
	wp_delete_post( $p->ID, true );
}
delete_transient( 'kg_lead_' . md5( $ip ) );
for ( $i = 0; $i <= $cap; $i++ ) {
	delete_transient( 'kg_lead_' . md5( '198.51.100.' . $i ) );
}
delete_transient( 'kg_lead_h_' . gmdate( 'YmdH' ) );
exit( $fail ? 1 : 0 );
