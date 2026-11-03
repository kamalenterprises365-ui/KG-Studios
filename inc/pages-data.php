<?php
/**
 * Page tree and copy for every page that is not a hand-built template.
 * page.php renders any page whose slug is listed here with type "hub" or "detail".
 * Pages with type "template" are created by the installer and use their own page-{slug}.php.
 *
 * Copy is carried over from the previous site where it existed. Where it did not,
 * it is a neutral draft written for the owner to review and edit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kg_pages() {
	static $p = null;
	if ( null !== $p ) {
		return $p;
	}

	$p = array(
		/* ---- Hand-built templates ---- */
		'home'     => array( 'title' => 'Home', 'parent' => '', 'type' => 'template' ),
		'work'     => array( 'title' => 'Our Work', 'parent' => '', 'type' => 'template', 'meta' => 'Before and after: cluttered slides turned into sharp, on-brand presentations by KG Studios.' ),
		'about'    => array( 'title' => 'About', 'parent' => '', 'type' => 'template', 'meta' => 'KG Studios is a presentation, brand and digital design agency in Gurgaon, led by alumni from BCG, KPMG and ZS.' ),
		'process'  => array( 'title' => 'Process', 'parent' => '', 'type' => 'template', 'meta' => 'How KG Studios works: brief, story, design, motion and delivery, under NDA-backed workflows.' ),
		'pricing'  => array( 'title' => 'Pricing', 'parent' => '', 'type' => 'template', 'meta' => 'How KG Studios works with clients: per-project decks, outsourced design teams and template systems.' ),
		'faq'      => array( 'title' => 'FAQ', 'parent' => '', 'type' => 'template', 'meta' => 'Answers about NDAs, tools, pricing and how to start a project with KG Studios.' ),
		'insights' => array( 'title' => 'Insights', 'parent' => '', 'type' => 'template', 'meta' => 'Articles on presentation design, storytelling and brand from KG Studios.' ),
		'contact'  => array( 'title' => 'Contact', 'parent' => '', 'type' => 'template', 'meta' => 'Tell KG Studios who you are and what you need. We will do the rest.' ),
		'thank-you' => array( 'title' => 'Thank you', 'parent' => 'contact', 'type' => 'template' ),
		'sitemap'  => array( 'title' => 'Sitemap', 'parent' => '', 'type' => 'template' ),

		/* ---- Services ---- */
		'services' => array(
			'title'    => 'Services',
			'parent'   => '',
			'type'     => 'hub',
			'h1'       => 'Presentation, brand and <span class="gold">digital</span>',
			'lead'     => 'Where ideas rise, flow, dive, and shine – through powerful presentations.',
			'meta'     => 'Presentation design, brand identity and digital design from KG Studios, a specialist agency in Gurgaon serving India and the Middle East.',
			'children' => array( 'presentation-design', 'brand-identity', 'digital-design' ),
		),
		'presentation-design' => array(
			'title'    => 'Presentation Design',
			'parent'   => 'services',
			'type'     => 'hub',
			'h1'       => 'Presentations that <span class="gold">win the room</span>',
			'lead'     => 'We turn cluttered, inconsistent slides into sharp, on-brand, high-impact presentations built to drive decisions.',
			'meta'     => 'Pitch decks, sales decks, keynotes, consulting decks, ESG reports and templates, designed by KG Studios.',
			'short'    => 'Decks for funding, sales, events and leadership.',
			'image'    => 'svc-1.jpg',
			'children' => array(
				'pitch-and-investor-decks', 'sales-and-marketing-decks', 'event-and-conference-keynotes',
				'proposal-and-consulting-decks', 'annual-and-esg-reports', 'presentation-template-creation',
				'outsourced-presentation-design', 'presentation-design-training', 'dam-and-web-add-ins',
			),
			'work'     => 2,
			'faq'      => array( 1, 2, 3, 5 ),
		),
		'pitch-and-investor-decks' => array(
			'title'   => 'Pitch & Investor Decks',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Pitch decks that help you <span class="gold">raise faster</span>',
			'lead'    => 'Investor-ready pitch deck design to help startups raise funding faster.',
			'short'   => 'Investor-ready pitch deck design to help startups raise funding faster.',
			'image'   => 'svc-1.jpg',
			'who'     => array( 'Founders preparing for a funding round', 'Startups building a demo-day or investor deck', 'Teams refreshing a deck for the next round' ),
			'gets'    => array( 'A clear investor story and slide flow', 'Custom, on-brand slide design', 'Charts and numbers designed to be read at a glance', 'Optional motion for the key moments', 'Editable files in PowerPoint, Google Slides or Keynote' ),
			'outcome' => 'A deck that makes your story easy to follow and easy to back.',
			'related' => array( 'sales-and-marketing-decks', 'brand-identity', 'startups-and-founders' ),
			'faq'     => array( 1, 2, 3, 5 ),
		),
		'sales-and-marketing-decks' => array(
			'title'   => 'Sales & Marketing Decks',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Sales decks built to <span class="gold">close deals</span>',
			'lead'    => 'High-conversion sales presentation design for enterprise deal closure.',
			'short'   => 'High-conversion sales presentation design for enterprise deal closure.',
			'image'   => 'svc-2.jpg',
			'who'     => array( 'Sales teams pitching enterprise buyers', 'Marketing teams launching products or campaigns', 'Founder-led sales conversations' ),
			'gets'    => array( 'Message structure that answers your buyer’s questions', 'A branded slide system your whole team can reuse', 'Product, case study and proof slides designed for clarity', 'Editable files for every seller' ),
			'outcome' => 'Sales conversations that stay focused on value, not on slide formatting.',
			'related' => array( 'presentation-template-creation', 'outsourced-presentation-design', 'corporate-and-enterprise-teams' ),
			'faq'     => array( 1, 2, 3, 5 ),
		),
		'event-and-conference-keynotes' => array(
			'title'   => 'Event & Conference Keynotes',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Keynotes that <span class="gold">hold the room</span>',
			'lead'    => 'Professional presentation design for Corporate events and webinars.',
			'short'   => 'Professional presentation design for Corporate events and webinars.',
			'image'   => 'svc-3.jpg',
			'who'     => array( 'Executives and speakers on stage', 'Corporate event and webinar teams', 'Conference organisers' ),
			'gets'    => array( 'Slides designed for a big screen and a distant audience', 'A narrative flow that holds attention', 'Motion and transitions that support the talk', 'Files prepared for the platform you present on' ),
			'outcome' => 'A talk where the slides support the speaker and the audience remembers the message.',
			'related' => array( 'proposal-and-consulting-decks', 'corporate-and-enterprise-teams' ),
			'faq'     => array( 1, 2, 7, 5 ),
		),
		'proposal-and-consulting-decks' => array(
			'title'   => 'Proposal & Consulting Decks',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Executive decks that <span class="gold">drive decisions</span>',
			'lead'    => 'Executive SteerCo deck design for leadership updates and decisions.',
			'short'   => 'Executive SteerCo deck design for leadership updates and decisions.',
			'image'   => 'svc-4.jpg',
			'who'     => array( 'Consulting teams preparing proposals', 'Leaders presenting updates to a SteerCo', 'Teams that need decisions, not just information' ),
			'gets'    => array( 'A storyline and executive summary structure', 'Clean, consistent slide design', 'Frameworks, charts and tables designed for clarity', 'Templates your team can keep using' ),
			'outcome' => 'Leadership reads the point first and the detail second.',
			'related' => array( 'presentation-template-creation', 'outsourced-presentation-design', 'consulting-firms' ),
			'faq'     => array( 1, 2, 3, 5 ),
		),
		'annual-and-esg-reports' => array(
			'title'   => 'Annual & ESG Reports',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Annual and ESG reports <span class="gold">worth reading</span>',
			'lead'    => 'Annual and ESG reports designed to be read, shared and presented.',
			'short'   => 'Annual and ESG reports designed to be read, shared and presented.',
			'image'   => 'svc-5.jpg',
			'who'     => array( 'Corporate communications and investor relations teams', 'Sustainability and ESG teams', 'Companies publishing yearly results' ),
			'gets'    => array( 'A layout and design system for the report', 'Data visualisation and infographic design', 'A consistent look across report, deck and summary', 'Editable source files' ),
			'outcome' => 'A report that looks as credible as the numbers inside it.',
			'related' => array( 'proposal-and-consulting-decks', 'corporate-and-enterprise-teams' ),
			'faq'     => array( 1, 2, 3, 5 ),
		),
		'presentation-template-creation' => array(
			'title'   => 'Presentation Template Creation',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Templates that keep every deck <span class="gold">on-brand</span>',
			'lead'    => 'Custom Template system – scalable, on-brand, and AI-Copilot compatible.',
			'short'   => 'Custom Template system – scalable, on-brand, and AI-Copilot compatible.',
			'image'   => 'svc-6.jpg',
			'who'     => array( 'Teams whose decks look different every time', 'Organisations rolling out Microsoft Copilot', 'Brand teams that need one presentation standard' ),
			'gets'    => array( 'Master slides and layouts built on your brand', 'Reusable components: charts, tables, icons', 'A Copilot-compatible structure', 'A short usage guide for your team' ),
			'outcome' => 'Anyone in your company can build a good-looking, on-brand deck.',
			'related' => array( 'outsourced-presentation-design', 'presentation-design-training', 'consulting-firms' ),
			'faq'     => array( 1, 2, 3, 5 ),
		),
		'outsourced-presentation-design' => array(
			'title'   => 'Outsourced Presentation Design',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'A presentation design team <span class="gold">on call</span>',
			'lead'    => 'Your own presentation design team, without the cost of hiring one.',
			'short'   => 'Your own presentation design team, without the cost of hiring one.',
			'image'   => 'about.png',
			'who'     => array( 'Teams with a steady flow of decks', 'Consulting firms and agencies with peak workloads', 'Companies without an in-house design team' ),
			'gets'    => array( 'A team that learns your brand and style', 'One point of contact for every request', 'NDA-backed, secure workflows', 'Capacity that scales up and down with your needs' ),
			'outcome' => 'Decks arrive ready to present, and your own team stays focused on the content.',
			'related' => array( 'presentation-template-creation', 'consulting-firms', 'corporate-and-enterprise-teams' ),
			'faq'     => array( 1, 2, 4, 5 ),
		),
		'presentation-design-training' => array(
			'title'   => 'Presentation Design Training',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Train your team to build <span class="gold">better slides</span>',
			'lead'    => 'Help your team build clearer, better-looking slides themselves.',
			'short'   => 'Help your team build clearer, better-looking slides themselves.',
			'image'   => 'design.jpg',
			'who'     => array( 'Teams that build their own decks', 'Managers who want consistent slide quality', 'Consultants and analysts' ),
			'gets'    => array( 'Practical sessions on storytelling and slide design', 'Tips for PowerPoint and Google Slides', 'Before and after exercises using real slides' ),
			'outcome' => 'Every deck your team builds starts from a stronger place.',
			'related' => array( 'presentation-template-creation', 'outsourced-presentation-design' ),
			'faq'     => array( 2, 4, 5, 6 ),
		),
		'dam-and-web-add-ins' => array(
			'title'   => 'DAM and Web Add-ins',
			'parent'  => 'presentation-design',
			'type'    => 'detail',
			'h1'      => 'Brand assets, <span class="gold">where your team works</span>',
			'lead'    => 'Connect your brand assets and templates to the tools your team already uses.',
			'short'   => 'Connect your brand assets and templates to the tools your team already uses.',
			'image'   => 'svc-6.jpg',
			'who'     => array( 'Brand and marketing teams managing assets', 'Organisations standardising their presentations' ),
			'gets'    => array( 'Digital asset management set-up for brand and slide assets', 'Add-ins that bring approved templates into PowerPoint', 'Guidance for rolling it out to your team' ),
			'outcome' => 'Approved assets are easy to find and easy to use.',
			'related' => array( 'presentation-template-creation', 'outsourced-presentation-design' ),
			'faq'     => array( 1, 2, 5, 6 ),
		),
		'brand-identity' => array(
			'title'   => 'Brand Identity',
			'parent'  => 'services',
			'type'    => 'detail',
			'h1'      => 'Brand identities that <span class="gold">stand out</span>',
			'lead'    => 'We craft distinctive brand identities for startups and growing businesses – from new launches to brand refresh initiatives – helping brands stand out with clarity and consistency.',
			'meta'    => 'Logo and visual identity, brand guidelines, employer branding, collaterals and packaging design from KG Studios.',
			'short'   => 'Logo, identity systems, guidelines and collaterals.',
			'image'   => 'design.jpg',
			'who'     => array( 'Startups preparing to launch', 'Growing businesses refreshing their brand', 'Teams building an employer brand' ),
			'gets'    => array( 'Logo & visual identity systems', 'Brand guidelines & toolkits', 'Employer Branding', 'Marketing collaterals', 'Packaging design' ),
			'outcome' => 'A brand that looks consistent everywhere it appears.',
			'related' => array( 'pitch-and-investor-decks', 'digital-design', 'startups-and-founders' ),
			'faq'     => array( 3, 4, 5, 6 ),
		),
		'digital-design' => array(
			'title'   => 'Digital Design',
			'parent'  => 'services',
			'type'    => 'detail',
			'h1'      => 'Digital experiences that <span class="gold">convert</span>',
			'lead'    => 'We bring brands to life through engaging digital experiences. From high-performing websites and landing pages to social media and campaign creatives, we design intuitive, conversion-focused solutions that drive impact across platforms.',
			'meta'    => 'Website UX/UI, landing pages, social media and campaign creatives from KG Studios.',
			'short'   => 'Websites, landing pages, social and campaign creatives.',
			'image'   => 'about.png',
			'who'     => array( 'Brands launching or relaunching a website', 'Marketing teams running campaigns', 'Teams that need steady social content' ),
			'gets'    => array( 'Website design (UX/UI)', 'Landing pages & campaign microsites', 'Social media creatives & management', 'Digital campaign creatives & website interactives' ),
			'outcome' => 'A digital presence that is easy to use and easy to act on.',
			'related' => array( 'brand-identity', 'sales-and-marketing-decks', 'corporate-and-enterprise-teams' ),
			'faq'     => array( 3, 4, 5, 6 ),
		),

		/* ---- Who we serve ---- */
		'who-we-serve' => array(
			'title'    => 'Who We Serve',
			'parent'   => '',
			'type'     => 'hub',
			'h1'       => 'Built for teams that <span class="gold">present</span>',
			'lead'     => 'Presentation & brand design for teams across India and the Middle East.',
			'meta'     => 'KG Studios designs presentations and brands for startups and founders, corporate and enterprise teams, and consulting firms in India and the Middle East.',
			'children' => array( 'startups-and-founders', 'corporate-and-enterprise-teams', 'consulting-firms' ),
		),
		'startups-and-founders' => array(
			'title'   => 'Startups & Founders',
			'parent'  => 'who-we-serve',
			'type'    => 'detail',
			'h1'      => 'Pitch decks and brands for <span class="gold">founders</span>',
			'lead'    => 'Look as credible as you feel. We build the pitch deck and brand identity that make a young company easy to believe in.',
			'short'   => 'Pitch decks and brand identity for startups & founders.',
			'image'   => 'hero-1.jpg',
			'who'     => array( 'Founders raising a funding round', 'Startups launching a new brand', 'Teams preparing for demo days and investor meetings' ),
			'gets'    => array( 'An investor-ready pitch deck', 'A brand identity that fits your stage', 'A website or landing page to match', 'One consistent look across all of it' ),
			'outcome' => 'Investors notice the difference immediately.',
			'related' => array( 'pitch-and-investor-decks', 'brand-identity', 'digital-design' ),
			'faq'     => array( 1, 3, 5, 6 ),
		),
		'corporate-and-enterprise-teams' => array(
			'title'   => 'Corporate & Enterprise Teams',
			'parent'  => 'who-we-serve',
			'type'    => 'detail',
			'h1'      => 'Decks and brands for <span class="gold">enterprise teams</span>',
			'lead'    => 'On-brand, visually compelling work that performs across every platform, from marketing decks to campaign creatives.',
			'short'   => 'Presentations & brand design for corporate & enterprise teams.',
			'image'   => 'hero-3.jpg',
			'who'     => array( 'Marketing and communications teams', 'Sales and business development teams', 'Brand and corporate affairs teams' ),
			'gets'    => array( 'Marketing and sales presentations', 'Event and conference keynotes', 'Template systems for the whole company', 'Digital and campaign creatives' ),
			'outcome' => 'A creative partner that keeps every touchpoint on brand.',
			'related' => array( 'sales-and-marketing-decks', 'event-and-conference-keynotes', 'presentation-template-creation', 'outsourced-presentation-design' ),
			'faq'     => array( 1, 2, 4, 5 ),
		),
		'consulting-firms' => array(
			'title'   => 'Consulting Firms',
			'parent'  => 'who-we-serve',
			'type'    => 'detail',
			'h1'      => 'Proposal decks for <span class="gold">consulting firms</span>',
			'lead'    => 'Consulting moves fast and clients expect polished work at every touchpoint. We are led by alumni of BCG, KPMG and ZS, so we speak your language.',
			'short'   => 'Proposal decks & executive presentations for consulting firms.',
			'image'   => 'hero-2.jpg',
			'who'     => array( 'Partners and managers writing proposals', 'Teams presenting to a SteerCo', 'Firms that need extra design capacity at peak times' ),
			'gets'    => array( 'Proposal and SteerCo decks', 'Firm-wide template systems', 'An outsourced design team that works under NDA', 'Client-facing collaterals' ),
			'outcome' => 'Work that is on brief, on time and ready for the client.',
			'related' => array( 'proposal-and-consulting-decks', 'outsourced-presentation-design', 'presentation-template-creation' ),
			'faq'     => array( 1, 2, 4, 5 ),
		),
	);

	return $p;
}

/** Page data for a slug, or null when the slug is not a data-driven page. */
function kg_page_data( $slug ) {
	$all = kg_pages();
	return isset( $all[ $slug ] ) && 'template' !== $all[ $slug ]['type'] ? $all[ $slug ] : null;
}

/** Permalink for a data page by slug (falls back to a path that will resolve once the page exists). */
function kg_slug_url( $slug ) {
	$all = kg_pages();
	$path = $slug;
	for ( $p = $all[ $slug ]['parent'] ?? ''; $p; $p = $all[ $p ]['parent'] ?? '' ) {
		$path = $p . '/' . $path;
	}
	$page = get_page_by_path( $path );
	return $page ? get_permalink( $page ) : home_url( '/' . $path . '/' );
}

/** Shared FAQ. Pages pick items by 1-based number. */
function kg_faq() {
	return array(
		1 => array( 'Do you work under NDA?', 'Yes. We use strict NDA-backed processes and secure workflows so your data, ideas and strategies stay protected.' ),
		2 => array( 'Which tools do you design in?', 'PowerPoint, Google Slides, Keynote, Canva and Figma. We adapt to the tools you already use.' ),
		3 => array( 'Can you work from our existing brand and slides?', 'Yes. Share your current deck and brand assets and we will build on them, or refresh them if you prefer.' ),
		4 => array( 'Who do you work with?', 'Startups and founders, corporate and enterprise teams, and consulting firms across India and the Middle East.' ),
		5 => array( 'How is pricing decided?', 'It depends on scope: the number of slides, the amount of content work and any motion. Send us your brief and we will come back with a quote.' ),
		6 => array( 'How do I get started?', 'Fill in the short form on the contact page. Tell us who you are and what you need, and we will take it from there.' ),
		7 => array( 'Do you offer motion and animation?', 'Yes. We use motion and narrative flow to guide attention in high-stakes rooms.' ),
	);
}

/** The five-step process. */
function kg_process() {
	return array(
		array( 'Brief', 'You tell us who you are, who the audience is and what the deck must achieve.' ),
		array( 'Story', 'We shape the storyline and slide flow before any design starts.' ),
		array( 'Design', 'We design the slides on your brand, in the tool you use.' ),
		array( 'Motion', 'Where it helps, we add motion that guides attention.' ),
		array( 'Delivery', 'You receive editable files, ready to present, through NDA-backed workflows.' ),
	);
}

/** Primary and footer menu trees: slug => child slugs. */
function kg_menu_tree( $which ) {
	if ( 'footer' === $which ) {
		return array( 'services' => array(), 'work' => array(), 'process' => array(), 'pricing' => array(), 'faq' => array(), 'about' => array(), 'contact' => array(), 'sitemap' => array() );
	}
	return array(
		'services'     => array( 'presentation-design', 'brand-identity', 'digital-design' ),
		'who-we-serve' => array( 'startups-and-founders', 'corporate-and-enterprise-teams', 'consulting-firms' ),
		'work'         => array(),
		'process'      => array(),
		'about'        => array(),
		'insights'     => array(),
	);
}
