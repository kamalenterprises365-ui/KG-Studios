<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Lead form: posts to admin-post.php, emails the site's contact address.
 * Protected by a nonce, a honeypot, and a per-IP throttle.
 */
add_action( 'admin_post_nopriv_kg_lead', 'kg_handle_lead' );
add_action( 'admin_post_kg_lead', 'kg_handle_lead' );

function kg_lead_redirect( $status ) {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'kg_sent', $back );
	wp_safe_redirect( add_query_arg( 'kg_sent', $status, $back ) . '#contact' );
	exit;
}

function kg_handle_lead() {
	if ( ! isset( $_POST['kg_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kg_nonce'] ) ), 'kg_lead' ) ) {
		kg_lead_redirect( 'error' );
	}
	// Honeypot: real users leave this empty.
	if ( ! empty( $_POST['kg_website'] ) ) {
		kg_lead_redirect( 'ok' );
	}

	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = 'kg_lead_' . md5( $ip );
	if ( get_transient( $key ) ) {
		kg_lead_redirect( 'wait' );
	}

	$f = function ( $name, $multiline = false ) {
		$v = isset( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : '';
		return $multiline ? sanitize_textarea_field( $v ) : sanitize_text_field( $v );
	};

	$name    = $f( 'kg_name' );
	$email   = sanitize_email( isset( $_POST['kg_email'] ) ? wp_unslash( $_POST['kg_email'] ) : '' );
	$phone   = $f( 'kg_phone' );
	$company = $f( 'kg_company' );
	$type    = $f( 'kg_type' );
	$service = $f( 'kg_service' );
	$message = $f( 'kg_message', true );

	if ( '' === $name || ! is_email( $email ) ) {
		kg_lead_redirect( 'invalid' );
	}

	$body = "Name: $name\nEmail: $email\nPhone: $phone\nCompany / Role: $company\nI am a: $type\nNeeds help with: $service\n\n$message\n";
	$sent = wp_mail(
		kg_opt( 'email' ),
		sprintf( '[KG Studios] New enquiry from %s', $name ),
		$body,
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	if ( $sent ) {
		set_transient( $key, 1, 60 );
	}
	kg_lead_redirect( $sent ? 'ok' : 'error' );
}

/** Renders the multi-step lead form. $id keeps radio/label ids unique per instance. */
function kg_lead_form( $id = 'lead' ) {
	$types    = array( 'Startup', 'Founder', 'Corporate Team', 'Consulting Firm', 'Other' );
	$services = array( 'Presentations', 'Brand Identity', 'Digital Design', 'Other' );
	$status   = isset( $_GET['kg_sent'] ) ? sanitize_key( $_GET['kg_sent'] ) : '';
	$notes    = array(
		'ok'      => array( 'ok', __( 'Thank you. We will get back to you shortly.', 'kgstudios' ) ),
		'wait'    => array( 'err', __( 'Please wait a minute before sending another message.', 'kgstudios' ) ),
		'invalid' => array( 'err', __( 'Please enter your name and a valid email.', 'kgstudios' ) ),
		'error'   => array( 'err', __( 'Something went wrong. Please email us directly.', 'kgstudios' ) ),
	);
	?>
	<form class="lead" id="<?php echo esc_attr( $id ); ?>" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" data-steps>
		<input type="hidden" name="action" value="kg_lead">
		<?php wp_nonce_field( 'kg_lead', 'kg_nonce' ); ?>
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
			<button type="button" class="btn btn--gold" data-next><?php esc_html_e( 'Next', 'kgstudios' ); ?></button>
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
				<button type="button" class="btn btn--gold" data-next><?php esc_html_e( 'Next', 'kgstudios' ); ?></button>
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
			<label class="field"><span><?php esc_html_e( 'Tell us about your project', 'kgstudios' ); ?></span><textarea name="kg_message" rows="4"></textarea></label>
			<div class="lead__nav">
				<button type="button" class="btn btn--ghost" data-prev><?php esc_html_e( 'Back', 'kgstudios' ); ?></button>
				<button type="submit" class="btn btn--gold"><?php esc_html_e( "Let's Talk", 'kgstudios' ); ?></button>
			</div>
		</fieldset>
	</form>
	<?php
}
