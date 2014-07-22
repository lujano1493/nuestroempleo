(function (w, $, undefined) {
  "use strict";  		
        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//platform.linkedin.com/in.js";
        js.innerHTML="lang: es_ES-";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'linkedin-platform'));

})(window, jQuery);