// JavaScript Document

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
		
		
		
		
		
		/*agregamos un bind para redimensionar nuestro campo de trabajo en experiencia laoboral*/
			$("#laboral_").resize(function (){
					var $this=$(this);
					if(!$this.is(":visible")){
						return;
					}
					var height=$this.parent().height();
					$("#forms .slides_control").animate({height: height}, 500);	
			});			
		 consultar_experiencia_laboral();
		 
		 
		 /*configuramoes eventos para nuestro formulario*/
		 		/*ultimo sueldo ganado*/
		$(document).on("change",".ult_sueldo",function (){
				var $this=$(this),$parent=$this.parent();
				var checked=$this.prop("checked");
				var is_checked=false;
				$parent.find("input[type=checkbox]").each(function(index, element) {						
						if(!is_checked){	
							is_checked=$(this).prop("checked");				                    	
						}
						$(this).prop("checked",false);
				});
				$this.prop("checked",checked);
				if(!is_checked){
					is_checked=checked;
				}
				
				var $ult_sueldo=$this.closest(".formulario").find(".div_explab_sueldo");				
				if(is_checked){
					$ult_sueldo.hide("clip",{},500,function (){
						$ult_sueldo.find("input[type=text],select").val($this.val());
						});
					
					
				}
				else{
					$ult_sueldo.find("input[type=text],select").val("");
					$ult_sueldo.show("clip",{},500,function (){});	
				
				}
				
			
			});
		
		/*Sidicato */
			$(document).on("change",".sindicato",function (){
				var $this=$(this);
				var $div_sindicato=$this.closest(".formulario").find(".div_sindicato");		
				if($this.val()=="S"){
					$div_sindicato.show("clip",{},500,function (){});	
				}
				else{
					$div_sindicato.hide("clip",{},500,function (){});
					$div_sindicato.find("input[type=text],select").val("");	
				}
				
			});
		/*vales*/
		
			$(document).on("change",".checkbox_change",function (){
				var $this=$(this);
				
			});
		 
		 
	});
});



	function configurar_form_laboral  (input){
			var element_validar={
					rules: {
						"data[Laboral][ExpLabPer][explab_empresa]":{required:true},
						"data[Laboral][ExpLabPer][explab_jefe]":{required:true},
						"data[Laboral][ExpLabPer][explab_dir]":{required:true},
						"data[Laboral][ExpLabPer][explab_tel]":{required:true,digits:true},
						"data[Laboral][ExpLabPer][explab_fecini]":{required:true,date:true},
						"data[Laboral][ExpLabPer][explab_fecter]":{required:true,date:true,endDate:true},
						"data[Laboral][ExpLabPer][explab_sindi_]":{required:true},
						"data[Laboral][ExpLabPer][sindi_cve]":{required:true},
						"data[Laboral][ExpLabPer][explab_sueldo]":{required:true,number:true,mayor:true},
						"data[Laboral][ExpLabPer][explab_puestos]":{required:true},
						"data[Laboral][ExpLabPer][explab_mds]":{required:true}
						
          			 },
       				messages: {
		   			"data[Laboral][ExpLabPer][explab_empresa]":{required:"Ingresa nombre de la Empresa"},
					"data[Laboral][ExpLabPer][explab_jefe]":{required:"Ingresa nombre del jefe inmediato"},
					"data[Laboral][ExpLabPer][explab_dir]":{required:"Ingresa dirección"},
					"data[Laboral][ExpLabPer][explab_tel]":{required:"Ingresa teléfono",digits:"Ingresa teléfono válido"},
					"data[Laboral][ExpLabPer][explab_fecini]":{required:"Ingresa fecha de inicio",date:"Formato de fecha erronea"},
					"data[Laboral][ExpLabPer][explab_fecter]":{required:"Ingresa fecha de término",date:"Formato de fecha erronea",
																										  endDate:"La fecha de término es menor a la de inicio"},
					"data[Laboral][ExpLabPer][sindi_cve]":{required:"Elige Sindicato"},
					"data[Laboral][ExpLabPer][explab_sindi_]":{required:"Elige Sí o No"},
					"data[Laboral][ExpLabPer][explab_sueldo]":{required:"Ingresa Sueldo",number:"Ingresa una cantidad"},
					"data[Laboral][ExpLabPer][explab_puestos]":{required:"Ingresa una descripción del puesto"},
					"data[Laboral][ExpLabPer][explab_mds]":{required:"ingresa motivos de separación"}
					
					}

				};
				configure_validation(input,element_validar);	
				configure_control_date(input);
				
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
		function consultar_experiencia_laboral(){
			$.getJSON('../Escolares/consultar/form_exp_laboral', function(data) {
  					$(data).each(function(index, element) {
                       	 var $form= $("#laboral_").find("#model").find("#form_exp_laboral");
						 
						  var	result=add_view_form(element,$form);						 
						 result.add();
						 result.show();
						 
						 						 
                    });
 	  			
			});
			
		}
		
	


