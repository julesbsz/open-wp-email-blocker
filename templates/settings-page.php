<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$blocking_enabled = get_option(Open_Wp_Email_Blocker::OPTION_BLOCKING_ENABLED, false);
$redirect_emails = get_option(Open_Wp_Email_Blocker::OPTION_REDIRECT_EMAILS, '');
?>

<div class="wrap">
    <h1><?php esc_html_e('Open WP Email Blocker Settings', 'owpeb'); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('owpeb_options_group');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Enable Email Blocking', 'owpeb'); ?></th>
                <td>
                    <input type="checkbox" name="<?php echo esc_attr(Open_Wp_Email_Blocker::OPTION_BLOCKING_ENABLED); ?>" value="1" <?php checked(1, $blocking_enabled, true); ?> />
                    <label for="<?php echo esc_attr(Open_Wp_Email_Blocker::OPTION_BLOCKING_ENABLED); ?>">
                        <?php esc_html_e('Check this box to enable email blocking.', 'owpeb'); ?>
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e('Redirect Emails To', 'owpeb'); ?></th>
                <td>
                    <input type="text" name="<?php echo esc_attr(Open_Wp_Email_Blocker::OPTION_REDIRECT_EMAILS); ?>" value="<?php echo esc_attr( $redirect_emails ); ?>" size="50" />
                    <p class="description"><?php esc_html_e('Enter email addresses separated by commas to redirect all emails to these addresses instead of blocking them.', 'owpeb'); ?></p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
