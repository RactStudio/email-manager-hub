<?php
// emhub-outbound-email-templates.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use EWPT\Modules\EmailManagerHub\emhub as emhub;

// Function to process and assign the custom HTML template to the email
add_filter('wp_mail', function ($args) {
    // Ensure $args has the keys we need
    if (isset($args['subject']) && isset($args['message'])) {
        // Load your custom email template
        $template = emhub::email_template_html_raw_data();

        // Use preg_replace to replace placeholders with actual content
        $template = preg_replace('/\{subject\}/', $args['subject'], $template);
        $template = preg_replace('/\{message\}/', nl2br($args['message']), $template);

        // Assign the modified template to the email content
        $args['message'] = $template;

        // Ensure the email is sent as HTML
        if (is_array($args['headers'])) {
            $args['headers'][] = 'Content-Type: text/html; charset=UTF-8';
        } else {
            $args['headers'] = array('Content-Type: text/html; charset=UTF-8');
        }
    } else {
        // Log an error if subject or message are not set
        error_log('Error: Subject or message not set in wp_mail args');
    }

    // Return the modified args
    return $args;
}, 1, 1);
