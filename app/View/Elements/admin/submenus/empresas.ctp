<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link(__('Convenios'), array(
          'controller' => 'empresas',
          'action' => 'convenios',
          'admin' => $isAdmin,
        ));
      ?>
    </li>
  </ul>
</div>