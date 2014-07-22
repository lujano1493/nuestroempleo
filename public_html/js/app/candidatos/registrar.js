//   function showLightbox() {
//   document.getElementById('over').style.display='block';
//   document.getElementById('fade').style.display='block';
//   iniciar_registra_candidato('.formulario');
//    $('#registro-candidato01 .refresh-captcha-image').trigger('click');
// }
//  function iniciar_registra_candidato(name_class_){
//    var $div=$(name_class_);
//    $div.find('input[name= \'data[Candidato][terminos]\']').prop('checked',false);

// }
//  function hideLightbox() {
//   document.getElementById('over').style.display='none';
//   document.getElementById('fade').style.display='none';
//   ocultar_registra_candidato('.formulario');
// }
//  function ocultar_registra_candidato(name_class_){
//  var $div=$(name_class_);
//  $div.find('form').css({'display':'block'});
//  $div.find('.info_after').css({'display':'none'});
// }

/*login*/

$(document).ready(function($) {
	'use strict';
	/**
	 * Solución temporal. 2014-02-17 11:07:01 UTC
	 */
	// $('#modal-nuevo-form-candidato01').on('show',function (event) {
	//	$(this).find('input[name= \'data[Candidato][terminos]\']').prop('checked',false);
	// });

	$('#login_form_candidato').validate({
		focusInvalid: true,
		onkeyup: false,
		errorElement: 'div',
		wrapper: 'div',
		errorPlacement:function (error,element) {
			var alert = $('.login_validation_error').find('.alert-error');

			if (alert.length === 0) {
				$('.login_validation_error').append($('<div class=\'alert alert-error fade in popup\'></div>'));
				alert = $('.login_validation_error').find('.alert-error');
				alert.append($('<a class=\'close\' data-dismiss=\'alert\' href=\'#\' >&times;</a> '));
			}
			alert.append(error);
		},
		showErrors: function (errorMap, errorList) {
			this.defaultShowErrors();
			if (this.errorList.length === 0 ) {
				$('.login_validation_error').empty();
			}
		}

	});

});



