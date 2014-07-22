(function ($) {
  "use strict";

  $(document).on('ready', function () {
    var $contenido_der = $(".contenido_der").hide()
      , $tab_der = $('#tab_der')
      , $tab_der_interna = $('#tab_der_interna')
      , $panel_der = $('#panel_der')
      , $abre_tab_der = $('a#abre_tab_der');

    $( '#jms-slideshow' ).jmslideshow({
      autoplay : true,
      bgColorSpeed: '0.8s',
      arrows   : true
    });

    $contenido_der = $(".contenido_der").hide();

    $(".jms-link").click(function () {
      $("#panel_der").stop().animate({
        width: '450px',
        opacity: 0.9
      }, 'slow');

      $contenido_der.fadeIn('slow');

      $("#tab_der").stop().animate({
        left: '450px'
      }, 'slow');
    });

    $abre_tab_der.on('click', function (e) { e.preventDefault(); });
    $tab_der.on('click', function () {
      if (!$tab_der_interna.hasClass('expandida_der')) {
        $tab_der.stop().animate({
          left: '450px'
        }, 500, function () {
          $tab_der_interna.addClass('expandida_der');
        });

        $panel_der.stop().animate({
          width: '450px',
          opacity: 0.9
        }, 500, function () {
          $contenido_der.fadeIn('slow');
        });
      } else {
        $contenido_der.fadeOut('slow', function() {
          $tab_der.stop().animate({
            left: 0
          }, 500, function () {
            $tab_der_interna.removeClass('expandida_der');
          });

          $panel_der.stop().animate({
            width: 0,
            opacity: 0.1
          }, 500);
       });

      }
    });
  });

})(jQuery);