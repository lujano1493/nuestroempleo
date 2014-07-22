(function ($, undefined) {
  'use strict';

  $('[data-open-div]').on('click', function (event) {
    var $this = $(this)
      , data = $this.data()
      , $div = $('#' + data.openDiv);
    if ($div.is(':visible')) {
      $div.hide('fast').closest('.row').hide('fast');
    } else {
      $div.closest('.row').show('fast', function () {
        $div
          .siblings('.form-hide')
          .hide('fast').end().show('fast');
      });
    }

    if ($this.is('a')) {
      return false;
    }

  });
})(jQuery);