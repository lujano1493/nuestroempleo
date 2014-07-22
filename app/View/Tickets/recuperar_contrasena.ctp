<box class="form">
  <?php
    echo $this->Form->create(false, array(
      'class' => 'one-line-inputs',
      'data-component' => 'ajaxform'
    ));
  ?>
  <fieldset>
    <legend>Recuperar Contraseña</legend>
    <?php
      echo $this->Form->input('Usuario.email', array(
        'icon'=> 'envelope-alt',
        'placeholder' => 'Escribe tu correo electrónico',
        'required' => true,
        'type' => 'email'
      ));
    ?>
  </fieldset>
  <div class="form-actions">
    <?php
      echo $this->Form->submit('Recuperar', array(
        'class' => 'btn',
        'div' => false
      ));
      echo $this->Html->link('Registrarme', '/');
      echo $this->Html->link('Iniciar Sesión', '/iniciar_sesion');
    ?>
  </div>
  <?php echo $this->Form->end(); ?>
</box>