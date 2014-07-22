(function ($, undefined) {
  'use strict';

  var $creditsForm = $('#CreditosForm')
    , $creditsHandler = $('#credits-handler')
    , $credHandlers = $('[data-credit-handler]');

  $credHandlers.each(function () {
    var $handler = $(this)
      , data = $handler.data()
      , creditId = data.creditHandler
      , _infinity = data.credits === 'infinity'
      , maxCredits =  _infinity ? -1 : data.credits;

    $creditsHandler.on('change', 'input[data-credit-assign=' + creditId + ']', function (event) {
      var $input = $(this)
        , itemId = $input.data('item-id')
        , $label = $creditsHandler.find('label[data-item-id=' + itemId + ']')
        , $recoverInput = $creditsHandler.find('input[data-credit-recover][data-item-id=' + itemId + ']')
        , $handlers = $('input[data-credit-assign=' + creditId + ']').not(this)
        , labelCredits = +($label.data('credits'))
        , credits = +($handler.data('available-credits') || maxCredits)
        , value = +this.value
        , total = 0;

      if (value > 1000) {
        value = this.value = 1000;
      }

      if (_infinity) {
        $label.text(value + labelCredits);
      } else {
        $handlers.each(function () {
          total += +(this.value || 0);
        });

        if ((total + value) > credits) {
          value = credits - total;
          $input.val(value);
        }

        $handler.text(credits - (total + value)).data('credits', credits - (total + value));
        $label.text(value + labelCredits).data('available-credits', value + labelCredits);
      }
      $recoverInput.prop('disabled', +value > 0);
    });

    $creditsHandler.on('change',  'input[data-credit-recover=' + creditId + ']', function (event) {
      var $input = $(this)
        , itemId = $input.data('item-id')
        , $label = $creditsHandler.find('label[data-item-id=' + itemId + ']')
        , $assignInput = $creditsHandler.find('input[data-credit-assign][data-item-id=' + itemId + ']')
        , $handlers = $('input[data-credit-recover=' + creditId + ']').not(this)
        , labelCredits = +($label.data('available-credits') || $label.data('credits'))
        , credits = +($handler.data('credits'))
        , value = +this.value
        , total = 0;

      if (labelCredits <= 0) {
        this.value = 0;
        return false;
      }

      if (_infinity) {
        $label.text(labelCredits - value);
      } else {
        $handlers.each(function () {
          total += (+this.value || 0);
        });

        if (value > labelCredits) {
          value = labelCredits;
          $input.val(value);
        }

        $label.text(labelCredits - value); //.data('credits', labelCredits - value);
        $handler.text(credits + total + value)
          .data('available-credits', credits + total + value);
      }

      $assignInput.prop('disabled', +value > 0);
    });
  });

  $creditsForm.on('success.ajaxform', function (event, data) {
    $creditsForm[0].reset();

    if (data.html) {
      $('#credits-bar').replaceWith(data.html);
    }
  });

})(jQuery);