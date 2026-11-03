<?php
/**
 * Case studies: the editable content behind the Work page.
 * Editors write the story in the block editor; the box below adds client, service,
 * a result line and the before/after slide images.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_post_type( 'kg_case', array(
		'labels'       => array(
			'name'          => __( 'Case studies', 'kgstudios' ),
			'singular_name' => __( 'Case study', 'kgstudios' ),
			'add_new_item'  => __( 'Add case study', 'kgstudios' ),
			'edit_item'     => __( 'Edit case study', 'kgstudios' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-awards',
		'menu_position' => 21,
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'work', 'with_front' => false ),
	) );
} );

function kg_case_fields() {
	return array(
		'kg_client'  => array( __( 'Client (or "Confidential client")', 'kgstudios' ), 'text' ),
		'kg_service' => array( __( 'Service', 'kgstudios' ), 'text' ),
		'kg_result'  => array( __( 'Result in one line', 'kgstudios' ), 'text' ),
		'kg_before'  => array( __( 'Before image', 'kgstudios' ), 'image' ),
		'kg_after'   => array( __( 'After image', 'kgstudios' ), 'image' ),
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'kg_case_meta', __( 'Case study details', 'kgstudios' ), 'kg_case_box', 'kg_case', 'normal', 'high' );
} );

function kg_case_box( $post ) {
	wp_nonce_field( 'kg_case_meta', 'kg_case_nonce' );
	foreach ( kg_case_fields() as $key => $f ) {
		$val = get_post_meta( $post->ID, $key, true );
		printf( '<p><label for="%1$s"><strong>%2$s</strong></label><br>', esc_attr( $key ), esc_html( $f[0] ) );
		printf( '<input type="%1$s" class="widefat" id="%2$s" name="%2$s" value="%3$s">', 'image' === $f[1] ? 'url' : 'text', esc_attr( $key ), esc_attr( $val ) );
		if ( 'image' === $f[1] ) {
			printf( ' <button type="button" class="button kg-pick" data-target="%s">%s</button>', esc_attr( $key ), esc_html__( 'Choose image', 'kgstudios' ) );
		}
		echo '</p>';
	}
	?>
	<script>
	document.querySelectorAll('.kg-pick').forEach(function (b) {
		b.addEventListener('click', function () {
			var frame = wp.media({ multiple: false, library: { type: 'image' } });
			frame.on('select', function () {
				document.getElementById(b.dataset.target).value = frame.state().get('selection').first().toJSON().url;
			});
			frame.open();
		});
	});
	</script>
	<?php
}

add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) && 'kg_case' === get_post_type() ) {
		wp_enqueue_media();
	}
} );

add_action( 'save_post_kg_case', function ( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['kg_case_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kg_case_nonce'] ) ), 'kg_case_meta' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( kg_case_fields() as $key => $f ) {
		$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		update_post_meta( $post_id, $key, 'image' === $f[1] ? esc_url_raw( $raw ) : sanitize_text_field( $raw ) );
	}
} );

/**
 * Before/after slider markup, shared by the Work grid, home page and case studies.
 * $before / $after are image URLs.
 */
function kg_ba_figure( $before, $after, $delay = 0 ) {
	?>
	<figure class="ba" data-ba data-reveal="up" style="--d:<?php echo esc_attr( $delay ); ?>s">
		<img class="ba__after" src="<?php echo esc_url( $after ); ?>" alt="<?php esc_attr_e( 'After: redesigned slide', 'kgstudios' ); ?>" loading="lazy" width="800" height="450" draggable="false">
		<img class="ba__before" src="<?php echo esc_url( $before ); ?>" alt="<?php esc_attr_e( 'Before: original slide', 'kgstudios' ); ?>" loading="lazy" width="800" height="450" draggable="false">
		<span class="ba__tag ba__tag--l"><?php esc_html_e( 'Before', 'kgstudios' ); ?></span>
		<span class="ba__tag ba__tag--r"><?php esc_html_e( 'After', 'kgstudios' ); ?></span>
		<span class="ba__handle" aria-hidden="true"></span>
		<input class="ba__range" type="range" min="0" max="100" value="50" aria-label="<?php esc_attr_e( 'Before and after slider', 'kgstudios' ); ?>">
	</figure>
	<?php
}
