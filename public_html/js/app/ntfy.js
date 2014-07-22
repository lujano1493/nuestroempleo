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

  });

  socket.on('receiver-ntfy', function(data) {
    $ntfy.ntfy('add', data);
  });

  $ntfy.on('click', 'a[data-ntfy-load]', function (event) {
    var $this = $(this)
      , offset = $this.data('ntfy-offset') || 0
      , type = $this.data('ntfy-load');

    console.log(offset);
    console.log(type);
    $ntfy.ntfy('get', {offset: offset, type: type}, function (response) {
      var items = response.results.items;

      $.each(items, function (i, item) {
        $ntfy.ntfy('add', type, item);
      });

      $this.data('ntfy-offset', offset + items.length);
    });

    return false;
  });
})(window, jQuery);
