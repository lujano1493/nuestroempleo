(function ($, undefined) {
  "use strict";
  /**
    * 
    */


    var searchAdvanced = function (el, opts) {       
          
          this.init(el);


  }, searchavanced = searchAdvanced.prototype;



  searchavanced.init = function (el){     

    var  $el=this.$el=$(el),            
          action=this.action=el.action|| "", 
          $submit=this.$submit= $el.find("[type='submit'].search-all"),
          $search_query= this.$search_query=$el.find(".search-query"),
          $submit_a=this.$submit_a= $el.find("[type='submit'].search-avanced"),
          $params=this.$params=$el.find(".param-name");



          this.bind();




  };
  searchavanced.url_direct=function(url_param){
         var self=this,new_url= self.action +"?"+url_param;
        window.top.location.href=new_url;

  };

  searchavanced.bind= function (){
      var self=this,$params=self.$params,$submit_a=self.$submit_a,$submit=self.$submit,
          $el=self.$el;




      $el.on("click",".btn-slide",function (event){
          event.preventDefault();
          var $btn=$(this);
      

          var $hide= $el.find(".panel-search"),$show= $el.find(".panel-advanced");         
          if($btn.hasClass('active')){
            $hide=$el.find(".panel-advanced");
            $show=$el.find(".panel-search");           
          }

          $hide.hide("clip",600,function (){
                  $show.show("clip",600);
          });

      });

      $submit_a.on("click",function (event){
        event.preventDefault();
        var  url_param="",data={};

        $params.each(function (index,element){
          var $this=$(this),field=$this.data("param-name");    
          if( $this.val().length > 0   )  {            
            var value = $this.is("[type='text']") ? $this.val() : $this.find("option:selected").text() ;
            data[field] = !data[field] ? value :data[field] +" "+ value ; 

          }

        });


        for(var key in data ){
               if(data[key]){
                url_param+= key+"="+data[key]+"&";
               }

          }
          url_param+="busqueda_avanzada=true";


        self.url_direct(url_param);
      });


      $submit.on("click",function (event){
        event.preventDefault();
        var  url_param= self.$search_query.data("param-name") +"=" + self.$search_query.val();               
        self.url_direct(url_param);
      });



    
  };

  searchavanced.defaults = {  
  };

  

    $.fn.searchavanced = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('searchavanced')
        , options = $.extend({}, $.fn.searchavanced.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('searchavanced', (data = new searchAdvanced(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  $.component('searchavanced');

})(jQuery);
