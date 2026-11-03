<?php
/**
 * Site copy carried over from the previous kgstudios.io site.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function kg_content( $key ) {
	static $c = null;
	if ( null === $c ) {
		$c = array(
			'audiences' => array(
				'Pitch Decks & Brand Identity for Startups & Founders',
				'Presentations & Brand Design for Corporate & Enterprise Teams',
				'Proposal Decks & Executive Presentations for Consulting Firms',
			),
			'hero_images' => array( 'hero-1.jpg', 'hero-2.jpg', 'hero-3.jpg' ),
			'clients' => array( 'chill', 'ei', 'gen', 'ic', 'indi-closet', 'midlife-baithak', 'ot', 'vis', 'vo' ),
			'presentations' => array(
				array( 'Pitch & Investor decks', 'Investor-ready pitch deck design to help startups raise funding faster.', 'svc-1.jpg' ),
				array( 'Sales & Marketing decks', 'High-conversion sales presentation design for enterprise deal closure.', 'svc-2.jpg' ),
				array( 'Event & conference keynotes', 'Professional presentation design for Corporate events and webinars.', 'svc-3.jpg' ),
				array( 'Proposal & consulting decks', 'Executive SteerCo deck design for leadership updates and decisions.', 'svc-4.jpg' ),
				array( 'Annual & ESG reports', 'Create modern and copilot compatible PowerPoint templates', 'svc-5.jpg' ),
				array( 'Presentation Template Creation', 'Custom Template system – scalable, on-brand, and AI-Copilot compatible', 'svc-6.jpg' ),
			),
			'extras' => array( 'Outsource presentation design service', 'DAM and Web add–ins', 'Presentation Design training' ),
			'brand' => array(
				'title' => 'Brand Identity',
				'text'  => 'We craft distinctive brand identities for startups and growing businesses – from new launches to brand refresh initiatives – helping brands stand out with clarity and consistency.',
				'list'  => array( 'Logo & visual identity systems', 'Brand guidelines & toolkits', 'Employer Branding', 'Marketing collaterals', 'Packaging design' ),
			),
			'digital' => array(
				'title' => 'Digital Design',
				'text'  => 'We bring brands to life through engaging digital experiences. From high-performing websites and landing pages to social media and campaign creatives, we design intuitive, conversion-focused solutions that drive impact across platforms.',
				'list'  => array( 'Website design (UX/UI)', 'Landing pages & campaign microsites', 'Social media creatives & management', 'Digital campaign creatives & website interactives' ),
			),
			'why' => array(
				array( 'Consulting DNA, Design Excellence', 'Led by alumni from BCG, KPMG, and ZS – we bring 30+ years of consulting experience and strategic thinking that goes far beyond design.' ),
				array( 'Motion-Led Storytelling', 'We go beyond static slides – using motion and narrative flow to guide executive attention and drive message retention in high-stakes rooms.' ),
				array( 'AI-Powered Velocity', 'Proprietary AI workflows enable 30–50% faster execution – delivering exceptional quality at speeds that keep pace with your business.' ),
				array( 'Multi-Platform Mastery', 'Native expertise across PowerPoint, Google Slides, Keynote, Canva, and Figma – seamlessly adapting to your tools and workflow.' ),
				array( 'Enterprise-Grade Confidentiality', 'Strict NDA-backed processes and secure workflows ensure your data, ideas, and strategies stay completely protected – always.' ),
			),
			'pairs' => array( 1, 3, 5, 7, 9, 11 ),
			'team' => array(
				array( 'Kamal Ghanghas', 'Co-Founder & Creative Director', 'Ex-BCG, ZS & KPMG. 15+ years of experience', 'team-kamal.png' ),
				array( 'Kavita Dahiya', 'Sr. presentation specialist', '15+ years of experience in design and strategy', 'team-kavita.png' ),
				array( 'Aditya Malik', 'Presentation specialist', '5+ years of experience', 'team-aditya.png' ),
				array( 'Sahil Sheoran', 'Marketing and automation specialist', '3+ years of experience', 'team-sahil.png' ),
			),
			'testimonials' => array(
				array( 'Rahul M.', 'Co-Founder, Series A Fintech Startup, India', 'We had a strong story but needed it to come to life visually. KG Studios helped us build a brand identity and pitch deck that truly represented who we are. Investors noticed the difference immediately – we looked as credible as we felt.' ),
				array( 'Priya S.', 'Head of Marketing, Enterprise Corporation, UAE', 'From high-impact marketing presentations to digital campaign creatives, KG Studios consistently delivers work that is on-brand, visually compelling, and built to perform across every platform. They’ve become our go-to creative partner.' ),
				array( 'Amit K.', 'Marketing Director, Management Consulting Firm', 'Consulting moves fast and clients expect polished, compelling work at every touchpoint. KG Studios consistently delivers – from proposals to SteerCo meetings and client-facing collaterals – always on brief, always on time, always impressive.' ),
			),
		);
	}
	return $c[ $key ] ?? array();
}
