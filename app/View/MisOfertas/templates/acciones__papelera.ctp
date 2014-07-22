<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href="/mis_ofertas/{{= it.slug }}/recuperar" class="btn btn-sm btn-green" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
    <i class="icon-undo"></i>Recuperar
  </a>
  <a href="/mis_ofertas/{{= it.slug }}/eliminar/<?php echo $authUser['keycode']; ?>" class="btn btn-sm btn-danger" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
    <i class="icon-trash"></i>Eliminar permanentemente
  </a>
</div>