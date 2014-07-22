(function ($, undefined) {
  'use strict';

  var Suggestito = function (el, opts) {
    var $el = this.$el = $(el)
      , makeQuery = this.makeQuery = this.$el.data('query');

    this.options = this.initOptions(opts);
    this.init();

  }, suggestito = Suggestito.prototype;

  Suggestito.defaults = {

  };

  suggestito.init = function () {
    this.$el.data('magicSuggest', null);

    this.$suggest = this.$el.magicSuggest(this.options);

    if (!this.makeQuery) {
      this.getData();
    }

    if (this.allowFreeEntries) {
      this.$suggest.addToSelection(this.defaultValue);
    }
  };

  suggestito.initOptions = function (opts) {
    var value = this.$el.val();
    this.defaultValue = value ? $.parseJSON(value) : [];
    this.allowFreeEntries = !!(this.$el.data('free-entries') || false);
    return {
      allowFreeEntries: this.allowFreeEntries,
      cls: 'suggestito',
      data: this.makeQuery ? this.$el.data('source-url') : {},
      displayField: this.$el.data('display-field') || 'name',
      emptyText : this.$el.attr('placeholder'),
      inputCfg: {
        'data-rule-suggest' : true
      },
      maxDropHeight: 140,
      maxSelection: this.$el.data('max-selection'),
      maxSelectionRenderer: function(v) {
        return 'No puedes seleccionar más de ' + v + ' opci' + (v > 1 ? 'ones':'ón');
      },
      method: 'GET',
      noSuggestionText: 'No existen sugerencias',
      renderer: this.getTemplate(),
      required: this.$el.prop('required'),
      selectionPosition: 'bottom',
      selectionStacked: true,
      element_extra: opts.renderer,
      valueField: this.$el.data('value-field') || 'id'
    };
  };

  suggestito.getTemplate = function () {
    var template = this.$el.data('template')
      , fnTemplate = templates[template];

    if ($.isFunction(fnTemplate)) {
      return fnTemplate;
    }

    return null;
  };

  suggestito.getData = function () {
    var self = this;
    $.ajax({
      type: 'GET',
      url: this.$el.data('source-url') + '?suggestito',
      dataType: 'json'
    }).done(function (data) {
      self.$suggest.setData(data.results);
      self.$suggest.setValue(self.defaultValue);
    });
  };

  suggestito.isValid = function () {
    return this.$suggest.isValid();
  };

  suggestito.option = function (opt, fn) {
    $(this.$suggest).remove();
    this.options[opt] = fn;
    //this.init();
  };

  $.fn.suggestito = function (opts) {
    if ($.isFunction($.fn.magicSuggest)) {
      var options = $.extend({}, Suggestito.defaults, 'object' === typeof opts ? opts : {})
        , args = Array.prototype.slice.call(arguments, 1);

      return this.each(function (index) {
        var $this = $(this)
          , suggestito = $this.parent().data('suggestito');

        if (!suggestito) {
          $this.parent().data('suggestito', (suggestito = new Suggestito(this, options)));
        }

        if ('string' === typeof opts) {
          suggestito[opts].apply(suggestito, args || []);
        }
      });
    } else {
      console.error('Datatable plugin not exists');
      return this;
    }
  };

  var templates = {
    candidato: function (item) {
      return '<div>' +
        '<div style="float:left;"><img src="' + item.foto + '" width="50"/></div>' +
        '<div style="padding-left: 85px;">' +
            '<div style="padding-top: 20px;font-style:bold;font-size:120%;color:#333">' + item.name + '</div>' +
            '<div style="color: #999">' + item.desc + '</div>' +
            '</div>' +
        '</div><div style="clear:both;"></div>';
    },
    categoria: function (item) {
      return '<div>' +
          '<div>' +
            item.name +
            '<span class="label label-default pull-right">' + item.categoria + '</span>' +
          '</div>' +
        '</div>';
    }
  };

  $.component('suggestito');
})(jQuery);