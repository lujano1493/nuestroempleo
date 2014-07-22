(function ($, undefined) {
  'use strict';

  $.u = {
    stripHtml: function (htmlString) {
      return $('<div/>').html(htmlString).text();
    },
    rndm: function (length) {
      var d = new Date();
      return (+d).toString(16).slice(-(length || 6));
    },
    currency: function (number, decimals, symbol) {
      decimals = decimals || 2;
      symbol = symbol || '$';

      return symbol + '' + number.toFixed(decimals).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    },
    getKey: function (key, value) {
      var keys = key.split('.');

      for (var i = 0, _len = keys.length; i < _len; i++) {
        value = value[keys[i]];
      }
      return value;
    },
  };

})(jQuery);