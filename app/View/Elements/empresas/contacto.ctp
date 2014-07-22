<?php
  echo $this->Form->create(false, array(
    'url' => array('controller' => 'empresas', 'action' => 'contacto'),
    'class' => 'no-bordered',
    'data-component' => 'elastic-input ajaxform',
    'novalidate' => true
  ));
?>
  <fieldset>
    <?php
      echo $this->Form->input('ContactoForm.nombre', array(
        'label' => false,
        'placeholder' => 'Nombre completo',
        'required' => true,
      ));
      echo $this->Form->input('ContactoForm.email', array(
        'label' => false,
        'placeholder' => 'Correo electrónico',
        'required' => true,
      ));
      echo $this->Form->input('ContactoForm.tel', array(
        'label' => false,
        'placeholder' => 'Teléfono',
        'type' => 'text'
      ));
      echo $this->Form->input('ContactoForm.comentarios', array(
        'label' => false,
        'placeholder' => 'Comentarios',
        'type' => 'textarea'
      ));
      echo $this->Html->image('/uploads/refresh_captcha', array('alt' => 'catpcha'));
      echo $this->Form->input('ContactoForm.captcha', array(
        'label' => false,
        'placeholder' => 'Captura la imagen',
        'required' => true
      ));
    ?>
  </fieldset>
  <?php
    echo $this->Form->submit('Enviar', array(
      'class' => 'btn btn-primary btn-large pull-right',
      'div' => false
    ));
  ?>
<?php echo $this->Form->end(); ?>