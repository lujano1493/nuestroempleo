<?php
  echo $this->Form->create('Carpeta', array(
    'class' => 'modal fade',
    'id' => 'nueva-carpeta',
    //'data-component' => 'ajaxform',
    'url' => array(
      'controller' => 'carpetas',
      'action' => 'nueva'
    ),
    //'style' => 'width:640px;margin-left:-320px'
  ));
?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4>Nueva Carpeta</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-6 col-md-offset-3">
            <?php
              echo $this->Form->input('carpeta_nombre', array(
                'class' => 'form-control input-block-level',
                'label' => 'Nombre de la carpeta',
                'placeholder' => 'Ingresa el nombre de la carpeta'
              ));
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-md-offset-3">
            <?php
              echo $this->Form->input('tipo_cve', array(
                'class' => 'form-control input-block-level',
                //'data-component' => 'sourcito',
                //'data-source-controller' => 'carpetas',
                //'data-source-name' => 'lista',
                //'data-source-autoload' => true,
                'label' => 'Tipo de Carpeta',
                'placeholder' => 'Elige que quieres organizar',
                'options' => array(
                  'Para organizar mis Ofertas',
                  'Para organizar mis Candidatos',
                )
              ));
            ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <?php
            echo $this->Form->submit('Aceptar', array(
              'class' => 'btn btn-default btn-sm btn-success',
              'data-submit' => true,
              'div' => false
            ));
          ?>
      </div>
    </div>
  </div>
<?php
  echo $this->Form->end();
?>