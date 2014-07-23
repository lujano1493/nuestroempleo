<li class="nota well well-sm">
  <div class="block">
    <i class="icon-edit"></i>
    <div class="text-actions inline pull-right">
      <a href="#" class="edit">Editar</a>
      <a href="/mis_candidatos/Candidato-{{= it.candidato }}/borrar_nota/nota-{{= it.id }}" class="text-danger" data-component='ajaxlink'>Borrar</a>
    </div>
  </div>
  <strong>{{= it.usuario.nombre}}</strong>
  <div class="content">
    {{= it.texto }}
  </div>
  <p class="text-right">
    <small>{{= it.created }}</small>
  </p>
  <?php
    echo $this->Form->input('data', array(
      'class' => 'data',
      'id' => false,
      'data' => array(
        'id' => '{{= it.id }}',
        'texto' => '{{= it.texto }}',
        'item-id' => '{{= it.candidato }}'
      ),
      'type' => 'hidden'
    ));
  ?>
</li>