(function ($, undefined) {
  "use strict";
  /**
    * WaitProcess
    */
  var WaitProcess = function (div, opts) {

    this.init(div);
  }, waitprocess = WaitProcess.prototype;


  waitprocess.init= function(div){
    var $div=this.$div=$(div),
        type_wait=this.type_wait= $div.data('type-wait')|| 'default';
};

  waitprocess.create_wait=function (event){   
    var $div_wait=$('<div class="wait-block" style="display:none"></div>' ),$div=this.$div;    
      $div.addClass("relative");
      var width=$div.width(),height=$div.height();
      $div_wait.height(height).width(width);
      var options={config_extra:function(){}};
      if(this.type_wait=='default'){
        options=default_wait($div);  
      }
      else if(this.type_wait=='label'){
        options=label_wait($div);
      }    
    options.config_extra($div_wait);

    if(this.type_wait!=='block'){
      $div_wait.spin(options);
    }  
    $div.prepend($div_wait);
    $div_wait.show("fade",500);
  };

waitprocess.remove_wait=function (){
  var $div=this.$div;
  $div.find(".wait-block").hide("fade",500, function (){
              $div.removeClass("relative");
              $(this).remove();
          });
};



  function default_wait($div){
    var width=$div.width(),height=$div.height();
    var ration= height/width, 
     radio=20,
     line_tickness=10,
     length= ration > 1  ?  width/4 : height/4 ,
     top= (height/2) - (length+radio+line_tickness) ,         
     left= (width/2) - (length+radio+line_tickness) ;  
    return {
          lines: 15, // The number of lines to draw
          length:  length, // The length of each line
          width: line_tickness, // The line thickness
          radius: radio, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 0, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          color: '#5d9cc7', // #rgb or #rrggbb or array of colors
          speed: 1, // Rounds per second
          trail: 60, // Afterglow percentage
          shadow: false, // Whether to render a shadow
          hwaccel: true, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          top:    top, // Top position relative to parent in px
          left:   left,  // Left position relative to parent in px
          config_extra:function($div_wait){}

    };

  }
  function label_wait($div){
  var width=$div.width(),height=$div.height();
   return {
          lines: 15, // The number of lines to draw
          length:  8, // The length of each line
          width: 4, // The line thickness
          radius: 10, // The radius of the inner circle
          corners: 1, // Corner roundness (0..1)
          rotate: 0, // The rotation offset
          direction: 1, // 1: clockwise, -1: counterclockwise
          color: '#5d9cc7', // #rgb or #rrggbb or array of colors
          speed: 1, // Rounds per second
          trail: 60, // Afterglow percentage
          shadow: false, // Whether to render a shadow
          hwaccel: true, // Whether to use hardware acceleration
          className: 'spinner', // The CSS class to assign to the spinner
          zIndex: 2e9, // The z-index (defaults to 2000000000)
          top:    10, // Top position relative to parent in px
          left:   (width/2)-160,  // Left position relative to parent in px
          config_extra: function($div_wait){
            $div_wait.append('<h1>  Cargando ... </h1>');
          }

    };
  }




  WaitProcess.defaults = {  
  };


    $(document).on("create-background-wait.ajax ",function (event){
           $(event.target).waitprocess("create_wait");
    });

      $(document).on("remove-background-wait.ajax",function (event){
           $(event.target).waitprocess("remove_wait");
    });




  

    $.fn.waitprocess = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('waitprocess')
        , options = $.extend({}, $.fn.waitprocess.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('waitprocess', (data = new WaitProcess(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  }; 

})(jQuery);


