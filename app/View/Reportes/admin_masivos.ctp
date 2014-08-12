
<?php
echo $this->element('admin/title');

	
  $opciones_masivos = array(
    'masivos_candidato' => 'Estado de Candidatos'
  );

 
?>

<div class="alert alert-info">
  Por favor, selecciones el reporte que desea consultar, una vez realizado
  seleccione el archivo a subir.
</div>

<?php
  echo $this->Form->create(false, array(
    'class' => 'no-lock',
    'id' => 'form-masivo'

  ));
?>
  <h5 class="subtitle">
    <i class="icon-list"></i>
    <?php echo __('Reportes de Productos'); ?>
  </h5>
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
    <div class="col-xs-4">     
      <div class="">
        <?php
          echo $this->Form->input('archivo', array(
            'id' => "masivo",
            'class' => 'form-control input-sm input-block-level',
            'label' => false,
            'type' => 'file',
            'required' => true,
            'rule-required' => true,
            'msg-required' => 'Elige un archivo.'
          ));    
        ?>
      </div>
    </div>
  </div>
  <div class="btn-actions">
    <?php
      echo $this->Form->submit(__('Aceptar'), array(
        'class' => 'btn btn-success'      
      ));
    ?>
  </div>
<?php
  echo $this->Form->input("type" ,array(
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