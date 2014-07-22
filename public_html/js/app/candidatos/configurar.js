$(document).ready(function($) {
	loadFoto();


	$(document).on("click",".show_cambiar_pass",function (event){
		event.preventDefault();
		$("#cambia_pass1").modal({ keyboard: false,backdrop:'static' });


	});

	$("#cambia_pass1").on("hidden",function (event){
		event.preventDefault();
		$("#cambia_pass1 form").each(function (){
				this.reset();
		});
	});


	

});