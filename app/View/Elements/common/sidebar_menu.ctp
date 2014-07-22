<div id="menu" class="sidebar fixed">
  <div id="main-tasks">
    <?php
      echo $this->Html->link('', array(
        'controller' => 'mi_espacio',
        'action' => 'index'
      ), array(
        'class' => 'btn btn-small btn-warning',
        'icon' => 'home'
      ));

      echo $this->Html->link('', array(
        'controller' => 'mis_ofertas',
        'action' => 'nueva'
      ), array(
        'class' => 'btn btn-small btn-success',
        'icon' => 'file-alt'
      ));

      echo $this->Html->link('', array(
        'controller' => 'mis_cuentas',
        'action' => 'index'
      ), array(
        'class' => 'btn btn-small btn-danger',
        'icon' => 'group'
      ));

      echo $this->Html->link('', array(
        'controller' => 'config',
        'action' => 'index'
      ), array(
        'class' => 'btn btn-small btn-primary',
        'icon' => 'cog'
      ));
    ?>
  </div>
  <?php 
    echo $this->Menu->make(array(
      'Mis Ofertas' => array(
        'url' => array(
          'controller' => 'mis_ofertas',
          'action' => 'index'
        ),
        'icon' => 'file-alt',
        'element' => 'empresas/folders_ofertas'
      ),
      'Candidatos' => array(
        'url' => array(
          'controller' => 'candidatos',
          'action' => 'index'
        ),
        'icon' => 'user',
        'element' => 'empresas/folders_candidatos'
      ),
      'Mensajes' => array(
        'url' => array(
          'controller' => 'mis_mensajes',
          'action' => 'index'
        ),
        'icon' => 'comments-alt',
        'element' => 'empresas/folders_mensajes'
      ),
      'Evaluaciones' => array(
        'url' => array(
          'controller' => 'evaluaciones',
          'action' => 'index'
        ),
        'icon' => 'pencil'
      ),
      'Cuentas' => array(
        'url' => array(
          'controller' => 'mis_cuentas',
          'action' => 'index'
        ),
        'icon' => 'group'
      ),
      'Eventos' => array(
        'url' => array(
          'controller' => 'mis_eventos',
          'action' => 'index'
        ),
        'icon' => 'bullhorn'
      )
    ), array(
      'ul' => 'nav nav-list'
    ));
  ?>
  <a href='#' data-collapse>
    <i class="icon-double-angle-left" data-close></i>
    <i class="icon-double-angle-right" data-open></i>
  </a>
</div>