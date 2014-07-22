
/*$(document).ready(function(e) {
	$("input[type='text']").bind("blur", null, function(e) {
    	$(this).val($(this).val().toUpperCase());
	});
});*/

function calcularEdad(fecha){
	try{
			var fecha= fecha.value.split("/");
			
			var d1=new Date();
			d1.setFullYear(parseInt(fecha[2]),parseInt(fecha[1]-1),parseInt(fecha[0]));
			var d2=new Date();
			var anio=parseInt( (d2.getTime()-d1.getTime())/(365*1000*60*60*24));
			$("#label_anio").html(anio);
			
	} catch (e){
		
		
	}
	
}


function getCiudad(field,field_change){
	var value=$(field).val();

	$.ajax({
        type: "POST",
        url: "../Candidato/getCiudad",
		dataType:"json",
        data: {est_cve:value} ,
        success: function(datos) {
				$(field_change).attr('disabled',false);
				if(datos!==undefined){
							$(field_change).html("");
							var options="";
						$(datos).each(function(index, element) {
							
                       		options += "<option value=\""+element.Municipio.ciudad_cve+"\" >"+element.Municipio.ciudad_nom+ "</option>";
                        });
						$(field_change).html(options);
				}
				
				
	},
	  beforeSend: function (){
				$(field_change).attr('disabled',true);
				$(field_change).html("<option value='-1'>Cargando  ... </option> ");
	}
	  });		 
	


}


$(document).ready(function(e) {
		$(function(){
		//$("#div_radio_genero").buttonset();
			
			$("#perfil").find("#persona_nac").each(function(index, element) {
                	crear_calen(this);
            });
			
			crear_calen("persona_nac");
			sts_inicial('perfil');
			
			var element_validar={
				 rules: {
         		"data[Perfil][Candidato][persona_nom]":{required:true,minlength:2},
				"data[Perfil][Candidato][persona_pat]":{required:true,minlength:2},
				"data[Perfil][Candidato][persona_nac]":{required:true},
				"data[Perfil][Candidato][persona_email]":{required:true,email:true}
				

				
				
		   
           },
		   	 messages: {
			"data[Perfil][Candidato][persona_nom]":{required: 'Ingresa nombre',minlength:"Ingresa nombre"},
			"data[Perfil][Candidato][persona_pat]":{required: 'Ingresa apellido paterno',minlength:"Ingresa apellido paterno"},		
			"data[Perfil][Candidato][persona_nac]":{required: 'Ingresa fecha de nacimiento'},
			"data[Perfil][Candidato][persona_email]":{required:'Ingresa correo electrónico',email:'Correo electrónico inválido'}  
       		}};
			
			configure_validation(document.getElementById("config_form_perfil"),element_validar);	

			
			
		});
	
	
        });













