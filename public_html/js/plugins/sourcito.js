(function ($, undefined) {

  'use strict';

  var Sourcito = function (element, opts) {
    this.$el = $(element);
    this.init();
  }, sourcito = Sourcito.prototype;

  Sourcito.defaults = {

  };

  sourcito.init = function () {
    this.$scope = this.$el.data('source-scope') ? this.$el.closest(this.$el.data('source-scope')) : null;

    this.$el
      .on('change', sourcito.getJSON.bind(this))
      .off('click.sourcito');

  };

  sourcito.generateURL = function () {
    var url = this.$el.data('source-controller')
      , elements = [
      url || 'info',
      this.$el.data('source-name'),
      (this.$el.val() || 'index') + '.json'
    ];

    return '/' + elements.join('/');
  };

  sourcito.isEmpty = function isEmpty() {
    return !(this.$el.val() || this.$el.data('default-value'));
  };

  sourcito.beforeSend = function beforeSend(xhr) {
    if (this.isEmpty()) {
      xhr.abort();
      return false;
    }
    this.$el.parent().spin('tiny');
  };

  sourcito.getJSON = function getJSON(event) {
    if (this.$el.data('already-loaded')) {
      return false;
    }

    $.ajax({
      type  : 'GET',
      url   : this.generateURL(),
      data  : {},
      beforeSend: this.beforeSend.bind(this)
    }).done(this.onSuccess.bind(this))
      .fail(this.onFail.bind(this))
      .always(this.always.bind(this));
  };

  sourcito.processResults = function (key, results) {
    if (key === '_defaults') {
      return this.setDefaults(results);
    }

    var self = this
      , $target = ('string' === typeof key) ? $('[data-json-name=' + key + ']', this.$scope) : this.$el
      , options = '';

    if (this.$el.data('source-self') && $target === this.$el) {
      this.$el.data('already-loaded', true);
    }

    results = results || key;

    if ($.isArray(results)) {
      $.each(results, function (index, value) {
          var id = value.id || index
            , name = 'string' === typeof value ? value : (value.nombre || value.name);
          options += '<option value=' + id +'>'+ name + '</option>';
        });
      $target.html(options);
    } else if ($.isPlainObject(results)) {
      $.each(results, $.proxy(sourcito.processResults, self));
      return true;
    }

    $target.val(function (i, val) {
      var defaultValue = $(this).data('default-value')
        , value = ('string' === typeof results || 'number' === typeof results) ? results : defaultValue;

      if (!$target.data('already-loaded')) {
        $target.data('default-value', results);
      }

      return value;
    }).trigger('change');
  };

  sourcito.setDefaults = function (results) {
    var self = this;
    $.each(results, function (key, value) {
      var $tDefault = $('[data-json-name=' + key + ']', self.$scope);
      $tDefault.data('default-value', value);
    });
  };

  sourcito.onSuccess = function onSuccess(data) {
    this.processResults(data.results);
  };

  sourcito.onFail = function onFail(xhr, textStatus) {
    /**
      * Manejamos un error.
      */
    if (!xhr.responseText) {
      return false;
    }

    //var jsonObj = $.parseJSON(xhr.responseText);
  };

  sourcito.always = function always() {
    this.$el.parent().spin(false);
  };

  $.fn.sourcito = function (opts) {
    var options = $.extend({}, Sourcito.defaults, 'object' === typeof opts ? opts : {})
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function (index) {
      var $this = $(this)
        , sourcito = $this.data('sourcito');

      if (!sourcito) {
        $this.data('sourcito', (sourcito = new Sourcito(this, options)));
      }

      if ('string' === typeof opts) {
        sourcito[opts].apply(sourcito, args);
      }
    });
  };

  $('form').one('focus.sourcito', '[data-source-name]', function () {
    var $this = $(this);
    $this.sourcito('getJSON');
  }).find('[data-source-autoload]').sourcito('getJSON');
})(jQuery);