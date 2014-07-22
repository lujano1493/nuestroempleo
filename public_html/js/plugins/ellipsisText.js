


(function ($, undefined) {
  "use strict";
  /**
    * ellipsisText
    */
  var ellipsisText = function (container, opts) {
   

  }, ellipsistext = ellipsisText.prototype;

  $container = $(container);
    var containerHeight = $container.height();
    var $text = $container.find("p");
 
    while ( $text.outerHeight() > containerHeight ) {
        $text.text(function (index, text) {
            return text.replace(/\W*\s(\S)*$/, '...');
        });
    }
  ellipsisText.defaults = {  
  };



ellipsistext.ocultar=function(para){
 
}

$.fn.ellipsistext = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('ellipsistext')
        , options = $.extend({}, $.fn.ellipsistext.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('ellipsistext', (data = new ellipsisText(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('ellipsistext');
})(jQuery);
