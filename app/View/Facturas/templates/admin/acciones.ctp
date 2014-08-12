<div class="btn-actions" data-item-id='{{= it.id }}'>
  {{? it.status.val < 2}}
    <a href='#' class="btn btn-sm btn-success disabled" target="_blank" disabled='disabled'>
      <i class="icon-ok"></i><?php echo __('Activar Servicios'); ?>
    </a>
  {{?? it.status.val === 2 && !it.is_promo }}
    <a href='/admin/facturas/{{= it.folio }}/timbrar' class="btn btn-sm btn-purple" title='Timbrar' data-component='ajaxlink'>
      <i class="icon-bell"></i>Timbrar
    </a>
  {{? }}
  {{? it.is_promo }}
    <a href='#' class="btn btn-sm btn-purple disabled" title='Timbrar' disabled='disabled'>
      <i class="icon-bell"></i>Timbrar
    </a>
  {{? }}
</div>