<?php $stats = $this->Session->read('Auth.User.Stats.ofertas.stats'); ?>
<div class="submenu" data-ajaxlink-view="menu-ofertas">
  <ul>
    <li>
      <?php
        echo $this->Menu->link('Crear Oferta', array(
          'controller' => 'mis_ofertas',
          'action' => 'nueva'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Ofertas Activas', array(
          'controller' => 'mis_ofertas',
          'action' => 'activas'
        ), array(
          'tags' => array('span', $stats['activas'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Ofertas Inactivas', array(
          'controller' => 'mis_ofertas',
          'action' => 'inactivas'
        ), array(
          'tags' => array('span', $stats['inactivas'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Ofertas en Borrador', array(
          'controller' => 'mis_ofertas',
          'action' => 'en_borrador'
        ), array(
          'tags' => array('span', $stats['borrador'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Ofertas Compartidas', array(
          'controller' => 'mis_ofertas',
          'action' => 'compartidas'
        ), array(
          'tags' => array('span', $stats['compartidas'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Ofertas Eliminadas', array(
          'controller' => 'mis_ofertas',
          'action' => 'eliminadas'
        ), array(
          'tags' => array('span', $stats['eliminadas'], 'total-items')
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Carpetas', array(
          'controller' => 'mis_ofertas',
          'action' => 'carpetas'
        ));
      ?>
      <?php
        $folders = $this->Session->read('Auth.User.Stats.ofertas.folders');
        if (!empty($folders)) {
          echo $this->element('common/folder', array(
            'controller' => 'mis_ofertas',
            'children' => $folders
          ));
        }
      ?>
    </li>
  </ul>
</div>