<div class="btn-actions" data-item-id='{{= it.id }}'>
  <a href="/admin/cuentas/{{= it.slug }}/editar" class="btn btn-sm btn-orange">
    <i class="icon-edit"></i>Editar
  </a>
  {{ if (it.id != <?php echo $authUser['cu_cve']; ?>) { }}
    {{? it.status.val === 1 }}
      <a href="/admin/cuentas/{{= it.slug }}/bloquear" class='btn btn-sm btn-yellow' data-component="ajaxlink">
        <i class="icon-lock"></i>Bloquear
      </a>
    {{?? it.status.val === 0 }}
      <a href="/admin/cuentas/{{= it.slug }}/activar" class='btn btn-sm btn-success' data-component="ajaxlink">
        <i class="icon-unlock"></i>Activar
      </a>
    {{?? it.status.val === -1 }}
      <a href='/admin/cuentas/enviar_activacion/{{= it.key }}' class="btn btn-sm btn-primary" data-component='ajaxlink'>
        <i class="icon-link"></i><?php echo __('Enviar Activación'); ?>
      </a>
    {{? }}
  {{ } }}
</div>