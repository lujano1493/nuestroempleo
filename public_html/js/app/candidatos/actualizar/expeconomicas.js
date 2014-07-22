


function config_validation_edit_ecoexp(field){
		var element_validar={
				 rules: {
         		"data[ExpEcoCan][expeco_tipoe]":{required:true},
				"data[ExpEcoCan][explab_sa]":{required:true,expresion:number_positive},
				"data[ExpEcoCan][explab_sd]":{required:true,expresion:number_positive,compare:{type:"number",element:".explab_sa",compare:">="}},
		   		"data[ExpEcoCan][explab_viajar]":{required:true},
		   		"data[ExpEcoCan][explab_reu]":{required:true}
           },
		   	 messages: {
			"data[ExpEcoCan][expeco_tipoe]":{required: 'Selecciona una opción'},
			"data[ExpEcoCan][explab_sa]":{required: 'Ingresa sueldo actual',expresion:"Sueldo no válido"},
			"data[ExpEcoCan][explab_sd]":{required:"Ingresa sueldo deseado",expresion:"Sueldo no válido",mayor:"El sueldo deseado debe ser mayor que el actual"},
			"data[ExpEcoCan][explab_viajar]":{required:"Selecciona una opción"},
			"data[ExpEcoCan][explab_reu]":{required:"Selecciona una opción"}	
       		}};

			configure_validation(field,element_validar);		
	
	
}



$(document).ready(function(e) {
		$(function(){					

			 config_validation_edit_ecoexp(document.getElementById("config_validation_edit_ecoexp"));


		});


		$(document).on("click",".guardar",function(){
			

		});
});