{{? it.status.value === 1 }}
  <a href="/mis_evaluaciones/{{= it.slug}}/resultados/{{= it.candidato.id}}" target='_blank'>
    Ver resultados
  </a>
{{??}}
  <span>{{= it.status.text }}</span>
{{?}}