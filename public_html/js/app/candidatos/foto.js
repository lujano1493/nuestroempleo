// JavaScript Document



/*foto.js*/

$(document).on("click",".subir-foto",function (event){
  event.preventDefault();
  $("#actualizar_foto").modal("show");  

});

$(document).on("click",".regresar",function (event){
  event.preventDefault();
  $("#actualizar_foto").modal("hide");  

});

$("#actualizar_foto").on("hidden",function (){
  cargarFoto();
   remove_file({async:true});
});


  $(document).ready(function(e) {
        $(function (){
          var stack_pick=[];
      initialFileUpload();
       /*     $(window).bind('beforeunload', function(event) {
                 event.preventDefault();        
                 remove_file({async:false});
            });*/
      $(document).ready(function($) {

          $(document).on ("click",".delete_picture",function(event){
                        event.preventDefault();        
                        var callback={done:function (delete_url){
                                $(".delete_picture").data("data",null).prop("disabled",true);
                                $(".foto_candidato").hide("fade",500,function (){
                                        $(this).attr("src","").show("fade",500);

                                });

                        

                        }};


              remove_file(callback);

          });       
                   $(document).on ("click",".guardar_foto",function(event){                    
                        event.preventDefault();      

                        var $this=$(this);  
                        $this.prop("disabled",true);
                        var data_info=$this.data("coor");
                        data_info.img_info=$(".delete_picture").data("data");

                                $.ajax(
                                    {type:"POST",data:data_info,url:'/Uploads/cropimage',dataType :"json",
                                    success:function ( data ){
                                            $("#form-editar-foto01").trigger("success.ajaxform",data);
                                            if (data!=undefined && data.file_img!=undefined){
                                               var $panel_foto=template_img(data.file_img);
                                                $("#panel-foto").hide("fade",500,function (){       
                                                        destroy_jcrop();
                                                        $(".delete_picture").prop("disabled",true);
                                                        $(this).append($panel_foto).find(".preview-pane").css("display","none");
                                                        $(this).show("fade",500);
                                                        $(".regresar").trigger("click");

                                                });
                                            }


                                    } });


                         

                    });             

                    $(document).on("hover",".foto_candidato",function ( event ){
                             event.preventDefault();        
                             var $div=$("#modal_actualiza_foto");                                                       
                             $div.modal({ keyboard: false });

                    });

        

      });
        
    });
    });




function initialFileUpload(){
  $(function(){
  
    // Enable iframe cross-domain access via redirect option:
    //$('#fileupload').fileupload();

     $('#fileupload').fileupload({
            dataType: 'json',  
            url: '/Uploads/upload',
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            context: $('#fileupload')[0],
            start: function (e){
                $("#progress_picture").show('fade').addClass("active");


            },
            stop: function (e){
              $("#progress_picture").removeClass("active");

        setTimeout(function (){   
                        $("#progress_picture").hide('fade',500,function (){
                          $(this).find(".bar").css("width","0%");
                        }); },500);

            },

            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $("#progress_picture").find(".progress .bar").css('width',progress + '%');      
            }, 
            send: function (e, data) {
               remove_file();

            },

            done: function (e, data) {
               var result =data.result;
              var src_img=result.files[0].url+"?time="+new Date().getTime();               


                $(".delete_picture").prop({disabled:false  }).data("data",result.files[0]);
                iniciar_jcrop(src_img);


              
          }



        });


    });
  


}

function remove_file(callback){
     var  disabled=$(".delete_picture").prop("disabled");

    if(disabled){
        return;

     }
     if(callback==undefined){      
        callback={async:true};     
     }
    callback.done=(callback.done==undefined)?function (){}:callback.done;

     var  delete_url=$(".delete_picture").data("data").delete_url;

    destroy_jcrop();
    $(".guardar_foto").prop("disabled",true);
    $.ajax({async:callback.async ,url:delete_url,type:"DELETE"}).done(function (){      
                                                callback.done();
                                  } );



}



function destroy_jcrop(){
     JcropAPI = $('#foto_candidato_load').data('Jcrop');
       if(JcropAPI!=null){ 
            JcropAPI.destroy();
        }
    $("#panel-foto").empty();
}

/*presentación final*/
function template_img(src_img){
     return $(
                "<img  id='foto_candidato_edit' class='foto-candidato' src='"+src_img+"?time="+new Date().getTime()+"' border='0' width='100' height='130'  />");

}

function template_panel_img(src_img){

    return $(
                "<img  id='foto_candidato_load' class='foto-candidato' src='"+src_img+"?time="+new Date().getTime()+"'  border='0'/>"
        );
/*
         "<!-- <div id='preview-pane'>"+
                "<div class='preview-container'>" +
                "<img  id='foto_candidato_edit_preview' class='foto_candidato' src='"+src_img+"?time="+new Date().getTime()+"'  border='0'  /> "+
                "</div>"+
            "</div> -->"
*/
}
function iniciar_jcrop(src_img){
    var $panel_foto=template_panel_img(src_img);
        $("#panel-foto").empty().append($panel_foto);
    // Create variables (in this scope) to hold the API and image size
 // var jcrop_api,
  //      boundx,
   //     boundy;

        // Grab some information about the preview pane
        /*$preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container');
        var $pimg = $('#preview-pane .preview-container img');

        $pcnt.width(260).height(300);
        var xsize = $pcnt.width(),ysize = $pcnt.height();*/
    //console.log('init',[xsize,ysize]);
    $('#foto_candidato_load').Jcrop({      
      onChange: updatePreview,
      onSelect: updatePreview,
      onRelease: function (){  $(".guardar_foto").prop("disabled",true); },
      aspectRatio: 0
    },function(){

         var width_=$("#foto_candidato_load").width();
        var height_=$("#foto_candidato_load").height();

        var width=100;
        var height=120;
        var scale=0.4;
      $("#foto_candidato_load").data("Jcrop").setOptions({
        aspectRatio: width/height,
        maxSize:[width_,height_],
        minSize:[width,height ],
        setSelect:[0,0,width,height]


      });
      // Use the API to get the real image size
    /*  var bounds = this.getBounds();
      boundx = bounds[0];
      boundy = bounds[1];
      // Store the API in the jcrop_api variable
      jcrop_api = this;

      // Move the preview into the jcrop container for css positioning
      $preview.appendTo(jcrop_api.ui.holder);*/
    });

    function updatePreview(c)
    {
    $(".guardar_foto").prop("disabled",false);
      if (parseInt(c.w) > 0)
      {
       /* var rx = xsize / c.w;
        var ry = ysize / c.h;*/
        $(".guardar_foto").data("coor",c);

/*
        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });*/
      }
    };

  }