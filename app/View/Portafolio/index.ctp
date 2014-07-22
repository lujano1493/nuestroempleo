
<div class="forma_genral_tit"><h2>Mi Portafolio</h2></div>
  <div class="alert alert-info fade in popup" data-alert="alert">
    <i class="icon-info-sign icon-3x"></i>&nbsp;&nbsp;&nbsp;
     En esta sección, podrás almacenar documentación requerida por los Reclutadores en el proceso de selección como: Comprobante de estudio, Cartas de Recomendación, Comprobante de domicilio, CURP, Acta de nacimiento etc, o simplemente una muestra de tu trabajo. Da clic en examinar y adjunta el archivo.
  </div>      


<div class="row">
  <?= $this->element("candidatos/datos_candidato")?>

  <div class="span9">

      <div class="row-fluid">
        <h4>Recuerda que sólo puedes adjuntar un archivo de cada tipo</h4>
                
    <?
        $layouts=array(
                         array(
                            "label"=>"Dirección Web",
                          "title" => "Si tu documento pesa más de 2 MB inserta la URL.",                        
                          "tipo" => "10"
                          ),
                          array(
                            "label"=>"Imagen",
                          "title" => "Formatos de imagen aceptados: JPG, PNG y  JPEG.",
                          "format" => "jpg|jpeg|png",
                          "tipo" => "1",
                          "default_nom" =>"foto1"
                          ),
                          array(
                          "label"=>"PDF",                        
                          "format" => "pdf",
                          "tipo" => "2",
                          "default_nom" =>"pdf"
                          ),
                           array(
                            "label"=>"Word",
                          "title" => "Inserta extensiones .DOC  y .DOCX",
                          "format" => "doc|docx",
                          "tipo" => "3",
                          "default_nom" =>"documento"
                          )
                        );



    ?>

    <?php foreach ($layouts as $value) :?>

      <?=$this->element("candidatos/portafolio/form_docscan",array("layouts"=>$value ,"documentos" =>$documentos  )) ?>

    <?php endforeach; ?>


      
    </div>

  </div>


</div>
<div class="articulos_interes">
<?php  
  $articulos= ClassRegistry::init("WPPost")->articulos_liga(3);
?>              
          <?php
           foreach ($articulos as $key => $articulo):
           ?>

          <?=$this->element("candidatos/articulo",array("value"=>$articulo,"pull" =>"pull-right",  "span" => "span4" ) ) ?>
          <?php endforeach;?>

</div>
<div class="row">

  <div class="span5 pull-left">
    <img src="/img/publicidad/horizontal_R.Askins.jpg" width="878" height="181" class="img-polaroid">
  </div>
    <div class="span5 pull-right"> 
      <img src="/img/publicidad/horizontal_impresor.jpg" width="878" height="181" class="img-polaroid">
    </div>

</div>
<?php 

$this->AssetCompress->addScript(array(
  'vendor/image_upload/vendor/jquery.ui.widget.js',
  'vendor/image_upload/jquery.iframe-transport.js',
  'vendor/image_upload/jquery.fileupload.js',
  'vendor/jquery.Jcrop.min.js',
  'vendor/jquery.color.js',               
  'app/candidatos/archivos.js',
  ), 'archivos.js');

  ?>

