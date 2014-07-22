{{? !it.borrador }}
  <a href="/mis_evaluaciones/{{= it.slug }}/asignaciones" data-component="ajaxlink" data-magicload-target="#main-content">
    {{= it.asignadas }}
  </a>
{{?? }}
  -
{{? }}