(function ($, undefined) {
  "use strict";

  var controlKeys = [8, 9, 13, 35, 36, 37, 39];

  $('form').on('keypress', 'input[type=number], .numeric', function (event) {
    var isControlKey = controlKeys.join(",").match(new RegExp(event.which));

    if (
      !event.which ||
      (48 <=  event.which && event.which <= 57) ||
      isControlKey
    ) {
      return;
    } else {
      event.preventDefault();
    }
  }).on('change', 'input[type=number], .numeric', function (event) {
    if ($.trim(this.value) === '') {
      this.value = 0;
    }
  });
})(jQuery);