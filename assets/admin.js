/**
 * AI Summary Buttons - Admin Script
 */
(function($) {
  'use strict';
  
  $(document).ready(function() {
    
    // Initialize color pickers
    if ($.fn.wpColorPicker) {
      $('.aisb-color-picker').wpColorPicker({
        change: function(event, ui) {
          updatePreview();
        }
      });
    }
    
    /**
     * Update live preview
     */
    function updatePreview() {
      var $previewButtons = $('#preview-buttons');
      $previewButtons.empty();
      
      $('.aisb-button-config-item').each(function() {
        var $item = $(this);
        var aiType = $item.data('ai-type');
        var enabled = $item.find('.aisb-toggle-input').is(':checked');
        
        if (!enabled) return;
        
        var label = $item.find('.aisb-label-input').val() || 'AI Button';
        var bgColor = $item.find('.aisb-bg-color').val() || '#000000';
        var textColor = $item.find('.aisb-text-color').val() || '#FFFFFF';
        var logoSvg = $item.find('.aisb-logo-svg').val() || '';
        var logoPosition = $item.find('.aisb-logo-position').val() || 'left';
        
        // Create button element
        var $button = $('<button>', {
          'type': 'button',
          'class': 'aisb-btn aisb-btn-' + aiType + ' aisb-logo-' + logoPosition,
          'data-aisb-type': aiType,
          'css': {
            'background': bgColor,
            'color': textColor
          }
        });
        
        // Add icon
        var $icon = $('<span>', {
          'class': 'aisb-btn-icon',
          'html': logoSvg
        });
        
        // Add text
        var $text = $('<span>', {
          'class': 'aisb-btn-text',
          'text': label
        });
        
        $button.append($icon).append($text);
        $previewButtons.append($button);
      });
    }
    
    /**
     * Handle preview button click
     */
    $('.aisb-preview-btn').on('click', function(e) {
      e.preventDefault();
      updatePreview();
      
      // Show success message
      var $button = $(this);
      var originalText = $button.html();
      $button.html('<span class="dashicons dashicons-yes"></span> Preview Updated!');
      
      setTimeout(function() {
        $button.html(originalText);
      }, 2000);
    });
    
    /**
     * Update preview on field changes
     */
    $('.aisb-label-input, .aisb-toggle-input, .aisb-logo-position').on('change', function() {
      updatePreview();
    });
    
    $('.aisb-logo-svg').on('input', function() {
      // Debounce the preview update
      clearTimeout($(this).data('timeout'));
      var timeout = setTimeout(function() {
        updatePreview();
      }, 1000);
      $(this).data('timeout', timeout);
    });
    
    /**
     * Toggle config body visibility
     */
    $('.aisb-toggle-input').on('change', function() {
      var $configBody = $(this).closest('.aisb-button-config-item').find('.aisb-config-body');
      if ($(this).is(':checked')) {
        $configBody.slideDown(300);
      } else {
        $configBody.slideUp(300);
      }
    });
    
    // Initialize collapsed state for disabled items
    $('.aisb-button-config-item').each(function() {
      var $item = $(this);
      var enabled = $item.find('.aisb-toggle-input').is(':checked');
      if (!enabled) {
        $item.find('.aisb-config-body').hide();
      }
    });
    
    /**
     * Form validation
     */
    $('.aisb-settings-form').on('submit', function(e) {
      var hasError = false;
      
      $('.aisb-color-picker').each(function() {
        var value = $(this).val();
        if (value && !isValidHexColor(value)) {
          hasError = true;
          $(this).css('border-color', '#d63638');
          alert('Please enter a valid hex color code (e.g., #000000)');
          e.preventDefault();
          return false;
        } else {
          $(this).css('border-color', '');
        }
      });
      
      if (!hasError) {
        // Show saving indicator
        var $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true);
        $submitBtn.html('<span class="dashicons dashicons-update spin"></span> Saving...');
      }
    });
    
    /**
     * Validate hex color
     */
    function isValidHexColor(hex) {
      return /^#([0-9A-F]{3}){1,2}$/i.test(hex);
    }
    
    /**
     * Add animation to dashicons
     */
    $('<style>')
      .prop('type', 'text/css')
      .html('@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } } .spin { animation: spin 1s linear infinite; }')
      .appendTo('head');
  });
  
})(jQuery);
