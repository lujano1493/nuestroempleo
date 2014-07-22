<?php
  echo $this->element('admin/title');
?>

<div class="btn-actions">
  <?php
    echo $this->Html->link('Nueva Cuenta', array(
      'admin' => $isAdmin,
      'controller' => 'cuentas',
      'action' => 'nueva'
    ), array(
      'class' => 'btn btn-primary',
      'icon' => 'user',
      'data-open-div' => 'new-account-form'
    ));
  ?>
</div>

<div class="row" style="display:none;">
  <div class="cols-xs-12">
    <?php echo $this->element('admin/nueva_cuenta'); ?>
  </div>
  <br><br>
</div>

<table class="table table-bordered" data-table-role="main" data-component="dynamic-table">
  <thead>
    <tr  class="table-header">
      <th colspan="7">
        <div class="pull-left btn-actions">
          <?php
            // echo $this->Html->link(__('Nueva Cuenta'), array(
            //   'controller' => 'mis_cuentas',
            //   'action' => 'nueva'
            // ), array(
            //   'class' => 'btn btn-sm btn-blue',
            //   'icon' => 'folder-close',
            //   'after' => true
            // ));
          ?>
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
      <th data-table-prop="id" data-data-type="numeric">Id</th>
      <th data-table-prop="#tmpl-nombre">Nombre</th>
      <th data-table-prop="email">Sesión</th>
      <th data-table-prop="perfil.desc">Perfil</th>
      <th data-table-prop="registrado">Registro</th>
      <th data-table-prop="status.desc">Status</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones__index' => 'acciones-cuentas'
  ), null, array(
    'folder' => 'admin'
  ));

  $this->AssetCompress->addScript(array(
    'app/empresas/cuentas.js'
  ), 'cuentas.js');
?>