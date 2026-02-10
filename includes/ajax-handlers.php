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
    
    $configs = isset($_POST['configs']) ? $_POST['configs'] : [];
    
    // Validate and sanitize
    $saved_configs = [];
    $default_configs = aisb_get_default_configs();
    
    foreach ($configs as $ai_type => $config) {
        if (!isset($default_configs[$ai_type])) {
            continue;
        }
        
        $saved_configs[$ai_type] = [
            'enabled' => isset($config['enabled']) && $config['enabled'] === true,
            'label' => sanitize_text_field($config['label'] ?? $default_configs[$ai_type]['label']),
            'color' => sanitize_hex_color($config['color'] ?? $default_configs[$ai_type]['color']),
            'text_color' => sanitize_hex_color($config['text_color'] ?? $default_configs[$ai_type]['text_color']),
            'logo_svg' => wp_kses($config['logo_svg'] ?? $default_configs[$ai_type]['logo_svg'], [
                'svg' => ['xmlns' => [], 'viewbox' => [], 'fill' => [], 'width' => [], 'height' => []],
                'path' => ['d' => [], 'fill' => []],
                'circle' => ['cx' => [], 'cy' => [], 'r' => [], 'fill' => []],
                'rect' => ['x' => [], 'y' => [], 'width' => [], 'height' => [], 'fill' => []],
                'g' => ['fill' => [], 'transform' => []],
            ])
        ];
    }
    
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
