<div class="">
  <?php
    echo $this->Html->spanLink('Busca Candidatos al instante', array(
      'controller' => 'candidatos',
      'action' => 'index'
    ), array(
      'class' => 'btn btn-block btn-default btn-multiline btn-purple',
      'icon' => 'search icon-2x'
    ));
  ?>
</div>