<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link(__('Compartir Eventos'), array(
          'controller' => 'sociales',
          'action' => 'eventos',
          'admin' => $isAdmin,
        ));
      ?>
    </li>
  </ul>
</div>