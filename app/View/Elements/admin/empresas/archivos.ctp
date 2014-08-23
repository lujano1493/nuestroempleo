<?php if (empty($onlyList)): ?>
  <div class="alert alert-info">
    Antes de activar el servicio, por favor, verifique que el pago del mismo se haya efectuado.
  </div>
<?php endif ?>
<ul class="list-unstyled" id="list-files">
  <?php foreach ($files as $key => $value): ?>
    <li>
      <?php
        echo $this->Html->link($value, array(
          'admin' => $isAdmin,
          'controller' => 'facturas',
          'action' => 'descargar_comprobante',
          'id' => $factura['factura_folio'],
          $value
        ), array(
          'class' => 'lead',
          'target' => '_blank',
        ));
        echo '&nbsp;&nbsp;';
        echo $this->Html->link(__('Borrar'), array(
          'admin' => $isAdmin,
          'controller' => 'facturas',
          'action' => 'comprobante',
          'id' => $factura['factura_folio'],
          $value
        ), array(
        'class' => 'text-danger',
          'data' => array(
            'component' => 'ajaxlink',
            'ajax-type' => 'DELETE',
            'params' => json_encode(array(
              'empresa_id' => (int)$empresa['Empresa']['cia_cve']
            )),
          )
        ));
      ?>
    </li>
  <?php endforeach ?>
</ul>
<?php if (empty($onlyList)): ?>
  <div>
    <?php
      echo $this->Form->create(false, array(
        'id' => 'formFacturaUpload',
        'url' => array(
          'admin' => $isAdmin,
          'controller' => 'facturas',
          'action' => 'comprobante',
          $factura['factura_folio']
        ),
        'class' => 'row',
      ));
    ?>
      <div class="col-xs-12">
        <div class="form-group">
          <div class="input-group">
            <?php
              echo $this->Form->input('Empresa.cia_cve', array(
                'value' => $empresa['Empresa']['cia_cve'],
                'type' => 'hidden',
              ));

              echo $this->Form->input('facturainfo', array(
                'label' => false,
                'class' => 'form-control input-sm',
                'div' => false,
                'readonly' => true,
              ));
            ?>
            <div class="input-group-btn">
              <span class="btn btn-sm btn-info fileinput-button">
                <i class="icon-plus icon-white"></i>
                <span><?php echo __('Agregar Archivo'); ?></span>
                <input  id='fileupload' type="file" name="files[]" multiple="" data-related-img='img-logo'>
              </span>
              <button type="button" class="btn btn-sm btn-success" data-role="save" disabled>
                <i class="icon-upload icon-white"></i>
                <span><?php echo __('Guardar Archivo'); ?></span>
              </button>
            </div>
          </div>
        </div>
        <div id='progress-file-upload' class='col-xs-12' style="display:none;">
          <div class="progress">
            <div class="progress-bar progress-bar-info progress-bar-striped" style="width: 0%;"></div>
          </div>
        </div>
      </div>
    <?php
      echo $this->Form->end();
    ?>
  </div>
<?php endif ?>
<?php
  $this->AssetCompress->addScript(array(
      'vendor/image_upload/vendor/jquery.ui.widget.js',
      'vendor/image_upload/jquery.iframe-transport.js',
      'vendor/image_upload/jquery.fileupload.js',
      'vendor/jquery.Jcrop.min.js',
      'vendor/jquery.color.js',
      'app/empresas/archivos.js',
    ),
    'archivos.emp.js'
  );
?>