




$(document).ready(function(e) {
		$(function(){
		//$("#div_radio_genero").buttonset();
		
		
							  
							  
		
			sts_inicial('domicilio');
			
        	var element_validar= { rules: {
				
				"data[Direccion][DirPersona][dirper_callenum]":{required:true},
				"data[Direccion][CodigoPostal][cp_asentamiento]":{required:true,valida_cp:true},
				"data[Direccion][DirPersona][dirper_numext]":{required:true,digits:true},
				"data[Direccion][DirPersona][dirper_numint]":{digits:true},
				"data[Direccion][DirPersona][dirper_tel]":{required:true,digits:true},
				"data[Direccion][DirPersona][dirper_movil]":{required:true,digits:true}
           },
       	messages: {
			
			"data[Direccion][DirPersona][dirper_callenum]":{required:"Ingresa Calle"},
			"data[Direccion][CodigoPostal][cp_asentamiento]":{required:"Selecciona Opción",valida_cp:"Elige una colonia"},
			"data[Direccion][DirPersona][dirper_numext]":{required:"Ingresa número exterior",digits:"Ingresa sólo números"},
			"data[Direccion][DirPersona][dirper_numint]":{digits:"Ingresa sólo números"},
			"data[Direccion][DirPersona][dirper_tel]":{required:"Ingresa número teléfonico",digits:"Ingresa sólo números"},
			"data[Direccion][DirPersona][dirper_movil]":{required:"Ingresa número teléfonico móvil",digits:"Ingresa sólo números"}
			
		   
       	}};
	   	configure_validation(document.getElementById("config_form_domicilio"),element_validar);	
			
		});
	
	
        });

		
		




		