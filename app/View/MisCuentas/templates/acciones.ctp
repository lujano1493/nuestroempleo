<div class="btn-actions">
  <a href="/mis_cuentas/{{= it.slug }}/creditos" class="btn btn-sm btn-green">
    <i class="icon-money"></i>Asignar Cr&eacute;ditos
  </a>
  <a href="/mis_cuentas/{{= it.slug }}/editar" class="btn btn-sm btn-orange">
    <i class="icon-edit"></i>Editar
  </a>
  {{ if (it.id != <?php echo $authUser['cu_cve']; ?>) { }}
    {{? it.status === 1 }}
      <a href="/mis_cuentas/{{= it.slug }}/bloquear" class='btn btn-sm btn-yellow' data-component="ajaxlink">
        <i class="icon-lock"></i>Bloquear
      </a>
    {{?? it.status === 0 }}
      <a href="/mis_cuentas/{{= it.slug }}/activar" class='btn btn-sm btn-success' data-component="ajaxlink">
        <i class="icon-unlock"></i>Activar
      </a>
    {{?? it.status === -1 }}
      <a href="/mis_cuentas/enviar_activacion/{{= it.keycode }}" class='btn btn-sm btn-blue' data-component="ajaxlink">
        <i class="icon-link"></i>Enviar link de Activaci&oacute;n
      </a>
    {{? }}
  {{ } }}
</div>