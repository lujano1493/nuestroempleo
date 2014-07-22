(function ($, undefined) {
  "use strict";
  var OptimizePaginate = function ($table) {
    var oCache = this.oCache = {
      iCacheLower: -1,
      lastRequest:[]
    };

    this.$table = $table || $("#");
  }, optimizepag = OptimizePaginate.prototype;

  optimizepag.fnSetKey = function (aoData, sKey, mValue) {
    for (var i=0, iLen = aoData.length; i < iLen; i++) {
      if (aoData[i].name === sKey) {
        aoData[i].value = mValue;
      }
    }
  };
  optimizepag.fnGetKey = function (aoData, sKey) {
    for (var i = 0, iLen = aoData.length; i < iLen; i++) {
      if (aoData[i].name === sKey) {
        return aoData[i].value;
      }
    }
    return null;
  };

  /* script para disminuir el numero de peticiones al servidor*/
  optimizepag.fnDataTablesPipeline = function (sSource, aoData, fnCallback) {
    var self = this
      , iPipe = 5 /* Ajust the pipe size */
      , bNeedServer = false
      , sEcho = self.fnGetKey(aoData, 'sEcho')
      , iRequestStart = self.fnGetKey(aoData, 'iDisplayStart')
      , iRequestLength = self.fnGetKey(aoData, 'iDisplayLength')
      , iRequestEnd = iRequestStart + iRequestLength;

    self.oCache.iDisplayStart = iRequestStart;

    /* outside pipeline? */
    if (self.oCache.iCacheLower < 0 || iRequestStart < self.oCache.iCacheLower ||
      iRequestEnd > self.oCache.iCacheUpper || aoData.length !== self.oCache.lastRequest.length) {
      bNeedServer = true;
    }

    /* sorting etc changed? */
    if (self.oCache.lastRequest && !bNeedServer) {
      for (var i = 0, iLen = aoData.length; i < iLen; i++) {
        if (aoData[i].name !== "iDisplayStart" && aoData[i].name !== "iDisplayLength" && aoData[i].name !== "sEcho") {
          if (aoData[i].value !== self.oCache.lastRequest[i].value) {
            bNeedServer = true;
            break;
          }
        }
      }
    }

    /* Store the request for checking next time around */
    self.oCache.lastRequest = aoData.slice();

    if (bNeedServer) {
      if (iRequestStart < self.oCache.iCacheLower) {
        iRequestStart = iRequestStart - (iRequestLength * (iPipe - 1));
        if (iRequestStart < 0) {
          iRequestStart = 0;
        }
      }
      self.oCache.iCacheLower = iRequestStart;
      self.oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
      self.oCache.iDisplayLength = self.fnGetKey(aoData, "iDisplayLength");
      self.fnSetKey(aoData, "iDisplayStart", iRequestStart);
      self.fnSetKey(aoData, "iDisplayLength", iRequestLength * iPipe);       
      var $parent= self.$table.closest('div');
      $parent.data("type-wait",'label');
      $parent.trigger("create-background-wait.ajax");
      $.getJSON(sSource, aoData, function (json) {

        if(json.is_empty){
           $("#result-empty-msg").css("display","block");
           $("#desplegables").hide();
        }
        /* Callback processing */
        self.oCache.lastJson = $.extend(true, {}, json);

        if (self.oCache.iCacheLower !== self.oCache.iDisplayStart) {
          json.results.splice(0, self.oCache.iDisplayStart-self.oCache.iCacheLower);
        }
        json.results.splice(self.oCache.iDisplayLength, json.results.length);

        fnCallback(json);
        self.$table.fnClearTable(true);
        $parent.trigger("remove-background-wait.ajax");
      });
    } else {
      var json = $.extend(true, {}, self.oCache.lastJson);
      json.sEcho = sEcho; /* Update the echo for each response */
      json.results.splice(0, iRequestStart-self.oCache.iCacheLower);
      json.results.splice(iRequestLength, json.results.length);
      fnCallback(json);
      return;
    }
  };


   $.fn.optimizepag = function (option) {    	
    		return new OptimizePaginate(this);
  }; 




})(jQuery);
