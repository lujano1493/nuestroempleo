(function ($, undefined) {
  "use strict";

  $(document).on('ready', function () {
    var $default = $('[data-default-for]')
      , _defaultKey = $default.data('default-for')
      , _defaults = $default.size() > 0 ? $.parseJSON($default.val() || '[]') : [];
    $('[name="' + _defaultKey + '"]').each(function() {
      var $this = $(this)
        , val = $this.val();
      if ($.inArray(val, _defaults) >= 0) {
        $this.prop('checked', true);  
      }
    });

  });
})(jQuery);