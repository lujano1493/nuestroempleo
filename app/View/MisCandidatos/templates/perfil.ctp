<h5 class="title-profile">
  <a href="/candidatos/{{= it.slug }}/perfil" data-item-id="{{= it.id}}" data-component='ajaxlink' data-magicload-target='#main-content'>
    {{= it.perfil }}
    <small>{{= it.datos.ubicacion }}</small>
    {{? it.adquirido }}
      <small class="text-danger">Adquirido</small>
    {{? }}
  </a>
</h5>
<a class="actions-link" href="#" data-action-role='open-in-table' data-table-prop='#tmpl-acciones'>Acciones</a>