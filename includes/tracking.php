<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Track plugin installation (runs once)
 */
add_action('admin_init', function () {
    // Skip if already tracked
    if (get_option('ai_summary_tracked')) {
        return;
    }
    
    // Replace with your actual tracking server URL
    $tracking_url = 'https://yourdomain.com/track';
    
    $response = wp_remote_post($tracking_url, [
        'timeout' => 5,
        'blocking' => false, // Non-blocking request
        'body' => [
            'domain' => home_url(),
            'plugin' => 'ai-summary-buttons',
            'version' => AI_SUMMARY_VERSION,
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
