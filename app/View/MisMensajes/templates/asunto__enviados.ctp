<a href="/mis_mensajes/{{= it.id }}/ver" data-action-role='open-in-table' data-table-prop='#tmpl-contenido'>
  {{= it.asunto }}
  {{? it.importante }}
    <span class="badge badge-important">!</span>
  {{?}}
</a>