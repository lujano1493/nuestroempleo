(function ($, undefined) {
  "use strict";
  /**
    * CommentCan
    */
  var CommentCan = function (div, opts) {

    this.init(div);
  }, comentcan = CommentCan.prototype;


  comentcan.init= function(div){

    var $div=this.$div=$(div),idOferta=this.idOferta=$("[name*='idOferta']").val(),
        $input_msj=this.$input_msj=$div.find(".mensaje-candidato"),
        $area=this.$area=$div.find(".area-comentarios");
    this.cargar_comentarios();
    this.bind();
  };

  comentcan.bind=function (){
    var self=this;
    this.$area.on("done-ajax.comment",$.proxy(self.done_comment,self));
    this.$area.on("before-ajax.comment",$.proxy(self.before_comment,self));
  };

  comentcan.done_comment=function (event){
      this.$input_msj.val("");

  };
  comentcan.before_comment=function(event){

  };


  comentcan.guarda_comentario= function(){
    if(this.$input_msj.val().length <4 ){
      return false;
    }

    var self=this,data={idOferta:self.idOferta,mensaje:self.$input_msj.val()};
    add_comment(data,"/PostulacionesCan/guarda_comentario",self.$area);


  };
 

   comentcan.cargar_comentarios= function(){
    var self=this,data={idOferta:self.idOferta};
    add_comment(data,"/PostulacionesCan/comentarios",self.$area);
  };


  CommentCan.defaults = {  
  };

    /*funciones  privada*/
   function add_comment (data,url,$area){

    var callback=function (data){
      $area.trigger("done-ajax.comment");
      for(var i=0;i<data.length;i++){
        var html= $.template("#tmpl-comentarios",data[i]);
        $area.append(html);

      }
    };
      $area.trigger("before-ajax.comment");    
    get_json(data,url,callback);
   };

  function get_json(data,url,callback){
    callback=callback || function(data){};
     $.getJSON(url, data, function(json, textStatus) {
       callback(json.results);
    });




  };


  

    $.fn.comentcan = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('comentcan')
        , options = $.extend({}, $.fn.comentcan.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('comentcan', (data = new CommentCan(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  }; 

  $(document).on("click",".enviar-comentario-candidato",function (event){
    event.preventDefault();
    var $btn=$(this),$div=$btn.closest("[data-component*='comentcan']");

    /*si no se ha inicializado el plugin para poder comentar se crea*/
    if(!$div.data('comentcan')){
        $div.comentcan({});
    }
    var comentcan= $div.data('comentcan');

    comentcan.guarda_comentario();
  }); 


  $.component("comentcan");
})(jQuery);


