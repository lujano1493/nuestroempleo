<div class="btn-actions" data-item-id='{{= it.id }}'>
  {{? it.status === 1 }}
    <a href='/mis_eventos/{{= it.id }}/editar' class="btn btn-sm btn-primary" data-edit-event="true">
      <i class="icon-edit"></i>Editar
    </a>
    <a href='/mis_eventos/{{= it.id }}/cancelar' class="btn btn-sm btn-yellow" data-component='ajaxlink'>
      <i class="icon-ban-circle"></i>Cancelar Evento
    </a>
  {{?}}
  <a href='/mis_eventos/{{= it.id }}/eliminar' class="btn btn-sm btn-danger" data-component='ajaxlink'>
    <i class="icon-trash"></i>Eliminar
  </a>
</div>