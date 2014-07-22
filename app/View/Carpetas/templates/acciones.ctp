<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href="#" class="btn btn-xs btn-primary folder-change-name" data-id='{{= it.id }}' title='Cambiar Nombre' data-component='tooltip'>
    <i class="icon-pencil"></i>
  </a>
  <a href='/carpetas/{{= it.slug }}/borrar' class="btn btn-xs btn-danger" title='Borrar' data-component='tooltip ajaxlink'
    data-ajaxlink-target="{{= (it.tipo.value === 0) ? 'view:menu-ofertas' : 'view:menu-candidatos'}}" >
    <i class="icon-trash"></i>
  </a>
</div>