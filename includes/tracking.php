<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Track plugin installation (runs once)
 */
add_action('admin_init', function () {
    // Only send tracking if site owner has opted in.
    if (get_option('aisb_tracking_optin', 'no') !== 'yes') {
        return;
    }

    // Skip if already tracked
    if (get_option('ai_summary_tracked')) {
        return;
    }
    
    // Tracking endpoint must be configured by integration code.
    $tracking_url = apply_filters('aisb_tracking_url', '');
    if (empty($tracking_url)) {
        return;
    }
    
    $response = wp_remote_post(esc_url_raw($tracking_url), [
        'timeout' => 5,
        'blocking' => false, // Non-blocking request
        'body' => [
            'domain' => home_url(),
            'plugin' => 'ai-summary-buttons',
            'version' => AISB_VERSION,
            'wp_version' => get_bloginfo('version'),
            'php_version' => PHP_VERSION
        ]
    ]);
    
    // Mark as tracked regardless of success to avoid repeated attempts
    update_option('ai_summary_tracked', 1);
    
    // Log errors for debugging
    if (is_wp_error($response)) {
        error_log('AI Summary Tracking Error: ' . $response->get_error_message());
    }
});
