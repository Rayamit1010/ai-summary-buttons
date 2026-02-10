<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Validate license key with remote server
 *
 * @param string $key License key to validate
 * @return bool True if valid, false otherwise
 */
function ai_validate_license($key) {
    if (empty($key)) {
        return false;
    }
    
    // Replace with your actual license server URL
    $license_server = 'https://yourdomain.com/license';
    
    $response = wp_remote_post($license_server, [
        'timeout' => 10,
        'body' => [
            'license' => sanitize_text_field($key),
            'domain' => home_url(),
            'product' => 'ai-summary-buttons'
        ]
    ]);
    
    // Handle errors
    if (is_wp_error($response)) {
        error_log('AI Summary License Check Error: ' . $response->get_error_message());
        return false;
    }
    
    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    return !empty($data['valid']);
}
