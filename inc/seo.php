<?php
/**
 * SEO basics: structured data, description and social tags, robots rules.
 * If Yoast, Rank Math or AIOSEO is active, it owns the description, social tags,
 * Organization and breadcrumb data; the theme only adds Service and FAQ data.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kg_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/** Slug of the current page, or '' when not on a page. */
function kg_current_slug() {
	return is_page() ? (string) get_post_field( 'post_name', get_queried_object_id() ) : '';
}

function kg_ld( array $data ) {
	printf(
		"<script type=\"application/ld+json\">%s</script>\n",
		wp_json_encode( array( '@context' => 'https://schema.org' ) + $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG )
	);
}

function kg_faq_ld( array $items ) {
	$entities = array();
	foreach ( $items as $qa ) {
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $qa[0],
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $qa[1] ),
		);
	}
	kg_ld( array( '@type' => 'FAQPage', 'mainEntity' => $entities ) );
}

add_action( 'wp_head', function () {
	$plugin = kg_has_seo_plugin();
	$slug   = kg_current_slug();
	$data   = $slug ? kg_page_data( $slug ) : null;

	if ( ! $plugin && is_front_page() ) {
		$socials = array_values( array_filter( array( kg_opt( 'facebook' ), kg_opt( 'instagram' ), kg_opt( 'linkedin' ) ) ) );
		kg_ld( array_filter( array(
			'@type'        => 'ProfessionalService',
			'name'         => 'KG Studios',
			'url'          => home_url( '/' ),
			'logo'         => get_template_directory_uri() . '/assets/img/favicon.png',
			'image'        => get_template_directory_uri() . '/assets/img/about.png',
			'description'  => 'KG Studios is a specialized presentation, brand, and digital design agency headquartered in Gurgaon, India.',
			'email'        => kg_opt( 'email' ),
			'telephone'    => kg_opt( 'phone' ),
			'address'      => array( '@type' => 'PostalAddress', 'addressLocality' => 'Gurgaon', 'addressCountry' => 'IN' ),
			'areaServed'   => array( 'India', 'Middle East' ),
			'sameAs'       => $socials,
		) ) );
	}

	if ( ! $plugin && is_page() && get_post_ancestors( get_queried_object_id() ) ) {
		$crumbs = array();
		$ids    = array_reverse( get_post_ancestors( get_queried_object_id() ) );
		$ids[]  = get_queried_object_id();
		foreach ( $ids as $i => $id ) {
			$crumbs[] = array( '@type' => 'ListItem', 'position' => $i + 1, 'name' => get_the_title( $id ), 'item' => get_permalink( $id ) );
		}
		kg_ld( array( '@type' => 'BreadcrumbList', 'itemListElement' => $crumbs ) );
	}

	if ( $data && 'detail' === $data['type'] && ! empty( $data['who'] ) && 'who-we-serve' !== $data['parent'] ) {
		kg_ld( array(
			'@type'       => 'Service',
			'name'        => $data['title'],
			'description' => $data['lead'],
			'provider'    => array( '@type' => 'ProfessionalService', 'name' => 'KG Studios', 'url' => home_url( '/' ) ),
			'areaServed'  => array( 'India', 'Middle East' ),
		) );
	}

	$faq = kg_faq();
	if ( $data && ! empty( $data['faq'] ) ) {
		kg_faq_ld( array_values( array_intersect_key( $faq, array_flip( $data['faq'] ) ) ) );
	} elseif ( 'faq' === $slug ) {
		kg_faq_ld( array_values( $faq ) );
	}

	if ( $plugin ) {
		return;
	}

	// Description and social tags.
	$all  = kg_pages();
	$desc = 'KG Studios is a specialized presentation design agency headquartered in Gurgaon, India';
	if ( $slug && isset( $all[ $slug ] ) ) {
		$desc = $all[ $slug ]['meta'] ?? ( $all[ $slug ]['lead'] ?? $desc );
	} elseif ( is_singular() && has_excerpt() ) {
		$desc = get_the_excerpt();
	}
	$desc  = wp_strip_all_tags( $desc );
	$image = ( $slug && ! empty( $all[ $slug ]['image'] ) ) ? $all[ $slug ]['image'] : 'about.png';
	if ( is_singular( 'kg_case' ) && get_post_meta( get_the_ID(), 'kg_after', true ) ) {
		$image_url = get_post_meta( get_the_ID(), 'kg_after', true );
	} else {
		$image_url = get_template_directory_uri() . '/assets/img/' . $image;
	}
	printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:site_name\" content=\"KG Studios\">\n<meta property=\"og:type\" content=\"%s\">\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( wp_get_document_title() ) );
	printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( is_singular() ? get_permalink() : home_url( '/' ) ) );
	printf( "<meta property=\"og:image\" content=\"%s\">\n<meta name=\"twitter:card\" content=\"summary_large_image\">\n", esc_url( $image_url ) );
}, 2 );

/** Keep the thank-you page out of search results so it only counts real conversions. */
add_filter( 'wp_robots', function ( $robots ) {
	if ( 'thank-you' === kg_current_slug() ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
	}
	return $robots;
} );

/** Author archives expose usernames and add thin pages: send them home and drop them from the core sitemap. */
add_action( 'template_redirect', function () {
	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );
