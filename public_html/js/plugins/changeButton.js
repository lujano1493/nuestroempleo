(function ($, undefined) {
  
  "use strict";

  $.fn.changeButton = function (opts) {
    return this.on('change', function (e) {
      var $el = $(this)
        , $button = $el.closest('form').find('[type=submit]')
        , $selectedOption = $el.find("option:selected")
        , buttonText = $selectedOption.data('button-text')
        , buttonClass = $selectedOption.data('button-class');
      
      $button.removeClass($el.data('previous-class')).val(buttonText);
      if (buttonClass) {
        $button.addClass(buttonClass);
      }
      $el.data('previous-class', buttonClass);

    });
  };

  $.component('change-button');
})(jQuery);