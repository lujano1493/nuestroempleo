(function ($, undefined) {
  "use strict";

  $.fn.sequence = function (opts) {
    return this.each(function (index, el) {
      $(this).text(index + 1);
    });
  };

})(jQuery);