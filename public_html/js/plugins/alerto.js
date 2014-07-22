(function ($, undefined) {
  'use strict';

  var Alerto = function (el, opts) {
    this.$el = $(el);
    this.tmplFn = opts.template;

    console.log(opts);
  }, alerto = Alerto.prototype;

  Alerto.defaults = {
    template: function (message, type) {
      var tmpl = '<div class="alert-container clearfix"><div class="alert alert-'+ type + ' alert-dismissable fade in popup" data-alert="alert">' +
        '<button type="button" class="close" data-dismiss="alert">×</button>' +
        message +
        '</div></div>';

      return tmpl;
    }
  };

  alerto.show = function (message, options) {
    var self = this
      , opts = options || {}
      , $message = $(message)[opts.prepend ? 'prependTo' : 'appendTo'](self.$el)
      , time = opts.time || (opts > 0 && opts) || 2000;

    setTimeout(function () {
      $message.fadeOut(300, function () {
        $(this).remove();
      });
    }, time);
  };

  alerto.danger = function (message, options) {
    message = this.tmplFn(message, 'danger');
    this.show(message, options);
  };

  alerto.warning = function (message, options) {
    message = this.tmplFn(message, 'warning');
    this.show(message, options);
  };

  alerto.info = function (message, options) {
    message = this.tmplFn(message, 'info');
    this.show(message, options);
  };

  $.fn.alerto = function (opts) {
    var options = $.extend({}, Alerto.defaults, 'object' === typeof opts ? opts : {})
      , args = Array.prototype.slice.call(arguments, 1);
    return this.each(function (index) {
      var $this = $(this)
        , alerto = $this.data('alerto');

      if (!alerto) {
        $this.data('alerto', (alerto = new Alerto(this, options)));
      }

      if ('string' === typeof opts) {
        alerto[opts].apply(alerto, args || []);
      }
    });
  };

})(jQuery);