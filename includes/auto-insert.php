<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Auto-insert AI summary buttons after post content
 */
add_filter('the_content', function ($content) {
    // Only on single posts
    if (!is_single()) {
        return $content;
    }
    
    // Check if auto-insert is enabled
    if (get_option('aisb_auto_insert') !== 'yes') {
        return $content;
    }
    
    // Don't insert if we're in the admin or doing AJAX
    if (is_admin() || wp_doing_ajax()) {
        return $content;
    }
    
    // Get position
    $position = get_option('aisb_auto_insert_position', 'after');
    
    // Generate buttons
    $buttons = do_shortcode('[ai_summary_buttons]');
    
    // Insert based on position
    if ($position === 'before') {
        return $buttons . $content;
    } else {
        return $content . $buttons;
    }
});
