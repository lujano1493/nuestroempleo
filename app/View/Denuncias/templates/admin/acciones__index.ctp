{{
  var buttons = {
      'cv' : {
        'icon': 'user', 'text': 'Ver CV',  link: '/admin/denuncias/' + it.id +'/candidato/' + it.slug + '/'
      },
      'oferta' : {
        'icon': 'book', 'text': 'Ver Oferta', link: '/admin/denuncias/' + it.id + '/oferta/' + it.slug + '/'
      }
    }
    , btn = buttons[it.tipo.val]
    , actions = [
      {text: 'Reportado',   icon: 'ban-circle',       value: 'reportado'},
      {text: 'En Revisión', icon: 'question',         value: 'revision'},
      {text: 'Aceptado',    icon: 'thumbs-up-alt',    value: 'aceptado'},
      {text: 'Declinado',   icon: 'thumbs-down-alt',  value: 'declinado'}
    ]
    , status = it.status.val
    , disabled = status >= 2
    , btnAction = disabled ? actions[status] : actions[status + 1];
}}

<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href='#' class="btn btn-sm btn-success" data-action-role='open-in-table' data-table-prop='#tmpl-detalles-denuncias'>
    <i class="icon-list"></i><?php echo __('Detalles'); ?>
  </a>
  <a href='{{= btn.link }}'  data-component="ajaxlink" data-magicload-target="#main-content"  data-item-id="{{=it.id}}"   class="btn btn-sm btn-yellow">
    <i class="icon-{{= btn.icon }}"></i>{{= btn.text }}
  </a>
  <div class="btn-group">
    <a class="btn btn-sm btn-primary {{= disabled ? 'disabled' : '' }}" href="/admin/denuncias/{{= it.tipo.val + '-' + it.id }}/status/{{= btnAction.value }}" data-component='ajaxlink'  data-after="reloadData">
      <i class="icon-{{= btnAction.icon }}"></i>{{= btnAction.text }}
    </a>
    <button class="btn btn-sm btn-primary dropdown-toggle {{= disabled ? 'disabled' : '' }}" data-toggle="dropdown">
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      {{ for (var i = 1, _len = actions.length; i < _len; i++) { }}
        {{ btnAction = actions[i]; }}
        {{? status < i }}
          <li>
            <a href="/admin/denuncias/{{= it.tipo.val + '-' + it.id }}/status/{{= btnAction.value }}" data-component='ajaxlink' data-after="reloadData">
              <i class="icon-{{= btnAction.icon }}"></i>{{= btnAction.text }}
            </a>
          </li>
        {{?}}
      {{ } }}
    </ul>
  </div>
</div>