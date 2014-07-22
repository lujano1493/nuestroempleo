/* areas interes  areaint.js*/
$(document).ready(function(e) {
	$(function(){	

			/* areas de interes*/



			if($(".agregados .areas_interes .lista_areas_interes").length>0){
				var ms=$(".agregados .areas_interes .lista_areas_interes").magicSuggest($.extend(getMaggicSuggest_option(),
				{ 
						displayField:"cespe_nom",
						valueField:"cespe_cve",
						emptyText: 'Ingresa un Área de interés',
						data: getItemsfromSelected (".template .cespe_cve_arr option","cespe_cve","cespe_nom"),
						maxSelection: 3,
						element_extra:[{id:"cespe_cve",type:"hidden",name:"data[AreaIntCan]"}]
				}));
				ms.addToSelection( getValues(".agregados .areas_interes .AreaIntCan"));

					/*validacion de areas de interes*/
				$(".agregados .areas_interes form").validate(getValidationOptions());

				$(".agregados .areas_interes form").find("input[id*='ms-input']").attr("name","ms-input").rules("add",{
						magicsugest: ms,					
							messages: {
								magicsugest:  "Selecciona un Área de interés."
						}});

			}
		

			/*areas de experiencia*/

				var ms=$(".agregados .areas_experiencia .lista_areas_interes_exp").magicSuggest($.extend(getMaggicSuggest_option(),
			{ 
					displayField:"cespe_nom",
					valueField:"cespe_cve",
					emptyText: 'Ingresa un Área de experiencia',
					data: getItemsfromSelected (".template .cespe_cve_arr option","cespe_cve","cespe_nom"),
					maxSelection: 3,
					selectionPosition:'bottom',
					selectionStacked: true,
					element_extra:[{id:"cespe_cve",type:"hidden",name:"data[AreaExpCan]"},{id:"tiempo_cve",
						  	type:"select",options: function (){
						  		var options ="";
						  		$(".tiempo_cve_arr option").each(function (){
						  				options+= "<option value='"+this.value+"'> "+this.text+" </value>";
						  		});
						  		return options;

						  	},name:"data[AreaExpCan]"} ]
			}));
			ms.addToSelection( getValues(".agregados .areas_experiencia .AreaExpCan"));	
			config_load_magicSuggest(ms,".agregados .areas_experiencia .AreaExpCan");				
			$(".agregados .areas_experiencia form").validate(getValidationOptions());
			$(".agregados .areas_experiencia form input[id*='ms-input']").attr("name","ms-input").rules("add",{
					magicsugest: ms,					
						messages: {
							magicsugest:  "Selecciona un Área de experiencia."
					}});

			$(".exp_no_lab_has").data("magicSuggest",ms);
		

	});
});

