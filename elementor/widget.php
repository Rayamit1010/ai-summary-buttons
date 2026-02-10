<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Elementor Widget for AI Summary Buttons
 */
add_action('elementor/widgets/register', function ($widgets_manager) {
    
    class AI_Summary_Elementor_Widget extends \Elementor\Widget_Base {
        
        public function get_name() {
            return 'ai_summary_buttons';
        }
        
        public function get_title() {
            return __('AI Summary Buttons', 'ai-summary-buttons');
        }
        
        public function get_icon() {
            return 'eicon-button';
        }
        
        public function get_categories() {
            return ['general'];
        }
        
        protected function register_controls() {
            
            $this->start_controls_section(
                'content_section',
                [
                    'label' => __('Content', 'ai-summary-buttons'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
            
            $this->add_control(
                'label',
                [
                    'label' => __('Label Text', 'ai-summary-buttons'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('Summarize this page with:', 'ai-summary-buttons'),
                ]
            );
            
            $this->add_control(
                'buttons',
                [
                    'label' => __('AI Assistants', 'ai-summary-buttons'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => [
                        'chatgpt' => 'ChatGPT',
                        'claude' => 'Claude',
                        'gemini' => 'Gemini',
                        'perplexity' => 'Perplexity',
                        'grok' => 'Grok',
                    ],
                    'default' => ['chatgpt', 'claude', 'gemini', 'perplexity', 'grok'],
                ]
            );
            
            $this->end_controls_section();
        }
        
        protected function render() {
            $settings = $this->get_settings_for_display();
            $buttons = implode(',', $settings['buttons']);
            
            echo do_shortcode('[ai_summary_buttons label="' . esc_attr($settings['label']) . '" buttons="' . esc_attr($buttons) . '"]');
        }
    }
    
    $widgets_manager->register(new AI_Summary_Elementor_Widget());
});
