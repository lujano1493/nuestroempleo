<header id="header" class="clearfix">
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <?php 
          echo $this->element('common/logo', array(
            'section' => 'empresas'
          ));
          echo $this->element('common/search'); 
        ?>
        <ul class="nav pull-right">
          <?php if ($isAuthUser): ?>
            <li><?php echo $this->Html->link('Mi Espacio', '/mi_espacio'); ?></li>
            <li>
              <div class="btn-group">
                <?php
                  echo $this->Html->link('Mi Cuenta', array(
                    'admin' => 0,
                    'controller' => 'mi_espacio',
                    'action' => 'mi_cuenta'
                  ), array(
                    'class' => 'btn'
                  ));
                ?>
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><?php echo $this->Html->link('Cerrar Sesión', '/cerrar_sesion'); ?></li>
                </ul>
              </div>
            </li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </div>
</header>