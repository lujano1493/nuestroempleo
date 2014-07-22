(function ($, undefined) {
  "use strict";
  /**
    * AjaxForm
    */
  var AjaxForm = function (form, opts) {
    var $form = this.$form = $(form)
      , $submitBtn = this.$submitButton = $form.find('input[type=submit]'),list_ms=[] ;

      this.hide_alert= $form.data("hide-alert") ? true: false ;

      this.wait_=$form.data("hide-wait-background")? true : false ;


      /*si el form sirve como plantilla  no lo configuramo*/
      if($form.closest(".template").length>0){
          return;

      }
      /*verifica que hacer en caso de que la validación*/
    this.onvalidationerror= $form.data("onvalidationerror") || [] ;

    this.onsucces_action=$form.data("onsucces-action")|| [{ "action":"default"}];

    /*configuracion de radio button jojojojo*/
     $(form).find(".group-radio").find("input").each(function (){
            var $radio= $(this),id_radio=$radio.attr("id");           
            $radio.next().attr("for",id_radio);
     });


    if(Modernizr.input.required ){
      $(form).find(".group-radio").buttonset();
    }   
    config_calendar_form(form);     
    this.$form.find(".magicsuggest").each(function (index,element){
        var options=$(this).data("magicsuggest-options")|| {}  ;
        var id=$(this).attr("id");
        /*eliminamos parametros */
        $(this).data("magicsuggest-options",undefined);        
        var ms=$(this).magicSuggest($.extend(getMaggicSuggestOption(), options));        
        
        /*verificamos si hay parametros de inicio en*/
        if(options.value_ini){
            for (var key in options.value_ini){
              var val_=options.value_ini[key];
              ms.addToSelection(val_);

          }

        }

       var messageValidation= options.messageValidation  ||"Selecciona una opción";
        ms.messageValidation=messageValidation;
        list_ms.push(ms);
        /*si tiene validation */
     /*   if($form.hasClass("form-validation")){

          if(validation_m.required){

             $(form).find( "[id='"+id+"']" ).find("input[id*='ms-input']").attr("name","ms-input"+index).rules("add",{
              magicsugest: ms,          
                messages: {
                magicsugest:validation_m.message
              }});

          }
        }*/



    });

    this.opts = opts;
    this.action = form.action;
    this.bindEvents();
    this.list_ms=list_ms;
    this.element_invalid=[];

    if($form.hasClass("hide")){
        $form.show("fade",1000,function (){ $(this).toggleClass("hide")  });
    }

  }, ajaxform = AjaxForm.prototype;

  AjaxForm.defaults = {

  };

  ajaxform.redirect = function (url) {
    if (url) {
      window.location.href = url;
    }
  };

  ajaxform.bindEvents = function () {
    //guardar  formulario
    this.$form.submit($.proxy(this.onSubmit, this));
    //eliminar formuarlio 
   // this.$form.closest(".formulario").on("click",".delete_data" ,$.proxy( this.delete_data, this ));


  };

  ajaxform.beforeSend = function () {
     if ($.isFunction(this.opts.beforeSend)) {
       this.opts.beforeSend(this);
    }
    else{
        /*verificamos si tiene tooltip :)*/
        if(this.$submitButton.data("tooltip")){
          this.$submitButton.tooltip("hide");
        }

      if(!this.wait_){
        this.$form.parent().trigger('create-background-wait.ajax');
      }
    }
    
  };

  ajaxform.onSuccess = function (data) {    
    var results = data.results ||[],self=this;
    this.$form.addClass("save");
    this.$form.trigger("success.ajaxform",data);

    $(results).each (function (){
          self.$form.find("[name*='"+this.name_id+"']").val(this.id);
    });

    if ($.isFunction(this.opts.onSuccess)) {
       this.opts.onSuccess(data, this);
    }
      self.insertAlert("success",data);              
  };

  ajaxform.insertAlert=function (type,data){                          
              if(!this.hide_alert){
                var $form=this.$form;
                create_alert_ajax($form,type,data);
              }              
  };


    /*en caso de que la validación sea incorrecta ó la respuesta del servidor sea */
  ajaxform.onValidationError=function (){
      if($.isFunction( this.opts.onValidationError )){
          this.opts.onValidationError(this);
      }
        var self=this;
        $( this.onvalidationerror).each(function (index,element){
            self.$form.find(this.target).trigger(this.action);
        });
  };

  ajaxform.onError = function (xhr, textStatus) {
    try{

       this.$form.trigger("error-ajax.ajaxform");   
       var jsonObj = $.parseJSON(xhr.responseText)
      , validationErrors = jsonObj.validationErrors;      
      this.insertAlert("error",jsonObj); 
      this.processValidationErrors(validationErrors);
      this.focusElementInvalid();
      this.onValidationError();
      if ($.isFunction( this.opts.onError)) {
         this.opts.onError(xhr, textStatus, this);
      }


    }catch (err){
        this.insertAlert("error",{code:-1,message:"Error al procesar respuesta del servidor "+ err });

    }
   
  };

  ajaxform.always = function (data) {   
    if ($.isFunction( this.opts.always)) {
       this.opts.always(data,this);
    }
    else{
          if(!this.wait_){
           this.$form.parent().trigger('remove-background-wait.ajax');
          }
    }

    this.$submitButton.prop('disabled', false);
    setTimeout($.proxy(this.redirect, this, data.redirect), 2000);
  };
  ajaxform.focusElementInvalid= function (){
      var self = this;
      if(self.element_invalid.length >0){
          self.element_invalid[self.element_invalid.length-1].focus();
          this.element_invalid=[];
        }
  }



  ajaxform.processValidationErrors = function (errors, scope) {
    var self = this;
    if(!errors){
        return;
    }
    $.each(errors, function (key, value) {
      key = (scope || "") + "["+ key + "]";
      if ($.isPlainObject(value) || $.isArray(value) ) {
        self.processValidationErrors(value, key);        
      } else {
        self.addMessage(key, value);
      }
    });
  };



  ajaxform.addMessage = function (name, message, type) {
        if($.isFunction( this.opts.addMessage)){
            this.opts.addMessage(name, message,type,this);
        }else{
            var new_name=name.split("][");
            name="";
            $(new_name).each(function (index,value){
               name+= ((new_name.length-1)!= index ) ?  value+"]" : ""; 
               name+= ((new_name.length-2) > index)  ?  "[" :"";   
             });


            var element=this.$form.find('[name*=\'' + name + '\']');
            if(element.is(":hidden") || element.length==0 ){
              alert(message );
            }
            else{
                if(!element.hasClass("error")){
                  this.createMessage(message,element); 
                }
            }
           
        }
  };

  ajaxform.createMessage= function (message,element){
    var validationform= this.$form.data("validationform");
    var error=$("<div/>").addClass("post");
    $("<div />").addClass("error").html(message).appendTo(error);    
     element.addClass("error");                      
    if(validationform){
           validationform.error_customize(error, element) ;
    }
    else{
        error.appendTo(element.parent());
    }
    element.blur(function (){ 
                  $(this).removeClass("error").closest(".parent_")
                      .find(".formError").empty().remove();
                    } );

    this.element_invalid.push(element);

  }

  ajaxform.validate= function (){



     /**/

      var flag=true,self=this;

     if($.isFunction( this.opts.validate)){
           flag=  this.opts.validate(this.$form);
       }


      /*verificamos si nuestro formulario utiliza el jquery validation */
    if(this.$form.hasClass("form-validation")){
      if(!this.$form.valid()){
        flag= false;
      }

    }
      /* validamos nuestros magicsuggest*/
      $(this.list_ms).each(function (){ 
        if(this.input.is (':visible') && this.input.parents (':hidden').length == 0 ){
            if (!this.isValid()  ){
              self.createMessage(this.messageValidation ,this.input);              
              flag=false;
            }

        }
        
      });
      if(!flag){
        self.$form.trigger("validation-error.ajaxform");
        this.onValidationError();
        this.focusElementInvalid();
      }
      return flag;


  };


   ajaxform.delete_data = function () {
    var  self=this,$div=self.$form.closest(".formulario"),$form=self.$form;

     function ocultar(){
       $div.hide("fade",500,function() {   $div.remove(); }  );

    }

    if($form.hasClass("save")){
      if(!confirm("¿Estás seguro que deseas realizar esta acción?")){
          return false;
      }
    }
    else{
      ocultar();
      return true;
    }
    var field=$form.find(".primary-key");
    var options_field= field.data("primarykey") ? field.data("primarykey")  :null  ; 
    var data="",name_model="";
    if(options_field){
      data= "data[id]="+field.val() ;
      name_model=options_field.name_model;
    }


    $.ajax({
      type  : 'post',
      dataType: 'json',
      url   : "/Candidato/eliminar/"+name_model,
      data  : data   ,
      beforeSend:  $.proxy(self.beforeSend, self) 
    })
    .done(function (data){ 
          self.$form.trigger("delete-success.ajaxform");
          ocultar();


    })
    .fail($.proxy(self.onError, self))
    .always($.proxy(self.always, self));


    return true;

  };

  ajaxform.onSubmit = function (event) {
    event.preventDefault()
    var self = this, format_ex={
        boostrap:function (){
          if('undefined' === typeof bootbox){
              console.log("no existe referencia bootbox");
              return;
          }
          bootbox.confirm("¿Está seguro de realizar esta acción?", function(result) {
            if(result){
                self.sendInfo();
            }        
            }); 

        },
        default:function (){
           if( confirm("¿Está seguro de realizar esta acción?")){
               self.sendInfo();
          }
        }
    } ;
    /*validamos nuestros elementos del formulario*/
    if(!self.validate()){
        return false;
    }
    var confirm_= self.$submitButton.data("confirm")|| false ,format_confirm=self.$submitButton.data("format-confirm") || 'default';
    if( confirm_ ){    
       format_ex[format_confirm]();        
    }
    else{
        self.sendInfo();
    }
    
    return false;
  };

  ajaxform.sendInfo=function (){
     var self=this, formData = self.data = self.$form.serialize() ,$form=self.$form;
     this.$submitButton.prop('disabled', true);
    var async= $form.data("async")===undefined  ? true :$form.data("async") ===true ;
    $.ajax({
      async: async,
      type  : 'POST',
      dataType: 'json',
      url   : self.action,
      data  : formData,
      beforeSend:  $.proxy(self.beforeSend, self) 
    })
    .done($.proxy(self.onSuccess, self))
    .fail($.proxy(self.onError, self))
  .always($.proxy(self.always, self));

  };

    $.fn.ajaxform = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('ajaxform')
        , options = $.extend({}, $.fn.ajaxform.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('ajaxform', (data = new AjaxForm(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  }



  $.component('ajaxform');
})(jQuery);
