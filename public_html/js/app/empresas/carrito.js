(function ($, undefined) {
  'use strict';

  var $carritoFacturcionForm = $('#FacturacionEmpresaCarritoForm')
    , $carritoForm = $('#carritoForm')
    , $submitCarrito = $('#submitCarrito');

  $(document).on('ready', function () {
    var $carritoSubtotal = $('#carrito-subtotal')
      , $carritoIVA = $('#carrito-iva')
      , $carritoTotal = $('#carrito-total')
      , $carritoCants = $('[data-cost]')
      , checkTotal = function () {
        var $total = $('label[data-subtotal]')
          , t = 0;

        $total.each(function () {
          var $this = $(this);

          !$this.hasClass('disabled') && (t += $(this).data('subtotal'));
        });

        if (t <= 0) {
          $submitCarrito.prop('disabled', true).addClass('disabled');
        } else {
          $submitCarrito.prop('disabled', false).removeClass('disabled');
        }

        $carritoSubtotal.text($.u.currency(t));
        $carritoIVA.text($.u.currency(t * 0.16));
        $carritoTotal.text($.u.currency(t * 1.16));
      };

    $carritoCants.on('change', function () {
      var $this = $(this)
        , $label = $('label[for=' + $this.attr('id') +']')
        , cant = $this.val()
        , costo = $this.data('cost')
        , t = costo * cant;

      $label.data('subtotal', t).text($.u.currency(t));
      checkTotal();
    });

    $('.rm-item').on('click', function () {
      var $tr = $(this).siblings('label').addClass('disabled').closest('tr')
        , $input = $tr.find('input');

      $tr.addClass('disabled');
      $input.prop('disabled', true);

      checkTotal();
      return false;
    });

    $('.ok-item').on('click', function () {
      var $tr = $(this).siblings('label').removeClass('disabled').closest('tr')
        , $input = $tr.find('input');

      $tr.removeClass('disabled');
      $input.prop('disabled', false);

      checkTotal();
      return false;
    });
  });

  $submitCarrito.on('click', function (event) {
    var $this = $(this);

    $this.prop('disabled', true).addClass('disabled');
    $this.append('<i class="icon-spinner icon-spin"></i>');

    $carritoFacturcionForm
      .ajaxform('submit', [event, { noredirect: true }])
      .on('success.ajaxform', function () {
        $carritoForm.submit();
      });

    return false;
  });

})(jQuery);