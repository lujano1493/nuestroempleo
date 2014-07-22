<?php
  echo $this->Html->spanLink('Publica una oferta fácil y rápido', array(
    'controller' => 'mis_ofertas',
    'action' => 'nueva'
  ), array(
    'class' => 'btn btn-block btn-default btn-multiline btn-blue',
    'icon' => 'edit icon-2x',
  ));
?>
<?php
  echo $this->Html->spanLink('¡Busca candidatos al instante!', array(
    'controller' => 'candidatos',
    'action' => 'index'
  ), array(
    'class' => 'btn btn-block btn-default btn-multiline btn-purple',
    'icon' => 'search icon-2x'
  ));
?>
<?php
  $url = $this->Acceso->has('mis_eventos') ? '#nuevo-evento' : array(
    'controller' => 'mis_eventos'
  );

  echo $this->Html->spanLink('Publica un evento aquí', $url, array(
    'class' => 'btn btn-block btn-default btn-multiline btn-green',
    'data-toggle' => 'slidemodal',
    'icon' => 'calendar icon-2x'
  ));
?>