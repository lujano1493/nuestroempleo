<?php
  echo $this->element('empresas/title');
?>

<table class="table table-bordered" data-table-role="main" data-component="dynamic-table"
  data-source-url="/mis_cuentas/todas.json">
  <thead>
    <tr  class="table-header">
      <th colspan="7">
        <div class="pull-left btn-actions">
          <?php
            echo $this->Html->link(__('Nueva Cuenta'), array(
              'controller' => 'mis_cuentas',
              'action' => 'nueva'
            ), array(
              'class' => 'btn btn-sm btn-blue',
              'icon' => 'folder-close',
              'after' => true
            ));
          ?>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
      <th data-table-prop="#tmpl-nombre">Nombre</th>
      <th data-table-prop="email">Cuenta</th>
      <th data-table-prop="perfil.nombre">Perfil</th>
      <th data-table-prop="#tmpl-status">Status</th>
      <th data-table-prop="created" class="md">Fecha de Creaci&oacute;n</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'status',
    //'creditos',
    'acciones'
  ));
?>