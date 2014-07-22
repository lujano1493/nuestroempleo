/* global bootbox */
(function ($, undefined) {
  'use strict';

  $.validator.addMethod('suggest', function (value, element, params) {
    var $input = $(element).closest('.input')
      , $suggestito = $input.data('suggestito');

    return $suggestito ? $suggestito.isValid() : true;
  }, 'Debes elegir al menos una opción.');

  /**
    * AjaxForm
    */
  var AjaxForm = function (form, opts) {
    var $form = this.$form = $(form);

    this.$buttons = $form.find('[data-submit], .btn');
    this.$submits = this.$buttons.filter('[data-submit]');
    this.$alertBeforeSend = $form.find('[data-alert-before-send]');

    this.opts = $form.data('opts') || {};

    $form.attr('novalidate', 'novalidate');
    this.isModal = $form.hasClass('modal') || $form.hasClass('slidemodal');
    this.action = form.action;
    this.bindEvents();
  }, ajaxform = AjaxForm.prototype;

  AjaxForm.defaults = {

  };

  ajaxform.redirect = function (url) {
    if (url) {
      window.location.href = url;
    }
  };

  ajaxform.bindEvents = function () {
    var self = this;
    //this.$form.submit($.proxy(this.submit, this));

    if (this.isModal) {
      this.$form.on('shown.bs.modal shown.slide.modal', function (event) {
        //console.log('Modal show');
      });

      this.$form.on('hidden.bs.modal hidden.slide.modal', function (event) {
        if (self.validator) {
          self.validator.resetForm();
        } else {
          self.$form.get(0).reset();
        }
        self.$buttons.prop('disabled', false).removeClass('disabled');
      });
    }
  };

  ajaxform.beforeSend = function () {
    this.$buttons
      .prop('disabled', true).addClass('disabled');
    this.$submits
      .append('<i class="icon-spinner icon-spin"></i>');
  };

  ajaxform.onSuccess = function (data) {
    this.message(data.message, data.message_time);
    if (!this.$form.hasClass('no-lock')) {
      this.$buttons.prop('disabled', true).addClass('disabled');
    } else {
      this.$buttons.prop('disabled', false).removeClass('disabled');
    }

    this.isModal && setTimeout($.proxy(this.hideModals, this), 2000); // this.hideModals();
    this.$form.trigger('success.ajaxform', data);
  };

  ajaxform.onError = function (xhr, textStatus) {
    var jsonObj = $.parseJSON(xhr.responseText)
      , validationErrors = jsonObj.validationErrors || {};

    this.message(jsonObj.message, jsonObj.message_time);
    this.$buttons.prop('disabled', false).removeClass('disabled');
    this.processValidationErrors(validationErrors);
    this.scrollTo(this.$form.find('input.error-msg').first());
  };

  ajaxform.always = function (data) {
    this.$submits.find('.icon-spin').remove();
    // this.hideModals();

    data && setTimeout($.proxy(this.redirect, this, data.redirect), 2000);
  };

  ajaxform.message = function (message, time) {
    if (message) {
      if ('string' === typeof message && !message.match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
        $('.alerts-container').alerto('info', message);
        return;
      }

      if (this.isModal && !this.$form.hasClass('on-success-hide')) {
        this.$form.find('.alerts-container').alerto('show', message, {
          'prepend' : true,
          time: time || 2000
        });
      } else {
        $('.alerts-container').alerto('show', message, {
          time: time || 2000
        });
      }
    }
  };

  ajaxform.processValidationErrors = function (errors, scope) {
    var self = this;
    $.each(errors, function (key, value) {
      key = (scope || '') + '['+ key + ']';
      if ($.isPlainObject(value)) {
        self.processValidationErrors(value, key);
      } else {
        'string' === typeof value[0] && self.addMessage(key, value[0]);
      }
    });
  };

  ajaxform.addMessage = function (name, message, type) {
    var $message = $('<div />')
      .addClass('error-msg')
      .html(message)
      .prepend('<a class="close" href="#" data-dismiss="alert">×</a>');

    this.$form.find('[name*=\'' + name + '\']')
      .addClass('error-msg')
      .after($message)
      .one('keypress', function () {
        $(this).siblings('.error-msg').children('.close').click();
      });
  };

  ajaxform.submit = function (event, extraData) {
    var self = this;
    extraData = extraData || {};

    self.validate(extraData, function (valid) {
      if (!valid) {
        self.scrollTo(self.$form.find('.error-msg:visible').first());
        self.always();
      } else {
        if (self.$alertBeforeSend.size() > 0) {
          bootbox.confirm(self.$alertBeforeSend.html(), function (result) {
            result && self.sendAjax(extraData);
          });
        } else {
          self.sendAjax(extraData);
        }
      }
    }.bind(self));

    return false;
  };

  ajaxform.scrollTo = function ($item) {
    $item = $item.closest('fieldset');
    if ($item.size() === 0) {
      return false;
    }

    $('html, body').animate({
      scrollTop: $item.offset().top
    }, 'fast').promise().done(function () {
      // Promise
    });
  };

  ajaxform.hideModals = function () {
    if (this.$form.hasClass('slidemodal')) {
      this.$form.slidemodal('hide');
    } else if (this.$form.hasClass('modal')) {
      this.$form.modal('hide');
    } else {
      this.$form.find('.slidemodal').slidemodal('hide');
    }
  };

  ajaxform.sendAjax = function (extraData) {
    var serializedData = this.$form.serializeObject()
      , formData = this.data = $.extend({},
        serializedData,
        extraData,
        this.$form.data('input-data'));

    $.ajax({
      type  : 'POST',
      dataType: 'json',
      url   : this.action,
      data  : formData,
      beforeSend: this.beforeSend.bind(this)
    })
    .done($.proxy(this.onSuccess, this))
    .fail($.proxy(this.onError, this))
    .always($.proxy(this.always, this));
  };

  ajaxform.validate = function (opts, callback) {
    var self = this;

    this.validator = this.$form.validate({
      debug: false,
      errorElement: 'div',
      errorClass: 'error-msg',
      invalidHandler: function () {
        self.$form.find('.slidemodal').slidemodal('hide');
      },
      ignore: opts.ignore || this.opts.ignore || '.ignore'
    });

    callback(this.$form.valid());
  };

  $.fn.ajaxform = function (opts, args) {
    var options = 'object' === typeof opts && $.extend({}, AjaxForm.defaults, opts);

    return this.each(function (index) {
      var $this = $(this)
        , ajaxform = $this.data('ajaxform');

      if (!ajaxform) {
        $this.data('ajaxform', (ajaxform = new AjaxForm(this, options)));
      }

      if ('string' === typeof opts) {
        ajaxform[opts].apply(ajaxform, args || []);
      }
    });
  };

  /*$(document).one('focus', '[data-component~=ajaxform]', function (e) {
    $(this).attr("novalidate", "novalidate");
  });*/

  /*$(document).on('submit', '[data-component~=ajaxform]', function (e) {
    var $this = $(this);
    $this.ajaxform('submit', [e]);

    return false;
  });*/

  $(document.body).on('click', '[data-submit]', function (event) {
    var $this = $(this)
      , $form = $this.closest('form')
      , data = $this.data();

    if (data.submit) {
      $form.ajaxform('submit', [event, data]);
    }

    return false;
  });

})(jQuery);