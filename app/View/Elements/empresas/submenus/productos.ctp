<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link(__('Productos Adquiridos'), array(
          'controller' => 'mis_productos',
          'action' => 'adquiridos'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link(__('Tienda en Línea'), array(
          'controller' => 'mis_productos',
          'action' => 'catalogo'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link(__('Carrito de Compras'), array(
          'controller' => 'mis_productos',
          'action' => 'carrito'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link(__('Histórico'), array(
          'controller' => 'mis_productos',
          'action' => 'historico'
        ));
      ?>
    </li>
  </ul>
</div>