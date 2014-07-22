<?php
  echo $this->element('admin/title');
?>
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

          <th data-table-prop="id" data-data-type='numeric'>No.</th>
          <th data-table-prop="#tmpl-nombre">Empresa</th>
          <th data-table-prop="admin.nombre">Contacto</th>
          <th data-table-prop="admin.tel">Télefono</th>
          <th data-table-prop="">Web</th>
          <th data-table-prop="admin.email">Email</th>
          <th data-table-prop="ejecutivo.nombre">Ejecutivo</th>
          <th data-table-prop="#tmpl-fecha-alta">Fecha de Registro</th>
          <th data-table-prop="status.text">Status</th>
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
    'fecha-alta'
  ), null, array(
    'folder' => 'admin'
  ));

?>
