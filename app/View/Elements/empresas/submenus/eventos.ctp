<div class="submenu">
  <ul>
    <li>
      <?php
        echo $this->Menu->link('Publicar Evento', array(
          'controller' => 'mis_eventos',
          'action' => 'publicar'
        ));
      ?>
    </li>
    <li>
      <?php
        echo $this->Menu->link('Todos los Eventos', array(
          'controller' => 'mis_eventos',
          'action' => 'todos'
        ));
      ?>
    </li>
  </ul>
</div>