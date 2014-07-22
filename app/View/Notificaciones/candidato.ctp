<div class="container without-space">
  <div class="forma_genral_tit"><h2>Notificaciones</h2></div>
  <div class="tabbable historial-notificaciones" data-component="historialntfy" 
  data-url="<?=$this->Html->url(array("controller" => "notificaciones", "action" => "index"  ))?>" 
  data-role="<?=$role?>"> <!-- Only required for left/right tabs -->
    <?= $this->element("candidatos/notificacion/menu_notificacion"); ?>
    <div class="tab-content">
      <?= $this->element("candidatos/notificacion/tab_panel"); ?>
    </div>
  </div>
</div>

<?php
  echo $this->Template->insert(array(
    'notificacion-historial'
  ), null, array(
    'folder' => 'candidatos'
  ));
?>