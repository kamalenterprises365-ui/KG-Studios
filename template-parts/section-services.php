<?php
/**
 * Services. Args: heading (bool) to show the "What we do" heading block.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$a = wp_parse_args( $args, array( 'heading' => true ) );
$brand   = kg_content( 'brand' );
$digital = kg_content( 'digital' );
?>
<section class="section" id="what_we_do">
	<div class="wrap">
		<?php if ( $a['heading'] ) : ?>
			<header class="section__head" data-reveal="up">
				<p class="eyebrow"><?php esc_html_e( 'What We Do', 'kgstudios' ); ?></p>
				<h2><?php esc_html_e( 'Presentation Services', 'kgstudios' ); ?></h2>
				<p class="muted"><?php esc_html_e( 'Where ideas rise, flow, dive, and shine – through powerful presentations.', 'kgstudios' ); ?></p>
			</header>
		<?php endif; ?>

		<div class="cards">
			<?php foreach ( kg_content( 'presentations' ) as $i => $s ) : ?>
				<article class="card tilt" data-reveal="up" style="--d:<?php echo esc_attr( ( $i % 3 ) * 0.08 ); ?>s">
					<div class="card__img"><img src="<?php echo kg_img( $s[2] ); ?>" alt="<?php echo esc_attr( $s[0] ); ?>" loading="lazy" width="600" height="400"></div>
					<div class="card__body">
						<span class="card__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $s[0] ); ?></h3>
						<p><?php echo esc_html( $s[1] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<ul class="pills" data-reveal="up">
			<?php foreach ( kg_content( 'extras' ) as $e ) : ?>
				<li><?php echo esc_html( $e ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="section section--alt" id="services">
	<div class="wrap split-rows">
		<article class="split" data-reveal="left">
			<div class="split__text">
				<p class="eyebrow"><?php esc_html_e( 'Our Services', 'kgstudios' ); ?></p>
				<h2><?php echo esc_html( $brand['title'] ); ?></h2>
				<p class="muted"><?php echo esc_html( $brand['text'] ); ?></p>
				<h3 class="mini"><?php esc_html_e( 'Services include:', 'kgstudios' ); ?></h3>
				<ul class="ticks"><?php foreach ( $brand['list'] as $l ) : ?><li><?php echo esc_html( $l ); ?></li><?php endforeach; ?></ul>
			</div>
			<div class="split__img"><img src="<?php echo kg_img( 'design.jpg' ); ?>" alt="<?php esc_attr_e( 'Brand identity design', 'kgstudios' ); ?>" loading="lazy" width="900" height="600"></div>
		</article>

		<article class="split split--rev" data-reveal="right">
			<div class="split__text">
				<p class="eyebrow"><?php esc_html_e( 'Our Services', 'kgstudios' ); ?></p>
				<h2><?php echo esc_html( $digital['title'] ); ?></h2>
				<p class="muted"><?php echo esc_html( $digital['text'] ); ?></p>
				<h3 class="mini"><?php esc_html_e( 'Services include:', 'kgstudios' ); ?></h3>
				<ul class="ticks"><?php foreach ( $digital['list'] as $l ) : ?><li><?php echo esc_html( $l ); ?></li><?php endforeach; ?></ul>
			</div>
			<div class="split__img"><img src="<?php echo kg_img( 'about.png' ); ?>" alt="<?php esc_attr_e( 'Digital design', 'kgstudios' ); ?>" loading="lazy" width="854" height="621"></div>
		</article>
	</div>
</section>
