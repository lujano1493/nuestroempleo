/* global io, bootbox */
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

  socket.on('credits-updated', function (data) {
    var $creditsBar = $('#credits-bar')
      , $creditsItems = $creditsBar.find('span[data-credit]')
      , updateCredits = function (credits) {
        $creditsItems.each(function () {
          var $this = $(this)
            , creditType = $this.data('credit')
            , creditValue = (credits[creditType] && credits[creditType].disponibles) || '-';

          $this.html(creditValue);
        });
      };

    bootbox.alert('¡Tus créditos han sido actualizados!', function() {
      updateCredits(data.credits);
    });
  });

  socket.on('session-updated', function () {
    bootbox.dialog({
      message: 'Se han activado tus servicios, por favor refresca la página.',
      title: 'Servicios activados',
      buttons: {
        main: {
          label: 'Refrescar',
          className: 'btn-primary',
          callback: function() {
            document.location.reload();
          }
        }
      }
    });
  });

  socket.on('receiver-ntfy', function (data) {
    $ntfy.ntfy('add', 'notificacion', data);

    // if (data.data) {
    //   $(document).trigger('receiver-ntfy.ntfy',data);
    // }
  });

  $ntfy.on('click', 'a[data-ntfy-load]', function (event) {
    var $this = $(this)
      , offset = $this.data('ntfy-offset') || 0;

    console.log(offset);
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