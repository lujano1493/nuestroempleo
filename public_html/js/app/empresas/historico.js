(function ($, undefined) {
  'use strict';

  var process = function (items) {
    var $items = $('#historico-details')
      , facturas = items.facturas
      , data = {};

    for (var i = 0; i < facturas.length; i++) {
      data = {
        empresa: items.empresa,
        factura : facturas[i]
      };

      $items
        .append($.template('#tmpl-panel-detalles', data))
        .find('.slide:eq(' + i + ')').data('data', data);
    }

    $items.on('autoslide.navidone', function () {
      $items.siblings('.main-pagination').addClass('sliding').autoSlide({
        'naviClass' : 'pagination clearfix',
        'selector': 'div',
        'itemsPerPage': 3
      });

      // var $nWrapper = $('<div class="new" style="overflow: hidden;"></div>')
      //   , $pag = $items.siblings('.main-pagination')
      //   , nWrapperWidth = 0;

      // $pag.width('9999px').wrap($nWrapper);

      // nWrapperWidth = $nWrapper.outerWidth();

      // $pag.find('a').on('click', function () {
      //   var $li = $(this).parent('li')
      //     , index = $li.index()
      //     , marginLeft = ($(this).outerWidth() * index);

      //   if (marginLeft > ($('.new').outerWidth() / 2)) {

      //   }

      //   $pag.stop().animate({
      //     marginLeft: -1 * marginLeft + 'px'
      //   }, 100);
      // });

    }).autoSlide({
      naviType: 'div'
    });
  };

  $(document).on('ready', function () {
    $.ajax({
      url: '/mis_productos/historico.json'
    }).done(function (data) {
      process(data.results);
    });
  });

})(jQuery);