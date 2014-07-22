<div class="btn-actions" data-item-id='{{= it.id }}'>
  {{? it.vigencia != 0 }}
  <a href="/mis_ofertas/{{= it.id }}/reanudar" class="btn btn-sm btn-green" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
    <i class="icon-play"></i>Reanudar
  </a>
  {{?? }}
  <a href="/mis_ofertas/{{= it.id }}/duplicar" class="btn btn-sm btn-purple">
    <i class="icon-copy"></i>Republicar
  </a>
  {{? }}
  <a href="/mis_ofertas/{{= it.slug }}/eliminar" class="btn btn-sm btn-danger" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
    <i class="icon-trash"></i>Eliminar
  </a>
</div>