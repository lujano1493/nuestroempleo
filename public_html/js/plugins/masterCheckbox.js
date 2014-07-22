(function ($, undefined) {
  'use strict';

  var MasterCheckbox = function (el, opts) {
    this.$el = $(el);
    this.$master = this.$el.find('thead input[type=checkbox].master');
  }, masterCheckbox = MasterCheckbox.prototype;

  masterCheckbox.check = function (el) {
    var $box = $(el)
      , totalCheckboxes = 0
      , totalChecked = 0;

    this.$bodyChechboxes = this.$el.find('tbody tr td:first-child input[type=checkbox]');

    if ($box.is('.master')) {
      this.$bodyChechboxes.prop('checked', $box.is(':checked'));
    } else if ($box.is('[data-input-value]')) {
      totalCheckboxes = this.$bodyChechboxes.size();
      totalChecked = this.$bodyChechboxes.filter(':checked').size();

      this.$master.prop('checked', totalCheckboxes === totalChecked);
    }
  };

  $.fn.checkboxes = function (opts) {
    var options = 'object' === typeof opts && $.extend(MasterCheckbox.defaults, opts)
      , args = Array.prototype.slice.call(arguments, 1);

    return this.each(function () {
      var $this = $(this)
        , masterCheckbox = $this.data('master-checkbox');

      if (!masterCheckbox) {
        $this.data('master-checkbox', (masterCheckbox = new MasterCheckbox(this, options)));
      }

      if ('string' === typeof opts) {
        masterCheckbox[opts].apply(masterCheckbox, args);
      }
    });
  };

  $('table').on('click', 'input[type=checkbox]', function (event) {
    var $table = $(event.delegateTarget);

    $table.checkboxes('check', this);
  });
})(jQuery);