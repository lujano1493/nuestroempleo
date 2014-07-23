<div id="menu" class="sidebar">
  <?php
    echo $this->Html->image($this->Session->read('Auth.User.Empresa.logo'), array(
      'alt' => __('Mi Logotipo'),
      'class' => 'logo img-responsive',
      'style' => 'width:150px;height:100px;margin:auto',
      'id' => 'img-logo'
    ));
    if ($this->Acceso->checkRole('admin')) {
      echo $this->Html->link(__('Cambiar / Subir imagen'), '#subir-logo', array(
        'data-toggle' => 'modal',
        'id' => 'upload-logo'
      ));
    }
  ?>
  <div id="main-tasks">
    <?php
      echo $this->Html->link('', array(
        'controller' => 'mi_espacio',
        'action' => 'index'
      ), array(
        'class' => 'btn btn-default btn-sm',
        'icon' => 'home',
        'data-component' => 'tooltip',
        'title' => __('Inicio')
      ));
      echo $this->Html->link('', '#nueva-carpeta', array(
        'class' => 'btn btn-default btn-sm',
        'icon' => 'folder-open',
        'data-component' => 'tooltip',
        'data-toggle' => 'modal',
        'title' => __('Crear una nueva Carpeta')
      ));
      echo $this->Html->link('', array(
        'controller' => 'mis_mensajes',
        'action' => 'nuevo'
      ), array(
        'class' => 'btn btn-default btn-sm',
        'icon' => 'envelope',
        'data-component' => 'tooltip',
        'title' => __('Crear un nuevo Mensaje')
      ));
      echo $this->Html->link('', array(
        'controller' => 'mi_espacio',
        'action' => 'mi_cuenta'
      ), array(
        'class' => 'btn btn-default btn-sm',
        'icon' => 'cog',
        'data-component' => 'tooltip',
        'data-toggle' => 'modal',
        'title' => __('Mi Cuenta')
      ));
    ?>
  </div>
  <?php
    echo $this->Menu->make(array(
      __('Mis Ofertas') => array(
        'url' => array(
          'controller' => 'mis_ofertas',
          'action' => 'index'
        ),
        'icon' => 'file-text',
        'element' => 'empresas/submenus/ofertas'
      ),
      __('Mis Candidatos') => array(
        'url' => array(
          'controller' => 'mis_candidatos',
          'action' => 'index'
        ),
        'icon' => 'group',
        'element' => 'empresas/submenus/candidatos'
      ),
      __('Mis Mensajes') => array(
        'url' => array(
          'controller' => 'mis_mensajes',
          'action' => 'index'
        ),
        'icon' => 'envelope',
        'element' => 'empresas/submenus/mensajes'
      ),
      __('Mis Evaluaciones') => array(
        'url' => array(
          'controller' => 'mis_evaluaciones',
          'action' => 'index'
        ),
        'icon' => 'pencil',
        // 'element' => 'empresas/submenus/evaluaciones'
      ),
      __('Mis Eventos') => array(
        'url' => array(
          'controller' => 'mis_eventos',
          'action' => 'index'
        ),
        'icon' => 'calendar',
        'element' => 'empresas/submenus/eventos'
      ),
      __('Mis Cuentas') => array(
        'url' => array(
          'controller' => 'mis_cuentas',
          'action' => 'index'
        ),
        'icon' => 'user',
        'element' => 'empresas/submenus/cuentas'
      ),
      __('Mis Productos') => array(
        'url' => array(
          'controller' => 'mis_productos',
          'action' => 'index'
        ),
        'icon' => 'shopping-cart',
        'element' => 'empresas/submenus/productos'
      ),
      __('Mis Reportes') => array(
        'url' => array(
          'controller' => 'mis_reportes',
          'action' => 'index'
        ),
        'icon' => 'bar-chart',
        //'element' => 'empresas/submenus/reportes'
      ),
    ), array(
      'ul' => 'nav nav-list'
    ));
  ?>
  <div class="btn-actions">
    <?php
      echo $this->Html->link(__('Invitar a Candidatos'), array(
        'controller' => 'candidatos',
        'action' => 'invitar'
      ), array(
        'class' => 'btn btn-primary',
        'icon' => array(
          'after' => 'smile'
        )
      ));
    ?>
  </div>
  <?php echo $this->element('empresas/sidebar/contacto'); ?>
</div>