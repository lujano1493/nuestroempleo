<div class="btn-actions" data-item-id="{{= it.id }}">
  {{? !it.adquirido }}
    <a href='/mis_candidatos/{{= it.id}}/comprar' class="btn btn-sm btn-orange" data-component='ajaxlink' data-after='reloadData' data-action-role='buy'>
      <i class="icon-group"></i>Adquirir
    </a>
  {{?}}
  {{? it.adquirido && !it.favorito }}
    <a href='/mis_candidatos/{{= it.id}}/favorito' class="btn btn-sm btn-yellow" data-component='ajaxlink' data-action-role='favorite'>
      <i class="icon-star"></i>Marcar como favorito
    </a>
  {{?}}
  <div class="folders-btn inline">
    <a href='#' class="btn btn-sm btn-aqua" data-component='folderito' data-source='/carpetas/candidatos.json' data-id="{{= it.id }}" data-controller='mis_candidatos'>
      <i class="icon-folder-open"></i>Guardar en
    </a>
  </div>
  {{? it.adquirido }}
    <a href='/mis_mensajes/nuevo?to={{= it.datos.email}}&id={{= it.id}}' class="btn btn-sm btn-blue" data-component='ajaxlink' data-magicload-target='#main-content'>
      <i class="icon-envelope"></i>Enviar Mensaje
    </a>
  {{?}}
</div>