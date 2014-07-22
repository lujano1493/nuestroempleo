<?php
  echo $this->Html->spanLink(__('¡Crea una oferta ahora!'), array(
    'controller' => 'mis_ofertas',
    'action' => 'nueva'
  ), array(
    'class' => 'btn btn-block btn-multiline btn-blue',
    'icon' => 'edit icon-2x'
  ));
?>
<?php
  if ($this->request->params['action'] != 'a_vencer') {
    echo $this->Html->spanLink(__('Ofertas por vencer'), array(
      'controller' => 'mis_ofertas',
      'action' => 'a_vencer'
    ), array(
      'class' => 'btn btn-block btn-multiline btn-yellow',
      'icon' => 'warning-sign icon-2x'
    ));
  } else {
    echo $this->Html->spanLink(__('Ofertas Activas'), array(
      'controller' => 'mis_ofertas',
      'action' => 'activas'
    ), array(
      'class' => 'btn btn-block btn-multiline btn-success',
      'icon' => 'ok icon-2x'
    ));
  }
?>