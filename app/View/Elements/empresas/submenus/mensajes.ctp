<?php $stats = $this->Session->read('Auth.User.Stats.mensajes.stats'); ?>
<div class="submenu" data-ajaxlink-view="menu-mensajes">
  <ul>
    <li>
      <?php
        echo $this->Menu->link('Nuevo Mensaje', array(
          'controller' => 'mis_mensajes',
          'action' => 'nuevo'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Bandeja de Entrada', array(
          'controller' => 'mis_mensajes',
          'action' => 'index'
        ), array(
          'tags' => array('span', $stats['recibidos'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Mensajes Enviados', array(
          'controller' => 'mis_mensajes',
          'action' => 'enviados'
        ), array(
          'tags' => array('span', $stats['enviados'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Mensajes Importantes', array(
          'controller' => 'mis_mensajes',
          'action' => 'importantes'
        ), array(
          'tags' => array('span', $stats['importantes'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Mensajes Eliminados', array(
          'controller' => 'mis_mensajes',
          'action' => 'eliminados'
        ), array(
          'tags' => array('span', $stats['eliminados'], 'total-items')
        ));
      ?>
    </li>
  </ul>
</div>