<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lead form: posts to admin-post.php, saves the enquiry as a private "Lead" post
 * (so nothing is lost if mail fails), then emails the site's contact address.
 * Protected by a honeypot and a per-IP throttle. No nonce: anonymous nonces expire
 * on cached pages and do not stop bots.
 */
add_action( 'init', function () {
	register_post_type( 'kg_lead', array(
		'labels'       => array( 'name' => __( 'Leads', 'kgstudios' ), 'singular_name' => __( 'Lead', 'kgstudios' ) ),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-email-alt',
		'supports'     => array( 'title', 'editor' ),
		'capabilities' => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap' => true,
	) );
} );

add_action( 'admin_post_nopriv_kg_lead', 'kg_handle_lead' );
add_action( 'admin_post_kg_lead', 'kg_handle_lead' );

/** Visitor IP. Behind Cloudflare, REMOTE_ADDR is the proxy, so prefer its header. */
function kg_client_ip() {
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
	return filter_var( $ip, FILTER_VALIDATE_IP ) ? $ip : '';
}

/**
 * Validates, stores and emails one enquiry.
 *
 * @param array  $in Unslashed form fields.
 * @param string $ip Visitor IP, used for the throttle.
 * @return string ok | wait | invalid | error
 */
function kg_process_lead( array $in, $ip ) {
	// Honeypot: real users leave this empty. Pretend success so bots learn nothing.
	if ( ! empty( $in['kg_website'] ) ) {
		return 'ok';
	}

	$key = 'kg_lead_' . md5( $ip );
	if ( get_transient( $key ) ) {
		return 'wait';
	}
	// Whatever the IP (the Cloudflare header can be forged when the site is reached directly), cap total enquiries per hour.
	$cap_key = 'kg_lead_h_' . gmdate( 'YmdH' );
	if ( (int) get_transient( $cap_key ) >= (int) apply_filters( 'kg_lead_hourly_cap', 20 ) ) {
		return 'wait';
	}

	$f = function ( $name, $multiline = false ) use ( $in ) {
		$v = isset( $in[ $name ] ) ? $in[ $name ] : '';
		return $multiline ? sanitize_textarea_field( $v ) : sanitize_text_field( $v );
	};

	$name  = $f( 'kg_name' );
	$email = sanitize_email( isset( $in['kg_email'] ) ? $in['kg_email'] : '' );
	if ( '' === $name || ! is_email( $email ) ) {
		return 'invalid';
	}

	$link = esc_url_raw( isset( $in['kg_link'] ) ? $in['kg_link'] : '' );
	$body = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\nCompany / Role: %s\nI am a: %s\nNeeds help with: %s\nFiles link: %s\n\n%s\n",
		$name, $email, $f( 'kg_phone' ), $f( 'kg_company' ), $f( 'kg_type' ), $f( 'kg_service' ), $link, $f( 'kg_message', true )
	);

	$saved = wp_insert_post( array(
		'post_type'    => 'kg_lead',
		'post_status'  => 'private',
		'post_title'   => $name,
		'post_content' => $body,
	) );
	$sent  = wp_mail(
		kg_opt( 'email' ),
		sprintf( '[KG Studios] New enquiry from %s', $name ),
		$body,
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	// Stored or emailed means the lead is safe; only fail when both did.
	if ( ! $sent && ( ! $saved || is_wp_error( $saved ) ) ) {
		return 'error';
	}
	set_transient( $key, 1, 60 );
	set_transient( $cap_key, (int) get_transient( $cap_key ) + 1, HOUR_IN_SECONDS );
	return 'ok';
}

function kg_handle_lead() {
	$status = kg_process_lead( wp_unslash( $_POST ), kg_client_ip() );
	$thanks = get_page_by_path( 'contact/thank-you' );
	if ( 'ok' === $status && $thanks ) {
		wp_safe_redirect( get_permalink( $thanks ) );
		exit;
	}
	$back   = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back   = remove_query_arg( 'kg_sent', $back );
	wp_safe_redirect( add_query_arg( 'kg_sent', $status, $back ) . '#contact' );
	exit;
}

/** Renders the multi-step lead form. $id keeps ids unique per instance. */
function kg_lead_form( $id = 'lead' ) {
	$types    = array( 'Startup', 'Founder', 'Corporate Team', 'Consulting Firm', 'Other' );
	$services = array( 'Presentations', 'Brand Identity', 'Digital Design', 'Other' );
	$status   = isset( $_GET['kg_sent'] ) ? sanitize_key( $_GET['kg_sent'] ) : '';
	$slides   = isset( $_GET['slides'] ) ? absint( $_GET['slides'] ) : 0;
	$prefill  = $slides ? sprintf( 'I need about %d slides. ', $slides ) : '';
	$notes    = array(
		'ok'      => array( 'ok', __( 'Thank you. We will get back to you shortly.', 'kgstudios' ) ),
		'wait'    => array( 'err', __( 'Please wait a minute before sending another message.', 'kgstudios' ) ),
		'invalid' => array( 'err', __( 'Please enter your name and a valid email.', 'kgstudios' ) ),
		'error'   => array( 'err', __( 'Something went wrong. Please email us directly.', 'kgstudios' ) ),
	);

	// After a successful send, show only the thank-you, not an empty form.
	if ( 'ok' === $status ) {
		printf( '<p class="lead__note lead__note--ok" role="status">%s</p>', esc_html( $notes['ok'][1] ) );
		return;
	}
	?>
	<form class="lead" id="<?php echo esc_attr( $id ); ?>" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-steps>
		<input type="hidden" name="action" value="kg_lead">
		<div class="lead__hp" aria-hidden="true"><label>Website <input type="text" name="kg_website" tabindex="-1" autocomplete="off"></label></div>

		<?php if ( isset( $notes[ $status ] ) ) : ?>
			<p class="lead__note lead__note--<?php echo esc_attr( $notes[ $status ][0] ); ?>" role="status"><?php echo esc_html( $notes[ $status ][1] ); ?></p>
		<?php endif; ?>

		<div class="lead__progress" aria-hidden="true"><i></i><i></i><i></i></div>

		<fieldset class="lead__step is-active" data-step="1">
			<legend><?php esc_html_e( 'I am a..', 'kgstudios' ); ?></legend>
			<div class="chips">
				<?php foreach ( $types as $i => $t ) : ?>
					<label class="chip"><input type="radio" name="kg_type" value="<?php echo esc_attr( $t ); ?>" <?php checked( 0, $i ); ?>><span><?php echo esc_html( $t ); ?></span></label>
				<?php endforeach; ?>
			</div>
			<button type="button" class="btn" data-next><?php esc_html_e( 'Next', 'kgstudios' ); ?></button>
		</fieldset>

		<fieldset class="lead__step" data-step="2">
			<legend><?php esc_html_e( 'I need help with...', 'kgstudios' ); ?></legend>
			<div class="chips">
				<?php foreach ( $services as $i => $s ) : ?>
					<label class="chip"><input type="radio" name="kg_service" value="<?php echo esc_attr( $s ); ?>" <?php checked( 0, $i ); ?>><span><?php echo esc_html( $s ); ?></span></label>
				<?php endforeach; ?>
			</div>
			<div class="lead__nav">
				<button type="button" class="btn btn--ghost" data-prev><?php esc_html_e( 'Back', 'kgstudios' ); ?></button>
				<button type="button" class="btn" data-next><?php esc_html_e( 'Next', 'kgstudios' ); ?></button>
			</div>
		</fieldset>

		<fieldset class="lead__step" data-step="3">
			<legend><?php esc_html_e( 'Tell us about you', 'kgstudios' ); ?></legend>
			<div class="lead__grid">
				<label class="field"><span><?php esc_html_e( 'Full Name', 'kgstudios' ); ?></span><input type="text" name="kg_name" required autocomplete="name"></label>
				<label class="field"><span><?php esc_html_e( 'Email', 'kgstudios' ); ?></span><input type="email" name="kg_email" required autocomplete="email"></label>
				<label class="field"><span><?php esc_html_e( 'Phone (Optional)', 'kgstudios' ); ?></span><input type="tel" name="kg_phone" autocomplete="tel"></label>
				<label class="field"><span><?php esc_html_e( 'Company / Role', 'kgstudios' ); ?></span><input type="text" name="kg_company" autocomplete="organization"></label>
			</div>
			<label class="field"><span><?php esc_html_e( 'Tell us about your project', 'kgstudios' ); ?></span><textarea name="kg_message" rows="4"><?php echo esc_textarea( $prefill ); ?></textarea></label>
			<label class="field"><span><?php esc_html_e( 'Link to your files (Drive, Dropbox, WeTransfer) – optional', 'kgstudios' ); ?></span><input type="url" name="kg_link" placeholder="https://" autocomplete="off"></label>
			<div class="lead__nav">
				<button type="button" class="btn btn--ghost" data-prev><?php esc_html_e( 'Back', 'kgstudios' ); ?></button>
				<button type="submit" class="btn"><?php esc_html_e( "Let's Talk", 'kgstudios' ); ?></button>
			</div>
		</fieldset>
	</form>
	<?php
}
