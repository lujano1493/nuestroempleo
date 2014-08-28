<div id='actualizar_foto'   class="modal hide fade " tabindex="-1" role="dialog">
    <div class="modal-header ">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x&nbsp;&nbsp;</button> 
        <h2 style="color:black;">   Actualización de Fotografía</h2>
    </div>
    <div class="alert-container clearfix">
        <div class="alert alert-info fade in popup" data-alert="alert">
            <i class=" icon-info-sign icon-2x"></i>
            Tu fotografía debe  mostrar el rostro de frente, vestimenta apropiada para el puesto, una apariencia seria y responsable. Evita imágenes en reuniones sociales, desenfocadas y con exceso de maquillaje.
        </div>
    </div>
    <div class="formulario modal-body" >
        <form id="form-editar-foto01"  class="center save">           
                 <div class="btn-group">
                    <span class="btn fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Examinar</span>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="fileupload" type="file" name="files[]" multiple="">
                    </span>
                  <button class="btn guardar_foto" disabled><i class="icon-thumbs-up-alt guardar_foto"  ></i>&nbsp;<span>Guardar</span></button>
                  <button class="btn delete_picture" data-url=""  ><i class="icon-remove"  ></i>&nbsp;<span>Eliminar</span></button>
                  <button class="btn regresar"><i class="icon-arrow-left" ></i>&nbsp;<span>Salir</span></button>
                 </div>       
                <br>

                 <!-- The global progress bar -->
          


                    <div id='progress_picture' class=' hide'>
                        <div class="progress progress-striped ">
                            <div class="bar" style="width: 0%;"></div>
                        </div>
                    </div> 
                 
                     <!-- The container for the uploaded files -->
            <div id="files" class="files">
                    <div class="center span12 well">
                       

                        <div id="panel-foto">
                            <div class="text-center">
                                <img id="imgFoto" class="foto-candidato" src="/img/candidatos/default.jpg" border="0"  width="100" height="130" >                          
                            </div>
                        </div>

                       
                      
                    </div>
            </div>
        </form>
    </div>
        
    <div class="modal-footer center" > 
           
    </div>
</div>


<?php 

$this->AssetCompress->addScript(array(
    'vendor/image_upload/jquery.iframe-transport.js',
    'vendor/image_upload/jquery.fileupload.js',
    'vendor/jquery.Jcrop.js',               
    'app/candidatos/foto.js',
    ), 'editarFoto.js');

    ?>

