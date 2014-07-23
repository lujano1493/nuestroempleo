
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
    var $form = $(this)
      , $container = $form.closest('#anotaciones')
      , $anotaciones = $container.find('#lista-anotaciones');
    this.reset();
    if (data.results.isCreated) {
      if ($anotaciones.size() === 0) {
        $container.find('.empty').remove();
        $anotaciones = $('<ul></ul>', {
          'class' : 'list-unstyled',
          'id' : 'lista-anotaciones'
        }).appendTo($container);
      }

      $anotaciones.prepend($.template('#tmpl-notas', data.results));
    } else {
      $form.closest('.nota').replaceWith($.template('#tmpl-notas', data.results));
    }
  }).on('click', '#lista-anotaciones .edit', function (event) {
    var $container = $(this).closest('.nota')
      , data = $container.find('.data').data()
      , $content = $container.find('.content')
      , $html = $.parseHTML($.template('#tmpl-edit-notas', data))
      , close = function () {
        $container.find('.edit-nota').fadeOut('fast', function () {
          $(this).remove();
          $content.fadeIn('fast');
          $container.removeClass('editing');
        });

        return false;
      };

    if ($container.hasClass('editing')) {
      close();
    } else {
      $content.fadeOut('fast', function () {
        $(this).after($html).next('.edit-nota').fadeIn('fast').on('click', '.cancel-edit', close);
      });
      $container.addClass('editing');
    }

    return false;
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