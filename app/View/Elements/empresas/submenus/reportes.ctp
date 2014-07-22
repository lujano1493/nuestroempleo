<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link('Ofertas', array(
          'controller' => 'mis_reportes',
          'action' => 'ofertas'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Postulaciones', array(
          'controller' => 'mis_reportes',
          'action' => 'postulaciones'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Otros', array(
          'controller' => 'mis_reportes',
          'action' => 'otros'
        ));
      ?>
    </li>
  </ul>
</div>