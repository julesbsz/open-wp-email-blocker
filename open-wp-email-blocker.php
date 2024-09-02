<?php
/**
 * Plugin Name: Open WP Email Blocker
 * Description: An Open Source plugin that blocks or redirects e-mails sent by WordPress.
 * Version: 0.1
 * Author: Jules Bousrez
 * License: GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define the plugin directory path and URL.
define( 'OWPEB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'OWPEB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include the main class file.
require_once OWPEB_PLUGIN_DIR . 'includes/class-email-blocker.php';
require_once OWPEB_PLUGIN_DIR . 'includes/class-email-blocker-admin.php';

// Register activation and deactivation hooks.
register_activation_hook( __FILE__, array( 'Open_Wp_Email_Blocker', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Open_Wp_Email_Blocker', 'deactivate' ) );

// Initialize the plugin.
add_action( 'plugins_loaded', array( 'Open_Wp_Email_Blocker', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'Open_Wp_Email_Blocker_Admin', 'get_instance' ) );
?>