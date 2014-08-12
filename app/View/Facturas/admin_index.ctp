<?php
  echo $this->element('admin/title');
?>

<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered" data-component="dynamic-table">
      <thead>
        <tr  class="table-header">
          <th colspan="7">
            <div class="pull-left btn-actions">
            </div>
            <div class="pull-right" id="filters"></div>
          </th>
        </tr>
        <tr>
          <th data-table-prop="#tmpl-folio">Folio</th>
          <th data-table-prop="facturacion.empresa">Empresa</th>
          <th data-table-prop="facturacion.rfc">RFC</th>
          <th data-table-prop="empresa.admin.email">Cuenta</th>
          <th data-table-prop="#tmpl-fecha-creacion" data-order='desc'>Fecha de Alta</th>
          <th data-table-prop="status.str">Status</th>
          <!-- <th data-table-prop="">Registrado por</th> -->
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<?php
echo $this->Template->insert(array(
  'folio',
  'fecha-creacion',
  'acciones' => 'acciones-facturas'
), null, array(
  'folder' => 'admin'
));

?>