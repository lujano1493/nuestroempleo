$(document).ready(function(e) {
		$(function(){
			$(document).on("blur",".cp_cp",function (){
					buscar_codigoPostal(this);
				
			});		
			/*cambiamos el cp_cve seleccionado del combo*/
			$(document).on("change",".cp_asentamiento",function (){

				$(this).closest("form").find(".cp_cve").val($(this).val());			

			});

			$(document).on("keydown",".cp_cp",function (event){
		// solo permitiremos los delete
		
		    	if (  event.keyCode == 8 ||event.keyCode == 9 ) {
		    		// let it happen, don't do anything
		    	}
		    	else {
		    		// Ensure that it is a number and stop the keypress 96 a 105
		    		if (event.keyCode < 48 || event.keyCode > 57 &&  event.keyCode < 96  ||  event.keyCode > 105 ) {
		    			event.preventDefault();	
		    		}	
		    	}
			});
			
		});
});

function show_error_postcode(field,exito){
	var $field=$(field);
	if(exito!='success'){
			var $div_error=$("<div class='hide text-error'  > Verifica tu Código Postal. </div>"),$parent=$field.closest("div.controls");
			$parent.find(".text-error").remove();	

			$div_error.appendTo($parent);			

			$div_error.show("fade",2000,function (){
					setTimeout(function (){  
						$div_error.hide("fade",10000,function (){ $(this).remove() });
					},3000);
					
			});

	}
}


function buscar_codigoPostal(field){
	var $field=$(field),$form=$field.closest("form"),value=$field.val();

	var name= $form.find(".cp_asentamiento").attr("name");
	var id= $form.find(".cp_asentamiento").attr("id");
	var clazz= "input-medium cp_asentamiento";
					 


	$.ajax({
        type: "POST",
        url: "/Info/codigo_postal/"+value,
		dataType:"json",
        data: {} ,
        error: function (request, status, error){
        		show_error_postcode(field,'empty');
        },

        success: function(datos) {

        		if(datos==undefined ||datos==null ){
        			 	show_error_postcode(field,'empty');
        			 	return;
        		}        		 
        		if(!datos.results){
				 	return;
				 }
				 

				 var results=datos.results;
				 $form.find(".est_nom").val(results.estado);
				 $form.find(".ciudad_nom").val(results.municipio);
				 $form.find(".cp_cve").val("");
				 
		
				 if( results.colonias.length==1){				 
				 	var options="";	

				 }
				 else{
				 	var options="<option value='' >Selecciona opción</option> ";
				 }

				

				 $(results.colonias).each(function(index, element) {							
                   		options += "<option value=\""+element.id+"\" >"+element.nombre+ "</option>";
                    });
					

				 
				 $form.find(".cp_asentamiento").html(options).focus();

				 if( results.colonias.length==1){				 
				 	
					$form.find(".cp_cve").val(results.colonias[0].id);

				 }
					 
					 
					
				
				
	},
	  beforeSend: function (){


		  		$form.find(".load_wait").show("blind", {}, 600,function (){ });
				$form.find(".cp_asentamiento").html("<option  value='' >Cargando ... </option> ").prop("disabled",true);
				$form.find(".est_nom").val("Cargando ...");
				$form.find(".ciudad_nom").val("Cargando ...");

				
				
	},
	complete: function(objeto, exito){          		
				$form.find(".cp_asentamiento").prop("disabled",false);
				$form.find(".load_wait").hide("blind", {}, 600,function (){ });
	}

	  });		 
}