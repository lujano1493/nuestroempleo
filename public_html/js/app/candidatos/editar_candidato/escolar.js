$(document).ready(function(e) {
		$(function(){
		/*Redimensionado Automatico*/ 
			$("#escolar_").resize(function (){
					var $this=$(this);
					if(!$this.is(":visible")){
						return;
					}
					var height=$this.parent().height();
					$("#forms .slides_control").animate({height: height}, 500);	
			});
		
	
	
		/*Configuracion de eventos del formulario escolar div did */
		/*Cuando se seleccion un nivel en el que se especefica especialidad*/
		$(document).on('change','.escper_nivel_change',function() {
			var option=$(this).val(); 
			var $esp=$(this).parent().parent().parent().find("#escper_especialidad");		
			var $gmc=$(this).parent().parent().parent().find("#escper_gmc");
			var value_gmc=$gmc.val();
			if (option==1){
				
				
				
				$gmc.html(
						"<option value=''>Selecciona opción </option>"+
						"<option value='1'>PRIMER AÑO </option>"+
						"<option value='2'>SEGUNDO AÑO </option>"+
						"<option value='3'>TERCER AÑO </option>"+
						"<option value='4'>CUARTO AÑO </option>"+
						"<option value='5'>QUINTO AÑO </option>"+
						"<option value='6'>SEXTO AÑO </option>"
				
				);
				
				
			}
			else{
				$gmc.html(
						"<option value=''>Selecciona opción </option>"+
						"<option value='1'>PRIMER AÑO </option>"+
						"<option value='2'>SEGUNDO AÑO </option>"+
						"<option value='3'>TERCER AÑO </option>"
				
				);
					
			}
			$gmc.val(value_gmc);
			
			if(option ==3 || option==4 ||option==5 ){
				$esp.parent().show("clip",{},500);
			
			}			
			else{
				$esp.parent().hide("clip",{},500);
				$esp.val("");
			}			

		});
		/*Para agregar seleccion de titulacion o no */
		$(document).on('change','.radio_change',function() {
				var value=$(this).val();
				var $radios=$(this).parent().find("input[type=radio],input[type=checkbox]");
				$radios.each(function(index, element) {
                    var value_=$(element).val();
					if(value_==value){
							element.checked=true;
							$(element).trigger("change");
					}				
                });
				
				
		});
		
			/*Para agregar datos de algun elemento que cambio su id  */
		$(document).on('change','.id_change',function() {
				var $this=$(this),$parent=$this.parent(),$change=$parent.find("#"+$this.attr("id_change"));
				$change.val($this.val());				
				
		});
		
			/*Para agregar datos de algun elemento que cambio su id  */
		$(document).on('change','.change_select_all',function() {
				var $this=$(this),$parent=$this.parent(),$change=$parent.find("#"+$this.attr("id_change"));
						
				
		});
		
		
		
		
		/* Configuracion de Form estudios Superiores */
		
		$(document).on('change','.select_change_ajax',function(event) {
			/* buscamos el form donde se encuentra el elemento */
				var $this=$(this);
				var $parent=$this.parent().parent().parent();
				var $target=$parent.find("#"+$this.attr("select_change"));				
				select_change_ajax($this,$target,true);
		});
		
		/*configuracion de eventos para errores a mostrar*/
		
	/*	$(document).on('mou',".formError ",function (event){
				
		});*/
		
		
			 	
	});
	
			/*cargamos datos academicos*/	
			consultar_escolares("form_escolar_b");
			consultar_escolares("form_escolar_s");
			consultar_escolares("form_escolar_p");
			consultar_escolares("form_escolar_c");
			consultar_escolares("form_escolar_i");
		  	  
});
/*obtener datos escolares*/
function consultar_escolares(tipo){
			$.getJSON('../Escolares/consultar/'+tipo, function(data) {
  					$(data).each(function(index, element) {
                       	 var $form_p= $("#escolar_").find("#model").find("#"+tipo);
						 var	result=addData_(element,$form_p);						 
						 result.add();
						 result.show();
                    });
 	  			
			});
			
		}


/*peticion ajax json para obtener lista  */
function select_change_ajax($this,$target,async){
						var id=$this.attr("id");
						
						var data_=$target.data("value");
						if(data_!=null){
							$this.val(data_.input);
						}
						
						var value=$this.val();
						$target.html("<option value=''>cargando ... </option>");
						$target.attr("disabled",true);		
										
						$.ajax({dataType:"json", async:async,
								
								url:'../Escolares/change_select/'+id+"/"+value, 
								success:function(data) {
								var str="<option value=''> Selecciona Opción </option>";
  								for (index_ in data){
                     				str+= "<option value='"+index_+"'> "+data[index_] +"</option>";
								}
								$target.html(str);
								/*verificamos que tengamos un dato inicial para input*/
								var data_= $target.data("value");
								if(data_!=null){
										$target.attr("disabled",false);
										$target.val(data_.target);										
								}
								$target.data("value",null);	
							}
							,complete : function (){ 	$target.attr("disabled",false);		  }   });

	
	}



