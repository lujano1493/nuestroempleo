(function ($, undefined) {
  "use strict";
  /**
    * formBusqueda
    */
  var formBusqueda = function (form, opts) {
    var $form = this.$form = $(form);
     


  }, formbusqueda = formBusqueda.prototype;

  formBusqueda.defaults = {  
  };

  

    $.fn.formbusqueda = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('formbusqueda')
        , options = $.extend({}, $.fn.formbusqueda.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('formbusqueda', (data = new formBusqueda(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('carrusel');
})(jQuery);
