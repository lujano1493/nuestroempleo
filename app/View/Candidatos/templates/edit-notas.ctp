 <?php
  echo $this->Form->create('NotaDenuncia', array(
    'class' => 'edit-nota no-lock',
    'style' => 'display:none;',
    'url' => array(
      'controller' => 'mis_candidatos',
      'action' => 'anotacion',
      'id' => '{{= it.itemId }}',
    )
  ));
?>
  <div class="row">
    <div class="col-xs-12">
      <?php
        echo $this->Form->input('Anotacion.anotacion_cve', array(
          'type' => 'hidden',
          'value' => '{{= it.id }}'
        ));

        echo $this->Form->input('Anotacion.anotacion_detalles', array(
          'class' => 'form-control input-sm input-block-level',
          'label' => 'Detalles',
          'type' => 'textarea',
          'value' => '{{= it.texto }}',
          'rows' => 3
        ));
      ?>
    </div>
  </div>
  <div class="btn-actions">
    <?php
      echo $this->Html->link(__('Editar'), '#', array(
        'class' => 'btn btn-sm btn-success',
        'data-submit' => true,
      ));

      echo $this->Html->link(__('Cancelar'), '#', array(
        'class' => 'cancel-edit btn btn-sm btn-danger'
      ));
    ?>
  </div>
<?php
  echo $this->Form->end();
?>