<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Open_Wp_Email_Blocker {
    // Options.
    const OPTION_BLOCKING_ENABLED = 'owpeb_blocking_enabled';
    const OPTION_REDIRECT_EMAILS = 'owpeb_redirect_emails';

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
        // Hook into phpmailer_init and block e-mails.
        add_action( 'phpmailer_init', array( $this, 'handle_emails' ), 10, 1 );

        // Initialize options
        $this->init_options();
    }

    /**
     * Initialize the plugin options.
     */
    public function init_options() {
        if ( false === get_option( self::OPTION_BLOCKING_ENABLED ) ) {
            update_option( self::OPTION_BLOCKING_ENABLED, true );
        }
        if ( false === get_option( self::OPTION_REDIRECT_EMAILS ) ) {
            update_option( self::OPTION_REDIRECT_EMAILS, '' );
        }
    }

    /**
     * Handle e-mails sent by WordPress.
     *
     * @param PHPMailer $phpmailer The PHPMailer instance (passed by reference).
     */
    public function handle_emails( $phpmailer ) {
        error_log('handlling emails');

        $blocking_enabled = filter_var( get_option( self::OPTION_BLOCKING_ENABLED, false ), FILTER_VALIDATE_BOOLEAN );
        $redirect_emails = get_option( self::OPTION_REDIRECT_EMAILS, '' );

        error_log('blocking_enabled (type: ' . gettype($blocking_enabled) . '): ' . var_export($blocking_enabled, true));
        error_log('redirect_emails: ' . $redirect_emails);

        if ( $blocking_enabled ) {
            if ( ! empty( $redirect_emails ) ) {
                // Redirect the email to the specified addresses
                $emails = explode( ',', $redirect_emails );
                $emails = array_map( 'trim', $emails ); // Trim spaces around emails
                $phpmailer->ClearAllRecipients(); // Clear all current recipients
                foreach ( $emails as $email ) {
                    if ( is_email( $email ) ) {
                        $phpmailer->addAddress( $email ); // Add new recipient
                    }
                }
                error_log( 'E-mail redirected to: ' . implode( ', ', $emails ) );
            } else {
                // Clear all recipients to effectively block the email
                $phpmailer->ClearAllRecipients();
                error_log( 'E-mail blocked');
            }
        }
    }

    /**
     * Activation hook.
     */
    public static function activate() {
        update_option( self::OPTION_BLOCKING_ENABLED, true );
        update_option( self::OPTION_REDIRECT_EMAILS, '' );
    }

    /**
     * Deactivation hook.
     */
    public static function deactivate() {
        delete_option( self::OPTION_BLOCKING_ENABLED );
        delete_option( self::OPTION_REDIRECT_EMAILS );
    }
}
?>
