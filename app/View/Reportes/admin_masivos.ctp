
<?php
echo $this->element('admin/title');

	
  $opciones_masivos = array(
    'masivos_candidato' => 'Estado de Candidatos'
  );

 
?>

<div class="alert alert-info">
  Por favor, selecciones el reporte que desea consultar, una vez realizado
  sube un archivo de texto ó de excel para procesarlo.
</div>

<?php
  echo $this->Form->create(false, array(
    'class' => 'no-lock',
    'id' => 'form-masivo'

  ));
?>
  <h5 class="subtitle">
    <i class="icon-list"></i>
    <?php echo __('Reportes Masivos'); ?> 
  </h5>
  <?=$this->element("admin/ayuda/reporte_masivo" )?>
  <div class="row">
    <div class="col-xs-4">
      <div id="tipo-reportes"  >
        <!-- <h6><?php echo __('Internos'); ?></h6> -->
        <?php
          echo $this->Form->radios('type', $opciones_masivos, array(
            // 'class' => 'input radio',
            'div' => array(
              'style' => 'margin-bottom:8px;'
            )
          ));
        ?>
      </div>
      
    </div>  
    <div class="col-xs-6">     

     
    <div class="input-append file-upload" data-component="tooltip" data-placement="bottom">
        <input type="text" class="info" readonly    >
                  <span class="btn btn-sm btn-primary fileinput-button"   >                 
                    <i class="icon-plus icon-white"></i>
                     <span> Examinar </span>              
                    <!-- The file input field used as target for the file upload widget -->
                       <?php
                          echo $this->Form->input('archivo', array(
                            'id' => "masivo",
                            'class' => 'filestyle',
                            'label' => false,
                            "name" => "files[]",
                            "div" =>false,
                            'type' => 'file'
                          ));    
                        ?>
                  </span>     

                </div>

      
    </div>
    <div class="col-xs-2">
       <button type="submit" class="btn btn-sm btn-success" disabled="disabled">
             <label>Aceptar</label>
       </button>
    </div>
  </div>
 
<?php
  echo $this->Form->input("format" ,array(
    "class" => "type",
    "type" =>"hidden",
    "value" => "txt|xls|xlsx"

    ));

  echo $this->Form->end();
?>
<br><br>
<div id="chartsito"></div>

<?php
  $this->AssetCompress->addScript(array(
  'vendor/image_upload/vendor/jquery.ui.widget.js',
  'vendor/image_upload/jquery.iframe-transport.js',
  'vendor/image_upload/jquery.fileupload.js',
  'vendor/jquery.Jcrop.min.js',
  'vendor/jquery.color.js',               
  'app/admin/masivo.js',
  ), 'archivos_admin.js');
?>