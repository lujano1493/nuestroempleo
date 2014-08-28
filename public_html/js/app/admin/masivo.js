$(function ($){
  'use strict';
	// function checarFormato(value,formatos){
	// 	var data=formatos.split('|');
	// 	return  $.inArray(value,data) > -1 ;

	// }
  	var $inputFile=$('#masivo'),$form=$inputFile.closest('form'),$submit=$form.find('[type=\'submit\']');

   
   	$inputFile.fileupload({
             dataType: 'json',              
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
             url: $form.attr('action'),               
            start: function (e){              
                $form.find('.progress-barcito').show('fade').addClass('active');
            },
            stop: function (e){          
              $form.find('.progress-barcito').removeClass('active');
              setTimeout(function (){   
                         $form.find('.progress-barcito').hide('fade',500,function (){
                          $form.find('.bar').css('width','0%');
                        }); },500);
            },

            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
              $form.find('.progress .bar').css('width',progress + '%');      
            }, 
            send: function (e, data) {
                $submit.append('<i class=\'icon-spinner icon-spin\'></i>')
                .addClass('disabled spinner')
                .prop('disabled', 'disabled');
            },

            add: function (e, data) {              
              $form.find('.info').val(data.files[0].name); 
              $submit.prop('disabled',false);             
              $submit.off('click').on('click',function (){
                  data.submit();      
              });      			                                       
            },

            done: function (e, data) {                
               var results =data.result.results;
               console.log(results);  
                results.url && (window.location =results.url);
               $submit.prop('disabled',false);
          },fail: function (e, data) {
            var results= $.parseJSON(data.jqXHR.responseText);
            results.message && $('.alerts-container').alerto('show', results.message,7000);

          },always: function (e,data){
            $submit.removeClass('disabled spinner')
            .prop('disabled', false)
            .find('.icon-spin').remove();
          }
        });


});