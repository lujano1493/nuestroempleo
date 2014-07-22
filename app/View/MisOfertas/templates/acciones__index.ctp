{{
  var actions = [
    {action: 'publicar',   icon: 'ok',            text: 'Publicar'},
    {action: 'recomendar', icon: 'star',          text: 'Recomendar'},
    {action: 'distinguir', icon: 'thumbs-up-alt', text: 'Distinguir'}
  ]
    , status = it.status.value
    , disabled = status === 3
    , btn = !disabled ? actions[status] : actions[status - 1];
}}
<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href='#' class="close" data-table-row-dismiss>&times;</a>
  <div class="btn-group">
    <a class="btn btn-sm btn-success {{= disabled ? 'disabled' : '' }}" href="/mis_ofertas/{{= it.slug }}/{{= btn.action }}" data-component='ajaxlink' data-magicload-target='#main-content'>
      <i class="icon-{{= btn.icon }}"></i>{{= btn.text }}
    </a>
    <button class="btn btn-sm btn-success dropdown-toggle {{= disabled ? 'disabled' : '' }}" data-toggle="dropdown">
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      {{ for (var i = 0, _len = actions.length; i < _len; i++) { }}
        {{ btn = actions[i]; }}
        {{? status <= i }}
          <li>
            <a href="/mis_ofertas/{{= it.slug }}/{{= btn.action }}" data-component='ajaxlink' data-magicload-target='#main-content'>
              <i class="icon-{{= btn.icon }}"></i>{{= btn.text }}
            </a>
          </li>
        {{?}}
      {{ } }}
    </ul>
  </div>
  <a href="/mis_ofertas/{{= it.slug }}/editar" class="btn btn-sm btn-orange">
    <i class="icon-pencil"></i>Editar
  </a>
  <a href="/mis_ofertas/{{= it.slug }}/duplicar" class="btn btn-sm btn-purple">
    <i class="icon-copy"></i>Republicar
  </a>
  {{? !it.es_compartida }}
  <a href="/mis_ofertas/{{= it.slug }}/compartir" class="btn btn-sm btn-aqua" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas" data-ajaxlink-confirm-html='share'>
    <i class="icon-share-sign"></i>Compartir
  </a>
  {{? }}
  <div class="folders-btn inline">
    <a href='#' class="btn btn-sm btn-blue" data-component='folderito' data-source='/carpetas/ofertas.json' data-id="{{= it.id }}" data-controller='mis_ofertas'>
      <i class="icon-folder-open"></i>Guardar en
    </a>
  </div>
  {{? it.status.value > 0 && !it.pausada }}
    <a href="/mis_ofertas/{{= it.slug }}/pausar" class="btn btn-default btn-sm" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
      <i class="icon-pause"></i>Pausar
    </a>
  {{?}}
  {{? it.status.value > 0 && it.pausada }}
    <a href="/mis_ofertas/{{= it.slug }}/reanudar" class="btn btn-default btn-sm" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
      <i class="icon-play"></i>Reanudar
    </a>
  {{?}}
  <a href="/mis_ofertas/{{= it.slug }}/eliminar" class="btn btn-sm btn-danger" data-component=' ajaxlink' data-ajaxlink-target="view:menu-ofertas">
    <i class="icon-trash"></i>Eliminar
  </a>
</div>