(function ($, undefined) {
  "use strict";

  var Catalog = function (el, opts) {
    this.$el = $(el);
    this.init();
  }, catalog = Catalog.prototype;

  Catalog.defaults = {};

  catalog.init = function () {
    var $selectOption = this.$el.find('.select-option')
      , $panels = $selectOption.next('.panel')
      , $closeBtns = $panels.find('.close').on('click', function () {
        var index = $closeBtns.index(this);
        $selectOption.eq(index).click();
      });

    $selectOption.on('click', function () {
      var $this = $(this);
      $selectOption.not($this).removeClass('active');
      $this.toggleClass('active');
    });
  };

  $.fn.catalog = function (opts) {
    opts = $.extend(Catalog.defaults, opts);

    return this.each(function (index) {
      var catalog = new Catalog(this, opts);
    });
  };

  $.component('catalog');
})(jQuery);