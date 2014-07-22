<div class="btn-actions" data-item-id='{{= it.id }}'>
  {{? it.status.value < 2}}
  <a href='/admin/empresas/{{= it.empresa.slug }}/facturas/{{= it.folio }}' class="btn btn-sm btn-success">
    <i class="icon-ok"></i><?php echo __('Activar Servicios'); ?>
  </a>
  {{? }}
  <a href='#' class="btn btn-sm btn-blue">
    <i class="icon-book"></i>Ver Factura
  </a>
</div>