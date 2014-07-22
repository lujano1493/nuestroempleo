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
  <a href="/mis_ofertas/{{= it.slug }}/eliminar" class="btn btn-sm btn-danger" data-component='ajaxlink' data-ajaxlink-target="view:menu-ofertas">
    <i class="icon-trash"></i>Eliminar
  </a>
</div>