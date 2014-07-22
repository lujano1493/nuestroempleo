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

<?php 
  //$credits = $this->Session->read('Auth.User.Creditos');
  debug($creditos);
?>
<?php echo $this->Form->create('Creditos'); ?>
  <fieldset>
    <?php 
      $count = 0;
      foreach ($creditos as $value): ?>
      <?php
        /*echo $this->Form->hidden('Creditos.servicio_cve', array(
          'value' => $value['servicio_cve']
        ));*/
        echo $this->Form->input('Creditos.' . $count++ . '.' . $value['identificador'], array(
          'label' => $value['nombre'],
          'type' => 'number',
          'min' => 0,
          'max' => $value['disponibles'],
          'value' => 0
        ));
      ?>
    <?php endforeach ?>
  </fieldset>
  <?php 
    echo $this->Form->submit('Aceptar', array(
      'class' => 'btn btn-primary btn-large',
      //'disabled' => true,
      'div' => false
    ));
  ?>
<?php echo $this->Form->end(); ?>

