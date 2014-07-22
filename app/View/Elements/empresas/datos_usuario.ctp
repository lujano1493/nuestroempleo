<?php
  echo $this->element('empresas/cambiar_contrasena');
  echo $this->Form->create('Usuario', array(
    'class' => 'form-inline no-bordered',
    'novalidate' => true,
    'url' => array(
      'controller' => 'mi_espacio',
      'action' => 'mi_cuenta'
    )
  ));
?>
  <fieldset class="">
    <legend class="subtitle">
      Datos de la Cuenta
    </legend>
    <div class="row">
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Usuario.con_nombre', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Nombre:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Usuario.con_paterno', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Apellido Paterno:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Usuario.con_materno', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Apellido Materno:',
            'placeholder' => ''
          ));
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Usuario.con_ubicacion', array(
            'class' => 'form-control input-sm input-block-level',
            'label' => 'Ubicación:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Usuario.con_tel', array(
            'class' => 'form-control input-sm input-block-level numeric',
            'label' => 'Teléfono:',
            'placeholder' => ''
          ));
        ?>
      </div>
      <div class="col-xs-4">
        <?php
          echo $this->Form->input('Usuario.con_ext', array(
            'class' => 'form-control input-sm input-block-level numeric',
            'label' => 'Extensión:',
            'placeholder' => '',
            'type' => 'number'
          ));
        ?>
      </div>
    </div>
    <div class="btn-actions text-right">
      <?php
        echo $this->Html->link(__('Aceptar'), '#', array(
          'class' => 'btn btn-success',
          'data-submit' => true
        ));
      ?>
    </div>
  </fieldset>
  <fieldset>
    <legend class="subtitle">
      <?php echo __('Cambiar Contraseña'); ?>
    </legend>
    <div class="row">
      <div class="col-xs-12">
        <p>
          Por favor de click en el botón <strong>cambiar contraseña</strong>, ingrese su contraseña actual e indique
          su nueva contraseña, mínimo 8 caracteres y máximo 15, confirme la información y de click en aceptar.
        </p>
        <div class="btn-actions text-right">
          <?php
            echo $this->Html->link('Cambiar contraseña', '#cambiar-contrasena', array(
              'class' => 'btn btn-success',
              'data-toggle' => 'modal'
            ));
          ?>
        </div>
      </div>
    </div>
  </fieldset>
<?php echo $this->Form->end(); ?>