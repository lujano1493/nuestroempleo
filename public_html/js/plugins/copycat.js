(function ($, undefined) {
  "use strict";

  var Copycat = function (element, opts, globalElements) {
    var $el = this.$el = globalElements ? $(globalElements) : $(element)
      , splits = $el.data('target-name').split(':')
      , targetName = this.targetName = splits[0]
      , event = splits[1] || 'change';

    this.opts = opts;
    this.$targets = $('[data-name=' + targetName + ']');

    this.getObservers(splits[2]).init(event);

  }, copycat = Copycat.prototype;

  copycat.init = function (event) {

    if (this.$observers) {
      this.initObservers(event);
    } else {
      this.$el.on(event, this.onEvent.bind(this));
      if (this.$el.val()) {
        this.$el.trigger(event);
      }
    }
  };

  copycat.getObservers = function (items) {
    if (items) {
      this.$observers = this.$el.find(items);
    } else {
      this.$observers = null;
    }
    return this;
  };

  copycat.initObservers = function (event) {
    var self = this;
    self.$observers.each(function () {
      $(this).on(event, function () {
        var checked = self.$observers.filter(':checked').map(function () {
          var $this = $(this);
          return '<li>' + $this.next('label').text() + '</li>';
        }).get();

        self.$targets.html(checked.join("\n"));
      }).trigger(event);
    });
  };

  copycat.onEvent = function () {
    var self = this
      , $selected = null
      , thisVal = this.getVal();

    if (this.$el.is('select') && this.$el.data('option')) {
      $selected = this.$el.find('option:selected');
      self.$targets.find('[data-value]').html(thisVal);
      $.each($selected.data(), function (k, v) {
        self.$targets.find('[data-' + k + ']').html(v);
      });
    } else if (this.$el.is(':checkbox')) {
      if (self.$el.is(':checked')) {
        self.$targets.removeClass('hide');
      } else {
        self.$targets.addClass('hide');
      }
    } else {
      self.$targets.each(function () {
        var $target = $(this);

        if ($target.is(':input')) {
          $target.val(thisVal);
        } else {
          $target.html(thisVal);
        }
      });
    }
  };

  copycat.getVal = function() {
    return this.$el.map(function () {
      var $this = $(this)
        , value = '';
      if ($this.is('select')) {
        value = $this.find(':selected').text();
      } else if ($this.is(':input')) {
        value = $this.val();
      } else {
        value = $this.text();
      }

      return value;
    }).get().join(' ');
  };

  /**
    * Plugin que cambia el valor apuntado en data-target
    */
  $.fn.copycat = function (opts) {
    var uniqueTargets = [];
    return this.each(function (index) {
      var dataTarget = $(this).data('target-name');

      if ($.inArray(dataTarget, uniqueTargets) === -1) {
        var target = new Copycat(this, opts, '[data-target-name="' + dataTarget + '"]');
        uniqueTargets.push(dataTarget);
      }
    });
  };

  $(document).on('focus', '[data-target-name]', function (e) {
    var $this = $(this);
    $this.copycat();

    return false;
  });

  $('[data-target-name]', '[data-copycat-autoload]').copycat();
})(jQuery);