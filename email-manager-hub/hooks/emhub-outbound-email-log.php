<?php
// emhub-outbound-email-log.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use EWPT\Modules\EmailManagerHub\emhub as emhub;

// Hook into wp_mail action to intercept outgoing emails sent via wp_mail function to store in email log
add_action( 'wp_mail', function ( $args ) {
	// Store the email in log
	emhub::capture_outbound_email_log( $args );
    // Return the args
    return $args;
}, 0, 1);