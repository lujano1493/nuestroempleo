// JavaScript Document

/**/

$(document).ready(function(e) {
    	$(function (){
				$(document).on("click",'.editar_pasatiempo',function (){
						
						var $this=$(this),$parent=$this.closest(".view_");
						$parent.find(":checkbox").prop("disabled",false);
						
						$this.removeClass("editar_pasatiempo");
						$this.addClass("guardar_pasatiempo");
						$this.text("Guardar");
				});
				$(document).on("click",'.guardar_pasatiempo',function (){
							var $this=$(this),$parent=$this.closest(".view_");
						var info={$form:$parent,callback:function (){
										$parent.find(":checkbox").prop("disabled",true);
										$this.removeClass("guardar_pasatiempo");
										$this.addClass("editar_pasatiempo");
										$this.text("Editar");
							
							
							} };
						guardar_pasatiempo(info);	
						
				});
				
				/*agregamos un bind para redimensionar nuestro campo de trabajo en experiencia laoboral*/
			$("#pasatiempo_").resize(function (){
					var $this=$(this);
					if(!$this.is(":visible")){
						return;
					}
					var height=$this.parent().height();
					$("#forms .slides_control").animate({height: height}, 500);	
			});		
				
				
			
		});
});




function guardar_pasatiempo(info){
			var params="",$form=info.$form;
			info.$form.find("input:checked").each(function (elem,index){
						var $this= $(this);
						params+=$this.attr("name")+"="+$this.val()+"&";
				});
			var $status=$form.find(".status");
			if($status.length==0){
				$form.find(".pasatiempo").append("<div class='row-fluid status' ></div>");
				$status=$form.find(".status");
			}	
			$status.empty().append("<div class='span12 msj' > </div>");
			
		
		$.ajax({
        	type: "POST",
        	url: "../Escolares/guardar_pasatiempo",
			dataType:"json",
       	 	data: params ,
        	success: function(datos) {	
			
					var class_status="";
				if(datos!=null&&datos!=undefined){
						$status.find(".msj").html(datos[0].mensaje);
						class_status=(datos[0].sts=="ok")?"info_ok":"info_error";
						$status.addClass(class_status).show("clip",{},500,function(){
							setTimeout(function (){
							$status.hide("clip",{},500);
							},1000);
							
							
							});
						
				}
				
				
				info.callback();
				
				
      		},
			beforeSend: function(objeto){	
			},
		complete: function(objeto, exito){          				
         		
		
		}
		});		 	
	
	

}