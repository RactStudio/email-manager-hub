<?php
// essential-wp-tools/modules/email-manager-hub/email-manager-hub-functions.php

// Define namespace
namespace EWPT\Modules\EmailManagerHub;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class emhub {
    
    // Function to create the custom database table for email log
    public static function create_email_log_table() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ewpt_emhub_email_log'; // Custom table name

        // Check if the table exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            // Table does not exist, so create it
            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                to_email varchar(255) NOT NULL,
                subject text NOT NULL,
                message longtext NOT NULL,
                headers longtext NOT NULL,
                attachments longtext NOT NULL,
                from_email varchar(255) NOT NULL,
                email_type varchar(255) NOT NULL,
                priority varchar(255) NOT NULL,
                status varchar(255) NOT NULL DEFAULT 'pending',
                retry_count int NOT NULL DEFAULT 0,
                last_attempt_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                timestamp datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    // Function to capture outbound email and store it in the email log
    public static function capture_outbound_email_log($args) {
        // Extract relevant email info
        $to = $args['to'];
        $subject = $args['subject'];
        $message = $args['message'];
        $headers = $args['headers'];
        $attachments = isset($args['attachments']) ? $args['attachments'] : array();

        // Call function to create the table if it doesn't exist
        self::create_email_log_table();

        // Call function to save email to the log
        self::save_outbound_email_log($to, $subject, $message, $headers, $attachments);
    }

    // Function to save email to the log
    public static function save_outbound_email_log($to, $subject, $message, $headers, $attachments) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ewpt_emhub_email_log'; // table name

        // Get the maximum number of emails to save from user input
        $max_emails = intval(get_option('emhub_max_email_save_in_email_log', 100));

        // Ensure max_emails is between 10 and 1000
        if ($max_emails < 10) {
            $max_emails = 10;
        } elseif ($max_emails > 1000) {
            $max_emails = 1000;
        }
		
        // Get the current count of emails in the log
        $current_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

        // Delete the oldest entries if the current count exceeds the max limit
        if ($current_count >= $max_emails) {
            $emails_to_delete = $current_count - $max_emails + 1; // Calculate how many emails to delete
            $wpdb->query("DELETE FROM $table_name ORDER BY id ASC LIMIT $emails_to_delete");
        }

        // Placeholder metadata
        $from_email = '';
        foreach ($headers as $header) {
            if (stripos($header, 'From:') === 0) {
                $from_email = trim(str_replace('From:', '', $header));
                break;
            }
        }
        $email_type = 'General'; // Default to 'General' type
        $priority = 'Normal'; // Default to 'Normal' priority

        // Prepare data to insert
        $data = array(
            'to_email' => sanitize_email($to),
            'subject' => sanitize_text_field($subject),
            'message' => wp_kses_post($message),
            'headers' => maybe_serialize($headers), // Serialize headers array
            'attachments' => maybe_serialize($attachments), // Serialize attachments array
            'from_email' => sanitize_email($from_email),
            'email_type' => sanitize_text_field($email_type),
            'priority' => sanitize_text_field($priority),
            'status' => '', // eg: sent, failed, pending for (email log).
            'retry_count' => 0,
            'last_attempt_at' => current_time('mysql', 1) // Get the current time
        );

        // Insert data into the custom table
        $wpdb->insert($table_name, $data);
    }

    // Function to load email template HTML raw data
    public static function email_template_html_raw_data() {
        $template_path = plugin_dir_path(__FILE__) . 'templates/template1.html';
        if (file_exists($template_path)) {
            return file_get_contents($template_path);
        }
        return '';
    }

	/**
	// Function to retry sending failed emails
	public static function retry_failed_emails() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'ewpt_emhub_email_log'; // Table name

		// Query the email log for failed emails
		$failed_emails = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $table_name WHERE status = %s",
				'failed'
			)
		);
		
		// For each failed email, attempt to resend it
		foreach ($failed_emails as $email) {
			$to = $email->to_email;
			$subject = $email->subject;
			$message = $email->message;
			$headers = unserialize($email->headers); // Deserialize headers
			$attachments = unserialize($email->attachments); // Deserialize attachments

			// Attempt to resend the email
			$success = wp_mail($to, $subject, $message, $headers, $attachments);

			// Update the status and retry count accordingly
			if ($success) {
				// Email sent successfully, update status to 'sent' and reset retry count
				$wpdb->update(
					$table_name,
					array(
						'status' => 'sent',
						'retry_count' => 0
					),
					array('id' => $email->id)
				);
			} else {
				// Email sending failed, update status to 'failed' and increment retry count
				$wpdb->update(
					$table_name,
					array(
						'status' => 'failed',
						'retry_count' => $email->retry_count + 1
					),
					array('id' => $email->id)
				);
			}
		}
	}
	**/
		
}
