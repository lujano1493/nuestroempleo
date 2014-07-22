(function ($, undefined) {
  "use strict";
  /**
    * autocomplete
    */


    var autoComplete = function (input, opts) {       
       		
       		this.init(input);


  }, autocomplete = autoComplete.prototype;


  function split( val ) {
      return val.split( /,\s*/ );
    };
    function extractLast( term ) {
      return split( term ).pop();
    };
 


  autocomplete.init = function (input){  		



  	  $( input )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        source: function( request, response ) {
          $.getJSON( "BusquedaOferta/autocomplete", {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });




  };

  autocomplete.defaults = {  
  };

  

    $.fn.autocomplete = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('autocomplete')
        , options = $.extend({}, $.fn.autocomplete.defaults, $this.data(), typeof option == 'object' && option)
      if (!data) $this.data('autocomplete', (data = new autocomplete(this, options)))
      if (typeof option == 'string') data[option]()
      //else if ( typeof option =='object') data.show()
    })
  };



     $.component('autocomplete');
   })(JQuery);