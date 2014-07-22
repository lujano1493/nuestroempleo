(function ($, w) {
  'use strict';

  $('table').on('opened-row.dynamic', function (event, el, data) {
    var $el = $(el);

    if ($el.data('on-open-row') === 'mark-msg-as-read') {
      $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {},
        url:  ( ($el.data('controller-url')) || '/mis_mensajes/') + data.id + '/leido'
      }).done(function (response) {
        $el.closest('tr').find('.unread').removeClass('unread');
      });
    }
  });

  $(document).on('success.ajaxform', '#form-send-msg', function () {
    // $.fn.magicload && $('#main-content').magicload('close');
  });
})(jQuery, window);