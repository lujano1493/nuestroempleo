
$(".change-options").on("click",function (event){
		event.preventDefault();		
		var  $element=$(this), change_option= $element.data("chage-option") ? $element.data("chage-option") :null  ;

		if(!change_option) return;

		var value=$element.val(),options= change_option[value],str_html="";	



		   for (  var key in  options ){
                  str_html+="<option value='"+key+"'> " + options_ex[key]+"</option>";
                }
               

}));

