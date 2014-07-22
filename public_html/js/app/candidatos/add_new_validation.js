/*add_new_validation*/
var onlyletter_expression="[A-Za-záéíóúÁÉÍÓÚñÑ]+";
var number_positive= /^[0-9]+\.?[0-9]*$/;


function add_validation(name,funcion,message){	
	$.validator.addMethod(name,funcion  ,message);	
	}


function add_validation_number_pos(){
	add_validation("number_pos",function (value,element,param){
					 return     value!="" &&  !isNaN(parseFloat(value)) ;
					},"Numero")	
	
	
}

function add_validation_diferent(){
	add_validation("diferent",function (value,element,param){
						var $area=$(element).closest(".work_area" );
						if($area.length==0){
							return false;
						}
						var $this=$(element);
						$this.addClass("checkando");
						var $element_comp=$area.find(".agregados").find(param);

						var flag=true;
						$element_comp.each(function (){
							if(!$(this).hasClass("checkando")){
									if($(this).val()==$this.val() ){
										flag=false;
									}
							}
						});
						$this.removeClass("checkando");

						
					 return flag;
					},"Existe elementos duplicados")	


}


function add_validation_date(){
	add_validation("date",function ( value, element ) {
		
			var date=$(element).parent().find("#"+$(element).attr("id")+"_datepicker").data("date_select");
			return date!=undefined;

    		},"formato de fecha no valido");


}
function add_validation_compare(){
add_validation("compare",function (value,element,param){
			 			var $element=$(element),$form=$element.closest("form"),$element_comp=$form.find(param.element);
			 			
			 			if(param.type=="number"){

			 				var end=parseFloat($element.val()),start=parseFloat($element_comp.val());

			 				if(param.compare==">="){			 					
			 					return (end>=start );
			 				}
			 				if(param.compare=="<="){			 					
			 					return (end<=start );
			 				}
			 				if(param.compare=="=="){			 					
			 					return (end==start );
			 				}
			 				if(param.compare==">"){			 					
			 					return (end>start );
			 				}
			 				if(param.compare=="<"){			 					
			 					return (end<start );
			 				}
			 				else{
			 					return false;
			 				}
			 			}
			 			if(param.type=="date"){			 		

							var start=$element_comp.parent().find("#"+$element_comp.attr("id")+"_datepicker").data("date_select");
							var end=$element.parent().find("#"+$element.attr("id")+"_datepicker").data("date_select");
							if(start==undefined||start==null ){
								return false;
							}
							else if (end==null || end==undefined){
								return true;
							}
							return  end > start;
			 			}
			 			else{
			 				return false;
			 			}


			 	} ,"elemento es menor");		



}
	


/*nuevos metodos para validación*/

function add_validation_expresion(){
	add_validation("expresion",function (value,element,param){
					 return value.match(param);
					},"Error en la expresión")	
	
	
}



/*verificar Codigo Postal*/
function add_validation_codigoPostal(){
	add_validation("asentamiento", function(value,element) {
														var ok = false;
														 var opcion=  parseInt (value);
														 
														 if (!isNaN(opcion)&&opcion!=-1){
															ok=true;																										
														}
																												
														return ok;}
								  ,"Elige una Colonia");	
	
}


function add_validation_captcha(){
	
	add_validation("captcha", function(codigo) {
				var isSuccess = false;
				$.ajax({ url: "../Uploads/validate_captcha",
					dataType: "json",
					type: "POST",
					data: "codigo=" + codigo,
					async: false,
					success:
						function(msg) { isSuccess = msg;}
	
				  });
				return isSuccess;},"");
}

/*exite correo*/

function add_validation_exist_email(){
	
	add_validation("exist_email", function(email) {
				var isSuccess = false;
				$.ajax({ url: "/info/existe_correo",
					dataType: "json",
					type: "POST",
					data: "email=" + email,
					async: false,
					success:
						function(msg) { isSuccess = msg;}
	
				  });
				return isSuccess;},"correo electronico ya esta ocupado por otra cuenta");
}





function add_validation_magicsugest(){
	
	add_validation("magicsugest", function(value,element,param) {			
					var valid= param.isValid();
					console.log(element);
					return valid;
			},"debe ingresar al menos un elemento a la lista ");
}



$(function (){

	$(document).ready(
		function ($){
				add_validation_codigoPostal();			
				add_validation_captcha();
				add_validation_exist_email();
				add_validation_expresion();				
				add_validation_date();		
				add_validation_compare();
				add_validation_diferent();
				add_validation_magicsugest();


				$.validator.addMethod("alphanumeric", function(value, element) {
				        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
				}); 

			$.validator.addMethod("myurl", function(value, element) {
				        return this.optional(element) || /^((https?|s?ftp):\/\/)?(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
				}); 

				$.validator.addMethod("mydate", function(value, element) {
				        return this.optional(element) || /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}?$/i.test(value);
				}); 

				$.validator.addMethod('equalTo',
					 function( value, element, param ) {
						// bind to the blur event of the target in order to revalidate whenever the target field is updated
						// TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
						var target = $(element).closest("form").find(param);
						if ( this.settings.onfocusout ) {
							target.unbind(".validate-equalTo").bind("blur.validate-equalTo", function() {
								$(element).valid();
							});
						}
						return value === target.val();
					}

				 ,"");	
			}
		);


});