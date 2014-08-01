<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href='/admin/empresas/{{= it.slug }}/editar' class="btn btn-sm btn-primary" title='Editar'>
    <i class="icon-pencil"></i>Editar
  </a>
  {{? it.tipo.val === 'comercial' }}
    <a href='/admin/empresas/{{= it.slug }}/historial' class="btn btn-sm btn-purple" data-item-id="{{= it.id}}" data-component='ajaxlink' data-magicload-target='#main-content'>
      <i class="icon-list"></i>Historial
    </a>
  {{?? }}
    <a href='/admin/convenios/{{= it.slug }}/condiciones' class="btn btn-sm btn-success" target="_blank">
      <i class="icon-list"></i><?php echo __('Condiciones'); ?>
    </a>
    {{? it.status.value === 2 }}
      <a href='/admin/convenios/{{= it.slug }}/finalizar' class="btn btn-sm btn-danger">
        <i class="icon-remove-circle"></i><?php echo __('Finalizar Convenio'); ?>
      </a>
    {{? }}
  {{? }}
  <!-- <a href='#' class="btn btn-sm btn-danger" title='Desactivar'>
    <i class="icon-ban-circle"></i>Desactivar
  </a> -->
</div>