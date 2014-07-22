<div class="btn-actions">
  {{? !it.borrador }}
    <a href="/mis_evaluaciones/{{= it.slug}}/asignar" class="btn btn-sm btn-success">
      <i class="icon-pencil"></i>Asignar Evaluación
    </a>
  {{? }}
  <a href="/mis_evaluaciones/{{= it.slug}}/editar" class="btn btn-sm btn-orange">
    <i class="icon-edit"></i>Editar
  </a>
  <a href="/mis_evaluaciones/{{= it.slug}}/eliminar" class="btn btn-sm btn-danger" data-component='ajaxlink'>
    <i class="icon-trash"></i>Eliminar
  </a>
</div>