<?php
/**
 * Admin Settings Page - Button Customization
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the settings page
 */
function aisb_settings_page() {
    // Check user permissions
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Save settings
    if (isset($_POST['aisb_save_configs']) && check_admin_referer('aisb_save_configs_nonce')) {
        aisb_save_button_configs();
    }
    
    // Reset to defaults
    if (isset($_POST['aisb_reset_configs']) && check_admin_referer('aisb_reset_configs_nonce')) {
        delete_option('aisb_button_configs');
        echo '<div class="notice notice-success"><p>Settings reset to defaults successfully!</p></div>';
    }
    
    $configs = aisb_get_configs();
    ?>
    
    <div class="wrap aisb-admin-wrap">
        <h1 class="aisb-admin-title">
            <span class="dashicons dashicons-share"></span>
            AI Summary Buttons - Customize
        </h1>
        
        <div class="aisb-admin-header">
            <p class="aisb-description">
                Customize the appearance and behavior of your AI summary buttons. 
                Change colors, logos, labels, and enable/disable specific AI services.
            </p>
        </div>
        
        <div class="aisb-admin-content">
            <!-- Preview Section -->
            <div class="aisb-preview-section">
                <h2>Live Preview</h2>
                <div class="aisb-preview-container">
                    <div class="aisb-wrapper" id="aisb-preview">
                        <div class="aisb-buttons" id="preview-buttons">
                            <?php foreach ($configs as $ai_type => $config): ?>
                                <?php if ($config['enabled']): ?>
                                    <?php 
                                    $logo_position = isset($config['logo_position']) ? esc_attr($config['logo_position']) : 'left';
                                    $logo_class = 'aisb-logo-' . $logo_position;
                                    ?>
                                    <button type="button" 
                                            class="aisb-btn aisb-btn-<?php echo esc_attr($ai_type); ?> <?php echo $logo_class; ?>"
                                            data-aisb-type="<?php echo esc_attr($ai_type); ?>"
                                            style="background: <?php echo esc_attr($config['color']); ?>; color: <?php echo esc_attr($config['text_color']); ?>;">
                                        <span class="aisb-btn-icon">
                                            <?php echo $config['logo_svg']; ?>
                                        </span>
                                        <span class="aisb-btn-text">
                                            <?php echo esc_html($config['label']); ?>
                                        </span>
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Customization Form -->
            <form method="post" action="" class="aisb-settings-form">
                <?php wp_nonce_field('aisb_save_configs_nonce'); ?>
                
                <h2>Button Customization</h2>
                
                <div class="aisb-buttons-config">
                    <?php foreach ($configs as $ai_type => $config): ?>
                        <div class="aisb-button-config-item" data-ai-type="<?php echo esc_attr($ai_type); ?>">
                            <div class="aisb-config-header">
                                <div class="aisb-config-title">
                                    <span class="aisb-config-icon">
                                        <?php echo $config['logo_svg']; ?>
                                    </span>
                                    <h3><?php echo esc_html($config['name']); ?></h3>
                                </div>
                                <label class="aisb-toggle">
                                    <input type="checkbox" 
                                           name="aisb_configs[<?php echo esc_attr($ai_type); ?>][enabled]" 
                                           value="1" 
                                           <?php checked($config['enabled'], true); ?>
                                           class="aisb-toggle-input">
                                    <span class="aisb-toggle-slider"></span>
                                </label>
                            </div>
                            
                            <div class="aisb-config-body">
                                <div class="aisb-config-row">
                                    <div class="aisb-config-field">
                                        <label>Button Label</label>
                                        <input type="text" 
                                               name="aisb_configs[<?php echo esc_attr($ai_type); ?>][label]" 
                                               value="<?php echo esc_attr($config['label']); ?>"
                                               class="aisb-input aisb-label-input"
                                               placeholder="<?php echo esc_attr($config['name']); ?>">
                                    </div>
                                    
                                    <div class="aisb-config-field">
                                        <label>Background Color</label>
                                        <input type="text" 
                                               name="aisb_configs[<?php echo esc_attr($ai_type); ?>][color]" 
                                               value="<?php echo esc_attr($config['color']); ?>"
                                               class="aisb-color-picker aisb-bg-color"
                                               data-default-color="<?php echo esc_attr($config['color']); ?>">
                                    </div>
                                    
                                    <div class="aisb-config-field">
                                        <label>Text Color</label>
                                        <input type="text" 
                                               name="aisb_configs[<?php echo esc_attr($ai_type); ?>][text_color]" 
                                               value="<?php echo esc_attr($config['text_color']); ?>"
                                               class="aisb-color-picker aisb-text-color"
                                               data-default-color="<?php echo esc_attr($config['text_color']); ?>">
                                    </div>
                                    
                                    <div class="aisb-config-field">
                                        <label>Logo Position</label>
                                        <select name="aisb_configs[<?php echo esc_attr($ai_type); ?>][logo_position]" 
                                                class="aisb-select aisb-logo-position">
                                            <option value="left" <?php selected(isset($config['logo_position']) ? $config['logo_position'] : 'left', 'left'); ?>>Left</option>
                                            <option value="right" <?php selected(isset($config['logo_position']) ? $config['logo_position'] : 'left', 'right'); ?>>Right</option>
                                            <option value="top" <?php selected(isset($config['logo_position']) ? $config['logo_position'] : 'left', 'top'); ?>>Top</option>
                                            <option value="bottom" <?php selected(isset($config['logo_position']) ? $config['logo_position'] : 'left', 'bottom'); ?>>Bottom</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="aisb-config-row">
                                    <div class="aisb-config-field aisb-config-field-full">
                                        <label>Custom Logo SVG (Optional - Leave empty for official logo)</label>
                                        <textarea name="aisb_configs[<?php echo esc_attr($ai_type); ?>][logo_svg]" 
                                                  class="aisb-textarea aisb-logo-svg"
                                                  rows="3"
                                                  placeholder="Paste SVG code here..."><?php echo esc_textarea($config['logo_svg']); ?></textarea>
                                        <p class="description">Paste custom SVG code or leave empty to use the official <?php echo esc_html($config['name']); ?> logo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="aisb-form-actions">
                    <button type="submit" name="aisb_save_configs" class="button button-primary button-large">
                        <span class="dashicons dashicons-yes"></span> Save Changes
                    </button>
                    
                    <button type="button" class="button button-secondary button-large aisb-preview-btn">
                        <span class="dashicons dashicons-visibility"></span> Update Preview
                    </button>
                </div>
            </form>
            
            <!-- Reset Form -->
            <form method="post" action="" class="aisb-reset-form">
                <?php wp_nonce_field('aisb_reset_configs_nonce'); ?>
                <button type="submit" 
                        name="aisb_reset_configs" 
                        class="button button-link-delete"
                        onclick="return confirm('Are you sure you want to reset all settings to default? This cannot be undone.');">
                    <span class="dashicons dashicons-image-rotate"></span> Reset to Defaults
                </button>
            </form>
            
            <!-- Shortcode Info -->
            <div class="aisb-shortcode-info">
                <h3><span class="dashicons dashicons-editor-code"></span> How to Use</h3>
                <div class="aisb-shortcode-examples">
                    <div class="aisb-shortcode-example">
                        <h4>Basic Usage</h4>
                        <code>[ai_summary_buttons]</code>
                        <p>Displays all enabled AI buttons</p>
                    </div>
                    
                    <div class="aisb-shortcode-example">
                        <h4>With Custom Label</h4>
                        <code>[ai_summary_buttons label="Try AI summaries:"]</code>
                        <p>Adds a custom label above the buttons</p>
                    </div>
                    
                    <div class="aisb-shortcode-example">
                        <h4>Specific Buttons Only</h4>
                        <code>[ai_summary_buttons buttons="chatgpt,claude,gemini"]</code>
                        <p>Shows only the specified AI buttons</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}

/**
 * Save button configurations
 */
function aisb_save_button_configs() {
    if (!isset($_POST['aisb_configs']) || !is_array($_POST['aisb_configs'])) {
        return;
    }
    
    $saved_configs = [];
    $default_configs = aisb_get_default_configs();
    
    foreach ($_POST['aisb_configs'] as $ai_type => $config) {
        if (!isset($default_configs[$ai_type])) {
            continue;
        }
        
        $saved_configs[$ai_type] = [
            'enabled' => isset($config['enabled']) && $config['enabled'] == '1',
            'label' => sanitize_text_field($config['label'] ?? $default_configs[$ai_type]['label']),
            'color' => sanitize_hex_color($config['color'] ?? $default_configs[$ai_type]['color']),
            'text_color' => sanitize_hex_color($config['text_color'] ?? $default_configs[$ai_type]['text_color']),
            'logo_position' => in_array($config['logo_position'] ?? 'left', ['left', 'right', 'top', 'bottom']) ? $config['logo_position'] : 'left',
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
    
    echo '<div class="notice notice-success is-dismissible"><p>Settings saved successfully!</p></div>';
}
