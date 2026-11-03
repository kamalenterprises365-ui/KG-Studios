<?php
/**
 * Integrity check for the page tree in inc/pages-data.php. Run on staging:
 *   wp eval-file wp-content/themes/KG-Studios/tests/pages-data.php
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( "Run with WP-CLI: wp eval-file tests/pages-data.php\n" );
}

$all  = kg_pages();
$fail = 0;
$bad  = function ( $msg ) use ( &$fail ) {
	$fail++;
	echo "FAIL $msg\n";
};

foreach ( $all as $slug => $p ) {
	if ( $p['parent'] && ! isset( $all[ $p['parent'] ] ) ) {
		$bad( "$slug: unknown parent {$p['parent']}" );
	}
	foreach ( array_merge( $p['children'] ?? array(), $p['related'] ?? array() ) as $ref ) {
		if ( ! isset( $all[ $ref ] ) ) {
			$bad( "$slug: unknown link $ref" );
		}
	}
	foreach ( $p['faq'] ?? array() as $n ) {
		if ( ! isset( kg_faq()[ $n ] ) ) {
			$bad( "$slug: unknown faq $n" );
		}
	}
	if ( 'template' !== $p['type'] && empty( $p['lead'] ) ) {
		$bad( "$slug: missing lead" );
	}
	if ( ! empty( $p['image'] ) && ! file_exists( get_template_directory() . '/assets/img/' . $p['image'] ) ) {
		$bad( "$slug: missing image {$p['image']}" );
	}
	if ( 'template' === $p['type'] && 'home' !== $slug && ! file_exists( get_template_directory() . "/page-$slug.php" ) ) {
		$bad( "$slug: missing page-$slug.php" );
	}
}

echo $fail ? "$fail problem(s)\n" : 'PASS ' . count( $all ) . " pages\n";
exit( $fail ? 1 : 0 );
