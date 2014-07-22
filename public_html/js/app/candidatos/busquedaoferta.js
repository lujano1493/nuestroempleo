$(document).ready(function ($){
	"use strict";
		var page=1;

		function empty(ob){
			for(var iter in ob){
				  if  ( ob[iter]!==null && ob[iter]!==''  ) 	return false;
			}
			return true;
		}
		function ocultar_desplegable(type){
				var   param=$("[data-component*='linkconcat']").data("linkconcat").parameter;						
				if( ( type=='page' &&page!==1) || !empty(param) ){				
					$("#desplegables").css("display","none");
						var table=$("#ofertas-table");
						if(table.length ==0 || type!=='page' ){
							return;
						}
						$('html, body').animate({
									      'scrollTop':table.offset().top
									    });
				}
				else{
					$("#desplegables").css("display","block");
				}			

		}
		$(document).on("click",".filtro",function (event){
				 	ocultar_desplegable("click");
				});

		$("#ofertas-table").each(function(){
				var table=$(this);														
				table.on("page",function (event, settings){
					event.preventDefault();
					page = (settings._iDisplayStart / settings._iDisplayLength) + 1;					
					
					ocultar_desplegable("page");
				});
		});
});