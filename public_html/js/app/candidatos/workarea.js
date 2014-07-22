

(function ($, undefined) {
  "use strict";
  /**
    * workArea
    */
  var workArea = function (div, opts) {
    var $div=this.$div=$(div),count=$div.find(".count_register").val();
    this.data_max= $div.data("max")!=undefined ? $div.data("max"):3;
    this.count=count===""?0:+count ;
    this.opts=opts;
    this.bindEvents();
    //quitamos la clase save a nuestro formulario base  //
    this.$div.find(".template div.formulario form").removeClass("save");

    $(document).ready(function ($){

      if(count==0){
          $div.find(".add").trigger("click");

       }


    });

    
  }, workarea = workArea.prototype;

  workArea.defaults = {

  };


  workarea.bindEvents= function (){
      var self=this;

    self.$div.on("click",".add",$.proxy( self.add, self ));
      self.$div.on("click",".remove",$.proxy( self.remove, self ));
   // self.$div.on("click",".show" ,$.proxy( self.show, self ));
   // self.$div.on("click",".hide" ,$.proxy( self.hide, self ));

  }


  workarea.add = function (event) {
    event.preventDefault();    

    if( this.count >=   this.data_max){
      alert("Sólo puede agregar "+this.data_max  +" como máximo.");
      return;
    }


    /*creamos un formulario nuevo apartir de la pantilla base */
    var self=this, $new_form=self.$div.find(".template div.formulario").clone();
    this.changeName($new_form);
    $new_form.css("display","none");
    var name_components=["validationform","ajaxform"];
    /*conguramos el nuevo form con los plugins de validacion y ajax*/
    
    $(name_components).each(function (c,i){
        $.component(i,$new_form);
    });
    $new_form.find("form [data-source-name]").sourcito('getJSON');


    /*agregamos nuestro nuevo formulario al espacio*/
    self.$div.find(".agregados").append($new_form);

  
   
    $new_form.show("fade",500, function (){  
      
       /*cargar eventos iniciales para el formulario*/
      /*configuramos los eventos para el nuevo form*/
       $new_form.find(".event-change").each(function (){
          $(this).trigger("change");
        });
      $new_form.find("[type='submit']").focus() ;
       

    });    

    this.count++;

  };

  workarea.remove= function (event){
    event.preventDefault();
    var $div= $(event.target).closest(".formulario"),$form=$div.find("form");

    this.count= $form.ajaxform("delete_data") ? this.count-1:this.count;

  };





  workarea.changeName =function ($new_form){
    var self=this;
    /*cambiamos el nombre de cada input,select y textarea*/
    $new_form.find("select,input,textarea,div.date-picker").each (function (){
      var name=$(this).attr("name"),str_id="";

      if(name!=null){
         var names=name.split("][");

          var newname="";

            newname= names[0];
              /*verificamos si es un radio*/
             if($(this).is(":radio")){
                  str_id=$(this).val(); 
              }

            if(names.length == 3){
              newname+= "][" + self.count  +"]["+ names[names.length-1] ;
            }  
            else  if(names.length==2){
                newname+="]["+ names[names.length-1] ;
            }
            else{

               newname=names+count;
            }
            $(this).attr("id",newname.replace(/\[|\]|data/gi,"")  + str_id );
            $(this).attr("name",newname);    

      }
    });


  };
 
  $.fn.workarea = function (opts) {
    opts = $.extend({}, workArea.defaults, opts);

    return this.each(function (index) {
      var div = new workArea(this, opts);
    });
  };

  $.component('workarea');
})(jQuery);