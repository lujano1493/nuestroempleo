

 $("#encuesta-ref01").on("success.ajaxform",function (event,data ){  
 	$("#btn_hide_gracias").trigger("click");  
 });

$(document).ready(function ($){

	$("#encuesta-ref01").ajaxform({ validate: function ($form){
				
				var size_preguntas=$form.data("size-preguntas");

				for (i=0;i<size_preguntas;i++){
					var input_checked= $form.find("[name*='["+i+"][respuesta_cve]']:checked");
					if(input_checked.length==0){						
						alert("Debe completar el formulario antes de enviarlo");
						var div_=$form.find("[name*='["+i+"][respuesta_cve]']").closest("div.sesion-pregunta");
						$('html, body').animate({ scrollTop: div_.offset().top }, 'slow');
						return false;
					}

				}

				return true;

	}  });




});



