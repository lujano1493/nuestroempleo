<?php
  echo $this->element('empresas/title', array(
    'busqueda' => false
  ));
?>
<div class="tabbable historial-notificaciones" data-component="historialntfy" data-role="<?=$role?>">
  <ul class="nav nav-tabs nav-tabs_notificaciones"  style="display:none" >
    <li class="active">
      <a href="#ntfy-history" data-toggle="tab">
        <i class="icon-bell"></i>Notificaciones
      </a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane panel active" id="ntfy-history">
      <div class="content" data-limit="10"></div>
      <div class="btn-actions">
        <a href="/notificaciones" data-target="" class="more-ntfy hide">Ver más</a>
        <?php
          echo $this->Html->link(__('Ver más'), array(
            'controller' => 'notificaciones',
            'action' => 'index'
          ), array(
            'class' => 'btn btn-default more-ntfy',
            'data' => array(
              'target' => ''
            )
          ));
        ?>
      </div>
    </div>
  </div>
</div>
<?php
  echo $this->Template->insert(array(
    'notificacion-historial'
  ), null, array(
    'folder' => 'empresas'
  ));
?>