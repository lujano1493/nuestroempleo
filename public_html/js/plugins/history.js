/* jshint -W032 */
/* global History */
;
(function ($, H, undefined) {
  'use strict';

  var callbacks = {
      'default': {}
    }
    , _prevHandler = null
    , _timestamp = (new Date()).getTime();

  var $win = $(window)
    , HFn = {
    back: function () {
      H.back.apply(null, arguments);
    },
    push: function () {
      $.h.pushed = true;
      H.pushState.apply(null, arguments);
    },
    replace: function () {
      $.h.pushed = true;
      H.replaceState.apply(null, arguments);
    },
    state: function () {
      return H.getState();
    },
    handler: function (fn, namespace) {
      callbacks[namespace] = fn;
    }
  };

  $.h = function (type, args) {
    var _items = type.split('.');

    if ($.isFunction(args)) {
      return HFn.handler.call(null, args, type);
    }

    type = _items[0];

    if (HFn[type]) {
      if (('push' === type || 'replace' === type)) { //Aquí arguments[1] es data {}.
        /**
         * Se establecen estos datos en arguments, para pasarlos en el data de history.
         */
        arguments[1] = arguments[1] || {};
        arguments[1].__handler = _items[1] || 'default';
        arguments[1].__type = type;
        arguments[1].__timestamp = (new Date()).getTime();
        arguments[2] = arguments[2] || $('[data-role=title]').text();
      }

      return HFn[type].apply(null, Array.prototype.slice.call(arguments, 1));
    } else {
      console.log(type + 'método no existe.');
    }
  };

  $win.on('statechange', function () {
    var State = $.h('state')
      , handler = State.data.__handler
      , type = State.data.__type
      , fn = callbacks[handler]
      , internal = !$.h.pushed
      , timestamp = State.data.__timestamp;


    /**
     * Si no existe el timestamp quiere decir que está regresando.
     */
    if (!timestamp || _timestamp > timestamp) {
      fn = callbacks[_prevHandler + '.back'];
    }

    if ($.isFunction(fn)) {
      fn.call(null, State, type, internal);
    }

    $.h.pushed = false;

    _prevHandler = handler;
    _timestamp = State.data.__timestamp;
  });

})(jQuery, History);