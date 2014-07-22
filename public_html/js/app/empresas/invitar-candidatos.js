'use strict';

(function ($, undefined) {

  var $invites = $('#invites');

  $(document).on('click', '.new-invite', function(event) {
    if ($invites.find('ol').children('.row').size() >= 20) {
      return false;
    }

    $invites.find('ol').append($.template('#tmpl-invitaciones', {
      id: $.u.rndm()
    }));

    checkButtons();
    return false;
  }).on('click', '.rm-item',function (event) {
    var $link = $(this)
      , $row = $link.closest('.row');

    $row.fadeOut('fast', function () {
      $row.remove();
      checkButtons();
    });

    return false;
  }).on('success.ajaxform', '#invitarForm', function(e, data) {
    var $form = $(this);

    $form.children('.row').hide('fast').promise().done(function () {
      for (var type in data.results) {
        if (data.results.hasOwnProperty(type)) {
          showInvitacionesSuccess($form, data.results[type], type);
        }
      }
    });
  });

  function checkButtons() {
    var $rmBtns = $invites.find('.rm-item')
      , rmBtnsSize = $rmBtns.size();

    if (rmBtnsSize > 1) {
      $rmBtns.first().removeClass('disabled').attr('disabled', false);
    } else {
      $rmBtns.first().addClass('disabled').attr('disabled', 'disabled');
    }
  }

  function showInvitacionesSuccess($domEl, users, type) {
    $domEl.find('.results').append($.template('#tmpl-invitacion-enviada', {
      users: users,
      type: type
    }));
  }

})(jQuery);