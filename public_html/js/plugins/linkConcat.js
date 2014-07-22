(function ($, undefined) {
  "use strict";
  /**
    * linkConcat
    */
  var linkConcat = function (div_content, opts) {       
        var  self=this,parameter=self.parameter={};         
        this.url_refresh_filter=
        $(div_content).data("param-search",$(div_content).data("param-search-ini") ||"");

        var elements_refresh= $(div_content).data("callback-refresh-element");

        $(elements_refresh).each( function(index, val) {
             if(val.type=='datatable'){
                  var params_ini= $(val.target).data("params-ini");
                   $(params_ini).each(function (){
                      self.parameter[this.name] = this.value;
                   });                   
             }
        });



        this.init(div_content);
  }, linkconcat = linkConcat.prototype;
  linkconcat.init=function (div_content){

        var  self=this,$div_content= this.$div_content= $(div_content);
        var  tipo=this.tipo=$div_content.data("request") || 'none';
        var callback_refresh=this.callback_refresh=  $div_content.data("callback-refresh-element") || [];
        var $filtros=this.$filtros=$div_content.find(".filtro"),
            $parent_filtros= this.$parent_filtros=$div_content.find(".parent-filtro");        
        self.url_filter= $div_content.data("url-filter")||"/BusquedaOferta/filtros";
        self.procesa();
        self.bind_event();


  };

  linkconcat.bind_event=function (){
      var self=this;

      // self.$parent_filtros.on("click",function (event){
      //     event.preventDefault();
      //     var $this=$(this);
      //     $this.closest('.categoria-root').find(".sub-categoria").toggleClass("hide");
      // });


  };

  linkconcat.estatico=function ($filtro) {

      var url=$filtro.attr("href") || $filtro.data("url") || '';
      var option=$filtro.data("option") || 'concat';
      var field_query=$filtro.data("field-query") || '';
      var value_query=$filtro.data("value-query") || '';

     var param = window.top.location.href.split("?");
      var param_= url.split("?");

      var data= "";
      if(option=='concat'){

        if(param_.length==2){
          data=param_[1];
        }

        if(param.length==2 ){
           if(param_.length==2){
               data+="&";
           }
          data+=param[1];
        }
      }
      else{

         if(param.length==2 ){

            var ss=param[1].split("&"),ll=ss.length;

            for (var index = 0 ;index<ll ;index++ ){
              if(  ss[index].indexOf(field_query)  == -1){            
                data+= ss[index] + ( (index+1<ll) ? "&" :"" );
              }

            }
       
        }
     


      }
      var new_url= (option=='concat' ? param_[0]:"" )  +"?"+data;
      $filtro.attr("href",new_url);
      $filtro.on("click",function (event){
          event.preventDefault();
            window.top.location.href=new_url;
      });



  };

  linkconcat.refresh_element=function (){
      var self=this;

      $(self.callback_refresh).each( function(index, data) {
            if(data.type== 'datatable' ){
             self.refresh_datatable($(data.target));

            }


         
      });



  };

  linkconcat.refresh_datatable=function ($table){
    var self=this, table = $table.dataTable(),
        oSettings = table.fnSettings();

    //Retrieve the new data with $.getJSON. You could use it ajax too
    var params=[];
    for(var i in self.parameter){
        if(self.parameter[i] ){
             params.push({name:i,value:self.parameter[i]});
        }
    }

    $table.data("dynamic-params",params);
    $table.fnClearTable(false);
    $table.fnDraw(true);    


  }

  linkconcat.ajax=function ($filtro){
    $filtro.on("click",function (event){    
      var option=$(this).data("option") || 'concat';
      var field_query=$(this).data("field-query") || '';
      var value_query=$(this).attr("data-value-query") || '';
      var self=$(this).closest("[data-component*='linkconcat']").data("linkconcat");
      event.preventDefault();      
      /*verificamos si el parametro habiasido elejido anteriormente en el caso de que si fue seleccioando se elimina */
      self.parameter[field_query] = !self.parameter[field_query] ?  value_query : null; 
      /*si el parametro a enviar existe se agregara a la lista de filtros seleccionados*/   
      self.refresh_data($(this));

    });


      


  };


  linkconcat.refresh_data=function ($filtro){     
     var self=this,$div_content=self.$div_content,str_param="";
    var field_query=$filtro.data("field-query") || '';
     var value_query=$filtro.attr("data-value-query") || '';

    for (var key  in self.parameter ){  
      if(self.parameter[key]){
        str_param+= "&"+key +"="+ encodeURIComponent(self.parameter[key]);          
      }          
    }
    str_param= "time="+(new Date().getTime()) +"&dato="+ ( encodeURIComponent(self.$div_content.data("param-search")) )  +str_param;    


    $div_content.trigger('create-background-wait.ajax');
     $(".filtros-select").data("type-wait","block"); 
    $(".filtros-select").trigger('create-background-wait.ajax');

    self.refresh_element();


    $.getJSON(self.url_filter+"?"+str_param,function (data){
    $div_content.find(".target-load").html(data.content);
    $div_content.trigger('remove-background-wait.ajax');
    $(".filtros-select").trigger('remove-background-wait.ajax');
    var component_arr=["tooltip","acordeoncito"];
    $(component_arr).each(function (){
      $.component(this,$div_content);
    });
    $div_content.each(function (){
      self.init(this);
    });

    if(   self.parameter[field_query] ){
      var data= {
      field_query:field_query,
      value_query:value_query
      };
      var html=$.template("#tmpl-filtro-select",data);
      $(".filtros-select").append(html);
    }  else{
      $(".filtros-select").find("."+field_query).closest("span").find(".delete-filter").trigger("click",true); 
    }
    });


  };

  linkconcat.procesa=function (tipo){
    var self=this;
    $(self.$filtros).each( function(index, filtro) {
            var $filtro=$(filtro);
            if(self.tipo=='none'){
                self.estatico($filtro);
            }                  
            else{
                self.ajax($filtro);
            }

    });



  };

  linkConcat.defaults = {  
  };

  

    $.fn.linkconcat = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('linkconcat')
        , options = $.extend({}, $.fn.linkconcat.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('linkconcat', (data = new linkConcat(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


    $(document).on("click",".filtro-select .delete-filter",function(event,flag){
                event.preventDefault();
                var value_query=$(this).data("value");
                var field_query=$(this).data("query");
                $(this).closest('p').remove();                
                  if(!flag){
                      $("[data-field-query='"+field_query+"']").each(function(index,element){
                        var $this=$(this);
                          if($this.data("value-query") == value_query){
                             $this.trigger("click")
                              return false;
                          }


                      } );
                  }                  
              
          });    

     $(document).on("click",".filtro-select span.badge",function (event){
          event.preventDefault();

     });
  

  $.component('linkconcat');
})(jQuery);
