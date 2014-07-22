(function ($, undefined) {
  "use strict";
  /**
    * triggerElementSelect
    */
  var triggerElementSelect = function (elem, opts) {       
      var $elem=this.$elem=$(elem),scope=this.scope =  $elem.data("scope") || 'form',
          target=this.target=$elem.data("target") || "", default_status= this.default_status= $elem.data("default-status") ||'hidden',
          value_change=this.value_change=$elem.data("value-change") || "", name_event=this.name_event =$elem.data("name-event")|| "change";
    
          this.init();
       
  }, triggerelementselect = triggerElementSelect.prototype;
  triggerelementselect.init=function (){
    this.$scope= this.$elem.closest(this.scope);
    this.$target=this.$scope.find(this.target);

    var do_status=  this.default_status =='hidden'  ?  'hide':'show'    
    this.$target[do_status]();
    this.bind();
  };

  triggerelementselect.bind=function (){
      var self=this,$elem=self.$elem,$target=self.$target,
            name_event=this.name_event,value_change=this.value_change;
      $elem.on(name_event,function (event){
            var $this= $(this);
            $target[$this.val()==value_change? 'show':'hide'  ](500) ;
      });




  };



  triggerElementSelect.defaults = {  
  };

  

    $.fn.triggerelementselect = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('triggerelementselect')
        , options = $.extend({}, $.fn.triggerelementselect.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('triggerelementselect', (data = new triggerElementSelect(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  
  $.component('triggerelementselect');
})(jQuery);
