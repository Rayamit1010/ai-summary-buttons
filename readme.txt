=== AI Summary Buttons ===
Contributors: rayamit1010
Tags: ai, summary, buttons, shortcode, elementor
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 2.5.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add beautiful AI-powered summary buttons to WordPress posts and pages. Connect users with ChatGPT, Claude, Gemini, Perplexity, and Grok in one click.

== Description ==

AI Summary Buttons helps visitors summarize your content using their preferred AI assistant.

Features:

* Five AI services: ChatGPT, Claude, Gemini, Perplexity, and Grok.
* Easy insertion with shortcode, auto-insert, and Elementor widget.
* Customize labels, colors, logo position, and enabled services.
* Lightweight frontend with selective asset loading.
* Privacy-first defaults with optional anonymous telemetry disabled by default.

= Shortcode examples =

* `[ai_summary_buttons]`
* `[ai_summary_buttons label="Summarize with AI:"]`
* `[ai_summary_buttons buttons="chatgpt,claude,gemini"]`

== Installation ==

1. Upload plugin files to the `/wp-content/plugins/ai-summary-buttons` directory, or install through WordPress plugin screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Open **AI Buttons** in wp-admin and configure your button styles and settings.

== Frequently Asked Questions ==

= Does this plugin require AI API keys? =

No. It opens supported AI services with a pre-filled prompt and current page URL.

= Is data collected? =

Anonymous telemetry is optional and disabled by default. Site owners can opt in from plugin settings.

= Can I disable specific AI services? =

Yes. You can enable/disable each provider from the customization page.

== Changelog ==

= 2.5.2 =
* Added centralized config sanitization and stricter validation.
* Added explicit opt-in setting for anonymous telemetry.
* Fixed tracking version constant usage.
* Limited frontend event listeners to plugin wrapper scope.
* Improved auto-insert behavior for posts and pages.
* Added WordPress.org compatible `readme.txt`.
* Added conditional external updater toggle for non-WordPress.org distributions.

== Upgrade Notice ==

= 2.5.2 =
Security, privacy, and compatibility improvements for distribution on WordPress.org and premium marketplaces.
