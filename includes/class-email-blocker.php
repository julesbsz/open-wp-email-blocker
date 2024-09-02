<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Open_Wp_Email_Blocker {
    // Options.
    const OPTION_BLOCKING_ENABLED = 'owpeb_blocking_enabled';

    // The single instance of the class.
    private static $instance = null;

    // Get the instance of the class.
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Initialize the plugin.
    private function __construct() {
        // Hook into wp_mail and block e-mails.
        add_filter( 'wp_mail', array( $this, 'handle_emails' ), 10, 1 );

        // Initialize options
        $this->init_options();
    }

    /**
     * Initialize the plugin options.
     */
    public function init_options() {
        if ( false === get_option( self::OPTION_BLOCKING_ENABLED ) ) {
            update_option( self::OPTION_BLOCKING_ENABLED, false );
        }
    }

    /**
     * Handle e-mails sent by WordPress.
     *
     * @param array $args Arguments passed to wp_mail function.
     * @return array|false Modified arguments or false to block the email.
     */
    public function handle_emails( $args ) {
        $blocking_enabled = filter_var( get_option( self::OPTION_BLOCKING_ENABLED, false ), FILTER_VALIDATE_BOOLEAN );
        
        if ( $blocking_enabled ) {
            error_log( 'E-mail blocked: ' . print_r( $args, true ) );
            return false;
        }
        
        return $args;
    }

    /**
     * Activation hook.
     */
    public static function activate() {
        update_option( self::OPTION_BLOCKING_ENABLED, false );
    }

    /**
     * Deactivation hook.
     */
    public static function deactivate() {
        delete_option( self::OPTION_BLOCKING_ENABLED );
    }
}
?>
