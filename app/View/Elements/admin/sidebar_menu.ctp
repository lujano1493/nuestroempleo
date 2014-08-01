<div id="menu" class="sidebar">
  <?php
    echo $this->Html->image('assets/logo.jpg', array(
      'alt' => __('Mi Logotipo'),
      'class' => 'logo img-responsive',
      'id' => 'img-logo'
    ));
  ?>
  <div class="" style="margin:5px;">
    <p class="">
      <?php echo __('Bienvenido %s', $this->Session->read('Auth.User.fullName')); ?>
    </p>
    <p><?php echo $this->Session->read('Auth.User.Perfil.per_descrip'); ?></p>
    <div class="btn-actions">
      <?php
        echo $this->Html->link(__('Inicio'), array(
          'controller' => 'mi_espacio',
          'action' => 'index',
          'admin' => $isAdmin
        ), array(
          'class' => 'btn btn-default btn-block',
          'icon' => 'home'
        ));
      ?>
    </div>
  </div>
  <?php
    echo $this->Menu->make(array(
      __('Compañias') => array(
        'url' => array(
          'controller' => 'empresas',
          'action' => 'index',
          'admin' => $isAdmin
        ),
        'element' => 'admin/submenus/empresas',
        'icon' => 'briefcase',
        'active_with' => 'convenios'
      ),
      __('Cuentas') => array(
        'url' => array(
          'controller' => 'cuentas',
          'action' => 'index',
          'admin' => $isAdmin
        ),
        'icon' => 'group',
      ),
      __('Productos') => array(
        'url' => array(
          'controller' => 'productos',
          'action' => 'index',
          'admin' => $isAdmin
        ),
        'icon' => 'book'
      ),
      __('Reportes') => array(
        'url' => array(
          'controller' => 'reportes',
          'action' => 'index',
          'admin' => $isAdmin
        ),
        'element' => 'admin/submenus/reporte_internos',
        'icon' => 'bar-chart'
      ),
      __('Denuncias') => array(
        'url' => array(
          'controller' => 'denuncias',
          'action' => 'index',
          'admin' => $isAdmin
        ),
        'icon' => 'warning-sign'
      ),
       __('Redes Sociales') => array(
        'url' => array(
          'controller' => 'sociales',
          'action' => 'ofertas',
          'admin' => $isAdmin
        ),
        'icon' => 'fa fa-facebook'
      )
    ), array(
      'ul' => 'nav nav-list'
    ));
  ?>
  <div class="btn-actions">
    <?php
      echo $this->Html->link(__('Soporte Técnico'), array(
        'admin' => $isAdmin,
        'controller' => 'soporte',
        'action' => 'index'
      ), array(
        'class' => 'btn btn-yellow',
        'icon' => 'wrench'
      ));
    ?>
  </div>
</div>