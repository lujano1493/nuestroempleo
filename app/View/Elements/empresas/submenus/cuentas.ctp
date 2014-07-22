<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link('Crear Cuentas', array(
          'controller' => 'mis_cuentas',
          'action' => 'nueva'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Administrar Cuentas', array(
          'controller' => 'mis_cuentas',
          'action' => 'administrar'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Asignación de Créditos', array(
          'controller' => 'mis_cuentas',
          'action' => 'creditos'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Mi Cuenta', array(
          'controller' => 'mi_espacio',
          'action' => 'mi_cuenta'
        ));
      ?>
    </li>
  </ul>
</div>