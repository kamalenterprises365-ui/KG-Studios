<?php
/**
 * Home page. Every section is a full-bleed "slide" in one flat brand colour:
 * gold, paper, ink, paper, teal, ink, gold, paper, ink, paper, teal, gold, ink.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$aud = kg_content( 'audiences' );
?>
<section class="hero f-gold" data-hero>
	<div class="hero__top">
		<p class="statement" data-reveal="up"><?php esc_html_e( 'Presentation & Brand Design Agency for Founders, Corporates & Consulting Firms – Indian & Middle East', 'kgstudios' ); ?></p>
		<div class="rotator" data-rotator data-reveal="up" style="--d:.08s">
			<?php foreach ( $aud as $i => $line ) : ?>
				<span class="<?php echo 0 === $i ? 'is-on' : ''; ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>><?php echo esc_html( $line ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
	<h1 class="hero__name" data-lens>
		<span class="hero__ink">KG Studios</span>
		<span class="hero__lens" aria-hidden="true">KG Studios</span>
	</h1>
	<div class="hero__actions">
		<a class="btn magnet" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a quote', 'kgstudios' ); ?></a>
		<a class="btn btn--ghost" href="<?php echo esc_url( kg_page_url( 'work' ) ); ?>"><?php esc_html_e( 'See our work', 'kgstudios' ); ?></a>
	</div>
</section>

<?php
get_template_part( 'template-parts/section', 'logos' );
?>
<section class="section f-ink" id="intro">
	<div class="wrap">
		<h2 data-reveal="up"><?php esc_html_e( 'Win approvals. Secure funding. Drive growth.', 'kgstudios' ); ?></h2>
		<p class="statement" data-reveal="up" style="--d:.08s"><?php esc_html_e( 'We turn complex ideas into persuasive presentations, powerful brands, and high-performing digital experiences – helping you win approvals, secure funding, and drive growth.', 'kgstudios' ); ?></p>
	</div>
</section>
<?php
get_template_part( 'template-parts/section', 'scene' );
get_template_part( 'template-parts/section', 'services' );
get_template_part( 'template-parts/section', 'game' );
get_template_part( 'template-parts/section', 'why' );
get_template_part( 'template-parts/section', 'effect', array( 'limit' => 4 ) );
get_template_part( 'template-parts/section', 'process' );
get_template_part( 'template-parts/section', 'team' );
get_template_part( 'template-parts/section', 'testimonials' );
?>
<a class="band f-gold" id="contact-us" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>#contact">
	<span class="band__sentence"><?php esc_html_e( "Tell us who you are and what you need – we'll do the rest.", 'kgstudios' ); ?></span>
	<svg class="band__arrow" viewBox="0 0 48 48" width="48" height="48" aria-hidden="true"><path d="M12 36 36 12M16 12h20v20" fill="none" stroke="currentColor" stroke-width="4"/></svg>
	<span class="band__word"><?php esc_html_e( 'Talk', 'kgstudios' ); ?></span>
</a>
<?php
get_footer();
