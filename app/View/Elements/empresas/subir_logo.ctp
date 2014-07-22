<?php
  echo $this->Form->create('Empresa', array(
    'id' => 'subir-logo',
    'class' => 'modal fade',
    'url' => array(
      'controller' => 'uploads'
    )
  ));
?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4><?php echo __('Actualiza tu logotipo'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div id='progress_picture' class='col-xs-12 hide'>
            <div class="progress progress-striped ">
              <div class="bar" style="width: 0%;"></div>
            </div>
          </div>
        </div>
        <div class='row'>
          <div class="col-xs-12">
            <div id="jcrop-panel" class="well">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-sm btn-default regresar" data-dismiss="modal">
          <i class=" icon-arrow-left icon-white "></i>
          <span><?php echo __('Cancelar'); ?></span>
        </a>
        <span class="btn btn-sm btn-info fileinput-button">
          <i class="icon-plus icon-white"></i>
          <span><?php echo __('Agregar Archivo'); ?></span>
          <?php
            if (empty($relatedImg)) {
              $relatedImg = 'img-logo';
            }
          ?>
          <input  id='fileupload' type="file" name="files[]" multiple="" data-related-img='<?php echo $relatedImg; ?>'>
        </span>
        <button type="button" class="btn btn-sm btn-danger" data-role="delete" disabled>
          <i class="icon-trash icon-white"></i>
          <span><?php echo __('Eliminar'); ?></span>
        </button>
        <?php
          $url = !empty($empresa) ? $this->Html->url(array(
            'admin' => $isAdmin,
            'controller' => 'uploads',
            'action' => 'cropimage',
            'id' => $empresa['cia_cve'],
            'slug' => $empresa['cia_nombre'],
          )) : null;

          $attr = $isAdmin && $url ? "data-crop-url=\"$url\"" : '';
        ?>
        <button type="button" class="btn btn-sm btn-success" data-role="save" <?php echo $attr; ?> disabled>
          <i class="icon-upload icon-white"></i>
          <span><?php echo __('Guardar Fotografía'); ?></span>
        </button>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>

<?php
  $this->AssetCompress->addScript(array(
    'vendor/image_upload/vendor/jquery.ui.widget.js',
    'vendor/image_upload/jquery.iframe-transport.js',
    'vendor/image_upload/jquery.fileupload.js',
    'vendor/jquery.Jcrop.min.js',
    'vendor/jquery.color.js',
    'app/upload.js',
    ),
    'uploadPhoto.js'
  );

?>