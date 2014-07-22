  
(function ($, undefined) {
  "use strict";

    $(document).on("click","[data-component*='bottonactionajax']", function (event,data){
      event.preventDefault();
      var $botton =  $(this);
      if(!$botton.data("ajaxrequest")){
        $botton.ajaxrequest({});
        $botton.on("done-ajax.ajaxrequest",function(event ){
                var after_sucess=this.after_sucess=$botton.data("after-sucess");
                var $parent=$botton.closest('div');
                if(after_sucess == "disabled"){
                    $(this).prop("disabled",true);
                }
                else if (after_sucess=="hide" ){
                    $parent.hide("fast",500);
                }
                else if(after_sucess=="remove" ){
                      $parent.empty();            
                }

        });
        $botton.trigger("click");
      }
  } );

})(jQuery);





