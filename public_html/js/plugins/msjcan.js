
(function ($, undefined) {
  "use selementict";
  var callbacks={
              deleteRow:function (event,id,stat){
                      var $msg_t= $(".msg-menu .msg-total"),
                          $msg_e=$(".msg-menu .msg-eliminados"),
                          $msg_i=$(".msg-menu .msg-importantes"),
                          $msg_envi=$(".msg-menu .msg-enviados");        
                          $msg_t.html(stat.recibidos);         
                          $msg_e.html(stat.eliminados);   
                          $msg_i.html(stat.importantes);  
                          $msg_envi.html(stat.enviados);                        
               }


 };
    $("#mensajes-table").on('success.ajaxlink', function (event, data) {    
        if (data.callback) {
          var fn = callbacks[data.callback.fn]
            , args = data.callback.args || [];
              args=args.slice();
              args.unshift(event);
          fn && fn.apply(this, args);
        }
    });
  



})(jQuery);
