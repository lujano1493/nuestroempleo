(function ($, undefined) {
  var Editor = function (el, opts) {
    this.$el = $(el).addClass(opts.uneditableClass);
    this.opts = opts;
    this.uneditable = true;

    this.init();
  }, editor = Editor.prototype;

  editor.init = function () {
    var self = this;
    
    this.findElements();
    this.$editLink.on('click', function (e) {
      self.$el.removeClass(self.opts.uneditableClass);
      self.editable();
      $(this).hide();
      self.$cancelLink.show();
      e.preventDefault();
    });

    this.$cancelLink.on('click', function (e) {
      self.$el.addClass(self.opts.uneditableClass);
      self.editable(false);
      $(this).hide();
      self.$editLink.show();
      e.preventDefault();
    });
  };

  editor.isEditable = function () {
    return !this.$el.hasClass('uneditable');
  };


  editor.editable = function (isEditable) {
    isEditable = (typeof isEditable != 'undefined') ? isEditable : true;
    console.log(isEditable);
    this.$inputs.each(function (i) {
      $(this).prop('readonly', !isEditable);
    });
  };

  editor.findElements = function () {
    this.createEditableLinks();
    this.$inputs = this
      .$el.find(':input').not('[type=submit]')
      .filter(':visible');
    this.bindEvents();
    this.editable(false);
  };

  editor.createEditableLinks = function () {
    var self = this
      , $editLink = this.$el.find('a[data-edit-link]')
      , $cancelLink = this.$el.find('a[data-edit-cancel-link]').hide();

    if ($editLink.size() === 0) {
      $editLink = $('<a />', {
        'href'  : '#',
        'text': this.opts.editLink
      }).prependTo(this.$el);
    }
    this.$editLink = $editLink;

    if ($cancelLink.size() === 0) {
      $cancelLink = $('<a />', {
        'href'  : '#',
        'style' : 'display:none;',
        'text'  : this.opts.cancelLink
      }).insertAfter(this.$editLink);
    }
    this.$cancelLink = $cancelLink;
  };

  editor.bindEvents = function () {
    var self = this;

    this.$inputs.on('click', function (e) {
      !self.isEditable() && $(this).addClass('editable').prop('readonly', false);
    }).on('focus', function (e) {
      !self.isEditable() && $(this).addClass('editable').prop('readonly', false);
    }).on('focusout', function (e) {
      !self.isEditable() && $(this).removeClass('editable').prop('readonly', true);
    }).on('keypress', function (e) {
      
      if (e.which === 13) {
        $(this).blur();
      }
    });
  };

  Editor.defaults = {
    editableClass   : 'editable',
    uneditableClass : 'uneditable',
    cancelLink      : 'Cancelar',
    editLink        : 'Editar'
  };

  $.fn.inlineEditor = function (opts) {
    opts = $.extend({}, Editor.defaults, opts);

    return this.each(function (index) {
      var editor = new Editor(this, opts);
    });
  };

  $.component('inline-editor');
})(jQuery);