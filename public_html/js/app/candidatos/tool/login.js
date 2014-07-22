$(document).ready(function($) {
	
	$("#login_form_candidato").validate({
				focusInvalid:true,
				onkeyup:false,
				errorElement: 'div',
				wrapper: "div",
				errorPlacement:function (error,element){
				 	var alert= $(".login_validation_error").find(".alert");
					if(alert.length==0){
					 	$(".login_validation_error").append($("<div class='alert alert-error fade in popup' ></div>"));					 	
					 	alert=$(".login_validation_error").find(".alert");					 
					 	alert.append($("<a class='close' data-dismiss='alert' href='#''>&times;</a> "));
					 	
					}
					alert.append(error);
				},
				showErrors: function(errorMap, errorList){
				  this.defaultShowErrors();			

				},
				invalidHandler: function(event, validator) {					  
			}
	});	
});



