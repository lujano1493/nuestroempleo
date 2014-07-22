/* global bootbox */
(function ($, undefined) {
  'use strict';

  var AjaxLink = function (el, opts) {
    this.$link = $(el);
    this.href = el.href;
    this.init();

  }, ajaxlink = AjaxLink.prototype;

  ajaxlink.callbacks = {
    reloadContent: function (data) {
      $('#main-content').magicload('refresh', function ($container) {
        var $link = $container.data('relatedLink');
        if ($link) {
          var $tr = $link.closest('tr')
            , $table = $tr.closest('table');

          $table.dynamicTable('updateRow', $tr, data[0]);
        }
      });
    },
    reloadData: function (event, data) {
      var action=this.$link.hasClass('action-row')
        , $tr =  !action ?this.$link.closest('tr').prev('tr'): this.$link.closest('tr')
        , $table = $tr.closest('table')
        , $link = $tr.find('h5.title-profile a');

      $table.dynamicTable('getData', $tr, function (prevData) {
        var d = $.extend(true, {}, prevData, data[0] || data);
        $table
          .dynamicTable('closeRows')
          .dynamicTable('updateRow', $tr, d);

        $link.size() > 0 && $('#main-content').magicload('load', $link[0].href, 'reload', $link);
      });
    }
  };

  ajaxlink.init = function () {
    //var self = this;
    this.confirmHtml = this.$link.data('ajaxlink-confirm-html');
    this.isMulti = this.$link.data('ajaxlink-multi');
    if (this.isMulti) {
      this.$table = this.$link.closest('table');
    }
  };

  ajaxlink.findCheckboxes = function (callback) {
    var $checkboxes = this.$table.find('tbody tr td input[type=checkbox]')
      , $checked = $checkboxes.filter(':checked')
      , data = {}
      , ids = $checked.map(function (index) {
        var $this = $(this);
        return $this.data('input-value');
      }).get();

    if ($.isArray(ids) && ids.length > 0) {
      data = {
        ids : ids
      };

      callback.call(this, data);
    }
  };

  ajaxlink.click = function (event, opts) {
    var params = {}
      , self = this
      , _confirm = null
      , _continue = function () {
        if (self.isMulti) {
          self.findCheckboxes(self.processAjax);
        } else {
          console.log(opts);
          params = $.extend({
            'after': opts.after,
            'redirect': opts.redirect || 0,
          }, opts.params || {});

          self.processAjax(params);
        }
      };

    this.opts = opts;
    if (this.$link.prop('disabled')) {
      return false;
    }

    if (this.opts.magicloadTarget) {
      this.loadHtml();
    } else {
      if (!opts.noConfirm && 'undefined' !== typeof bootbox) {
        _confirm = this.confirmHtml ?
          $('[data-alert-before-send="'+ this.confirmHtml +'"]').html() :
          '¿Estás seguro que deseas realizar esta acción?';

        bootbox.confirm(_confirm, function (result) {
          result && _continue();
        });
        return false;
      } else if (!opts.noConfirm && !(_confirm = confirm('¿Estás seguro que deseas realizar esta acción?'))) {
        return false;
      }

      _continue();
    }

    return false;
  };

  ajaxlink.loadHtml = function (data) {
    var self = this
      , $content = $(this.opts.magicloadTarget);

    $content
      .magicload({
        'append' : !!this.opts.magicloadTarget,
        'load'   : this.href,
      }, this.$link)
      .on('loaded.magicload', function (event, responseText, textStatus, XMLHttpRequest) {
        $content.magicload('initComponents');

        self.$link.trigger([textStatus, 'ajaxlink'].join('.'), [responseText]);
      });
  };

  ajaxlink.processAjax = function (data) {
    var self = this;

    $.ajax({
      beforeSend: self.beforeSend.bind(self),
      data: data || {},
      dataType: 'json',
      type: self.opts.ajaxType || 'POST',
      url: self.href
    })
    .done($.proxy(self.onSuccess, self))
    .fail($.proxy(self.onError, self))
    .always($.proxy(self.always, self));
  };

  ajaxlink.beforeSend = function () {
    this.$link
      .append('<i class="icon-spinner icon-spin"></i>')
      .addClass('disabled spinner')
      .prop('disabled', 'disabled');

  };

  ajaxlink.onSuccess = function (data) {
    if (this.opts.ajaxlinkTarget) {
      ajaxlink.targets(this.opts.ajaxlinkTarget.split(':'), data);
    }

    data.message && $('.alerts-container').alerto('show', data.message);

    this.$link.trigger('success.ajaxlink', [data]);
  };

  ajaxlink.onError = function (xhr) {
    var data = $.parseJSON(xhr.responseText);

    data.message && $('.alerts-container').alerto('show', data.message);
    this.$link.trigger('error.ajaxlink', [data]);
  };

  ajaxlink.always = function (data) {
    data = $.isPlainObject(data) ? data : $.parseJSON(data);

    data.modal && this.modal(data.modal);
    if (data.callback) {
      var fn = this.callbacks[data.callback.fn];
      fn && fn.apply(this, data.callback.args);
    }

    this.$link
      .removeClass('disabled spinner')
      .prop('disabled', false)
      .find('.icon-spin').remove();

    data && setTimeout($.proxy(this.redirect, this, data.redirect), 2000);
  };

  ajaxlink.modal = function (data) {
    if ('string' === typeof data) {
      bootbox.alert(data, function (result) {

      });
    }
  };


  ajaxlink.targets = function (targets, data) {
    var targetName = targets[1] || targets[0]
      , targetType = (targets[1] && targets[0]) || 'id';

    if (targetType === 'id') {
      $('#' + targetName).replaceWith(data.html);
    } else {
      $('[data-ajaxlink-' + targetType + '="' + targetName + '"]').replaceWith(data.html);
    }
  };

  ajaxlink.redirect = function (url) {
    if (url) {
      window.location.href = url;
    }
  };

  $.fn.ajaxlink = function (opts) {
    var options = 'object' === typeof opts && $.extend({}, AjaxLink.defaults, opts)
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function (index) {
      var $this = $(this)
        , ajaxlink = $this.data('ajaxlink');

      if (!ajaxlink) {
        $this.data('ajaxlink', (ajaxlink = new AjaxLink(this, options)));
      }

      if ('string' === typeof opts) {
        ajaxlink[opts].apply(ajaxlink, args || []);
      }
    });
  };

  $(document).on('click.ajaxlink', 'a[data-component~=ajaxlink]', function (e) {
    var $link = $(this)
      , data = $link.data();

    $link.ajaxlink('click', e, data);

    return false;
  });
})(jQuery);