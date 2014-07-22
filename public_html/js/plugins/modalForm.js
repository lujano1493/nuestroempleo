(function ($, undefined) {
  "use strict";
  /**
    * modalForm
    */
  var modalForm = function (modal, opts) {
    var $modal = this.$modal = $(modal),  
        $body= this.$body=$modal.find(".modal-body"),
        $form=this.$form=$body.find("form"),
        close_done=this.close_done=$modal.data("close-done")||false,
        auto=this.auto=$modal.data("auto") || false,
        $div_form=this.$div_form=$body.find(".formulario");

        if(auto) {
            $modal.modal('show');
        }
      this.bindEvents();

  }, modalform = modalForm.prototype;

  modalForm.defaults = {  
  };


modalform.bindEvents= function (){
    var self=this;

    self.$modal.on("hide",$.proxy( self.ocultar, self  ));
    self.$modal.on("shown",$.proxy( self.mostrar, self ));

    self.$form.on("success.ajaxform",$.proxy(self.done_ajax,self));
    self.$form.on("error-ajax.ajaxform",$.proxy(self.error_ajax,self));

 };

modalform.ocultar=function(event){
  var self=this;
  if(!$(event.target).is("div.modal") ){
      return;
  }


  self.$body.children('div').addClass('hide');
  self.$body.find(".ajax-done").css("display","none");
  self.$form.each(function (){  reset_form(this)});  
}
modalform.mostrar=function (event){

    if(!$(event.target).is("div.modal") ){
      return;
    }


  var self=this;
    self.$div_form.removeClass("hide");
  self.$form.find(".refresh-captcha-image").trigger("click");


}
modalform.error_ajax=function (event){
  var self=this;
}
modalform.done_ajax=function(event){
  var self=this;
  self.$body.children('div').addClass("hide");


   if(!self.close_done){          
        self.$body.find(".ajax-done").show("fade",function (){
            $('html, body').animate({ scrollTop: self.$modal.offset().top }, 'slow');
         
        },500);    
    }    
    else{
       self.$modal.modal("hide");
    }
}

$.fn.modalform = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('modalform')
        , options = $.extend({}, $.fn.modalform.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('modalform', (data = new modalForm(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };


  

  $.component('modalform');
})(jQuery);