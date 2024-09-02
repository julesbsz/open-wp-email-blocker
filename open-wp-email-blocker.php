<?php
/**
 * Plugin Name: Open WP Email Blocker
 * Description: An Open Source plugin that blocks or redirects e-mails sent by Wordpress.
 * Version: 0.1
 * Author: Jules Bousrez
 * License: GPL-2.0+
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define the plugin directory path.
define( 'OWPEB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );