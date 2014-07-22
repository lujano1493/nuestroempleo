(function ($, undefined) {
  'use strict';
  $(document).on("success.ajaxlink","[data-type*=elementreplece]",function(event,data){
  		var $el=$(this), results=data.results,
  		target= $el.data("target") || results.target,info=results.data;
  		var html_tmpl=$.template(target,info);
  		$el.html(html_tmpl);  	
  });
})(jQuery);