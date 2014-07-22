



$(document).ready(function (){
      $(function (){
          var process_=  function ($element){
            focus_scroll($element,function (){
                                                $element.trigger("click");

              });

          }   
          var    ref= window.top.location.href, info= ref.split("#")  ;
            if(info.length == 2){
                  var id_element="#"+info[1];
                  if(id_element.length>1){
                    process_( $(  id_element ));
                  }                 
            }
            $(document).on('click',"[data-component*=viewelementview]",function(event) {
                    event.preventDefault();
                    var  $this=$(this),link=$this.data("url") || [];

                    if(link.length ==0){
                        return;
                    }
                    var $element= $("#"+link[0].element);

                    if($element.length ==1){
                              process_($element);

                    }
                    else{
                          var url_base= link[0].empresa ? "/"+link[0].empresa:"";
                          window.top.location.href=url_base+"/" +link[0].controller+"/"+link[0].action+"#"+link[0].element;
                    }
   });
      });

});

function focus_scroll($element,callback){

      if($element.length==0){
        return false;
      }
      callback= $.isFunction(callback) ? callback : function (){};
     $('html, body').animate({
                            'scrollTop': $element.offset().top - 80
                          },callback);


}

