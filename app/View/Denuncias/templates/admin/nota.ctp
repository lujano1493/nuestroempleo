<li class="nota well well-sm">
  <div class="block">
    <i class="icon-edit"></i>
    <div class="text-actions inline pull-right">
      <a href="#" class="edit ">Editar</a>
      <a href="/admin/denuncias/{{=it.tipo}}-{{= it.id }}/borrar_nota" class="text-danger" data-component='ajaxlink'>Borrar</a>
    </div>
  </div>
  <div class="content">
    {{= it.texto }}
  </div>
  <p class="text-right">
    <small>{{= it.created }}</small>
  </p>

  <input type="hidden" data-id="{{=it.id}}"  data-texto="{{=it.texto}}"  data-denunciaId="{{=it.denunciaId}}" data-tipo="{{=it.tipo}}" class="data"  >    
</li>