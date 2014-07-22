

/* config_event inicio*/



$(document).ready(function ($){


	/*eventos para guardar datos*/
	$(document).on ("click",".guardar_actualizacion",function (event){
			event.preventDefault();			
			var $this=$(this),$formito=$this.closest(".formulario"),vista=$formito.attr("data-form"),$form=$formito.find("form");
			var params=undefined;

			if($this.hasClass("multiple") ){
				$formito=$this.closest(".work_area");
				$form=$formito.find(".agregados").find("form");
				vista=$formito.find(".template").find(".formulario").attr("data-form");
				params=$form.serialize();

				
			}


			var request={
				$this:$this,params:params,$div:$formito,url:"../Candidato/guardar_actualizar/"+vista,callback_ok:function (){
				},callback_complete:function (){
					remove_background_wait($formito);
					

				},callback_ok:function (data){

					var $status=$this.closest(".control").find(".status");
					$status.append(create_alert('success',data[0].msg));	

					
					if($this.hasClass("multiple") ){
						data=data[0]["result"];

						var $formitos_=$formito.find(".agregados").find(".formulario");
						$formitos_.each (function (index,element){
							for(var j in data[index][vista]){
								var $input=$(element).find("."+j);
								if( $input.is(":hidden")){
									$input.val(data[index][vista][j] );
								}
							}						
							$(element).addClass("save");
						});

					}
					else{
						$formito.addClass("save");
						var data=data[0]["result"][vista];
						for(index in data){
							var $input=$formito.find("."+index);
							if($input.is (":hidden")){
								$input.val(data[index]);
							}
							
						}

					}
					



				},callback_before:function (){
					create_background_wait($formito);


				}
			};
			ajax_request_(request);



	});

		/*eliminar*/

		/*eventos para guardar datos*/
	$(document).on ("click",".eliminar_registro",function (event){
			event.preventDefault();					
			var $this=$(this),$formito=$this.closest(".formulario");
			var conteo=function (){
				$count_register= $formito.closest(".work_area").find(".count_register");

				var count=parseInt($count_register.val());
				if(!isNaN(count)){
					$count_register.val(--count);
				}


			};
			if(!$formito.hasClass("save")){
				$formito.hide("fade","500",function (){ $(this).empty().remove();  });
				conteo();
				return;
			}


			/* creamo una confirmacion */
			if (!confirm("seguro que desea hacer esta acción")){
				return ;
  			}


			var vista=$formito.attr("data-form"),$form=$formito.find("form");


			var request={
				$this:$this,$div:$formito,valid:false,url:"../Candidato/eleminar_Explab/"+vista,callback_ok:function (){

				},callback_complete:function (){
					remove_background_wait($formito);

				},callback_ok:function (data){
					var $status=$this.closest(".control").find(".status");
					$status.append(create_alert('success',data[0].msg));							
					conteo();

					$this.closest(".bar_tool").hide("fade",800,function (){
							$(this).find(".buttons").empty();
						});

					$formito.hide("fade",500,function (){							
							$(this).empty().remove();							
					});					

				},callback_before:function (){
					create_background_wait($formito);

				}
			};
			ajax_request_(request);



	});





	$(document).on("click",".work_area .add",function(event){
		event.preventDefault();					


		var $this=$(this),$work_area=$this.closest(".work_area");
		var count=parseInt($work_area.find(".count_register").val());
		var data_max=parseInt($work_area.attr("data-max"));
		if(isNaN(count)|| count>=data_max){
				alert("Sólo se pueden agregar "+data_max+" como maximo");		
				return;	
		}

		$work_area.find(".count_register").val(++count);


		var select_=$work_area.attr("data-tamplate"),
			$form_base=$work_area.find(".template").find("."+select_);					


		count=$form_base.find("form").data("count");		
		var $form_new=$form_base.clone(),name_model=$form_new.attr("data-form");


		/*cambiamos el nombre de cada input,select y textarea*/
		$form_new.find("select,input,textarea,div.date-picker").each (function (){
			var name=$(this).attr("name");
			if(name!=null){
				 names=name.split("][");


			    var newname="",i=0;
			    while(i<names.length){
			    	newname+=names[i];			    	
			    	if((i+1)<names.length){
			    		newname+="][";
			    	}
			    	if(names[i]==name_model){
			    		newname+=(count)+"][";
			    		i++;
			    	}			    				  
			    	i++;
			    }
			    $(this).attr("id",newname.replace(/\[|\]|data/gi,"")  );
				$(this).attr("name",newname);    

			}
		});

		$form_base.find("form").data("count",++count);
		$form_new.css("display","none");
		$work_area.find(".agregados").append($form_new);
		$form_new.show("fade",500,function (){
			$(this).find("form").each(function (){ 	
					getConfigValidation("."+select_)(this);	
			 });
		})

	});


});
