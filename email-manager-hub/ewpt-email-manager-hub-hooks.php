<?php
// essential-wp-tools/modules/email-manager-hub/ewpt-email-manager-hub-hooks.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Add Modules Action/Hooks files
$ewpt_disable_all_email_manager_hub_options = get_option('ewpt_disable_all_email_manager_hub_options', 0);
if ($ewpt_disable_all_email_manager_hub_options != 1) {
	
	$emhub_change_outgoing_email_form_name = get_option('emhub_change_outgoing_email_form_name', 0);
	if ($emhub_change_outgoing_email_form_name == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/emhub-change-outgoing-email-form-name.php');
	}
	
	$emhub_change_outgoing_email_form_address = get_option('emhub_change_outgoing_email_form_address', 0);
	if ($emhub_change_outgoing_email_form_address == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/emhub-change-outgoing-email-form-address.php');
	}
	
	$emhub_enable_smtp_connections = get_option('emhub_enable_smtp_connections', 0);
	if ($emhub_enable_smtp_connections == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/emhub-smtp-connections.php');
	}
	
	$emhub_outbound_email_templates = get_option('emhub_outbound_email_templates', 0);
	if ($emhub_outbound_email_templates == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/emhub-outbound-email-templates.php');
	}

	$emhub_enable_outbound_email_log = get_option('emhub_enable_outbound_email_log', 0);
	if ($emhub_enable_outbound_email_log == 1) {
		include_once(plugin_dir_path(__FILE__) . 'hooks/emhub-outbound-email-log.php');
	}
	
}
