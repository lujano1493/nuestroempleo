<li class="nota well well-sm">
  <div class="block">
    <i class="icon-edit"></i>
    <div class="text-actions inline pull-right">
      <a href="#">Editar</a>
      <a href="/mis_candidatos/{{= it.candidato }}/borrar_nota/{{= it.id }}" class="text-danger" data-component='ajaxlink'>Borrar</a>
    </div>
  </div>
  <strong>{{= it.usuario.nombre}}</strong>
  <div class="content">
    {{= it.texto }}
  </div>
  <p class="text-right">
    <small>{{= it.created }}</small>
  </p>
</li>