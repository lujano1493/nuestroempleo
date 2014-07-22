(function ($, undefined) {
  "use strict";
  /**
    * LinkRef
    */
  var LinkRef = function (link, opts) {
    var $link = this.$link = $(link);
      this.bindEvents();

  }, linkref = LinkRef.prototype;

  LinkRef.defaults = {  
  };


linkref.bindEvents= function (){
    var self=this;
    self.$link.on("click",function (event){
      event.preventDefault();
      var link=$(this).attr("href");
      window.top.location.href=link;
    });
 };
$.fn.linkref = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('linkref')
        , options = $.extend({}, $.fn.linkref.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('linkref', (data = new LinkRef(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('linkref');
})(jQuery);