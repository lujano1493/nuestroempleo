/*config.js*/
function mayus(field){
	var value=field.value.toUpperCase();
	field.value=value;
}

var meses=[ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];



function  toStringDate(fecha_string){
	if(fecha_string==null || fecha_string==undefined){
		return null;
	}
	var v=fecha_string.split("/");
	if(v.length==1){
		return null;
	}

	return new Date(+v[2],(+v[1])-1,+v[0]);
}
function toDateString(fechin){

		return  fechin.getDate()+"/"+(fechin.getUTCMonth()+1)+"/"+fechin.getFullYear();

}


function parseBool(val)
{
	
	if(val==undefined || val==null){
		return false;
	}
	
    if ((val.toLowerCase() === 'true' || val.toLowerCase() === 'yes'|| val==='1' ) || val === 1)
        return true;
    else 
        return false;
}

		function	getDefaultDatepicker(){

			return { 	
			changeMonth: true,
            changeYear: true,
			numberOfMonths: 1,
			showButtonPanel: false,
			dateFormat:"dd/mm/yy",
			minDate:  "-80y" ,
			maxDate: "+40y" ,
			defaultDate:new Date(1982,5,1),
			yearRange: 'c-30:c+30'
			}	;

		}




function create_calendar_default(input_date){
	  $(function() {
	  	var options=getDefaultDatepicker();		
	  	options["dateFormat"]="dd/mm/yy";	    
	  	options["defaultDate"]=new Date(1992,5,1);
        $(input_date).datepicker(	options);		
		//$(".ui-datepicker").css("font-size","11px");		
    });
	  
	
}


function config_calendar_form(form){
	$(form).find('.date-picker').each(function (){
		var $date_picker=$(this);
		/*configuracion inicial del nuevo formulario :P */
		var default_date_picker=getDefaultDatepicker();
		if($(this).hasClass("date-picker-month-year")){
			var value_ini=false,id_hide="date_picker";
			$(this).find(".hide").each(function (){
				value_ini=toStringDate($(this).val());
				id_hide=$(this).attr("id");
			});
			var month_init=4;
			if($(this).hasClass("date-end")){
				month_init++;
			}
			value_ini=value_ini ? value_ini: new Date();

			var options={
					"defaultDate": value_ini,
					"showButtonPanel":true,
					"currentText":"Mes Actual",			
					"altField":"#"+id_hide+".hide",
					"altFormat":"dd/mm/yy",
					"onChangeMonthYear": function (year,month,inst){
								var date=new Date(year, month-1, 1);
								$date_picker.datepicker('setDate', date);	
								var mes= 2628000000;

								var disabled_input=$date_picker.find(".hide").prop("disabled");
								/*configuracion de la fecha maxima y minima*/
								if($date_picker.hasClass("date-start")){
									var date_min=new Date(date.getTime() ),$_end=$date_picker.closest(".row-fluid").find(".date-end");
									$_end.datepicker("option","minDate",date_min);

									/*verificamos si la fecha fin esta deshabilitada le quitamos el rango a nuestro  calendario de 
									fecha inicio*/
									if($_end.find(".hide").prop("disabled")){
										$date_picker.datepicker("option","maxDate",null);
									}
								}
								else if($date_picker.hasClass("date-end") ){
									var date_max=new Date(date.getTime() );
									$date_picker.closest(".row-fluid").find(".date-start").datepicker("option","maxDate",date_max);
								}
								$date_picker.find(".hide").trigger("change");
								

						}
			};
			$.extend(default_date_picker,options);

		}
		else{
				var ini_v=$date_picker.val();
				if(ini_v!=""){
					var date_ini=toStringDate(ini_v);								
					default_date_picker["defaultDate"]=date_ini;

				}
						

		}
		if($date_picker.hasClass("date-birth")){
			var datef=default_date_picker["defaultDate"];		
			var dif= Math.abs( datef.getFullYear()  - (new Date()).getFullYear());
			//default_date_picker["yearRange"] = 'c-40:c+'+(dif);	
			default_date_picker["maxDate"]= new Date();



		}


		$date_picker.datepicker(default_date_picker);		
		if($date_picker.hasClass("date-picker-month-year") && $date_picker.find(".hide").val() == ""  ){
			$date_picker.find(".hide").val(toDateString(new Date() ));

		}

	});


}

 /* obtener valores para agregar a la lista  apartir de selectores */

 function getValues(select){
		var values=[];
		$(select).each(function (){
			var $this=$(this),entity={}	;
			$(this).find(":hidden").each(function (){
				var data_id=$(this).attr("data-id");
				if(data_id!=undefined){
					entity[data_id]=$(this).val();			
				}	
			});
			values.push(entity);
		});
		return values;
	};

function getOptionsfromSelect(select){
											var options="";
											$(select).each(function (){
									  				options+= "<option value='"+this.value+"'> "+this.text+" </value>";
									  		});
											return options;
										}


/* generar lista de elementos*/

function getItemsfromSelected(select,id,name){
		var values=[];
		$(select).each(function (){
								option={};
								option[id]=this.value;
								option[name]=this.text;
				  				values.push(option);
				  		});
		return values;

}


/*config magic_suggest*/

function getMaggicSuggestOption(){

	return {
		allowFreeEntries: false,	
		required:true,
		useTabKey: true,
		emptyText: 'Ingresa un Área de intéres',
		maxSelection: 3,
		noSuggestionText:"No hay sugerencias",
		 minCharsRenderer: function(v) {
	      return 'Escribe minimo  ' + v + ' caracter'+ ( (v>1 ) ? "es":"") ;
	    },
		maxSelectionRenderer: function(v) {
		return 'Sólo se puede ingresar ' + v + ' elemento'+ ( (v>1 ) ? "s":"") ;
		},
		maxEntryRenderer:function (v){
			return 'Reduce el número de caracteres a '+v;
		}
	};

}
/* ms:magicSuggestm, select: [selector donde se encuentra los datos a cargar]   */

function config_load_magicSuggest(ms,select){

	$(ms).on('load', function(){
			        if(this._dataSet === undefined){
			            this._dataSet = true;
			            var v=getValues(select);
			             ms.addToSelection(v);
			            ms.setDataUrlParams({});
			        }
			    });



}




/*animacion de espera...*/
	
function wait_form($this,loading){

	$this.closest(".control").find("button,input,select").prop( "disabled", loading );
	var $wait=$this.closest(".control").find(".loading");
	if(loading){
		$wait.show("clip",[],500);	
	}
	else{
		$wait.hide("clip",[],500);	
	}

}	

/*ajax_request_
	$this es el boton o elemento donde se llava acabo el evento
	$div es el formulario
	valid si es true se validan los elementos de formulario si es false no realiza validación
	
*/

/*evento para radio button
	paremteros
		options =arraglo de valores que indica cuando se activa el evento
		event_s = tipo de accion
		select = cadena que indica la clase u objeto que se ocultará 
		all_ = indica si se hara la búsqueda en todo el documento o en el form donde se encentra el input que 
		genero el evento  true en todo el documento 
		si no se especifica se buscará entodo el documento
*/


function toggle_radio(options,event_s,select,target_s,all_){
	all_= all_==undefined ? true :all_;

	var $form=$(target_s).closest("form") ;  
	$(document).on(event_s,target_s,function (){
      var $this=$(this);
      var $select=  all_ ?   $(select)  :   $this.closest( "form ").find(select)  ; 
      if($this.val()==options[0] && $this.is(":checked")){
          hide_inputs($select);
         
      }
      else if ($this.val()==options[1] && $this.is(":checked")){
         show_inputs($select);

      }
});

$(target_s).trigger(event_s);

};


/*funcion */
function toggle_(){

	$(document).on("change",".ec_nivel",function (event){
		 var value=$(this).val(),$select=$(this).closest( "form").find(".carreras") ;
		 if(value>2){
		 	show_inputs($select);
		 }
		 else{
		 	hide_inputs($select);
		 }


	});

	$(".ec_nivel").trigger("change");

}


/*habilitar o inhabilitar inputs*/
	function  hide_inputs($select){
		var select_="input,select,textarea";
		if($select.hasClass("hide") ){
			return;
		}
		 $select.addClass("hide").find(select_).filter(" :not(.magicsuggest)"  ). each(function (){
	
		 		
//			console.log(this);	
              if($(this).hasClass("ui-helper-hidden-accessible")){
                    $(this).button({ disabled: true });
              }
                else {

                   $(this).prop("disabled",true);
                }
          });

	}
	function show_inputs($select){
		if(!$select.hasClass("hide")){
			return;
		}
			var select_="input,select,textarea";
		        $select.removeClass("hide").find(select_).each(function (){
                  if($(this).hasClass("ui-helper-hidden-accessible")){
                    $(this).button({ disabled: false });
              }
                else{

                   $(this).prop("disabled",false);
                }
                  });

	}


/*crear mensajes status ajax form*/

function create_alert_ajax($form,type,data){
              var msg=   data.message ? data.message  : "",error=data.error;       


              /*manejo de errores  si debug esta activo*/
              if(error){
              		if(data.debug>0 ){
              			msg="<div>message: "+error.message +"</div>"+
              				"<div>file: "+error.file+"</div>"+
              				"<div>line: "+error.line+"</div>"+
              				" <div>code: "+error.code  +"</div>";
              		}
              		else{
              			msg=error.message;
              		}
              		
              }           
              type =   data.type ? data.type :type;
              type= type=== "ok" ? "success" :type;       
              $form.find(".alert-container").remove();

             var html_msg = $.parseHTML( msg );

               html_msg =   !$(html_msg).is("div") ?  create_alert(type,msg) : html_msg;
              $form.prepend(html_msg);
              $form.find(".alert-container .alert").attr("tabindex","1").focus();


}




/*creacion de un mesaje  de alerta*/

function create_alert(type,message){
	if (type==undefined){
		type="warning"
	}
	var $div=$("<div class='alert-container clearfix'>   <div class='alert alert-"+type+"' fade in>  "+
				 "<a class='close' href='#' data-dismiss='alert'>×</a> "+message+"</div></div>");
	return $div;
}
	


function reset_form(form){
	 var $form=$(form);
	 form.reset(); 
	 $form.find(".message").remove();
	 if($form.hasClass("form-validation")){
	 	$form.validate().resetForm();
	 }
	 $form.find(".error").removeClass("error");
	 $form.find(".alert-container").empty().remove();
}


  function cargarFoto(){ 
        var $foto_img=$(".foto-candidato");
        if($foto_img.length== 0){
          return false;
        }
        $foto_img.attr("src","/img/loading.gif");    
        $.getJSON("/Candidato/loadFoto",function (data){
          var str= data[0];
          $(".foto-candidato").attr("src",data[0]+"?time="+ new Date().getTime());                
        });   
  }

	$(document).ready(function ($){

			// console.log(Modernizr.input);

					/*quitamos eventos para copiar,cortar y pegar*/
		$(document).on("keydown",".no-edit",function (event){			
			    if(event.ctrlKey && (event.which == 67 || event.which== 86 || event.which==88)){ // [x] == 88; [c] == 67; [v] == 86;			     
			        return false;
			        // Manual Copy / Paste / Cut code here.
				}
			}).on("contextmenu",".no-edit",function(event){
				return false;

			});


		 $('form').off('click.sourcito').find("[data-source-name]").one("click.sourcito",function (event){
		 	$(event.target).sourcito("getJSON");
		 });

	});


jQuery.extend({
    compare: function (arrayA, arrayB) {
        if (arrayA.length != arrayB.length) { return false; }
        // sort modifies original array
        // (which are passed by reference to our method!)
        // so clone the arrays before sorting
        var a = jQuery.extend(true, [], arrayA);
        var b = jQuery.extend(true, [], arrayB);
        for (var i = 0, l = a.length; i < l; i++) {
            if (a[i] !== b[i]) { 
                return false;
            }
        }
        return true;
    }
});




