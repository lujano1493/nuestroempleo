
$(document).ready (function (){

	/*inicializacion de eventos*/

	/*cuando se nfoque en el formulario*/

	$(document).on("focusin",".formulario ",function(){
		var $tool_bar=$(".bar_tool"),$this=$(this);
		var title=$this.attr("title");
		var savebotton=$this.attr("data-save");
		var $bottons= $tool_bar.find(".bottons");
		$bottons.empty();
		if(savebotton!=undefined){

			$bottons.append("<button class='btn btn-success  guardar_actualizacion'> "+savebotton+" "+title+ "</button>");
		}
		var deletebutton=$this.attr("data-delete");
		if(deletebutton!=undefined){
			$bottons.append("<button class='btn btn-danger  eliminar_registro'>  "+deletebutton+" "+title+" </button>");
		}
		$tool_bar.data("formulario",$this);
		$tool_bar.show("fade",500);

	})


		/* evento para toolbar focus, hover */
		var flag_event_toolbar=false;
		$(document).on("mouseenter focusin",".bar_tool .control",function (event){
			event.preventDefault();

			$(this).css({'opacity' : 0.95 });

			if(event.type=="focusin"){
				flag_event_toolbar=true;
			}

		});
		$(document).on("mouseleave focusout",".bar_tool .control",function (event){
			event.preventDefault();			
			if(event.type=="focusout"){
				flag_event_toolbar=false;
			}
			if(!flag_event_toolbar){
				$(this).css({'opacity' : 0.4 });
			}
		});


		/*optener resultado*/





	$(document).on("click",".bar_tool .control .close",function (){
		var $this= $(this);
		$this.closest(".bar_tool").hide("fade",500);
	});



	//config
	var $float_speed=1500; //milliseconds
	var $float_easing="easeOutQuint";
	var $menu_fade_speed=500; //milliseconds
	//cache vars
	var $fl_menu=$(".bar_tool");

	



	$(window).resize(function() {
		$('.bar_tool').css("top","92%");
		menuPosition= getmenuPosition ($fl_menu);
	});

	var menuPosition= getmenuPosition ($fl_menu);
	FloatMenu();

	$(window).scroll(function () { 
		FloatMenu();
	});

	function FloatMenu(){
		var scrollAmount=$(document).scrollTop();
		var newPosition=menuPosition+scrollAmount;
		if($(window).height()<$fl_menu.height()){
			$fl_menu.css("top",menuPosition);
		} else {
			$fl_menu.stop().animate({top: newPosition}, $float_speed, $float_easing);			
		}
	}
	function getmenuPosition ($fl_menu){
		var flag_no_v=false;		
		if (!$fl_menu.is(":visible")){
			$fl_menu.css("display","block");
			flag_no_v=true;
		}	
		var menuPosition=$('.bar_tool').position().top;
		if (flag_no_v){
			$fl_menu.css("display","none");
		}
		return menuPosition;
	}






});

