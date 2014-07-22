


$(document).ready(function ($){

	$(document).on("change",".ec_nivel",function (event){
		 var  $this=$(this),value=$this.val(),$form=$this.closest("form"),$car=$form.find(".carreras"),$esp=$form.find(".especialidad");
		 if(value <= 3){

		 	hide_inputs($car);
		 	hide_inputs($esp);
		 	return;
		 }
		 if(value>3 && value <= 8  ){
		 		var $show=$car;
		 		var $hide=$esp ;

		 }
		 else if(value >8 ){
		 	var	$hide=$car ;
		 	var $show=$esp;

		 }
		 show_inputs($show);
		 hide_inputs($hide);


	});



	$(".ec_nivel").trigger("change");


});
