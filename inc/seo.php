<?php
/**
 * SEO: page titles and descriptions, structured data, social tags, robots rules, llms.txt.
 *
 * Titles and descriptions come from kg_seo_table() / pages-data.php and are applied whether or not
 * Yoast, Rank Math or AIOSEO is active. With a plugin active it keeps ownership of Open Graph tags,
 * Organization and breadcrumb data; the theme adds the agency, service and FAQ data on top.
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

/**
 * Search titles (about 60 characters including the brand) and optional descriptions (about 155).
 * A page missing here falls back to its own title / meta / lead.
 */
function kg_seo_table() {
	return array(
		'home'                           => array( 'Presentation & Brand Design Agency in Gurgaon | KG Studios', 'Presentation, brand and digital design agency in Gurgaon. Pitch decks, keynotes and identities for founders, corporates and consulting firms.' ),
		'services'                       => array( 'Presentation, Brand & Digital Design Services | KG Studios', null ),
		'presentation-design'            => array( 'Presentation Design Agency in India | KG Studios', null ),
		'pitch-and-investor-decks'       => array( 'Pitch Deck Design for Startups & Investors | KG Studios', 'Investor-ready pitch deck design to help startups raise funding faster. Story, slides and charts from a Gurgaon presentation design agency.' ),
		'sales-and-marketing-decks'      => array( 'Sales & Marketing Presentation Design | KG Studios', 'High-conversion sales presentation design for enterprise deal closure. Branded, reusable decks for sales and marketing teams.' ),
		'event-and-conference-keynotes'  => array( 'Keynote & Conference Presentation Design | KG Studios', 'Professional presentation design for corporate events, conferences and webinars. Slides built for the big screen.' ),
		'proposal-and-consulting-decks'  => array( 'Consulting Proposal & SteerCo Deck Design | KG Studios', 'Executive SteerCo and proposal deck design for consulting teams and leaders, by alumni of BCG, KPMG and ZS.' ),
		'annual-and-esg-reports'         => array( 'Annual & ESG Report Design | KG Studios', 'Annual and ESG reports designed to be read, shared and presented. Layout, data visuals and editable files.' ),
		'presentation-template-creation' => array( 'PowerPoint Template Design, Copilot-Ready | KG Studios', 'Custom, on-brand PowerPoint template systems that are scalable and AI-Copilot compatible, built for whole teams.' ),
		'outsourced-presentation-design' => array( 'Outsourced Presentation Design Team | KG Studios', 'A presentation design team on call, working under NDA-backed workflows, without the cost of an in-house hire.' ),
		'presentation-design-training'   => array( 'Presentation Design Training for Teams | KG Studios', 'Training that helps your team build clearer, better-looking slides: storytelling, slide design and PowerPoint practice.' ),
		'dam-and-web-add-ins'            => array( 'DAM & PowerPoint Add-ins for Brand Assets | KG Studios', 'Connect your brand assets and approved templates to the tools your team already uses.' ),
		'brand-identity'                 => array( 'Brand Identity Design for Startups | KG Studios', null ),
		'digital-design'                 => array( 'Website, Landing Page & Social Design | KG Studios', null ),
		'who-we-serve'                   => array( 'Who We Serve: Presentation & Brand Design | KG Studios', null ),
		'startups-and-founders'          => array( 'Pitch Decks & Branding for Startup Founders | KG Studios', 'Pitch decks and brand identity that make a young company look as credible as it feels, for startups and founders.' ),
		'corporate-and-enterprise-teams' => array( 'Presentation Design for Enterprise Teams | KG Studios', 'On-brand presentations, keynotes and campaign creatives for corporate and enterprise marketing, sales and brand teams.' ),
		'consulting-firms'               => array( 'Presentation Design for Consulting Firms | KG Studios', 'Proposal decks, SteerCo presentations and firm-wide templates for consulting firms, by alumni of BCG, KPMG and ZS.' ),
		'work'                           => array( 'Our Work: Before & After Slide Redesigns | KG Studios', null ),
		'about'                          => array( 'About KG Studios | Gurgaon Presentation Design Agency', null ),
		'process'                        => array( 'Our Presentation Design Process | KG Studios', null ),
		'pricing'                        => array( 'Presentation Design Pricing & Engagement | KG Studios', null ),
		'faq'                            => array( 'Presentation Design FAQ | KG Studios', null ),
		'insights'                       => array( 'Presentation & Brand Design Insights | KG Studios', null ),
		'contact'                        => array( 'Contact KG Studios | Get a Design Quote', null ),
		'sitemap'                        => array( 'Sitemap | KG Studios', null ),
	);
}

/** Cut text to a snippet length at a word boundary. */
function kg_snippet( $text, $max = 155 ) {
	$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $text ) ) );
	if ( strlen( $text ) <= $max ) {
		return $text;
	}
	$cut = substr( $text, 0, $max - 1 );
	$pos = strrpos( $cut, ' ' );
	return rtrim( false === $pos ? $cut : substr( $cut, 0, $pos ), ' ,.;:–-' ) . '…';
}

/**
 * Title and description for the current request, or null when the theme has nothing specific.
 * Returns array( title, description, image file ).
 */
function kg_seo_for_current() {
	static $cache = array();
	$slug = is_front_page() ? 'home' : kg_current_slug();
	if ( '' === $slug ) {
		return null;
	}
	if ( array_key_exists( $slug, $cache ) ) {
		return $cache[ $slug ];
	}
	$table = kg_seo_table();
	if ( empty( $table[ $slug ][0] ) ) {
		$cache[ $slug ] = null;
		return null;
	}
	$page = kg_pages()[ $slug ] ?? array();
	$desc = $table[ $slug ][1];
	if ( ! $desc ) {
		$desc = $page['meta'] ?? ( $page['lead'] ?? 'KG Studios is a specialized presentation design agency headquartered in Gurgaon, India' );
	}
	$cache[ $slug ] = array( $table[ $slug ][0], kg_snippet( $desc ), $page['image'] ?? 'about.png' );
	return $cache[ $slug ];
}

/* ---- Titles and descriptions, applied with or without an SEO plugin ---- */
add_filter( 'pre_get_document_title', function ( $title ) {
	$cur = kg_seo_for_current();
	return $cur ? $cur[0] : $title;
}, 99 );

foreach ( array( 'wpseo_title', 'wpseo_opengraph_title', 'wpseo_twitter_title' ) as $kg_hook ) {
	add_filter( $kg_hook, function ( $title ) {
		$cur = kg_seo_for_current();
		return $cur ? $cur[0] : $title;
	}, 99 );
}
foreach ( array( 'wpseo_metadesc', 'wpseo_opengraph_desc', 'wpseo_twitter_description' ) as $kg_hook ) {
	add_filter( $kg_hook, function ( $desc ) {
		$cur = kg_seo_for_current();
		return $cur ? $cur[1] : $desc;
	}, 99 );
}
unset( $kg_hook );

/** Social share image: the page's own image, else the studio picture. Yoast would otherwise pick a random in-page image. */
add_filter( 'wpseo_opengraph_image', function ( $image ) {
	$cur = kg_seo_for_current();
	return $cur ? get_template_directory_uri() . '/assets/img/' . $cur[2] : $image;
}, 99 );

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

/** The agency as a ProfessionalService, with its service catalogue. Facts only; nothing here is invented. */
function kg_agency_ld() {
	$all      = kg_pages();
	$services = array();
	foreach ( array_merge( $all['presentation-design']['children'], array( 'brand-identity', 'digital-design' ) ) as $slug ) {
		$services[] = array(
			'@type'       => 'Offer',
			'itemOffered' => array( '@type' => 'Service', 'name' => $all[ $slug ]['title'], 'url' => kg_slug_url( $slug ) ),
		);
	}
	$socials = array_values( array_filter( array( kg_opt( 'facebook' ), kg_opt( 'instagram' ), kg_opt( 'linkedin' ) ) ) );
	return array_filter( array(
		'@type'           => 'ProfessionalService',
		'@id'             => home_url( '/#agency' ),
		'name'            => 'KG Studios',
		'url'             => home_url( '/' ),
		'logo'            => get_template_directory_uri() . '/assets/img/favicon.png',
		'image'           => get_template_directory_uri() . '/assets/img/about.png',
		'description'     => 'KG Studios is a specialized presentation, brand, and digital design agency headquartered in Gurgaon, India, led by alumni from BCG, KPMG, and ZS.',
		'email'           => kg_opt( 'email' ),
		'telephone'       => kg_opt( 'phone' ),
		'address'         => array( '@type' => 'PostalAddress', 'addressLocality' => 'Gurgaon', 'addressCountry' => 'IN' ),
		'areaServed'      => array( 'India', 'Middle East' ),
		'knowsAbout'      => array( 'Presentation design', 'Pitch decks', 'Brand identity', 'PowerPoint templates', 'Digital design' ),
		'founder'         => array( '@type' => 'Person', 'name' => 'Kamal Ghanghas', 'jobTitle' => 'Co-Founder & Creative Director' ),
		'hasOfferCatalog' => array( '@type' => 'OfferCatalog', 'name' => 'KG Studios services', 'itemListElement' => $services ),
		'sameAs'          => $socials,
	) );
}

add_action( 'wp_head', function () {
	$plugin = kg_has_seo_plugin();
	$slug   = kg_current_slug();
	$data   = $slug ? kg_page_data( $slug ) : null;

	if ( is_front_page() ) {
		kg_ld( kg_agency_ld() );
		if ( ! $plugin ) {
			kg_ld( array( '@type' => 'WebSite', '@id' => home_url( '/#website' ), 'name' => 'KG Studios', 'url' => home_url( '/' ), 'inLanguage' => 'en' ) );
		}
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
			'serviceType' => $data['title'],
			'description' => $data['lead'],
			'url'         => get_permalink(),
			'provider'    => array( '@id' => home_url( '/#agency' ) ),
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

	// Description and social tags (only when no SEO plugin prints them).
	$cur  = kg_seo_for_current();
	$desc = $cur ? $cur[1] : 'KG Studios is a specialized presentation design agency headquartered in Gurgaon, India';
	if ( ! $cur && is_singular() && has_excerpt() ) {
		$desc = kg_snippet( get_the_excerpt() );
	}
	$image = $cur ? $cur[2] : 'about.png';
	if ( is_singular( 'kg_case' ) && get_post_meta( get_the_ID(), 'kg_after', true ) ) {
		$image_url = get_post_meta( get_the_ID(), 'kg_after', true );
	} else {
		$image_url = get_template_directory_uri() . '/assets/img/' . $image;
	}
	printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:site_name\" content=\"KG Studios\">\n<meta property=\"og:locale\" content=\"en_IN\">\n<meta property=\"og:type\" content=\"%s\">\n", is_singular( 'post' ) ? 'article' : 'website' );
	printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( wp_get_document_title() ) );
	printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $desc ) );
	printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( is_singular() ? get_permalink( get_queried_object_id() ) : home_url( '/' ) ) );
	printf( "<meta property=\"og:image\" content=\"%s\">\n<meta name=\"twitter:card\" content=\"summary_large_image\">\n", esc_url( $image_url ) );
}, 2 );

/* ---- Robots, sitemaps, archives ---- */

function kg_thankyou_id() {
	$page = get_page_by_path( 'contact/thank-you' );
	return $page ? (int) $page->ID : 0;
}

/** The placeholder "Hello world!" post that ships with WordPress. */
function kg_hello_world_id() {
	$post = get_page_by_path( 'hello-world', OBJECT, 'post' );
	return $post ? (int) $post->ID : 0;
}

/** Pages that must stay out of every sitemap and out of the index. */
function kg_noindex_ids() {
	static $ids = null;
	if ( null === $ids ) {
		$ids = array_values( array_filter( array( kg_thankyou_id(), kg_hello_world_id() ) ) );
	}
	return $ids;
}

add_filter( 'wp_robots', function ( $robots ) {
	if ( is_singular() && in_array( (int) get_queried_object_id(), kg_noindex_ids(), true ) ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
	} elseif ( ! is_404() && ! is_search() ) {
		// Allow full snippets and previews in search and AI results.
		$robots['max-snippet']       = '-1';
		$robots['max-video-preview'] = '-1';
	}
	return $robots;
} );

add_filter( 'wpseo_robots', function ( $robots ) {
	return is_singular() && in_array( (int) get_queried_object_id(), kg_noindex_ids(), true ) ? 'noindex, nofollow' : $robots;
} );

add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', function ( $ids ) {
	return array_merge( (array) $ids, kg_noindex_ids() );
} );

add_filter( 'wp_sitemaps_posts_query_args', function ( $args ) {
	$args['post__not_in'] = array_merge( isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array(), kg_noindex_ids() );
	return $args;
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

/* ---- llms.txt: a plain-text map of the site for AI search and assistants ---- */
add_action( 'init', function () {
	add_rewrite_rule( '^llms\.txt$', 'index.php?kg_llms=1', 'top' );
} );
add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'kg_llms';
	return $vars;
} );
add_action( 'template_redirect', function () {
	if ( ! get_query_var( 'kg_llms' ) ) {
		return;
	}
	$all    = kg_pages();
	$out    = "# KG Studios\n\n> Presentation, brand and digital design agency headquartered in Gurgaon, India, led by alumni from BCG, KPMG and ZS. Serves startups and founders, corporate and enterprise teams, and consulting firms across India and the Middle East.\n\n";
	$groups = array(
		'Services'     => array_merge( array( 'services' ), $all['services']['children'], $all['presentation-design']['children'] ),
		'Who we serve' => array_merge( array( 'who-we-serve' ), $all['who-we-serve']['children'] ),
		'Company'      => array( 'work', 'about', 'process', 'pricing', 'faq', 'insights', 'contact' ),
	);
	foreach ( $groups as $heading => $slugs ) {
		$out .= "## $heading\n";
		foreach ( array_unique( $slugs ) as $slug ) {
			$p     = $all[ $slug ];
			$blurb = $p['short'] ?? ( $p['meta'] ?? ( $p['lead'] ?? '' ) );
			$out  .= sprintf( "- [%s](%s)%s\n", $p['title'], kg_slug_url( $slug ), $blurb ? ': ' . kg_snippet( $blurb, 140 ) : '' );
		}
		$out .= "\n";
	}
	$out .= "## Contact\n- Email: " . kg_opt( 'email' ) . "\n- Phone: " . kg_opt( 'phone' ) . "\n- Location: " . kg_opt( 'address' ) . "\n";
	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo $out; // phpcs:ignore WordPress.Security.EscapeOutput -- plain text built from theme data.
	exit;
} );
