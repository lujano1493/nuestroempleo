/*configuracion y validacion de forms*/

/*agregamos nuevo metodo para validar Fechas*/


$(document).ready(function(e) {
    $(function(){
			$.validator.addMethod("endDate", function(value, element) {
      			var $form= $(element).closest(".formulario");
				var $startDate=$form.find(".startdate");
				var start=$startDate.datepicker("getDate");
				var end=$(element).datepicker("getDate");
				if(start==null||end==null){
					return false;
				}
				return start < end;

      		},"");
			
			$.validator.addMethod("date",function ( value, element ) {
        		var bits = value.match( /([0-9]+)/gi ), str;
        		if ( ! bits )
            		return this.optional(element) || false;
        		str = bits[ 1 ] + '/' + bits[ 0 ] + '/' + bits[ 2 ];
        		return this.optional(element) || !/Invalid|NaN/.test(new Date( str ));
    		},"Please enter a date in the format dd/mm/yyyy");
			
			$.validator.addMethod("percent", function(value, element) {
      			var value_= parseFloat( $(element).val());

				if(value_<0||value_>100){
					return false;
				}
				return true;

      		},"");
			

		
		
			
				
	});
});

			function configurar_form_curso(input){
				var element_validar={
					  	rules: {
								"data[Escolar][Curso][curper_tipo]":{required:true},
								"data[Escolar][Curso][curper_descrip]":{required:true},
								"data[Escolar][Curso][curper_obj]":{required:true},
								"data[Escolar][Curso][curper_fecini]":{required:true,date:true},
								"data[Escolar][Curso][curper_fecfin]":{required:true,date:true,endDate:true},
								"data[Escolar][Curso][curper_intext]":{required:true},
								"data[Escolar][Curso][curper_instructor]":{required:true},
								"data[Escolar][Curso][curper_result]":{required:true}
							},
       					messages: {
		   						"data[Escolar][Curso][curper_tipo]":{required:"Selecciona tipo"},
								"data[Escolar][Curso][curper_descrip]":{required:"Escribe Descripción"},
								"data[Escolar][Curso][curper_obj]":{required:"Escribe Objetivo"},
								"data[Escolar][Curso][curper_fecini]":{required:"Selecciona fecha inicial",
																	date:"Formato de fecha inválido"},
								"data[Escolar][Curso][curper_fecfin]":{required:"Selecciona fecha final",
																		date:"Formato de fecha inválido",
																	   endDate:"La fecha final debe ser mayor a la fecha inicial"},
								"data[Escolar][Curso][curper_intext]":{required:"Selecciona Opción"},
								"data[Escolar][Curso][curper_instructor]":{required:"Escribe el nombre del instructor"},
								"data[Escolar][Curso][curper_result]":{required:"Selecciona resultado"}
							}	
								};
				
				configure_validation(input,element_validar);	
				configure_control_date(input);
				configure_event_add_list(input);
				
			};
			
			
			
			
			function configurar_form_idioma(input){
				var element_validar={
					rules: {
						"data[Escolar][IdiomaPer][idioma_cve]":{required:true},
						"data[Escolar][IdiomaPer][idiper_lee]":{required:true,number:true,percent:true},
						"data[Escolar][IdiomaPer][idiper_esc]":{required:true,number:true,percent:true},
						"data[Escolar][IdiomaPer][idiper_con]":{required:true,number:true,percent:true}
          			 },
       				messages: {
		   			"data[Escolar][IdiomaPer][idioma_cve]":{required:"Selecciona Idioma"},
					"data[Escolar][IdiomaPer][idiper_lee]":{required:"Escribe porcentaje lectura",number:"Ingresa un número",
															percent:"porcentaje fuera del rango"},
					"data[Escolar][IdiomaPer][idiper_esc]":{required:"Escribe porcentaje escritura",number:"Ingresa un número",
															percent:"porcentaje fuera del rango"},
					"data[Escolar][IdiomaPer][idiper_con]":{required:"Escribe porcentaje comprensión",number:"Ingresa un nÚmero",
															percent:"porcentaje fuera del rango"}
					}

				};
				configure_validation(input,element_validar);	
				configure_event_add_list(input);
			};
			
			function configurar_form_basico(input){
				var element_validar={
          		rules: {
				
					"data[Escolar][Escolar][escper_nivel]":{required:true},
					"data[Escolar][Escolar][escper_institucion]":{required:true},
					"data[Escolar][Escolar][escper_lugar]":{required:true},
					"data[Escolar][Escolar][escper_gmc]":{required:true},
					"data[Escolar][Escolar][escper_titulado]":{required:true},
					"data[Escolar][Escolar][escper_especialidad]":{required:true}				
           		},
      			messages: {
		   			"data[Escolar][Escolar][escper_nivel]":{required:"Selecciona nivel"},
					"data[Escolar][Escolar][escper_institucion]":{required:"Escribe institución"},
					"data[Escolar][Escolar][escper_lugar]":{required:"Escribe lugar"},
					"data[Escolar][Escolar][escper_gmc]":{required:"selecciona grado máximo cursado"},
					"data[Escolar][Escolar][escper_titulado]":{required:"Selecciona Sí o No"},
					"data[Escolar][Escolar][escper_especialidad]":{required:"Escribe Especialidad"}
		   
       			}};			
				configure_validation(input,element_validar);	
				configure_event_add_list(input);
			};
			
			function configurar_form_superior(input){
				var element_validar={
				  rules: {
					"data[Escolar][EscCarArea][carea_cve]":{required:true},
					"data[Escolar][EscCarGene][cgen_cve]":{required:true},
					"data[Escolar][Escolar_S][cespe_cve]":{required:true},
					"data[Escolar][Escolar_S][escper_institucion]":{required:true},
					"data[Escolar][Escolar_S][escper_lugar]":{required:true},
					"data[Escolar][Escolar_S][escper_gmc]":{required:true},
					"data[Escolar][Escolar_S][escper_titulado]":{required:true}
           			},
      	 		messages: {
		   			"data[Escolar][EscCarArea][carea_cve]":{required:"Selecciona Área General"},
					"data[Escolar][EscCarGene][cgen_cve]":{required:"Selecciona Carrera Genérica"},
					"data[Escolar][Escolar_S][cespe_cve]":{required:"Selecciona Carrera Específica"},
					"data[Escolar][Escolar_S][escper_institucion]":{required:"Escribe Institución"},
					"data[Escolar][Escolar_S][escper_lugar]":{required:"Escribe lugar"},
					"data[Escolar][Escolar_S][escper_gmc]":{required:"Selecciona grado máximo cursado"},
					"data[Escolar][Escolar_S][escper_titulado]":{required:"Selecciona Sí o No"}
      			 }	
				};
				configure_validation(input,element_validar);	
				configure_event_add_list(input);
			};
			function configurar_form_posgrado(input){
				var element_validar={
				      rules: {
						"data[Escolar][Escolar_P][escper_nivel]":{required:true},				
						"data[Escolar][Escolar_P][escper_institucion]":{required:true},
						"data[Escolar][Escolar_P][escper_lugar]":{required:true},
						"data[Escolar][Escolar_P][escper_gmc]":{required:true},
						"data[Escolar][Escolar_P][escper_especialidad]":{required:true}, 
						"data[Escolar][Escolar_P][escper_titulado]":{required:true}
           				},
      				 messages: {
		   				"data[Escolar][Escolar_P][escper_nivel]":{required:"Selecciona nivel"},
						"data[Escolar][Escolar_P][escper_institucion]":{required:"Escribe institución"},
						"data[Escolar][Escolar_P][escper_lugar]":{required:"Escribe lugar"},
						"data[Escolar][Escolar_P][escper_gmc]":{required:"Selecciona grado máximo cursado"},
						"data[Escolar][Escolar_P][escper_especialidad]":{required:"Escribe el posgrado "},
						"data[Escolar][Escolar_P][escper_titulado]":{required:"Selecciona Sí o No"}
					 }
				};
				configure_validation(input,element_validar);	
				configure_event_add_list(input);
			};
			
			
			function configure_event_add_list(input){
				var $form=$(input).parent();
				$form.each(function(index, element) {
                                this.add_list= function (data,$parent){
										var result =addData_(data,$parent);
										return result;
								};
				  });
				
			}
			
			
		