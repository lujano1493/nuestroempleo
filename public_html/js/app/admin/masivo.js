$(function ($){
  'use strict';
	function checarFormato(value,formatos){
		var data=formatos.split("|");
		return  $.inArray(value,data) > -1 ;

	}
  	var $input_file=$("#masivo"),$form=$input_file.closest('form'),$submit=$form.find("[type='submit']");
   	$input_file.fileupload({
             dataType: 'json',              
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
             url: $form.attr("action"),               
            start: function (e){              
                $form.find(".progress-barcito").show('fade').addClass("active");
            },
            stop: function (e){          
              $form.find(".progress-barcito").removeClass("active");
              setTimeout(function (){   
                         $form.find(".progress-barcito").hide('fade',500,function (){
                          $form.find(".bar").css("width","0%");
                        }); },500);
            },

            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
              $form.find(".progress .bar").css('width',progress + '%');      
            }, 
            send: function (e, data) {

            },

            add: function (e, data) {
                  var start_p= data.files[0].name.lastIndexOf( "." ), type_data=data.files[0].name.substring(start_p+1).toLowerCase();

                  if(start_p < 0 ){
                      alert("¡Verifica la extensión del archivo!");
                      return;
                  }
      				data.submit();                      
                  // if(checarFormato(type_data, data.form.find(".type").val())){
                  //   data.form.find(".info").val(data.files[0].name);                                      
                  //   if(!$submit.prop("disabled") ){
                  //   	$submit.prop("disabled",true);
                  
                  //   }                  
                  
                  // }                  
                  // else{
                  //     alert("¡Formato de archivo no valido!");                    
                  // }
                                    
            },

            done: function (e, data) {                
               var result =data.result;
               console.log(result);  
               $submit.prop("disabled",false);
          }
        });


});