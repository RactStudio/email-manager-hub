<?php
// essential-wp-tools/modules/email-manager-hub/ewpt-email-manager-hub-actions.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Check if current page is the target page
if (isset($_GET['page']) && $_GET['page'] === 'ewpt-email-manager-hub') {
	
	// Enqueue EWPT Admin Assets
	ewpt::enqueue_ewpt_admin_assets();

	// Enqueue Color Picker Alpha
	add_action( 'admin_enqueue_scripts', function () {
		// Enqueue WordPress color picker style
		wp_enqueue_style( 'wp-color-picker' );
		// Enqueue custom color picker script
		$color_picker_alpha_script = EWPT_PLUGIN_URL . 'inc/wp-color-picker-alpha.min.js';
		wp_register_script( 'emhub-wp-color-picker-alpha', $color_picker_alpha_script, array( 'wp-color-picker' ), '3.0.3', true);
		wp_enqueue_script( 'emhub-wp-color-picker-alpha' );
	});

	// Ajax handler for fetching email log
	add_action('wp_ajax_emhub_get_email_log', function() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'ewpt_emhub_email_log'; // Custom table name
		
		$email_log = $wpdb->get_results("SELECT * FROM $table_name WHERE status IN ('sent', 'failed', 'pending', '') ORDER BY timestamp DESC LIMIT 200", ARRAY_A);
		wp_send_json($email_log);
	});

	// Ajax handler for clearing email log
	add_action('wp_ajax_emhub_clear_email_log', function() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'ewpt_emhub_email_log'; // Custom table name
		
		// Clear email log data
		$wpdb->query("DELETE FROM $table_name WHERE status IN ('sent', 'failed', 'pending', '')");
		// Return success message
		wp_send_json_success('Email log cleared successfully.');
	});

}