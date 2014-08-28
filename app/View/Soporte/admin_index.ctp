<?php
  echo $this->element('admin/title');
?>

<?php
  echo $this->Form->create(null, array(
    'class' => 'form-inline'
  ));
?>
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-info">
        <?php echo __('Por favor, complete el formulario para enviar su solicitud al área correspondiente.'); ?>
      </div>
    </div>
  </div>
  <fieldset>
    <legend class="subtitle">
      <?php echo __('Datos'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Soporte.asunto', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Asunto'),
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <fieldset>
    <legend class="subtitle">
      <?php echo __('Informe del Problema'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Soporte.descripcion', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Descripción del Problema'),
            'type' => 'textarea'
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <div class="btn-actions">
    <?php
      echo $this->Html->link(__('Aceptar'), '#', array(
        'class' => 'btn btn-success',
        'data-submit' => true,
      ));
    ?>
  </div>
<?php echo $this->Form->end(); ?>
