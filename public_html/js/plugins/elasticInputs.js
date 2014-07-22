//Optional parameter includeMargin is used when calculating outer dimensions
(function ($, undefined) {
  "use strict";

  $.fn.getHiddenDimensions = function(includeMargin) {
    var $item = this
      , props = { position: 'absolute', visibility: 'hidden', display: 'block' }
      , dim = { width:0, height:0, innerWidth: 0, innerHeight: 0,outerWidth: 0,outerHeight: 0 }
      , $hiddenParents = $item.parents().andSelf().not(':visible')
      , oldProps = [];

    includeMargin = includeMargin || false;

    $hiddenParents.each(function() {
      var old = {};

      for (var name in props) {
        if (props.hasOwnProperty(name)) {
          old[name] = this.style[name]; 
          this.style[name] = props[name];
        }
      }

      oldProps.push(old);
    });

    dim.width = $item.width();
    dim.outerWidth = $item.outerWidth(includeMargin);
    dim.innerWidth = $item.innerWidth();
    dim.height = $item.height();
    dim.innerHeight = $item.innerHeight();
    dim.outerHeight = $item.outerHeight(includeMargin);

    $hiddenParents.each(function(i) {
      var old = oldProps[i];
      for (var name in props) {
        if (props.hasOwnProperty(name)) {
          this.style[name] = old[name];  
        }  
      }
    });

    return dim;
  };
})(jQuery);

(function ($, undefined) {
  "use strict";

  var Elastic = function (element, opts) {
    this.$el = $(element);
    this.opts = opts;
    this.init();

  }, elastic = Elastic.prototype;

  Elastic.defaults = {
    filter: ':text, select, [type=email], [type=number], textarea'
  };

  elastic.findElements = function () {
    this.$inputs = this
      .$el.find(':input')
      //.filter(':visible')
      .filter(this.opts.filter);
  };

  elastic.eachInput = function (index) {
    var $input = $(this)
      , $parent = $input.parent()
      , $label = $input.siblings("label[for='" + this.id + "']")
      , labelWidth = $label.getHiddenDimensions(true).outerWidth;

    $input.css('width', /*$parent.getHiddenDimensions().width - labelWidth - 1*/ '100%');
    $parent.css('padding-left', labelWidth + 'px');
    $label.css('margin-left', (-1 * labelWidth) + 'px');
  };

  elastic.init = function () {
    this.findElements();
    this.$inputs.each(elastic.eachInput);
  };


  $.fn.elasticInput = function (opts) {
    opts = $.extend({}, Elastic.defaults, opts);

    return this.each(function (index) {
      var elastic = new Elastic(this, opts);
    });
  };

  $.component('elastic-input');
})(jQuery);