<?php
/**
 * Plugin Auto-Updater
 * Checks GitHub for updates and auto-replaces existing version
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class AISB_Auto_Updater {
    
    private $plugin_slug = 'ai-summary-buttons-pro/ai-summary-buttons.php';
    private $github_user = 'Rayamit1010';
    private $github_repo = 'ai-summary-buttons-pro';
    private $current_version;
    
    public function __construct() {
        $this->current_version = AISB_VERSION;
        
        // Check for updates
        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
        add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
        
        // After plugin update
        add_filter('upgrader_post_install', [$this, 'after_install'], 10, 3);
        
        // Add update notice in admin
        add_action('admin_notices', [$this, 'update_notice']);
    }
    
    /**
     * Check for plugin updates from GitHub
     */
    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }
        
        // Get latest release from GitHub
        $remote_info = $this->get_github_release_info();
        
        if (!$remote_info) {
            return $transient;
        }
        
        // Compare versions
        if (version_compare($this->current_version, $remote_info->version, '<')) {
            $plugin_data = [
                'slug' => dirname($this->plugin_slug),
                'plugin' => $this->plugin_slug,
                'new_version' => $remote_info->version,
                'url' => $remote_info->url,
                'package' => $remote_info->download_url,
                'tested' => '6.4',
                'icons' => [
                    'default' => 'https://raw.githubusercontent.com/' . $this->github_user . '/' . $this->github_repo . '/main/assets/icon.png'
                ]
            ];
            
            $transient->response[$this->plugin_slug] = (object) $plugin_data;
        }
        
        return $transient;
    }
    
    /**
     * Get plugin information for update screen
     */
    public function plugin_info($false, $action, $args) {
        if ($action !== 'plugin_information') {
            return $false;
        }
        
        if (!isset($args->slug) || $args->slug !== dirname($this->plugin_slug)) {
            return $false;
        }
        
        $remote_info = $this->get_github_release_info();
        
        if (!$remote_info) {
            return $false;
        }
        
        $plugin_info = [
            'name' => 'AI Summary Buttons Pro',
            'slug' => dirname($this->plugin_slug),
            'version' => $remote_info->version,
            'author' => '<a href="https://github.com/' . $this->github_user . '">Amit Ray</a>',
            'homepage' => 'https://github.com/' . $this->github_user . '/' . $this->github_repo,
            'download_link' => $remote_info->download_url,
            'sections' => [
                'description' => $remote_info->description ?? 'Professional AI-powered summary buttons with full customization.',
                'changelog' => $remote_info->changelog ?? ''
            ],
            'tested' => '6.4',
            'requires' => '5.0',
            'requires_php' => '7.0',
        ];
        
        return (object) $plugin_info;
    }
    
    /**
     * Get latest release info from GitHub
     */
    private function get_github_release_info() {
        // Check cache first
        $cache_key = 'aisb_github_release_info';
        $cached = get_transient($cache_key);
        
        if ($cached !== false) {
            return $cached;
        }
        
        // GitHub API URL
        $api_url = "https://api.github.com/repos/{$this->github_user}/{$this->github_repo}/releases/latest";
        
        $response = wp_remote_get($api_url, [
            'timeout' => 15,
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'WordPress/' . get_bloginfo('version')
            ]
        ]);
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        
        if (empty($data->tag_name)) {
            return false;
        }
        
        // Find the .zip asset
        $download_url = '';
        if (!empty($data->assets)) {
            foreach ($data->assets as $asset) {
                if (strpos($asset->name, '.zip') !== false) {
                    $download_url = $asset->browser_download_url;
                    break;
                }
            }
        }
        
        // Fallback to zipball_url if no zip asset found
        if (empty($download_url)) {
            $download_url = $data->zipball_url;
        }
        
        $release_info = (object) [
            'version' => ltrim($data->tag_name, 'v'),
            'url' => $data->html_url,
            'download_url' => $download_url,
            'description' => $data->body ?? '',
            'changelog' => $this->parse_changelog($data->body ?? '')
        ];
        
        // Cache for 12 hours
        set_transient($cache_key, $release_info, 12 * HOUR_IN_SECONDS);
        
        return $release_info;
    }
    
    /**
     * Parse changelog from release body
     */
    private function parse_changelog($body) {
        if (empty($body)) {
            return '';
        }
        
        // Convert markdown to HTML for better display
        $changelog = '<div style="padding: 15px;">';
        $changelog .= nl2br(esc_html($body));
        $changelog .= '</div>';
        
        return $changelog;
    }
    
    /**
     * After plugin installation
     */
    public function after_install($response, $hook_extra, $result) {
        global $wp_filesystem;
        
        // Check if this is our plugin
        if (!isset($hook_extra['plugin']) || $hook_extra['plugin'] !== $this->plugin_slug) {
            return $response;
        }
        
        // Ensure the plugin is in the correct directory
        $proper_destination = WP_PLUGIN_DIR . '/' . dirname($this->plugin_slug);
        $wp_filesystem->move($result['destination'], $proper_destination, true);
        $result['destination'] = $proper_destination;
        
        // Clear update cache
        delete_transient('aisb_github_release_info');
        
        // Activate the plugin if it was active before
        if (is_plugin_active($this->plugin_slug)) {
            activate_plugin($this->plugin_slug);
        }
        
        return $response;
    }
    
    /**
     * Show update notice in admin
     */
    public function update_notice() {
        $screen = get_current_screen();
        
        // Only show on plugins page
        if ($screen->id !== 'plugins') {
            return;
        }
        
        // Check if update is available
        $remote_info = $this->get_github_release_info();
        
        if (!$remote_info) {
            return;
        }
        
        if (version_compare($this->current_version, $remote_info->version, '<')) {
            ?>
            <div class="notice notice-info is-dismissible" style="border-left: 4px solid #2271b1; padding: 15px;">
                <h3 style="margin-top: 0;">🚀 AI Summary Buttons Pro Update Available!</h3>
                <p>
                    <strong>Version <?php echo esc_html($remote_info->version); ?></strong> is available. 
                    You are currently running <strong>version <?php echo esc_html($this->current_version); ?></strong>.
                </p>
                <p>
                    <a href="<?php echo admin_url('plugins.php?plugin_status=upgrade'); ?>" class="button button-primary">
                        Update Now
                    </a>
                    <a href="<?php echo esc_url($remote_info->url); ?>" target="_blank" class="button button-secondary">
                        View Release Notes
                    </a>
                </p>
            </div>
            <?php
        }
    }
}

// Initialize the updater
new AISB_Auto_Updater();

