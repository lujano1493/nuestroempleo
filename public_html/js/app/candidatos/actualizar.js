

$(document).ready(function ($){

  $(function(){
    "use strict";
    var form_data=$("form:not(.template)").serialize();
     toggle_radio(["S","N"],"change",".fecha_final_escolar",".ec_actual ",false);
              toggle_radio(["S","N"],"change",".fecha_final_explab" ,".explab_actual",false);
              toggle_();
              /*  $("#collapseThree, #collapseNine").on("shown",function (){     
                 $(this).closest(".accordion-group").find("button.si-no").html("No")      }) ;
              $("#collapseThree, #collapseNine").on("hiden",function (){     
                 $(this).closest(".accordion-group").find("button.si-no").html("Si")      }) ;*/
              $(".accordion-body").on ("shown",function (event){  
                 event.preventDefault(); 
               $("body, html").animate({
                "scrollTop":   $("#" + $(this).attr("id") ).parent().offset().top
                  }, 500);
  }); 
  $(".refrel_cve").on("click",function(event) {
         event.preventDefault(); 
         var $e=$(this),$s=$e.closest("form").find(".reftipo_cve"); 
               if($e.val()>4) 
                $s.val("0"); 
               else 
                $s.val("1");     

           } );

  


    $(document).on("success.ajaxform","form",function(event){
         var $form=$(event.target);
         if($form.hasClass('change-form'))
            $form.removeClass('change-form');

    }); 
    $(document).on("change","input,select,textarea",function(event){
          var $this= $(this), id=$this.attr('id')|| "";
          if( id.indexOf("ms-input") > -1 )
                return;            
          var $form=$(event.target).closest('form');
           if( $form.data("ajaxform")  && !$form.hasClass('change-form'))
              $form.addClass('change-form');

    });

    $('form').each(function(){
        var ajaxform=$(this).data("ajaxform");
        if(!ajaxform)
            return true;
        var list_ms=ajaxform.list_ms;
        if (!list_ms){
          return true;
        }

        if(list_ms.length >0 )
            $(list_ms).each(function (){                  
                   $(this).on("selectionchange",function(event,msn,data){
                        msn.input.closest('form').addClass('change-form');
                   });
            });

    });    




   $(window).on('beforeunload', function(event) { 
             event.preventDefault();
              var $forms=$("form.change-form");
                    
                  $forms.each(function(){
                        var $form=$(this);
                        $form.data("async",false);
                        $form.find("[type='submit']").trigger("click");
                  });
                 

        } 
    ).on("unload",function(event){


    });



  });

});


 
