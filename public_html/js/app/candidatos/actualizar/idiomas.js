
/* escolar.js*/
$(document).ready (function ($){


		var ms=$(".agregados .lista_idiomas").magicSuggest($.extend(getMaggicSuggest_option(),
			{ 
					displayField:"idioma_nom",
					valueField:"idioma_cve",
					emptyText: 'Ingresa un idioma',
					data: getItemsfromSelected (".template .idioma_cve_arr option","idioma_cve","idioma_nom"),
					maxSelection: 6,
					selectionPosition:'bottom',
					selectionStacked: true,
					element_extra:[{id:"idioma_cve",type:"hidden",name:"data[IdiomaCan]"},
								   {id:"ic_nivel",type:"select",name:"data[IdiomaCan]", 
										options:getOptionsfromSelect(".template .ic_nivel_arr option") }]
			}));
			ms.addToSelection( getValues(".agregados .idiomas .IdiomaCan"));
				
				/*validacion de idiomas*/

			if($(".agregados .idiomas .no_required").length==0){
				$(".agregados .idiomas form").validate(getValidationOptions());			
					$(".agregados .idiomas form").find("input[id*='ms-input']").attr("name","ms-input").rules("add",{
						magicsugest: ms,					
							messages: {
							magicsugest:  "Selecciona un idioma."
						}});

			}
			


});