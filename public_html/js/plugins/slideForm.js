(function ($, undefined) {
  "use strict";
  /**
    * slideForm
    */
  var slideForm = function (div, opts) {       
        var parameter=this.parameter={};      
        this.init(div);
  }, slideform = slideForm.prototype;
  slideform.init=function (div){
          var self=this,$div=self.$div=$(div),
              $form=self.$form=$div.find("[data-component*='ajaxform']"),
              action_callback_done=this.action_callback_done= $div.data("action-callback-done") || "default",
              target_callback_done=this.target_callback_done= $div.data("target-callback-done") || "",
              element_refresh=this.element_refresh=$div.data("element-refresh") || [];


          self.bind($form);

  };

  slideform.bind=function ($form){
    var self=this;
    self.$form.on("success.ajaxform",$.proxy( self.form_on_done, self  ));
    self.$form.on("validation-error.ajaxform",$.proxy(self.form_on_validation_error,self));
    self.$form.on("error-ajax.ajaxform",$.proxy(self.form_on_validation_error,self));            
  };
  slideform.refresh_captchar=function(){
      this.$form.find(".refresh-captcha-image").trigger("click");
  };

  slideform.form_on_validation_error= function (event){
    this.refresh_captchar();
  };
 


  slideform.form_on_done=function (event){
      var self=this;

      if(self.action_callback_done=="default"){
        self.$form.addClass("hide");
        self.$div.find(".ajax-done").show("fade",function (){   
           focus_form($(this));       
        },500);
      }
      else if (self.action_callback_done == 'modalshow'){    
            self.$form.each(function (){
                  this.reset();
            });
            self.refresh_captchar();
            $(self.target_callback_done).modal("show");        

      }

      else if (self.action_callback_done=="done-login-refresh") {   
            self.$div.hide("fast");          
            $(self.element_refresh).each (function (index,element){
                var $elem= $(element.target);
                var url= element.url ;
                if(!url || $elem.length == 0 )
                    return true;
                $elem.trigger("create-background-wait.ajax");
                $.get(url,{time: (new Date()).getTime() } ,function(data) {
                   $elem.trigger("remove-background-wait.ajax");
                  $elem.html(data).show("fade",500);
                  var component_arr=["validationform","ajaxform","slideform","socialelement"];
                  $(component_arr).each(function (index,name_com){
                    $.component(name_com,$elem);
                  });
                  /* cargar elemtos  para compartir y dar like*/
                  FB &&FB.XFBML.parse();
                  /*agregamos los botones +1 para google plus*/
                  gapi&&gapi.plusone.go();
                  /*refrescamos y cargamos botones dinamicamente twetter */
                  $.ajax({ url: '//platform.twitter.com/widgets.js', dataType: 'script', cache:true}); 

                }).success(function() { 
                 });

            });
      }
       
  };


 function focus_form($element){

       $('html, body').animate({
                            'scrollTop': $element.offset().top - 30
                          });
  };

  slideForm.defaults = {  
  };

  

    $.fn.slideform = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('slideform')
        , options = $.extend({}, $.fn.slideform.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('slideform', (data = new slideForm(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };



  $(document).on("click",'[data-trigger-slide]',function (event){
      event.preventDefault();
      var $this=$(this),$div=$($this.data("trigger-slide"));
      var slideform=$div.data("slideform");
      if(!slideform){
          return false;
      }
       $div.toggle("slow",function (){
            $div.toggleClass("hide");
            var $element=slideform.$form;
            if($div.hasClass("hide"))
                $element=$this;
              focus_form($element);                  

       });
    });


  

  $.component('slideform');
})(jQuery);
