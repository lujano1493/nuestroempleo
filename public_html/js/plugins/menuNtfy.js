(function ($, undefined) {
  'use strict';

  /**
    * menuNtfy
    */
   
    var defaults_options_popover={
                    trigger:'hover',
                    placement:'left',
                    container:'body',
                    delay: { show: 500, hide: 100 },
                    html:true
    };
    var create_popover= function(select,data){
        var options= $.extend({},defaults_options_popover,data);      
        options.title= " <div class='ntfy-title'>"+options.title+"</div>";
        select.popover(options).popover('show');
    };
     var callback= {
       "ntfy_to_candidato": function (data){

              var ntfy=data.data,totales=data.totales,name_select_type={
                    "mensaje":"mensaje",
                    "evaluacion":"notificacion",
                    "evento":"evento",
                    "notificacion":"notificacion"
              },name_type=name_select_type[ntfy.tipo];
              ntfy.cia_cve=data.from.cia_cve;     
              ntfy.logo=data.from.logo;       
              $(".ntfy-"+name_type).each(function (){
                  var $this=$(this);
                  var total= totales ? totales[name_type] : $this.find(".ntfy-total").html();   
                   total= !totales ? (+total)+1:total;
                  $this.find(".ntfy-total").html(total);
                  $this.find("ul").prepend($.template("#tmpl-can-"+name_type,ntfy));
              });
       },
       "ntfy_to_empresa":function (data){
          var ntfy=data.data,from=data.from,totales=data.totales;
          $(".ntfy-empresa").each(function (){
              var $this=$(this);
              $this.find(".ntfy-total").html(totales.notificacion);
              $this.find("ul").prepend($.template("#tmpl-emp-notificaciones",ntfy));
              var element=$this.find("ul li:first"), tipo=ntfy.tipo ,d={
                            notificacion_cve:ntfy.notificacion_cve,
                            notificacion_texto:ntfy.notificacion_texto,
                            fecha:ntfy.created,
                            nombre:from.nombre,
                            email:from.email
              },tmp_popover=$.template("#tmpl-emp-"+tipo,d);
              create_popover(element,{
                                        title:ntfy.notificacion_titulo,
                                        content:tmp_popover
                });






          });              
       }
  };


  var menuNtfy = function (el, opts) {
    var $el = this.$el = $(el),
        type=this.type = $el.data("ntfy-type") ||"notificacion" ;

    this.init();
  }, menuntfy = menuNtfy.prototype;

  menuNtfy.defaults = {

  };
  menuntfy.init=function (){
    this.$el.find("[data-popover]").each(function (index,ele){
        var $this=$(this),data_popover=$this.data("popover")||[];
        if(data_popover.length==0)
          return true;
       create_popover($this,data_popover[0]);

    });



  };
  menuntfy.redirect = function (url) {
    if (url) {
      window.location.href = url;
    }
  };


  menuntfy.leido = function (extraData,callback) {
    callback =callback ||function (){};
    var self=this;
    var data = extraData ||{};
    $.ajax({
      type  : 'GET',
      dataType: 'json',
      url   : '/notificaciones/leido',
      data  :data,
      beforeSend: function (xhr){

      }
    })
    .done(function (data, textStatus, jqXHR){
        var totales=data.results;
        self.$el.trigger("success.menuntfy");
        self.$el.find(".ntfy-total").html(totales[self.type]);
        callback();
        self.redirect(data.redirect);              
    })
    .fail(function (jqXHR, textStatus, errorThrown) {})
    .always(function(data, textStatus, jqXHR){

    });
  };



  $.fn.menuntfy = function (opts, args) {
    var options = 'object' === typeof opts && $.extend({}, menuNtfy.defaults, opts);

    return this.each(function (index) {
      var $this = $(this)
        , menuntfy = $this.data('menuntfy');

      if (!menuntfy) {
        $this.data('menuntfy', (menuntfy = new menuNtfy(this, options)));
      }

      if ('string' === typeof opts) {
        menuntfy[opts].apply(menuntfy, args || []);
      }
    });
  };



  $(document).on("receiver-ntfy.ntfy",function (event,data){
    callback['ntfy_to_'+data.data['para_tipo']](data);
  });
 
  $(document).on("click",".ntfy-link", function(event) {
      event.preventDefault();
      var $this=$(this),menuntfy=$this.closest('[data-component*=menuntfy]').data("menuntfy");
      if(menuntfy){

          var id=$this.data("id"),data= {
                        id: id,
                        redirect:$this.attr("href")
          }

          menuntfy.leido(data, function (){
                $this.removeClass('no-leido');
                var t= $("a[data-id="+id+"].link-historial");
                 t.closest('.element').find(".no-leido").hide("fast");                 
          });
      }


  });
  // $(document.body).on('click', '[data-submit]', function (event) {
  //   var $this = $(this)
  //     , $el = $this.closest('form')
  //     , data = $this.data();

  //   if (data.submit) {
  //     $form.menuntfy('submit', [event, data]);
  //   }

  //   return false;
  // });

    $.component("menuntfy");
})(jQuery);