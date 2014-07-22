(function ($, undefined) {
  "use strict";
  /**
    * Acordeonsito
    */

  var iconShow=$("<a>&nbsp;Mostrar</a>", {href:"#"} ).prepend($("<i class='icon-plus'></i>") );
  var iconHide=$("<a>&nbsp;Ocultar</a>", {href:"#" } ).prepend($("<i class='icon-minus'></i>") );

  var Acordeonsito = function (div, opts) {
    var $div = this.$div = $(div);
    this.opts = opts;



    var $ocultos=$div.find(".ocultos");

    $div.find(".control a").on("click",function(event){
          var $control=$(this);
          event.preventDefault();

          function toggleClass (icon){
            $ocultos.toggleClass("hide");
            $control.empty();
            $control.append(icon.clone());

          }
          if($ocultos.hasClass("hide")){
            $ocultos.show("clip",500,function (){
              toggleClass(iconHide);        
            });

          }
          else{
              $ocultos.hide("clip",500,function (){
                toggleClass(iconShow);
                $('html, body').animate({ scrollTop: $div.offset().top }, 'slow');
              });      
          }
    });

  }, acordeoncito = Acordeonsito.prototype;

  Acordeonsito.defaults = {  
  };

  

    $.fn.acordeoncito = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('acordeoncito')
        , options = $.extend({}, $.fn.acordeoncito.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('acordeoncito', (data = new Acordeonsito(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('acordeoncito');
})(jQuery);
