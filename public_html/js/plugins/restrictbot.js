(function ($, undefined) {
  "use strict";

  var _filters = {
    minValue : function (thisVal, targetVal) {
      if (thisVal < targetVal) {
        this.$el.val(targetVal);
      }
    },
    maxValue : function (thisVal, targetVal) {
      if (thisVal > targetVal) {
        this.$el.val(targetVal);
      }
    }
  };

  var RestrictBot = function (el, opts) {
    var $el = this.$el = $(el);
    this.init();
  }, restrictbot = RestrictBot.prototype;

  restrictbot.init = function () {
    var self = this;
    
    this.filters = this.getFilters();
    
    this.$el.on('change', function (event) {
      var passFilter = false;
      for (var i = 0, _filters = self.filters , _len = _filters.length; i < _len; i++) {
        passFilter = self.checkFilter(_filters[i].target, _filters[i].filter);
        // if (!passFilter) {
        //   break;
        // }
      }
      // if (!passFilter) {

      // }
      // return passFilter;
    });
  };

  restrictbot.checkFilter = function (target, filter) {
    var $target = $('[data-restrict-name="' + target + '"]')
      , targetVal = $target.val()
      , thisVal = this.$el.val()
      , filterFn = _filters[filter];
    
    return filterFn.call({
      $el: this.$el,
      $target: $target
    }, thisVal, targetVal);
  };

  restrictbot.getFilters = function () {
    var filtersString = this.$el.data('restrict-by');

    return $.map(filtersString.split(','), function(val, index) {
      var it = val.split(':');
      return {
        target: it[0],
        filter: it[1]
      };
    });
  };

  $.fn.restrictbot = function (opts) {
    return this.each(function (index) {
      var restrict = new RestrictBot(this, opts);
    });
  };

  $('[data-restrict-by]').restrictbot();

})(jQuery);

