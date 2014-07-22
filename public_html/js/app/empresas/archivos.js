/* jshint unused: false */
/* jshint camelcase: false */
(function ($, undefined) {
  'use strict';

  var $ul = $('#list-files')
    , $assignCreditsBtn = $('[data-role="assign-credits"]')
    , $form = $('#formFacturaUpload')
    , $accepted = $('#accepted')
    , enabledBtn = function () {
      if ($ul.find('li').size() > 0 || +$accepted.val() === 1) {
        $assignCreditsBtn.removeClass('disabled').prop('disabled', false);
      } else {
        $assignCreditsBtn.addClass('disabled').prop('disabled', true);
      }
    };


  var upload = {
    url : $form.attr('action'),
    $fu : $('#fileupload'),
    $progress : $('#progress-file-upload'),
    btns: {
      $save : $('[data-role=save]'),
      $del : $('[data-role=delete]')
    },
    init: function () {
      this.btns.$save.on('click', upload.uploadFile);
      this.btns.$del.on('click', upload.removeFile);
      this.$fu.fileupload({
        dataType: 'json',
        url: upload.url,
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(pdf|doc|docx|jpe?g|png)$/i,
        context: $('#fileupload')[0],
        add: function (e, data) {
          var acceptFileTypes = /(\.|\/)(pdf|doc|docx|jpe?g|png)$/i;

          if(data.originalFiles[0].type.length && !acceptFileTypes.test(data.originalFiles[0].type)) {
            alert('Tipo de archivo no válido');
            return false;
          }

          if(data.originalFiles[0].size && +data.originalFiles[0].size > 1000000) {
            alert('Tamaño de archivo muy grande');
            return false;
          }

          data.form.find('#facturainfo').val(data.files[0].name);
          upload.btns.$save.prop('disabled', false).one('click', function () {
            data.form.valid() && data.submit();
          });
        },
        start: function (e) {
          upload.$progress.show('fade').addClass('active');
        },
        stop: function (e) {
          upload.$progress.removeClass('active');

          setTimeout(function () {
            upload.$progress.hide('fade',500, function () {
              $(this).find('.progress-bar').css('width','0%');
            });
          }, 500);
        },
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          console.log(progress);
          upload.$progress.find('.progress-bar').css('width', progress + '%');
        },
        send: function (e, data) {

        },
        done: function (e, data) {
          var response = data.result
            , $li = $('<li></li>')
            , $a = $('<a></a>', {
              'class' : 'lead',
              'href' : response.results.file.url,
              'text' : response.results.file.filename,
              'target' : '_blank',
            }).appendTo($li)
            , $aDel = $('<a></a>', {
              'class': 'text-danger',
              'href' : response.results.file.deleteUrl,
              'text' : 'Borrar',
              'data-component' : 'ajaxlink',
              'data-ajax-type' : 'DELETE',
            }).data('params', {
              'empresa_id' : response.results.empresa_id
            }).appendTo($li);

            $li.appendTo($ul);

          upload.$fu.replaceWith(upload.$fu.val('').clone(true));
          data.form.find('#facturainfo').val('');

          $('.alerts-container').alerto('show', response.message);
          enabledBtn();
        }
      });
    }
  };

  $(document).on('ready', enabledBtn);

  $ul.on('success.ajaxlink', 'a.text-danger', function () {
    var $this = $(this);
    $this.closest('li').remove();
    enabledBtn();
  });

  upload.init();

})(jQuery);