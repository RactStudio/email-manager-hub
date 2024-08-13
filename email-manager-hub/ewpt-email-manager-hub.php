<?php
// essential-wp-tools/modules/email-manager-hub/ewpt-email-manager-hub.php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use Essential\WP\Tools\ewpt as ewpt;

// Register settings
add_action( 'init', function () {
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'ewpt_disable_all_email_manager_hub_options', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'ewpt_email_manager_hub_menu_link', 'string');
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_change_outgoing_email_form_name', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_change_outgoing_email_form_name_text', 'string');
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_change_outgoing_email_form_address', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_change_outgoing_email_form_address_text', 'email');
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_enable_total_smtp_counter', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_enable_smtp_connections", 'boolean'); // enable
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_primary_connection", 'integer'); // primary smtp
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_fallback_connection", 'integer'); // fallback smtp
	
	// Main SMTP Options / Settings Loop :-)
	// Get the minimum and maximum number to save from user input
	$total_smtp_slots = intval(get_option('emhub_enable_total_smtp_counter', 2));
	// Ensure between 10 and 10
	if ($total_smtp_slots < 1) {
		$total_smtp_slots = 1;
	} elseif ($total_smtp_slots > 10) {
		$total_smtp_slots = 10;
	}
	for ($i = 1; $i <= $total_smtp_slots; $i++) {
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_name", 'string'); // name / title
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_connection_type", 'string'); // connection type
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_host", 'string'); //smtp host
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_port", 'intval');  // port
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_email", 'string'); // email / username
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_password", 'string'); // password / api key
		ewpt::register_setting_data('ewpt_email_manager_hub_settings', "emhub_smtp_{$i}_encryption", 'string'); // encryption (ssl/tls/none) (select)
	}
	
	// Global Styles
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_background', 'color');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_color', 'color');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_margin', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_padding', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_align', 'string');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_font', 'string');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_global_size', 'integer');
	
	
	// Page Design
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_enable', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_media_link', 'url');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_media_width', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_media_height', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_media_align', 'string');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_url_enable', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_logo_url', 'url');
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_h1_text_enable', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_h1_text_align', 'string');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_h1_text_size', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_h1_text_color', 'color');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_h1_text', 'string');
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_paragraph_enable', 'boolean');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_paragraph_text_align', 'string');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_paragraph_text_size', 'integer');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_paragraph_text_color', 'color');
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_html_template_paragraph_text', 'html_post');
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_outbound_email_templates', 'boolean'); // Enable email templates
	
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_enable_outbound_email_log', 'boolean'); // Enable email log
	ewpt::register_setting_data('ewpt_email_manager_hub_settings', 'emhub_max_email_save_in_email_log', 'intval'); // Enable email log
	
});

// Menu of the Module
add_action( 'admin_menu', function () {
	// Get the option for menu visibility
	$menu_visibility_option = get_option('ewpt_email_manager_hub_menu_link', 'sub_menu');
	// Module menu name
	$module_name = 'Email Manager Hub'; // Define the module name/title here
	ewpt::assign_modules_menu_link($menu_visibility_option, $module_name);
});

// Callback function to render the settings page
if (!function_exists('ewpt_email_manager_hub_settings_page')) {
function ewpt_email_manager_hub_settings_page() {
	// Include the module config file
	include(plugin_dir_path(__FILE__) . 'ewpt-email-manager-hub-config.php');
		 
	// Get the minimum and maximum number to save from user input
	// Total SMTP slot by User defined - OR, default to 2 
	$emhub_smtp_i = intval(get_option('emhub_enable_total_smtp_counter', 2));
	// Ensure between 10 and 10
	if ($emhub_smtp_i < 1) {
		$emhub_smtp_i = 1;
	} elseif ($emhub_smtp_i > 10) {
		$emhub_smtp_i = 10;
	}
	
?>
	
	<div id="ewpt-page-header" class="ewpt-page-header">
	
		<?php
		// Include the module header file
		include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header.php';
		?>
		
	</div>
	
	<div id="ewpt-page-main" class="wrap ewpt-page-main">

		<div id="ewpt-page-body" class="ewpt-page-body">
			
			<h1>
			
				<!-- Show Mask -->
				<div id="ewpt-mask"></div>
				
				<?php
				// Include the module header file
				include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-header-sub.php';
				?>
				
			</h1>
	
			<!-- Main Tab -->
			<h2 class="nav-tab-wrapper">
				<a href="#<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="nav-tab main-tab">Settings</a>
				<a href="#smtp-settings" class="nav-tab main-tab">SMTP Email Relay</a>
				<a href="#email-templates" class="nav-tab main-tab">Email Templates</a>
				<a href="#email-log" class="nav-tab main-tab">Email Log</a>
				<a href="#test-email" class="nav-tab main-tab">Test Email</a>
				<a href="#about-module" class="nav-tab main-tab">About</a>
				<div class="nav-tab main-tab ewpt-save-button"><p class="submit"><input form="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
			</h2>
			
			<form id="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" name="<?php echo sanitize_html_class(strtolower(EWPT_SHORT_SLUG)); ?>-form" method="post" action="options.php">
			
				<?php wp_nonce_field( esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce'), esc_attr(strtolower(EWPT_SHORT_SLUG).'_nonce') ); ?>
				<?php //settings_errors(); ?>
				<?php settings_fields(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'_'.$EWPT_MODULE_VAR.'_settings'))); ?>
				<?php //do_settings_sections(esc_attr(strtolower(EWPT_SHORT_SLUG.'-'.$EWPT_MODULE_SLUG))); ?>
				
				<div id="<?php echo sanitize_html_class($EWPT_MODULE_TAB_DEFAULT); ?>" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border"><?php echo esc_attr($EWPT_MODULE_NAME); ?> Settings</h3>
						
						<table class="form-table ewpt-form ewpt-form-border-bottom">
							<tr valign="top">
								<th scope="row">All Options</th>
								<td>
									<label>
										<input type="checkbox" name="ewpt_disable_all_email_manager_hub_options" value="1" <?php checked(get_option('ewpt_disable_all_email_manager_hub_options', 0)) ?> />
										Disable
									</label>
								</td>
								<td>
									<div class='ewpt-info-red'>
										Disable all options action and won't load hooks files, unchecked means all actions are active.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Menu Link</th>
								<td>
										<select name="ewpt_email_manager_hub_menu_link">
											<option value="sub_menu" <?php selected(get_option("ewpt_email_manager_hub_menu_link"), 'sub_menu'); ?>>Sub Menu</option>
											<option value="main_menu" <?php selected(get_option("ewpt_email_manager_hub_menu_link"), 'main_menu'); ?>>Main Menu</option>
											<option value="hidden_menu" <?php selected(get_option("ewpt_email_manager_hub_menu_link"), 'hidden_menu'); ?>>Hide Menu</option>
										</select>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										'Sub Menu': Add this module settings page link inside 'EWPT Dashboard' menu.<br/>
										'Main Menu': Add this module settings page link as main menu link (standalone).<br/>
										'Hide menu': Hide this settings page link. Link only available on 'EWPT Dashboard' page.
									</div>
								</td>
							</tr>
							
						</table>
						
						<table class="form-table ewpt-form ewpt-form-border-bottom">
						
							<tr valign="top">
								<th scope="row">Outgoing Email Form Name</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_change_outgoing_email_form_name" value="1" <?php checked(get_option('emhub_change_outgoing_email_form_name', 0)); ?> />
										Enable
										<input type="text" name="emhub_change_outgoing_email_form_name_text" value="<?php echo esc_attr(get_option('emhub_change_outgoing_email_form_name_text', '')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Change all of the outgoing email sender name
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Outgoing Email Form Address</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_change_outgoing_email_form_address" value="1" <?php checked(get_option('emhub_change_outgoing_email_form_address', 0)); ?> />
										Enable
										<input type="email" name="emhub_change_outgoing_email_form_address_text" value="<?php echo esc_attr(get_option('emhub_change_outgoing_email_form_address_text', '')); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Change all of the outgoing email sender address
									</div>
								</td>
							</tr>
							
						</table>
						
						<table class="form-table ewpt-form ewpt-form-border-bottom">
						
							<tr valign="top">
								<th scope="row">Email Log</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_enable_outbound_email_log" value="1" <?php checked(get_option('emhub_enable_outbound_email_log', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Activate all outbound email logs for more precise email management.
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Maximum Email Log</th>
								<?php
									// Get the maximum number of emails to save from user input
									$emhub_max_emails_log = intval(get_option('emhub_max_email_save_in_email_log', 100));
									// Ensure max_emails is between 10 and 1000
									if ($emhub_max_emails_log < 10) {
										$emhub_max_emails_log = 10;
									} elseif ($emhub_max_emails_log > 1000) {
										$emhub_max_emails_log = 1000;
									}
								?>
								<td>
									<label>
										<input type="number" name="emhub_max_email_save_in_email_log" value="<?php echo intval($emhub_max_emails_log); ?>" />
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Enter the maximum number of recent emails to retain in the log.<br/>
										<strong>Note: Default is 100. Minimum is 10 and maximum is 1000.<br/>
										Values outside this range will be adjusted automatically.</strong>
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="nav-tab ewpt-save-button" style="margin: 30px 0 0 0;"><p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
					
				</div>
			
				<div id="smtp-settings" class="tab-content" style="display: none;">
					<div class="tab-pane">
					
						<h3 class="ewpt-no-top-border">Email Relay Settings</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom">
						
							<tr valign="top">
								<th scope="row">Connections Status</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_enable_smtp_connections" value="1" <?php checked(get_option("emhub_enable_smtp_connections", 0)); ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Activate SMTP Connections for sending emails from your WordPress site.<br/>
										<strong>Note: All outbound WP emails will pass through the designated SMTP email relay.</strong>
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Total Connections</th>
								<?php
									// Get the minimum and maximum number to save from user input
									$total_smtp_slots = intval(get_option('emhub_enable_total_smtp_counter', 2));
									// Ensure between 10 and 10
									if ($total_smtp_slots < 1) {
										$total_smtp_slots = 1;
									} elseif ($total_smtp_slots > 10) {
										$total_smtp_slots = 10;
									}
								?>
								<td>
									<input type="number" name="emhub_enable_total_smtp_counter" value="<?php echo intval($total_smtp_slots); ?>" />
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Decreasing the SMTP Email Realy slot's does not clear saved data.<br/>
										<strong>Note: Default: 2, Minimum: 1 and Maximum: 10</strong>
									</div>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row">Primary Connection</th>
								<td>
										<select name="emhub_smtp_primary_connection">
											<?php for ($i = 1; $i <= $emhub_smtp_i; $i++) :
												$emhub_smtp_name = get_option("emhub_smtp_{$i}_name");
												if(!empty($emhub_smtp_name)){
													$emhub_smtp_name = ' - ('.$emhub_smtp_name.')';
												} else {
													$emhub_smtp_name = '';
												}
												$emhub_connection_type = get_option("emhub_smtp_{$i}_connection_type");
												if(!empty($emhub_connection_type)){
													$emhub_connection_type = ' - '.$emhub_connection_type.'';
												} else {
													$emhub_connection_type = '';
												}
											?>
												<option value="<?php echo intval($i); ?>" <?php selected(get_option("emhub_smtp_primary_connection"), $i); ?>><?php echo intval($i) . esc_attr($emhub_connection_type) . esc_attr($emhub_smtp_name); ?></option>
											<?php endfor; ?>
										</select>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										SMTP encryption type of the host (tls/ssl/none)
									</div>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Fallback Connection</th>
								<td>
										<select name="emhub_smtp_fallback_connection">
											<option value="0" <?php selected(get_option("emhub_smtp_{$i}_fallback_connection"), 0); ?>>0 - Disable</option>
											<?php for ($i = 1; $i <= $emhub_smtp_i; $i++) :
												$emhub_smtp_name = get_option("emhub_smtp_{$i}_name");
												if(!empty($emhub_smtp_name)){
													$emhub_smtp_name = ' - ('.$emhub_smtp_name.')';
												} else {
													$emhub_smtp_name = '';
												}
												$emhub_connection_type = get_option("emhub_smtp_{$i}_connection_type");
												if(!empty($emhub_connection_type)){
													$emhub_connection_type = ' - '.$emhub_connection_type.'';
												} else {
													$emhub_connection_type = '';
												}
											?>
												<option value="<?php echo intval($i); ?>" <?php selected(get_option("emhub_smtp_fallback_connection"), $i); ?>><?php echo intval($i) . esc_attr($emhub_connection_type) . esc_attr($emhub_smtp_name); ?></option>
											<?php endfor; ?>
										</select>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										SMTP encryption type of the host (tls/ssl/none)
									</div>
								</td>
							</tr>
							
						</table>
						
						<h3 class="ewpt-no-top-border">Connections Settings</h3>
						<div class="ewpt-form ewpt-form-border-bottom">
							<div class="ewpt-info-blue ewpt-info-border">
								
								<!-- Nested Tab Navigation -->
								<h3 class="nav-tab-wrapper nested-nav-tab-wrapper">
									<?php for ($i = 1; $i <= $emhub_smtp_i; $i++) : ?>
										<a href="#nested-tab-<?php echo intval($i); ?>" class="nav-tab nested-tab">CONNECTION: <?php echo intval($i); ?></a>
									<?php endfor; ?>
								</h3>
								
								<!-- Nested Tab Content -->
								<?php for ($i = 1; $i <= $emhub_smtp_i; $i++) : ?>
								
									<div id="nested-tab-<?php echo intval($i); ?>" class="nested-tab-content">
										<div class="tab-pane">
											<h3 class="ewpt-no-top-border">Connection: <?php echo intval($i); ?></h3>
											<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
											
												<tr valign="top">
													<th scope="row">Connection Name</th>
													<td>
														<label>
															<input type="text" name="emhub_smtp_<?php echo intval($i); ?>_name"  value="<?php echo esc_attr(get_option("emhub_smtp_{$i}_name")); ?>" />
														</label>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															Enter an optional name for this SMTP connection (only for reference)
														</div>
													</td>
												</tr>
												
												<tr valign="top">
													<th scope="row">Connection Type</th>
													<td>
															<select name="emhub_smtp_<?php echo intval($i); ?>_connection_type">
																<option value="php" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'php'); ?>>PHP</option>
																<option value="smtp" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'smtp'); ?>>SMTP</option>
																<option value="aws" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'aws'); ?>>AWS</option>
																<option value="google" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'google'); ?>>Google</option>
																<option value="microsoft" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'microsoft'); ?>>Microsoft</option>
																<option value="yahoo" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'yahoo'); ?>>Yahoo</option>
																<option value="twillio" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'twillio'); ?>>Twillio</option>
																<option value="sengrid" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'sengrid'); ?>>Sengrid</option>
																<option value="turbo-smtp" <?php selected(get_option("emhub_smtp_{$i}_connection_type"), 'turbo-smtp'); ?>>Turbo SMTP</option>
															</select>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															Choose a Connection Type for this SMTP connection
														</div>
													</td>
												</tr>
												
												<tr valign="top">
													<th scope="row">Host</th>
													<td>
														<label>
															<input type="text" name="emhub_smtp_<?php echo intval($i); ?>_host" value="<?php echo esc_attr(get_option("emhub_smtp_{$i}_host")); ?>" />
														</label>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															Enter smtp host url. Example: smtp.gmail.com
														</div>
													</td>
												</tr>
												
												<tr valign="top">
													<th scope="row">Port</th>
													<td>
														<label>
															<input type="number" name="emhub_smtp_<?php echo intval($i); ?>_port" value="<?php echo esc_attr(get_option("emhub_smtp_{$i}_port")); ?>" />
														</label>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															Enter smtp port number. Example: 25, 465, 587, 2525, etc.<br/>
															Typical Port for SMTP: 465 = SSL ; 587 = TLS ; 25 = No Encryption
														</div>
													</td>
												</tr>
												
												<tr valign="top">
													<th scope="row">Username</th>
													<td>
														<label>
															<input type="text" name="emhub_smtp_<?php echo intval($i); ?>_email" value="<?php echo esc_attr(get_option("emhub_smtp_{$i}_email")); ?>" />
														</label>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															Enter smtp host email. Example: example@gmail.com / username
														</div>
													</td>
												</tr>
												
												<tr valign="top">
													<th scope="row">Password</th>
													<td>
														<label>
															<input type="text" name="emhub_smtp_<?php echo intval($i); ?>_password" value="<?php echo esc_attr(get_option("emhub_smtp_{$i}_password")); ?>" />
														</label>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															Enter smtp host email password. Example: your gmail email password / api key.<br/>
															<strong>Note: Password / API key will be stored as plain text. Make sure your site is using SSL.</strong>
														</div>
													</td>
												</tr>
												
												<tr valign="top">
													<th scope="row">Encryption</th>
													<td>
															<select name="emhub_smtp_<?php echo intval($i); ?>_encryption">
																<option value="tls" <?php selected(get_option("emhub_smtp_{$i}_encryption"), 'tls'); ?>>TLS</option>
																<option value="ssl" <?php selected(get_option("emhub_smtp_{$i}_encryption"), 'ssl'); ?>>SSL</option>
																<option value="none" <?php selected(get_option("emhub_smtp_{$i}_encryption"), 'none'); ?>>None</option>
															</select>
													</td>
													<td>
														<div class='ewpt-info-blue'>
															SMTP encryption type of the host (tls/ssl/none)
														</div>
													</td>
												</tr>
												
											</table>
										</div>
									</div>

								<?php endfor; ?>
								
							</div>
						</div>
						
						<div class="ewpt-save-button" style="margin: 30px 0 0 0;">
							<p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p>
						</div>
						
					</div>
				</div>
				
				<div id="email-templates" class="tab-content" style="display: none;">
					<div class="tab-pane">
						
						<h3 class="ewpt-no-top-border">HTML Email Templates</h3>
						<table class="form-table ewpt-form ewpt-form-border-bottom">
						
							<tr valign="top">
								<th scope="row">HTML Email Template</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_outbound_email_templates" value="1" <?php checked(get_option('emhub_outbound_email_templates', 0)) ?> />
										Enable
									</label>
								</td>
								<td>
									<div class='ewpt-info-blue'>
										Activate all outbound email to use html template.
									</div>
								</td>
							</tr>
							
						</table>
												
						<!-- Global Styles -->
						<table class="form-table ewpt-form ewpt-form-border-bottom">
							<!-- Background Color -->
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row">Global Styles</th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="emhub_html_template_global_background" value="<?php echo esc_attr(get_option('emhub_html_template_global_background', 'rgb(221, 51, 51)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(background-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the global BACKGROUND COLOR for the maintenance mode page.
									</div>
								</td>
							</tr>
							<!-- Text Color -->
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="emhub_html_template_global_color" value="<?php echo esc_attr(get_option('emhub_html_template_global_color', 'rgb(255, 255, 255)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(text-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the global text COLOR for the maintenance mode page.
									</div>
								</td>
							</tr>
							<!-- Margin -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_global_margin" value="<?php echo esc_attr(get_option('emhub_html_template_global_margin', 35)); ?>" />
										PX;  (margin)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global MARGIN of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<!-- Padding -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_global_padding" value="<?php echo esc_attr(get_option('emhub_html_template_global_padding', 5)); ?>" />
										PX;  (padding)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global PADDING of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_global_size" value="<?php echo esc_attr(get_option('emhub_html_template_global_size', 16)); ?>" />
										PX;  (font-size)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global FONT SIZE of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<!-- Text Align -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="emhub_html_template_global_align">
											<option value="center" <?php selected(get_option("emhub_html_template_global_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("emhub_html_template_global_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("emhub_html_template_global_align"), 'right'); ?>>Right</option>
										</select>
										(text-align)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the global TEXT ALIGN of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<!-- Font Family -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="size-6x" name="emhub_html_template_global_font" value="<?php echo esc_attr(get_option('emhub_html_template_global_font', '"open sans", sans-serif, Helvetica Neue')); ?>" />
										(font-family)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the global FONTS FAMILY for the maintenance mode page.<br/>
										Default: "open sans", sans-serif, Helvetica Neue
									</div>
								</td>
							</tr>
							
						</table>
						
						<!-- Template Design -->
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
						 
							<!-- Logo URL using WordPress Media Uploader -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Header Logo</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_html_template_logo_enable" value="1" <?php checked(get_option('emhub_html_template_logo_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="url" name="emhub_html_template_logo_media_link" id="emhub_html_template_logo_media_link" value="<?php echo esc_url(get_option('emhub_html_template_logo_media_link', '')); ?>" />
									</label>
									<input type="button" id="upload_logo_button" class="button" value="Choose Logo" />
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the link, Upload, or choose the logo to display on the maintenance mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_logo_media_width" value="<?php echo esc_attr(get_option('emhub_html_template_logo_media_width', 192)); ?>" />
										PX;  (width)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the width and height of the page logo. '0' means auto
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_logo_media_height" value="<?php echo esc_attr(get_option('emhub_html_template_logo_media_height', 0)); ?>" />
										PX; (height)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the width and height of the page logo. '0' means auto
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="emhub_html_template_logo_media_align">
											<option value="center" <?php selected(get_option("emhub_html_template_logo_media_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("emhub_html_template_logo_media_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("emhub_html_template_logo_media_align"), 'right'); ?>>Right</option>
										</select>
										(alignment)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the page logo alignment
									</div>
								</td>
							</tr>
							<!-- Logo Link -->
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="checkbox" name="emhub_html_template_logo_url_enable" value="1" <?php checked(get_option('emhub_html_template_logo_url_enable', 0)) ?> />
										Enable
									</label>
									<label>
										<input type="url" name="emhub_html_template_logo_url" value="<?php echo esc_url(get_option('emhub_html_template_logo_url', '')); ?>" />
										(URL)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the "Maintenance Mode" page logo URL (link).
									</div>
								</td>
							</tr>

							<!-- H1 Text -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Header Title</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_html_template_h1_text_enable" value="1" <?php checked(get_option('emhub_html_template_h1_text_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="emhub_html_template_h1_text_color" value="<?php echo esc_attr(get_option('emhub_html_template_h1_text_color', 'rgb(255, 255, 255)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(text-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the H1 Text color
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_h1_text_size" value="<?php echo esc_attr(get_option('emhub_html_template_h1_text_size', 32)); ?>" />
										PX;  (font-size)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the H1 text FONT SIZE of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="emhub_html_template_h1_text_align">
											<option value="center" <?php selected(get_option("emhub_html_template_h1_text_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("emhub_html_template_h1_text_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("emhub_html_template_h1_text_align"), 'right'); ?>>Right</option>
										</select>
										(alignment)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the H1 Text Alignment
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="size-6x" name="emhub_html_template_h1_text" value="<?php echo esc_textarea(get_option('emhub_html_template_h1_text', "We'll be back soon!")); ?>" />
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the H1 Text for the maintenance mode page.
									</div>
								</td>
							</tr>

							<!-- Footer HTML Text -->
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row">Footer HTML</th>
								<td>
									<label>
										<input type="checkbox" name="emhub_html_template_paragraph_enable" value="1" <?php checked(get_option('emhub_html_template_paragraph_enable', 0)) ?> />
										Enable
									</label>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border color-2px-margin-top">
								<th scope="row"></th>
								<td>
									<label>
										<input type="text" class="ewpt-color-field" data-alpha-enabled="true" name="emhub_html_template_paragraph_text_color" value="<?php echo esc_attr(get_option('emhub_html_template_paragraph_text_color', 'rgb(255, 255, 255)')); ?>" />
									</label>
									<text class="ewpt-color-left-padding">(text-color)</text>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the Paragraph Text  color
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<input type="number" name="emhub_html_template_paragraph_text_size" value="<?php echo esc_attr(get_option('emhub_html_template_paragraph_text_size', 16)); ?>" />
										PX;  (font-size)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the Paragraph text FONT SIZE of the Maintenance Mode page.
									</div>
								</td>
							</tr>
							<tr valign="top" class="ewpt-no-bottom-border">
								<th scope="row"></th>
								<td>
									<label>
										<select name="emhub_html_template_paragraph_text_align">
											<option value="center" <?php selected(get_option("emhub_html_template_paragraph_text_align"), 'center'); ?>>Center</option>
											<option value="left" <?php selected(get_option("emhub_html_template_paragraph_text_align"), 'left'); ?>>Left</option>
											<option value="right" <?php selected(get_option("emhub_html_template_paragraph_text_align"), 'right'); ?>>Right</option>
										</select>
										(alignment)
									</label>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Choose the Paragraph Text Alignment
									</div>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"></th>
								<td>
									<?php
									$content = get_option('emhub_html_template_paragraph_text', "<p>We're performing some maintenance at the moment. We’ll be back up shortly!</p><p>— <strong>The Team</strong></p>");
									$editor_id = 'emhub_html_template_paragraph_text';
									$settings = array(
										'textarea_name' => 'emhub_html_template_paragraph_text',
										'textarea_rows' => 8,
										'media_buttons' => true,
										'tinymce' => false, // Disable TinyMCE (visual editor)
										'quicktags' => true, // Enable Quicktags
										'teeny' => false, // Use the minimal editor
										//'editor_class' => 'ewpt-code-field', // Custom class
									);
									wp_editor($content, $editor_id, $settings);
									?>
								</td>
								<td>
									<div class='description ewpt-info-blue'>
										Enter the Paragraph Text for the maintenance mode page.
									</div>
									<br/>
									<div class='ewpt-info-green'>
										Basic <strong>HTML</strong> Tags and Attributes are supported.
									</div>
								</td>
							</tr>
							
						</table>
						
					</div>
					
					<div class="nav-tab ewpt-save-button" style="margin: 30px 0 0 0;"><p class="submit"><input form="<?php echo sanitize_html_class(EWPT_SHORT_SLUG); ?>-form" type="submit" name="submit" id="submit" class="ewpt-save-btn button button-primary" value="Save Changes"></p></div>
					
				</div>
				
				<div id="email-log" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Outbound Email Log</h3>
						
						<div class="ewpt-form ewpt-no-border-bottom">
							<div class="ewpt-info-border ewpt-info-full">
									<div id="emhub_reload_email_log_btn" class="button">Reload Log</div>
									<div id="emhub_empty_email_log_btn" class="button">Empty Log</div>
							</div>
						</div>
						
						<?php
						// All options disable options name
						$emhub_enable_email_log = get_option('emhub_enable_outbound_email_log');
						if ($emhub_enable_email_log === 0 || empty($emhub_enable_email_log)) {
						?>
							<div class="ewpt-form ewpt-no-border-bottom">
								<div class="ewpt-info-border ewpt-info-full">
									<div class="ewpt-info-red">The <strong>Email Log's </strong> is currently disabled!</div>
								</div>
							</div>
						<?php } ?>
						
						<table class="wp-list-table widefat fixed striped ewpt-no-top-border ewpt-form-border-bottom ewpt-border-radius-bottom-5px">

							<!-- Table header -->
							<thead>
								<tr valign="top">
									<th style="width:25px;">#ID</th>
									<th>To</th>
									<th>Subject</th>
									<th>From</th>
									<th style="width:65px;">Status</th>
									<th style="width:130px;">Date</th>
								</tr>
							</thead>
							<!-- Table body will be populated via Ajax -->
							<tbody id="email-log-body">
								<!-- Ajax response will be injected here -->
							</tbody>
							
						</table>
						
					</div>
				</div>

				<?php
				// Include the module about file
				include(EWPT_PLUGIN_PATH . 'inc/ewpt-about-modules.php');
				?>
				
				<?php //submit_button('Save Changes'); ?>
						
			</form>
							
			<form id="emhub_test_email_address-form" method="post">
					
				<div id="test-email" class="tab-content" style="display: none;">
					<div class="tab-pane">
						<h3 class="ewpt-no-top-border">Send Test Email</h3>
						
						<table class="form-table ewpt-form ewpt-form-border-bottom ewpt-border-radius-bottom-5px">
							
							<tr valign="top">
								<th scope="row">Send Test Email</th>
								<td>
									<?php wp_nonce_field( sanitize_text_field('emhub_test_email_nonce'), sanitize_text_field('emhub_test_email_nonce' ) ); ?>
									<input type="email" id="emhub_test_email_address" name="emhub_test_email_address" value="<?php echo esc_html(is_email(wp_get_current_user()->user_email)); ?>" placeholder="Enter receiver email address">
									<button form="emhub_test_email_address-form" type="submit" name="submit" id="emhub_test_email_button" class="button">Send test email</button>
								</td>
								<td>
									<span id="emhub_test_email_result"></span>
								</td>
							</tr>
							
						</table>
						
					</div>
				</div>
					
			</form>
				
		</div>
		
		<div id="ewpt-page-footer" class="ewpt-page-footer">
			
			<?php
			// Include the module footer file
			include EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php';
			?>

			<!-- Modals -->
			<div id="confirmEmptyLog" class="ewpt modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<header>
						<h2>Message</h2>
					</header>
					<div>
						<p id="confirm-message">Are you sure you want to clear the email log?</p>
					</div>
					<footer>
						<button id="confirmClearLog" class="ok button">Yes, Clear Log</button>
						<button id="cancelClearLog" class="cancel button">Cancel</button>
					</footer>
				</div>
			</div>

			<div id="messageEmptyLog" class="ewpt modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<header>
						<h2>Message</h2>
					</header>
					<div>
						<p id="message-empty-log"></p>
					</div>
					<footer>
						<button class="close button">Close</button>
					</footer>
				</div>
			</div>
			
			<script>
			jQuery(document).ready(function($) {
				//Function to  Send Test Email
				$('#emhub_test_email_button').click(function(e) {
					e.preventDefault();
					
					// Get the email address from the input field
					var email = $('#emhub_test_email_address').val();
					// Get the nonce from the hidden input field
					var nonce = $('#emhub_test_email_nonce').val();
					
					// Check if the email address is provided
					if (!email) {
						$('#emhub_test_email_result').text('Please provide an email address.');
						return;
					}
					
					// Show "Please wait..." message
					$('#emhub_test_email_button').prop('disabled', true).text('Please wait ... ...');
					
					// Send AJAX request to send test email
					$.ajax({
						type: 'POST',
						url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
						data: {
							action: 'emhub_send_test_email',
							emhub_test_email_address: email,
							emhub_test_email_nonce: nonce
						},
						success: function(response) {
							// Parse JSON response
							var data = $.parseJSON(response);
							
							// Show result message
							$('#emhub_test_email_result').text(data.message);
						},
						error: function(xhr, textStatus, errorThrown) {
							console.log(xhr.responseText);
						},
						complete: function() {
							// Restore button text and enable button
							$('#emhub_test_email_button').prop('disabled', false).text('Send test email');
						}
					});
					
				});
				
			});
			</script>

			<script>
			jQuery(document).ready(function($) {
				// Function to fetch email log via Ajax
				function getEmailLog(callback) {
					$.ajax({
						type: 'POST',
						url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
						dataType: 'json',
						data: {
							action: 'emhub_get_email_log',
							nonce: '<?php echo esc_attr( wp_unslash( wp_create_nonce( "emhub_get_email_log_nonce" ) ) ); ?>' // Add nonce for security
						},
						success: function(response) {
							displayEmailLog(response);
						},
						error: function(xhr, status, error) {
							console.error(xhr.responseText);
						},
						complete: function() {
							if (typeof callback === 'function') {
								callback();
							}
						}
					});
				}

				// Function to display email log in table
				function displayEmailLog(emailLog) {
					var html = '';
					$.each(emailLog, function(index, log) {
						html += '<tr>';
						html += '<td>' + log.id + '</td>';
						html += '<td>' + log.to_email + '</td>';
						html += '<td>' + log.subject + '</td>';
						html += '<td>' + log.from_email + '</td>';
						html += '<td>' + log.status + '</td>';
						html += '<td>' + log.timestamp + '</td>';
						html += '</tr>';
					});
					$('#email-log-body').html(html);
				}

				// Initial email log load on page load
				getEmailLog();

				// Function to reload email log
				$(document).on('click', '#emhub_reload_email_log_btn', function(e) {
					e.preventDefault();
					$(this).prop('disabled', true).text('Please wait..');
					getEmailLog(function() {
						$('#emhub_reload_email_log_btn').prop('disabled', false).text('Reload Log');
					});
				});

				// Function to empty email log
				function handleEmailLogClearing() {
					showMessageModal('confirmEmptyLog');

					$(document).on('click', '#confirmClearLog', function() {
						hideMessageModal('confirmEmptyLog');
						$('#emhub_empty_email_log_btn').prop('disabled', true).text('Please wait..');

						$.ajax({
							type: 'POST',
							url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
							data: {
								action: 'emhub_clear_email_log',
								nonce: '<?php echo esc_attr( wp_unslash( wp_create_nonce( "emhub_clear_email_log_nonce" ) ) ); ?>' // Add nonce for security
							},
							success: function(response) {
								if(response.success) {
									$('#messageEmptyLog').addClass('success'); // add 'success' class for modal
									showMessageModal('messageEmptyLog', 'Email log cleared successfully!');
								} else {
									$('#messageEmptyLog').addClass('errors'); // add 'errors' class for modal
									showMessageModal('messageEmptyLog', 'Failed to clear the email log. Please try again.');
								}
								getEmailLog();
							},
							error: function(xhr, status, error) {
								console.error(xhr.responseText);
								$('#messageEmptyLog').addClass('errors'); // add 'errors' class for modal
								showMessageModal('messageEmptyLog', 'An error occurred while clearing the email log.');
								$('#emhub_empty_email_log_btn').prop('disabled', false).text('Empty Log');
							},
							complete: function() {
								$('#emhub_empty_email_log_btn').prop('disabled', false).text('Empty Log');
							}
						});
					});

					$(document).on('click', '#cancelClearLog', function() {
						hideMessageModal('confirmEmptyLog');
					});
				}

				$(document).on('click', '#emhub_empty_email_log_btn', function(e) {
					e.preventDefault();
					$('#messageEmptyLog').removeClass('success errors'); // remove dynamic class ''
					handleEmailLogClearing();
				});

				// Show modal function with fadeIn effect
				function showMessageModal(modalId, message) {
					$('#' + modalId + ' p').html(message);
					$('#' + modalId).fadeIn();
					setTimeout(function() {
						$('#' + modalId).fadeOut();
					}, 10000); // Hide the modal after 10 seconds
				}

				// Hide modal function with fadeOut effect
				function hideMessageModal(modalId) {
					$('#' + modalId).fadeOut();
				}

				// Close modal on clicking the close button or cancel button
				$(document).on('click', '.close, .cancel', function() {
					$(this).closest('.modal').fadeOut();
				});
				
			});
			</script>
			
			<script id="emhub-uploader-script">
			(function($) {
				// Logo Uploader Script
				$(document).ready(function () {
					var mediaUploader;

					$('#upload_logo_button').click(function (e) {
						e.preventDefault();
						if (mediaUploader) {
							mediaUploader.open();
							return;
						}

						mediaUploader = wp.media.frames.file_frame = wp.media({
							title: 'Choose Logo',
							button: {
								text: 'Choose Logo'
							},
							multiple: false
						});

						mediaUploader.on('select', function () {
							var attachment = mediaUploader.state().get('selection').first().toJSON();
							$('#emhub_html_template_logo_media_link').val(attachment.url);
						});

						mediaUploader.open();
					});
					
					// Initialize color picker for elements with class 'ewpt-color-field'
					$(".ewpt-color-field").wpColorPicker();
					
					// Initialize color mirror for elements with class 'ewpt-textarea-code'
					wp.codeEditor.initialize($('.ewpt-code-field'), cm_settings);
					
				});
			})(jQuery);
			</script>
			
			<?php
				// Enqueue necessary scripts for media uploader
				wp_enqueue_media();
			?>

			<?php
			// Include the module footer file
			include(EWPT_PLUGIN_PATH . 'inc/ewpt-modules-footer.php');
			?>
			
		</div>
		
    </div>
	
	
	<?php
}

	// Add AJAX action for sending test email with nonce verification
	add_action( 'wp_ajax_emhub_send_test_email', function () {
		// Nonce verification
		if (!ewpt::check_nonce(esc_attr(strtolower('emhub_test_email_nonce')))) {
			echo wp_json_encode(array('success' => false, 'message' => 'Security (nonce) verification failed!'));
			exit;
		}
		
		// Get the email address from the input field
		$email_address = isset( $_POST['emhub_test_email_address'] ) ? sanitize_email( $_POST['emhub_test_email_address'] ) : '';

		// Check if email address is provided and is valid
		if (!empty($email_address) && is_email($email_address)) {

			// Get the outgoing email from name
			$sender_name = get_option('wp_mail_from_name');
			// Get the outgoing email sender address
			$sender_email = get_option('wp_mail_from');
			
			// Check if the sender email is empty or invalid
			if (empty($sender_email) || !is_email($sender_email)) {
				// If empty or invalid, use the admin email as a fallback
				$sender_email = get_option('admin_email');
			}
			
			// Set up email parameters
			$subject = 'Test Email - Email Manager Hub (EWPT)';
			$message = 'Hello<br/><br/>This is a test email sent by you from your WordPress website.<br/><br/>Powered by: Email Manager Hub (EWPT)';

			// Set up email headers
			$headers = array(
				'From: ' . esc_attr($sender_name) . ' <' . is_email($sender_email) . '>',
				'Content-Type: text/html; charset=UTF-8',
			);
			
			// Send email
			$result = wp_mail(is_email($email_address), esc_attr($subject), ewpt::rsd_sanitize_html_raw_field($message), $headers);

			// Check if email was sent successfully
			if ($result) {
				// Return success message
				echo wp_json_encode(array('success' => true, 'message' => 'Test email sent successfully.'));
			} else {
				// Return error message
				echo wp_json_encode(array('success' => false, 'message' => 'Failed to send test email.'));
			}
		} else {
			// Return error message if email address is empty or invalid
			echo wp_json_encode(array('success' => false, 'message' => 'Please provide a valid email address.'));
		}

		// Always exit to avoid further execution
		exit;
	});

	// Include the actions (mostly ajax call)
	include plugin_dir_path(__FILE__) . 'ewpt-email-manager-hub-actions.php';
	
} // if (!function_exists('ewpt_email_manager_hub_settings_page'))