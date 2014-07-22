  function checarFormato(value,formatos){
    var data=formatos.split("|");
    return  $.inArray(value,data) > -1 ;

  }
  function appendItemFile(data,$form){
    var id=data.results.id;
    var time=new Date();
    $.getJSON('/Portafolio/elemento/'+id + "?time="+time.getTime(),function (data){
      $form.find(".add-files").append(data.content);    
      $form.find("#file-upload"+id).
        find("[data-component*='ajaxrequest']").ajaxrequest({}).
          show("fade",600,function (){  $(this).removeClass("hide"); });

      if($form.data("max-files") == $form.find(".add-files .file-upload").length  ){
          $form.find(".input-controller").prop("disabled",true);
      }



    });
  
    


  



  }

  function checar_exite($form){
     var tipo=$form.find(".tipo").val();
            if ($form.find(".add-files").find(".archivo"+tipo).length > 0 ){
              alert("¡Ya existe un archivo del mismo tipo!");
              return false;
            }
            return true;

  }


  $(function(){
  
    // Enable iframe cross-domain access via redirect option:
    //$('#fileupload').fileupload();

     $('.fileupload').fileupload({
            dataType: 'json',              
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            url: '/Portafolio/guardar',            
            start: function (e){
                var $form=$(e.target).closest('form');
                $form.find(".progress-barcito").show('fade').addClass("active");
            },
            stop: function (e){

              var $form=$(e.target).closest('form');
              $form.find(".progress-barcito").removeClass("active");

              setTimeout(function (){   
                         $form.find(".progress-barcito").hide('fade',500,function (){
                          $(this).find(".bar").css("width","0%");
                        }); },500);
              $form.find(".info, [name*='docscan_descrip'] " ).val("") ;

            },

            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                 var $form=$(e.target).closest('form');
              $form.find(".progress .bar").css('width',progress + '%');      
            }, 
            send: function (e, data) {

            },

            add: function (e, data) {
                  var start_p= data.files[0].name.lastIndexOf( "." ), type_data=data.files[0].name.substring(start_p+1).toLowerCase();

                  if(start_p < 0 ){
                      alert("¡Verifica la extensión del archivo!");
                      return;
                  }

                  if(checarFormato(type_data, data.form.find(".type").val())){
                    data.form.find(".info").val(data.files[0].name);                      
                    if(!data.form.data("lock")){
                        data.form.find(".save").click(function (event){ 
                        event.preventDefault();                        
                        if(!checar_exite(data.form)){
                          return;
                        }
                        if(data.form.valid()){
                            data.submit();
                        }
                        
                      });
                        data.form.data("lock",true);

                    }                  
                  
                  }                  
                  else{
                      alert("¡Formato de archivo no valido!");                    
                  }
                                    
            },

            done: function (e, data) {                
               var result =data.result;
                appendItemFile(result,$(e.target).closest("form"));              
          }



        });
     

        $(document).on("done-ajax.ajaxrequest",".file-delete",function (event){
          event.preventDefault();          
          var $this=$(this),$form=$this.closest('form');
          $this.closest('.file-upload').remove();
          if($form.find(".add-files .file-upload").length == 0){
            $form.find(".input-controller").prop("disabled",false);
          }

        });

        $("form.guarda_liga").ajaxform({validate:function ($form){
            return checar_exite($form);

        },onSuccess:function (data,obj){
            obj.$form.find("[name*='docscan_nom'], [name*=docscan_descrip]").val("");
        }
            
        }).on("success.ajaxform",function (event,data){              
              appendItemFile(data,$(event.target) );                    
        
        });


    });
  