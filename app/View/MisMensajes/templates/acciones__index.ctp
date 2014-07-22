<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href='/mis_mensajes/{{= it.id }}/ver' class="btn btn-xs btn-blue" data-component='ajaxlink' title='Abrir' data-magicload-target='#main-content'>
    <i class="icon-envelope-alt"></i>
  </a>
  <a href='/mis_mensajes/{{= it.id }}/responder' class="btn btn-xs btn-primary" data-component='ajaxlink' title='Responder' data-magicload-target='#main-content'>
    <i class="icon-share-alt"></i>
  </a>
  <a href='/mis_mensajes/{{= it.id }}/borrar' class="btn btn-xs btn-danger" title='Borrar' data-component='tooltip ajaxlink' data-ajaxlink-target="view:menu-mensajes">
    <i class="icon-trash"></i>
  </a>
</div>