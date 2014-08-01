<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link(__('Internos'), array(
          'controller' => 'reportes',
          'action' => 'internos',
          'admin' => $isAdmin,
        ));
      ?>
    </li>
  </ul>
</div>