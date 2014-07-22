/* global io */
(function (w, $, undefined) {
  'use strict';

  if ('undefined' === typeof io) {
    console.warn('El servidor de notificaciones no está disponible.');
    return;
  }

  var socket = io.connect(w.ioServer)
    , $ntfy = $('#ntfy-menu');

  socket.on('welcome', function (data) {
    // console.log(data);
    /*socket.emit('suscribe', {
      name: $('[data-user-name]').first().data('user-name')
    });*/
  });

  socket.on('receiver-ntfy', function (data) {
    // $ntfy.ntfy('add', 'notificacion', data);

    // if (data.data) {
    //   $(document).trigger('receiver-ntfy.ntfy',data);
    // }
  });

  $ntfy.on('click', 'a[data-ntfy-load]', function (event) {
    var $this = $(this)
      , offset = $this.data('ntfy-offset') || 0;

    $ntfy.ntfy('get', {offset: offset}, function (response) {
      var items = response.results.items;

      $.each(items, function (i, item) {
        $ntfy.ntfy('add', 'notificacion', item);
      });

      $this.data('ntfy-offset', offset + items.length);
    });

    return false;
  });
})(window, jQuery);