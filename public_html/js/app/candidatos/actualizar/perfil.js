function config_validation_edit_perfil(field){
		var element_validar={
				 rules: {
         		"data[Candidato][candidato_nom]":{required:true},
				"data[Candidato][candidato_pat]":{required:true},
				"data[Candidato][candidato_fecnac]":{required:true},

		   		"data[Candidato][candidato_perfil]":{required:true},
				"data[DirCandidato][CodigoPostal][cp_asentamiento]":{required:true,asentamiento:true},
				"data[Candidato][candidato_movil]":{required:true,digits:true},
				"data[Candidato][candidato_tel]":{digits:true}
		   
           },
		   	 messages: {
			"data[Candidato][candidato_nom]":{required: 'Ingresa nombre'},
			"data[Candidato][candidato_pat]":{required: 'Ingresa apellido'},
			"data[Candidato][candidato_fecnac]":{required: 'Ingresa fecha de nacimiento'},
		   	"data[Candidato][candidato_perfil]":{required:'Ingresa un título a tu perfil'},
			"data[DirCandidato][CodigoPostal][cp_asentamiento]":{required:"Selecciona una colonia",asentamiento:"Selecciona una colonia"},
			"data[Candidato][candidato_movil]":{required:"Ingresa un número de teléfono celular",digits:"Verifica el número de teléfono"},
			"data[Candidato][candidato_tel]":{digits:"Verifique el número teléfonico"}
       		}};
			
			configure_validation(field,element_validar);		

	
	
}




/*guardar perfil general primera vez*/

$(document).on("click",".guardar_perfil_general",function (event){
		event.preventDefault();			
			var  $this=$(this),$formito=$(".form_"),$form=$formito.find("form"),vista="Candidato",params=$form.serialize();

			var request={
				$this:$this,params:params,$div:$formito,url:"../Candidato/guardar_primera",
				callback_complete:function (){
					remove_background_wait($formito);
					$this.closest(".control").find("button").prop("disabled",true);	

				},callback_ok:function (data){
					var $status=$this.closest(".control").find(".status");
					$status.append(create_alert('success',data[0].msg));								
					$("#msg_block").removeClass("alert-block").addClass("alert-success").find("h4").text("Registro Rápido Completo").focus();
				},callback_before:function (){
					create_background_wait($formito);

				}
			};
			ajax_request_(request);

});



	
$(document).ready(function(e) {
		$(function(){					
			create_calendar_default("#candidato_fecnac_edit");

			$("#form_candidato_edit").each(function (){
				$form=$(this);
				$form.validate();

			});
			 //config_validation_edit_perfil(document.getElementById("config_form_edita_perfil_candidato"));



			 loadFoto();
		});




	/*mostrar y ocultar botones de  guardar*/

	$(document).on("focusin mouseenter",".formulario, .work_area",function(event){
			event.preventDefault();
			$(this).find(".control").show("fade",500);
			if(event.type=="focusin"){
				$(this).data("focusin",true);
			}

	});

	$(document).on("focusout mouseleave",".formulario, .work_area",function(event){
			event.preventDefault();			
			if(event.type=="focusout"){
				$(this).data("focusin",false);
			}
			if(!$(this).data("focusin")){
				$(this).find(".control").hide("fade",500);
			}
			

	});


		
});