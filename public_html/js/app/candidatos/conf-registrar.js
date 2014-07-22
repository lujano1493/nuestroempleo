function mayus(field){
	var value=field.value.toUpperCase();
	field.value=value;
}


function parseBool(val)
{
    if ((val.toLowerCase() === 'true' || val.toLowerCase() === 'yes'|| val==='1' ) || val === 1)
        return true;
    else 
        return false;
}

function crear_calen(id){
	  $(function() {
        $( "#"+id ).datepicker(	{ 
			dateFormat: "dd/mm/yy" ,
			dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
			dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
			monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ] ,
			monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
			changeMonth: true,
            changeYear: true,
			numberOfMonths: 1,
			showButtonPanel: false,
			minDate:  "-50y" ,
			maxDate: new Date() ,
			closeText: "Cerrar",
			currentText:"Hoy"
			}	
		);		
		$(".ui-datepicker").css("font-size","10px");		
    });
	  
	
}





function registrar(vista){
		 //$("#form_candidato").submit(); 
		if (!$("#form_general").valid()){
			return;
		}		 
		 var params=$("#"+vista+"_").serialize();
		$.ajax({
        	type: "POST",
        	url: "../Candidato/guardar_datos_candidato/"+vista,
			dataType:"json",
       	 	data: params ,
        	success: function(datos) {	
			
				if(datos[0].sts=="ok"){
						
							
				}
				else{
					alert(datos[0].mensaje);
						
					}
				
      		},
			beforeSend: function(objeto){	
						$("#boton_"+vista).attr("disabled",true);
				
		
        },
		complete: function(objeto, exito){          				
         		  if(exito=="success"){
					   deshabilitar(true,vista);  //dasabilitamos controles
            		}
					$("#boton_"+vista).attr("disabled",false);
		}
		});		 
		 
		 
	}
	
	
function deshabilitar(flag,vista){
	
	var boton="#boton_"+vista;
	if(flag){
		$(boton).attr("onclick","editar_"+vista+"();");
		$(boton).text("Editar");
	}
	else{
		$(boton).attr("onclick","guardar_"+vista+"();");
		$(boton).text("Guardar");
		
		}

	var form_control="#"+vista+"_";
	$(form_control).find("input,select").each(function(index, element) {
		if (!$(element).hasClass("disabled_")){
        	$(element).attr("disabled",flag);
		}
		else{
			$(element).attr("disabled",true);	
		}
		if ($(element).hasClass("edit_to_label")){
			var id=$(element).attr("id");
			var name=$(element).attr("name");
			var value=$(element).attr("value");
        	$(element).parent().html(
				"<label>"+value+" </label> \n"+
				"<input id='"+id+"' type='hidden' name='"+name+"' value='"+value+"'  />"
			);
		}
    });
	
}

function sts_inicial(vista){
		var disabled=parseBool ($("#disabled_"+vista).val());
			deshabilitar(disabled,vista);
	
	
	}
	
	
	
	
	
	$(document).ready(function(e) {
		$(function(){
		$.validator.addMethod("valida_cp", function(value,element) {
       												var ok = false;
													 var opcion=  parseInt (value);
													 
													 if (!isNaN(opcion)&&opcion!=-1){
														ok=true;
													}
													if(ok){
													 	$("#cp_cve").val(value);
														var text =$("#cp_asentamiento option:selected").text();
														$(element).parent().html(
														"<input type='text' id='cp_asentamiento_'  value='"+text+"' disabled />\n"+
														"<input type='hidden' id='cp_asentamiento' name='data[CodigoPostal][cp_asentamiento]' value='"+value+"' />"
														
														);
														
														
													}
       												
													return ok;}
							  ,"Elige una Colonia");
			
       $('#form_general').validate({
           rules: {
         		"data[Perfil][Candidato][persona_nom]":{required:true,minlength:2},
				"data[Perfil][Candidato][persona_pat]":{required:true,minlength:2},
				"data[Perfil][Candidato][persona_mat]":{required:true,minlength:2},
				"data[Perfil][Candidato][persona_nac]":{required:true},
				"data[Perfil][Candidato][persona_email]":{required:true,email:true},
				
				"data[Direccion][DirPersona][dirper_callenum]":{required:true},
				"data[Direccion][CodigoPostal][cp_asentamiento]":{required:true,valida_cp:true},
				"data[Direccion][DirPersona][dirper_numext]":{required:true,digits:true},
				"data[Direccion][DirPersona][dirper_numint]":{digits:true},
				"data[Direccion][DirPersona][dirper_tel]":{required:true,digits:true},
				"data[Direccion][DirPersona][dirper_movil]":{required:true,digits:true},
				
				
				
		   
           },
       messages: {
			"data[Perfil][Candidato][persona_nom]":{required: 'Ingresa nombre',minlength:"Ingresa nombre"},
			"data[Perfil][Candidato][persona_pat]":{required: 'ingresa apellido paterno',minlength:"Ingresa apellido paterno"},
			"data[Perfil][Candidato][persona_mat]":{required: 'Ingresa apellido materno',minlength:"Ingresa apellido materno"},			
			"data[Perfil][Candidato][persona_nac]":{required: 'Ingresa fecha de nacimiento'},
			"data[Perfil][Candidato][persona_email]":{required:'Ingresa correo electrónico',email:'Correo electrónico inválido'},
			
			"data[Direccion][DirPersona][dirper_callenum]":{required:"Ingresa Calle"},
			"data[Direccion][CodigoPostal][cp_asentamiento]":{required:"Selecciona Opción",valida_cp:"Selecciona una colonia"},
			"data[Direccion][DirPersona][dirper_numext]":{required:"Ingresa número exterior",digits:"Ingresa sólo números"},
			"data[Direccion][DirPersona][dirper_numint]":{digits:"Ingresa sólo números"},
			"data[Direccion][DirPersona][dirper_tel]":{required:"Ingresa número teléfonico",digits:"Ingresa sólo números"},
			"data[Direccion][DirPersona][dirper_movil]":{required:"Ingresa número teléfonico móvil",digits:"Ingresa sólo números"}
			
		   
       },
       //debug: true,
	    focusInvalid:true,
		   
       /*errorElement: 'div',*/
       //errorContainer: $('#errores'),
       submitHandler: function(form){
          	//form.submit();
				
			
       }
    });
	  
	  
	});
	
	
 });

	