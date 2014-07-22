<?php
  echo $this->element('admin/title');
?>

<div class="btn-actions text-right">
  <?php
    echo $this->Html->link('Nueva Empresa', array(
      'admin' => $isAdmin,
      'controller' => 'cuentas',
      'action' => 'nueva'
    ), array(
      'class' => 'btn btn-primary btn-lg',
      'icon' => 'user',
      'data-open-div' => 'new-empresa-form'
    ));
  ?>
</div>

<div class="row" style="display:none;">
  <div class="cols-xs-12">
    <?php echo $this->element('admin/nueva_empresa'); ?>
  </div>
  <br><br>
</div>
<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-component="dynamic-table">
      <thead>
        <tr class='table-header'>
          <th colspan="7">
            <div class="pull-left btn-actions">
            </div>
            <div id="filters" class="pull-right"></div>
          </th>
        </tr>
        <tr>
          <!-- <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th> -->
          <th data-table-prop="id" data-data-type='numeric' data-order='desc'>Clave</th>
          <th data-table-prop="#tmpl-nombre">Nombre</th>
          <!-- <th data-table-prop="rfc">RFC</th> -->
          <th data-table-prop="#tmpl-contacto">Contacto</th>
          <th data-table-prop="ejecutivo.nombre">Ejecutivo</th>
          <th data-table-prop="#tmpl-tipo-compania">Tipo</th>
          <th data-table-prop="#tmpl-fecha-alta">Fecha de Alta</th>
          <!--<th>Fecha de Alta</th>
          <th>Tipo de Memebresia</th>
          <th>Fecha de Vencimiento</th> -->
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'nombre',
    'acciones' => 'acciones-empresas',
    'contacto',
    'tipo-compania',
    'fecha-alta'
  ), null, array(
    'folder' => 'admin'
  ));

  $this->AssetCompress->addScript(array(
    'app/empresas/cuentas.js'
  ), 'cuentas.js');
?>