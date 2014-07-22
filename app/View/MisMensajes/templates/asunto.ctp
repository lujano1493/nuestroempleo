<a href="/mis_mensajes/{{= it.id }}/ver" class="msg-subject {{= !it.leido ? 'unread' : '' }}"
  data-action-role='open-in-table' data-table-prop='#tmpl-contenido' data-on-open-row='mark-msg-as-read'>
  {{= it.asunto }}
  {{? it.importante }}
    <span class="badge badge-important">!</span>
  {{?}}
</a>