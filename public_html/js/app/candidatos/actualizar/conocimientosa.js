
/* conocimientosa.js*/
$(document).ready (function ($){

	

/*conocimientosa.js */
	config_template(".conocimientosa" ,
			function (form){
					$(form).find(".conoc_descrip").rules("add",
						{
						required: true,					
							messages: {
								required:  "Ingresa una breve descripción"
							}});
				
						

				});
		initConfigValidation(".conocimientosa");


});