<div class="navbar navbar-fixed-top navbar-default alerts-container">
  <div class="container">
    <!--logo-->
    <?php
      echo $this->Html->link(__('Administración'), array(
        'admin' => $isAdmin,
        'controller' => 'mi_espacio',
        'action' => 'index'
      ), array(
        'class' => 'navbar-brand'
      ));
    ?>
    <!--header candidatos-->
    <div class="pull-right">
      <?php echo $this->element('admin/notificaciones'); ?>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <?php
            $userName = $this->Session->read('Auth.User.fullName');
            echo $this->Html->link($userName, array(
              //'controller' => 'mi_espacio',
              //'action' => 'mi_cuenta'
            ), array(
              'class' => 'link-icon',
              'icon' => 'user',
              'data-toggle' => 'dropdown',
            ));
          ?>
          <ul class="dropdown-menu pull-right">
            <li>
              <?php
                echo $this->Html->link(__('Mi Cuenta'), array(
                  'admin' => $isAdmin,
                  'controller' => 'mi_espacio',
                  'action' => 'mi_cuenta'
                ), array(
                  'icon' => 'cog',
                ));
              ?>
            </li>
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