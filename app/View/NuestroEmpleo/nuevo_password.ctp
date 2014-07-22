<div class="box form container">
  <?php if ($authUser) { ?>
  <header>
    <h1 class="title btn-small">Cambiar Contraseña</h1>
    <div class="btn-group right">
      <?php 
      echo $this->Html->link('Perfil', array('controller' => 'users', 'action' => 'perfil'),
        array('class' => 'btn btn-small', 'escape' => false));
      $icon_plus = $this->Html->tag('i', '', array('class' => 'icon-home'));
      echo $this->Html->link($icon_plus . ' Escritorio', array('controller' => 'dashboard', 'action' => 'index'),
        array('class' => 'btn btn-small', 'escape' => false));
        ?>
      </div>
    </header>
  <?php } ?>
  <?php 
    if (isset($userFound) && $userFound === true) {
      echo $this->Form->create('Usuario', array('url' => '/nuevo_password/' . $key,
        'class' => 'form-inline big')); 
  ?>
      <fieldset class="row-fluid">
        <div class="span4 offset4">
          <?php 
            echo $this->Form->input('password', array(
              'icon' => 'key',
              'placeholder' => 'Ingresa tu nueva contraseña'
            ));
            echo $this->Form->input('confirm_password', array(
              'icon' => 'key',
              'placeholder' => 'Repite la contraseña',
              'type' => 'password'
            ));
          ?>
        </div>
      </fieldset>
      <div class="form-actions f-right">

        <?php
          // echo $this->element('alert', array(
          //   'class' => 'alert-info',
          //   'message' => 'Ingresa tu nueva contraseña.'
          // ));
          echo $this->Form->submit('Aceptar', array('class' => 'btn btn-success btn-large', 'div' => false));
        ?>
      </div>
      <?php echo $this->Form->end(); 
    }
  ?>
</div>