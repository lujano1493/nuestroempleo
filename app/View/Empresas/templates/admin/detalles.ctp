<div class="" style="padding:15px 20px;">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Costo</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      {{~it.detalles :d:i }}
        <tr>
          <td>{{= d.nombre }}</td>
          <td>{{= d.desc || '' }}</td>
          <td>{{= d.cant }}</td>
          <td>{{= d.costo.text }}</td>
          <td>{{= d.subtotal.text }}</td>
        </tr>
      {{~}}
      <tr>
        <td colspan="4" class="text-right"></td>
        <td>{{= it.total.text }}</td>
      </tr>
    </tbody>
  </table>
  <div class="btn-actions">
    {{? it.status.value === 2 }}
      <a href="#" class="btn btn-success disabled" data-component="ajaxlink" disabled="disabled">
        <i class="icon-ok"></i><?php echo __('Créditos Asignados'); ?>
      </a>
    {{?? }}
      <a href="/admin/empresas/{{= it.empresa.slug }}/facturas/{{= it.folio }}/asignar" class="btn btn-success" data-component="ajaxlink">
        <i class="icon-ok"></i><?php echo __('Activar Servicios'); ?>
      </a>
    {{? }}
  </div>
</div>