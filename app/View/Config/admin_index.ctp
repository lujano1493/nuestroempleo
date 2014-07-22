<?php
  echo $this->element('admin/title');
?>

<ul class="nav nav-pills tasks">
  <li>
    <?php
      echo $this->Html->link('Catálogos', array(
        'admin' => $isAdmin,
        'controller' => 'config',
        'action' => 'catalogos'
      ));
    ?>
  </li>
  <li>
    <?php
      echo $this->Html->link('Áreas', array(
        'admin' => $isAdmin,
        'controller' => 'config',
        'action' => 'areas'
      ));
    ?>
  </li>
</ul>


ADMIN_CONFIG