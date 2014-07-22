
(function ($, undefined) {
  'use strict';

  var searchFn = function (dom) {
    var $dom = $(dom)
      , searcher = $('[data-param-search-ini]').data('param-search-ini');

    if (searcher) {
      $dom.find('.searchable').highlight(searcher);
    }
  };

  $(document).on('ready', function () {

    $.component('tooltip');
  }).on('success.ajaxform', '#anotaciones form', function (e, data) {
    this.reset();
    var $form = $(this)
      , $container = $form.parent()
      , $anotaciones = $container.find('#lista-anotaciones');

    if ($anotaciones.size() === 0) {
      $container.find('.empty').remove();
      $anotaciones = $('<ul></ul>', {
        'class' : 'list-unstyled',
        'id' : 'lista-anotaciones'
      }).appendTo($container);
    }

    $anotaciones.prepend($.template('#tmpl-notas', data.results));
  }).on('success.ajaxlink', '#lista-anotaciones .nota', function () {
    $(this).remove();
  }).on('dynamic.draw', 'table[data-component=dynamic-table]', function () {
    searchFn(this);
  }).on('loaded.magicload', '#main-content', function () {
    searchFn(this);
  });

  $(document).on('success.ajaxlink', 'a.update-cart', function () {
    var $carrito = $('#carrito-list');

    $carrito.popover({
      title: 'Nuevo Producto',
      content: 'Se agrego un nuevo producto al carrito',
      placement: 'bottom'
    }).popover('show');

    setTimeout(function () {
      $carrito.popover('destroy');
    }, 3000);
  });
})(jQuery);