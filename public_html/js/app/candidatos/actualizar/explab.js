
/* explab.js*/
$(document).ready (function ($){


	$(document).on("click",".exp_lab_has",function (){
		$(".experiencia_laboral_ ").show("fade",500);
		$(".experiencia_laboral_ ").find("input,select,textarea").each(function (){
									$(this).attr("name",$(this).attr("data-name"));
		});
		$(this).addClass("active");
		$(".exp_no_lab_has").removeClass("active");
		$("[name*='tiene_exp']").val("active");
			

	});
	$(document).on("click",".exp_no_lab_has",function (event,first){
		/*filtramos solo acciones de hacer click*/
		first= (first==undefined)?false:first,self=this ;
		var $formito=$(".experiencia_laboral_");

		$agregados= $formito.find(".agregados .explaboral");		
		var ms=$(".exp_no_lab_has").data("magicSuggest");
		//console.log(ms);
		//console.log($(".agregados .areas_experiencia form input[id*='ms-input']"));
		function ocultar(){
				$formito.hide("fade",500).find("input,select,textarea").each(function (){
													$(this).attr("data-name",$(this).attr("name")).attr("name","");
				});
				$(self).addClass("active");
				$(".exp_lab_has").removeClass("active");		
				$agregados.empty();
				ms.clear();
		}

		if($agregados.length==0&& ms.getValue().length==0){
			ocultar();
			return;
		}
		

		if(!first){
			if(confirm("¿Desea continuar con esta acción?")){
				var request={
					$this:$(this),$div:$formito,url:"/Candidato/eleminar_Explab",valid:false,send_param:false,
					callback_complete:function (){
						remove_background_wait($formito);},
					callback_ok:function (data){
							if(data[0].sts=="ok"){																						
								ocultar();
							
							}

					},callback_before:function (){
						create_background_wait($formito);
					}
				};
				ajax_request_(request);			
			}
		}
				

	});



	$(document).on("change",".explab_actual",function (){

			var $this=$(this),$div_fec=$this.closest(".formulario").find(".explab_fecfin"),$div_parent=$div_fec.parent();

			if($this.prop("checked") && "S"==$this.val()){
					$this.closest(".formulario").find(".explab_fecini").datepicker("option","maxDate",null);
					$div_fec.addClass("hide").find(".hide").val("");
					$div_parent.addClass("hide");
			}
			else if($this.prop("checked") && "N"== $this.val()){				
				$div_fec.removeClass("hide");
				$div_parent.removeClass("hide");
			}

	});

/*explab.js */
	config_template(".explaboral" ,
			function (form){

					$(form).find(".explab_empresa").rules("add",
						{
						required: true,					
							messages: {
								required:  "Ingresa el nombre de la Compañía."
							}});
					$(form).find(".giro_cve").rules("add",
						{
						required: true,					
							messages: {
								required:  "Selecciona el giro de la Empresa."
							}});
					$(form).find(".explab_puesto ").rules("add",
							{
							required: true,					
								messages: {
									required:  "Ingresa el nombre del Puesto."
								}});
					$(form).find(".explab_funciones").rules("add",
							{
							required: true,					
								messages: {
									required:  "Ingresa una descripción del puesto."
								}});

					$(form).find(".explab_actual").rules("add",
							{
							required: true,					
								messages: {
									required:  "Selecciona si trabajas actualmente."
								}});



					config_calendar_form(form);
					/*configuracion para no mostrar la opcion si trabajas*/
					var count= +$(form).closest( ".work_area").find(".count_register ").val();
					if((count-1)>0){
							var elem =$(form).find(".explab_actual");
							$(form).find(".explab_actual_div").empty();
							var input=$("<input>",{					type:"hidden",
																	name:elem.attr("name"),
																	value:"N"});
							$(form).find(".explab_actual_div").append(input);
					}
					$(form).find(".explab_actual").trigger("change");
					
				
				


				});

		initConfigValidation(".explaboral");

					if($(".exp_no_lab_has").hasClass("active")){
						//	$(".exp_no_lab_has").trigger("click",true);
					}

});