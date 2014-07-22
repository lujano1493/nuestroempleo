<?php echo $this->Form->create('EmpresaUsuario', 
  array('class' => 'sliding clearfix ajax container bordered one-line-inputs')); 
?>
  <?php echo $this->Session->flash(); ?>
  <fieldset>
    <legend>Datos de la Cuenta</legend>
    <div class="row-fluid">
      <div class="span6">
        <?php 
          echo $this->Form->input('EmpresaUsuarioContacto.con_email', array(
            'icon' => 'envelope',
            'placeholder' => 'Correo Electrónico',
            'required' => true,
            'type' => 'email',
          ));
        ?>
      </div>
      <div class="span6">
        Con este correo, el usuario iniciar&aacute; sesi&oacute;n
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <?php 
          echo $this->Form->input('Perfil.per_cve', array(
            'icon' => 'group',
            'placeholder' => 'Perfil',
            'required' => true,
            'options' => $perfiles
          ));
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span4">
        <?php echo $this->Form->input('EmpresaUsuarioContacto.con_nom', array(
          'icon' => 'user',
          'placeholder' => 'Nombre(s)',
          'required' => true
          ));
        ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('EmpresaUsuarioContacto.con_paterno', array(
          'label' => false,
          'placeholder' => 'Primer Apellido',
          'required' => true
          ));
        ?>
      </div>
      <div class="span4">
        <?php echo $this->Form->input('EmpresaUsuarioContacto.con_materno', array(
          'label' => false,
          'placeholder' => 'Segundo Apellido',
          //'required' => true
          ));
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <?php echo $this->Form->input('EmpresaUsuarioContacto.con_movil', array(
          'icon' => 'phone',
          'placeholder' => 'Teléfono',
          'required' => true
          ));
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?php 
          echo $this->Form->submit('Aceptar', array(
            'class' => 'btn btn-primary btn-large',
            //'disabled' => true,
            'div' => false
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <?php echo $this->Form->end(); ?>
<?php 
  $this->Html->script(array('plugins', 'm/main'), array('inline' => false)); 
?>
