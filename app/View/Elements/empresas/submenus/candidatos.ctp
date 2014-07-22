<?php $stats = $this->Session->read('Auth.User.Stats.candidatos.stats'); ?>
<div class="submenu" data-ajaxlink-view="menu-candidatos">
  <ul>
    <li>
      <?php
        echo $this->Menu->link('Buscar Candidatos', array(
          'controller' => 'candidatos',
          'action' => 'index'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Candidatos Adquiridos', array(
          'controller' => 'mis_candidatos',
          'action' => 'adquiridos'
        ), array(
          'tags' => array('span', $stats['adquiridos'], 'total-items')
        ));
      ?>
    </li>
        <li>
      <?php
        echo $this->Menu->link('Candidatos Favoritos', array(
          'controller' => 'mis_candidatos',
          'action' => 'favoritos'
        ), array(
          'tags' => array('span', $stats['favoritos'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Candidatos en Cartera', array(
          'controller' => 'mis_candidatos',
          'action' => 'cartera'
        ));
        $folders = $this->Session->read('Auth.User.Stats.candidatos.folders');
        if (!empty($folders)) {
          echo $this->element('common/folder', array(
            'controller' => 'mis_candidatos',
            'children' => $folders,
          ));
        }
      ?>
    </li>
  </ul>
</div>