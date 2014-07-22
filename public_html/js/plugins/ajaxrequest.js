



(function ($, undefined) {
  "use strict";
  
  //jaxRequest
    
  var ajaxRequest = function (element, opts) {
    var $element = this.$element = $(element);
    this.opts = opts;
    this.event_ajax=  $element.data("event-ajax") ? $element.data("event-ajax") : "click" ;
    this.url_ajax=  $element.data("url-ajax") ? $element.data("url-ajax") :  ( $element.is("a") ?  $element.attr("href")  : "" )   ;
    this.msg_status= $element.data("msg-status-ajax") != undefined  ? $element.data("msg-status-ajax") :true ;
    this.confirm_ajax= $element.data("confirm-ajax") ? $element.data("confirm-ajax") :false;
    this.param= $element.data("param-ajax") ? $element.data("param-ajax") : "" ;

    this.bindEvents();
   
  }, ajaxrequest = ajaxRequest.prototype;

  ajaxRequest.defaults = {

  };

  
  ajaxrequest.bindEvents= function (){
    var self=this;
    this.$element.on(this.event_ajax, $.proxy(this.on_event,this)  );

  

 };

 ajaxrequest.on_event=function (event){
    event.preventDefault();
    var self=this;
    if(self.confirm_ajax){
      if(!confirm("¿Seguro que desea realizar esta acción ?")){
          return false;
      }

    }
     self.$element.prop("disabled",true);

     if(self.$element.data("tooltip")){
        self.$element.tooltip("hide") ;
     }

    self.$element.trigger("init-ajax");  
    var url= self.$element.data("url-change") ? self.$element.data("url-change"):this.url_ajax ,
            param= self.$element.data("param-ajax") ? self.$element.data("param-ajax") : "",
            time=new Date();

    $.ajax({dataType:"json",url:url+ "?time"+ time.getTime(),
            data:param,
            type:"POST",
            beforeSend: function (){   self.$element.trigger("before-ajax.ajaxrequest");    }
            }).always(function (data){  self.$element.prop("disabled",false);    self.$element.trigger("always-ajax.ajaxrequest");     }).
        done(function (data) {   
        if(self.msg_status){
          var $fs=self.$element.closest("form");
          create_alert_ajax($fs,"sucess",data);
        }
        self.$element.trigger("done-ajax.ajaxrequest",data);
     
      }). fail(function(xhr, textStatus) {             
            if(self.msg_status){
              create_alert_ajax(self.$element.closest("form"),"error",$.parseJSON(xhr.responseText));
            }
            self.$element.trigger("error-ajax.ajaxrequest");   

          }     ) ;


 }

  $.fn.ajaxrequest = function (opts) {
    opts = $.extend({}, ajaxRequest.defaults, opts);

    return this.each(function (index) {

      var $this = $(this)
        , data = $this.data('ajaxrequest')
        , options = $.extend({}, $.fn.ajaxrequest.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('ajaxrequest', (data = new ajaxRequest(this, options)))
      if (typeof option == 'string') data[option]()
    });
  };

  $.component('ajaxrequest');
})(jQuery);