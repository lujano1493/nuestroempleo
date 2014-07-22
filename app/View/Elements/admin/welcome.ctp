<div class="element">
  Hola <?php 
    $name = $this->Session->read('Auth.User.fullName');
    echo $this->Html->link($name, array(
      'admin' => $isAdmin,
      'controller' => 'mi_espacio',
      'action' => 'mi_cuenta'
    ));
  ?>
</div>