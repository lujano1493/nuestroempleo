<p class="title">&Uacute;ltimos <?php echo $this->Html->link('facturas', array(
  'admin' => $isAdmin,
  'controller' => 'facturas',
  'action' => 'index'
)) ?> registrados.</p>
<table class="table table-bordered" data-component="dynamic-table" data-source-url="/admin/facturas/recientes.json">
  <thead>
    <tr  class="table-header">
      <th colspan="7">
        <div class="pull-left btn-actions">
        </div>
        <div class="pull-right" id="filters"></div>
      </th>
    </tr>
    <tr>
      <th data-table-prop=":input"><input type="checkbox" class="master"></th>
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