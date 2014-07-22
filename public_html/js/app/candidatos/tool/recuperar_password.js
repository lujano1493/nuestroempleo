
/*
$(function (){
	$(document).ready(function($) {
			configure_validation("#recuperar_contrasena_candidato_form",
					{
				 rules: {
				"data[CandidatoUsuario][cc_email]":{required:true,email:true},
				"data[Candidato][codigo]":{required:true,captcha:true}
           },
		   	 messages: {
		   	"data[CandidatoUsuario][cc_email]":{required:'ingrese correo electronico.',email:'correo electronico inválido.'},
			
			"data[Candidato][codigo]":{required:'ingrese c&oacute;digo.',captcha:'el c&oacute;digo no es valido.'}		
       		}

				});

			$(document).on("click",".recuperar",function (event){
					event.preventDefault();
					var  $this=$(this),$div=$this.closest(".formulario");
					var height=$div.height();
					var petition={field:this,url:"../Candidato/recuperar_password",callback_ok:function (){
									$div.find(".input_data").hide("clip",500,function (data){
												$div.find(".registro_completo").height(height).show("clip",500,function (){});	
											});
						
					}};
					ajax_request_(petition);

			});

	});


});*/