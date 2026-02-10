<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * White Label Settings (Pro Feature)
 * Only available if license is valid
 */
add_action('admin_menu', function () {
    add_submenu_page(
        'ai-summary-about',
        'White Label',
        'White Label',
        'manage_options',
        'ai-summary-white-label',
        function () {
            // Save settings
            if (isset($_POST['ai_wl_nonce']) && wp_verify_nonce($_POST['ai_wl_nonce'], 'ai_white_label_settings')) {
                update_option('ai_white_label', isset($_POST['enable_wl']) ? 'yes' : 'no');
                echo '<div class="notice notice-success"><p>White label settings saved!</p></div>';
            }
            ?>
            <div class="wrap">
                <h2>White Label Settings</h2>
                <p>Remove developer branding from the plugin.</p>
                
                <form method="post">
                    <?php wp_nonce_field('ai_white_label_settings', 'ai_wl_nonce'); ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">Enable White Label</th>
                            <td>
                                <label>
                                    <input type="checkbox" name="enable_wl" value="yes" <?php checked(get_option('ai_white_label'), 'yes'); ?>>
                                    Hide developer information from About page
                                </label>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button('Save Settings'); ?>
                </form>
            </div>
            <?php
        }
    );
});
