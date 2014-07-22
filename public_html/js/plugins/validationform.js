(function ($, undefined) {
  "use strict";
  /**
    * ValidationForm
    */
  var ValidationForm = function (form, opts) {
    var $form = this.$form = $(form)
      , $submitBtn = this.$submitButton = $form.find('input[type=submit]');

    this.opts = opts;
    this.action = form.action;
    var options_validation=getValidationOptions(this);
    $form.validate(options_validation);
    $form.addClass("form-validation");
  }, validationform = ValidationForm.prototype;

  ValidationForm.defaults = {  
  };

 function getValidationOptions(vf){

  return {
      focusInvalid:true,
      //onfocusout:false,
      onkeyup:false,
      errorPlacement: vf.error_customize,
      errorElement: 'div',
      wrapper: "div",
      //errorContainer: $('#errores'),
      /*submitHandler: function(form){
        form.submit();
      },*/
      showErrors: function(errorMap, errorList){

        $(this.currentForm).find(".post").remove();
        this.defaultShowErrors();
      /*  
        $(this.currentForm).find(".formError").each ( function (){
          var $div_error=$(this);
          setTimeout(function(){
            $div_error.hide("clip",{},500);
          },2500); 
        });*/


      },
      invalidHandler: function(event, validator) {
        
      }

  }

} 
  /*configuracion personalizada de mensajes de error*/

validationform.error_customize=function (error, element) {

        error.addClass('formError');
        error.removeClass("error");
        error.find(".error").after("<div class='formErrorArrow'> </div>");
        error.find(".error").addClass("formErrorContent");        
        var str_div="",i=10;
         for(i=10;i>=1;i--){
           str_div+="<div class='line"+i+"'><!--  --></div>";
        }
        error.find("div.formErrorArrow").append(str_div);       


    
        /*si el elemento ya se encuentra dentro de div con clase parent_  ya no es necesario agregarlo sobre un div con esta clase*/
      if(element.closest( ".parent_").length==0 ){
        /*para el maggic sugesst*/
        var parent= element.closest("div.ms-ctn").addClass("parent_");
        /*si se encuentra dentro de un maggic suggest */
        if(parent.length>0){
        var div_=parent;
        }
        else if(!element.is("input[type='radio']") && !element.is("input[type='checkbox']") ){
          var parent=element.parent();
          var prev=element.prev();
          var div_=$("<div/>",{'class':"parent_"});
          div_.appendTo(parent);
          /*en caso de que tenga elementos a un lado como iconos otros input ect.*/
          if(prev.is("span.add-on")){
            prev.appendTo(div_);
          }
          element.appendTo(div_);
        }
        else{
          var div_=element.parent().addClass("parent_");

        }

      }
      else{
        var div_=element.closest( ".parent_");
      }
      /*eliminamos mensajes posteriores al enviar ajax*/
      var post =div_.find(".post").empty().remove();
      
      error.appendTo(div_); 
      var width=element.outerWidth()/3;
      var height=error.outerHeight();

      if(element.is("input[type='radio']") || element.is("input[type='checkbox']")){

        var width=div_.outerWidth()/3;
        var height=error.outerHeight();

      }

      error.css("top",-height-5);
      error.css("left",width);
                       
      }

  

    $.fn.validationform = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('validationform')
        , options = $.extend({}, $.fn.validationform.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('validationform', (data = new ValidationForm(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('validationform');
})(jQuery);