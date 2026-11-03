<?php
/**
 * Home page.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$aud = kg_content( 'audiences' );
$imgs = kg_content( 'hero_images' );
?>
<section class="hero">
	<div class="orb orb--gold" data-parallax="0.18"></div>
	<div class="orb orb--teal" data-parallax="-0.12"></div>
	<div class="grid-bg" aria-hidden="true"></div>
	<div class="wrap hero__grid">
		<div class="hero__text">
			<p class="eyebrow" data-reveal><?php esc_html_e( 'Welcome to KG Studios', 'kgstudios' ); ?></p>
			<h1 data-reveal="up" style="--d:.05s">
				<?php esc_html_e( 'Presentation & Brand Design Agency for', 'kgstudios' ); ?>
				<span class="gold">Founders, Corporates &amp; Consulting Firms</span>
			</h1>
			<p class="hero__region" data-reveal="up" style="--d:.1s">– Indian &amp; Middle East</p>
			<div class="rotator" data-rotator data-reveal="up" style="--d:.15s" aria-live="polite">
				<?php foreach ( $aud as $i => $line ) : ?>
					<span class="<?php echo 0 === $i ? 'is-on' : ''; ?>"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</div>
			<p class="lead-text" data-reveal="up" style="--d:.2s"><?php esc_html_e( 'We turn complex ideas into persuasive presentations, powerful brands, and high-performing digital experiences – helping you win approvals, secure funding, and drive growth.', 'kgstudios' ); ?></p>
			<div class="hero__actions" data-reveal="up" style="--d:.25s">
				<a class="btn btn--gold magnet" href="#contact-us"><?php esc_html_e( "Let's Talk", 'kgstudios' ); ?></a>
				<a class="btn btn--ghost" href="#our_work"><?php esc_html_e( 'See the transformation', 'kgstudios' ); ?></a>
			</div>
		</div>

		<div class="hero__visual" data-reveal="right">
			<div class="stack" data-rotator-img>
				<?php foreach ( $imgs as $i => $img ) : ?>
					<img class="<?php echo 0 === $i ? 'is-on' : ''; ?>" src="<?php echo kg_img( $img ); ?>" alt="" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?> width="1000" height="667">
				<?php endforeach; ?>
			</div>
			<div class="float float--a"><?php esc_html_e( 'BCG · KPMG · ZS alumni', 'kgstudios' ); ?></div>
			<div class="float float--b"><?php esc_html_e( 'India & Middle East', 'kgstudios' ); ?></div>
		</div>
	</div>

	<div class="wrap hero__form" data-reveal="up" style="--d:.3s">
		<p class="hero__form-t"><?php esc_html_e( "Tell us who you are and what you need – we'll do the rest.", 'kgstudios' ); ?></p>
		<?php kg_lead_form( 'lead-hero' ); ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/section', 'logos' );
get_template_part( 'template-parts/section', 'services' );
get_template_part( 'template-parts/section', 'why' );
get_template_part( 'template-parts/section', 'effect', array( 'limit' => 4 ) );
get_template_part( 'template-parts/section', 'team' );
get_template_part( 'template-parts/section', 'testimonials' );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
