<div class="navbar navbar-fixed-top alerts-container">
  <div class="container">
    <?php
      $membresiaName = $authUser['Perfil']['membresia'];
      echo $this->Html->link(__('Membresía %s', $membresiaName), array(
        'controller' => 'mi_espacio',
        'action' => 'index'
      ), array(
        'class' => 'navbar-brand'
      ));
    ?>
    <div class="pull-right">
      <?php echo $this->element('empresas/credits'); ?>
      <?php echo $this->element('empresas/carrito/dropdown_menu'); ?>
      <?php echo $this->element('empresas/notificaciones'); ?>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <?php
            echo $this->Html->link($this->Session->read('Auth.User.fullName'), '#', array(
              'data-toggle' => 'dropdown',
              'icon' => array(
                'after' => 'caret-down'
              )
            ));
          ?>
          <ul class="dropdown-menu pull-right" role="menu">
            <li>
              <?php
                echo $this->Html->link(__('Mi Cuenta'), array(
                  'controller' => 'mi_espacio',
                  'action' => 'mi_cuenta'
                ), array(
                  'icon' => 'user'
                ));
              ?>
            </li>
            <li>
              <?php
                echo $this->Html->link(__('Ayuda'), '/documentos/empresas/usuario_empresas.pdf', array(
                  'icon' => 'question-sign',
                  'target' => '_blank'
                ));
              ?>
            </li>
            <li class="divider"></li>
            <li>
              <?php
                echo $this->Html->link(__('Cerrar Sesión'), '/cerrar_sesion', array(
                  'icon' => 'off'
                ));
              ?>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
  <?php
    if (isset($flash) && $flash === true):
      echo $this->Session->flash();
    endif;
  ?>
</div>