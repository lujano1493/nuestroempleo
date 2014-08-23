<div class="btn-actions" data-item-id='{{= it.id }}'>
  {{? it.status.val === 1 || it.status.val === 0}}
    <a href='/admin/empresas/{{= it.empresa.slug }}/facturas/{{= it.folio }}' class="btn btn-sm btn-success" target="_blank">
      <i class="icon-ok"></i><?php echo __('Activar Servicios'); ?>
    </a>
  {{?? it.status.val === 2 }}
    <a href='/admin/facturas/{{= it.folio }}/timbrar' class="btn btn-sm btn-purple" title='Timbrar' data-component='ajaxlink'>
      <i class="icon-bell"></i>Timbrar
    </a>
  {{?? it.status.val === 3 || it.status.val === -2 }}
    <a href='/admin/facturas/{{= it.folio}}.xml' class="btn btn-sm btn-green" title='Descargar XML' target="_blank">
      <i class="icon-download"></i>Descargar XML
    </a>
    <a href='/admin/facturas/{{= it.folio}}.pdf' class="btn btn-sm btn-blue" title='Descargar PDF' target="_blank">
      <i class="icon-download"></i>Descargar PDF
    </a>
    {{? it.status.val === 3}}
      <div class="btn-group">
        <a href='/admin/facturas/{{= it.folio }}/cancelar' class="btn btn-sm btn-danger" title='Cancelar' data-component='ajaxlink'>
          <i class="icon-ban-circle"></i>Cancelar
        </a>
        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li>
            <a href='/admin/facturas/{{= it.folio }}/devolucion' class="btn btn-sm" title='Procesar Devolución' data-component='ajaxlink'>
              <i class="icon-remove"></i>Procesar Devolución
            </a>
          </li>
        </ul>
      </div>
    {{? }}
  {{? }}
</div>