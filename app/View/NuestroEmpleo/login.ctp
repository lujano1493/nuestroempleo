<div class="box form">
  <?php
    echo $this->Session->flash('auth', array(
      'params' => array('class' => 'warning'),
      'element' => 'alert'
    ));
  ?>
  <?php echo $this->Form->create(false, array('class' => 'one-line-inputs no-bordered')); ?>
  <fieldset>
    <legend>Datos de Sesi&oacute;n</legend>
    <div class="row-fluid">
      <div class="span4 offset4 icon-label">
        <?php
          echo $this->Form->input('NuestroEmpleoUsuario.cu_sesion', array(
            'icon' => 'user',
            'placeholder' => 'Nombre de Usuario'
          ));
          echo $this->Form->input('NuestroEmpleoUsuario.cu_pwd', array(
            'icon' => 'key',
            'placeholder' => 'Contraseña'
          ));
        ?>
      </div>
    </div>
  </fieldset>
  <div class="form-actions f-right">
    <div class="center">
    <?php echo $this->Session->flash(); ?>
    </div>
    <?php
      echo $this->Form->submit('Entrar', array( 'class' => 'btn btn-primary btn-large', 'div' => false));
      //echo $this->Html->link('Registrarme como Empresa', array('action' => 'contacto'));
      echo $this->Html->link('Recuperar contraseña', '/recuperar_password');
    ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>