<?php
// emhub-smtp-connections.php

/**
 * Enable WP SMTP PHPmailer
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Disable wp_mail
//remove_action('phpmailer_init', 'wp_staticize_emoji_for_email');
//remove_action('phpmailer_init', 'wp_staticize_emoji');
//remove_action('phpmailer_init', 'wp_staticize_emoji_for_text_email');
//remove_action('phpmailer_init', 'wp_mail');

// Enable WP SMTP Email
add_action( 'phpmailer_init', function ( $phpmailer ) {
	$host = get_option('emhub_wp_smtp_host');
	$port = get_option('emhub_wp_smtp_port');
	$email = get_option('emhub_wp_smtp_email');
	$password = get_option('emhub_wp_smtp_password');
	$encryption = get_option('emhub_wp_smtp_encryption', 'none');
	
	if ( !empty($host) && !empty($port) && !empty($email) && !empty($password) ) {
		
		// SMTP host
		$phpmailer->Host = $host;

		// SMTP port (change this to the appropriate port)
		$phpmailer->Port = $port;

		// Enable SMTP authentication
		$phpmailer->SMTPAuth = true;

		// SMTP username (your email address)
		$phpmailer->Username = $email;

		// SMTP password
		$phpmailer->Password = $password;

		// SMTP encryption (ssl/tls/none)
		$phpmailer->SMTPSecure = $encryption;
		
		// Set the mailer to use SMTP (must be on end)
		$phpmailer->isSMTP();
		
	}
});