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
      <div class="col-xs-6">
        <?php
          echo $this->Form->input('Soporte.usuario', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Nombre del Usuario'),
          ));
        ?>
      </div>
      <div class="col-xs-6">
        <?php
          echo $this->Form->input('Soporte.fecha', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Nombre del Puesto'),
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Soporte.perfil', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Perfil'),
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          echo $this->Form->input('Soporte.ubicacion', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => __('Ubicación'),
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
          echo $this->Form->input('Soporte.usuario', array(
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