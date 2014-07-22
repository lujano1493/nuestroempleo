(function ($, undefined) {
  'use strict';

  $('input#change-pass-input').on('change', function () {
    var $this = $(this);

    $('#change-pass')[$this.is(':checked') ? 'show' : 'hide']('fast');
  });

  $('#UsuarioEmpresaPerCve').on('change', function () {
    var val = $(this).val()
      , hide = val === 'coordinador';

    $('#UsuarioEmpresaCuCvesup').closest('.input')[hide ? 'hide' : 'show']('fast');
  }).change();

})(jQuery);