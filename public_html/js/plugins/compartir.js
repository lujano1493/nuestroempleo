(function ($, undefined) {
  "use strict";
  var langs={
    facebook:'es_Es',
    twitter:'es',
    linkedin:'es',
    googleplus:'es-ES'
  };
  var popup = {
    facebook: function(opt){
      window.open("http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(opt.url)+"&t="+opt.text+"", "", "toolbar=0, status=0, width=900, height=500");
    },
    twitter: function(opt){
      window.open("https://twitter.com/intent/tweet?text="+encodeURIComponent(opt.text)+"&url="+encodeURIComponent( opt.url)+(opt.via !== '' ? '&via='+opt.via : ''), "", "toolbar=0, status=0, width=650, height=360");
    },
    linkedin: function(opt){
      window.open('https://www.linkedin.com/cws/share?url='+encodeURIComponent(opt.url)+'&token=&isFramed=true', 'linkedin', 'toolbar=no,width=550,height=550');
    },
    googleplus: function(opt){
      window.open("https://plus.google.com/share?hl="+opt.lang+"&url="+encodeURIComponent(opt.url), "", "toolbar=0, status=0, width=900, height=500");
    }
  };
  $(document).on("click","[data-network-social]",  function (event){
    event.preventDefault();
    var $this=$(this),options= $(this).data();
    if(!langs[options.networkSocial] ){
      return;
    }
    options.url= $this.attr("href") || options.url;
    options.lang= options.lang ||   langs[options.networkSocial] ;
    popup[options.networkSocial](options);
  });
})(jQuery);

