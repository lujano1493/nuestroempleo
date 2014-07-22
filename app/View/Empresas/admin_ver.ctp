<?php
  echo $this->element('admin/title');
?>

<div class="btn-actions">
  <?php
    echo $this->Html->link('Facturas', array(
      'controller' => 'empresas',
      'action' => 'facturas',
      'id' => $empresa['Empresa']['cia_cve'],
      'admin' => $isAdmin,
    ), array(
      'class' => 'btn btn-default'
    ));
  ?>
  <?php
    echo $this->Html->link('Usuarios', array(
      'controller' => 'empresas',
      'action' => 'usuarios',
      'id' => $empresa['Empresa']['cia_cve'],
      'admin' => $isAdmin,
    ), array(
      'class' => 'btn btn-default'
    ));
  ?>
</div>

<?php
  debug($empresa);
  debug($datosFacturacion);
?>