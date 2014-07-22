{{
  var actions = [
    {text: 'Contactar',             icon: 'phone-sign',      value: 'contactar'},
    {text: 'En Revisión',           icon: 'question',        value: 'revision'},
    {text: 'Cerrado',               icon: 'thumbs-up-alt',   value: 'cerrado'},
    {text: 'Fallido',               icon: 'thumbs-down-alt', value: 'fallido'}
  ]
    , status = it.status.value
    , disabled = status >= 2
    , btn = disabled ? actions[status] : actions[status + 1];
}}
<div class="btn-actions" data-item-id='{{= it.id }}'>
  {{? status != -1 }}
    <div class="btn-group">
      <a class="btn btn-sm btn-primary {{= disabled ? 'disabled' : '' }}" href="/admin/convenios/{{= it.slug }}/status/{{= btn.value }}" data-component='ajaxlink'>
        <i class="icon-{{= btn.icon }}"></i>{{= btn.text }}
      </a>
      <button class="btn btn-sm btn-primary dropdown-toggle {{= disabled ? 'disabled' : '' }}" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        {{ for (var i = 1, _len = actions.length; i < _len; i++) { }}
          {{ btn = actions[i]; }}
          {{? status < i }}
            <li>
              <a href="/admin/convenios/{{= it.slug }}/status/{{= btn.value }}" data-component='ajaxlink'>
                <i class="icon-{{= btn.icon }}"></i>{{= btn.text }}
              </a>
            </li>
          {{?}}
        {{ } }}
      </ul>
    </div>
    <a href='/admin/convenios/{{= it.slug }}/condiciones' class="btn btn-sm btn-success">
      <i class="icon-list"></i><?php echo __('Condiciones'); ?>
    </a>
    {{? it.status.value === 2 }}
      <a href='/admin/convenios/{{= it.slug }}/finalizar' class="btn btn-sm btn-danger">
        <i class="icon-remove-circle"></i><?php echo __('Finalizar Convenio'); ?>
      </a>
    {{? }}
  {{?? }}
    Convenio Finalizado
  {{? }}
</div>