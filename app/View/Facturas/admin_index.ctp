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
          <th data-table-prop=":input" data-table-order="none"><input type="checkbox" class="master"></th>
          <th data-table-prop="folio">Clave</th>
          <th data-table-prop="facturacion.empresa">Empresa</th>
          <th data-table-prop="facturacion.rfc">RFC</th>
          <th data-table-prop="empresa.admin.email">Cuenta</th>
          <th data-table-prop="fecha_alta.str">Fecha de Alta</th>
          <th data-table-prop="">Registrado por</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>