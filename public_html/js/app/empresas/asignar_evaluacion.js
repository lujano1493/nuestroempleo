(function ($, undefined) {
  'use strict';

  var evaluacion = function () {
    var $radios = $('[data-table-role=main]').find('tbody tr td input[type=radio]')
      , $checked = $radios.filter(':checked')
      , ids = $checked.map(function (index) {
        var $this = $(this);
        return $this.data('input-value');
      }).get();

    return ids;
  };

  var users = function () {
    var $checkboxes = $('[data-table-role=users]').find('tbody tr td input[type=checkbox]')
      , $checked = $checkboxes.filter(':checked')
      , ids = $checked.map(function (index) {
        var $this = $(this);
        return $this.data('input-value');
      }).get();

    return ids;
  };

  $('[data-action-role=submit]').on('click', function (event) {
    var $link = $(this)
      , href = this.href
      , evaluacionIds = evaluacion()
      , usersId = users();

    $link.attr('disabled', 'disabled');
    $.ajax({
      url: href,
      type: 'POST',
      dataType: 'json',
      data: {
        'id': evaluacionIds,
        'users_id' : usersId,
        'plazo': $('#plazo').val()
      },
      beforeSend: function () {
        if (evaluacionIds.length === 0 || usersId.length === 0) {
          $('.alerts-container').alerto('danger', 'Debes seleccionar una evaluación y al menos un candidato.');
          $link.attr('disabled', false);
          return false;
        }
        return true;
      }
    })
    .done(function (data) {
      var $checkboxes = $('[data-table-role=users], [data-table-role=main]').find('tbody tr td input')
        , $checked = $checkboxes.filter(':checked');

      $checked.prop('checked', false);
      $link.attr('disabled', false);

      $link.trigger('success.ajaxform',data);
      $('#success').modal('show');
    })
    .fail(function (data) {
      $('.alerts-container').alerto('show', data.message);
    })
    .always(function (data) {

    });

    return false;
  });
})(jQuery);