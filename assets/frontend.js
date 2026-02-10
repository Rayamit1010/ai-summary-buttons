/**
 * AI Summary Buttons - Frontend Script
 * Namespaced to prevent conflicts
 */
(function() {
  'use strict';
  
  // Ensure AISB_DATA is available
  if (typeof AISB_DATA === 'undefined') {
    console.warn('AISB_DATA not found');
    return;
  }
  
  /**
   * Get the prompt text with URL replaced
   */
  function getPromptText() {
    var url = window.location.href;
    var prompt = AISB_DATA.prompt || 'Please summarize this page: {{url}}';
    return prompt.replace('{{url}}', url);
  }
  
  /**
   * Open AI service with the prompt
   */
  function openAIService(aiType) {
    if (!AISB_DATA.configs || !AISB_DATA.configs[aiType]) {
      console.warn('AI type not configured:', aiType);
      return;
    }
    
    var config = AISB_DATA.configs[aiType];
    var promptText = getPromptText();
    var encodedPrompt = encodeURIComponent(promptText);
    
    // Use url_template if available, fallback to url for backward compatibility
    var baseUrl = config.url_template || config.url;
    var url = baseUrl + encodedPrompt;
    
    console.log('Opening AI service:', aiType, 'URL:', url);
    
    // Open in new tab
    window.open(url, '_blank', 'noopener,noreferrer');
  }
  
  /**
   * Handle button click
   */
  function handleButtonClick(event) {
    var button = event.target.closest('[data-aisb-type]');
    if (!button) return;
    
    event.preventDefault();
    event.stopPropagation();
    
    var aiType = button.getAttribute('data-aisb-type');
    openAIService(aiType);
  }
  
  /**
   * Handle hover effects
   */
  function handleHover(event) {
    var button = event.target.closest('.aisb-btn');
    if (!button) return;
    
    var hoverColor = button.getAttribute('data-aisb-hover');
    var originalColor = button.style.background;
    
    if (event.type === 'mouseenter' && hoverColor) {
      button.setAttribute('data-aisb-original-bg', originalColor);
      button.style.background = hoverColor;
    } else if (event.type === 'mouseleave') {
      var originalBg = button.getAttribute('data-aisb-original-bg');
      if (originalBg) {
        button.style.background = originalBg;
      }
    }
  }
  
  /**
   * Initialize the plugin
   */
  function init() {
    // Use event delegation for better performance
    document.addEventListener('click', handleButtonClick);
    
    // Optional: Add hover effects via JS (in addition to CSS)
    var buttons = document.querySelectorAll('.aisb-btn');
    buttons.forEach(function(button) {
      button.addEventListener('mouseenter', handleHover);
      button.addEventListener('mouseleave', handleHover);
    });
  }
  
  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
  
})();
