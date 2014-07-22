$(document).ready(function(e) {
    $(function (){
		
		/*agregamos un nuevo metodo de validacion*/
		
			$.validator.addMethod("mayor", function(value, element) {
      			var value_= parseFloat( $(element).val());

				if(value_<2){
					return false;
				}
				return true;

      		},"La cantidad es menor a 2");
		
		
		
		$(document).on("click",".enviar_correo",function (event){
				  event.preventDefault();
				alert("enviar");
			
			
			});
		
		
		
		
		/*agregamos un bind para redimensionar nuestro campo de trabajo en experiencia laoboral*/
			$("#referencia_").resize(function (){
					var $this=$(this);
					if(!$this.is(":visible")){
						return;
					}
					var height=$this.parent().height();
					$("#forms .slides_control").animate({height: height}, 500);	
			});			

		
		 
		 consultar_referencias();
	});
});


	function configurar_form_referencias(input){
			var element_validar={
					rules: {
						"data[Referencia][nombre]":{required:true},
						"data[Referencia][correo]":{required:true,email:true},
						"data[Referencia][telefono]":{digits:true},
						"data[Referencia][tipo]":{required:true},
						"data[Referencia][anio]":{required:true}
					
						
          			 },
       				messages: {
		   			"data[Referencia][nombre]":{required:"Ingresa Nombre de Referencia."},
						"data[Referencia][correo]":{required:"Ingresa Correo Electrónico.",email:"Correo Electrónico no valido."},
						"data[Referencia][telefono]":{digits:"Ingresa Teléfono valido."},
						"data[Referencia][tipo]":{required:"Selecciona tipo de Relación."},
							"data[Referencia][anio]":{required:"Selecciona Opción."}
					
					}

				};
				configure_validation(input,element_validar);	
				
				var $form=$(input).parent();
				/*implementamos metedo para agregar a una lista*/
				$form.each(function(index, element) {
                                this.add_list= function (data,$parent){
										var result =add_view_form(data,$parent);
										return result;
								};
				  });
	
	
	}
	
		/*funcion para cargar todos los registro de experiencia laboral*/
		function consultar_referencias(){
			$.getJSON('../Escolares/consultar/form_referencias', function(data) {
  					$(data).each(function(index, element) {
                       	 var $form= $("#referencia_").find("#model").find("#form_referencias");						 
						 var  result=add_view_form(element,$form);						 
						 result.add();
						 result.show();
						 
						 						 
                    });
 	  			
			});
			
		}
		


