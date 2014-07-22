<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href="/mis_ofertas/{{= it.slug }}/duplicar" class="btn btn-sm btn-purple">
    <i class="icon-copy"></i>Copiar
  </a>
  {{? it.es_propia}}
  <a href="/mis_ofertas/{{= it.slug }}/compartir" class="btn btn-sm btn-danger" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas" data-ajax-type='DELETE' data-ajaxlink-confirm-html='unshare'>
    <i class="icon-trash"></i>Dejar de compartir
  </a>
  {{? }}
</div>