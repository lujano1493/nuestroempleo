/* jshint camelcase: false */
(function ($, undefined) {
  'use strict';

  var $uploadForm = $('#subir-logo');
  var jcrop = {
    $panel: $('#jcrop-panel'),
    createImage: function (imgUrl) {
      return $('<div class="text-center">' +
        '<img id="image-editor" class="jcropeditor" src="'+ imgUrl + '"/>'+
        '</div>');
    },
    init: function (srcImg) {
      jcrop.$panel.empty();
      jcrop.$container = jcrop.createImage(srcImg).appendTo(jcrop.$panel);
      jcrop.$img = jcrop.$container.find('#image-editor');

      jcrop.$img.Jcrop({
        onChange: jcrop.updatePreview,
        onSelect: jcrop.updatePreview,
        onRelease: function () {
          upload.btns.$save.prop('disabled', true);
        },
        aspectRatio: 0
      }, function () {
        var width_ = jcrop.$img.width()
          , height_ = jcrop.$img.height()
          // , width = 250
          // , height = 150;
        //, scale = 0.4;
        jcrop.$img.data('Jcrop').setOptions({
          aspectRatio : width/height,
          maxSize     : [width_, height_],
          minSize     : [width, height],
          setSelect   : [0, 0, width, height]
        });
      });
    },
    updatePreview: function (c) {
      upload.btns.$save.prop('disabled', false);
      if (+c.w > 0) {
        upload.btns.$save.data('coor', c);
      }
    },
    destroy: function () {
      var JcropAPI = jcrop.$img.data('Jcrop');
      if(JcropAPI && JcropAPI !== null){
        JcropAPI.destroy();
      }

      jcrop.$panel.empty();
    }
  };

  var upload = {
    url : '/uploads/upload',
    cropUrl: '/uploads/cropimage',
    $fu : $('#fileupload'),
    btns: {
      $save : $('[data-role=save]'),
      $del : $('[data-role=delete]')
    },
    init: function () {
      this.btns.$save.on('click', upload.savePhoto);
      this.btns.$del.on('click', upload.removeFile);
      this.$img = this.$fu.data('related-img');

      if (this.btns.$save.data('crop-url')) {
        this.cropUrl = this.btns.$save.data('crop-url');
      }

      this.$fu.fileupload({
        dataType: 'json',
        url: upload.url,
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        context: $('#fileupload')[0],
        start: function (e) {
          $('#progress_picture').show('fade').addClass('active');
        },
        stop: function (e) {
          $('#progress_picture').removeClass('active');

          setTimeout(function () {
            $('#progress_picture').hide('fade', 500, function () {
              $(this).find('.bar').css('width', '0%');
            });
          }, 500);
        },
        progressall: function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          $('#progress_picture').find('.progress .bar').css('width', progress + '%');
        },
        send: function (e, data) {
          //upload.removeFile();
        },
        done: function (e, data) {
          var result = data.result
            , imgUrl = result.files[0].url + '?time=' + new Date().getTime();

          upload.btns.$del.prop({disabled:false}).data('data-url', result.files[0]);
          jcrop.init(imgUrl);
        }
      });
    },
    removeFile: function (callback) {
      var disabled = upload.btns.$del.prop('disabled')
        , delete_url = upload.btns.$del.data('data-url').delete_url;

      if (disabled) {
        return;
      }
      callback = callback || {async: true};
      callback.done = $.isFunction(callback.done) ? callback.done : function (){};

      jcrop.destroy();
      upload.btns.$save.prop('disabled', true);
      $.ajax({
        async : callback.async,
        url   : delete_url,
        type  : 'DELETE'
      }).done(function () {
        console.log('Whoops! Se ha borrado.');
      });
    },
    savePhoto: function (event) {
      var cords = upload.btns.$save.data('coor');
      cords.img_info = upload.btns.$del.data('data-url');
      event.preventDefault();
      $.ajax({
        type: 'POST',
        data: cords,
        url: upload.cropUrl,
        dataType :'json'
      }).done(upload.onSucces);
    },
    onSucces: function (data) {
      if (data && data.file_img) {
        $uploadForm.modal('hide');
        jcrop.destroy();
        upload.removeFile();

        if (upload.$img) {
          $('#' + upload.$img).attr('src', data.file_img + '?version=' + new Date().getTime());
        }
      }
    }
  };

  function reset(img) {
    var $img = $('<img />', {
      src: $('#' + upload.$img).attr('src'),
      width: 250,
      height: 150
    });
    $uploadForm.find('#jcrop-panel').html($img);
  }

  $uploadForm.on('shown', reset).on('hidden', reset);

  upload.init();

})(jQuery);