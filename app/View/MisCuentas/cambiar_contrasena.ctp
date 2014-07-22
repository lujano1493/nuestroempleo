<?php
  echo $this->element('empresas/title');
?>

<ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Volver', array(
        'controller' => 'mis_cuentas',
        'action' => 'index'
      ));
    ?>
  </li>
</ul>

<p class="well well-small info">
  Cambiarás la contraseña del usuario: <strong><?php echo $user['UsuarioEmpresa']['cu_sesion']; ?></strong>.
</p>

<?php echo $this->Form->create(); ?>
  <div class="row-fluid">
    <div class="span6 offset3">
      <?php
        echo $this->Form->input('new_password', array(
          'label' => 'Nueva Contraseña',
          'value' => $new_password
        ));
      ?>
    </div>
    <div class="actions">
      <?php
        echo $this->Form->submit('Aceptar', array(
          'class' => 'btn btn-primary btn-large',
          //'disabled' => true,
          'div' => false
        ));
      ?>
    </div>
  </div>
<?php echo $this->Form->end(); ?>