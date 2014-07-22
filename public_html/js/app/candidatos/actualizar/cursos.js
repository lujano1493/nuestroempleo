
/* cursos.js*/
$(document).ready (function ($){



	

config_template(".cursos" ,
			function (form){
					$(form).find(".cursotipo_cve").rules("add",
						{
						required: true,					
							messages: {
								required:  "Selecciona opción"
							}});

					$(form).find(".curso_institucion").rules("add",
						{
						required: true,					
							messages: {
								required:  "Ingresa nombre de la institución"
						}});
					$(form).find(".curso_nom").rules("add",
						{
						required: true,					
							messages: {
								required:  "Ingresa nombre del curso"
						}});
					
			

					config_calendar_form(form);

				});

		initConfigValidation(".cursos");


});