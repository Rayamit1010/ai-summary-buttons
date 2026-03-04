<?php
/**
 * AJAX Handlers for AI Summary Buttons
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle AJAX request to save configurations
 */
function aisb_ajax_save_configs() {
    check_ajax_referer('aisb_admin_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Permission denied']);
        return;
    }
    
    $configs = isset($_POST['configs']) ? (array) $_POST['configs'] : [];
    $saved_configs = aisb_sanitize_configs($configs);
    
    update_option('aisb_button_configs', $saved_configs);
    
    wp_send_json_success(['message' => 'Settings saved successfully!']);
}
add_action('wp_ajax_aisb_save_configs', 'aisb_ajax_save_configs');

/**
 * Handle AJAX request to reset configurations
 */
function aisb_ajax_reset_configs() {
    check_ajax_referer('aisb_admin_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Permission denied']);
        return;
    }
    
    delete_option('aisb_button_configs');
    
    wp_send_json_success([
        'message' => 'Settings reset to defaults successfully!',
        'configs' => aisb_get_default_configs()
    ]);
}
add_action('wp_ajax_aisb_reset_configs', 'aisb_ajax_reset_configs');
