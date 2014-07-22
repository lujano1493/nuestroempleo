(function ($, undefined) {
  "use strict";
  /**
    * triggerElement
    */
  var triggerElement = function (element, opts) {
    var $element = this.$element = $(element);
    var after_sucess=this.after_sucess=$element.data("after-sucess");

    var action=$element.data("action") ||"click";
    var action_t=$element.data("target-action") ||"click";
    var target=$element.data("target");

    $element.on(action, function (event,data){
        event.preventDefault();
       var $t=$(target);
        $t.trigger(action_t);
    } );
  }, triggerelement = triggerElement.prototype;

  triggerElement.defaults = {  
  };

  

    $.fn.triggerelement = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('triggerelement')
        , options = $.extend({}, $.fn.triggerelement.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('triggerelement', (data = new triggerElement(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('triggerelement');
})(jQuery);

