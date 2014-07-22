<?php
  echo $this->element('empresas/title');
?>

<div>
  <div class="row">
    <div class="col-xs-12">
      <p>
        <?php echo __('Los detalles de su compra fueron enviados al siguiente correo electrónico') ?>
      </p>
      <?php echo $this->Session->read('Auth.User.cu_sesion'); ?>
    </div>
  </div>
  <div class="btn-actions">
    <?php
      echo $this->Html->link('Descargar Reporte', $this->Session->read('App.persistData.url'), array(
        'class' => 'btn btn-lg btn-purple',
        'target' => "_blank",
        'icon' => 'download'
      ));
    ?>
  </div>
</div>