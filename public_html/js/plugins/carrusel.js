(function ($, undefined) {
  "use strict";
  /**
    * Carrusel
    */
  
  var arr_class_container={bxslider:"bxslider",flexslider:"slides" };
  var Carrusel = function (div, opts) {
    var $div = this.$div = $(div);
    var url=this.url=$div.data("url")||"",
        content_type=this.content_type=$div.data("content-type") || 'html',
        template_id=this.template_id=$div.data("template-id")|| "#",
        direction=this.direction=$div.data("direction")||'horizontal',
        type=this.type=$div.data("type") || "flexslider",
        num_item_display=this.num_item_display=$div.data("num-item-display")|| 2,
        disabled_direction_nav=this.disabled_direction_nav=$div.data("disabled-direction-nav")|| false,   
        paginate = this.paginate= $div.data("paginate")  || false,
        params=$div.data("params-ini")||[],limit=this.limit=$div.data("limit")||200,
        offset=this.offset=0,is_ajax=this.is_ajax=$div.data("isajax") || false ;
        this.params= params.length == 1 ? params[0]: {};
    this.contain_class=arr_class_container[type];
    this.opts = opts;
    this.init($div);   
  }, carrusel = Carrusel.prototype;

  carrusel.init= function ($div){
    var self=this,arr_init={
          bxslider:self.bxslider_init,
          flexslider:self.flexslider_init,
          jscarousel: self.jsCarousel_init
    };
    self.$div.addClass("cargando");
    var carrusel_f= arr_init[self.type];    
    if(self.is_ajax){
        self.load_ajax(carrusel_f);
    }
    else{
      carrusel_f.apply(this);
    }

  };
  carrusel.get_json=function (callback){
      callback=callback||function(){};
      var self=this,$div=self.$div,params=self.params;
      if(self.paginate){
        params.iDisplayStart=self.offset;
        params.iDisplayLength=self.limit;
      }
      params.paginate=self.paginate;        
      $.getJSON(self.url,params, function(json, textStatus) { 
        var list=[],aux="";

        if(self.paginate){
          self.total=json.iTotalDisplayRecords;
          self.offset=  self.offset +json.iTotalRecords;
        }
        $(json.results).each(function (index,element){
          aux+=$.template(self.template_id, element);   
          if(  (index+1)% self.num_item_display ===0 ) {
            list.push("<li class='row-fluid'>" +aux+"</li>");
            aux="";
          }                    
        });
        if(aux!=""){
          list.push("<li class='row-fluid'>" +aux+"</li>");
        }      
       callback(list);
      });
  };
  carrusel.load_ajax= function (callback){
    callback= callback || function (){};
    var self=this,class_type="." + this.type,$div=self.$div,
        $content=$div.find(class_type);
    $div.spin("large");
    var self=this,f_v={
          html:function (callback){
            $div.find(class_type).load(self.url +"?time"+ (new Date().getTime()) , 
                function (responseText, textStatus, XMLHttpRequest) {   
                $div.spin(false);               
                callback.apply(self);
            });
          },

          json:function(callback){       
            self.get_json(function (list){
                  var html_content="",list_length=list.length;
                  for(var i=0;i<list_length;i++){
                    html_content+=list[i];
                  }
                  $("<ul class='"+self.contain_class+"'> </ul>").append(html_content).appendTo($content);      
                  if(html_content=="") $div.hide(); else $div.show();                       
                  callback.apply(self);  
                });    

          }
    };
    f_v[self.content_type](callback);
  };

  function debuggear($div){
    $div.spin(false);   
    $div.removeClass("cargando");  
    $div.find(".flexslider").removeClass("flexslider");

  }
  carrusel.bxslider_init=function(callback){
    var $div=this.$div;
    $div.spin('large');
     $div.find('.bxslider').bxSlider({ 
        auto: true,        
        pager:false,
        controls:false,
        pause: 10000,
        onSliderLoad:function (){
            $div.spin(false);
        }
    }).show("fade",500);
  };
  carrusel.flexslider_init=function (callback){
      var self=this,$div=this.$div;                     
     $.flexslider($div.find(".flexslider"),{
            animation: "slide",       
            direction:  self.direction, 
            controlNav: false,       
            slideshow: false,
            animationLoop: false,
            directionNav: !self.disabled_direction_nav,
            start: function(slider){       
                $div.spin(false);   
                $div.removeClass("cargando");                                 
                slider.mouseleave(function() {
                    slider.play();
                });
                slider.mouseenter(function() {
                     slider.pause();
                });              
            },
            end:function(slider){
                if(self.offset >= self.total || !self.paginate  ) 
                  return;
                if(!self.ajax_process){
                  self.ajax_process=true;
                  self.get_json(function(list){                      
                    var list_length=list.length;
                    for(var i=0;i<list_length;i++){
                      slider.addSlide(list[i]);   
                    }
                    self.ajax_process=false;                 
                  });
                }
            }
           });

  };


  Carrusel.defaults = {  
  };
    $.fn.carrusel = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('carrusel')
        , options = $.extend({}, $.fn.carrusel.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('carrusel', (data = new Carrusel(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };
  

  $.component('carrusel');
})(jQuery);
