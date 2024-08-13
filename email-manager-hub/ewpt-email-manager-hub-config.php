<?php
// essential-wp-tools/modules/email-manager-hub/ewpt-email-manager-hub-config.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//Defined Variable Parameters
$EWPT_MODULE_NAME = "Email Manager Hub";
$EWPT_MODULE_DESC = "Manage your WordPress site's email sender's name and email address, and in future we will add stunning HTML template-based emails.";
$EWPT_MODULE_READY = "Development"; // eg: Production, Development
$EWPT_MODULE_VAR = "email_manager_hub";
$EWPT_MODULE_SLUG = "email-manager-hub";
$EWPT_MODULE_TAB_VAR = "EmailManagerHub";
$EWPT_MODULE_TAB_DEFAULT = "default-settings";
$EWPT_MODULE_VERSION = "1.0.0";
$EWPT_MODULE_URL = "https://github.com/RactStudio/".$EWPT_MODULE_SLUG."/";
$EWPT_MODULE_AUTHOR = "Mahamudul Hasan Rubel";
$EWPT_MODULE_AUTHOR_URL = "https://mhr.ractstudio.com/";
$EWPT_MODULE_DONATE = "https://www.buymeacoffee.com/ractstudio/";

// Check module readiness
if ($EWPT_MODULE_READY == "Production") {
	$module_ready_class = "ewpt-info-green";
} elseif ($EWPT_MODULE_READY == "Development") {
	$module_ready_class = "ewpt-info-red";
} else {
	$module_ready_class = "ewpt-info-blue";
}