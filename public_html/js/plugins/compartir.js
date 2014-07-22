(function ($, undefined) {
  "use strict";
  
    var button_options= {  //settings for buttons
      googlePlus : {  //http://www.google.com/webmasters/+1/button/
        url: '',  //if you need to personnalize button url
        urlCount: false,  //if you want to use personnalize button url on global counter
        size: 'medium',
        lang: 'es-ES',
        annotation: ''
      },
      facebook: { //http://developers.facebook.com/docs/reference/plugins/like/
        url: '',  //if you need to personalize url button
        urlCount: false,  //if you want to use personnalize button url on global counter
        action: 'like',
        layout: 'button_count',
        width: '',
        send: 'false',
        faces: 'false',
        colorscheme: '',
        font: '',
        lang: 'es_Es'
      },
      twitter: {  //http://twitter.com/about/resources/tweetbutton
        url: '',  //if you need to personalize url button
        urlCount: false,  //if you want to use personnalize button url on global counter
        count: 'horizontal',
        hashtags: '',
        via: '',
        related: '',
        lang: 'es'
      },
      digg: { //http://about.digg.com/downloads/button/smart
        url: '',  //if you need to personalize url button
        urlCount: false,  //if you want to use personnalize button url on global counter
        type: 'DiggCompact'
      },
      delicious: {
        url: '',  //if you need to personalize url button
        urlCount: false,  //if you want to use personnalize button url on global counter
        size: 'medium' //medium or tall
      },
      stumbleupon: {  //http://www.stumbleupon.com/badges/
        url: '',  //if you need to personalize url button
        urlCount: false,  //if you want to use personnalize button url on global counter
        layout: '1'
      },
      linkedin: {  //http://developer.linkedin.com/plugins/share-button
        url: '',  //if you need to personalize url button
        urlCount: false,  //if you want to use personnalize button url on global counter
        counter: ''
      },
      pinterest: { //http://pinterest.com/about/goodies/
        url: '',  //if you need to personalize url button
        media: '',
        description: '',
        layout: 'horizontal'
      }
    };  
    
  var socialElement = function (el, opts) {
    var $el=this.$el=$(el),href=this.href=$el.data("href")|| document.location,
        template=this.template=  $.template($el.data("template-id"),{}) || '',
        show_button= this.show_button=$el.data("show-button") ||false ;
    this.init();
   
  }, socialelement = socialElement.prototype;

  socialElement.defaults = {
    
  };
  socialelement.init= function (){
    var self=this,$el=self.$el;
        $el.sharrre({
          share: {
             googlePlus:true,
            facebook: true,
            twitter: false,
             linkedin:true
          },
          template:self.template,
          enableHover: self.show_button,
          render: function(api, options){
            $(api.element).on('click', '.twitter', function(event) {
              event.preventDefault();
              api.openPopup('twitter');
            });
            $(api.element).on('click', '.facebook', function() {
              event.preventDefault();
              api.openPopup('facebook');
            });
            $(api.element).on('click', '.googleplus', function() {
              event.preventDefault();
              api.openPopup('googlePlus');
            });
             $(api.element).on('click', '.linkedin', function() {
              event.preventDefault();
              api.openPopup('linkedin');
            });
          },
          url: self.href,
          urlCurl:"/informacion/sharrre"
        });
 };

  $.fn.socialelement = function (opts) {
    opts = $.extend({}, socialElement.defaults, opts);

    return this.each(function (index) {

      var $this = $(this)
        , data = $this.data('socialelement')
        , options = $.extend({}, $.fn.socialelement.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('socialelement', (data = new socialElement(this, options)))
      if (typeof option == 'string') data[option]()
    });
  };

  $.component('socialelement');
})(jQuery);