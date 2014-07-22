
/* escolar.js*/
$(document).ready (function ($){

	$(document).on("change",".ec_nivel",function (){
		var $form=$(this).closest(".formulario");
		var $candidato_cve=$form.find(".candidato_cve");
		 var magicS=$candidato_cve.data("magicSuggest");
		 var value=$(this).val();
		 if(value>2){
		 		magicS.enable();
		 }
		 else{
		 	magicS.disable();
		 	magicS.clear();
		 }

	});


	$(document).on("change",".ec_actual",function (){
			var $this=$(this),$div_fec=$this.closest(".formulario").find(".ec_fecfin"),$div_parent=$div_fec.parent();

			if($this.prop("checked") && "S"==$this.val()){
					$this.closest(".formulario").find(".ec_fecini").datepicker("option","maxDate",null);
					$div_fec.addClass("hide").find(".hide").val("");
					$div_parent.addClass("hide");
			}
			else if($this.prop("checked") && "N"== $this.val()){
				$div_fec.removeClass("hide");
				$div_parent.removeClass("hide");
			}

	});

	

/*escolar.js */
	config_template(".educacion_escolar" ,
			function (form){
					$(form).find(".ec_nivel").rules("add",
						{
						required: true,					
							messages: {
								required:  "Selecciona opción"
							}});

					$(form).find(".ec_institucion").rules("add",
						{
						required: true,					
							messages: {
								required:  "Ingresa nombre de la institución"
						}});

		
							var ms=$(form).find(".cespe_cve").magicSuggest($.extend(getMaggicSuggest_option(),
					{ 
							displayField:"cespe_nom",
							valueField:"cespe_cve",
							emptyText: 'Ingresa un área de conocimiento',
							data: getItemsfromSelected (".template .cespe_cve_arr option","cespe_cve","cespe_nom"),
							maxSelection: 1
					}));
					ms.addToSelection( getValues(".agregados .areas_interes .EscCan"));
					$(form).find(".candidato_cve").data("magicSuggest",ms);
					/*agregamos validacion para el suggest magic*/
					$(form).find("input[id*='ms-input']").attr("name","ms-input").rules("add",{
						magicsugest: ms,					
							messages: {
								magicsugest:  "Selecciona un área de conocimiento"
							}});

					config_calendar_form(form);

						$(form).find(".ec_nivel").trigger("change");


							/*configuracion para no mostrar la opcion si estudia actualmente*/
					var count= +$(form).closest( ".work_area").find(".count_register ").val();
					if((count-1)>0){
							var elem =$(form).find(".ec_actual");
							$(form).find(".ec_actual_div").empty();
							var input=$("<input>",{					type:"hidden",
																	name:elem.attr("name"),
																	value:"N"});
							$(form).find(".ec_actual_div").append(input);
					}
					$(form).find(".ec_actual").trigger("change");



				});

		initConfigValidation(".educacion_escolar");


});