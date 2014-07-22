(function ($, undefined) {
  "use strict";

  var _templates = {};

  $.template = function (tmpl, data) {
    var fn;

    if (!tmpl) {
      return '';
    }

    if (!(fn = _templates[tmpl])) {
      var $template = $(tmpl);

      if ($template.size()) {
        fn = _templates[tmpl] = doT.template($template.html());
      }
    }

    return $.isFunction(fn) ? fn(data) : 'Template not found';
  };

})(jQuery);