(function ( $, undefined) {
  "use strict";
  /**
    * 
    */


    var evaluacionCan = function (el, opts) {       
          var self=this,$el=this.$el=$(el),
           type_test= this.type_test=$(el).data("type-test") || 'N',
           size_test=this.size_test=$(el).data("size-test")|| 0,
           idEvaluacion=this.idEvaluacion= $(el).find(".idEvaluacion").val();
           self.question_solve=size_test;
        
          if(type_test=='N'){
              this.init_form_test();
              this.init_cronom();
          }  

          else{
                this.init_test_time();
          }



          this.bind_ordinary();


  }, evaluacioncan = evaluacionCan.prototype;
  evaluacioncan.init_test_time = function (el){ 
      var  self=this,$el=this.$el,$btn_start=$el.find(".btn-start-time"),
          idEvaluacion=this.idEvaluacion;
          self.test_time_config($el,$btn_start,idEvaluacion);



          /*si la prueba ya habia iniciado se disparan los eventos para mostrar la evaluacion*/
      var start_test=self.start_test=self.$el.data("start-test");    
      if(start_test){
            $btn_start.trigger("click");

      }
        

 };

evaluacioncan.test_time_config=function ($el,$btn_start,idEvaluacion){
    var self=this; 
    $btn_start.on("click",function (event){            
            event.preventDefault();            
             $btn_start.prop('disabled', true);
            $.getJSON("/Evaluaciones/evaluacion_completa/"+idEvaluacion,{time:new Date().getTime()},function(data){                  
                  var results=data.results;
                  $el.find(".sesion-preguntas").html(data.content);  
                  self.size_test=results.total_preguntas;
                  var start=new Date(results.start),time=new Date(results.time );
                  self.init_form_test();
                  self.init_cronom(time);                  
                  self.old_data_form=self.get_data_form();    
                  if(self.type_test=='S'){                    
                    self.$el.find("[type='submit']").removeClass('hide'); 
                  }
                  else if(self.type_test=='P'){
                     var $button_next=self.$button_next= $('<button class="btn_color btn-large next-question"> Siguiente </button>');
                     self.$el.find("[type='submit']").closest('div').append($button_next); 
                  }
                  $btn_start.remove();                    

            } );          

          });

   

};


 evaluacioncan.init_cronom=function (time){
            time= time || new Date(1000*60*60*24);
            var self=this,time_=time.getTime(),reset=time_; 
            reset= reset < 0  ? 0 :reset;   
            var $time_test=self.$el.find(".time-test") ,formato_fecha=function(start,end,callback){                
                callback= callback|| function(){};
                var reset= end.getTime()- start.getTime(),
                    seg= reset /(1000),min=Math.floor(seg/60),
                    hrs=Math.floor(seg/(60*60));
                    seg= Math.floor(seg%60);
                if(reset>= 0 )                   
                   $time_test.html(  min+"  min. "+seg+" seg." );
                callback();
            };         
            var  start=new Date(),end=new Date( start.getTime()+reset);
            formato_fecha(start,end,function(){ $time_test.removeClass('hide');  });
            var chrono=self.chrono =setInterval(function (){                                                                                        
                var now=new Date();                
                formato_fecha(now,end);
                self.time_reset=end.getTime()-now.getTime();
                  /*verificamos formulario cada 3 min*/
                if(  now.getTime() % (1000*60*3 )  == 0  ){                                          
                      if(!self.check_form()){
                          self.save_form();

                      }
                }
                  if(now >=  end){
                    self.stop_chrono();
                    if(self.type_test==='S' || (self.type_test==='P' && self.question_solve-1 <= 0   )){
                      self.end_test();     
                    }            
                    else {
                          self.$el.find(".next-question").trigger("click",true);
                    }

                  }                  
            },1000);
           
 };

 evaluacioncan.stop_chrono=function (){
          clearInterval(this.chrono);
 };
 evaluacioncan.end_test=function(){
      var self=this;
       self.flag_validate=true;
       self.$el.find("[type='submit']").trigger("click").remove();            

 };



  evaluacioncan.init_form_test = function (){     
          var self=this,$el=self.$el, $preguntas=self.$preguntas=$el.find(".pregunta"),
              $opciones=self.$opciones=$el.find(".opcion .opcion-input");

          $el.ajaxform({
                        validate:$.proxy(self.validate,self)

          });
          self.flag_validate=false;
          $preguntas.each(function (){
                  var $pregunta=$(this),arr_opc=[],$checked=$pregunta.find(":checked");
                  var $input_opc=$pregunta.find("input[type='hidden'].opciones");

                  $checked.each(function (){
                        arr_opc.push($(this).val());

                  });
                  $input_opc.prop("value","["+arr_opc+"]");        
                  $input_opc.data("value",arr_opc);

          });

  };

  evaluacioncan.check_form=function (){
      var self=this,flag=true, 
          old_data_form=this.old_data_form= this.old_data_form,
      new_data_form=this.get_data_form();

      if(new_data_form.length!==old_data_form.length){
        return false;
      }

      $(new_data_form).each(function (index,element){
          flag= $.compare(new_data_form[index],old_data_form[index]);
           return flag;
      });
      this.old_data_form=new_data_form;
      return flag;

  };
  /*envio del formulario de manera sincrona*/
  evaluacioncan.save_form= function (async){
     async= async === undefined ? true : false;    
      var self=this,data=(this.$el.serialize()+"&data[time]="+self.time_reset);
      $.ajax({
        url: '/Evaluaciones/guardar_preguntas',
        type: 'POST',
        dataType:'json',
        data: data,
        async:async
      }).done(function(){
            self.$el.find(".save").val("true");
      });    
  };

  evaluacioncan.get_data_form = function (){
          var data=[];
          this.$el.find("input[type='hidden'].opciones").each(function (){

                     data.push( $(this).data("value") || [] );

          });      
          return data;

  };



  evaluacioncan.bind_ordinary=function (){
    var  self=this,$opciones=self.$opciones,$el=self.$el;
    self.$el.on("success.ajaxform",function (event,data){
        $("#btn_hide_gracias").trigger("click");        
        self.stop_chrono(self.chrono);
        self.unbind();
    });

    self.$el.on("click",".next-question",function(event,flag){ 
        flag= flag || false;
        var  $session=self.$el.find(".sesion-pregunta:last"), 
             idPreg=$session.find("[name*='pregunta_cve']").val(),
             $btn=$(this);        
        self.flag_validate=flag;
        if (!self.$el.data("ajaxform").validate()){
          return false;
        }
        event.preventDefault();
        $btn.prop('disabled', true);
        var param="time="+new Date().getTime()+"&idPreg="+idPreg;
        self.stop_chrono();
        $session.hide("slow",function (){ $(this).addClass('hide') });
        $.getJSON("/Evaluaciones/cambiar_pregunta/"+self.idEvaluacion+"?"+param  ,function(data){          
              var results=data.results;
              self.question_solve=results.question_solve;
              $el.find(".sesion-preguntas").append(data.content).
                  find(".sesion-pregunta:last").find("[name*='Pregunta']").
                  each(function (){
                      var $this=$(this),index= self.size_test-self.question_solve, 
                      name=$this.attr("name"), arr_name=name.split(/data\[Pregunta\]\[[0-9]+\]/);
                      if(arr_name.length>1){
                            $this.attr("name","data[Pregunta]["+index+"]"+arr_name[1]);
                      }


                  });  

              var start=new Date(results.start),time=new Date(results.time );              
              if((self.question_solve-1) == 0  ){  
                self.$button_next.remove();
                $el.find("[type='submit']").removeClass('hide');
              }
              self.init_cronom(time);  
              $btn.prop('disabled', false);                        
        } );    


    });


    self.$el.on("click",".opcion .opcion-input",function (event){
      var $this=$(this),$div_pregunta=$this.closest('.pregunta'),$opciones_input=$div_pregunta.find("input[type='hidden'].opciones"), 
       $opciones=$div_pregunta.find(".opcion-input:checked"),arr_opc=[];
       $opciones.each(function (){
              arr_opc.push($(this).val());
       });        
      $opciones_input.prop("value","["+arr_opc+"]");        
      $opciones_input.data("value",arr_opc);

    });



     $(window).on('beforeunload', function(event) { 
              /*antes de que salga mensaje de cargar o mantenerse*/                                 
               self.save_form(false);           
                return "Actualmente se encuetra su evaluación en proceso.";

        } 
    ).on('unload',function (event){  
          


     });


  };

  evaluacioncan.unbind=function (){
      $(window).off("beforeunload").off("unload");


  }

  evaluacioncan.validate=function ($form){
      var self=this,$arr_opciones=self.$el.find("input[type='hidden'].opciones"),        
          flag=true;
        if(self.flag_validate){
              return true;
          }

        $arr_opciones.each(function (){
                var  $ele=$(this), arr_opc= $ele.data("value") || [];
                  if( $ele.closest('.sesion-pregunta').hasClass('hide')  ){
                      return true;
                  }
                  if(arr_opc.length==0 ){
                      flag=false;
                      self.focus( $ele.closest('.sesion-pregunta') );
                      return false;
                  }

        });
        
      return flag;

  };

  evaluacioncan.focus=function ($element,offset){
        offset= offset || 0;
        $('html, body').animate({ scrollTop: $element.offset().top +offset }, 'slow');
  };

  evaluacioncan.defaults = {  
  };

  

    $.fn.evaluacioncan = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('evaluacioncan')
        , options = $.extend({}, $.fn.evaluacioncan.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('evaluacioncan', (data = new evaluacionCan(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  $.component('evaluacioncan');

})(jQuery);
