/**
  *
  */
(function ($, undefined) {
  "use strict";

  $.component = function (name, context, opts) {
    opts = opts || {};
    var fnName = $.camelCase(name)
      , $items = $('[data-component~="'+ name + '"]', context);

    if ($.isFunction($.fn[fnName])) {
      $items[fnName](opts);
    }

    return $items;
  };

  $.fn.serializeObject = function() {
    var o = {}
      , a = this.serializeArray();
    $.each(a, function() {
      if (o[this.name] !== undefined) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || '');
      } else {
        o[this.name] = this.value || '';
      }
    });
    return o;
  };

})(jQuery);