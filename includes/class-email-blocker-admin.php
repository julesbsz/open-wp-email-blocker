<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Open_Wp_Email_Blocker_Admin {
    
    // The single instance of the class.
    private static $instance = null;

    // Get the instance of the class.
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructor.
    public function __construct() {
        // Add the settings page
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        // Register the settings
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    /**
     * Add the settings page.
     */
    public function add_settings_page() {
        add_options_page(
            'Open WP Email Blocker Settings',
            'Email Blocker',
            'manage_options',
            'owpeb-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Register the settings.
     */
    public function register_settings() {
        register_setting(
            'owpeb_options_group',
            Open_Wp_Email_Blocker::OPTION_BLOCKING_ENABLED 
        );
    }

    /**
     * Render the settings page.
     */
    public function render_settings_page() {
        include OWPEB_PLUGIN_DIR . 'templates/settings-page.php';
    }
}
