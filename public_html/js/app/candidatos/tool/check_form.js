$(document).ready(function ($){

	$("#habilidades01").ajaxform({ validate: function ($form){
				
				var max_checked=$form.data("max-checked") ?$form.data("max-checked") :3 ;
				if($form.find("input:checked").length  > max_checked  ){
					alert("Sólo puedes elegir hasta "+max_checked+" opciones" );
					return false;

				}
				return true;

	}  });



	$("#habilidades01").find(":checkbox").on("change",function (event){
		var $this=$(this),$form=$this.closest('form'),max_checked=$form.data("max-checked");		
		if($form.find(":checked").length>max_checked && $this.is(":checked") ){
			$this.prop("checked",false);

		}
		


	});





});



