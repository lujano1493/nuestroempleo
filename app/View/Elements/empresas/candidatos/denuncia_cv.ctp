<?php
  echo $this->Form->create('Denuncia', array(
    'class' => 'modal fade',
    'id' => 'denuncia-cv' . (!empty($timestamp) ? ('-' . $timestamp) : ''),
    'url' => array(
      'controller' => 'candidatos',
      'action' => 'denunciar',
      'id' => $id
    ),
    //'style' => 'width:640px;margin-left:-320px'
  ));
?>
  <div class="modal-dialog">
    <div data-alert-before-send>
      <div class="alert alert-warning">
        ¿Estás seguro de denunciar este perfil?
      </div>
    </div>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Denuncia de CV</h4>
      </div>
      <div class="modal-body">

        <div class="alerts-container">
          
        </div>
        <div class="row">
          <fieldset>
            <?php
              echo $this->Form->input('Denuncia.motivo_cve', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Motivo de Reporte',
                'empty' => false,
                'options' => $_listas['motivos']
              ));
            ?>
            <?php
              echo $this->Form->input('Denuncia.detalles', array(
                'class' => 'form-control input-sm input-block-level',
                'label' => 'Detalles',
                'type' => 'textarea'
              ));
            ?>
          </fieldset>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <?php
          echo $this->Html->link(__('Aceptar'), '#', array(
            'class' => 'btn btn-sm btn-success',
            'data-submit' => true,
          ));
        ?>
      </div>
    </div>
  </div>
<?php echo $this->Form->end(); ?>