<div class="container">
  <div class="box form">
    <?php
      echo $this->Session->flash('auth', array(
        'params' => array('type' => 'warning'),
        'element' => 'alert'
      ));
    ?>
    <?php echo $this->Form->create(false, array(
      'url' => '/recuperar_password',
      'class' => 'one-line-inputs'
    )); ?>
    <p class="alert alert-info">El sistema enviará un email con las indicaciones para recuperar tu constraseña.</p>
    <fieldset class="row-fluid">
      <div class="span4 offset4">
        <legend>Recuperar Contraseña</legend>
        <?php
          echo $this->Form->input('Usuario.email', array(
            'icon' => 'envelope-alt',
            'placeholder' => 'Escribe tu correo electrónico',
            'type' => 'email'
          ));
        ?>
      </div>
    </fieldset>
    <div class="form-actions f-right">
      <div class="left">
        <?php echo $this->Session->flash(); ?>
      </div>
      <?php
        echo $this->Form->submit('Recuperar', array('class' => 'btn btn-primary btn-large', 'div' => false));
        echo $this->Html->link('Registrarme', '/registrar');
        echo $this->Html->link('Iniciar Sesión', '/iniciar_sesion');
      ?>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>

</div>
