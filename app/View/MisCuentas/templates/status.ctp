{{? it.status === 1 }}
  <span class="badge badge-success">Activa</span>
{{?? it.status === 0}}
  <span class="badge badge-warning">Bloqueada</span>
{{??}}
  <span class="badge badge-important">Inactiva</span>
{{?}}