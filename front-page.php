<?php
/**
 * Home page.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$aud   = kg_content( 'audiences' );
$cards = array( 2, 4, 6, 8, 10 ); // "after" slides, front card first.
?>
<section class="hero" data-slide="<?php esc_attr_e( 'Welcome', 'kgstudios' ); ?>">
	<div class="orb orb--gold" data-parallax="0.18"></div>
	<div class="orb orb--teal" data-parallax="-0.12"></div>
	<div class="grid-bg" aria-hidden="true"></div>
	<div class="wrap hero__grid">
		<div class="hero__text">
			<p class="eyebrow" data-reveal><?php esc_html_e( 'Welcome to KG Studios', 'kgstudios' ); ?></p>
			<h1 data-reveal="up" style="--d:.05s">
				<?php esc_html_e( 'Presentation & Brand Design Agency for', 'kgstudios' ); ?>
				<em class="gold">Founders, Corporates &amp; Consulting Firms</em>
			</h1>
			<p class="hero__region" data-reveal="up" style="--d:.1s">– Indian &amp; Middle East</p>
			<div class="rotator" data-rotator data-reveal="up" style="--d:.15s">
				<?php foreach ( $aud as $i => $line ) : ?>
					<span class="<?php echo 0 === $i ? 'is-on' : ''; ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</div>
			<p class="lead-text" data-reveal="up" style="--d:.2s"><?php esc_html_e( 'We turn complex ideas into persuasive presentations, powerful brands, and high-performing digital experiences – helping you win approvals, secure funding, and drive growth.', 'kgstudios' ); ?></p>
			<div class="hero__actions" data-reveal="up" style="--d:.25s">
				<a class="btn btn--gold magnet" href="<?php echo esc_url( kg_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Get a quote', 'kgstudios' ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( kg_page_url( 'work' ) ); ?>"><?php esc_html_e( 'See our work', 'kgstudios' ); ?></a>
			</div>
		</div>

		<div class="hero__visual" data-reveal="right">
			<div class="deck3d" data-deck3d aria-hidden="true">
				<div class="deck3d__float">
					<div class="deck3d__inner">
						<?php foreach ( $cards as $i => $n ) : ?>
							<figure class="deck3d__card" style="--i:<?php echo (int) $i; ?>">
								<img src="<?php echo kg_img( 'slide-' . $n . '.jpeg' ); ?>" alt="" width="800" height="450" <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
							</figure>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="float float--a"><?php esc_html_e( 'BCG · KPMG · ZS alumni', 'kgstudios' ); ?></div>
			<div class="float float--b"><?php esc_html_e( 'India & Middle East', 'kgstudios' ); ?></div>
		</div>
	</div>
	<a class="scroll-cue" href="#what_we_do" aria-label="<?php esc_attr_e( 'Scroll to services', 'kgstudios' ); ?>"><span></span></a>
</section>

<?php
get_template_part( 'template-parts/section', 'logos' );
get_template_part( 'template-parts/section', 'scene' );
get_template_part( 'template-parts/section', 'services' );
get_template_part( 'template-parts/section', 'game' );
get_template_part( 'template-parts/section', 'why' );
get_template_part( 'template-parts/section', 'effect', array( 'limit' => 4 ) );
get_template_part( 'template-parts/section', 'process' );
get_template_part( 'template-parts/section', 'team' );
get_template_part( 'template-parts/section', 'testimonials' );
get_template_part( 'template-parts/section', 'cta' );
get_footer();
