<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link(__('Crear Evaluación'), array(
          'controller' => 'mis_evaluaciones',
          'action' => 'nueva'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link(__('Asignar Evaluación'), array(
          'controller' => 'mis_evaluaciones',
          'action' => 'asignar'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link(__('Gestión de Evaluaciones'), array(
          'controller' => 'mis_evaluaciones',
          'action' => 'gestion'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link(__('Todas Mis Evaluaciones'), array(
          'controller' => 'mis_evaluaciones',
          'action' => 'todas'
        ));
      ?>
    </li>
  </ul>
</div>